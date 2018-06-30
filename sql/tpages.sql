-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2018 at 02:25 AM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_tpages`
--

CREATE TABLE `wp_tpages` (
  `id` int(11) NOT NULL,
  `last` int(11) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_tpages`
--

INSERT INTO `wp_tpages` (`id`, `last`, `created_at`, `updated_at`) VALUES
(1337, 0, NULL, '2018-06-29');
