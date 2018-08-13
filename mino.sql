-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2018 at 07:17 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mino`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkPath` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES
(1, 'Views', 7, 3, 'assets/images/artwork/views.png\r\n'),
(2, 'Beautiful Imperfection', 12, 2, 'assets/images/artwork/beautiful-imperfection.png\r\n'),
(3, 'R.E.D', 11, 7, 'assets/images/artwork/red.png\r\n'),
(4, 'Chemistry', 5, 7, 'assets/images/artwork/chemistry.png\r\n'),
(5, 'Mboko God', 3, 3, 'assets/images/artwork/mboko-god.png\r\n'),
(6, 'Coloring Book', 4, 3, 'assets/images/artwork/coloring-book.png\r\n'),
(7, '25', 9, 5, 'assets/images/artwork/25.png\r\n'),
(8, 'The Greatest', 8, 2, 'assets/images/artwork/the-greatest.png\r\n'),
(9, 'Lemonade', 13, 2, 'assets/images/artwork/lemonade.png\r\n'),
(10, '16 Wives', 3, 3, 'assets/images/artwork/16-wives.png\r\n'),
(11, 'Tokooos', 14, 4, 'assets/images/artwork/tokooos\r\n.png\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Kendrick Lamar'),
(2, 'Kanye West'),
(3, 'Jovi LeMonstre'),
(4, 'Chance The Rapper'),
(5, 'Falz'),
(6, 'Maroon 5'),
(7, 'Drake'),
(8, 'Sia'),
(9, 'Adele'),
(10, 'Simi'),
(11, 'Tiwa Savage'),
(12, 'Asa'),
(13, 'Beyonce'),
(14, 'Fally Ipupa');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Rap'),
(4, 'Hip-Hop'),
(5, 'R&B'),
(6, 'Classical'),
(7, 'Afrobeat'),
(8, 'Jazz'),
(9, 'Funk'),
(10, 'Gospel');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `playlistsongs`
--

CREATE TABLE `playlistsongs` (
  `id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`) VALUES
(1, 'Be My Man', 12, 2, 2, '03:19', 'assets/music/asa-be-my-man.mp3\r\n', 3, 16),
(2, 'Monshung', 3, 10, 3, '03:22', 'assets/music/jovi-monshung.mp3\r\n', 5, 20),
(3, 'Esengo', 14, 11, 4, '03:21', 'assets/music/fally-ipupa-esengo.mp3\r\n', 1, 37),
(4, 'Ma Lo', 11, 3, 7, '02:51', 'assets/music/tiwa-savage-malo.mp3\r\n', 3, 22),
(5, 'Child\'s Play', 7, 1, 3, '04:01', 'assets/music/drake-childs-play.mp3', 4, 23),
(6, 'Sorry', 13, 9, 2, '03:52', 'assets/music/beyonce-sorry.mp3\r\n', 4, 28),
(7, 'Send My Love', 9, 7, 5, '03:43', 'assets/music/adele-send-my-love.mp3\r\n', 2, 30),
(8, 'Blessings', 4, 6, 3, '03:50', 'assets/music/chance-the-rapper-blessings.mp3\r\n', 2, 21),
(9, 'Chemistry', 5, 4, 7, '03:48', 'assets/music/falz-chemistry.mp3\r\n', 1, 14),
(10, 'Cheap Thrilss', 8, 8, 2, '03:31', 'assets/music/sia-cheap-thrills.mp3\r\n', 1, 10),
(11, 'River Lea', 9, 7, 5, '03:45', 'assets/music/adele-river-lea.mp3', 1, 44);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(32) NOT NULL,
  `signUpDate` datetime NOT NULL,
  `profilePic` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `email`, `password`, `signUpDate`, `profilePic`) VALUES
(1, 'frustoic', 'Fru', 'Emmanuel', 'Fru952002@gmail.com', 'cc875f5fcc43eff367ca3ef959aa999d', '2018-06-22 00:00:00', 'assets/images/profile-pics/profile.png'),
(3, 'pooPi', 'Poo', 'Pi', 'Stephenmcdonal22987@gmail.com', 'b0baee9d279d34fa1dfd71aadb908c3f', '2018-06-22 00:00:00', 'assets/images/profile-pics/profile.png'),
(4, 'frustoic', 'James', 'Fru', 'Lala@yahoo.po', 'dcddb75469b4b4875094e14561e573d8', '2018-06-22 00:00:00', 'assets/images/profile-pics/profile.png'),
(5, 'frustoic', 'James', 'Fru', 'Lala@yahoo.po', 'b0baee9d279d34fa1dfd71aadb908c3f', '2018-06-22 00:00:00', 'assets/images/profile-pics/profile.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlistsongs`
--
ALTER TABLE `playlistsongs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `playlistsongs`
--
ALTER TABLE `playlistsongs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
