-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 14 Avril 2016 à 00:16
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `fsf`
--

-- --------------------------------------------------------

--
-- Structure de la table `fsf_instance`
--

CREATE TABLE IF NOT EXISTS `fsf_instance` (
  `id_instance` int(11) NOT NULL AUTO_INCREMENT,
  `name_instance` varchar(255) NOT NULL,
  PRIMARY KEY (`id_instance`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `fsf_instance`
--

INSERT INTO `fsf_instance` (`id_instance`, `name_instance`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `fsf_metric`
--

CREATE TABLE IF NOT EXISTS `fsf_metric` (
  `id_metric` int(11) NOT NULL AUTO_INCREMENT,
  `id_instance` int(11) NOT NULL,
  `name_metric` varchar(255) NOT NULL,
  `default_value` int(11) NOT NULL,
  `max_value` int(11) NOT NULL,
  `min_value` int(11) NOT NULL,
  `low_value` int(11) NOT NULL,
  `high_value` int(11) NOT NULL,
  PRIMARY KEY (`id_metric`),
  KEY `id_instance` (`id_instance`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `fsf_metric`
--

INSERT INTO `fsf_metric` (`id_metric`, `id_instance`, `name_metric`, `default_value`, `max_value`, `min_value`, `low_value`, `high_value`) VALUES
(1, 1, 'sant&eacute;', 90, 100, 0, 20, 80),
(2, 1, 'argent', 50, 1000000, 0, 20, 1000);

-- --------------------------------------------------------

--
-- Structure de la table `fsf_rule`
--

CREATE TABLE IF NOT EXISTS `fsf_rule` (
  `rule_id` varchar(50) NOT NULL,
  `id_instance` int(11) NOT NULL,
  `rule_content` text NOT NULL,
  PRIMARY KEY (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fsf_rule`
--

INSERT INTO `fsf_rule` (`rule_id`, `id_instance`, `rule_content`) VALUES
('GOOD_HEALTH', 1, 'SELECT \r\nCASE value\r\n  WHEN > 79 THEN ''1''\r\n  ELSE ''0''\r\nEND\r\nFROM fsf_user_metric\r\nWHERE id_metric = 1\r\nAND login_user = &login');

-- --------------------------------------------------------

--
-- Structure de la table `fsf_step`
--

CREATE TABLE IF NOT EXISTS `fsf_step` (
  `id_step` int(11) NOT NULL AUTO_INCREMENT,
  `id_instance` int(11) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `variation_metrics` varchar(255) NOT NULL,
  PRIMARY KEY (`id_step`),
  KEY `id_instance` (`id_instance`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `fsf_step`
--

INSERT INTO `fsf_step` (`id_step`, `id_instance`, `summary`, `text`, `variation_metrics`) VALUES
(1, 1, 'Debut de l''aventure', 'Lundi matin : Le r&eacute;veil sonne, une nouvelle semaine va commencer.', '0;0'),
(2, 1, 'Route en voiture', 'Route en voiture', ''),
(3, 1, 'Route en m&eacute;tro', 'Route en m&eacute;tro', '0;0');

-- --------------------------------------------------------

--
-- Structure de la table `fsf_step_link`
--

CREATE TABLE IF NOT EXISTS `fsf_step_link` (
  `id_step_origin` int(11) NOT NULL,
  `id_step_target` int(11) NOT NULL,
  `text_link` varchar(255) NOT NULL,
  `rule_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id_step_origin`,`id_step_target`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fsf_step_link`
--

INSERT INTO `fsf_step_link` (`id_step_origin`, `id_step_target`, `text_link`, `rule_id`) VALUES
(1, 2, 'Zou en voiture', ''),
(1, 3, 'Go en m&eacute;tro', '');

-- --------------------------------------------------------

--
-- Structure de la table `fsf_user`
--

CREATE TABLE IF NOT EXISTS `fsf_user` (
  `login_user` varchar(255) NOT NULL,
  `id_instance` int(11) NOT NULL,
  `id_step` int(11) NOT NULL,
  PRIMARY KEY (`login_user`,`id_instance`),
  KEY `id_step` (`id_step`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fsf_user`
--

INSERT INTO `fsf_user` (`login_user`, `id_instance`, `id_step`) VALUES
('flo', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `fsf_user_metric`
--

CREATE TABLE IF NOT EXISTS `fsf_user_metric` (
  `login_user` varchar(255) NOT NULL,
  `id_metric` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`login_user`,`id_metric`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fsf_user_metric`
--

INSERT INTO `fsf_user_metric` (`login_user`, `id_metric`, `value`) VALUES
('flo', 1, 100);
