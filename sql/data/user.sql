-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 22, 2012 at 08:50 AM
-- Server version: 5.1.61-0ubuntu0.11.10.1
-- PHP Version: 5.3.6-13ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `whiteboard`
--

-- --------------------------------------------------------


--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`, `roomCreator`) VALUES
(1, 'Teste', 'teste@teste.com', 'senha', 1),
(2, 'Rodrigo', 'rodrigo@teste.com', 'senha', 1),
(3, 'Henrique', 'henrique@teste.com', 'senha', 1),
(4, 'Felipe', 'felipe@teste.com', 'senha', 1),
(5, 'Lourenço', 'lourenco@teste.com', 'senha', 1),
(6, 'Debora', 'debora@teste.com', 'senha', 1),
(7, 'Renan', 'renan@teste.com', 'senha', 1),
(8, 'Lucila', 'lucila@teste.com', 'senha', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
