-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2015 a las 22:57:58
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `top_games`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista`
--

CREATE TABLE IF NOT EXISTS `lista` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `autor_original` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lista`
--

INSERT INTO `lista` (`id`, `nombre`, `descripcion`, `autor_original`, `id_usuario`) VALUES
(4, 'Super Crash', 'Lista de juegos de crash', 'u1', 10),
(6, 'Final Fantasy List', 'Lista de final fantasy', 'u1', 10),
(7, 'Old school', 'Juegos de la infancia', 'u1', 4),
(19, 'Machacabotones', 'Juegos de lucha', 'u1', 4),
(20, 'Best shooters', 'Juegos de disparos', 'u1', 4),
(21, 'Plataformas', 'Juegos de plataformas', 'u1', 4),
(22, 'Race games', 'Juegos de carreras', 'u1', 4),
(24, 'Machacabotones', 'Juegos de lucha', 'u1', 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lista`
--
ALTER TABLE `lista`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lista`
--
ALTER TABLE `lista`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
