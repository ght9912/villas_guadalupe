CREATE TABLE `villasdeguadalupe`.`caracteristicas_empresa` (`id` BIGINT(20) NOT NULL AUTO_INCREMENT , `icono` VARCHAR(255) NULL , `titulo` TEXT NULL , `descripcion_cor` TEXT NULL , `descripcion_lar` TEXT NULL , `tipo` VARCHAR(30) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `caracteristicas_empresa` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `tipo`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;
