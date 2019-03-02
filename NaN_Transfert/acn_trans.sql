-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 02 Mars 2019 à 02:29
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `acn_trans`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `compte_acn` float NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `compte_acn`, `password`) VALUES
(1, 'adelphe', 9.76, '9cf95dacd226dcf43da376cdb6cbba7035218921');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msgtrans` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `msg_user_env` varchar(255) NOT NULL,
  `msg_user_recu` varchar(255) NOT NULL,
  `datemsg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `messages`
--

INSERT INTO `messages` (`id`, `msgtrans`, `content`, `msg_user_env`, `msg_user_recu`, `datemsg`) VALUES
(9, 2, 'Vous avez recu 432 fcfa de : test (test@gma.com)', 'test', 'default@mail.com', '2019-03-02 00:15:14'),
(10, 2, 'Vous avez recu 200 fcfa de : test (test@gma.com)', 'test', 'default@mail.com', '2019-03-02 00:15:41');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `montant` float NOT NULL,
  `datetr` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `transactions`
--

INSERT INTO `transactions` (`id`, `user`, `email`, `montant`, `datetr`) VALUES
(2, 2, 'adelph@mail.com', 10, '2019-03-01 19:45:24'),
(3, 2, 'adelph@mail.com', 30, '2019-03-01 20:12:01'),
(4, 2, 'adelph@mail.com', 90, '2019-03-01 21:06:20'),
(5, 2, 'adelph@mail.com', 10, '2019-03-01 21:22:08'),
(6, 2, 'asas@li.com', 30, '2019-03-01 21:22:45'),
(7, 2, 'adelph@mail.com', 10, '2019-03-01 21:24:58'),
(8, 2, 'adelph@mail.com', 10, '2019-03-01 21:25:58'),
(9, 2, 'adelph@mail.com', 10, '2019-03-01 21:35:53'),
(10, 2, 'adelph@mail.com', 28, '2019-03-01 21:38:21'),
(11, 2, 'default@mail.com', 432, '2019-03-02 00:15:13'),
(12, 2, 'default@mail.com', 200, '2019-03-02 00:15:41');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `depot` float NOT NULL,
  `username` varchar(255) NOT NULL,
  `codes` varchar(5) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `depot`, `username`, `codes`, `password`) VALUES
(1, 'default', 'user', 'default@mail.com', 633, 'unregistered', '0', '7505d64a54e061b7acd54ccd58b49dc43500b635'),
(2, 'users1', 'defau', 'test@gma.com', 360.416, 'test', '11111', '7505d64a54e061b7acd54ccd58b49dc43500b635'),
(3, 'jnb', 'jnik', 'ninn', 1, 'aaaa', '11', 'ASASASAS'),
(4, 'eezerze', 'zazdzadza', 'adelph@mail.com', 48, 'aaaaaa', '333', '1a3d8e3d78806e85d07a25292db17684c897a967'),
(5, 'aed', 'aaa', 'asas@li.com', 30, 'asasa', '02222', '1a3d8e3d78806e85d07a25292db17684c897a967');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `msgtrans` (`msgtrans`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`msgtrans`) REFERENCES `transactions` (`id`);

--
-- Contraintes pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
