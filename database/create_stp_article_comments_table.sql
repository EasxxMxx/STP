-- --------------------------------------------------------
-- Table structure for table `stp_article_comments`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `stp_article_comments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` BIGINT UNSIGNED NOT NULL,
  `student_id` BIGINT UNSIGNED NULL COMMENT 'NULL if anonymous comment',
  `parent_id` BIGINT UNSIGNED NULL COMMENT 'Parent comment ID for nesting. NULL for Level 1 comments',
  `reply_to_id` BIGINT UNSIGNED NULL COMMENT 'The actual comment being replied to. Can be NULL if reply tag removed',
  `comment_level` TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 = Level 1, 2 = Level 2, 3 = Level 3',
  `comment_text` TEXT NOT NULL,
  `author_name` VARCHAR(255) NULL COMMENT 'Name if anonymous comment (when student_id is NULL)',
  `data_status` INT NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Deleted',
  `updated_by` INT NULL,
  `created_by` INT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_article_id` (`article_id`),
  INDEX `idx_student_id` (`student_id`),
  INDEX `idx_parent_id` (`parent_id`),
  INDEX `idx_reply_to_id` (`reply_to_id`),
  INDEX `idx_comment_level` (`comment_level`),
  INDEX `idx_data_status` (`data_status`),
  CONSTRAINT `fk_stp_article_comments_article`
    FOREIGN KEY (`article_id`)
    REFERENCES `stp_article` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_stp_article_comments_student`
    FOREIGN KEY (`student_id`)
    REFERENCES `stp_students` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_stp_article_comments_parent`
    FOREIGN KEY (`parent_id`)
    REFERENCES `stp_article_comments` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_stp_article_comments_reply_to`
    FOREIGN KEY (`reply_to_id`)
    REFERENCES `stp_article_comments` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
