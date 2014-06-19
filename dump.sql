-- phpMyAdmin SQL Dump
-- version 2.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 18, 2010 at 01:19 PM
-- Server version: 5.0.27
-- PHP Version: 5.2.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `invoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `company` varchar(100) collate utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(100) collate utf8_unicode_ci NOT NULL,
  `address_line_2` varchar(100) collate utf8_unicode_ci NOT NULL,
  `phone_number` varchar(20) collate utf8_unicode_ci NOT NULL,
  `city` varchar(80) collate utf8_unicode_ci NOT NULL,
  `zip_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `state` varchar(80) collate utf8_unicode_ci NOT NULL,
  `country` varchar(40) collate utf8_unicode_ci NOT NULL,
  `tax_id` varchar(40) collate utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `name`, `email`, `company`, `address_line_1`, `address_line_2`, `phone_number`, `city`, `zip_code`, `state`, `country`, `tax_id`, `created_on`) VALUES
(4, 'Olivier Dumetz', 'odumetz@gmail.com', 'Olivier Dumetz', '1155 promenade Elmlea', '', '', 'Ottawa', 'K1J 6W1', 'Ontario', 'Canada', '', '2009-12-06 14:57:16'),
(2, 'Tanya Fader', 'tanya.fader@mountainmamma.com', 'Mountain Mamma', '7 Ch. Pawley', '', '', 'Chelsea', 'J9B 2C9', 'Québec', 'Canada', '', '2009-12-06 17:39:56'),
(3, 'Edith Provost', 'provost@isbamusic.com', 'ISBA Music Entertainment Group', '2860 boul de la Concorde Est', 'Bureau 201', '', 'Laval', 'H7E 2B4', 'Québec', 'Canada', '', '2009-12-06 18:23:22'),
(1, 'Philippe Archambault', 'phil@roboys.com', 'Philippe Archambault', '70 rue Bégin', '', '819 205-2990', 'Gatineau', 'J9A 1E1', 'Québec', 'Canada', '', '2009-12-01 00:00:00'),
(5, 'Marie-Claude D''Aoust', 'marie-claude@c-show.ca', 'C-SHOW Productions Inc.', '5-C rue Garneau', '', '819-568-5505', 'Gatineau', 'J8X 1R4', 'Québec', 'Canada', '', '2010-01-07 11:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `permalink` char(10) collate utf8_unicode_ci NOT NULL,
  `status` varchar(10) collate utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `due_date` date NOT NULL,
  `invoice_id` int(7) unsigned zerofill NOT NULL,
  `po` varchar(40) collate utf8_unicode_ci NOT NULL,
  `due` int(4) unsigned NOT NULL,
  `taxe_rate` float NOT NULL,
  `discount_rate` float NOT NULL,
  `shipping_amount` float NOT NULL,
  `management_fee` float NOT NULL,
  `currency_symbol` char(1) collate utf8_unicode_ci NOT NULL default '$',
  `currency_code` char(3) collate utf8_unicode_ci NOT NULL,
  `notes` text collate utf8_unicode_ci NOT NULL,
  `client_id` int(11) unsigned NOT NULL,
  `subtotal` float NOT NULL,
  `tax` float NOT NULL,
  `tax_name` varchar(10) collate utf8_unicode_ci NOT NULL,
  `discount` float NOT NULL,
  `shipping` float NOT NULL,
  `management` smallint(3) NOT NULL,
  `total` float NOT NULL,
  `paid` float NOT NULL,
  `balance_due` float NOT NULL,
  `language` char(2) collate utf8_unicode_ci NOT NULL default 'fr',
  `display_country` tinyint(1) unsigned NOT NULL default '0',
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `permalink` (`permalink`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `permalink`, `status`, `date`, `due_date`, `invoice_id`, `po`, `due`, `taxe_rate`, `discount_rate`, `shipping_amount`, `management_fee`, `currency_symbol`, `currency_code`, `notes`, `client_id`, `subtotal`, `tax`, `tax_name`, `discount`, `shipping`, `management`, `total`, `paid`, `balance_due`, `language`, `display_country`, `created_by`) VALUES
(1, 'Yn7wITPUwI', 'draft', '2009-11-17', '2009-12-17', 0000039, '', 30, 0, 0, 0, 0, '', '', '', 3, 0, 0, 'Tax', 0, 0, 0, 2000, 0, 2000, 'fr', 0, 1),
(2, 'OflwNj6WBN', 'draft', '2009-11-19', '2009-12-19', 0000041, '', 30, 0, 0, 0, 0, '', '', '', 4, 0, 0, 'Tax', 0, 0, 0, 2400, 0, 2400, 'fr', 0, 1),
(3, '0NsGd63Bp4', 'draft', '2009-11-23', '2009-12-23', 0000042, '', 30, 0, 0, 0, 0, '', '', '', 3, 0, 0, 'Tax', 0, 0, 0, 200, 0, 200, 'fr', 0, 1),
(4, 'bkP0AOOtfh', 'paid', '2009-12-03', '2010-01-02', 0000043, '', 30, 0, 0, 0, 0, '', '', '', 2, 0, 0, 'Tax', 0, 0, 0, 320, 320, 0, 'fr', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_history`
--

CREATE TABLE IF NOT EXISTS `invoice_history` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `event` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `invoice_history`
--

INSERT INTO `invoice_history` (`id`, `invoice_id`, `user_id`, `date`, `event`) VALUES
(10, 4, 1, '2009-12-16 00:00:00', 'Payment of 320.00 received.'),
(2, 1, 1, '2009-11-17 00:00:00', 'Invoice created.'),
(3, 2, 1, '2009-11-19 00:00:00', 'Invoice created.'),
(4, 3, 1, '2009-11-23 00:00:00', 'Invoice created.'),
(5, 4, 1, '2009-12-03 00:00:00', 'Invoice created.'),
(11, 4, 1, '2009-12-16 00:00:00', 'Invoice paid.');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item`
--

CREATE TABLE IF NOT EXISTS `invoice_item` (
  `id` int(11) NOT NULL auto_increment,
  `description` text collate utf8_unicode_ci NOT NULL,
  `qty` varchar(10) collate utf8_unicode_ci NOT NULL,
  `kind` varchar(10) collate utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `invoice_item`
--

INSERT INTO `invoice_item` (`id`, `description`, `qty`, `kind`, `price`, `total`) VALUES
(1, 'License du CMS', '1', 'product', 300, 300);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_line`
--

CREATE TABLE IF NOT EXISTS `invoice_line` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `invoice_id` int(11) NOT NULL,
  `qty` varchar(10) collate utf8_unicode_ci NOT NULL,
  `kind` varchar(10) collate utf8_unicode_ci NOT NULL,
  `description` mediumtext collate utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `total` float NOT NULL,
  `position` smallint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `invoice_line`
--

INSERT INTO `invoice_line` (`id`, `invoice_id`, `qty`, `kind`, `description`, `price`, `total`, `position`) VALUES
(1, 1, '16', 'hour', 'Design de la nouvelle interface web', 50, 800, 0),
(2, 1, '10', 'hour', 'Découpe des pages web en HTML / CSS', 50, 500, 1),
(3, 1, '14', 'hour', 'Intégration du contenus et ronde de modifications', 50, 700, 2),
(4, 2, '16', 'hour', 'Insertion du contenu "The Book"', 50, 800, 1),
(5, 2, '24', 'hour', 'Module Puzzle', 50, 1200, 2),
(6, 2, '8', 'hour', 'Découpe de la template général des modules', 50, 400, 0),
(7, 3, '4', 'hour', 'Programmation des pages du Fan Club français et anglais, ainsi des pages de remerciment pour le site de Giorgia Fumanti.  Integration du lien vers les pages du Fan club dans le reste du site.', 50, 200, 0),
(8, 4, '8', 'hour', 'XHTML/CSS from Photoshop file for the home page', 40, 320, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `name` varchar(15) collate utf8_unicode_ci NOT NULL,
  `subject` varchar(255) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `language` char(2) collate utf8_unicode_ci NOT NULL default 'fr',
  PRIMARY KEY  (`name`,`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`name`, `subject`, `content`, `language`) VALUES
('invoice', 'Invoice {invoice_id}', 'Hello {client_name},\r\n\r\nHere is the invoice of {invoice_amount}.\r\n\r\nYou can view the invoice online at:\r\n\r\n{invoice_link}\r\n\r\n{signature}', 'en'),
('thank you', 'Thank You', 'Hello {client_name},\r\n\r\nWe have received the payment for invoice {invoice_id}, thank you!\r\n\r\nYou can view the invoice online at:\r\n\r\n{invoice_link}\r\n\r\n{signature}', 'en'),
('invoice', 'Facture {invoice_id}', 'Bonjour {client_name},\r\n\r\nVoici la facture de {invoice_amount} $.\r\n\r\nVous pouvez voir cette facture en ligne à l''adresse suivante:\r\n\r\n{invoice_link}', 'fr'),
('thank you', 'Merci', 'Bonjour {client_name},\r\n\r\nNous avons bien reçu le paiement de la facture {invoice_id}, merci!\r\n\r\nVous pouvez voir la facture en ligne:\r\n\r\n{invoice_link}\r\n\r\n{signature}', 'fr'),
('reminder', 'Reminder', 'Hello {client_name},\r\n\r\nJust a reminder that Invoice {invoice_id} was due on {invoice_due_date}. Please make the payment of {invoice_amount} as soon as possible.\r\n\r\nYou can view the invoice online at:\r\n\r\n{invoice_link}\r\n\r\n{signature}', 'en'),
('signature', '', 'Best regards,\r\n{name}\r\n\r\n{company}', 'en'),
('reminder', 'Reminder', 'Hello {client_name}, Just a reminder that Invoice {invoice_id} was due on {invoice_due_date}. Please make the payment of {invoice_amount} as soon as possible. You can view the invoice online at: {invoice_link} {signature}', 'fr'),
('signature', '', 'Cordialement, {name} {company}', 'fr');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `description` varchar(255) collate utf8_unicode_ci NOT NULL,
  `hours` float NOT NULL,
  `rate` float NOT NULL,
  `total` float NOT NULL,
  `status` varchar(10) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `description`, `hours`, `rate`, `total`, `status`) VALUES
(1, 'Invoice Machine Clone', 20, 0, 0, 'draft'),
(2, 'SiteFace - Inline Content Editor', 100, 0, 0, 'draft'),
(3, 'Time Tracker', 0, 0, 0, 'draft'),
(4, 'Flash Module Touchpoint', 40, 50, 2000, 'draft');

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE IF NOT EXISTS `quote` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `permalink` char(10) collate utf8_unicode_ci NOT NULL,
  `status` varchar(10) collate utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `quote_id` int(7) unsigned zerofill NOT NULL,
  `po` varchar(40) collate utf8_unicode_ci NOT NULL,
  `taxe_rate` float NOT NULL,
  `discount_rate` float NOT NULL,
  `shipping_amount` float NOT NULL,
  `management_fee` float NOT NULL,
  `currency_symbol` char(1) collate utf8_unicode_ci NOT NULL default '$',
  `currency_code` char(3) collate utf8_unicode_ci NOT NULL,
  `notes` text collate utf8_unicode_ci NOT NULL,
  `client_id` int(11) unsigned NOT NULL,
  `subtotal` float NOT NULL,
  `tax` float NOT NULL,
  `tax_name` varchar(10) collate utf8_unicode_ci NOT NULL,
  `discount` float NOT NULL,
  `shipping` float NOT NULL,
  `management` smallint(3) NOT NULL,
  `total` float NOT NULL,
  `language` char(2) collate utf8_unicode_ci NOT NULL default 'fr',
  `display_country` tinyint(1) unsigned NOT NULL default '0',
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `permalink` (`permalink`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `quote`
--

INSERT INTO `quote` (`id`, `permalink`, `status`, `date`, `quote_id`, `po`, `taxe_rate`, `discount_rate`, `shipping_amount`, `management_fee`, `currency_symbol`, `currency_code`, `notes`, `client_id`, `subtotal`, `tax`, `tax_name`, `discount`, `shipping`, `management`, `total`, `language`, `display_country`, `created_by`) VALUES
(1, 'cvw7noKDXq', 'refused', '2010-01-07', 0000044, '', 0, 0, 0, 0, '', '', 'Programmer la création et modification des contrats pour le festival des mongolfières à l''aide PHP et d''une base de données MySQL.\r\n\r\nLa création des documents du contract se fera automatiquement en fonction du gabarit "Contrat petites scènes FMG.doc"', 5, 0, 0, 'Tax', 0, 0, 0, 1595, 'fr', 1, 1),
(2, 'WkW7vJ9vb0', 'draft', '2010-01-06', 0000043, '', 0, 0, 0, 0, '', '', 'Presentations convertion for 3 documents with a total of 60 pages.', 2, 0, 0, 'Tax', 0, 0, 0, 1450, 'en', 1, 1),
(3, 'XAqS1OBLro', 'draft', '2010-01-10', 0000045, '', 0, 0, 0, 110, '', '', '', 5, 0, 0, 'Tax', 0, 0, 10, 1210, 'fr', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quote_history`
--

CREATE TABLE IF NOT EXISTS `quote_history` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `quote_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `event` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `quote_history`
--

INSERT INTO `quote_history` (`id`, `quote_id`, `user_id`, `date`, `event`) VALUES
(1, 1, 1, '2010-01-07 15:36:53', 'Estimate created.'),
(2, 2, 1, '2010-01-08 16:39:07', 'Estimate created.'),
(6, 1, 1, '2010-01-11 13:57:28', 'Estimate refused.'),
(7, 3, 1, '2010-01-12 14:20:15', 'Estimate created.');

-- --------------------------------------------------------

--
-- Table structure for table `quote_line`
--

CREATE TABLE IF NOT EXISTS `quote_line` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `quote_id` int(11) NOT NULL,
  `qty` varchar(10) collate utf8_unicode_ci NOT NULL,
  `kind` varchar(10) collate utf8_unicode_ci NOT NULL,
  `description` mediumtext collate utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `total` float NOT NULL,
  `position` smallint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `quote_line`
--

INSERT INTO `quote_line` (`id`, `quote_id`, `qty`, `kind`, `description`, `price`, `total`, `position`) VALUES
(1, 1, '5', 'hour', 'création du formulaire', 50, 250, 0),
(2, 1, '8', 'hour', 'programmation d''ajout et modification d''un contrat', 50, 400, 1),
(3, 1, '8', 'hour', 'progammation de l''affichage de la liste', 50, 400, 2),
(4, 1, '4', 'hour', 'génération du template de contrat pour le festival des mongolfières', 50, 200, 3),
(5, 1, '4', 'hour', 'programmation des taxes et entré de données automatisée', 50, 200, 4),
(6, 1, '1', 'service', '10% de gestion de projet', 145, 145, 5),
(7, 2, '2', 'hour', 'Player and commun design for presentation', 50, 100, 0),
(8, 2, '8', 'hour', 'player flash programmation (previous, next, play, pause and fullscreen)', 50, 400, 1),
(9, 2, '4', 'hour', 'security programmation (limit the flash to be load or embed on a other website)', 50, 200, 2),
(10, 2, '15', 'hour', 'pages integrations (4 pages/hour) total 60 pages', 50, 750, 3),
(11, 3, '8', 'hour', 'design', 50, 400, 0),
(12, 3, '8', 'hour', 'Découpage du Site HTML', 50, 400, 1),
(13, 3, '2', 'hour', 'Insertion du contenu', 50, 100, 2),
(14, 3, '1', 'hour', 'Programmation formulaire', 50, 50, 3),
(15, 3, '3', 'hour', 'Assurance Qualité et mise en ligne', 50, 150, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(20) collate utf8_unicode_ci NOT NULL,
  `password` char(40) collate utf8_unicode_ci NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `email` varchar(80) collate utf8_unicode_ci NOT NULL,
  `rate` float NOT NULL default '50',
  `is_active` tinyint(1) NOT NULL default '1',
  `is_admin` tinyint(1) NOT NULL default '0',
  `created_on` datetime default NULL,
  `created_by` int(10) unsigned NOT NULL default '1',
  `last_login` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `email`, `rate`, `is_active`, `is_admin`, `created_on`, `created_by`, `last_login`) VALUES
(1, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Philippe Archambault', 'philippe.archambault@gmail.com', 50, 1, 1, '2007-07-17 10:00:00', 1, '2010-01-14 13:02:57');
