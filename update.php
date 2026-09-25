<?php
require_once './config/conectarBD.php';

// Pega o que veio do formulário de edição
$id         = $_POST['id'];
$nome       = $_POST['nome'];
$montadora  = $_POST['montadora'];
$chassi     = $_POST['chassi'];
$placa      = $_POST['placa'];
$imagem_url = $_POST['imagem_url'];

// Imagem é opcional: se veio vazia, guarda NULL no banco
if ($imagem_url === '') {
    $imagem_url = null;
}

// Atenção ao WHERE: sem ele, TODOS os carros seriam alterados
$sql = 'UPDATE automoveis
        SET nome = :nome, montadora = :montadora, chassi = :chassi, placa = :placa, imagem_url = :imagem_url
        WHERE codigo = :id';

try {
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':montadora', $montadora);
    $stmt->bindParam(':chassi', $chassi);
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':imagem_url', $imagem_url);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: listaautomoveis.php');
    exit;
} catch (PDOException $e) {
    echo 'Alteração não realizada: ' . htmlspecialchars($e->getMessage());
}
