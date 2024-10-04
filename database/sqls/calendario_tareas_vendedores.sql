CREATE TABLE `villasdeguadalupe`.`calendario_tareas_vendedores` (`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `id_vendedor` BIGINT(20) UNSIGNED NOT NULL , `id_tarea` BIGINT(20) UNSIGNED NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `calendario_tareas_vendedores` CHANGE `id_vendedor` `id_vendedor` BIGINT(20) UNSIGNED NOT NULL;

ALTER TABLE `villasdeguadalupe`.`calendario_tareas_vendedores` ADD INDEX `calendario_tareas_vendedores_id_vendedor_foreign` (`id_vendedor`);

ALTER TABLE `villasdeguadalupe`.`calendario_tareas_vendedores` ADD INDEX `calendario_tareas_vendedores_id_tarea_foreign` (`id_tarea`);

ALTER TABLE `calendario_tareas_vendedores` ADD CONSTRAINT `calendario_tareas_vendedores_id_vendedor_foreign` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedores`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `calendario_tareas_vendedores` ADD CONSTRAINT `calendario_tareas_vendedores_id_tarea_foreign` FOREIGN KEY (`id_tarea`) REFERENCES `calendariotareas`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `calendario_tareas_vendedores` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `id_tarea`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;
