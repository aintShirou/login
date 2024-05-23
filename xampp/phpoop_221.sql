-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 04:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpoop_221`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `user_profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `birthdate`, `sex`, `user_email`, `user`, `pass`, `user_profile_picture`) VALUES
(16, 'Joseph Andrei', 'Tallado', '2024-05-08', 'Male', 'andreitallado008@gmail.com', 'aintShirou', '$2y$10$NESAkfDx1K7FBs2p1b7jx.jX9Q7GGX68IEkxkpEOaGbNUVxmaYeAS', 'uploads/arle_1716165945.jpg'),
(18, 'Benedict', 'Galgo', '2024-05-06', 'Male', 'talladojo@students.nu-lipa.edu.ph', 'Ben', '$2y$10$oirvlzq7YOxsaO5rLRqT7ObBFlto9.v6Yj5J0hjmRBBTiYgiReFoy', 'uploads/ei_1716166784.jpg'),
(20, 'Paula', 'De Chavez', '2024-05-09', 'Male', 'poleng@gmail.com', 'Poleng', '$2y$10$otmR4qLYN3gwDhrpIryyYeHharmUew8tkmajVBgxNynDcgRJJtXx.', 'uploads/miko_1716166953.jpg'),
(22, 'Axle Troy', 'Antonio', '2024-05-08', 'Male', 'axle@gmail.com', 'Toti', '$2y$10$PHsRSNIUJmjkcm3izyarqulRv3UCw0m6Ggu4ig55lkmwXsepcltA.', 'uploads/wbnr35rn.png'),
(24, 'Jowoss', 'Reyes', '2000-04-04', 'Male', 'jorossreyes84@gmail.com', 'Jorosss', '$2y$10$YSzoMmZrvdowT2nImriv9.4YpFGq2SGYaxzMOeHE5ZfoIucAB8DpC', 'uploads/wbnr35rn_1716170408.png'),
(25, 'Princess Coleen', 'Roxas', '2024-05-17', 'Female', 'coleen@gmail.com', 'Coleen', 'Coleen_123', 'uploads/ayaka.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `user_address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_street` varchar(225) DEFAULT NULL,
  `user_barangay` varchar(255) DEFAULT NULL,
  `user_city` varchar(255) DEFAULT NULL,
  `user_province` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`user_address_id`, `user_id`, `user_street`, `user_barangay`, `user_city`, `user_province`) VALUES
(16, 16, '1234', 'Banaybanay', 'Lipa City', 'Region IV-A (CALABARZON)'),
(18, 18, '123', 'Abbeg', 'Alcala', 'Region II (Cagayan Valley)'),
(20, 20, '123', 'Ihubok I (Kaychanarianan)', 'Basco (Capital)', 'Region II (Cagayan Valley)'),
(21, 22, '123145', 'Bessang', 'Allacapan', 'Region II (Cagayan Valley)'),
(22, 24, 'Cali', 'Calingatan', 'Mataasnakahoy', 'Region IV-A (CALABARZON)'),
(23, 25, 'Sadas', 'Antipolo', 'Dapitan City', 'Region IX (Zamboanga Peninzula)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`user_address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `user_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
