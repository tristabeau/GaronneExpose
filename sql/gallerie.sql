-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 10 Septembre 2014 à 07:27
-- Version du serveur :  5.1.73-1
-- Version de PHP :  5.3.3-7+squeeze19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gallerie`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `idarticle` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(150) NOT NULL,
  `date` varchar(10) NOT NULL,
  `annee` varchar(4) NOT NULL,
  `mois` varchar(2) NOT NULL,
  `jour` varchar(2) NOT NULL,
  `heure` varchar(5) NOT NULL,
  `contenu` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `nb_vues` smallint(4) NOT NULL,
  `vedette` tinyint(1) NOT NULL DEFAULT '0',
  `publie` tinyint(1) NOT NULL DEFAULT '0',
  `permalien` varchar(200) NOT NULL,
  `fk_idmembre` int(11) NOT NULL,
  `fk_idcategorie` int(11) NOT NULL,
  `corrige` tinyint(1) NOT NULL DEFAULT '0',
  `rapport` text NOT NULL,
  `correcteur` varchar(50) NOT NULL,
  PRIMARY KEY (`idarticle`),
  KEY `fk_idmembre` (`fk_idmembre`),
  KEY `fk_idcategorie` (`fk_idcategorie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `idcategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `tag` varchar(5) NOT NULL,
  `pere_idcategorie` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcategorie`),
  KEY `pere_idcategorie` (`pere_idcategorie`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`idcategorie`, `nom`, `tag`, `pere_idcategorie`) VALUES
(1, 'Informations', 'INFOR', NULL),
(2, 'Peinture', 'PEINT', 0),
(3, 'Évènement', 'EVENE', 0);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `idgroupe` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`idgroupe`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`idgroupe`, `nom`) VALUES
(4, 'Artiste'),
(3, 'Bureau'),
(2, 'Inscrit'),
(1, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `idmembre` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(32) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `descr` text NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `twitter` varchar(50) NOT NULL,
  `google` varchar(50) NOT NULL,
  `site` varchar(150) NOT NULL,
  `image` varchar(250) NOT NULL,
  `salt` varchar(5) NOT NULL,
  `mail` varchar(150) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activation` varchar(20) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `fk_idgroupe` int(11) NOT NULL,
  PRIMARY KEY (`idmembre`),
  KEY `fk_idgroupe` (`fk_idgroupe`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`idmembre`, `pseudo`, `mdp`, `age`, `descr`, `facebook`, `twitter`, `google`, `site`, `image`, `salt`, `mail`, `active`, `activation`, `titre`, `fk_idgroupe`) VALUES
(1, 'Admin', 'b156df20f91f3bb5e682df5a726c86d6', 0, '', '', '', '', '', '', 'muN6Z', '', 1, '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `nb_vues`
--

CREATE TABLE IF NOT EXISTS `nb_vues` (
  `ip` varchar(30) NOT NULL,
  `fk_idarticle` int(11) NOT NULL,
  PRIMARY KEY (`ip`,`fk_idarticle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `partenaire`
--

CREATE TABLE IF NOT EXISTS `partenaire` (
  `idpartenaire` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(250) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `site` varchar(150) NOT NULL,
  PRIMARY KEY (`idpartenaire`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `presse`
--

CREATE TABLE IF NOT EXISTS `presse` (
  `idpresse` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`idpresse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
