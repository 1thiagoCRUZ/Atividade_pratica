<?php
require_once './config/conectarBD.php';

// O id vem de um formulário POST (campo hidden), não de um link
$id = $_POST['id'] ?? '';

// Sem id (ex.: alguém abriu delete.php direto pela URL)? Volta para a lista
if ($id === '') {
    header('Location: listaautomoveis.php');
    exit;
}

// Atenção ao WHERE: sem ele, TODOS os carros seriam apagados
try {
    $stmt = $con->prepare('DELETE FROM automoveis WHERE codigo = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: listaautomoveis.php');
    exit;
} catch (PDOException $e) {
    echo 'Remoção não realizada: ' . htmlspecialchars($e->getMessage());
}
