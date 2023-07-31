-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Ago-2023 às 01:45
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `atividade_pratica`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `automoveis`
--

CREATE TABLE `automoveis` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `placa` char(7) NOT NULL,
  `chassi` varchar(17) NOT NULL,
  `montadora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `automoveis`
--

INSERT INTO `automoveis` (`codigo`, `nome`, `placa`, `chassi`, `montadora`) VALUES
(7, 'Gol', 'EVS6432', '123ADAS323', 1),
(8, 'Gol', 'EVS6432', '123ADAS323', 4),
(9, 'Opala', 'CHE67', '132134234', 4),
(10, 'Nissan', 'CHE66', '123ADAS321', 3),
(11, 'Nissan', 'CHE65', '123ADAS320', 3),
(12, 'Opala', 'CHE60', '123ADAS325', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `montadoras`
--

CREATE TABLE `montadoras` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `montadoras`
--

INSERT INTO `montadoras` (`codigo`, `nome`) VALUES
(1, 'Volkswagen'),
(2, 'Ford'),
(3, 'Fiat'),
(4, 'Chevrolet');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `automoveis`
--
ALTER TABLE `automoveis`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `montadora` (`montadora`);

--
-- Índices para tabela `montadoras`
--
ALTER TABLE `montadoras`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `automoveis`
--
ALTER TABLE `automoveis`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `montadoras`
--
ALTER TABLE `montadoras`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `automoveis`
--
ALTER TABLE `automoveis`
  ADD CONSTRAINT `automoveis_ibfk_1` FOREIGN KEY (`montadora`) REFERENCES `montadoras` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
