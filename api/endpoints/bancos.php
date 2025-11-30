<?php
header("Content-Type: application/json; charset=utf-8");
require __DIR__ . '/../config/db.php';

if (!empty($_GET['id'])) {
    $sql = $pdo->prepare('SELECT * FROM Bancos WHERE codigo = :cod');
    $sql->bindValue(":cod", explode('/', $_SERVER['REQUEST_URI'])[3]);

    if ($sql->execute()) {
        $banco = $sql->fetchAll(PDO::FETCH_ASSOC);

        if (count($banco) > 0) {
            echo json_encode([
                "error" => false,
                "code" => 200,
                "message" => "",
                "total" => count($banco),
                "data" => $banco
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode([
                "error" => false,
                "code" => 404,
                "message" => "Nenhum banco foi encontrado",
                "total" => count($banco),
                "data" => $banco
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }
} else {
    $sql = $pdo->prepare('SELECT * FROM Bancos ORDER BY ISPB ASC');

    if ($sql->execute()) {
        $bancos = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            "error" => false,
            "code" => 200,
            "message" => "Lista de bancos disponíveis",
            "total" => count($bancos),
            "data" => $bancos
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else {
        echo json_encode([
            "error" => false,
            "code" => 404,
            "message" => "Nenhum resultado foi encontrado",
            "total" => 0,
            "data" => null
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
