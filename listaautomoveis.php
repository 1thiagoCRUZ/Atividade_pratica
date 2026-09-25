<?php
require_once './config/conectarBD.php';

// Termo digitado na busca (vazio se ninguém buscou nada)
$termo = $_GET['nome_carro'] ?? '';

// O % nos dois lados significa "qualquer coisa antes e depois".
// Com o termo vazio fica '%%', que traz todos os carros.
$busca = '%' . $termo . '%';

$sql = 'SELECT a.codigo, a.nome, a.placa, a.chassi, a.imagem_url, m.nome AS montadora
        FROM automoveis a
        INNER JOIN montadoras m ON a.montadora = m.codigo
        WHERE a.nome LIKE :nome
        ORDER BY a.nome';

$stmt = $con->prepare($sql);
$stmt->bindParam(':nome', $busca);
$stmt->execute();
$carros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carros Cadastrados</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/lista.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header-title">
            <img src="./icons/lista.svg" />
            <h1>Concessionária DEVMENTHORS</h1>
        </div>
        <a href="index.php" class="header-button">Cadastrar Carro</a>
    </header>

    <main>
        <div class="lista-container">
            <h2>Carros Cadastrados</h2>

            <form action="listaautomoveis.php" method="get" class="busca">
                <input type="text" name="nome_carro" placeholder="Buscar pelo nome do carro" value="<?= htmlspecialchars($termo) ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <?php if ($termo !== '') { ?>
                    <a href="listaautomoveis.php" class="btn btn-secondary">Limpar</a>
                <?php } ?>
            </form>

            <?php if (count($carros) > 0) { ?>
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Montadora</th>
                            <th>Placa</th>
                            <th>Chassi</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carros as $carro) { ?>
                            <?php
                            // Se o carro não tem imagem, usa a imagem padrão
                            $imagem = !empty($carro['imagem_url']) ? $carro['imagem_url'] : './imagens/carro_padrao.svg';
                            ?>
                            <tr>
                                <td><img class="foto" src="<?= htmlspecialchars($imagem) ?>" alt=""></td>
                                <td><?= htmlspecialchars($carro['nome']) ?></td>
                                <td><?= htmlspecialchars($carro['montadora']) ?></td>
                                <td><?= htmlspecialchars($carro['placa']) ?></td>
                                <td><?= htmlspecialchars($carro['chassi']) ?></td>
                                <td class="acoes">
                                    <a href="editar.php?id=<?= (int) $carro['codigo'] ?>" class="btn btn-secondary">Editar</a>

                                    <!-- Apagar muda dados, então usa POST (formulário) e não um link -->
                                    <form action="delete.php" method="post" onsubmit="return confirm('Remover este carro?');">
                                        <input type="hidden" name="id" value="<?= (int) $carro['codigo'] ?>">
                                        <button type="submit" class="btn-perigo">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="vazio">Nenhum resultado encontrado.</p>
            <?php } ?>
        </div>
    </main>
</body>
</html>
