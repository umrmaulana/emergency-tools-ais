-- Database: emergency-tool
-- Sistem Emergency Tools AIS

-- ===============================================
-- TABEL USERS
-- ===============================================
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `npk` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('spv','inspector') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `npk` (`npk`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
-- TABEL LOCATIONS
-- ===============================================
CREATE TABLE `tm_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_code` varchar(20) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `desc` text,
  `area_code` varchar(5) DEFAULT NULL,
  `area_x` int(11) DEFAULT NULL,
  `area_y` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
-- TABEL MASTER EQUIPMENT TYPES
-- ===============================================
CREATE TABLE `tm_master_equipment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_name` varchar(100) NOT NULL,
  `equipment_type` varchar(50) NOT NULL,
  `desc` text,
  `icon_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
-- TABEL CHECKSHEET TEMPLATES
-- ===============================================
CREATE TABLE `tm_checksheet_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_type_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `standar_condition` varchar(255) NOT NULL,
  `standar_picture_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_checksheet_equipment_type` (`equipment_type_id`),
  CONSTRAINT `fk_checksheet_equipment_type` FOREIGN KEY (`equipment_type_id`) REFERENCES `tm_master_equipment_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
-- TABEL EQUIPMENTS
-- ===============================================
CREATE TABLE `tm_equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipment_code` varchar(50) NOT NULL,
  `location_id` int(11) NOT NULL,
  `equipment_type_id` int(11) NOT NULL,
  `qrcode` varchar(100) DEFAULT NULL,
  `last_check_date` timestamp NULL,
  `status` enum('active','inactive','maintenance') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipment_code` (`equipment_code`),
  UNIQUE KEY `qrcode` (`qrcode`),
  KEY `fk_equipment_location` (`location_id`),
  KEY `fk_equipment_type` (`equipment_type_id`),
  CONSTRAINT `fk_equipment_location` FOREIGN KEY (`location_id`) REFERENCES `tm_locations` (`id`),
  CONSTRAINT `fk_equipment_type` FOREIGN KEY (`equipment_type_id`) REFERENCES `tm_master_equipment_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
-- TABEL INSPECTIONS
-- ===============================================
CREATE TABLE `tr_inspections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `inspection_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_inspection_user` (`user_id`),
  KEY `fk_inspection_equipment` (`equipment_id`),
  KEY `fk_inspection_approver` (`approved_by`),
  CONSTRAINT `fk_inspection_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_inspection_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `tm_equipments` (`id`),
  CONSTRAINT `fk_inspection_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
-- TABEL INSPECTION DETAILS
-- ===============================================
CREATE TABLE `tr_inspection_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inspection_id` int(11) NOT NULL,
  `checksheet_item_id` int(11) NOT NULL,
  `actual_condition` varchar(255) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `note` text,
  `status` enum('ok','not_ok') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_detail_inspection` (`inspection_id`),
  KEY `fk_detail_checksheet` (`checksheet_item_id`),
  CONSTRAINT `fk_detail_inspection` FOREIGN KEY (`inspection_id`) REFERENCES `tr_inspections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_detail_checksheet` FOREIGN KEY (`checksheet_item_id`) REFERENCES `tm_checksheet_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
-- TABEL ATTACHMENTS  
-- ===============================================
CREATE TABLE `tr_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inspection_detail_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_type` varchar(20) NOT NULL,
  `file_size` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_attachment_detail` (`inspection_detail_id`),
  CONSTRAINT `fk_attachment_detail` FOREIGN KEY (`inspection_detail_id`) REFERENCES `tr_inspection_details` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===============================================
-- DATA SAMPLE
-- ===============================================

-- Insert sample users (hanya supervisor)
INSERT INTO `users` (`npk`, `username`, `name`, `password`, `level`) VALUES
('SPV001', 'supervisor', 'John Supervisor', 'admin123', 'spv'),
('SPV002', 'supervisor2', 'Jane Supervisor', 'admin123', 'spv');

-- Insert sample locations
INSERT INTO `tm_locations` (`location_code`, `location_name`, `desc`, `area_x`, `area_y`, `area_code`, `created_at`, `updated_at`) 
VALUES 
('LOC-A1', 'Area Produksi A', 'Area produksi utama lantai 1', 0, 0, 'A1', NOW(), NOW()),
('LOC-B2', 'Area Produksi B', 'Area produksi lantai 2', 1, 1, 'B2', NOW(), NOW()),
('LOC-C3', 'Gudang Material', 'Gudang penyimpanan material dan spare part', 2, 2, 'C3', NOW(), NOW()),
('LOC-D4', 'Area Quality Control', 'Area pengecekan kualitas produk', 3, 3, 'D4', NOW(), NOW()),
('LOC-A5', 'Area Packaging', 'Area pengemasan dan finishing', 4, 0, 'A5', NOW(), NOW());

-- Insert sample equipment types
INSERT INTO `tm_master_equipment_types` (`equipment_name`, `equipment_type`, `desc`, `is_active`) VALUES
('Fire Extinguisher', 'APAR', 'Alat Pemadam Api Ringan', 1),
('Emergency Light', 'LAMPU_DARURAT', 'Lampu penerangan darurat', 1),
('First Aid Kit', 'P3K', 'Kotak Pertolongan Pertama Pada Kecelakaan', 1),
('Emergency Phone', 'TELEPON_DARURAT', 'Telepon untuk situasi darurat', 1),
('Safety Shower', 'SHOWER_DARURAT', 'Shower darurat untuk kecelakaan kimia', 1);

-- Insert sample checksheet templates
INSERT INTO `tm_checksheet_templates` (`equipment_type_id`, `order_number`, `item_name`, `standar_condition`) VALUES
-- Fire Extinguisher checklist
(1, 1, 'Kondisi Tabung', 'Tidak berkarat, tidak penyok, tidak bocor'),
(1, 2, 'Pressure Gauge', 'Jarum menunjuk area hijau (normal)'),
(1, 3, 'Safety Pin', 'Terpasang dengan baik dan tidak rusak'),
(1, 4, 'Selang dan Nozzle', 'Tidak retak, tidak tersumbat'),
(1, 5, 'Label dan Tanggal', 'Jelas terbaca dan belum expired'),

-- Emergency Light checklist  
(2, 1, 'Kondisi Lampu', 'Tidak retak, tidak pecah'),
(2, 2, 'Brightness Test', 'Menyala terang saat test button ditekan'),
(2, 3, 'Battery Indicator', 'LED indikator menunjukkan charging normal'),
(2, 4, 'Mounting', 'Terpasang kuat dan tidak goyang'),

-- First Aid Kit checklist
(3, 1, 'Kondisi Box', 'Tidak rusak, mudah dibuka/tutup'),
(3, 2, 'Kelengkapan Isi', 'Sesuai dengan checklist standar P3K'),
(3, 3, 'Tanggal Expired', 'Semua item belum expired'),
(3, 4, 'Kebersihan', 'Bersih dari debu dan kotoran');

-- Insert sample equipments
INSERT INTO `tm_equipments` (`equipment_code`, `location_id`, `equipment_type_id`, `qrcode`, `status`) VALUES
('APAR-PA-001', 1, 1, 'QR_APAR_PA_001', 'active'),
('APAR-PA-002', 1, 1, 'QR_APAR_PA_002', 'active'),
('APAR-PB-001', 2, 1, 'QR_APAR_PB_001', 'active'),
('LAMP-PA-001', 1, 2, 'QR_LAMP_PA_001', 'active'),
('LAMP-PB-001', 2, 2, 'QR_LAMP_PB_001', 'active'),
('P3K-PA-001', 1, 3, 'QR_P3K_PA_001', 'active'),
('P3K-GU-001', 3, 3, 'QR_P3K_GU_001', 'active'),
('TEL-OF-001', 4, 4, 'QR_TEL_OF_001', 'active');

-- ===============================================
-- INDEXES UNTUK PERFORMANCE
-- ===============================================
ALTER TABLE `tr_inspections` ADD INDEX `idx_inspection_date` (`inspection_date`);
ALTER TABLE `tr_inspections` ADD INDEX `idx_approval_status` (`approval_status`);
ALTER TABLE `tm_equipments` ADD INDEX `idx_last_check_date` (`last_check_date`);
ALTER TABLE `tm_equipments` ADD INDEX `idx_status` (`status`);

COMMIT;
