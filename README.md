# 🚗 Sistema de Cadastro de Automóveis

Um sistema simples para gerenciamento de automóveis desenvolvido com PHP e MySQL, implementando operações CRUD (Create, Read, Update, Delete).

## 📋 Funcionalidades

- Cadastro de novos automóveis
- Listagem de todos os automóveis cadastrados
- Busca de automóveis por nome
- Edição de informações dos automóveis
- Exclusão de automóveis

## 🔧 Tecnologias Utilizadas

- PHP
- MySQL
- PDO (PHP Data Objects)
- HTML/CSS

## 📁 Estrutura do Projeto

### Arquivos de Configuração

#### 📂 config/config.php
Nesse arquivo definimos constantes. Constantes são como variáveis, mas com uma diferença: uma vez que você as define, o valor delas não pode ser alterado durante a execução do script.

A Estrutura das Variáveis:
- **DSN (mysql)**: Define o Driver que o PDO deve usar. O MySQL é o banco, e esse é o nome do driver.
- **DB_SERVER (localhost)**: O endereço do servidor do banco (geralmente localhost quando rodamos na nossa máquina).
- **DB_NAME (atividade_pratica)**: O nome do banco de dados que queremos acessar.
- **DB_USERNAME e DB_PASSWORD**: As credenciais de login.

```php
define('DSN',   'mysql');
define('DB_SERVER', 'localhost');
define('DB_NAME',   'atividade_pratica');
define('DB_USERNAME',   'root');
define('DB_PASSWORD',   "");
```

#### 📂 config/conectarBD.php
Criamos o objeto de conexão usando o PDO. O resultado desse comando é armazenado na variável $con (que, por convenção, é o objeto que usaremos para fazer todas as consultas).

O DSN (Data Source Name): O primeiro argumento do PDO é o endereço completo do banco, montado assim:
```
mysql:host=localhost;dbname=atividade_pratica
```

Ele está sendo concatenado usando as constantes do config.php

try-catch: tentativa e erro, vamos tentar (try) conectar com o banco de dados se der certo boa, se não passamos pro catch com a mensagem de erro.

```php
try {
    $con = new PDO(
        DSN . ':host=' . DB_SERVER . '; dbname=' . DB_NAME,
        DB_USERNAME,
        DB_PASSWORD
    );
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
```

### Arquivos Principais

#### 📂 index.php
Este arquivo é responsável por exibir o formulário de cadastro de automóveis. 

O que ele faz:
- Carrega as configurações e conexão com o banco de dados
- Busca todas as montadoras cadastradas no banco para preencher o dropdown
- Exibe um formulário HTML com método POST (os dados não aparecem na URL)
- Possui campos para nome, chassi, placa e URL da imagem do automóvel
- Envia os dados para o arquivo insere_automovel.php quando o formulário é submetido

Trecho importante:
```php
// Busca as montadoras no banco
$stmt = $con->prepare("SELECT * FROM montadora");
$stmt->execute();
$montadoras = $stmt->fetchAll(PDO::FETCH_ASSOC);

// No formulário, criamos o dropdown com as montadoras
foreach ($montadoras as $montadora) {
    echo '<option value="' . $montadora['id'] . '">' . htmlspecialchars($montadora['nome']) . '</option>';
}
```

#### 📂 insere_automovel.php
Este arquivo recebe os dados do formulário de cadastro e insere no banco de dados.

O que ele faz:
- Recebe os dados via método POST (nome, chassi, placa, etc.)
- Prepara uma instrução SQL com placeholders (?) para evitar injeção SQL
- Vincula os valores recebidos aos placeholders usando bindParam
- Executa a query para inserir os dados
- Redireciona para a página inicial após o cadastro

Trecho importante:
```php
// Recebe os dados do formulário
$nome = $_POST['nome'];
$chassi = $_POST['chassi'];
$placa = $_POST['placa'];
$montadora_id = $_POST['montadora_id'];
$url_imagem = $_POST['url_imagem'];

// Prepara e executa a query
$stmt = $con->prepare("INSERT INTO automoveis (nome, chassi, placa, montadora_id, url_imagem) VALUES (?, ?, ?, ?, ?)");
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $chassi);
$stmt->bindParam(3, $placa);
$stmt->bindParam(4, $montadora_id);
$stmt->bindParam(5, $url_imagem);
$stmt->execute();
```

