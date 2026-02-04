-- --------------------------------------------------------
-- Newsletter Tables Creation Script
-- Run this file in phpMyAdmin or MySQL command line
-- Make sure to run newsletter_subscriptions first, then newsletter_sent
-- --------------------------------------------------------

-- Table structure for table `newsletter_subscriptions`
CREATE TABLE IF NOT EXISTS `newsletter_subscriptions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `subscribed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `unsubscribed_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscriptions_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `newsletter_sent`
CREATE TABLE IF NOT EXISTS `newsletter_sent` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `newsletter_subscription_id` BIGINT UNSIGNED NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `article_count` INT(11) NOT NULL COMMENT 'The milestone article count (5, 10, 15, etc.)',
  `sent_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_sent_newsletter_subscription_id_article_count_unique` (`newsletter_subscription_id`, `article_count`),
  KEY `newsletter_sent_newsletter_subscription_id_foreign` (`newsletter_subscription_id`),
  CONSTRAINT `newsletter_sent_newsletter_subscription_id_foreign` FOREIGN KEY (`newsletter_subscription_id`) REFERENCES `newsletter_subscriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
