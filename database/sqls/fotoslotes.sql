-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2024 a las 21:39:30
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `villasgpe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotoslotes`
--

CREATE TABLE `fotoslotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lote_id` bigint(20) UNSIGNED NOT NULL,
  `ruta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotoslotes`
--

INSERT INTO `fotoslotes` (`id`, `lote_id`, `ruta`, `descripcion`, `alt`, `created_at`, `updated_at`) VALUES
(4, 3747, 'img/lotes/RKRunCiYD8AdOyFFafgRuT4XZULSipbOz5UB4LfA.png', 'kjbkhbiubkb', 'bkjbkbliu', '2024-08-24 00:12:10', '2024-08-27 02:32:18'),
(5, 3747, 'img/lotes/e8wt5Zy1uK5whZQGoSJ20CPe3Z51shc9VgUJLidv.png', 'fasdaga', 'gagadgasg', '2024-08-24 00:16:25', '2024-08-27 02:45:36'),
(6, 3747, 'img/lotes/nsngyzLacebivdqmfGm3Ciq8wY4vGEhnf3l4XHcr.png', 'bhbihbbhibi', 'nbbbbiubb', '2024-08-24 00:23:56', '2024-08-27 02:54:34'),
(7, 3747, 'img/lotes/mTVzAmijUjNyLanS6ZyHQmQfagnMUCbi994hi6Nq.png', 'kb khjbkjbkb', 'bkbikbiub', '2024-08-24 00:28:33', '2024-08-27 02:55:32'),
(8, 3747, 'img/lotes/lpBm0R1rHCk2QC9MB7MBTDiNQ3ezOdKh4W4b4iBD.png', 'kjbkhjbhb', 'bkbkbuoboubuo', '2024-08-24 00:29:30', '2024-08-27 02:58:10'),
(9, 3747, 'img/lotes/s6askiqRYfMZpi67xlLJK9DtiQ0bpqm2sxUrAqGw.png', NULL, NULL, '2024-08-24 00:30:13', '2024-08-24 00:30:13'),
(10, 3747, 'img/lotes/6a5eJynXstbsfaZZacyVcZtNPJ5wOPUd9tX4fgqZ.png', NULL, NULL, '2024-08-24 00:31:57', '2024-08-24 00:31:57'),
(11, 3747, 'img/lotes/TGLPaZgOwhwROWVRC4PFgBzdR4AOA9i1GnFN3jjm.png', NULL, NULL, '2024-08-24 00:32:28', '2024-08-24 00:32:28'),
(12, 3747, 'img/lotes/cBhJLB5cksWuPYawoOTzbIKSKpyIy7awUQFyG1Kx.png', NULL, NULL, '2024-08-24 00:33:31', '2024-08-24 00:33:31'),
(16, 5021, 'img/lotes/60OoJk12tJsrVIRvfGQqYkpagkzGN5qmi2Q8S8f9.png', 'Descripción de la imagen', 'Sustituto de la imagen', '2024-09-04 01:48:25', '2024-09-04 02:55:25'),
(17, 5021, 'img/lotes/b32ScwF0RHD41dDLRrpr5zmzjZ9IAPpYltrbwZpy.png', 'Nuevo texto', 'Nuevo texto', '2024-09-04 01:52:53', '2024-09-04 02:40:58');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fotoslotes`
--
ALTER TABLE `fotoslotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fotoslotes_id_lotes_foreign` (`lote_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fotoslotes`
--
ALTER TABLE `fotoslotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fotoslotes`
--
ALTER TABLE `fotoslotes`
  ADD CONSTRAINT `fotoslotes_id_lotes_foreign` FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