#### 📂 listaautomoveis.php
Este arquivo lista todos os automóveis cadastrados e permite filtrar por nome.

O que ele faz:
- Exibe um formulário de busca com método GET (os dados aparecem na URL)
- Verifica se foi enviado um termo de busca
- Monta uma query SQL com JOIN para buscar os dados dos automóveis e suas montadoras
- Se houver termo de busca, adiciona uma condição LIKE para filtrar pelo nome
- Exibe os resultados em uma tabela HTML
- Fornece links para editar e excluir cada automóvel

Trecho importante:
```php
// Verifica se existe um termo de busca
$termo_busca = isset($_GET['nome_carro']) ? $_GET['nome_carro'] : '';

// Monta a query base
$sql = "SELECT a.*, m.nome as nome_montadora 
        FROM automoveis a 
        JOIN montadora m ON a.montadora_id = m.id";

// Se tiver termo de busca, adiciona a condição
if (!empty($termo_busca)) {
    $sql .= " WHERE a.nome LIKE :termo";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':termo', '%' . $termo_busca . '%');
} else {
    $stmt = $con->prepare($sql);
}

// Executa e busca os resultados
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exibe os resultados com foreach
foreach ($results as $carro) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($carro['nome']) . '</td>';
    // ... outros campos
    echo '</tr>';
}
```

#### 📂 editar.php
Este arquivo exibe um formulário preenchido com os dados do automóvel para edição.

O que ele faz:
- Recebe o ID do automóvel via GET
- Busca os dados do automóvel no banco
- Busca a lista de montadoras para o dropdown
- Preenche um formulário com os dados atuais
- Envia os dados para update.php quando o formulário é submetido

Trecho importante:
```php
// Recebe o ID e busca os dados do automóvel
$id = $_GET['id'];
$stmt = $con->prepare("SELECT * FROM automoveis WHERE id = ?");
$stmt->bindParam(1, $id);
$stmt->execute();
$automovel = $stmt->fetch(PDO::FETCH_ASSOC);

// No formulário, preenchemos os campos com os dados atuais
echo '<input type="text" name="nome" value="' . htmlspecialchars($automovel['nome']) . '">';
```

#### 📂 update.php
Este arquivo recebe os dados do formulário de edição e atualiza no banco de dados.

O que ele faz:
- Recebe os dados via POST, incluindo o ID do automóvel (que vem de um campo `hidden` do formulário de edição)
- Se a URL da imagem vier vazia, grava `NULL` no banco (o carro fica sem foto e a lista usa a imagem padrão)
- Prepara uma instrução SQL UPDATE com placeholders nomeados (`:nome`, `:id`...)
- Vincula os valores recebidos aos placeholders com `bindParam`
- Executa a query para atualizar os dados
- Redireciona para a listagem após a atualização e encerra o script com `exit`
- Se der erro, mostra a mensagem passando por `htmlspecialchars()`

> **Atenção ao WHERE:** sem o `WHERE codigo = :id`, o UPDATE alteraria **todos** os carros da tabela.

Trecho importante:
```php
// Recebe os dados do formulário
$id         = $_POST['id'];
$nome       = $_POST['nome'];
$imagem_url = $_POST['imagem_url'];
// ... outros campos

// Imagem é opcional: se veio vazia, guarda NULL no banco
if ($imagem_url === '') {
    $imagem_url = null;
}

// Prepara e executa a query de atualização
$sql = 'UPDATE automoveis
        SET nome = :nome, montadora = :montadora, chassi = :chassi, placa = :placa, imagem_url = :imagem_url
        WHERE codigo = :id';

$stmt = $con->prepare($sql);
$stmt->bindParam(':nome', $nome);
// ... outros campos
$stmt->bindParam(':id', $id);
$stmt->execute();

header('Location: listaautomoveis.php');
exit;
```

#### 📂 delete.php
Este arquivo exclui um automóvel do banco de dados.

O que ele faz:
- Recebe o ID do automóvel via **POST** (não mais via GET pela URL)
- Prepara uma instrução SQL DELETE com placeholder nomeado (`:id`)
- Vincula o ID recebido ao placeholder
- Executa a query para excluir o registro
- Redireciona para a listagem após a exclusão e encerra o script com `exit`

