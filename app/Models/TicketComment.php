<?php

namespace App\Models\Ticket;

use App\Core\AbstractModel;
use App\Models\User;

class TicketComment extends AbstractModel
{
    protected string $table = 'tickets_comments';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'ticket_id',
        'user_id',
        'comment',
    ];

    protected array $required = [
        "ticket_id" => "Este dado é obrigatório.",
        "user_id" => "Este dado é obrigatório.",
        "comment" => "O campo comentário é obrigatório.",
    ];
    protected bool $timestamps = true;

    protected bool $softDelete = true;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setTicketId(int $ticketId): void
    {
        $this->attributes["ticket_id"] = $ticketId;
    }

    public function getTicketId(): ?string
    {
        return $this->attributes["ticket_id"];
    }

    public function setUserId(int $userId): void
    {

        if (!$userId) {
            throw new \InvalidArgumentException("O código é obrigatório.");
        }

        $this->attributes["user_id"] = $userId;
    }

    public function getUserId(): ?string
    {
        return $this->attributes["user_id"];
    }

    public function setComment(string $comment): void
    {
        $comment = trim(strip_tags($comment));

        if (strlen($comment) < 20) {
            throw new \InvalidArgumentException("O comentário pelo menos 20 caracteres.");
        }

        $this->attributes["comment"] = $comment;
    }

    public function getComment(): string
    {
        return $this->attributes["comment"];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes["created_at"];
    }



    public function ticket(): ?Ticket
    {
        return Ticket::find($this->getTicketId());
    }

    public function user(): ?User
    {
        return User::find($this->getUserId());
    }

    public function validateBusinessRules(array $data): array
    {
        $errors = [];

       $statusInvalid = [
           Ticket::ARCHIVED,
           Ticket::FINISHED
       ];

       $ticket = Ticket::find($data['ticket_id']);


       if(in_array($ticket->getStatus(), $statusInvalid, true)) {
           $errors[] =  "Não é possível realizar o comentário. O comentário está com status finalizado e/ou arquivado. ";
       }

        return $errors;
    }

    public static function commentsByTicketId(Int $ticketId):?array
    {
        return (new static())->where('ticket_id', "=" , $ticketId)
            ->orderBy("created_at" )
            ->get();
    }

}