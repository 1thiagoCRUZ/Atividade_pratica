<?php
require_once("./config/conectarBD.php");


$codigo = $_POST['codigo'];
$nome = $_POST['nome'];
$placa = $_POST['placa'];
$chassi = $_POST['chassi'];
$imagem_url = $_POST['imagem_url'];
$montadora = $_POST['montadora'];

$sql = "UPDATE automoveis 
            SET nome = :nome, placa = :placa, chassi = :chassi, imagem_url = :imagem_url, montadora = :montadora
            WHERE codigo = :codigo";

try {
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':chassi', $chassi);
    $stmt->bindParam(':imagem_url', $imagem_url);
    $stmt->bindParam(':montadora', $montadora);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();
    header("Location: listaautomoveis.php");
    exit;
} catch (PDOException $e) {
    die("Erro ao atualizar: " . $e->getMessage());
}
