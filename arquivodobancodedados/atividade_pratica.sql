-- Banco da aula: carros e montadoras

-- Apaga o banco se já existir (assim dá para importar de novo)
DROP DATABASE IF EXISTS atividade_pratica;

CREATE DATABASE atividade_pratica CHARACTER SET utf8mb4;
USE atividade_pratica;

-- Tabela de montadoras
CREATE TABLE montadoras (
    codigo INT AUTO_INCREMENT PRIMARY KEY,
    nome   VARCHAR(50) NOT NULL
);

-- Tabela de carros (montadora aponta para montadoras.codigo)
CREATE TABLE automoveis (
    codigo     INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    placa      VARCHAR(10)  NOT NULL,
    chassi     VARCHAR(17)  NOT NULL,
    imagem_url VARCHAR(255) NULL,
    montadora  INT          NOT NULL,
    FOREIGN KEY (montadora) REFERENCES montadoras(codigo)
);

-- Dados de exemplo
INSERT INTO montadoras (nome) VALUES
    ('Volkswagen'),
    ('Ford'),
    ('Fiat'),
    ('Chevrolet');

INSERT INTO automoveis (nome, placa, chassi, montadora) VALUES
    ('Gol',    'EVS6432', '123ADAS323', 1),
    ('Gol',    'EVS6432', '123ADAS323', 4),
    ('Opala',  'CHE67',   '132134234',  4),
    ('Nissan', 'CHE66',   '123ADAS321', 3),
    ('Nissan', 'CHE65',   '123ADAS320', 3),
    ('Opala',  'CHE60',   '123ADAS325', 2);
