-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 18, 2025 at 03:11 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bubblewash`
--

-- --------------------------------------------------------

--
-- Table structure for table `profile_uploads`
--

CREATE TABLE `profile_uploads` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `profile_uploads`
--

INSERT INTO `profile_uploads` (`id`, `user_id`, `filename`, `filepath`, `created_at`, `updated_at`) VALUES
(1, 30, 'user_30_1763478336.jpg', 'profile_uploads/user_30_1763478336.jpg', '2025-11-18 14:46:36', '2025-11-18 15:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_verified`, `verification_token`, `token_expires_at`, `reset_token`, `reset_token_expires_at`, `created_at`, `updated_at`) VALUES
(1, 'test1@gmail.com', '$2y$12$wJmbQltbgxFpeVHf0CUpfOhU4.vQ5cujZgcfo/yE/WkkDike6NsG.', 0, NULL, NULL, NULL, NULL, '2025-11-11 07:30:58', '2025-11-18 12:35:57'),
(2, 'test2@gmail.com', '$2y$12$9m2mSzWpG3InleFX23G03eXHj.E0Fpvv7ENxIktIDP2pBnzWKbWcO', 0, NULL, NULL, NULL, NULL, '2025-11-11 07:30:58', '2025-11-11 07:30:58'),
(3, 'test3@gmail.com', '$2y$12$JO6YCZUDZRtx9nnnqMfdwOgV29fR.oBJwgbPulsgGfgFbdXDV5P/C', 0, NULL, NULL, NULL, NULL, '2025-11-11 07:30:58', '2025-11-11 07:30:58'),
(4, 'test4@gmail.com', '$2y$12$9fGxTs.1BcmrGd3NMoDzleShppwA85VWoUdBbTBozMW6RWqkT4mcy', 0, NULL, NULL, NULL, NULL, '2025-11-11 07:30:58', '2025-11-11 07:30:58'),
(5, 'test5@gmail.com', '$2y$12$rT1xKdeTyjSt9254SJHKPOIxSbWv/E11DE8e5xS1AUgG4JeXfSZKe', 0, NULL, NULL, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(6, 'test6@gmail.com', '$2y$12$rlYvaJyeO8PgXj4pAt49gug5ac603WtEhVVdLrdCRY4BEgg/s7bFe', 0, NULL, NULL, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(7, 'test7@gmail.com', '$2y$12$5R79a8HV6gg0VPQm0tyRfOhw3VHN7z8uS4bvLh3tueNzUt/9kTE42', 0, NULL, NULL, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(8, 'test8@gmail.com', '$2y$12$g9yp9DHCrrBoLYu6eSpsCuiP6IQmLlZh.2QdzF3Ip32oq6rVCuJP2', 0, NULL, NULL, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(28, 'test9@gmail.com', '$2y$12$zYuRKfl/BjBqVVFLKfR7nOrYyi5VgGVKh87/QoPLqaXRkQXxInD/G', 1, NULL, NULL, NULL, NULL, '2025-11-17 14:46:04', '2025-11-17 15:13:46'),
(30, 'marcfrancislargo08@gmail.com', '$2y$12$zM.tQVhAUrd70qlwHSpah.YsdM/htBz8o8v.ZEgqM6WfdOoiR6cUi', 1, NULL, NULL, 'bab8ca0b05e317be0547ac8341a2faf6181b16a03844ffaa5cb400b737732e2c', '2025-11-18 16:05:57', '2025-11-18 14:40:31', '2025-11-18 15:05:57'),
(31, 'test999@gmail.com', '$2y$12$2mCzLGrOvZiS.KDmMhgUZeefdFX3Ee1nGKpfF1ONB/sjXzhyo2KAS', 0, 'd5a1a52d8045e6575d15a1b276f7e58b32a6ab4ab37a6574c2daa9eac590aa12', '2025-11-19 15:09:10', NULL, NULL, '2025-11-18 15:09:10', '2025-11-18 15:09:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_bubbles`
--

CREATE TABLE `user_bubbles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `service_type` enum('weighted','package') NOT NULL,
  `weight_kg` int DEFAULT NULL,
  `package_size` enum('small','medium','large') DEFAULT NULL,
  `folded` tinyint(1) DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `status` enum('pending','bubbling','ready_for_pickup','completed','cancelled') DEFAULT 'pending',
  `pickup_date` date DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_bubbles`
--

INSERT INTO `user_bubbles` (`id`, `user_id`, `service_type`, `weight_kg`, `package_size`, `folded`, `price`, `status`, `pickup_date`, `pickup_time`, `created_at`, `updated_at`) VALUES
(1, 30, 'package', NULL, 'large', 1, 505.00, 'cancelled', '2025-11-18', '10:00:00', '2025-11-18 14:45:02', '2025-11-18 14:56:10'),
(2, 30, 'weighted', 10, NULL, 1, 530.00, 'pending', '2025-11-28', '12:59:00', '2025-11-18 14:46:09', '2025-11-18 14:46:09'),
(3, 30, 'package', NULL, 'medium', 1, 405.00, 'cancelled', '2025-11-18', '09:05:00', '2025-11-18 14:47:15', '2025-11-18 14:56:01'),
(4, 30, 'package', NULL, 'large', 1, 505.00, 'pending', '2026-03-27', '19:00:00', '2025-11-18 14:47:38', '2025-11-18 14:47:38'),
(5, 30, 'weighted', 3, NULL, 1, 180.00, 'pending', '2026-02-19', '21:41:00', '2025-11-18 14:48:33', '2025-11-18 14:48:33'),
(6, 30, 'weighted', 4, NULL, 1, 230.00, 'pending', '2026-01-23', '03:00:00', '2025-11-18 14:48:55', '2025-11-18 14:48:55'),
(7, 30, 'weighted', 1, NULL, 0, 50.00, 'cancelled', '2025-11-18', '09:00:00', '2025-11-18 14:49:11', '2025-11-18 15:07:20'),
(8, 30, 'weighted', 6, NULL, 1, 330.00, 'completed', '2025-11-18', '21:05:00', '2025-11-18 14:49:32', '2025-11-18 14:55:54'),
(9, 30, 'weighted', 6, NULL, 1, 330.00, 'ready_for_pickup', '2025-11-18', '09:04:00', '2025-11-18 14:49:55', '2025-11-18 14:55:48'),
(10, 30, 'package', NULL, 'small', 1, 305.00, 'bubbling', '2030-12-18', '15:06:00', '2025-11-18 14:50:25', '2025-11-18 14:55:44'),
(11, 30, 'weighted', 4, NULL, 1, 230.00, 'pending', '2025-11-18', '09:00:00', '2025-11-18 14:50:38', '2025-11-18 15:07:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profile_uploads`
--
ALTER TABLE `profile_uploads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `verification_token` (`verification_token`),
  ADD KEY `reset_token` (`reset_token`);

--
-- Indexes for table `user_bubbles`
--
ALTER TABLE `user_bubbles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profile_uploads`
--
ALTER TABLE `profile_uploads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_bubbles`
--
ALTER TABLE `user_bubbles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profile_uploads`
--
ALTER TABLE `profile_uploads`
  ADD CONSTRAINT `profile_uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_bubbles`
--
ALTER TABLE `user_bubbles`
  ADD CONSTRAINT `user_bubbles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
