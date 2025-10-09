-- --------------------------------------------------------
-- Arquivo: atividade_pratica.sql
-- Banco de Dados para o sistema de locação de automóveis
-- Compatível com XAMPP / phpMyAdmin / MySQL / MariaDB
-- --------------------------------------------------------

-- Apaga o banco se já existir (opcional)
DROP DATABASE IF EXISTS atividade_pratica;

-- Cria o banco de dados
CREATE DATABASE atividade_pratica CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Usa o banco de dados
USE atividade_pratica;

-- --------------------------------------------------------
-- Tabela: montadoras
-- --------------------------------------------------------

CREATE TABLE montadoras (
  codigo INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserindo dados na tabela montadoras
INSERT INTO montadoras (codigo, nome) VALUES
(1, 'Volkswagen'),
(2, 'Ford'),
(3, 'Fiat'),
(4, 'Chevrolet');

-- --------------------------------------------------------
-- Tabela: automoveis
-- --------------------------------------------------------

CREATE TABLE automoveis (
  codigo INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  placa CHAR(7) NOT NULL,
  chassi VARCHAR(17) NOT NULL,
  montadora INT(11) NOT NULL,
  PRIMARY KEY (codigo),
  KEY fk_montadora (montadora),
  CONSTRAINT fk_automovel_montadora FOREIGN KEY (montadora)
    REFERENCES montadoras (codigo)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserindo dados na tabela automoveis
INSERT INTO automoveis (codigo, nome, placa, chassi, montadora) VALUES
(7, 'Gol', 'EVS6432', '123ADAS323', 1),
(8, 'Gol', 'EVS6432', '123ADAS323', 4),
(9, 'Opala', 'CHE67', '132134234', 4),
(10, 'Nissan', 'CHE66', '123ADAS321', 3),
(11, 'Nissan', 'CHE65', '123ADAS320', 3),
(12, 'Opala', 'CHE60', '123ADAS325', 2);

-- --------------------------------------------------------
-- Finalização
-- --------------------------------------------------------

COMMIT;

