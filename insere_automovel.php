<?php
/**  Dependências do Banco de Dados*/
require_once ("conectarBD.php");

//Atribuindo valores as váriaveis pelo metodo get
$nomeCarro = $_GET['nome'];
$placaCarro = $_GET['placa'];
$chassiCarro = $_GET['chassi'];
$valorSelect = $_GET['select'];

//Inserindo dados na tabela de automoveis os ? são os marcadores de posição
    $sql = "INSERT INTO automoveis(nome, placa, chassi, montadora) VALUES (?, ?, ?, ?);";
    try {
        $stmt = $con->prepare($sql);

        //preenchendo os marcadores de posição
        $stmt->bindParam(1, $nomeCarro);
        $stmt->bindParam(2, $placaCarro);
        $stmt->bindParam(3, $chassiCarro);
        $stmt->bindParam(4, $valorSelect);

        $stmt->execute();

        //Caso funcione vamos ser redirecionado para a página de index
        header('Location: index.php');

    } catch (PDOException $e) {
        echo "Cadastro de automóvel não realizado! Erro: ". $e->getMessage();;
    }


?>