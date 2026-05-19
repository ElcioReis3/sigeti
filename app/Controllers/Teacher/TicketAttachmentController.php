<?php

namespace App\Controllers\Teacher;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketAttachment;

class TicketAttachmentController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requirePermission(Permission::ATTACH_FILE_TICKET);
    }

    public function store(?array $data): void
    {
        $ticketId = (int)($data["ticket_id"] ?? 0);

        $this->validateCsrfToken($data, "/professor/chamados/{$ticketId}/comentarios");

        $ticket = Ticket::find($ticketId);

        if (!$ticket) {
            Message::warning("Chamado não encontrado ou não existe.");
            redirect("/professor/chamados");
            return;
        }

        if ($ticket->getOpenedBy() !== Auth::user()->id) {
            Message::warning("Você não tem permissão para anexar arquivos neste chamado.");
            redirect("/professor/chamados");
            return;
        }

        if (empty($_FILES["attachment"]) || $_FILES["attachment"]["error"] !== UPLOAD_ERR_OK) {
            Message::warning("Nenhum arquivo foi enviado ou ocorreu um erro no upload.");
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        $file         = $_FILES["attachment"];
        $originalName = $file["name"];
        $fileSize     = $file["size"];

        $finfo    = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file["tmp_name"]);

        if (!in_array($mimeType, TicketAttachment::allowedMimeTypes(), true)) {
            Message::warning("Tipo de arquivo não permitido. Envie imagens (JPG, PNG, WEBP), PDF ou documentos Word.");
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        if ($fileSize > TicketAttachment::maxFileSize()) {
            Message::warning("O arquivo deve ter no máximo 5MB.");
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        $isImage   = str_starts_with($mimeType, "image/");
        $uploadDir = $isImage
            ? UPLOAD_PATH . "/images/"
            : UPLOAD_PATH . "/docs/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $rawExtension = pathinfo($originalName, PATHINFO_EXTENSION);
        $extension    = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $rawExtension));
        $storedName   = bin2hex(random_bytes(16)) . "." . $extension;
        $filePath     = $uploadDir . $storedName;

        if (!move_uploaded_file($file["tmp_name"], $filePath)) {
            Message::error("Não foi possível salvar o arquivo. Tente novamente.");
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        $attachment = new TicketAttachment();

        try {
            $attachment->fill([
                "ticket_id"     => $ticketId,
                "uploaded_by"   => Auth::user()->id,
                "original_name" => $originalName,
                "stored_name"   => $storedName,
                "file_path"     => $filePath,
                "mime_type"     => $mimeType,
                "file_size"     => $fileSize,
            ]);

            $errors = array_merge(
                $attachment->validate([
                    "ticket_id"     => $ticketId,
                    "uploaded_by"   => Auth::user()->id,
                    "original_name" => $originalName,
                    "stored_name"   => $storedName,
                    "file_path"     => $filePath,
                    "mime_type"     => $mimeType,
                    "file_size"     => $fileSize,
                ]),
                $attachment->validateBusinessRules()
            );

            if ($errors) {
                unlink($filePath);
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/professor/chamados/{$ticketId}/comentarios");
                return;
            }

            $attachment->save();

        } catch (\InvalidArgumentException $e) {
            unlink($filePath);
            Message::error($e->getMessage());
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        Message::success("Anexo enviado com sucesso.");
        redirect("/professor/chamados/{$ticketId}/comentarios");
    }

    public function download(?array $data): void
    {
        $attachmentId = (int)($data["id"] ?? 0);

        $attachment = TicketAttachment::find($attachmentId);

        if (!$attachment) {
            Message::warning("Anexo não encontrado ou não existe.");
            redirect("/professor/chamados");
            return;
        }

        $ticket = Ticket::find($attachment->getTicketId());

        if (!$ticket || $ticket->getOpenedBy() !== Auth::user()->id) {
            Message::warning("Você não tem permissão para baixar este anexo.");
            redirect("/professor/chamados");
            return;
        }

        if (!file_exists($attachment->getFilePath())) {
            Message::error("O arquivo não foi encontrado no servidor.");
            redirect("/professor/chamados/" . $attachment->getTicketId() . "/comentarios");
            return;
        }

        header("Content-Type: " . $attachment->getMimeType());
        header("Content-Disposition: attachment; filename=\"" . $attachment->getOriginalName() . "\"");
        header("Content-Length: " . $attachment->getFileSize());
        header("Cache-Control: no-cache, must-revalidate");

        $handle = fopen($attachment->getFilePath(), "rb");

        while (!feof($handle)) {
            echo fread($handle, 8192);
            flush();
        }

        fclose($handle);
        exit;
    }

    public function destroy(?array $data): void
    {
        Auth::requirePermission(Permission::DELETE_OWN_ATTACHMENT);

        $ticketId     = (int)($data["ticket_id"] ?? 0);
        $attachmentId = (int)($data["id"] ?? 0);

        $this->validateCsrfToken($data, "/professor/chamados/{$ticketId}/anexos/excluir/{$attachmentId}");

        $attachment = TicketAttachment::find($attachmentId);

        if (!$attachment) {
            Message::warning("Anexo não encontrado ou não existe.");
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        if ($attachment->getTicketId() !== $ticketId) {
            Message::warning("Este anexo não pertence ao chamado informado.");
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        if ($attachment->getUploadedBy() !== Auth::user()->id) {
            Message::warning("Você só pode excluir anexos enviados por você.");
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        try {
            if (file_exists($attachment->getFilePath())) {
                unlink($attachment->getFilePath());
            }

            $attachment->delete();

        } catch (\InvalidArgumentException $e) {
            Message::error($e->getMessage());
            redirect("/professor/chamados/{$ticketId}/comentarios");
            return;
        }

        Message::success("Anexo excluído com sucesso.");
        redirect("/professor/chamados/{$ticketId}/comentarios");
    }
}