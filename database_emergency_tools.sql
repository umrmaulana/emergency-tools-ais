-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2025 at 12:49 AM
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
-- Database: `emergency_tool`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tm_checksheet_templates`
--

INSERT INTO `tm_checksheet_templates` (`id`, `equipment_type_id`, `order_number`, `item_name`, `standar_condition`, `standar_picture_url`, `created_at`, `update_at`) VALUES
(1, 1, 1, 'Kondisi Tabung', 'Tidak berkarat, tidak penyok, tidak bocor', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(2, 1, 2, 'Pressure Gauge', 'Jarum menunjuk area hijau (normal)', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(3, 1, 3, 'Safety Pin', 'Terpasang dengan baik dan tidak rusak', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(4, 1, 4, 'Selang dan Nozzle', 'Tidak retak, tidak tersumbat', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(5, 1, 5, 'Label dan Tanggal', 'Jelas terbaca dan belum expired', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(6, 2, 1, 'Kondisi Lampu', 'Tidak retak, tidak pecah', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(7, 2, 2, 'Brightness Test', 'Menyala terang saat test button ditekan', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(8, 2, 3, 'Battery Indicator', 'LED indikator menunjukkan charging normal', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(9, 2, 4, 'Mounting', 'Terpasang kuat dan tidak goyang', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(10, 3, 1, 'Kondisi Box', 'Tidak rusak, mudah dibuka/tutup', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(11, 3, 2, 'Kelengkapan Isi', 'Sesuai dengan checklist standar P3K', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(12, 3, 3, 'Tanggal Expired', 'Semua item belum expired', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(13, 3, 4, 'Kebersihan', 'Bersih dari debu dan kotoran', NULL, '2025-08-06 04:43:39', '2025-08-06 04:43:39');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tm_equipments`
--

INSERT INTO `tm_equipments` (`id`, `equipment_code`, `location_id`, `equipment_type_id`, `qrcode`, `last_check_date`, `status`, `created_at`, `update_at`) VALUES
(1, 'APAR-PA-001', 1, 1, 'QR_APAR_PA_001', NULL, 'active', '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(2, 'APAR-PA-002', 1, 1, 'QR_APAR_PA_002', NULL, 'active', '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(3, 'APAR-PB-001', 2, 1, 'QR_APAR_PB_001', NULL, 'active', '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(4, 'LAMP-PA-001', 1, 2, 'QR_LAMP_PA_001', NULL, 'active', '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(5, 'LAMP-PB-001', 2, 2, 'QR_LAMP_PB_001', NULL, 'active', '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(6, 'P3K-PA-001', 1, 3, 'QR_P3K_PA_001', NULL, 'active', '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(7, 'P3K-GU-001', 3, 3, 'QR_P3K_GU_001', NULL, 'active', '2025-08-06 04:43:39', '2025-08-06 04:43:39'),
(8, 'TEL-OF-001', 4, 4, 'QR_TEL_OF_001', NULL, 'active', '2025-08-06 04:43:39', '2025-08-06 04:43:39');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tm_locations`
--

INSERT INTO `tm_locations` (`id`, `location_code`, `location_name`, `desc`, `area_code`, `area_x`, `area_y`, `created_at`, `updated_at`) VALUES
(1, 'LOC-B6', 'Area Produksi A', 'Area produksi utama lantai 1', 'B6', -6.200000, 106.816666, '2025-08-06 04:43:39', '2025-08-05 23:41:59'),
(2, 'LOC-B2', 'Area Produksi B', '', 'B2', -6.201000, 106.817000, '2025-08-06 04:43:39', '2025-08-06 00:46:43'),
(3, 'LOC-C3', 'Gudang Material', '', 'C3', -6.202000, 106.818000, '2025-08-06 04:43:39', '2025-08-06 00:46:59'),
(4, 'LOC-D4', 'Area Quality Control', '', 'D4', -6.203000, 106.819000, '2025-08-06 04:43:39', '2025-08-06 00:47:11');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tm_master_equipment_types`
--

INSERT INTO `tm_master_equipment_types` (`id`, `equipment_name`, `equipment_type`, `desc`, `icon_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fire Extinguisher', 'APAR', 'Alat Pemadam Api Ringan', 'fire-extinguisher.svg', 1, '2025-08-06 04:43:39', '2025-08-06 08:50:19'),
(2, 'Emergency Light', 'LAMPU_DARURAT', 'Lampu penerangan darurat', 'emergency-light.svg', 1, '2025-08-06 04:43:39', '2025-08-06 08:50:19'),
(3, 'First Aid Kit', 'P3K', 'Kotak Pertolongan Pertama Pada Kecelakaan', 'first-aid.svg', 1, '2025-08-06 04:43:39', '2025-08-06 08:50:19'),
(4, 'Emergency Phone', 'TELEPON_DARURAT', 'Telepon untuk situasi darurat', NULL, 1, '2025-08-06 04:43:39', '2025-08-06 08:44:31'),
(10, 'APAR', 'APAR AF 11', 'Alat Pemadam Api Ringan', 'equipment_1754470893_1741.png', 1, '2025-08-06 02:01:22', '2025-08-06 02:01:33'),
(11, 'APAR', 'APAR CO2', 'Alat Pemadam Api Ringan', 'equipment_1754470911_9754.png', 1, '2025-08-06 02:01:51', '2025-08-06 09:01:51'),
(12, 'APAR', 'APAR POWDER', 'Alat Pemadam Api Ringan', 'equipment_1754470932_1949.png', 1, '2025-08-06 02:02:12', '2025-08-06 09:02:12'),
(13, 'APAR', 'APAR HALLOTRON', 'Alat Pemadam Api Ringan', 'equipment_1754470963_3956.png', 1, '2025-08-06 02:02:43', '2025-08-06 09:02:43'),
(15, 'APAR', 'APAR FOAM', 'Alat Pemadam Api Ringan', 'equipment_1754471001_1232.png', 1, '2025-08-06 02:03:21', '2025-08-06 09:03:21');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tr_inspection_details`
--

CREATE TABLE `tr_inspection_details` (
  `id` int NOT NULL,
  `inspection_id` int NOT NULL,
  `checksheet_item_id` int NOT NULL,
  `actual_condition` varchar(255) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `note` text,
  `status` enum('ok','not_ok') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `npk`, `username`, `name`, `password`, `level`, `created_at`, `update_at`) VALUES
(1, 'SPV001', 'supervisor', 'John Supervisor', 'admin123', 'spv', '2025-08-06 04:43:39', '2025-08-06 17:46:27'),
(2, 'SPV002', 'supervisor2', 'Jane Supervisor', 'admin123', 'spv', '2025-08-06 04:43:39', '2025-08-06 04:43:39');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tm_equipments`
--
ALTER TABLE `tm_equipments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tm_locations`
--
ALTER TABLE `tm_locations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tm_master_equipment_types`
--
ALTER TABLE `tm_master_equipment_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tr_attachments`
--
ALTER TABLE `tr_attachments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_inspections`
--
ALTER TABLE `tr_inspections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_inspection_details`
--
ALTER TABLE `tr_inspection_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
