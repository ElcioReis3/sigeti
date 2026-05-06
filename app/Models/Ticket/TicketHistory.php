<?php

namespace App\Models\Ticket;

use App\Core\AbstractModel;
use App\Models\User;

class TicketHistory extends AbstractModel
{
    protected string $table = "ticket_history";

    protected string $primaryKey = "id";

    protected array $fillable = [
        "ticket_id",
        "changed_by",
        "from_status",
        "to_status",
        "note",
    ];

    protected array $required = [
        "ticket_id" => "O campo CHAMADO é obrigatório.",
        "changed_by" => "O campo USUÁRIO é obrigatório.",
        "to_status" => "O campo STATUS é obrigatório.",
    ];

    protected bool $timestamps = false;

    protected bool $softDelete = false;

    public function getId(): int
    {
        return $this->attributes["id"];
    }

    public function setTicketId(int $ticketId): void
    {
        if ($ticketId <= 0) {
            throw new \InvalidArgumentException("O chamado informado é inválido.");
        }

        $this->attributes["ticket_id"] = $ticketId;
    }

    public function getTicketId(): int
    {
        return $this->attributes["ticket_id"];
    }

    public function setChangedBy(int $userId): void
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException("O usuário informado é inválido.");
        }

        $this->attributes["changed_by"] = $userId;
    }

    public function getChangedBy(): int
    {
        return $this->attributes["changed_by"];
    }

    public function setFromStatus(?string $fromStatus): void
    {
        $this->attributes["from_status"] = $fromStatus;
    }

    public function getFromStatus(): ?string
    {
        return $this->attributes["from_status"] ?? null;
    }

    public function setToStatus(string $toStatus): void
    {
        $toStatus = trim($toStatus);

        if (empty($toStatus)) {
            throw new \InvalidArgumentException("O status de destino não pode ser vazio.");
        }

        $this->attributes["to_status"] = $toStatus;
    }

    public function getToStatus(): string
    {
        return $this->attributes["to_status"];
    }

    public function setNote(?string $note): void
    {
        if ($note !== null) {
            $note = trim(strip_tags($note));

            if (strlen($note) > 255) {
                throw new \InvalidArgumentException("A observação deve ter no máximo 255 caracteres.");
            }
        }

        $this->attributes["note"] = $note;
    }

    public function getNote(): ?string
    {
        return $this->attributes["note"] ?? null;
    }

    public function getChangedAt(): ?string
    {
        return $this->attributes["changed_at"] ?? null;
    }

    public function changedBy(): ?User
    {
        return User::find($this->getChangedBy());
    }

    public static function register(
        int     $ticketId,
        int     $userId,
        ?string $fromStatus,
        string  $toStatus,
        ?string $note = null
    ): bool
    {
        $history = new static();

        $history->fill([
            "ticket_id" => $ticketId,
            "changed_by" => $userId,
            "from_status" => $fromStatus,
            "to_status" => $toStatus,
            "note" => $note,
        ]);

        return $history->save();
    }

    public static function byTicket(int $ticketId): array
    {
        return (new static())
            ->where("ticket_id", "=", $ticketId)
            ->orderBy("changed_at", "ASC")
            ->get();
    }

    public static function recentByUser(int $userId, int $limit = 10): array
    {
        $instance = new static();

        $sql = "SELECT th.*, t.title as ticket_title
                FROM ticket_history th
                INNER JOIN tickets t ON t.id = th.ticket_id
                WHERE th.changed_by = :user_id
                ORDER BY th.changed_at DESC
                LIMIT :limit";

        $statement = $instance->connection->prepare($sql);
        $statement->bindValue(":user_id", $userId, \PDO::PARAM_INT);
        $statement->bindValue(":limit", $limit, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function recentAll(int $limit = 10): array
    {
        $instance = new static();

        $sql = "SELECT th.*, t.title as ticket_title, u.name as changed_by_name
                FROM ticket_history th
                INNER JOIN tickets t ON t.id = th.ticket_id
                INNER JOIN users u ON u.id = th.changed_by
                ORDER BY th.changed_at DESC
                LIMIT :limit";

        $statement = $instance->connection->prepare($sql);
        $statement->bindValue(":limit", $limit, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}