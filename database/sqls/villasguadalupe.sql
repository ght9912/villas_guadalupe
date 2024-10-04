--
-- Base de datos: `villasguadalupe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `id_lote` bigint(20) UNSIGNED DEFAULT NULL,
  `estatus` varchar(100) DEFAULT NULL,
  `objeto` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `id_cliente`, `id_lote`, `estatus`, `objeto`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'activo', '\'{\"enganches\":[{\"cantidad\":\"14000\",\"fecha\":\"2024-01-03\"}],\"c_nombre\":\"oscar\",\"c_direccion\":\"Adalberto Palacios #255\",\"c_celular\":\"8441958120\",\"c_email\":\"irondarkht@gmail.com\",\"c_electoral\":\"oscar\",\"c_fallecido\":\"oscar\",\"indiceA\":\"dasfdasdf\",\"e_nombre\":\"C. Terminel Grijalva Mario Alberto\",\"e_direccion\":\"Calle Paseos del Vivero #2905 Fraccionamiento Paseos del Bosque \",\"e_email\":\"cobranzavillassanmiguelgamil.com\",\"e_electoral\":\"TESDF21341234\",\"e_ran\":\"08220019784\",\"l_superficie\":\"200\",\"l_contado\":\"450\",\"l_fin\":\"550\",\"Meses\":\"6 meses\",\"l_mensualidad\":\"16000\",\"l_mes\":\" Octubre \",\"l_dia\":\" 15 \",\"l_total\":\"110000\",\"\":\" Santiago Pinedo Iregoyen/Afirme/062164001771399473 \"}\' ', '2024-01-04 02:04:24', '2024-01-04 02:04:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `beneficiario` varchar(255) NOT NULL,
  `banco` varchar(255) NOT NULL,
  `no_cuenta` varchar(255) NOT NULL,
  `clabe_inter` varchar(255) NOT NULL,
  `no_tarjeta` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id`, `nombre`, `beneficiario`, `banco`, `no_cuenta`, `clabe_inter`, `no_tarjeta`, `created_at`, `updated_at`) VALUES
(1, 'Cuenta Villas de Guadalupe', 'Santiago Pinedo Iregoyen', 'Afirme', '177139947', '062164001771399473', '4320490101381364', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enajenantes`
--

CREATE TABLE `enajenantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `clave_electoral` varchar(255) DEFAULT NULL,
  `num_ran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `enajenantes`
--

INSERT INTO `enajenantes` (`id`, `nombre`, `direccion`, `email`, `clave_electoral`, `num_ran`, `created_at`, `updated_at`) VALUES
(1, 'C. Terminel Grijalva Mario Alberto', 'Calle Paseos del Vivero #2905 Fraccionamiento Paseos del Bosque ', 'cobranzavillassanmiguelgamil.com', 'TESDF21341234', '08220019784', '2024-01-02 19:38:52', '2024-01-02 06:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contratos_id_lote_foreign` (`id_lote`),
  ADD KEY `contratos_id_cliente_foreign` (`id_cliente`) USING BTREE;

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `enajenantes`
--
ALTER TABLE `enajenantes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `enajenantes`
--
ALTER TABLE `enajenantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratos_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `contratos_id_lote_foreign` FOREIGN KEY (`id_lote`) REFERENCES `lotes` (`id`);
COMMIT;


ALTER TABLE `contratos` ADD `total` FLOAT(10,2) NULL DEFAULT NULL AFTER `estatus`;
