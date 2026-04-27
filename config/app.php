<?php


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

define("APP_URL", $_ENV['APP_URL'] ?? "http://localhost/sigeti_cax");
define("APP_NAME", $_ENV['APP_NAME'] ?? "SIGETI - Sistema de Gestão de Chamados de TI");

define("APP_TIMEZONE", $_ENV['APP_TIMEZONE'] ?? "America/Sao_Paulo");

define("DB_CONNECTION", $_ENV['DB_CONNECTION'] ?? "yourdbsql");
define("DB_HOST", $_ENV['DB_HOST'] ?? "yourhost.com");
define("DB_PORT", $_ENV['DB_PORT'] ?? "9999");
define("DB_DATABASE", $_ENV['DB_DATABASE'] ?? "dbname");
define("DB_USERNAME", $_ENV['DB_USERNAME'] ?? "user");
define("DB_PASSWORD", $_ENV['DB_PASSWORD'] ?? "password");
define("DB_CHARSET", $_ENV['DB_CHARSET'] ?? "utf8mb4");
define("APP_DEVELOPER", $_ENV['APP_DEVELOPER'] ?? "Curso Técnico em Informática para Internet");

define("EMAIL_SEND", $_ENV['EMAIL_SEND'] ?? "contato@sigeti.com.br");
define("EMAIL_NAME", $_ENV['EMAIL_NAME'] ?? "Equipe Técnica do SIGETI");
define("USERNAME_SENDGRID", $_ENV['USERNAME_SENDGRID'] ?? "apikey");
define("PASSWORD_SENDGRID", $_ENV['PASSWORD_SENDGRID'] ?? "secret");