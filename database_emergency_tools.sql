-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2025 at 04:11 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `msu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tm_checksheet_templates`
--

CREATE TABLE `tm_checksheet_templates` (
  `id` int NOT NULL,
  `equipment_type_id` int NOT NULL,
  `order_number` int NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `standar_condition` varchar(255) NOT NULL,
  `standar_picture_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tm_checksheet_templates`
--

INSERT INTO `tm_checksheet_templates` (`id`, `equipment_type_id`, `order_number`, `item_name`, `standar_condition`, `standar_picture_url`, `created_at`, `update_at`) VALUES
(14, 10, 1, 'Pin & Segel', 'Tepasang & segel tidak putus', 'standard_1754538191_7429.jpg', '2025-08-06 20:23:21', '2025-08-06 20:43:11'),
(15, 11, 1, 'Pin & Segel', 'Terterter', 'standard_1754538198_8830.jpg', '2025-08-06 20:30:35', '2025-08-06 20:43:18'),
(17, 10, 2, 'Label APAR', 'Tertempel, dapat dibaca dan tidak rusak', 'standard_1754539013_5656.jpg', '2025-08-06 20:56:53', '2025-08-07 03:56:53'),
(18, 19, 1, 'NOZZLE', 'TDK PENYOK', 'standard_1754540890_7164.png', '2025-08-06 21:28:10', '2025-08-07 04:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `tm_equipments`
--

CREATE TABLE `tm_equipments` (
  `id` int NOT NULL,
  `equipment_code` varchar(50) NOT NULL,
  `location_id` int NOT NULL,
  `equipment_type_id` int NOT NULL,
  `qrcode` varchar(100) DEFAULT NULL,
  `last_check_date` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive','maintenance') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tm_equipments`
--

INSERT INTO `tm_equipments` (`id`, `equipment_code`, `location_id`, `equipment_type_id`, `qrcode`, `last_check_date`, `status`, `created_at`, `update_at`) VALUES
(12, 'AP-002', 15, 10, 'assets/emergency_tools/img/qrcode/qr_ap_001_1754548280.png', '2025-08-08 02:31:16', 'active', '2025-08-07 06:31:21', '2025-08-10 20:09:19'),
(13, 'HYD-001', 23, 19, 'assets/emergency_tools/img/qrcode/qr_ap_002_1754548573.png', '2025-08-07 01:20:30', 'active', '2025-08-07 06:36:14', '2025-08-10 20:08:31'),
(15, 'AP-001', 27, 10, 'assets/emergency_tools/img/qrcode/qr_ap_003_1754881465.png', '2025-08-10 20:49:29', 'active', '2025-08-11 03:04:26', '2025-08-10 20:49:29'),
(16, 'TANDU-001', 29, 23, 'assets/emergency_tools/img/qrcode/qr_tandu_001_1754882830.png', NULL, 'active', '2025-08-11 03:27:11', '2025-08-11 03:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `tm_locations`
--

CREATE TABLE `tm_locations` (
  `id` int NOT NULL,
  `location_code` varchar(20) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `desc` text,
  `area_code` varchar(5) DEFAULT NULL,
  `area_x` decimal(10,6) DEFAULT NULL,
  `area_y` decimal(10,6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tm_locations`
--

INSERT INTO `tm_locations` (`id`, `location_code`, `location_name`, `desc`, `area_code`, `area_x`, `area_y`, `created_at`, `updated_at`) VALUES
(14, 'OFFICE-01', 'Plant Office', 'Area Office', 'A2', '176.200000', '575.850000', '2025-08-06 19:47:54', '2025-08-07 02:47:54'),
(15, 'OFFICE-02', 'ADM Office', 'Area Office', 'A2', '114.550000', '606.940000', '2025-08-06 19:51:36', '2025-08-07 19:23:09'),
(23, 'GATE-01', 'Pintu Keluar', '', 'D5', '483.850000', '934.330000', '2025-08-06 20:38:58', '2025-08-07 19:25:07'),
(27, 'PLANT-B2', 'Tiang B2', '', 'B4', '333.200000', '189.940000', '2025-08-10 20:03:53', '2025-08-11 03:03:53'),
(28, 'PPIC-001', 'Delivery', '', 'C5', '439.270000', '800.230000', '2025-08-10 20:12:10', '2025-08-11 03:12:10'),
(29, 'PLANT-B5', 'Jalan', '', 'B5', '449.100000', '128.220000', '2025-08-10 20:26:41', '2025-08-11 03:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `tm_master_equipment_types`
--

CREATE TABLE `tm_master_equipment_types` (
  `id` int NOT NULL,
  `equipment_name` varchar(100) NOT NULL,
  `equipment_type` varchar(50) NOT NULL,
  `desc` text,
  `icon_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tm_master_equipment_types`
--

INSERT INTO `tm_master_equipment_types` (`id`, `equipment_name`, `equipment_type`, `desc`, `icon_url`, `is_active`, `created_at`, `updated_at`) VALUES
(10, 'APAR', 'AF 11', 'Alat Pemadam Api Ringan', 'equipment_1754551764_7466.png', 1, '2025-08-06 02:01:22', '2025-08-07 00:29:24'),
(11, 'APAR', 'CO2', 'Alat Pemadam Api Ringan', 'equipment_1754551773_7652.png', 1, '2025-08-06 02:01:51', '2025-08-07 00:29:33'),
(15, 'APAR', 'FOAM', 'Alat Pemadam Api Ringan', 'equipment_1754551784_2735.png', 1, '2025-08-06 02:03:21', '2025-08-07 00:29:44'),
(19, 'HYDRANT', 'BOX', 'Alat Pemadam Api', 'equipment_1754551799_4916.png', 1, '2025-08-06 21:04:00', '2025-08-07 00:29:59'),
(20, 'HYDRANT', 'PILLAR', 'Alat Pemadam Api', 'equipment_1754551698_7549.png', 1, '2025-08-06 21:05:18', '2025-08-07 00:28:18'),
(23, 'TANDU', 'TANDU', '', 'equipment_1754882651_2223.jpg', 1, '2025-08-10 20:24:11', '2025-08-11 03:24:11');

-- --------------------------------------------------------

--
-- Table structure for table `tr_attachments`
--

CREATE TABLE `tr_attachments` (
  `id` int NOT NULL,
  `inspection_detail_id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_type` varchar(20) NOT NULL,
  `file_size` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tr_attachments`
--

INSERT INTO `tr_attachments` (`id`, `inspection_detail_id`, `file_path`, `file_name`, `file_type`, `file_size`, `created_at`) VALUES
(1, 19, 'attachment_001.jpg', 'Pin Segel Detail 1.jpg', 'image/jpeg', 1024, '2025-08-11 03:58:18'),
(2, 19, 'attachment_002.jpg', 'Pin Segel Detail 2.jpg', 'image/jpeg', 1024, '2025-08-11 03:58:18'),
(3, 20, 'attachment_003.jpg', 'Label APAR Close-up.jpg', 'image/jpeg', 1024, '2025-08-11 03:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `tr_inspections`
--

CREATE TABLE `tr_inspections` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `equipment_id` int NOT NULL,
  `inspection_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tr_inspections`
--

INSERT INTO `tr_inspections` (`id`, `user_id`, `equipment_id`, `inspection_date`, `notes`, `approval_status`, `approved_by`, `created_at`, `updated_at`) VALUES
(22, 3, 15, '2025-08-10 20:49:29', '', 'pending', NULL, '2025-08-11 03:49:29', '2025-08-11 03:49:29'),
(23, 1, 12, '2025-08-11 03:56:31', 'Test inspection dengan detail dan foto', 'pending', NULL, '2025-08-11 03:56:31', '2025-08-11 03:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `tr_inspection_details`
--

CREATE TABLE `tr_inspection_details` (
  `id` int NOT NULL,
  `inspection_id` int NOT NULL,
  `checksheet_item_id` int NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `note` text,
  `status` enum('ok','not_ok') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tr_inspection_details`
--

INSERT INTO `tr_inspection_details` (`id`, `inspection_id`, `checksheet_item_id`, `photo_url`, `note`, `status`, `created_at`) VALUES
(17, 22, 14, 'inspection/inspection_14_1754884169.png', '', 'ok', '2025-08-11 03:49:29'),
(18, 22, 17, 'inspection/inspection_17_1754884169.png', '', 'ok', '2025-08-11 03:49:29'),
(19, 23, 14, 'inspection_photo_001.jpg', 'Pin dan segel dalam kondisi baik - Kondisi normal', 'ok', '2025-08-11 03:57:58'),
(20, 23, 17, 'inspection_photo_002.jpg', 'Label APAR masih tertempel dengan baik - Label dapat dibaca dengan jelas', 'ok', '2025-08-11 03:57:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `npk` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('spv','inspector') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `npk`, `username`, `name`, `password`, `level`, `created_at`, `update_at`) VALUES
(1, 'SPV001', 'supervisor', 'John Supervisor', 'admin123', 'spv', '2025-08-06 04:43:39', '2025-08-07 00:11:05'),
(2, '71030', 'umrmaulana', 'Umar Maulana', 'Maulana1', 'spv', '2025-08-06 04:43:39', '2025-08-10 18:51:10'),
(3, '12051', 'inspector', 'Inspector 1', 'admin123', 'inspector', '2025-08-07 08:05:04', '2025-08-10 20:07:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tm_checksheet_templates`
--
ALTER TABLE `tm_checksheet_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_checksheet_equipment_type` (`equipment_type_id`);

--
-- Indexes for table `tm_equipments`
--
ALTER TABLE `tm_equipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipment_code` (`equipment_code`),
  ADD UNIQUE KEY `qrcode` (`qrcode`),
  ADD KEY `fk_equipment_location` (`location_id`),
  ADD KEY `fk_equipment_type` (`equipment_type_id`),
  ADD KEY `idx_last_check_date` (`last_check_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `tm_locations`
--
ALTER TABLE `tm_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tm_master_equipment_types`
--
ALTER TABLE `tm_master_equipment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tr_attachments`
--
ALTER TABLE `tr_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attachment_detail` (`inspection_detail_id`);

--
-- Indexes for table `tr_inspections`
--
ALTER TABLE `tr_inspections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inspection_user` (`user_id`),
  ADD KEY `fk_inspection_equipment` (`equipment_id`),
  ADD KEY `fk_inspection_approver` (`approved_by`),
  ADD KEY `idx_inspection_date` (`inspection_date`),
  ADD KEY `idx_approval_status` (`approval_status`);

--
-- Indexes for table `tr_inspection_details`
--
ALTER TABLE `tr_inspection_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_inspection` (`inspection_id`),
  ADD KEY `fk_detail_checksheet` (`checksheet_item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `npk` (`npk`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tm_checksheet_templates`
--
ALTER TABLE `tm_checksheet_templates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tm_equipments`
--
ALTER TABLE `tm_equipments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tm_locations`
--
ALTER TABLE `tm_locations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tm_master_equipment_types`
--
ALTER TABLE `tm_master_equipment_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tr_attachments`
--
ALTER TABLE `tr_attachments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tr_inspections`
--
ALTER TABLE `tr_inspections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tr_inspection_details`
--
ALTER TABLE `tr_inspection_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tm_checksheet_templates`
--
ALTER TABLE `tm_checksheet_templates`
  ADD CONSTRAINT `fk_checksheet_equipment_type` FOREIGN KEY (`equipment_type_id`) REFERENCES `tm_master_equipment_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tm_equipments`
--
ALTER TABLE `tm_equipments`
  ADD CONSTRAINT `fk_equipment_location` FOREIGN KEY (`location_id`) REFERENCES `tm_locations` (`id`),
  ADD CONSTRAINT `fk_equipment_type` FOREIGN KEY (`equipment_type_id`) REFERENCES `tm_master_equipment_types` (`id`);

--
-- Constraints for table `tr_attachments`
--
ALTER TABLE `tr_attachments`
  ADD CONSTRAINT `fk_attachment_detail` FOREIGN KEY (`inspection_detail_id`) REFERENCES `tr_inspection_details` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tr_inspections`
--
ALTER TABLE `tr_inspections`
  ADD CONSTRAINT `fk_inspection_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_inspection_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `tm_equipments` (`id`),
  ADD CONSTRAINT `fk_inspection_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tr_inspection_details`
--
ALTER TABLE `tr_inspection_details`
  ADD CONSTRAINT `fk_detail_checksheet` FOREIGN KEY (`checksheet_item_id`) REFERENCES `tm_checksheet_templates` (`id`),
  ADD CONSTRAINT `fk_detail_inspection` FOREIGN KEY (`inspection_id`) REFERENCES `tr_inspections` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
