<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Automóveis cadastrados</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
            <center><div class="p-3">
                <h3>Tabela com os automóveis cadastrados</h3>
                <?php
                /**  Dependências do Banco de Dados*/
                require_once("conectarBD.php");
                
                //Fazendo a consulta e trazendo os dados do banco de dados
                $sql = "SELECT a.codigo, a.nome , a.placa, a.chassi, m.nome as montadora FROM automoveis a INNER JOIN montadoras m ON a.montadora = m.codigo";
                $stmt = $con->query($sql);

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

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //Percorrendo results e guardando seu valor em registro
                foreach ($results as $registro) {
                    echo ("<tr><th scope='row'>" . $registro['codigo'] . "</th><td>" . $registro['nome'] . "</td>");
                    echo ("<td>" . $registro['placa'] . "</td>");
                    echo ("<td>" . $registro['chassi'] . "</td>");
                    echo ("<td>" . $registro['montadora'] . "</td></tr>");
                }
                echo "</tbody></table>";
                ?>

                <hr>

                <h3>Busque pelo nome do seu carro abaixo</h3>
                <form action="buscarcarronome.php" method="get">
                <div class="mb-3">
                        <label for="exampleInputName1" class="form-label">Nome</label>
                        <input type="text" class="form-control custom-width" name='nomedocarro' aria-describedby="nameHelp">
                        <div class="form-text">Insira o nome do seu carro aqui</div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnsbmt">Pesquisar</button>
                </form>
            </div>
            </center>

</body>
</html>