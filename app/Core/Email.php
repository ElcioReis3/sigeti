<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Email
{
    private \stdClass $data;
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.sendgrid.net';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = USERNAME_SENDGRID;
        $this->mail->Password = PASSWORD_SENDGRID;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 465;
        $this->mail->setLanguage('br');
        $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
    }

    public function bootstrap(string $subject, string $body, string $toEmail, string $toName): self
    {
        $this->data = new \stdClass();
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->toEmail = $toEmail;
        $this->data->toName = $toName;
        return $this;
    }

    public function attach(string $filePath, string $fileName): self
    {
        $this->data->attachments[$filePath] = $fileName;

        return $this;
    }

    public function send(string $fromEmail = EMAIL_SEND, string $fromName = EMAIL_NAME)
    {
        if (empty($this->data)) {
            throw new \InvalidArgumentException("Erro ao enviar: verifique os dados.");
        }

        if (!filter_var($this->data->toEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("E-mail do destinatário é inválido.");
        }

        if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("E-mail do remetente é inválido");
        }

        try {

            $this->mail->setFrom($fromEmail, $fromName);
            $this->mail->addAddress($this->data->toEmail, $this->data->toName);
            $this->mail->addReplyTo($fromEmail, $fromName);

            if (!empty($this->data->attachments)) {
                foreach ($this->data->attachments as $filePath => $filename) {
                    $this->mail->addAttachment($filePath, $filename);
                }
            }

            $this->mail->isHTML(true);
            $this->mail->Subject = $this->data->subject;
            $this->mail->Body = $this->data->body;

            $this->mail->send();
            return true;

        } catch (Exception $mailException) {
            throw new \InvalidArgumentException("Erro ao enviar e-mail: ". $mailException->getMessage());
        }
    }
}