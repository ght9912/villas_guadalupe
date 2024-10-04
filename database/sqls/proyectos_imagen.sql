CREATE TABLE `villasdeguadalupe`.`proyectos_imagen` (`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `id_proyecto` BIGINT(20) UNSIGNED NOT NULL , `url` TEXT NULL DEFAULT NULL , `alternativo` TEXT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `villasdeguadalupe`.`proyectos_imagen` ADD INDEX `proyectos_imagen_id_proyecto_foreign` (`id_proyecto`);

ALTER TABLE `proyectos_imagen` ADD CONSTRAINT `proyectos_imagen_id_proyecto_foreign` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `proyectos_imagen` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `alternativo`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;
