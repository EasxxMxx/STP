-- --------------------------------------------------------
-- Table structure for table `stp_article`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `stp_article` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` BIGINT UNSIGNED NULL,
  `article_title` VARCHAR(255) NOT NULL,
  `article_author` VARCHAR(255) NOT NULL,
  `article_date` DATE NOT NULL,
  `article_featured` INT NOT NULL DEFAULT 0 COMMENT '0 = No, 1 = Yes',
  `article_views` INT NOT NULL DEFAULT 0,
  `article_featured_image` VARCHAR(255) NULL,
  `article_summary` TEXT NULL,
  `article_main_points_1` VARCHAR(255) NULL,
  `article_main_points_2` VARCHAR(255) NULL,
  `article_main_points_3` VARCHAR(255) NULL,
  `article_content` VARCHAR(255) NULL COMMENT 'Path to HTML file containing article content',
  `data_status` INT NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Disable',
  `updated_by` INT NULL,
  `created_by` INT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_category_id` (`category_id`),
  INDEX `idx_data_status` (`data_status`),
  INDEX `idx_article_featured` (`article_featured`),
  CONSTRAINT `fk_stp_article_category`
    FOREIGN KEY (`category_id`)
    REFERENCES `stp_article_category` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Sample data (optional - uncomment if you want to insert sample data)
-- Note: Make sure stp_article_category table has data first
-- --------------------------------------------------------

-- INSERT INTO `stp_article` (`category_id`, `article_title`, `article_author`, `article_date`, `article_featured`, `article_views`, `article_summary`, `article_main_points_1`, `article_main_points_2`, `article_main_points_3`, `data_status`, `created_at`, `updated_at`) VALUES
-- (1, '10 Ways To Maximize Your Restaurant Loyalty Rewards', 'John Doe', CURDATE(), 0, 0, 'Discover how to get the most out of your restaurant loyalty programs.', 'Point 1: Sign up for multiple programs', 'Point 2: Track your points regularly', 'Point 3: Use rewards strategically', 1, NOW(), NOW()),
-- (1, 'Understanding Career Paths in Technology', 'Jane Smith', CURDATE(), 1, 0, 'A comprehensive guide to technology career opportunities.', 'Point 1: Explore different tech roles', 'Point 2: Build relevant skills', 'Point 3: Network with professionals', 1, NOW(), NOW());

