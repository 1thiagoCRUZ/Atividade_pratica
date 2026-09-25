<?php
require_once 'config.php';

try {
    $con = new PDO(
        DSN . ':host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USERNAME,
        DB_PASSWORD,
        [
            // Erros de SQL viram exceções (o catch consegue capturar)
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // Cada linha do resultado vem com o nome das colunas ($carro['nome'])
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Falha na conexão: ' . $e->getMessage());
}