Por que POST e não um link? Apagar **muda dados**, então não deve ser feito por um link (GET): um link pode ser aberto sem querer, salvo no histórico ou acessado por robôs. Por isso, na `listaautomoveis.php` o botão **Remover** é um pequeno formulário com o ID num campo `hidden`, e ainda pede confirmação antes de enviar:

```html
<form action="delete.php" method="post" onsubmit="return confirm('Remover este carro?');">
    <input type="hidden" name="id" value="<?= (int) $carro['codigo'] ?>">
    <button type="submit" class="btn-perigo">Remover</button>
</form>
```

> **Atenção ao WHERE:** sem o `WHERE codigo = :id`, o DELETE apagaria **todos** os carros da tabela.

Trecho importante:
```php
// O id vem de um formulário POST (campo hidden), não de um link
$id = $_POST['id'];

// Prepara e executa a query de exclusão
$stmt = $con->prepare('DELETE FROM automoveis WHERE codigo = :id');
$stmt->bindParam(':id', $id);
$stmt->execute();

header('Location: listaautomoveis.php');
exit;
```

## 💡 Conceitos Importantes

### PDO (PHP Data Objects)
O PDO é como um "tradutor universal" para bancos de dados. Ele permite que seu código PHP se comunique com diferentes tipos de bancos de dados (MySQL, PostgreSQL, SQLite, etc.) usando a mesma sintaxe.

Principais comandos:
- **new PDO()**: Cria a conexão com o banco
- **prepare()**: Prepara uma instrução SQL para execução
- **bindParam()**: Vincula valores às posições na query (evita injeção SQL)
- **execute()**: Executa a query preparada
- **fetch()/fetchAll()**: Busca os resultados da query

### GET vs POST

- **GET**: 
  - Os dados são enviados pela URL (visíveis para o usuário)
  - Exemplo: `listaautomoveis.php?nome_carro=Civic`
  - Bom para: buscas, filtros, links para páginas específicas
  - Limitado em tamanho (URL tem limite de caracteres)
  - Não recomendado para dados sensíveis

- **POST**: 
  - Os dados são enviados no corpo da requisição (não visíveis na URL)
  - Exemplo: formulários de cadastro e edição
  - Bom para: envio de dados sensíveis, formulários grandes
  - Não tem limite de tamanho prático
  - Mais seguro para dados confidenciais

### Segurança

- **Prepared Statements**: 
  - Evitam injeção SQL separando o código SQL dos dados
  - O banco trata os dados como valores, não como comandos
  - Exemplo:
    ```php
    // Seguro (com prepared statement)
    $stmt = $con->prepare("SELECT * FROM usuarios WHERE nome = ?");
    $stmt->bindParam(1, $nome);
    
    // Inseguro (sem prepared statement)
    $query = "SELECT * FROM usuarios WHERE nome = '$nome'";
    ```

- **htmlspecialchars()**: 
  - Converte caracteres especiais em entidades HTML
  - Previne ataques XSS (Cross-Site Scripting)
  - Exemplo:
    ```php
    // Seguro
    echo htmlspecialchars($carro['nome']);
    
    // Inseguro
    echo $carro['nome'];
    ```

### Loops e Condicionais

- **foreach**: 
  - Percorre cada item de um array, um por um
  - Muito usado para exibir resultados de consultas
  - Exemplo:
    ```php
    foreach ($results as $carro) {
        echo $carro['nome'] . '<br>';
    }
    ```

- **Operador Ternário**: 
  - Uma forma compacta de fazer decisões simples
  - Formato: condição ? valor_se_verdadeiro : valor_se_falso
  - Exemplo:
    ```php
    // Com operador ternário
    $imagem = !empty($carro['url_imagem']) ? $carro['url_imagem'] : 'imagens/carro_padrao.svg';
    
    // Equivalente com if-else
    if (!empty($carro['url_imagem'])) {
        $imagem = $carro['url_imagem'];
    } else {
        $imagem = 'imagens/carro_padrao.svg';
    }
    ```

## 🚀 Como Usar

1. Configure um servidor web com PHP e MySQL (ex: XAMPP)
2. Importe o arquivo `arquivodobancodedados/atividade_pratica.sql` para criar o banco de dados
3. Coloque os arquivos na pasta htdocs do seu servidor
4. Acesse `http://localhost/Atividade_pratica/index.php` no navegador

## 📝 Licença

Este projeto é para fins educacionais.