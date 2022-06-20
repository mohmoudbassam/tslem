
CREATE TABLE `news_articles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint(1) DEFAULT '0',
  `sort_order` mediumint UNSIGNED DEFAULT '0',
  `user_id` double UNSIGNED DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `news_articles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `news_articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
