<?php
$errorCode = $errorCode ?? 404;

$catalog = [
        400 => ["title"=>"Requisição inválida","message"=>"A requisição não pôde ser processada.","icon"=>"bi-exclamation-triangle","color"=>"warning"],
        401 => ["title"=>"Não autenticado","message"=>"Faça login para continuar.","icon"=>"bi-lock","color"=>"warning"],
        403 => ["title"=>"Acesso negado","message"=>"Você não tem permissão.","icon"=>"bi-shield-x","color"=>"danger"],
        404 => ["title"=>"Página não encontrada","message"=>"A página não existe ou foi removida.","icon"=>"bi-file-earmark-x","color"=>"primary"],
        405 => ["title" => "Método não permitido","message" => "O método HTTP utilizado não é permitido para este recurso.", "icon" => "bi-x-octagon", "color" => "warning"],
        408 => ["title"=>"Tempo esgotado","message"=>"A requisição demorou muito.","icon"=>"bi-clock-history","color"=>"info"],
        409 => ["title"=>"Conflito","message"=>"Conflito de dados detectado.","icon"=>"bi-arrow-left-right","color"=>"warning"],
        410 => ["title"=>"Removido","message"=>"Este recurso não está mais disponível.","icon"=>"bi-trash","color"=>"secondary"],
        422 => ["title"=>"Dados inválidos","message"=>"Verifique os dados enviados.","icon"=>"bi-input-cursor-text","color"=>"warning"],
        429 => ["title"=>"Muitas requisições","message"=>"Aguarde antes de tentar novamente.","icon"=>"bi-speedometer2","color"=>"danger"],
        500 => ["title"=>"Erro interno", "message"=>"Erro inesperado no servidor.","icon"=>"bi-server","color"=>"danger"],
        501 => ["title" => "Não implementado", "message" => "O servidor não suporta a funcionalidade necessária para processar esta requisição.", "icon" => "bi-code-slash", "color" => "secondary"],
        502 => ["title"=>"Bad gateway","message"=>"Erro na comunicação com servidor.","icon"=>"bi-diagram-3","color"=>"warning"],
        503 => ["title"=>"Serviço indisponível","message"=>"Serviço temporariamente offline.","icon"=>"bi-cloud-slash","color"=>"info"],
];

$error = $catalog[$errorCode] ?? $catalog[500];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $errorCode ?> - <?= APP_NAME ?></title>

    <link rel="shortcut icon" href="<?= assets_mazer('/assets/compiled/svg/favicon.svg') ?>">

    <link rel="stylesheet" href="<?= assets_mazer('/assets/compiled/css/app.css') ?>">
    <link rel="stylesheet" href="<?= assets_mazer('/assets/extensions/bootstrap-icons/bootstrap-icons.css') ?>">
</head>

<body>

<script src="<?= assets_mazer('/assets/static/js/initTheme.js') ?>"></script>

<div class="min-vh-100 d-flex align-items-center bg-body">

    <div class="container">
        <div class="row justify-content-center text-center">

            <div class="col-12 col-md-10 col-lg-7">

                <div class="fw-bold text-<?= $error['color'] ?> opacity-25"
                     style="font-size: clamp(90px, 18vw, 180px); line-height:1;">
                    <?= $errorCode ?>
                </div>

                <div class="mb-3">
                    <i class="bi <?= $error['icon'] ?> text-<?= $error['color'] ?>"
                       style="font-size: clamp(28px, 5vw, 40px);"></i>
                </div>

                <h1 class="fw-bold mb-2" style="font-size: clamp(22px, 4vw, 32px);">
                    <?= $error['title'] ?>
                </h1>

                <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                    <?= $error['message'] ?>
                </p>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">

                    <a href="<?= url('/entrar') ?>" class="btn btn-<?= $error['color'] ?> px-4">
                        <i class="bi bi-house-door me-2"></i>
                        Ir para o início
                    </a>

                    <button onclick="history.back()" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-2"></i>
                        Voltar
                    </button>

                </div>

            </div>

        </div>
    </div>

</div>

<script src="<?= assets_mazer('/assets/compiled/js/app.js') ?>"></script>

</body>
</html>