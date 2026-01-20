-- --------------------------------------------------------
-- Table structure for table `stp_article_category`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `stp_article_category` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(255) NOT NULL,
  `color_code` VARCHAR(50) NOT NULL,
  `description` TEXT NULL,
  `data_status` INT NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Disable',
  `updated_by` INT NULL,
  `created_by` INT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_data_status` (`data_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Sample data (optional - uncomment if you want to insert sample data)
-- --------------------------------------------------------

-- INSERT INTO `stp_article_category` (`category_name`, `color_code`, `description`, `data_status`, `created_at`, `updated_at`) VALUES
-- ('UNIVERSITY NEWS', '#B71A18', 'Lorem ipsum dolor si amet', 1, NOW(), NOW()),
-- ('STUDY GUIDES', '#B71A18', 'Lorem ipsum dolor si amet', 1, NOW(), NOW()),
-- ('CAREER INSIGHTS', '#B71A18', 'Lorem ipsum dolor si amet', 1, NOW(), NOW()),
-- ('RESEARCH & INNOVATION', '#B71A18', 'Lorem ipsum dolor si amet', 1, NOW(), NOW()),
-- ('STUDY ABROAD', '#B71A18', 'Lorem ipsum dolor si amet', 1, NOW(), NOW()),
-- ('STUDENT LIFE', '#B71A18', 'Lorem ipsum dolor si amet', 1, NOW(), NOW());

