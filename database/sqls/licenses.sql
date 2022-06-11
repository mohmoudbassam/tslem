CREATE TABLE `licenses`
(
    `id`                       BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `raft_company_id`          BIGINT UNSIGNED NULL DEFAULT NULL,
    `box_raft_company_box_id`  BIGINT UNSIGNED NULL DEFAULT NULL,
    `camp_raft_company_box_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `date`                     TIMESTAMP NULL DEFAULT NULL,
    `expiry_date`              TIMESTAMP NULL DEFAULT NULL,
    `tents_count`              INT NULL DEFAULT '0',
    `person_count`             INT NULL DEFAULT '0',
    `camp_space`               DOUBLE NULL DEFAULT '0',
    `created_at`               TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`               TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX (`raft_company_id`),
    INDEX (`box_raft_company_box_id`),
    INDEX (`camp_raft_company_box_id`)
) ENGINE = InnoDB;
