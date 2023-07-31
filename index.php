<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade Prática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

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

            <div class="p-3">
                <h3>
                    Cadastro de automóveis
                </h3>
                <form action="insere_automovel.php" method="get">
                    <div class="mb-3">
                        <label for="exampleInputName1" class="form-label">Nome</label>
                        <input type="text" class="form-control custom-width" name='nome' aria-describedby="nameHelp">
                        <div class="form-text">Insira o nome do seu carro aqui</div>
                    </div>

                    <div class="mb-3">
                    <label for="exampleInputPlaca1" class="form-label">Placa</label>
                        <input type="text" class="form-control custom-width" name='placa'>
                    </div>

                    <div class="mb-3">
                    <label for="exampleInputChassi1" class="form-label">Chassi</label>
                        <input type="text" class="form-control custom-width" name='chassi'>
                    </div>


                    <div class="mb-3">
                        <label for="select" class="form-label">Montadoras</label>
                        <select name="select" class="form-select custom-width">
                            <option value="" selected>Montadoras</option>
                            <option value="1">Volkswagen</option>
                            <option value="2">Ford</option>
                            <option value="3">Fiat</option>
                            <option value="4">Chevrolet</option>
                        </select>
                    </div>

                    <br>

                    <button type="submit" class="btn btn-primary" id="btnsbmt">Enviar</button>
                </form>

            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>