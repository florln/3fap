-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 26 mai 2024 à 19:32
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `3fap`
--

-- --------------------------------------------------------

--
-- Structure de la table `activites`
--

CREATE TABLE `activites` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `lien` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `activites`
--

INSERT INTO `activites` (`id`, `nom`, `image_path`, `description`, `lien`, `created_at`) VALUES
(21, 'osdgfigfids', 'uploads/7.jpg', 'klsdjfbdskjfsdkfhsdfsdf', 'fsdfsdfsdffsd', '2024-05-05 13:10:42'),
(22, 'ertretertrtert', 'uploads/2.jpeg', 'tretretrtretretretreterfdgdhfghfdghfghgfhfh', 'ereythgfhgfhjghjfshetete', '2024-05-05 13:43:35');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`product_id`) VALUES
(3);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact_requests`
--

INSERT INTO `contact_requests` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'chriss', 'chriss@gmail.cim', 'zeffdsfdsfsdfsdfdfds', '2024-04-17 11:41:53');

-- --------------------------------------------------------

--
-- Structure de la table `goodies`
--

CREATE TABLE `goodies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `goodies`
--

INSERT INTO `goodies` (`id`, `name`, `description`, `image_path`, `price`, `stock_quantity`, `product_id`) VALUES
(2, 'test', 'tout va bien !!', 'uploads/logo.png', 12000.00, 25, 1111222554),
(3, 'test', 'tout va bien !!', 'uploads/logo.png', 12000.00, 25, 2022235552),
(4, 'pomme ', 'bonne pour tous', 'uploads/1.png', 21000.00, 25, NULL),
(5, 'bonbon', 'Très bon', 'uploads/2.png', 200.00, 456, NULL),
(6, 'tapioca', 'fait à base de manioc', 'uploads/Capture.PNG', 1200.00, 25, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `author`, `created_at`, `user_id`) VALUES
(4, 'test', 'tout est okay !!!!', '', '2024-05-26 16:15:20', 5),
(5, 'test', 'tout est okay !!!!', '', '2024-05-26 16:16:19', 5),
(6, 'all', 'tout!!!', '', '2024-05-26 17:27:55', 5);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','User') NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `first_name`, `last_name`, `email`, `phone_number`, `date_of_birth`, `active`) VALUES
(5, 'admin', '$2y$10$3M3zF9METZnx4DVbkqCkg.KVrQPjGRhCxlKvtQw4IDg0VU7rBw5rK', 'Admin', 'admin', 'admin', 'admin@mail.com', '366654525', '2016-06-08', 1),
(6, 'reertrt', '$2y$10$jXTYH3e..dXqiexLULW8kuL7cJ3M8KMS3LHyqGWn8BuQKUGrF1cKy', 'User', 'tyrtyytrt', 'tytrrtytyty', 'ertrtrtertret@ret.ert', '225656', '2018-06-13', 0),
(7, 'reerttyty', '$2y$10$ksyetfbvteDvMrJrEFa7huyC9RBB2pA/1SiA8LooizwHAaRgWhkjW', 'User', 'tyrtyytrt', 'tytrrtytyty', 'ertrtrtyyret@ret.ert', '225656', '2018-06-13', 0),
(8, 'user', '$2y$10$sm0nl9o.ZGpidB6vsBa/POSGbikGlw2aGa40LMWfTKfjZaqKfINNq', 'User', 'user', 'user', 'user@mail.com', '6552568', '2022-02-02', 0),
(9, 'christ', '$2y$10$QKfVPWl.966wfUX2l5N/uOZTeMvdH4exuYdajyL3MZ0ACs4DD0wdu', 'User', 'techrist', 'ted', 'christ@mail.com', '658856896', '2013-06-22', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activites`
--
ALTER TABLE `activites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `goodies`
--
ALTER TABLE `goodies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activites`
--
ALTER TABLE `activites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `goodies`
--
ALTER TABLE `goodies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
