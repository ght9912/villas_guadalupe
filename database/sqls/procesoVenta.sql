CREATE TABLE `villasdeguadalupe`.`proceso_venta` (`id` BIGINT NOT NULL AUTO_INCREMENT , `status` VARCHAR(255) NOT NULL , `descripcion` VARCHAR(255) NOT NULL , `seguimiento` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `proceso_venta` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `seguimiento`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

ALTER TABLE `proceso_venta` ADD `orden` FLOAT NOT NULL AFTER `id`;

ALTER TABLE `proceso_venta` ADD `id_embudo` BIGINT(20) UNSIGNED NOT NULL AFTER `id`;

ALTER TABLE `villasdeguadalupe`.`proceso_venta` ADD INDEX `proceso_venta_id_embudo_foreign` (`id_embudo`);

ALTER TABLE `proceso_venta` ADD CONSTRAINT `proceso_venta_id_embudo_foreign` FOREIGN KEY (`id_embudo`) REFERENCES `embudos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
