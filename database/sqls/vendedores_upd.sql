ALTER TABLE `vendedores` ADD `imagen` TEXT NULL AFTER `proyectos_participa`, ADD `puesto` TEXT NULL AFTER `imagen`, ADD `about` TEXT NULL AFTER `puesto`, ADD `linkedin` TEXT NULL AFTER `about`, ADD `x` TEXT NULL AFTER `linkedin`, ADD `instagram` TEXT NULL AFTER `x`, ADD `facebook` TEXT NULL AFTER `instagram`;

ALTER TABLE `vendedores`DROP `referencia`;

ALTER TABLE `vendedores` ADD `email_alt` VARCHAR(255) NULL AFTER `facebook`;
