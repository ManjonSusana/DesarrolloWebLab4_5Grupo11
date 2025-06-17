-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 18:49:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_hoteles2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotografia_habitacion`
--

CREATE TABLE `fotografia_habitacion` (
  `id` int(11) NOT NULL,
  `id_habitaciones` int(11) NOT NULL,
  `fotografia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotografia_habitacion`
--

INSERT INTO `fotografia_habitacion` (`id`, `id_habitaciones`, `fotografia`) VALUES
(1, 1, 'imagenes/individual1.png'),
(2, 2, 'imagenes/individual2.png'),
(3, 8, 'imagenes/individual3.png'),
(4, 3, 'imagenes/dobble1.png'),
(5, 4, 'imagenes/doble2.png'),
(6, 5, 'imagenes/suit1.png'),
(7, 10, 'imagenes/suit2.png'),
(8, 15, 'imagenes/individual3.png'),
(9, 6, 'imagenes/doble3.png'),
(10, 7, 'imagenes/doble3.png'),
(11, 9, 'imagenes/doble2.png'),
(12, 11, 'imagenes/doble3.png'),
(13, 13, 'imagenes/doble2.png'),
(14, 14, 'imagenes/suit3.png'),
(15, 12, 'imagenes/individual2.png'),
(16, 16, 'imagenes/individual1.png'),
(17, 17, 'imagenes/dobble1.png'),
(18, 18, 'imagenes/suit1.png'),
(19, 19, 'imagenes/doble2.png'),
(20, 20, 'imagenes/individual2.png'),
(21, 21, 'imagenes/doble3.png'),
(22, 22, 'imagenes/suit2.png'),
(23, 23, 'imagenes/dobble1.png'),
(24, 24, 'imagenes/individual3.png'),
(25, 25, 'imagenes/suit3.png'),
(26, 26, 'imagenes/individual1.png'),
(27, 27, 'imagenes/dobble1.png'),
(28, 28, 'imagenes/suit1.png'),
(29, 29, 'imagenes/doble2.png'),
(30, 30, 'imagenes/individual2.png'),
(31, 31, 'imagenes/doble3.png'),
(32, 32, 'imagenes/suit2.png'),
(33, 33, 'imagenes/dobble1.png'),
(34, 34, 'imagenes/individual3.png'),
(35, 35, 'imagenes/suit3.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id` int(11) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `piso` int(11) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `estado` enum('disponible','reservada','ocupado','fuera_servicio') DEFAULT 'disponible',
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`id`, `numero`, `piso`, `tipo`, `estado`, `descripcion`) VALUES
(1, '01', 1, 'individual', 'disponible', 'Habitación individual con baño privado, sin TV'),
(2, '02', 1, 'individual', 'disponible', 'Habitación individual con baño compartido, con TV'),
(3, '03', 1, 'doble', 'disponible', 'Habitación con dos camas individuales, sin TV'),
(4, '04', 1, 'doble', 'disponible', 'Habitación con dos camas individuales, con baño privado y TV'),
(5, '05', 1, 'suite', 'disponible', 'Suite de lujo con cama king, baño privado y TV'),
(6, '06', 1, 'doble', 'disponible', 'Habitación con cama matrimonial, sin TV'),
(7, '07', 1, 'doble', 'disponible', 'Habitación con cama matrimonial, baño privado y TV'),
(8, '08', 1, 'individual', 'disponible', 'Habitación individual con cama sencilla y baño compartido'),
(9, '09', 1, 'doble', 'disponible', 'Habitación con dos camas individuales, baño compartido'),
(10, '10', 1, 'suite', 'disponible', 'Suite con cama queen, baño privado y TV de alta definición'),
(11, '11', 1, 'doble', 'disponible', 'Habitación con dos camas individuales, sin TV'),
(12, '12', 1, 'individual', 'disponible', 'Habitación pequeña con baño compartido'),
(13, '13', 1, 'doble', 'disponible', 'Habitación con cama matrimonial, baño privado y TV'),
(14, '14', 1, 'suite', 'disponible', 'Suite premium con jacuzzi, cama king y TV inteligente'),
(15, '15', 1, 'individual', 'disponible', 'Habitación sencilla con escritorio y baño privado'),
(16, '16', 2, 'individual', 'disponible', 'Habitación individual con baño privado y escritorio'),
(17, '17', 2, 'doble', 'disponible', 'Habitación con dos camas individuales y balcón con vista'),
(18, '18', 2, 'suite', 'disponible', 'Suite de lujo con cama king, jacuzzi y minibar'),
(19, '19', 2, 'doble', 'disponible', 'Habitación con cama matrimonial, baño privado y TV'),
(20, '20', 2, 'individual', 'disponible', 'Habitación individual con baño compartido, sin TV'),
(21, '21', 2, 'doble', 'disponible', 'Habitación con dos camas individuales, sin baño privado'),
(22, '22', 2, 'suite', 'disponible', 'Suite con área de estar, TV inteligente y baño privado'),
(23, '23', 2, 'doble', 'disponible', 'Habitación con cama matrimonial y acceso a terraza'),
(24, '24', 2, 'individual', 'disponible', 'Habitación individual con escritorio, baño privado y TV'),
(25, '25', 2, 'suite', 'disponible', 'Suite premium con vista panorámica, cama king y jacuzzi'),
(26, '26', 3, 'individual', 'disponible', 'Habitación individual con baño privado y escritorio'),
(27, '27', 3, 'doble', 'disponible', 'Habitación con dos camas individuales y balcón con vista'),
(28, '28', 3, 'suite', 'disponible', 'Suite de lujo con cama king, jacuzzi y minibar'),
(29, '29', 3, 'doble', 'disponible', 'Habitación con cama matrimonial, baño privado y TV'),
(30, '30', 3, 'individual', 'disponible', 'Habitación individual con baño compartido, sin TV'),
(31, '31', 3, 'doble', 'disponible', 'Habitación con dos camas individuales, sin baño privado'),
(32, '32', 3, 'suite', 'disponible', 'Suite con área de estar, TV inteligente y baño privado'),
(33, '33', 3, 'doble', 'disponible', 'Habitación con cama matrimonial y acceso a terraza'),
(34, '34', 3, 'individual', 'disponible', 'Habitación individual con escritorio, baño privado y TV'),
(35, '35', 3, 'suite', 'disponible', 'Suite premium con vista panorámica, cama king y jacuzzi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_habitaciones` int(11) DEFAULT NULL,
  `tipo_habitacion` varchar(50) DEFAULT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `estado` enum('pendiente','confirmada','ocupado','finalizada','cancelada') DEFAULT 'pendiente',
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `id_usuario`, `id_habitaciones`, `tipo_habitacion`, `fecha_entrada`, `fecha_salida`, `estado`, `fecha_reserva`) VALUES
(0, 5, NULL, 'individual', '2025-06-12', '2025-06-14', 'pendiente', '2025-06-09 17:34:42'),
(1, 1, NULL, 'doble', '2025-06-10', '2025-06-12', 'pendiente', '2025-06-09 17:34:42'),
(2, 2, NULL, 'individual', '2025-06-15', '2025-06-18', 'confirmada', '2025-06-09 17:34:42'),
(3, 3, NULL, 'suite', '2025-06-05', '2025-06-08', 'ocupado', '2025-06-09 17:34:42'),
(4, 4, NULL, 'doble', '2025-06-20', '2025-06-23', 'pendiente', '2025-06-09 17:34:42'),
(6, 6, NULL, 'doble', '2025-06-10', '2025-06-11', 'confirmada', '2025-06-09 17:34:42'),
(7, 7, NULL, 'suite', '2025-06-19', '2025-06-22', 'pendiente', '2025-06-09 17:34:42'),
(8, 8, NULL, 'individual', '2025-06-25', '2025-06-26', 'ocupado', '2025-06-09 17:34:42'),
(9, 9, NULL, 'individual', '2025-06-11', '2025-06-13', 'confirmada', '2025-06-09 17:34:42'),
(10, 10, NULL, 'suite', '2025-06-30', '2025-07-02', 'confirmada', '2025-06-09 17:34:42'),
(11, 13, NULL, 'individual', '2025-06-10', '2025-06-13', 'cancelada', '2025-06-09 19:46:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipohabitacion`
--

CREATE TABLE `tipohabitacion` (
  `id_habitacion` int(11) NOT NULL,
  `nombre_h` int(11) NOT NULL,
  `superficie` float NOT NULL,
  `nro_camas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `ci` varchar(20) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `telefono`, `ci`, `fecha_registro`) VALUES
(1, 'Juan Pérez', 'juanp@gmail.com', '78912345', '121200', '2025-06-09 17:31:11'),
(2, 'Ana López', 'ana.lopez@gmail.com', '76543210', '2345678', '2025-06-09 17:31:11'),
(3, 'Carlos Rivera', 'carlosr@hotmail.com', '71234567', '3456789', '2025-06-09 17:31:11'),
(4, 'Lucía Gómez', 'lucia.gomez@gmail.com', '69874563', '4567890', '2025-06-09 17:31:11'),
(5, 'Mario Ruiz', 'mario.ruiz@yahoo.com', '67451238', '5678901', '2025-06-09 17:31:11'),
(6, 'Patricia Fernández', 'paty.fernandez@gmail.com', '72123456', '6789012', '2025-06-09 17:31:11'),
(7, 'Roberto Méndez', 'roberto.m@gmail.com', '73456129', '7890123', '2025-06-09 17:31:11'),
(8, 'Valeria Soto', 'valeria.soto@gmail.com', '76512389', '8901234', '2025-06-09 17:31:11'),
(9, 'Esteban Rojas', 'esteban.rojas@hotmail.com', '71239847', '9012345', '2025-06-09 17:31:11'),
(10, 'Gabriela Terán', 'gabriela.teran@gmail.com', '74561238', '0123456', '2025-06-09 17:31:11'),
(13, 'Artuhr', 'daniel@gmail.com', '1234567', '111111', '2025-06-09 19:46:55'),
(14, 'johan', 'partur@gmail.com', '656565656', '45678', '2025-06-10 22:59:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fotografia_habitacion`
--
ALTER TABLE `fotografia_habitacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_habitaciones` (`id_habitaciones`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_habitacion` (`id_habitaciones`);

--
-- Indices de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  ADD PRIMARY KEY (`id_habitacion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fotografia_habitacion`
--
ALTER TABLE `fotografia_habitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  MODIFY `id_habitacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fotografia_habitacion`
--
ALTER TABLE `fotografia_habitacion`
  ADD CONSTRAINT `fotografia_habitacion_ibfk_1` FOREIGN KEY (`id_habitaciones`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_habitaciones`) REFERENCES `habitaciones` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
