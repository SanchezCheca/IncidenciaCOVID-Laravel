-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-01-2021 a las 20:04:42
-- Versión del servidor: 8.0.22-0ubuntu0.20.04.3
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `incovidLaravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE `informes` (
  `id` int NOT NULL,
  `semana` varchar(100) NOT NULL,
  `region` varchar(50) NOT NULL,
  `nInfectados` int NOT NULL,
  `nFallecidos` int NOT NULL,
  `nAltas` int NOT NULL,
  `idautor` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `informes`
--

INSERT INTO `informes` (`id`, `semana`, `region`, `nInfectados`, `nFallecidos`, `nAltas`, `idautor`) VALUES
(1, 'Jan 4 - Jan 10', '1', 5, 10, 4, 1),
(2, 'Jan 4 - Jan 10', '0', 321654, 32155, 5816, 1),
(3, 'Nov 2 - Nov 8', '4', 489, 954, 843, 1),
(4, 'Nov 30 - Dec 6', '5', 89456, 49842, 546, 1),
(5, 'Dec 14 - Dec 20', '5', 4234, 412, 4231, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

CREATE TABLE `regiones` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `regiones`
--

INSERT INTO `regiones` (`id`, `nombre`) VALUES
(0, 'desconocido'),
(1, 'Asturias'),
(3, 'Comunidad de Madrid'),
(4, 'Cataluña'),
(5, 'Castilla-La Mancha'),
(6, 'Comunidad Valenciana'),
(7, 'Ceuta'),
(8, 'Islas Canarias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `activo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `pass`, `activo`) VALUES
(1, 'Daniel', 'daniel@daniel.com', '$1$y7wITeRO$oayt9UykrPMUXkfyjc59q/', 1),
(2, 'Pepe', 'pepe@pepe.com', '$1$fTPbAU.x$3WgedVd85rfC6waXsyDYV1', 1),
(4, 'Daniel', 'danie33l@daniel.com', 'daniel', 0),
(5, 'daniel5', 'daniel5@daniel5.com', 'daniel5', 0),
(7, 'daniel6', 'daniel6@daniel6.com', '$2y$10$h5Rxs30mDoFo6HJwWKxWkeJton9VgxjfQCtboalk6z8hvsLcC5RWS', 1),
(8, 'Agua', 'agua@agua.com', '$2y$10$cF4hmmszsu3dNYClQ4fFCOzUl7bysb.JyAfyJJe8aU8AYO4qHjyF2', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `idUsuario` int NOT NULL,
  `idRol` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`idUsuario`, `idRol`) VALUES
(1, 0),
(1, 1),
(2, 1),
(3, 0),
(7, 1),
(7, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `informes`
--
ALTER TABLE `informes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `informes`
--
ALTER TABLE `informes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `regiones`
--
ALTER TABLE `regiones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
