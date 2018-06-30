-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2018 at 02:26 AM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_tcats`
--

CREATE TABLE `wp_tcats` (
  `id` int(11) NOT NULL,
  `old_id` int(11) NOT NULL,
  `new_id` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_tcats`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_tcats`
--
ALTER TABLE `wp_tcats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_tcats`
--
ALTER TABLE `wp_tcats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;