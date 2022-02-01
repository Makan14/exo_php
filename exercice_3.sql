-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 10, 2018 at 08:51 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
SET time_zone
= "+00:00";

--
-- Database: `contacts`
--
CREATE DATABASE
IF NOT EXISTS contacts;

USE contacts;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS contact;
CREATE TABLE `contact`
(
  `id_contact` int
(3) NOT NULL,
  `nom` varchar
(20) NOT NULL,
  `prenom` varchar
(20) NOT NULL,
  `telephone` int
(10) NOT NULL,
  `annee_rencontre` year
(4) NOT NULL,
  `email` varchar
(255) NOT NULL,
  `type_contact` enum
('ami','famille','professionnel','autre') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`
id_contact`,
`nom
`, `prenom`, `telephone`, `annee_rencontre`, `email`, `type_contact`) VALUES
(1, 'Gauriau', 'Mila', 123456789, 2000, 'marie-helene.gauriau@lepoles.com', 'ami'),
(2, 'Diallo', 'Alpha', 123456789, 2017, 'alpha.diallo@lepoles.com', 'professionnel'),
(3, 'Ridel', 'Léa', 606060606, 2017, 'lea.ridel@lepoles.org', 'professionnel'),
(4, 'Diarra', 'Abdoulaye', 707070707, 2017, 'abdoulaye.diarra@lepoles.com', 'famille'),
(5, 'Dhaussy', 'Christophe', 909090909, 2018, 'cd@wf3.fr', 'professionnel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
ADD PRIMARY KEY
(`id_contact`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int
(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
