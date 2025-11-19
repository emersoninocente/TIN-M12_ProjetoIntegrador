-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 18/11/2025 às 21:49
-- Versão do servidor: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Versão do PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `autor` varchar(150) NOT NULL,
  `isbn` varchar(17) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `editora` varchar(100) DEFAULT NULL,
  `resumo` text DEFAULT NULL,
  `ano_publicacao` year(4) DEFAULT NULL,
  `edicao` varchar(20) DEFAULT NULL,
  `quantidade_paginas` int(11) DEFAULT NULL,
  `quantidade_total` int(11) DEFAULT 1,
  `quantidade_disponivel` int(11) DEFAULT 1,
  `capa_url` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `data_cadastro` timestamp NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `autor`, `isbn`, `genero`, `editora`, `resumo`, `ano_publicacao`, `edicao`, `quantidade_paginas`, `quantidade_total`, `quantidade_disponivel`, `capa_url`, `ativo`, `data_cadastro`, `data_atualizacao`) VALUES
(1, 'Não é milagre', 'Joel Jota', '978-65-5047-550-5', 'Auto Ajuda', 'Citadel', '     A vida que você quer começa com um único dia bem vivido.\r\n     Este livro, um mergulho profundo nos padrões de rotina do maior especialista em alta performance do Brasil.', '2025', '1', 176, 1, 1, NULL, 1, '2025-11-04 20:23:30', '2025-11-04 20:23:30'),
(3, 'Inovação Transcendente', 'Daniel Castro', '978-65-5047-613-7', 'Desenvolvimento profissional, Negócios', 'Citadel', 'Ideias são ferramentas divinas compartilhadas com o ser humano e capazes de mudar o mundo.', '2025', '1', 224, 5, 5, NULL, 1, '2025-11-04 20:27:22', '2025-11-16 21:30:03'),
(4, 'Titulo Exemplo', 'Autor Exemplo', '1234567890123', 'Ficção', 'Editora Exemplo', 'Resumo do livro exemplo', '2023', '1', 300, 10, 10, 'http://exemplo.com/capa.jpg', 1, '2025-11-04 20:40:05', '2025-11-04 20:40:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `livro_id` int(11) NOT NULL,
  `data_reserva` timestamp NULL DEFAULT current_timestamp(),
  `data_retirada` datetime DEFAULT NULL,
  `data_prevista_devolucao` datetime DEFAULT NULL,
  `data_devolucao` datetime DEFAULT NULL,
  `status` enum('pendente','ativa','finalizada','cancelada') DEFAULT 'pendente',
  `observacoes` text DEFAULT NULL,
  `bibliotecario_retirada_id` int(11) DEFAULT NULL,
  `bibliotecario_devolucao_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `reservas`
--

INSERT INTO `reservas` (`id`, `usuario_id`, `livro_id`, `data_reserva`, `data_retirada`, `data_prevista_devolucao`, `data_devolucao`, `status`, `observacoes`, `bibliotecario_retirada_id`, `bibliotecario_devolucao_id`) VALUES
(1, 2, 1, '2025-11-04 21:58:54', NULL, NULL, NULL, 'pendente', NULL, NULL, NULL),
(2, 1, 1, '2025-11-13 20:18:47', '2025-11-16 21:25:05', '2025-11-30 00:00:00', NULL, 'ativa', NULL, 1, NULL),
(3, 9, 3, '2025-11-14 00:07:52', NULL, NULL, NULL, 'pendente', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `perfil` enum('usuario','bibliotecario','administrador') DEFAULT 'usuario',
  `ativo` tinyint(1) DEFAULT 1,
  `data_cadastro` timestamp NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `cpf`, `telefone`, `perfil`, `ativo`, `data_cadastro`, `data_atualizacao`) VALUES
(1, 'Administrador', 'admin@biblioteca.com', '$2y$10$EvjOwg0WOsL0/YzllaWeP.7qCtfGvWwcTR/t3/4GPqHJYnuldZnsy', '324.680.530-01', '+55 51 98999-9998', 'administrador', 1, '2025-11-03 21:24:30', '2025-11-14 00:59:52'),
(2, 'Bibliotecário', 'bibliotecario@biblioteca.com', '$2y$10$gyerEJDP5m7TiQlt8C5ni.znEWcF3Sg5edpzUwRkYGqjgiwsRRhyi', '029.365.890-02', '+55 51 99899-9999', 'bibliotecario', 1, '2025-11-06 19:15:50', '2025-11-06 19:15:50'),
(3, 'Usuário', 'usuario@biblioteca.com', '$2y$10$U7cgiYaa/DH2hWt3Ah6Vi.jsxon3k5DMeCBapqHRgCdFHwcomaJse', '522.067.500-15', '+55 51 99989-9999', 'usuario', 1, '2025-11-06 19:16:45', '2025-11-06 19:16:45');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `idx_titulo` (`titulo`),
  ADD KEY `idx_autor` (`autor`),
  ADD KEY `idx_isbn` (`isbn`),
  ADD KEY `idx_genero` (`genero`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bibliotecario_retirada_id` (`bibliotecario_retirada_id`),
  ADD KEY `bibliotecario_devolucao_id` (`bibliotecario_devolucao_id`),
  ADD KEY `idx_usuario` (`usuario_id`),
  ADD KEY `idx_livro` (`livro_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_data_reserva` (`data_reserva`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_perfil` (`perfil`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`bibliotecario_retirada_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservas_ibfk_4` FOREIGN KEY (`bibliotecario_devolucao_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;