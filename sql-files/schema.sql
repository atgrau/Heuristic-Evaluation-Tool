-- --------------------------------------------------------
-- Host:                         51.68.226.246
-- Versión del servidor:         5.7.23-0ubuntu0.18.04.1 - (Ubuntu)
-- SO del servidor:              Linux
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para heuristic_evaluation
CREATE DATABASE IF NOT EXISTS `heuristic_evaluation` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `heuristic_evaluation`;

-- Volcando estructura para tabla heuristic_evaluation.answersbytemplate
CREATE TABLE IF NOT EXISTS `answersbytemplate` (
  `idTemplate` int(11) NOT NULL,
  `idAnswer` int(11) NOT NULL,
  PRIMARY KEY (`idTemplate`,`idAnswer`),
  KEY `idAnswer` (`idAnswer`),
  KEY `idTemplate` (`idTemplate`),
  CONSTRAINT `FK_idAnswer` FOREIGN KEY (`idAnswer`) REFERENCES `template_answers` (`ID`),
  CONSTRAINT `FK_idTemplateAns` FOREIGN KEY (`idTemplate`) REFERENCES `templates` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.categoriesbytemplate
CREATE TABLE IF NOT EXISTS `categoriesbytemplate` (
  `idTemplate` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  PRIMARY KEY (`idTemplate`,`idCategory`),
  KEY `idTemplate` (`idTemplate`),
  KEY `idCategory` (`idCategory`),
  CONSTRAINT `FK_idCategory` FOREIGN KEY (`idCategory`) REFERENCES `template_categories` (`ID`),
  CONSTRAINT `FK_idTemplateCat` FOREIGN KEY (`idTemplate`) REFERENCES `templates` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.content_entries
CREATE TABLE IF NOT EXISTS `content_entries` (
  `ID` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `content` longtext COLLATE latin1_spanish_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `iso` varchar(2) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.evaluations
CREATE TABLE IF NOT EXISTS `evaluations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `finished` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`ID`),
  KEY `FK_IdProject` (`id_project`),
  KEY `FK_idUser` (`id_user`),
  CONSTRAINT `FK_IdProject` FOREIGN KEY (`id_project`) REFERENCES `projects` (`ID`),
  CONSTRAINT `FK_idUser` FOREIGN KEY (`id_user`) REFERENCES `users` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='Contains all evaluations of all projects';

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.evaluation_results
CREATE TABLE IF NOT EXISTS `evaluation_results` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_evaluation` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_answer` int(11) NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_EVALUATION` (`id_evaluation`),
  KEY `FK_QUESTION` (`id_question`),
  KEY `FK_ANSWER` (`id_answer`),
  CONSTRAINT `FK_ANSWER` FOREIGN KEY (`id_answer`) REFERENCES `template_answers` (`ID`),
  CONSTRAINT `FK_EVALUATION` FOREIGN KEY (`id_evaluation`) REFERENCES `evaluations` (`ID`),
  CONSTRAINT `FK_QUESTION` FOREIGN KEY (`id_question`) REFERENCES `template_questions` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2450 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `active` bit(1) NOT NULL DEFAULT b'0',
  `id_user` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `finish_date` date NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  `creation_date` date NOT NULL,
  `id_template` int(11) NOT NULL,
  `archived` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`ID`),
  KEY `FK_TEMPLATE` (`id_template`),
  KEY `FK_USER_PROJECT` (`id_user`),
  CONSTRAINT `FK_TEMPLATE` FOREIGN KEY (`id_template`) REFERENCES `templates` (`ID`),
  CONSTRAINT `FK_USER_PROJECT` FOREIGN KEY (`id_user`) REFERENCES `users` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.projects_user
CREATE TABLE IF NOT EXISTS `projects_user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_PROJECT` (`id_project`),
  KEY `FK_USER` (`id_user`),
  CONSTRAINT `FKProject` FOREIGN KEY (`id_project`) REFERENCES `projects` (`ID`),
  CONSTRAINT `FKUser` FOREIGN KEY (`id_user`) REFERENCES `users` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.questionsbytemplate
CREATE TABLE IF NOT EXISTS `questionsbytemplate` (
  `idTemplate` int(11) NOT NULL,
  `idQuestion` int(11) NOT NULL,
  PRIMARY KEY (`idTemplate`,`idQuestion`),
  KEY `idTemplate` (`idTemplate`),
  KEY `idQuestion` (`idQuestion`),
  CONSTRAINT `FK_idQuestion` FOREIGN KEY (`idQuestion`) REFERENCES `template_questions` (`ID`),
  CONSTRAINT `FK_idTemplateQues` FOREIGN KEY (`idTemplate`) REFERENCES `templates` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.templates
CREATE TABLE IF NOT EXISTS `templates` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.template_answers
CREATE TABLE IF NOT EXISTS `template_answers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `answer` varchar(40) NOT NULL,
  `value` float NOT NULL DEFAULT '0',
  `original` bit(1) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.template_categories
CREATE TABLE IF NOT EXISTS `template_categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `original` bit(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.template_questions
CREATE TABLE IF NOT EXISTS `template_questions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `question` varchar(200) NOT NULL,
  `original` bit(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idCategoryQuestion` (`id_category`),
  CONSTRAINT `idCategoryQuestion` FOREIGN KEY (`id_category`) REFERENCES `template_categories` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla heuristic_evaluation.users
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL DEFAULT '0',
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `entity` varchar(50) DEFAULT NULL,
  `country` varchar(2) DEFAULT NULL,
  `gender` int(11) DEFAULT '0',
  `token` varchar(32) DEFAULT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
