<?php

namespace App\Models;

use App\Core\AbstractModel;
use http\Exception\InvalidArgumentException;

class SchoolUser extends AbstractModel
{
    protected string $table = 'school_users';
    protected string $primaryKey = 'id';

    public const MORNING = 'manha';
    public const AFTERNOON = 'tarde';
    public const FULLDAY = 'integral';
    public const SHIFTS = [
        self::MORNING,
        self::AFTERNOON,
        self::FULLDAY,
    ];

    protected array $fillable = [
        'school_id',
        'user_id',
        'shift',
    ];

    protected array $required = [
        "school_id" => "A escola é obrigatória.",
        "user_id" => "O usuário é obrigatório",
        "shift" => "O turno é obrigatório",
    ];
    protected bool $timestamps = false;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setSchoolId(int $schoolId): void
    {

        if (!$schoolId) {
            throw new InvalidArgumentException("O código é obrigaatório.");
        }

        $this->attributes["school_id"] = $schoolId;
    }

    public function getSchoolId(): ?string
    {
        return $this->attributes["school_id"] ?? null;
    }

    public function setUserId(int $userId): void
    {

        if (!$userId) {
            throw new InvalidArgumentException("O código é obrigaatório.");
        }

        $this->attributes["user_id"] = $userId;
    }

    public function getUserId(): ?string
    {
        return $this->attributes["user_id"];
    }


    public function setShift(?string $shift): void
    {
        $shift = $shift ?? self::FULLDAY;

        if (!in_array($shift, self::SHIFTS)) {
            throw new \InvalidArgumentException("O turno não é válido.");
        };

        $this->attributes["shift"] = $shift;
    }

    public function getShift(): ?string
    {
        return $this->attributes["shift"];
    }

    public function school(): ?School
    {
        return School::find($this->getSchoolId());
    }

    public function user(): ?User
    {
        return User::find($this->getUserId());
    }

    public function findBySchoolAndUser(int $schoolId, int $userId): ?self
    {
        return (new static())->where("school_id", "=", $schoolId)->where("user_id", "=", $userId)->first();
    }

    public static function linksByUser(int $userId): ?array
    {
        return (new static())->where("user_id", "=", $userId)->get();
    }
    public static function validateSchoolUserLinks(array $links):?array
    {
       $errors = [];

       if(empty($links)){
           return [
               "Vincule o professor a pelo menos uma escola."
           ];
       }

       $validSchools = [];

       foreach($links as $link){
           $schoolId = $link["school_id"] ?? 0;

           $existsSchool = School::find((int)$schoolId);
           if(!$existsSchool){
               unset($link);
           }else{
               $validSchools[] = $link;
           }
       }

        $links = $validSchools;

       $shifts = [];

       foreach($links as $link){
           if(!empty($link["shift"])){
               $shifts[] = $link["shift"];
           }
       }

       if(in_array(self::FULLDAY, $shifts, true)){
           $errors[]= " Professor com turno integral não pode conter outras escolas com turnos (MANHÃ e TARDE).";
       }

       $shiftCount = array_count_values($shifts);

       foreach($shiftCount as $shift => $count){
           if($count > 1){
               $value = match ($shift) {
                   self::FULLDAY => "INTEGRAL",
                   self::MORNING =>"MANHÃ",
                   self::AFTERNOON => "TARDE",
               };

               $errors[] =  "O turno {$value} não pode ser usado em mais de uma escola.";
           }
       }

       return $errors;
    }




}