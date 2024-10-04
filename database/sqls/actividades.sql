CREATE TABLE `villasdeguadalupe`.`actividades` (`id` BIGINT NOT NULL AUTO_INCREMENT , `id_vendedor` BIGINT UNSIGNED NOT NULL , `movimiento` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `actividades` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `movimiento`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

ALTER TABLE `villasdeguadalupe`.`actividades` ADD INDEX `actividades_id_vendedor_foreign` (`id_vendedor`);

ALTER TABLE `actividades` ADD CONSTRAINT `actividades_id_vendedor_foreign` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedores`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `actividades` CHANGE `id_vendedor` `id_user` BIGINT(20) UNSIGNED NOT NULL;

ALTER TABLE `villasdeguadalupe`.`actividades` DROP INDEX `actividades_id_vendedor_foreign`, ADD INDEX `actividades_id_user_foreign` (`id_user`) USING BTREE;

ALTER TABLE `actividades` DROP FOREIGN KEY `actividades_id_vendedor_foreign`; ALTER TABLE `actividades` ADD CONSTRAINT `actividades_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
