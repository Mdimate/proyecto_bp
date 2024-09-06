-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-09-2024 a las 23:56:09
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
-- Base de datos: `certificados_bp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `id` int(11) NOT NULL,
  `nombre` int(100) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `grupo` varchar(100) NOT NULL,
  `correo_alertamiento` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificados`
--

INSERT INTO `certificados` (`id`, `nombre`, `fecha_vencimiento`, `grupo`, `correo_alertamiento`) VALUES
(29, 0, '2024-09-19', 'dsdsdssd', 'dkhjs@dkjs.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_correo`
--

CREATE TABLE `config_correo` (
  `id` int(11) NOT NULL,
  `smtp_host` varchar(100) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_user` varchar(100) NOT NULL,
  `smtp_password` varchar(255) NOT NULL,
  `from_email` varchar(100) NOT NULL,
  `from_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `certificados_id` int(11) NOT NULL,
  `email_enviado` tinyint(1) NOT NULL,
  `fecha_envio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`) VALUES
(1, 'michell', 'michelldimate@gmail.com', 'Mddb@2411'),
(3, 'Daniela', 'danieladimate@gmail.com', 'Mddb@2411'),
(4, 'Dani', 'michelldimate2411@gmail.com', 'Mddb@2411'),
(8, '32828424', 'mdjs@gmail.com', 'hjdhjdhsd'),
(9, '123872', 'cosito@gmail.com', 'jddsks'),
(11, 'Michel', 'michel_dimate@bancopopular.com.co', '$2y$10$QAy5tP479TJK71.Urtk5/.zdCwKATLRDNYOzBdTyKG2d1yAZYxZdW'),
(12, 'Daniela Dimate', 'daniela_dimate@bancopopular.com.co', '$2y$10$IzDrVStZ8VsHAxUvlvlDqunRYYuvDdQLwy9hx6QM6jFlVu.vX1eIC'),
(13, '7823782ddjjd', 'michelldimate2@gmail.com', '$2y$10$kfuYd2ImDPq7c7dhCfzbYeu2bbC7V.YOzrFuiLFxKPmxnQW8bKDTu'),
(14, 'danita', 'danieladimate2411@gmail.com', '$2y$10$irTG3XL1Z15uxL55IUjbGuLtY6OzMFoEgqwUYfJieWFrwIvudbYMK');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `config_correo`
--
ALTER TABLE `config_correo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_usuarios_correo_unique` (`correo`),
  ADD KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `config_correo`
--
ALTER TABLE `config_correo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
