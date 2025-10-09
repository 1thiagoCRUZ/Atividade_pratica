<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Busca</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Cabeçalho -->
    <header class="bg-dark text-white py-3 mb-3">
        <div class="container">
            <div class="d-flex align-items-center">
                <i class="bi bi-car-front-fill fs-2 me-3"></i>
                <h1 class="mb-0">Sistema de Cadastro de Automóveis</h1>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="bg-dark col-auto col-md-4 col-lg-3 min-vh-100 d-flex flex-column justify-content-between">
                <div class="bg-dark p-2">
                    <a class="d-flex text-decoration-none mt-1 align-items-center text-white">
                        <span class="fs-4 d-none d-sm-inline">Atividade Prática</span>
                    </a>
                    <ul class="nav nav-pills flex-column mt-4">

                    <li class="nav-item py-2 py-sm-0">
                            <a href="index.php" class="nav-link text-white">
                                <img src="./icons/home.svg" alt="">
                                <span class="fs-5 d-none d-sm-inline">Início</span>
                            </a>
                        </li>

                        <li class="nav-item py-2 py-sm-0">
                            <a href="listaautomoveis.php" class="nav-link text-white">
                                <img src="./icons/lista.svg" alt="">
                                <span class="fs-5 d-none d-sm-inline">Lista de carros</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col p-3">
                <div class="card mb-4">
                <div class="card-header bg-gradient bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-search"></i> Resultados da pesquisa</h3>
                </div>
                <div class="card-body bg-light">
                    <?php
                    /**Pegando o arquivo que contem o codigo pra conexão com o banco de dados */
                    require_once ("./config/conectarBD.php");

                    //Atribuindo valor a variavel pelo metodo get
                    $nomeCarro = $_GET['nomedocarro'];

                    $sql = "SELECT a.codigo, a.nome, a.placa, a.chassi, m.nome as montadora FROM automoveis a INNER JOIN montadoras m ON a.montadora = m.codigo WHERE a.nome = :nomeCarro";

                    $stmt = $con->prepare($sql);
                    $stmt->bindValue(':nomeCarro', $nomeCarro);
                    $stmt->execute();

                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo "<table class='table table-striped table-hover'>
                    <thead class='table-dark'>
                    <tr>
                    <th scope='col'>Código</th>
                    <th scope='col'>Nome</th>
                    <th scope='col'>Placa</th>
                    <th scope='col'>Chassi</th>
                    <th scope='col'>Montadora</th>
                    </tr></thead>
                    <tbody>";

    foreach ($results as $registro) {
        echo("<tr>");
        echo("<td>" . $registro['codigo'] . "</td><td>" . $registro['nome'] . "</td>");
        echo("<td>" . $registro['placa'] . "</td>");
        echo("<td>" . $registro['chassi'] . "</td>");
        echo("<td>" . $registro['montadora'] . "</td></tr>");
    }

    echo "</table>";
    
    if (count($results) == 0) {
        echo "<div class='alert alert-info'>Nenhum carro encontrado com o nome '$nomeCarro'.</div>";
    }
    ?>
    
    <div class="mt-4">
        <a href="listaautomoveis.php" class="btn btn-outline-primary me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Voltar para a lista
        </a>
        <a href="index.php" class="btn btn-outline-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house me-1" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
            </svg>
            Página Inicial
        </a>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
        
</body>

</html>