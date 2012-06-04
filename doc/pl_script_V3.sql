-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 04 Juin 2012 à 15:15
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `project-leader`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

CREATE TABLE IF NOT EXISTS `appartenir` (
  `cat_id_pere` int(8) NOT NULL,
  `cat_id_fils` int(8) NOT NULL,
  PRIMARY KEY (`cat_id_pere`,`cat_id_fils`),
  KEY `fk_appertenir2` (`cat_id_fils`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `appartenir`
--

INSERT INTO `appartenir` (`cat_id_pere`, `cat_id_fils`) VALUES
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(3, 36),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(3, 41),
(4, 42),
(4, 43),
(4, 44),
(4, 45),
(4, 46),
(4, 47),
(4, 48),
(4, 49),
(4, 50),
(4, 51),
(4, 52),
(4, 53),
(4, 54),
(4, 55),
(4, 56);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_libelle` varchar(100) DEFAULT NULL,
  `cat_description` text,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`cat_id`, `cat_libelle`, `cat_description`) VALUES
(1, 'Developpement web / Software', NULL),
(2, 'Mobile', NULL),
(3, 'Base de données', NULL),
(4, 'Design', NULL),
(5, 'Programmation C', NULL),
(6, 'Programmation C#', NULL),
(7, 'Programmation C++', NULL),
(8, 'PHP', NULL),
(9, '.NET', NULL),
(10, 'HTML 5', NULL),
(11, 'AJAX', NULL),
(12, 'Javascript', NULL),
(13, 'ASP', NULL),
(14, 'Joomla', NULL),
(15, 'Delphi', NULL),
(16, 'Java', NULL),
(17, 'JSP', NULL),
(18, 'Python', NULL),
(19, 'Sharepoint', NULL),
(20, 'Perl', NULL),
(21, 'Android', NULL),
(22, 'BlackBerry', NULL),
(23, 'IPhone', NULL),
(24, 'IPad', NULL),
(25, 'Objective C', NULL),
(26, 'J2ME', NULL),
(27, 'Nokia', NULL),
(28, 'Samsung', NULL),
(29, 'Amazon Kindle', NULL),
(30, 'Palm', NULL),
(31, 'Symbian', NULL),
(32, 'WebOS', NULL),
(33, 'Windows Mobile', NULL),
(34, 'Windows Phone', NULL),
(35, 'Geolocalisation', NULL),
(36, 'Microsoft SQL Server 2005', NULL),
(37, 'Microsoft SQL Server 2008', NULL),
(38, 'phpMyAdmin', NULL),
(39, 'Oracle', NULL),
(40, 'Access', NULL),
(41, 'PostGreSQL', NULL),
(42, 'Animation 3D', NULL),
(43, 'ActionScript', NULL),
(44, 'Flash', NULL),
(45, 'Flash 3D', NULL),
(46, 'Flex', NULL),
(47, 'CSS', NULL),
(48, 'DreamWeaver', NULL),
(49, 'Balsamiq', NULL),
(50, 'Google SketchUp', NULL),
(51, 'Design icones', NULL),
(52, 'Illustrator', NULL),
(53, 'InDesign', NULL),
(54, 'PhotoShop', NULL),
(55, 'Template', NULL),
(56, 'Prezi', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

CREATE TABLE IF NOT EXISTS `competence` (
  `cpt_id` int(8) NOT NULL AUTO_INCREMENT,
  `cpt_libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cpt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `competence`
--

INSERT INTO `competence` (`cpt_id`, `cpt_libelle`) VALUES
(1, 'PHP'),
(2, 'Ruby');

-- --------------------------------------------------------

--
-- Structure de la table `correspondre`
--

CREATE TABLE IF NOT EXISTS `correspondre` (
  `prj_id` int(8) NOT NULL,
  `cat_id` int(8) NOT NULL,
  PRIMARY KEY (`prj_id`,`cat_id`),
  KEY `fk_correspondre2` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `correspondre`
--

INSERT INTO `correspondre` (`prj_id`, `cat_id`) VALUES
(1, 6),
(4, 6),
(7, 6),
(2, 27),
(9, 27),
(10, 27),
(3, 39),
(5, 39),
(6, 39),
(8, 39);

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

CREATE TABLE IF NOT EXISTS `cv` (
  `cv_id` int(8) NOT NULL AUTO_INCREMENT,
  `uti_id` int(8) NOT NULL,
  `cv_lien` varchar(256) DEFAULT NULL,
  `cv_date` datetime DEFAULT NULL,
  PRIMARY KEY (`cv_id`),
  KEY `fk_renseigner` (`uti_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `cv`
--


-- --------------------------------------------------------

--
-- Structure de la table `demander`
--

CREATE TABLE IF NOT EXISTS `demander` (
  `prj_id` int(8) NOT NULL,
  `cpt_id` int(8) NOT NULL,
  PRIMARY KEY (`prj_id`,`cpt_id`),
  KEY `fk_demander2` (`cpt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `demander`
--

INSERT INTO `demander` (`prj_id`, `cpt_id`) VALUES
(1, 1),
(4, 1),
(7, 1),
(9, 1),
(10, 1),
(2, 2),
(3, 2),
(5, 2),
(6, 2),
(8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE IF NOT EXISTS `etat` (
  `eta_id` int(8) NOT NULL AUTO_INCREMENT,
  `eta_libelle` varchar(100) DEFAULT NULL,
  `eta_date` datetime DEFAULT NULL,
  PRIMARY KEY (`eta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `etat`
--

INSERT INTO `etat` (`eta_id`, `eta_libelle`, `eta_date`) VALUES
(1, 'Nouveau', NULL),
(2, 'En cours', NULL),
(3, 'Fermé', NULL),
(4, 'Rejeté', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

CREATE TABLE IF NOT EXISTS `participer` (
  `prj_id` int(8) NOT NULL,
  `uti_id` int(8) NOT NULL,
  `par_date` datetime DEFAULT NULL,
  PRIMARY KEY (`prj_id`,`uti_id`),
  KEY `fk_participer2` (`uti_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `participer`
--

INSERT INTO `participer` (`prj_id`, `uti_id`, `par_date`) VALUES
(1, 1, '2012-04-09 13:13:34'),
(2, 1, '2012-04-09 13:13:40'),
(3, 2, '2012-04-09 22:49:18'),
(4, 1, '2012-04-09 23:06:33'),
(5, 1, '2012-04-09 23:25:18'),
(6, 2, '2012-04-09 23:36:06'),
(7, 1, '2012-04-09 23:41:37'),
(8, 2, '2012-04-09 23:45:21'),
(9, 1, '2012-04-14 23:22:13'),
(10, 2, '2012-04-14 14:17:18');

-- --------------------------------------------------------

--
-- Structure de la table `posseder`
--

CREATE TABLE IF NOT EXISTS `posseder` (
  `cpt_id` int(8) NOT NULL,
  `uti_id` int(8) NOT NULL,
  PRIMARY KEY (`cpt_id`,`uti_id`),
  KEY `fk_posseder2` (`uti_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `posseder`
--


-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE IF NOT EXISTS `projet` (
  `prj_id` int(8) NOT NULL AUTO_INCREMENT,
  `eta_id` int(8) NOT NULL,
  `prj_libelle` varchar(100) DEFAULT NULL,
  `prj_date` datetime DEFAULT NULL,
  `prj_budget` int(11) DEFAULT NULL,
  `prj_echeance` int(11) DEFAULT NULL,
  `prj_description` text,
  PRIMARY KEY (`prj_id`),
  KEY `fk_etat` (`eta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`prj_id`, `eta_id`, `prj_libelle`, `prj_date`, `prj_budget`, `prj_echeance`, `prj_description`) VALUES
(1, 1, 'project-leader', '2012-04-09 13:13:34', 5000, 0, 'site de gestion de projets'),
(2, 1, '12 monkeys', '2012-04-09 23:06:33', 454, 0, '12 monkeys'),
(3, 1, 'machete', '2012-04-09 23:06:35', 454, 0, 'machete'),
(4, 1, 'mr. brooks', '2012-04-09 22:49:18', 300, 0, 'mr. brooks'),
(5, 1, 'bliss', '2012-04-09 23:25:18', 4000, 0, 'bliss'),
(6, 1, 'crash', '2012-04-09 23:36:06', 300, 300, 'crash'),
(7, 2, 'the killer', '2012-04-09 23:39:20', 434, 34, 'the killer'),
(8, 3, 'blade runner', '2012-04-09 23:45:21', 32, 32, 'blade runner'),
(9, 3, 'le diable boiteux', '2012-04-14 23:22:13', 4, 6, 'le diable boiteux'),
(10, 4, 'spaceballs', '2012-04-14 23:31:52', 5, 5, 'spaceballs');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `uti_id` int(8) NOT NULL AUTO_INCREMENT,
  `uti_login` varchar(100) DEFAULT NULL,
  `uti_statut` varchar(100) DEFAULT NULL,
  `uti_mail` varchar(100) DEFAULT NULL,
  `uti_mdp` varchar(256) DEFAULT NULL,
  `uti_nom` varchar(100) DEFAULT NULL,
  `uti_prenom` varchar(100) DEFAULT NULL,
  `uti_ddn` date DEFAULT NULL,
  `uti_adresse` varchar(256) DEFAULT NULL,
  `uti_cp` varchar(5) DEFAULT NULL,
  `uti_ville` varchar(100) DEFAULT NULL,
  `uti_tel` varchar(20) DEFAULT NULL,
  `uti_presentation` varchar(256) DEFAULT NULL,
  `uti_date` datetime DEFAULT NULL,
  `uti_ddc` datetime DEFAULT NULL,
  PRIMARY KEY (`uti_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`uti_id`, `uti_login`, `uti_statut`, `uti_mail`, `uti_mdp`, `uti_nom`, `uti_prenom`, `uti_ddn`, `uti_adresse`, `uti_cp`, `uti_ville`, `uti_tel`, `uti_presentation`, `uti_date`, `uti_ddc`) VALUES
(1, 'vyros', 'client', 'vyros', 'vyros', '', '', '0000-00-00', '', '', '', '', '', '2012-04-09 13:12:21', NULL),
(2, 'varius', 'prestataire', 'varius', 'varius', '', '', '0000-00-00', '', '', '', '', '', '2012-04-09 18:57:13', NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD CONSTRAINT `fk_appertenir` FOREIGN KEY (`cat_id_pere`) REFERENCES `categorie` (`cat_id`),
  ADD CONSTRAINT `fk_appertenir2` FOREIGN KEY (`cat_id_fils`) REFERENCES `categorie` (`cat_id`);

--
-- Contraintes pour la table `correspondre`
--
ALTER TABLE `correspondre`
  ADD CONSTRAINT `fk_correspondre` FOREIGN KEY (`prj_id`) REFERENCES `projet` (`prj_id`),
  ADD CONSTRAINT `fk_correspondre2` FOREIGN KEY (`cat_id`) REFERENCES `categorie` (`cat_id`);

--
-- Contraintes pour la table `cv`
--
ALTER TABLE `cv`
  ADD CONSTRAINT `fk_renseigner` FOREIGN KEY (`uti_id`) REFERENCES `utilisateur` (`uti_id`);

--
-- Contraintes pour la table `demander`
--
ALTER TABLE `demander`
  ADD CONSTRAINT `fk_demander` FOREIGN KEY (`prj_id`) REFERENCES `projet` (`prj_id`),
  ADD CONSTRAINT `fk_demander2` FOREIGN KEY (`cpt_id`) REFERENCES `competence` (`cpt_id`);

--
-- Contraintes pour la table `participer`
--
ALTER TABLE `participer`
  ADD CONSTRAINT `fk_participer` FOREIGN KEY (`prj_id`) REFERENCES `projet` (`prj_id`),
  ADD CONSTRAINT `fk_participer2` FOREIGN KEY (`uti_id`) REFERENCES `utilisateur` (`uti_id`);

--
-- Contraintes pour la table `posseder`
--
ALTER TABLE `posseder`
  ADD CONSTRAINT `fk_posseder` FOREIGN KEY (`cpt_id`) REFERENCES `competence` (`cpt_id`),
  ADD CONSTRAINT `fk_posseder2` FOREIGN KEY (`uti_id`) REFERENCES `utilisateur` (`uti_id`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `fk_etat` FOREIGN KEY (`eta_id`) REFERENCES `etat` (`eta_id`);
