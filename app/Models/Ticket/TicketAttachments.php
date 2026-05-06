<?php

namespace App\Models\Ticket;

use App\Core\AbstractModel;
use App\Models\User;

class TicketAttachment extends AbstractModel
{
    protected string $table = "ticket_attachments";

    protected string $primaryKey = "id";

    protected array $fillable = [
        "ticket_id",
        "uploaded_by",
        "original_name",
        "stored_name",
        "file_path",
        "mime_type",
        "file_size",
    ];

    protected array $required = [
        "ticket_id" => "O campo CHAMADO é obrigatório.",
        "uploaded_by" => "O campo USUÁRIO é obrigatório.",
        "original_name" => "O campo NOME DO ARQUIVO é obrigatório.",
        "stored_name" => "O campo ARQUIVO SALVO é obrigatório.",
        "file_path" => "O campo CAMINHO é obrigatório.",
        "mime_type" => "O campo TIPO é obrigatório.",
        "file_size" => "O campo TAMANHO é obrigatório.",
    ];

    protected bool $timestamps = false;

    protected bool $softDelete = true;

    private const ALLOWED_MIME_TYPES = [
        "image/jpeg",
        "image/png",
        "image/webp",
        "application/pdf",
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    ];

    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

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

    public function setUploadedBy(int $userId): void
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException("O usuário informado é inválido.");
        }

        $this->attributes["uploaded_by"] = $userId;
    }

    public function getUploadedBy(): int
    {
        return $this->attributes["uploaded_by"];
    }

    public function setOriginalName(string $originalName): void
    {
        $originalName = trim($originalName);

        if (empty($originalName)) {
            throw new \InvalidArgumentException("O nome do arquivo não pode ser vazio.");
        }

        if (strlen($originalName) > 255) {
            throw new \InvalidArgumentException("O nome do arquivo deve ter no máximo 255 caracteres.");
        }

        $this->attributes["original_name"] = $originalName;
    }

    public function getOriginalName(): string
    {
        return $this->attributes["original_name"];
    }

    public function setStoredName(string $storedName): void
    {
        $this->attributes["stored_name"] = trim($storedName);
    }

    public function getStoredName(): string
    {
        return $this->attributes["stored_name"];
    }

    public function setFilePath(string $filePath): void
    {
        $this->attributes["file_path"] = trim($filePath);
    }

    public function getFilePath(): string
    {
        return $this->attributes["file_path"];
    }

    public function setMimeType(string $mimeType): void
    {
        if (!in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
            throw new \InvalidArgumentException("Tipo de arquivo não permitido.");
        }

        $this->attributes["mime_type"] = $mimeType;
    }

    public function getMimeType(): string
    {
        return $this->attributes["mime_type"];
    }

    public function setFileSize(int $fileSize): void
    {
        if ($fileSize <= 0) {
            throw new \InvalidArgumentException("O tamanho do arquivo é inválido.");
        }

        if ($fileSize > self::MAX_FILE_SIZE) {
            throw new \InvalidArgumentException("O arquivo deve ter no máximo 5MB.");
        }

        $this->attributes["file_size"] = $fileSize;
    }

    public function getFileSize(): int
    {
        return $this->attributes["file_size"];
    }

    public function getCreatedAt(): ?string
    {
        return $this->attributes["created_at"] ?? null;
    }

    public function isImage(): bool
    {
        return str_starts_with($this->getMimeType(), "image/");
    }

    public function uploadedBy(): ?User
    {
        return User::find($this->getUploadedBy());
    }

    public static function byTicket(int $ticketId): array
    {
        return (new static())
            ->where("ticket_id", "=", $ticketId)
            ->orderBy("created_at", "ASC")
            ->get();
    }

    public static function existsByTicket(int $ticketId): bool
    {
        return (new static())
                ->where("ticket_id", "=", $ticketId)
                ->count() > 0;
    }

    public static function allowedMimeTypes(): array
    {
        return self::ALLOWED_MIME_TYPES;
    }

    public static function maxFileSize(): int
    {
        return self::MAX_FILE_SIZE;
    }

    public function validateBusinessRules(): array
    {
        $errors = [];

        if (!Ticket::find($this->getTicketId())) {
            $errors[] = "Chamado não encontrado ou não existe.";
        }

        if (!User::find($this->getUploadedBy())) {
            $errors[] = "Usuário não encontrado ou não existe.";
        }

        $count = (new static())
            ->where("ticket_id", "=", $this->getTicketId())
            ->count();

        if ($count >= TICKET_MAX_ATTACHMENTS) {
            $errors[] = "Este chamado já atingiu o limite máximo de 10 anexos.";
        }

        return $errors;
    }
}