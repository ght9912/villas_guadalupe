CREATE TABLE `villasdeguadalupe`.`calendario_tareas_recursion` (`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `id_tarea` BIGINT(20) UNSIGNED NOT NULL , `fecha_inicio` DATETIME NOT NULL , `fecha_fin` DATETIME NOT NULL , `created_at` TIMESTAMP NULL DEFAULT NULL , `updated_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `calendario_tareas_recursion` ADD `repeticion` INT NULL AFTER `id_tarea`;
