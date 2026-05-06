<?php

namespace App\Models\Auth;

use App\Core\AbstractModel;
use App\Models\User;

class UserProfile extends AbstractModel
{
    protected string $table = "user_profiles";

    protected string $primaryKey = "id";

    protected array $fillable = [
        "user_id",
        "avatar_path",
        "phone",
        "extension",
        "gender",
        "birth_date",
        "job_title",
        "registration",
        "specialty",
        "bio",
        "city",
        "state",
        "country",
    ];

    protected array $required = [
        "user_id" => "O campo USUÁRIO é obrigatório.",
    ];

    protected bool $timestamps = true;

    protected bool $softDelete = false;

    private const GENDERS = [
        "masculino",
        "feminino",
        "nao_binario",
        "prefiro_nao_informar",
    ];

    public function getId(): int
    {
        return $this->attributes["id"];
    }

    public function setUserId(int $userId): void
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException("O usuário informado é inválido.");
        }

        $this->attributes["user_id"] = $userId;
    }

    public function getUserId(): int
    {
        return $this->attributes["user_id"];
    }

    public function setAvatarPath(?string $avatarPath): void
    {
        $this->attributes["avatar_path"] = $avatarPath;
    }

    public function getAvatarPath(): ?string
    {
        return $this->attributes["avatar_path"] ?? null;
    }

    public function setPhone(?string $phone): void
    {
        if ($phone !== null) {
            $phone = preg_replace('/[^0-9]/', '', trim($phone));

            if (strlen($phone) < 10 || strlen($phone) > 11) {
                throw new \InvalidArgumentException("O telefone deve ter entre 10 e 11 dígitos.");
            }
        }

        $this->attributes["phone"] = $phone;
    }

    public function getPhone(): ?string
    {
        return $this->attributes["phone"] ?? null;
    }

    public function setExtension(?string $extension): void
    {
        if ($extension !== null) {
            $extension = trim($extension);

            if (strlen($extension) > 10) {
                throw new \InvalidArgumentException("O ramal deve ter no máximo 10 caracteres.");
            }
        }

        $this->attributes["extension"] = $extension;
    }

    public function getExtension(): ?string
    {
        return $this->attributes["extension"] ?? null;
    }

    public function setGender(?string $gender): void
    {
        if ($gender !== null && !in_array($gender, self::GENDERS, true)) {
            throw new \InvalidArgumentException("O gênero informado é inválido.");
        }

        $this->attributes["gender"] = $gender;
    }

    public function getGender(): ?string
    {
        return $this->attributes["gender"] ?? null;
    }

    public function setBirthDate(?string $birthDate): void
    {
        if ($birthDate !== null) {
            $date = \DateTimeImmutable::createFromFormat("Y-m-d", $birthDate);

            if (!$date || $date->format("Y-m-d") !== $birthDate) {
                throw new \InvalidArgumentException("A data de nascimento é inválida. Use o formato AAAA-MM-DD.");
            }

            if ($date > new \DateTimeImmutable()) {
                throw new \InvalidArgumentException("A data de nascimento não pode ser uma data futura.");
            }
        }

        $this->attributes["birth_date"] = $birthDate;
    }

    public function getBirthDate(): ?string
    {
        return $this->attributes["birth_date"] ?? null;
    }

    public function setJobTitle(?string $jobTitle): void
    {
        if ($jobTitle !== null) {
            $jobTitle = trim(strip_tags($jobTitle));

            if (strlen($jobTitle) > 100) {
                throw new \InvalidArgumentException("O cargo deve ter no máximo 100 caracteres.");
            }
        }

        $this->attributes["job_title"] = $jobTitle;
    }

    public function getJobTitle(): ?string
    {
        return $this->attributes["job_title"] ?? null;
    }

    public function setRegistration(?string $registration): void
    {
        if ($registration !== null) {
            $registration = trim($registration);

            if (strlen($registration) > 50) {
                throw new \InvalidArgumentException("A matrícula deve ter no máximo 50 caracteres.");
            }
        }

        $this->attributes["registration"] = $registration;
    }

    public function getRegistration(): ?string
    {
        return $this->attributes["registration"] ?? null;
    }

    public function setSpecialty(?string $specialty): void
    {
        if ($specialty !== null) {
            $specialty = trim(strip_tags($specialty));

            if (strlen($specialty) > 100) {
                throw new \InvalidArgumentException("A especialidade deve ter no máximo 100 caracteres.");
            }
        }

        $this->attributes["specialty"] = $specialty;
    }

    public function getSpecialty(): ?string
    {
        return $this->attributes["specialty"] ?? null;
    }

    public function setBio(?string $bio): void
    {
        if ($bio !== null) {
            $bio = trim(strip_tags($bio));

            if (strlen($bio) > 1000) {
                throw new \InvalidArgumentException("A bio deve ter no máximo 1000 caracteres.");
            }
        }

        $this->attributes["bio"] = $bio;
    }

    public function getBio(): ?string
    {
        return $this->attributes["bio"] ?? null;
    }

    public function setCity(?string $city): void
    {
        if ($city !== null) {
            $city = trim(strip_tags($city));

            if (strlen($city) > 100) {
                throw new \InvalidArgumentException("A cidade deve ter no máximo 100 caracteres.");
            }
        }

        $this->attributes["city"] = $city;
    }

    public function getCity(): ?string
    {
        return $this->attributes["city"] ?? null;
    }

    public function setState(?string $state): void
    {
        if ($state !== null) {
            $state = trim(strip_tags($state));

            if (strlen($state) > 100) {
                throw new \InvalidArgumentException("O estado deve ter no máximo 100 caracteres.");
            }
        }

        $this->attributes["state"] = $state;
    }

    public function getState(): ?string
    {
        return $this->attributes["state"] ?? null;
    }

    public function setCountry(?string $country): void
    {
        if ($country !== null) {
            $country = trim(strip_tags($country));

            if (strlen($country) > 100) {
                throw new \InvalidArgumentException("O país deve ter no máximo 100 caracteres.");
            }
        }

        $this->attributes["country"] = $country ?? "Brasil";
    }

    public function getCountry(): ?string
    {
        return $this->attributes["country"] ?? "Brasil";
    }

    public function user(): ?User
    {
        return User::find($this->getUserId());
    }

    public static function findByUser(int $userId): ?static
    {
        return (new static())
            ->where("user_id", "=", $userId)
            ->first();
    }

    public static function createForUser(int $userId): bool
    {
        $profile = new static();

        $profile->fill([
            "user_id" => $userId,
            "country" => "Brasil",
        ]);

        return $profile->save();
    }

    public static function genders(): array
    {
        return self::GENDERS;
    }
}