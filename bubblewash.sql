-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 15, 2025 at 03:08 PM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_verified`, `verification_token`, `token_expires_at`, `created_at`, `updated_at`) VALUES
(1, 'test1@gmail.com', '$2y$12$wJmbQltbgxFpeVHf0CUpfOhU4.vQ5cujZgcfo/yE/WkkDike6NsG.', 0, NULL, NULL, '2025-11-11 07:30:58', '2025-11-11 07:30:58'),
(2, 'test2@gmail.com', '$2y$12$9m2mSzWpG3InleFX23G03eXHj.E0Fpvv7ENxIktIDP2pBnzWKbWcO', 0, NULL, NULL, '2025-11-11 07:30:58', '2025-11-11 07:30:58'),
(3, 'test3@gmail.com', '$2y$12$JO6YCZUDZRtx9nnnqMfdwOgV29fR.oBJwgbPulsgGfgFbdXDV5P/C', 0, NULL, NULL, '2025-11-11 07:30:58', '2025-11-11 07:30:58'),
(4, 'test4@gmail.com', '$2y$12$9fGxTs.1BcmrGd3NMoDzleShppwA85VWoUdBbTBozMW6RWqkT4mcy', 0, NULL, NULL, '2025-11-11 07:30:58', '2025-11-11 07:30:58'),
(5, 'test5@gmail.com', '$2y$12$rT1xKdeTyjSt9254SJHKPOIxSbWv/E11DE8e5xS1AUgG4JeXfSZKe', 0, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(6, 'test6@gmail.com', '$2y$12$rlYvaJyeO8PgXj4pAt49gug5ac603WtEhVVdLrdCRY4BEgg/s7bFe', 0, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(7, 'test7@gmail.com', '$2y$12$5R79a8HV6gg0VPQm0tyRfOhw3VHN7z8uS4bvLh3tueNzUt/9kTE42', 0, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(8, 'test8@gmail.com', '$2y$12$g9yp9DHCrrBoLYu6eSpsCuiP6IQmLlZh.2QdzF3Ip32oq6rVCuJP2', 0, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(9, 'test9@gmail.com', '$2y$12$Z8yMbfuC9jq5dCPvkmOzZeIzqkIarRObbXDLfsCJgYr3QTWVsZXue', 0, NULL, NULL, '2025-11-11 07:30:59', '2025-11-11 07:30:59'),
(10, 'test10@gmail.com', '$2y$12$.0/quNb.eCC5JMGlqNtrtOonEOEpv/nvoksBNhc7i9Qf6mdjHIVva', 0, NULL, NULL, '2025-11-11 07:31:00', '2025-11-11 07:31:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `verification_token` (`verification_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
