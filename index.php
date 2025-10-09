<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Carro</title>
    <link rel="stylesheet" href="./css/style.css">
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
            <h2>Informações do Veículo</h2>
            <p>Preencha os dados básicos do carro que deseja cadastrar</p>

            <form action="insere_automovel.php" method="post">
                <div class="form-grid">
                    <div class="form-field">
                        <label for="nome">Nome do Carro *</label>
                        <input type="text" id="nome" name="nome" placeholder="Ex: Civic 2023" required>
                    </div>

                    <div class="form-field">
                        <label for="montadora">Montadora *</label>
                        <select id="montadora" name="montadora" required>
                            <option value="" disabled selected>Selecione a montadora</option>
                             <?php
                                require_once("./config/conectarBD.php");

                                try {
                                    $sql = "SELECT codigo, nome FROM montadoras ORDER BY nome ASC";
                                    
                                    $stmt = $con->query($sql);
                                    
                                    if ($stmt->rowCount() > 0) {
                                        while($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='" . $linha["codigo"] . "'>" . htmlspecialchars($linha["nome"]) . "</option>";
                                        }
                                    } else {
                                        echo "<option disabled>Nenhuma montadora cadastrada</option>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<option disabled>Erro ao carregar montadoras.</option>";
                                } finally {
                                    $con = null;
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-field">
                        <label for="chassi">Chassi *</label>
                        <input type="text" id="chassi" name="chassi" placeholder="Ex: 9BWZZZ377VT004251" required minlength="17" maxlength="17">
                    </div>

                    <div class="form-field">
                        <label for="placa">Placa *</label>
                        <input type="text" id="placa" name="placa" placeholder="Ex: ABC-1234" required minlength="7" maxlength="8">
                    </div>
                    
                    <div class="form-field full-width">
                        <label for="imagem_url">URL da Imagem</label>
                        <input type="url" id="imagem_url" name="imagem_url" placeholder="https://exemplo.com/imagem-do-carro.jpg">
                        <span class="field-hint">Opcional: Cole o link de uma imagem do carro</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar Carro</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>