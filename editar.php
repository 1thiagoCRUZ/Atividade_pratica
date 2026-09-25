<?php
require_once './config/conectarBD.php';

// Qual carro será editado (vem na URL: editar.php?id=3)
$id = $_GET['id'] ?? '';

// Busca o carro para preencher o formulário
$stmt = $con->prepare('SELECT * FROM automoveis WHERE codigo = :id');
$stmt->bindParam(':id', $id);
$stmt->execute();
$carro = $stmt->fetch();

// Não achou o carro? Volta para a lista
if (!$carro) {
    header('Location: listaautomoveis.php');
    exit;
}

// Montadoras para o <select>
$montadoras = $con->query('SELECT codigo, nome FROM montadoras ORDER BY nome ASC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Carro</title>
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
        <a href="listaautomoveis.php" class="header-button">Ver Carros</a>
    </header>

    <main>
        <div class="form-container">
            <h2>Editar Veículo</h2>
            <p>Altere os dados e clique em salvar</p>

            <form action="update.php" method="post">
                <!-- O id vai escondido: o usuário não digita, mas o PHP precisa saber qual carro é -->
                <input type="hidden" name="id" value="<?= (int) $carro['codigo'] ?>">

                <div class="form-grid">
                    <div class="form-field">
                        <label for="nome">Nome do Carro *</label>
                        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($carro['nome']) ?>" required>
                    </div>

                    <div class="form-field">
                        <label for="montadora">Montadora *</label>
                        <select id="montadora" name="montadora" required>
                            <?php foreach ($montadoras as $m) { ?>
                                <option value="<?= (int) $m['codigo'] ?>" <?= $m['codigo'] == $carro['montadora'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($m['nome']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-field">
                        <label for="chassi">Chassi *</label>
                        <input type="text" id="chassi" name="chassi" value="<?= htmlspecialchars($carro['chassi']) ?>" required minlength="17" maxlength="17">
                    </div>

                    <div class="form-field">
                        <label for="placa">Placa *</label>
                        <input type="text" id="placa" name="placa" value="<?= htmlspecialchars($carro['placa']) ?>" required minlength="5" maxlength="8">
                    </div>

                    <div class="form-field full-width">
                        <label for="imagem_url">URL da Imagem</label>
                        <input type="url" id="imagem_url" name="imagem_url" value="<?= htmlspecialchars($carro['imagem_url'] ?? '') ?>" placeholder="https://exemplo.com/imagem-do-carro.jpg">
                        <span class="field-hint">Opcional: Cole o link de uma imagem do carro</span>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="listaautomoveis.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
