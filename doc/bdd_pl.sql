-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 02 Avril 2012 à 10:00
-- Version du serveur: 4.1.22
-- Version de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `bdd_pl`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_id` int(11) NOT NULL auto_increment,
  `categorie_libelle` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`categorie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `categorie_libelle`) VALUES
(1, 'Site Internet'),
(2, 'Application Mobile');

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

CREATE TABLE IF NOT EXISTS `competence` (
  `competence_id` int(11) NOT NULL auto_increment,
  `competence_libelle` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`competence_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `competence`
--

INSERT INTO `competence` (`competence_id`, `competence_libelle`) VALUES
(1, 'PHP'),
(2, 'Ruby');

-- --------------------------------------------------------

--
-- Structure de la table `correspondre`
--

CREATE TABLE IF NOT EXISTS `correspondre` (
  `idProjet` int(11) NOT NULL default '0',
  `idCategorie` int(11) NOT NULL default '0',
  PRIMARY KEY  (`idProjet`,`idCategorie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `correspondre`
--

INSERT INTO `correspondre` (`idProjet`, `idCategorie`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `demander`
--

CREATE TABLE IF NOT EXISTS `demander` (
  `idProjet` int(11) NOT NULL default '0',
  `idCompetence` int(11) NOT NULL default '0',
  PRIMARY KEY  (`idProjet`,`idCompetence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `demander`
--

INSERT INTO `demander` (`idProjet`, `idCompetence`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

CREATE TABLE IF NOT EXISTS `participer` (
  `idProjet` int(11) NOT NULL default '0',
  `idUtilisateur` int(11) NOT NULL default '0',
  PRIMARY KEY  (`idProjet`,`idUtilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `participer`
--

INSERT INTO `participer` (`idProjet`, `idUtilisateur`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE IF NOT EXISTS `projet` (
  `projet_id` int(11) NOT NULL auto_increment,
  `projet_libelle` varchar(200) NOT NULL default '',
  `projet_description` text NOT NULL,
  `projet_budget` varchar(200) NOT NULL default '',
  `projet_delai` varchar(200) NOT NULL default '',
  `projet_dateCreation` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`projet_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`projet_id`, `projet_libelle`, `projet_description`, `projet_budget`, `projet_delai`, `projet_dateCreation`) VALUES
(1, 'doctest', 'teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestttttttttttttttttttttttttttttttttttttttttttttttttteez                                                                                                                 rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '250', '60', '2012-03-23');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `uti_id` int(11) NOT NULL auto_increment,
  `uti_login` varchar(200) NOT NULL default '',
  `uti_statut` varchar(200) NOT NULL default '',
  `uti_mail` varchar(200) NOT NULL default '',
  `uti_mdp` varchar(200) NOT NULL default '',
  `uti_nom` varchar(200) NOT NULL default '',
  `uti_prenom` varchar(200) NOT NULL default '',
  `uti_ddn` date NOT NULL default '0000-00-00',
  `uti_adresse` varchar(200) NOT NULL default '',
  `uti_cp` varchar(200) NOT NULL default '',
  `uti_ville` varchar(200) NOT NULL default '',
  `uti_tel` varchar(200) NOT NULL default '',
  `uti_presentation` text NOT NULL,
  `uti_dateInscription` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`uti_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`uti_id`, `uti_login`, `uti_statut`, `uti_mail`, `uti_mdp`, `uti_nom`, `uti_prenom`, `uti_ddn`, `uti_adresse`, `uti_cp`, `uti_ville`, `uti_tel`, `uti_presentation`, `uti_dateInscription`) VALUES
(1, 'testuser', 'client', 'mail', 'lolmpm', '', '', '0000-00-00', '', '', '', '', '', '0000-00-00'),
(2, 'testpresta', 'prestataire', 'mail', 'kiklol', '', '', '0000-00-00', '', '', '', '', '', '0000-00-00');
