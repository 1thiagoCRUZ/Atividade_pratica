<?php
require_once("./config/conectarBD.php");

// 2. Lógica de busca/filtro
$searchTerm = isset($_GET['nome_carro']) ? trim($_GET['nome_carro']) : '';
$sql = "SELECT a.codigo, a.nome, a.placa, a.chassi, m.nome as montadora, a.imagem_url 
        FROM automoveis a 
        INNER JOIN montadoras m ON a.montadora = m.codigo";

if (!empty($searchTerm)) {
    $sql .= " WHERE a.nome LIKE :searchTerm";
}

$sql .= " ORDER BY a.codigo ASC";

try {
    $stmt = $con->prepare($sql);

    if (!empty($searchTerm)) {
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalCarros = count($results);

} catch (PDOException $e) {
    die("Erro ao consultar o banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Carros</title>
    <link rel="stylesheet" href="./css/listagem.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <a href="index.php" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6" />
            </svg>
            Voltar
        </a>
        <a href="index.php" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Adicionar carro
        </a>
    </header>

    <main>
        <div class="list-header">
            <h1>Lista de carros</h1>
        </div>

        <div class="filter-container">
            <form action="listaautomoveis.php" method="get" class="filter-form">
                <div class="form-field">
                    <label for="nome_carro">Nome do carro</label>
                    <input type="text" id="nome_carro" name="nome_carro" placeholder="Digite o nome do carro..."
                        value="<?= htmlspecialchars($searchTerm) ?>">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-filter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 35%;">Carro</th>
                        <th style="width: 15%;">Montadora</th>
                        <th style="width: 15%;">Placa</th>
                        <th style="width: 10%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($totalCarros > 0): ?>
                        <?php foreach ($results as $carro): ?>
                            <tr>
                                <td><?= htmlspecialchars($carro['codigo']) ?></td>
                                <td>
                                    <div class="car-info">
                                        <img src="<?= (!empty($carro['imagem_url']) ? htmlspecialchars($carro['imagem_url']) : 'https://placehold.co/64x64/e2e8f0/adb5bd?text=Carro') ?>"
                                            alt="Foto do <?= htmlspecialchars($carro['nome']) ?>">
                                        <div class="car-details">
                                            <span class="car-name"><?= htmlspecialchars($carro['nome']) ?></span>
                                            <span class="car-chassi">Chassi: <?= htmlspecialchars($carro['chassi']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($carro['montadora']) ?></td>
                                <td><span class="placa-tag"><?= htmlspecialchars($carro['placa']) ?></span></td>
                                <td>
                                    <span>
                                        <a href="editar.php?codigo=<?= htmlspecialchars($carro['codigo'])?>" style=" text-decoration: none;">
                                            <img src="./imagens/pencil-square.svg" alt="">
                                        </a>

                                        <a href="delete.php?codigo=<?= htmlspecialchars($carro['codigo']) ?>" style=" text-decoration: none;">
                                            <img src="./imagens/trash3.svg" alt="">
                                        </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="no-results">Nenhum carro encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span>Mostrando <?= $totalCarros ?> de <?= $totalCarros ?> carros</span>
        </div>
    </main>

</body>

</html>