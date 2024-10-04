CREATE TABLE `villasdeguadalupe`.`calendariotareas` (`id` BIGINT NOT NULL AUTO_INCREMENT , `id_vendedor` BIGINT NOT NULL , `nombre_tarea` VARCHAR(255) NOT NULL , `descripcion_tarea` VARCHAR(255) NOT NULL , `fecha` DATETIME NOT NULL , `created_at` TIMESTAMP NULL DEFAULT NULL , `updated_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `villasdeguadalupe`.`calendariotareas` ADD INDEX `calendariotareas_id_vendedor_foreign` (`id_vendedor`);

ALTER TABLE `calendariotareas` CHANGE `id_vendedor` `id_vendedor` BIGINT(20) UNSIGNED NOT NULL;

ALTER TABLE `calendariotareas` ADD CONSTRAINT `calendariotareas_id_vendedor_foreign` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedores`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `calendariotareas` CHANGE `fecha` `fecha_inicio` DATETIME NOT NULL;

ALTER TABLE `calendariotareas` ADD `fecha_fin` DATETIME NULL AFTER `fecha_inicio`;

ALTER TABLE `calendariotareas` CHANGE `fecha_fin` `fecha_fin` DATETIME NOT NULL;

ALTER TABLE `calendariotareas` DROP INDEX `calendariotareas_id_vendedor_foreign`;

ALTER TABLE `calendariotareas` DROP FOREIGN KEY `calendariotareas_id_vendedor_foreign`;

ALTER TABLE `calendariotareas` DROP `id_vendedor`;

ALTER TABLE `calendariotareas` CHANGE `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;
