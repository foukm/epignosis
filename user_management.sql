-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 04 Φεβ 2025 στις 10:16:04
-- Έκδοση διακομιστή: 10.4.28-MariaDB
-- Έκδοση PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `user_management`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `employee_code` char(7) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employee','manager') DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `employee_code`, `password`, `role`) VALUES
(1, 'admin', 'admin1111@example.com', '1234567', '$2y$10$yKvAhqcjyr462URzSBu3hOVR9Cm20Mr2GdAukdzqumjoubGv3AO6S', 'manager'),
(2, 'admin1', 'foukakimaria@gmail.com', '1234', '$2y$10$lZmrq2UZSGCz/Il/Hkq5o.oUrLC9EiWDSlnLwkWQaYmSfDTqjoj1u', 'employee'),
(20, 'employee1', 'eadam@gmail.com', '1234943', '$2y$10$LdnDPSrq8r595VEGBXBVnO504uyjiZ5DDhPjlC/foSfJpC2Y6TKEm', 'employee');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `vacation_requests`
--

CREATE TABLE `vacation_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `vacation_requests`
--

INSERT INTO `vacation_requests` (`id`, `user_id`, `start_date`, `end_date`, `reason`, `status`, `created_at`) VALUES
(1, 2, '2025-02-03', '2025-02-21', 'dsgdfg', 'approved', '2025-02-01 09:45:39'),
(2, 2, '2025-02-03', '2025-02-21', 'dsgdfg', 'rejected', '2025-02-01 09:46:20'),
(4, 2, '2025-02-02', '2025-02-14', 'jhj', 'rejected', '2025-02-01 19:34:50'),
(13, 2, '2025-02-18', '2025-02-22', 'k', 'approved', '2025-02-03 17:36:51'),
(14, 2, '2025-02-16', '2025-02-25', 'ddsfsdf', 'approved', '2025-02-03 17:43:35'),
(18, 20, '2025-02-09', '2025-02-15', 'I have to go to the doctor', 'approved', '2025-02-04 08:40:48'),
(19, 20, '2025-02-23', '2025-02-28', '-', 'rejected', '2025-02-04 08:41:01'),
(22, 20, '2025-02-25', '2025-02-28', '--', 'approved', '2025-02-04 08:48:49');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `employee_code` (`employee_code`);

--
-- Ευρετήρια για πίνακα `vacation_requests`
--
ALTER TABLE `vacation_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT για πίνακα `vacation_requests`
--
ALTER TABLE `vacation_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `vacation_requests`
--
ALTER TABLE `vacation_requests`
  ADD CONSTRAINT `vacation_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
