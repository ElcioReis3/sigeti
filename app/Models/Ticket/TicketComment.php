<?php

namespace App\Models\Ticket;

use App\Core\AbstractModel;
use App\Models\User;

class TicketComment extends AbstractModel
{
    protected string $table = 'tickets_comments';

    protected string $primaryKey = 'id';

    protected array $fillable = [
        "ticket_id",
        "user_id",
        "comment",
    ];

    protected array $required = [
        "ticket_id" => "O campo CHAMADO é obrigatório.",
        "user_id" => "O campo USUÁRIO é obrigatório.",
        "comment" => "O campo COMENTÁRIO é obrigatório."
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

    public function getTicketId(): int
    {
        return $this->attributes["ticket_id"];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes["user_id"] = $userId;
    }

    public function getUserId(): ?int
    {
        return $this->attributes["user_id"];
    }

    public function setComment(string $comment): void
    {
        $comment = trim(strip_tags($comment));

        if (strlen($comment) < 20) {
            throw new \InvalidArgumentException("O comentário deve ter pelo menos 20 caracteres.");
        }

        //Novo
        if (strlen($comment) > 1000) {
            throw new \InvalidArgumentException("O comentário deve ter no máximo 1000 caracteres.");
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

    //Novo
    public function validateBusinessRules(array $data): array
    {
        $errors = [];

        if (!empty($data["ticket_id"])) {
            $ticket = Ticket::find((int)$data["ticket_id"]);

            if (!$ticket) {
                $errors[] = "Chamado não encontrado ou não existe.";
                return $errors;
            }

            $blocked = [Ticket::FINISHED, Ticket::ARCHIVED];
            if (in_array($ticket->getStatus(), $blocked, true)) {
                $labels = [
                    Ticket::FINISHED => "Finalizado",
                    Ticket::ARCHIVED => "Arquivado",
                ];

                $label = $labels[$ticket->getStatus()];
                $errors[] = "Não é possível comentar em um chamado com status '{$label}'.";
            }
        }

        if (!empty($data["user_id"])) {

            $user = User::find((int)$data["user_id"]);

            if (!$user) {
                $errors[] = "Usuário não encontrado ou não existe.";
            }
        }

        return $errors;
    }

    public static function commentsByTicketId(int $ticketId): ?array
    {
        return (new TicketComment())->where("ticket_id", "=", $ticketId)->get();
    }
}