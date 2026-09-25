<?php
require_once './config/conectarBD.php';

// Pega o que veio do formulário
$nome       = $_POST['nome'];
$montadora  = $_POST['montadora'];
$chassi     = $_POST['chassi'];
$placa      = $_POST['placa'];
$imagem_url = $_POST['imagem_url'];

// Imagem é opcional: se veio vazia, guarda NULL no banco
if ($imagem_url === '') {
    $imagem_url = null;
}

$sql = 'INSERT INTO automoveis (nome, montadora, chassi, placa, imagem_url)
        VALUES (:nome, :montadora, :chassi, :placa, :imagem_url)';

try {
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':montadora', $montadora);
    $stmt->bindParam(':chassi', $chassi);
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':imagem_url', $imagem_url);
    $stmt->execute();

    header('Location: listaautomoveis.php');
    exit;
} catch (PDOException $e) {
    echo 'Cadastro não realizado: ' . htmlspecialchars($e->getMessage());
}
