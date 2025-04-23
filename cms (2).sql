-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 09:01 AM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `article`
--

CREATE TABLE `article` (
  `id_article` int(11) NOT NULL,
  `title` varchar(25) NOT NULL,
  `content` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `header_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id_article`, `title`, `content`, `date`, `header_image`) VALUES
(1, 'Pierwszy artykuł', 'cokolwiek', '2025-03-31', NULL),
(2, 'Drugi artykuł', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur laboriosam, amet optio enim reiciendis nulla. Accusantium iure sapiente amet iste, deserunt provident laudantium sint iusto necessitatibus eum, facere dolorem eaque.', '2025-03-31', NULL),
(15, 'trzeci artykuł', 'test test test test test test test test test test test test test test test test test test test test test test', '2025-04-14', NULL),
(16, 'Warszawa', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Error qui voluptas repudiandae recusandae obcaecati nemo consequuntur!', '2025-04-14', 'uploads/1744622953_warszawa-budynki.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','editor','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Marian', '$2y$10$CKuS3Gz701YFzDztv6kFle5b1qwcJFpP.NaYuQW/v2lGrTripcIF2', 'admin', '2025-03-31 09:09:18'),
(3, 'Filip', '$2y$10$0FF1gMVh7G7HUW0MTvqkNunD1ClMnoIB/oTZCHGZeUlc2v1Qyk29a', 'editor', '2025-04-02 07:44:14'),
(4, 'Franciszek', '$2y$10$2g8nkCfpcuyEDyIU2TgAHeg6cUtuQQWc7zBTaDWvt7bRS3DEP2ry6', 'user', '2025-04-02 09:53:26');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
