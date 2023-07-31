<?php
/**Pegando o arquivo que contem o codigo pra conexão com o banco de dados */
require_once ("conectarBD.php");

//Atribuindo valor a variavel pelo metodo get
$nomeCarro = $_GET['nomedocarro'];

$sql = "SELECT a.codigo, a.nome , a.placa, a.chassi, m.nome as montadora FROM automoveis a INNER JOIN montadoras m ON a.montadora = m.codigo WHERE a.nome = :nomeCarro";

$stmt = $con->prepare($sql);
$stmt->bindValue(':nomeCarro', $nomeCarro);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<meta charset="UTF-8">';
//bootstrap
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">';


    echo "<center><h2>Resultados da pesquisa</h2></center>";
    echo "<table class='table'>
                <thead>
                <tr>
                <th scope='col'>Código</th>
                <th scope='col'>Nome</th>
                <th scope='col'>Placa</th>
                <th scope='col'>Chassi</th>
                <th scope='col'>Montadora</th>
                </tr></thead>
                <tbody>";

    foreach ($results as $registro) {
        echo("<tr><td>" . $registro['codigo'] . "</td><td>" . $registro['nome'] . "</td>");
        echo("<td>" . $registro['placa'] . "</td>");
        echo("<td>" . $registro['chassi'] . "</td>");
        echo("<td>" . $registro['montadora'] . "</td></tr>");
    }

    echo "</table>";

?>