-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 24, 2015 at 04:44 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gamelist`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `tittle` varchar(100) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `qty` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `items`
--


-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `paypal_trans_id` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tittle` varchar(40) NOT NULL DEFAULT 'Notitle',
  `body` text NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `image` varchar(100) NOT NULL DEFAULT 'nophoto.jpg',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `tittle`, `body`, `price`, `image`) VALUES
(1, 'Bull', 'Bull is a animal', '0.50', 'nophoto.jpg'),
(2, 'COW', 'cow is also animal', '1.00', 'nophoto.jpg'),
(3, 'AN OX', 'some animal', '2.00', 'nophoto.jpg');
