CREATE TABLE `villasdeguadalupe`.`prospectos` (`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(255) NOT NULL , `telefono` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `prospectos` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `email`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

ALTER TABLE `prospectos` ADD `status` VARCHAR(255) NULL AFTER `email`;

ALTER TABLE `prospectos` CHANGE `status` `status` INT NULL DEFAULT NULL;

ALTER TABLE `prospectos` CHANGE `status` `status` BIGINT(20) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `villasdeguadalupe`.`prospectos` ADD INDEX `prospectos_status_foreign` (`status`);

ALTER TABLE `prospectos` ADD CONSTRAINT `prospectos_status_foreign` FOREIGN KEY (`status`) REFERENCES `proceso_venta`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `prospectos` ADD `data` LONGTEXT NOT NULL AFTER `status`;

ALTER TABLE `prospectos` CHANGE `nombre` `nombre` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL, CHANGE `telefono` `telefono` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

ALTER TABLE `prospectos` CHANGE `data` `data` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
