-- --------------------------------------------------------
-- Table structure for table `stp_article_content_images`
-- Updated: Removed image_order column (ID-based system)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `stp_article_content_images` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` BIGINT UNSIGNED NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `image_alt` VARCHAR(255) NULL COMMENT 'Alt text for image',
  `data_status` INT NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Disable',
  `updated_by` INT NULL,
  `created_by` INT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_article_id` (`article_id`),
  INDEX `idx_data_status` (`data_status`),
  CONSTRAINT `fk_stp_article_content_images_article`
    FOREIGN KEY (`article_id`)
    REFERENCES `stp_article` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

