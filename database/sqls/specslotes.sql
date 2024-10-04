-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2024 a las 21:40:04
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
-- Estructura de tabla para la tabla `specslotes`
--

CREATE TABLE `specslotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_lote` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `specslotes`
--

INSERT INTO `specslotes` (`id`, `id_lote`, `nombre`, `valor`, `created_at`, `updated_at`) VALUES
(41, 5021, 'Spec 1', 'Nuevo valor', '2024-09-03 02:06:51', '2024-09-03 07:59:35'),
(42, 5021, 'Nuevo spec', '2.12', '2024-09-03 02:06:51', '2024-09-03 07:59:35'),
(43, 5021, 'Nuevo spec 3', 'Valor 3.2', '2024-09-03 02:06:51', '2024-09-03 02:11:06'),
(49, 5021, 'Nuevo spec 7', 'Valor 7.2', '2024-09-03 02:24:25', '2024-09-03 02:42:41'),
(55, 5021, 'Nuevo 12', 'Valor 12', '2024-09-03 07:59:35', '2024-09-03 07:59:35');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `specslotes`
--
ALTER TABLE `specslotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `specslotes_id_lotes_foreign` (`id_lote`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `specslotes`
--
ALTER TABLE `specslotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `specslotes`
--
ALTER TABLE `specslotes`
  ADD CONSTRAINT `specslotes_id_lotes_foreign` FOREIGN KEY (`id_lote`) REFERENCES `lotes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
