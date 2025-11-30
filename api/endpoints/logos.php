<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

$codigo  = $_GET["codigo"] ?? null;
$arquivo = $_GET["arquivo"] ?? null;
$tamanho = $_GET["size"] ?? null;

if (!$codigo || !$arquivo) {
    echo json_encode([
        "error" => true,
        "code" => 400,
        "message" => "Parâmetros inválidos: código e arquivo são obrigatórios.",
        "total" => 0,
        "data" => []
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$path = "../uploads/logos/$codigo/$arquivo";

if (!file_exists($path)) {
    echo json_encode([
        "error" => true,
        "code" => 404,
        "message" => "Logo não encontrada para o banco informado.",
        "total" => 0,
        "data" => []
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$svg = file_get_contents($path);

if ($svg === false) {
    echo json_encode([
        "error" => true,
        "code" => 500,
        "message" => "Erro ao ler o arquivo SVG.",
        "total" => 0,
        "data" => []
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($tamanho) {
    $tamanho = preg_replace('/[^0-9]/', '', $tamanho);

    if (!$tamanho || $tamanho < 10) {
        echo json_encode([
            "error" => true,
            "code" => 400,
            "message" => "O tamanho informado é inválido.",
            "total" => 0,
            "data" => []
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $svg = preg_replace('/width="[^"]*"/', 'width="' . $tamanho . '"', $svg);
    $svg = preg_replace('/height="[^"]*"/', 'height="' . $tamanho . '"', $svg);

    if (!preg_match('/viewBox="[^"]*"/', $svg)) {
        $svg = preg_replace(
            '/<svg([^>]*)>/',
            '<svg$1 viewBox="0 0 ' . $tamanho . ' ' . $tamanho . '">',
            $svg
        );
    }
}

header("Content-Type: image/svg+xml");
echo $svg;