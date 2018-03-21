-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 21/03/2018 às 03:09
-- Versão do servidor: 5.7.21-0ubuntu0.16.04.1
-- Versão do PHP: 7.0.25-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `forumufba`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `essays`
--

CREATE TABLE `essays` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `conteudo` text,
  `posicao` int(11) DEFAULT '0' COMMENT '1 - favor0 - neutro-1 - contra',
  `id_publication` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `essays`
--

INSERT INTO `essays` (`id`, `titulo`, `conteudo`, `posicao`, `id_publication`, `id_user`) VALUES
  (4, 'Edit Contra', '<p>Contra</p>\r\n', -1, 1, 6),
  (5, 'O que é Lorem Ipsum?', '<p><strong>Lorem Ipsum</strong>&nbsp;&eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu n&atilde;o s&oacute; a cinco s&eacute;culos, como tamb&eacute;m ao salto para a editora&ccedil;&atilde;o eletr&ocirc;nica, permanecendo essencialmente inalterado. Se popularizou na d&eacute;cada de 60, quando a Letraset lan&ccedil;ou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editora&ccedil;&atilde;o eletr&ocirc;nica como Aldus PageMaker.</p>\r\n', 0, 1, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `essay_avaliation`
--

CREATE TABLE `essay_avaliation` (
  `id` int(11) NOT NULL,
  `avaliacao` int(11) DEFAULT NULL COMMENT '1 : positiva | (-1) : negativa\n',
  `id_essay` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `essay_avaliation`
--

INSERT INTO `essay_avaliation` (`id`, `avaliacao`, `id_essay`, `id_user`) VALUES
  (28, -1, 4, 5),
  (29, 1, 5, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `essay_link`
--

CREATE TABLE `essay_link` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `id_essay` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `essay_link`
--

INSERT INTO `essay_link` (`id`, `url`, `id_essay`) VALUES
  (4, 'link Coontra', 4),
  (5, 'https://br.lipsum.com', 5),
  (6, '', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `essay_oposition`
--

CREATE TABLE `essay_oposition` (
  `id` int(11) NOT NULL,
  `id_essay` int(11) DEFAULT NULL,
  `id_essay_oposition` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `tema` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `titulo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conteudo` text COLLATE utf8_unicode_ci,
  `visivel` int(11) DEFAULT NULL COMMENT '0 - nao visivel\n1 - visivel\n',
  `data` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `clicks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `publications`
--

INSERT INTO `publications` (`id`, `tema`, `titulo`, `conteudo`, `visivel`, `data`, `id_user`, `clicks`) VALUES
  (1, 'Lorem Ipsum', 'O que é Lorem Ipsum?', '<p><strong>Lorem Ipsum</strong>&nbsp;&eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu n&atilde;o s&oacute; a cinco s&eacute;culos, como tamb&eacute;m ao salto para a editora&ccedil;&atilde;o eletr&ocirc;nica, permanecendo essencialmente inalterado. Se popularizou na d&eacute;cada de 60, quando a Letraset lan&ccedil;ou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editora&ccedil;&atilde;o eletr&ocirc;nica como Aldus PageMaker.</p>\r\n', 1, '2018-03-08', 5, 285);

-- --------------------------------------------------------

--
-- Estrutura para tabela `publication_references`
--

CREATE TABLE `publication_references` (
  `id` int(11) NOT NULL,
  `origem` varchar(255) DEFAULT NULL COMMENT 'Texto livre para colocar livros ou links de outras publicações\n',
  `id_publication` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `id_essay` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `conteudo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `graduacao` varchar(255) DEFAULT NULL COMMENT 'Texto livre para informar graduação do usuário\n',
  `dtnasc` date DEFAULT NULL COMMENT 'Data de nascimento\n',
  `urlfoto` varchar(255) DEFAULT NULL,
  `pontos` int(11) DEFAULT '0',
  `tipo` int(11) DEFAULT NULL COMMENT '1 - admin\n2 - usuario\n',
  `verificado` tinyint(1) DEFAULT '0',
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `password`, `graduacao`, `dtnasc`, `urlfoto`, `pontos`, `tipo`, `verificado`, `ativo`) VALUES
  (5, 'Administrador', 'admin@kylb.xyz', '$2y$10$SoKBrmMmKmLhQmtLOIyzGOwEG8OPbz.a8U6vgb2YC.WyD6J4smWq6', 'Graduando em Ciências da Computação', '1990-02-12', NULL, 1, 1, 0, 1),
  (6, 'Comum', 'comum@kylb.xyz', '$2y$10$cq21/F9gRwlVJS8Z/Yo5R.4tFajYXmevypWjuliwqRyD2yAqTo54C', 'Nenhuma', '1990-02-12', NULL, -1, 2, 0, 1);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `essays`
--
ALTER TABLE `essays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_essays_1_idx` (`id_publication`),
  ADD KEY `fk_essays_2_idx` (`id_user`);

--
-- Índices de tabela `essay_avaliation`
--
ALTER TABLE `essay_avaliation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index4` (`id_user`,`id_essay`),
  ADD KEY `fk_essay_avaliation_1_idx` (`id_essay`);

--
-- Índices de tabela `essay_link`
--
ALTER TABLE `essay_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_essay_link_1_idx` (`id_essay`);

--
-- Índices de tabela `essay_oposition`
--
ALTER TABLE `essay_oposition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_essay_oposition_1_idx` (`id_essay`),
  ADD KEY `fk_essay_oposition_2_idx` (`id_essay_oposition`);

--
-- Índices de tabela `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_publications_1_idx` (`id_user`);

--
-- Índices de tabela `publication_references`
--
ALTER TABLE `publication_references`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_references_1_idx` (`id_publication`);

--
-- Índices de tabela `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reports_1_idx` (`id_essay`),
  ADD KEY `fk_reports_2_idx` (`id_user`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index2` (`email`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `essays`
--
ALTER TABLE `essays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de tabela `essay_avaliation`
--
ALTER TABLE `essay_avaliation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de tabela `essay_link`
--
ALTER TABLE `essay_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de tabela `essay_oposition`
--
ALTER TABLE `essay_oposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `publication_references`
--
ALTER TABLE `publication_references`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de tabela `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `essays`
--
ALTER TABLE `essays`
  ADD CONSTRAINT `fk_essays_1` FOREIGN KEY (`id_publication`) REFERENCES `publications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_essays_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `essay_avaliation`
--
ALTER TABLE `essay_avaliation`
  ADD CONSTRAINT `fk_essay_avaliation_1` FOREIGN KEY (`id_essay`) REFERENCES `essays` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_essay_avaliation_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `essay_link`
--
ALTER TABLE `essay_link`
  ADD CONSTRAINT `fk_essay_link_1` FOREIGN KEY (`id_essay`) REFERENCES `essays` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `essay_oposition`
--
ALTER TABLE `essay_oposition`
  ADD CONSTRAINT `fk_essay_oposition_1` FOREIGN KEY (`id_essay`) REFERENCES `essays` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_essay_oposition_2` FOREIGN KEY (`id_essay_oposition`) REFERENCES `essays` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `fk_publications_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `publication_references`
--
ALTER TABLE `publication_references`
  ADD CONSTRAINT `fk_references_1` FOREIGN KEY (`id_publication`) REFERENCES `publications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `fk_reports_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;