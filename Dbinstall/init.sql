-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 21 Avril 2016 à 21:46
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
  `root_step` int(11) NOT NULL,
  PRIMARY KEY (`id_instance`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `unit_metric` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_metric`),
  KEY `id_instance` (`id_instance`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `check_random_code` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_step`),
  KEY `id_instance` (`id_instance`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  KEY `rule_id` (`rule_id`),
  KEY `id_step_target` (`id_step_target`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `fsf_user`
--

CREATE TABLE IF NOT EXISTS `fsf_user` (
  `login_user` varchar(255) NOT NULL,
  `id_instance` int(11) NOT NULL,
  `id_step` int(11) NOT NULL,
  `check_activate` tinyint(1) NOT NULL DEFAULT '0',
  `way_user` text NOT NULL,
  PRIMARY KEY (`login_user`,`id_instance`),
  KEY `id_step` (`id_step`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
