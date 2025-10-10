<?php
require_once("./config/conectarBD.php");
// Preciso pegar a informação do ID pelo forms e apagar a linha pelo ID no banco

$carroID = $_GET['codigo'];

$sql = "DELETE FROM automoveis WHERE codigo=:carroID;";
try {
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':carroID', $carroID);
    $stmt->execute();
    header('Location: listaautomoveis.php');
} catch (PDOException $e) {
    echo "Ocorreu um erro ao deletar o carro: " . $e->getMessage();
}
?>