-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 30 Mars 2018 à 22:06
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `clim_concept`
--

-- --------------------------------------------------------

--
-- Structure de la table `alert_checktoday`
--

CREATE TABLE IF NOT EXISTS `alert_checktoday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `countAlert` int(11) DEFAULT NULL,
  `dateLastCheck` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `alert_checktoday`
--

INSERT INTO `alert_checktoday` (`id`, `countAlert`, `dateLastCheck`) VALUES
(11, 1, 1522439444);

-- --------------------------------------------------------

--
-- Structure de la table `civility`
--

CREATE TABLE IF NOT EXISTS `civility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(20) NOT NULL,
  `business` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `civility`
--

INSERT INTO `civility` (`id`, `tag`, `business`) VALUES
(1, 'M', 0),
(2, 'Mme', 0),
(3, 'SARL', 1);

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `civilityId` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `postal` int(11) NOT NULL,
  `city` varchar(40) NOT NULL,
  `road` text NOT NULL,
  `tel` varchar(10) NOT NULL,
  `port` varchar(10) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `serial` varchar(20) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `com` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cl_number` (`serial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `customer`
--

INSERT INTO `customer` (`id`, `civilityId`, `name`, `firstName`, `postal`, `city`, `road`, `tel`, `port`, `mail`, `serial`, `contact`, `sub_id`, `com`, `status`) VALUES
(13, 1, 'djai', 'grzgz', 45180, 'zrgzrgrz', 'rzgrzgrzg', '0238882446', '', '', '1513', '', 0, 'gentil ou m&eacute;chant', 0),
(14, 1, 'test2 aefgaegeag ae aegea', '', 45130, '', '', '', '', '', '1514', '', 0, 'aefeafea', 0),
(15, 1, 'test3', '', 45902, '', '', '', '', '', '1515', '', 0, '', 0),
(16, 1, 'zrhzrhz', '', 54156, '', '', '', '', '', 'CL1516', '', 0, 'rghrzh', 0);

-- --------------------------------------------------------

--
-- Structure de la table `defaut`
--

