-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-03-2017 a las 17:00:17
-- Versión del servidor: 5.7.13-0ubuntu0.16.04.2
-- Versión de PHP: 5.6.28-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `CADIP2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `claps`
--

CREATE TABLE `claps` (
  `id` int(255) NOT NULL,
  `id_estado` int(255) NOT NULL,
  `id_municipio` int(255) NOT NULL,
  `id_parroquia` int(255) NOT NULL,
  `codigo_clap` varchar(50) NOT NULL,
  `nombre_clap` varchar(200) NOT NULL,
  `comunidad` varchar(100) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `cedula` int(10) NOT NULL,
  `nombre_apellido` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `registrado` varchar(100) NOT NULL,
  `ubicado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `claps`
--
ALTER TABLE `claps`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `claps`
--
ALTER TABLE `claps`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
