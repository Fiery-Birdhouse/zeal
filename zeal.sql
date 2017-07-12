SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `zeal` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `zeal`;

CREATE TABLE `Livros` (
  `codLivro` int(11) NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `titulo` varchar(300) NOT NULL,
  `descricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Usuarios` (
  `codUsuario` int(11) NOT NULL,
  `usuario` varchar(32) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `token` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `Livros`
  ADD PRIMARY KEY (`codLivro`),
  ADD KEY `fk_codUsuario_Usuarios_Livros` (`codUsuario`);

ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`codUsuario`);


ALTER TABLE `Livros`
  MODIFY `codLivro` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `Usuarios`
  MODIFY `codUsuario` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Livros`
  ADD CONSTRAINT `codUsuario_Usuarios_Livros` FOREIGN KEY (`codUsuario`) REFERENCES `Usuarios` (`codUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
