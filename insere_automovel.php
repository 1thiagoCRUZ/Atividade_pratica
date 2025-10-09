<?php
/**  Dependências do Banco de Dados*/
require_once ("./config/conectarBD.php");

//Atribuindo valores as váriaveis pelo metodo post
$nomeCarro = $_POST['nome'];
$placaCarro = $_POST['placa'];
$chassiCarro = $_POST['chassi'];
$valorSelect = $_POST['montadora'];
$img_url = $_POST['imagem_url'];

//Inserindo dados na tabela de automoveis os ? são os marcadores de posição
    $sql = "INSERT INTO automoveis(nome, placa, chassi, montadora, imagem_url) VALUES (?, ?, ?, ?, ?);";
    try {
        $stmt = $con->prepare($sql);

        //preenchendo os marcadores de posição
        $stmt->bindParam(1, $nomeCarro);
        $stmt->bindParam(2, $placaCarro);
        $stmt->bindParam(3, $chassiCarro);
        $stmt->bindParam(4, $valorSelect);
        $stmt->bindParam(5, $img_url);

        $stmt->execute();

        //Caso funcione vamos ser redirecionado para a página de index
        header('Location: index.php');

    } catch (PDOException $e) {
        echo "Cadastro de automóvel não realizado! Erro: ". $e->getMessage();
    }


?>