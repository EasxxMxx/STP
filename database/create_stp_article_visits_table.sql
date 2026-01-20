-- --------------------------------------------------------
-- Table structure for table `stp_article_visits`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `stp_article_visits` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` BIGINT UNSIGNED NULL,
  `totalNumberVisit` INT NULL,
  `status` INT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Disable',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_article_id` (`article_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_at` (`created_at`),
  CONSTRAINT `fk_stp_article_visits_article`
    FOREIGN KEY (`article_id`)
    REFERENCES `stp_article` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

