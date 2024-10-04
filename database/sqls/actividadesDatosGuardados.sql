CREATE TABLE `villasdeguadalupe`.`actividades_datos` (`id` BIGINT NOT NULL AUTO_INCREMENT , `id_actividad` BIGINT NOT NULL , `data` JSON NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `actividades_datos` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `data`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

ALTER TABLE `villasdeguadalupe`.`actividades_datos` ADD INDEX `actividades_datos_id_actividad_foreign` (`id_actividad`);

ALTER TABLE `actividades_datos` ADD CONSTRAINT `actividades_datos_id_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividades`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
