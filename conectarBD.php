<?php
/**  Pegandoa o arquivo onde estão as variaveis do nosso banco de dados*/
require_once("config.php");


//abrindo a conexão com o banco de dados
try {
    $con = new PDO(
        DNS . ':host=' . DB_SERVER . '; dbname=' . DB_NAME,
        DB_USERNAME,
        DB_PASSWORD
    );
    $dataset = $con->query("SELECT SYSDATE() 'SYSDATE'"); //Obtendo a data e a hora do servidor do banco de dados
    $registro = $dataset->fetch();
} catch (PDOException $e) {
    echo "Ocorreu uma falha ao conectar o banco de dados <br />" . $e->getMessage();
}

?>