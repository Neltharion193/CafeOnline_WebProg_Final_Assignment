-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2022 at 04:32 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafeonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_header_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_headers`
--

CREATE TABLE `cart_headers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_headers`
--

INSERT INTO `cart_headers` (`id`, `user_id`, `status`) VALUES
(1, 9, 'Not Finalized'),
(2, 4, 'Not Finalized');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2021_12_01_141851_create_msusertype_table', 1),
(3, '2021_12_01_142654_create_msuser_table', 1),
(4, '2021_12_01_143309_create_msproducttype_table', 1),
(5, '2021_12_01_143528_create_msproduct_table', 1),
(12, '2021_12_01_144246_create_trheader_table', 2),
(13, '2021_12_01_144301_create_trdetail_table', 2),
(14, '2021_12_27_091105_create_cart_header_table', 3),
(15, '2021_12_27_091310_create_cart_detail_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ms_products`
--

CREATE TABLE `ms_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL,
  `imagepath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms_products`
--

INSERT INTO `ms_products` (`id`, `product_type_id`, `name`, `description`, `price`, `stock`, `imagepath`) VALUES
(1, 1, 'Spaghetti Bolognese', 'Spaghetti sangat lezat', 50000, 8, 'images/1640600572.jpg'),
(2, 1, 'Wagyu Steak', 'Steak sangat lembut', 100000, 9, 'images/1640600599.jpg'),
(3, 2, 'Triple Chocolate Cake', 'Kue yang sangat berasa coklatnya', 25000, 13, 'images/1640600652.jpg'),
(4, 2, 'Cheese Pudding', 'Keju pada pudding ini sangat mantap', 15000, 18, 'images/1640600679.jpg'),
(5, 3, 'Sprite', 'minuman segar', 5000, 18, 'images/1640600711.jpg'),
(6, 3, 'Coca Cola', 'minuman soda', 5000, 17, 'images/1640600733.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ms_product_types`
--

CREATE TABLE `ms_product_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producttype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms_product_types`
--

INSERT INTO `ms_product_types` (`id`, `producttype`) VALUES
(1, 'Main Course'),
(2, 'Dessert'),
(3, 'Beverages');

-- --------------------------------------------------------

--
-- Table structure for table `ms_users`
--

CREATE TABLE `ms_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type_id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms_users`
--

INSERT INTO `ms_users` (`id`, `user_type_id`, `fullname`, `email`, `password`, `address`, `gender`) VALUES
(1, 1, 'AdminOps', 'admin@gmail.com', '$2a$10$pSga7LPP0nOYmUffcTfs0OimIXWN9Ag.ftKP3PMfqUO55kQM6/6lG', 'Jl. Admin Jaya No. 11', 'male'),
(4, 3, 'tester1', 'tester@gmail.com', '$2y$10$.6lmEN37nYTZV0yoNhr7xuedHxuV8Ka62cse3m.khZj4BoNL5E9Sa', 'Jl. Tester No. 31', 'female'),
(5, 2, 'Staff1', 'staff@yahoo.com', '$2y$10$vTEpo6HqEo8esU/uj7BVUOlHW2/zy5PL/JO5rG/dzbYFgtQpyD17y', 'Jl. Staff No. 21', 'male'),
(6, 3, 'tester2', 'tester2@gmail.com', '$2y$10$kFMzD2myzeVAlaorKlJ/zeLdUPaL9yWCyQnAnR9ngYp4l7NyoOGQ2', 'Jl. Test 2', 'male'),
(9, 3, 'Bambang', 'bambang@gmail.com', '$2y$10$snI5NcAMk1GCAkRAHIbpiuCmlKOxBU/0YkMjNS0tExHc7NNDqNHDC', 'Jl. Bambang 1', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `ms_user_types`
--

CREATE TABLE `ms_user_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usertype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ms_user_types`
--

INSERT INTO `ms_user_types` (`id`, `usertype`) VALUES
(1, 'Admin'),
(2, 'Staff'),
(3, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tr_details`
--

CREATE TABLE `tr_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `header_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tr_details`
--

INSERT INTO `tr_details` (`id`, `header_transaction_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 1, 5, 1),
(3, 2, 3, 1),
(4, 2, 6, 1),
(5, 3, 4, 1),
(6, 3, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tr_headers`
--

CREATE TABLE `tr_headers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tr_headers`
--

INSERT INTO `tr_headers` (`id`, `user_id`, `staff_id`, `transaction_date`) VALUES
(1, 9, 5, '2022-01-13 21:34:58'),
(2, 4, 1, '2022-01-13 21:39:25'),
(3, 9, 5, '2022-01-13 21:46:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_details_cart_header_id_foreign` (`cart_header_id`),
  ADD KEY `cart_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `cart_headers`
--
ALTER TABLE `cart_headers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_headers_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ms_products`
--
ALTER TABLE `ms_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ms_products_product_type_id_foreign` (`product_type_id`);

--
-- Indexes for table `ms_product_types`
--
ALTER TABLE `ms_product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ms_users`
--
ALTER TABLE `ms_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ms_users_email_unique` (`email`),
  ADD KEY `ms_users_user_type_id_foreign` (`user_type_id`);

--
-- Indexes for table `ms_user_types`
--
ALTER TABLE `ms_user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tr_details`
--
ALTER TABLE `tr_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tr_details_header_transaction_id_foreign` (`header_transaction_id`),
  ADD KEY `tr_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `tr_headers`
--
ALTER TABLE `tr_headers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tr_headers_user_id_foreign` (`user_id`),
  ADD KEY `tr_headers_staff_id_foreign` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart_headers`
--
ALTER TABLE `cart_headers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ms_products`
--
ALTER TABLE `ms_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ms_product_types`
--
ALTER TABLE `ms_product_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ms_users`
--
ALTER TABLE `ms_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ms_user_types`
--
ALTER TABLE `ms_user_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_details`
--
ALTER TABLE `tr_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tr_headers`
--
ALTER TABLE `tr_headers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `cart_details_cart_header_id_foreign` FOREIGN KEY (`cart_header_id`) REFERENCES `cart_headers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ms_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_headers`
--
ALTER TABLE `cart_headers`
  ADD CONSTRAINT `cart_headers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ms_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ms_products`
--
ALTER TABLE `ms_products`
  ADD CONSTRAINT `ms_products_product_type_id_foreign` FOREIGN KEY (`product_type_id`) REFERENCES `ms_product_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ms_users`
--
ALTER TABLE `ms_users`
  ADD CONSTRAINT `ms_users_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `ms_user_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tr_details`
--
ALTER TABLE `tr_details`
  ADD CONSTRAINT `tr_details_header_transaction_id_foreign` FOREIGN KEY (`header_transaction_id`) REFERENCES `tr_headers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tr_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ms_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tr_headers`
--
ALTER TABLE `tr_headers`
  ADD CONSTRAINT `tr_headers_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `ms_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tr_headers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ms_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
