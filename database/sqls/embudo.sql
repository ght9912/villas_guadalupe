CREATE TABLE `villasdeguadalupe`.`embudos` (`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(255) NOT NULL , `descripcion` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `embudos` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `descripcion`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

ALTER TABLE `embudos` ADD `formulario` LONGTEXT NOT NULL AFTER `descripcion`;

ALTER TABLE `embudos` CHANGE `formulario` `formulario` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