CREATE TABLE IF NOT EXISTS `defaut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gazId` int(11) NOT NULL,
  `fournisseurId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `serial` varchar(40) DEFAULT NULL,
  `repere` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `equipment`
--

INSERT INTO `equipment` (`id`, `client_id`, `product_id`, `serial`, `repere`) VALUES
(9, 13, 11, '65151', NULL),
(8, 13, 9, NULL, NULL),
(7, 13, 9, NULL, NULL),
(6, 13, 11, NULL, NULL),
(10, 13, 9, NULL, NULL),
(11, 13, 11, NULL, NULL),
(12, 13, 12, '155', NULL),
(13, 14, 9, '4545', NULL),
(14, 14, 9, NULL, NULL),
(15, 15, 11, '1512', NULL),
(16, 15, 9, '512gzrg', NULL),
(17, 15, 9, NULL, NULL),
(18, 15, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `flu_bottle`
--

CREATE TABLE IF NOT EXISTS `flu_bottle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial` int(11) NOT NULL,
  `dateOfBuy` int(11) NOT NULL,
  `charge` int(11) DEFAULT NULL,
  `gazId` int(11) DEFAULT NULL,
  `typeId` int(11) NOT NULL,
  `fournisseurId` int(11) NOT NULL,
  `dateOfSell` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_newId` (`id`),
  UNIQUE KEY `unique_serial` (`serial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `flu_bottle`
--

INSERT INTO `flu_bottle` (`id`, `serial`, `dateOfBuy`, `charge`, `gazId`, `typeId`, `fournisseurId`, `dateOfSell`) VALUES
(12, 11111111, 1488139859, NULL, NULL, 3, 2, 1488226259),
(4, 51561, 1488227143, 9, 2, 1, 2, NULL),
(6, 51514, 1109538019, 9, 2, 1, 2, NULL),
(7, 5451, 1527439210, NULL, NULL, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `flu_gaz`
--

CREATE TABLE IF NOT EXISTS `flu_gaz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `flu_gaz`
--

INSERT INTO `flu_gaz` (`id`, `name`) VALUES
(2, 'R410A'),
(3, 'R407C'),
(10, 'R22');

-- --------------------------------------------------------

--
-- Structure de la table `flu_move`
--

CREATE TABLE IF NOT EXISTS `flu_move` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bottleId` int(11) NOT NULL,
  `serialFiche` int(11) DEFAULT NULL,
  `dateOfMove` int(11) NOT NULL,
  `chargeOut` float DEFAULT NULL,
  `chargeIn` float DEFAULT NULL,
  `gazId` int(11) NOT NULL,
  `customerId` int(11) DEFAULT NULL,
  `techId` int(11) NOT NULL,
  `equipmentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `flu_move`
--

INSERT INTO `flu_move` (`id`, `bottleId`, `serialFiche`, `dateOfMove`, `chargeOut`, `chargeIn`, `gazId`, `customerId`, `techId`, `equipmentId`) VALUES
(2, 20, 21, 22, 23, 24, 25, 26, 27, 27),
(3, 4, 31, 32, 33, 34, 35, 36, 37, 27),
(4, 3, 3, 3, 3, 3, 3, 3, 3, 3),
(12, 7, 5489615, 545641032, NULL, 5, 2, 14, 1, 14),
(11, 6, 75757, 1432017, 1, NULL, 2, 15, 1, 15),
(10, 7, 75757, 1432017, NULL, 2, 2, 15, 1, 15),
(9, 12, 11111111, 1109538019, 4, 4, 2, 15, 1, 15),
(13, 4, 5489615, 545641032, 4, NULL, 2, 14, 1, 14),
(14, 6, 1512, 1489514036, 4, NULL, 2, 14, 1, 13),
(15, 6, 1515, 1489514153, 4, NULL, 2, 14, 1, 13),
(16, 7, 573, 1521050494, NULL, 43.5, 2, 14, 2, 14),
(17, 4, 573, 1521050494, 2.4, NULL, 2, 14, 2, 14),
(18, 7, 57256, 1552846783, NULL, 45, 2, 14, 1, 13),
(19, 4, 57256, 1552846783, 14, NULL, 2, 14, 1, 13),
(20, 12, 515, 1490034483, NULL, 8, 2, 14, 1, 14),
(21, 6, 515, 1490034483, 5, NULL, 3, 14, 1, 14);

-- --------------------------------------------------------

--
-- Structure de la table `flu_stock`
--

CREATE TABLE IF NOT EXISTS `flu_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `gazId` int(11) NOT NULL,
  `charge` float DEFAULT NULL,
  `recup` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `flu_stock`
--

INSERT INTO `flu_stock` (`id`, `year`, `gazId`, `charge`, `recup`) VALUES
(1, 2012, 10, 4, 5),
(2, 2013, 2, 4, 4),
(8, 2016, 3, 12, 6),
(7, 2016, 2, 10, 5),
(5, 2017, 2, 55, 8),
(6, 2017, 3, 31, 8),
(9, 2017, 10, 24, 51);

-- --------------------------------------------------------

--
-- Structure de la table `flu_type`
--

CREATE TABLE IF NOT EXISTS `flu_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `flu_type`
--

INSERT INTO `flu_type` (`id`, `name`) VALUES
(1, 'charge'),
(2, 'récupération'),
(3, 'transfert');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `name`) VALUES
(2, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `history`
--

INSERT INTO `history` (`id`, `date`, `text`) VALUES
(16, 1515663965, 'rzhe(tehhtrej'),
(12, 1492024770, 'aegeagaeg\nae\ngaegae\ng\na\naeg'),
(13, 1493580228, '              &lt;p&gt;agaegaegaeg&lt;br&gt;\nag&lt;br&gt;\nae&lt;br&gt;\nge&lt;br&gt;\nagea&lt;br&gt;\n&lt;/p&gt;\n        test1');

-- --------------------------------------------------------

--
-- Structure de la table `history_link`
--

CREATE TABLE IF NOT EXISTS `history_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipmentId` int(11) NOT NULL,
  `historyId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Contenu de la table `history_link`
--

INSERT INTO `history_link` (`id`, `equipmentId`, `historyId`) VALUES
(1, 12, 7),
(2, 9, 7),
(3, 6, 7),
(4, 11, 7),
(5, 8, 7),
(6, 7, 7),
(7, 10, 7),
(8, 12, 8),
(9, 9, 8),
(10, 6, 8),
(11, 11, 8),
(12, 8, 8),
(13, 7, 8),
(14, 10, 8),
(15, 12, 12),
(16, 9, 12),
(17, 6, 12),
(18, 11, 12),
(19, 8, 12),
(20, 7, 12),
(21, 10, 12),
(22, 12, 13),
(23, 9, 13),
(24, 6, 13),
(25, 11, 13),
(26, 8, 13),
(27, 7, 13),
(28, 10, 13),
(29, 12, 14),
(30, 9, 14),
(31, 6, 14),
(32, 11, 14),
(33, 8, 14),
(34, 7, 14),
(35, 10, 14),
(36, 12, 15),
(37, 9, 15),
(38, 6, 16);

-- --------------------------------------------------------

--
-- Structure de la table `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `tech` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `level`
--

INSERT INTO `level` (`id`, `user_id`, `admin`, `tech`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mark`
--

CREATE TABLE IF NOT EXISTS `mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `mark`
--

INSERT INTO `mark` (`id`, `name`) VALUES
(1, 'Hitachi'),
(2, 'Daikin'),
(3, 'LG'),
(4, 'Panasonic'),
(6, 'Truc2'),
(8, 'Elokiti');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `mark` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `mark`, `category_id`) VALUES
(11, 'aefea', '<b>test</b>', 1, 0),
(10, 'actb', 'aaeba', 5, 18),
(9, 'egge', 'egeageavae \r\naefaf', 1, 19),
(12, 'chaudiere en mousse', 'aaevaeae ae va', 8, 18);

-- --------------------------------------------------------

--
-- Structure de la table `prod_category`
--

CREATE TABLE IF NOT EXISTS `prod_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` text NOT NULL,
  `frigo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `prod_category`
--

INSERT INTO `prod_category` (`id`, `name`, `description`, `frigo`) VALUES
(18, 'air/air', 'baeghg\r\nymiliy\r\nagea', 1);

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `timeAlert` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `status`
--

INSERT INTO `status` (`id`, `name`, `timeAlert`) VALUES
(1, 'Demande de pièce (envoyée)', 3),
(2, 'Demande de pièce (offre reçu)', NULL),
(3, 'Pièce commandé', 6),
(4, 'Pièce réceptionnée', NULL),
(5, 'Terminé', NULL),
(6, 'Installation à programmer', 8),
(7, 'Installation programmée', NULL),
(8, 'SAV à programmer', 3),
(22, 'SAV programmé', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `status_client`
--

CREATE TABLE IF NOT EXISTS `status_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customerId` int(11) NOT NULL,
  `statusId` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_customerId` (`customerId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `status_client`
--

INSERT INTO `status_client` (`id`, `customerId`, `statusId`, `date`) VALUES
(6, 15, 7, 1487977200),
(5, 14, 5, 1511564400),
(4, 13, 8, 1480028400);

-- --------------------------------------------------------

--
-- Structure de la table `sub`
--

CREATE TABLE IF NOT EXISTS `sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `postal` int(11) NOT NULL,
  `city` varchar(40) NOT NULL,
  `road` text NOT NULL,
  `contact` varchar(30) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `com` text NOT NULL,
  `mail` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `sub`
--

INSERT INTO `sub` (`id`, `name`, `postal`, `city`, `road`, `contact`, `tel`, `com`, `mail`) VALUES
(4, 'truuc', 45130, 'afefa', 'rkruk', 'afaef', '', '', ''),
(1, 'truc', 45110, '5541201f', 'afaefea', 'aefaef', '0288757775', 'aztgrht\r\nrzg', 'grr@tjhyk.dsg'),
(5, 'acae', 0, '', '', 'acae', '', '', ''),
(6, 'test', 92054, 'htehe', 'ethteh', 'grbzrg', '', '', ''),
(7, 'test2', 45190, 'truv', 'agaeg 121ae a ae', 'quelqu''un', '0238889263', 'efafa\r\n aef', 'aefaef@zgzrg.gt');

-- --------------------------------------------------------

--
-- Structure de la table `tech`
--

CREATE TABLE IF NOT EXISTS `tech` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `tech`
--

INSERT INTO `tech` (`id`, `name`, `firstname`) VALUES
(1, 'beauchamp', 'yoan'),
(2, 'courapied', 'gerald');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pass` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `name`, `pass`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
