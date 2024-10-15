-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2024 a las 16:16:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sitmdm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `idCertificado` int(20) NOT NULL,
  `id_estudiante` int(20) NOT NULL,
  `FechaSolicitud` date NOT NULL,
  `TipoCertificado` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `idEstado` int(20) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificados`
--

INSERT INTO `certificados` (`idCertificado`, `id_estudiante`, `FechaSolicitud`, `TipoCertificado`, `idEstado`, `fecha`) VALUES
(1, 1, '2024-10-07', 'Analítico Parcial', 1, '2024-10-07 21:24:27'),
(2, 1, '2024-10-07', 'Porcentaje de Materias', 1, '2024-10-07 21:39:42'),
(3, 1, '2024-10-07', 'Alumno Regular', 1, '2024-10-07 21:39:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativas`
--

CREATE TABLE `correlativas` (
  `id_corr` int(11) NOT NULL,
  `idTec` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  `idCorrelativas` int(11) NOT NULL,
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `correlativas`
--

INSERT INTO `correlativas` (`id_corr`, `idTec`, `idMateria`, `idCorrelativas`, `FechaMod`) VALUES
(1, 1, 3, 2, '2024-09-02 21:01:29'),
(2, 2, 6, 5, '2024-09-02 21:01:29'),
(3, 3, 9, 8, '2024-09-02 21:01:29'),
(4, 4, 12, 10, '2024-09-02 21:01:29'),
(5, 5, 14, 11, '2024-09-02 21:01:29'),
(6, 6, 17, 15, '2024-09-02 21:01:29'),
(7, 7, 19, 18, '2024-09-02 21:01:29'),
(8, 8, 21, 20, '2024-09-02 21:01:29'),
(9, 9, 22, 21, '2024-09-02 21:01:29'),
(10, 10, 23, 22, '2024-09-02 21:01:29'),
(11, 11, 24, 23, '2024-09-02 21:01:29'),
(12, 12, 25, 24, '2024-09-02 21:01:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentesmaterias`
--

CREATE TABLE `docentesmaterias` (
  `iddocentesmaterias` int(11) NOT NULL,
  `id_Persona` int(10) UNSIGNED NOT NULL,
  `id_Materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `docentesmaterias`
--

INSERT INTO `docentesmaterias` (`iddocentesmaterias`, `id_Persona`, `id_Materia`) VALUES
(1, 1, 5),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idEstado` int(20) NOT NULL,
  `estado` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idEstado`, `estado`, `fecha`) VALUES
(1, 'pendiente', '2024-09-11 05:03:02'),
(2, 'aprobado', '2024-09-11 05:03:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id_estudiante` int(11) NOT NULL,
  `numero_establecimiento` varchar(50) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `posee_dni` varchar(1) NOT NULL,
  `dni_numero` varchar(8) DEFAULT NULL,
  `cuil` varchar(11) DEFAULT NULL,
  `tiene_cpi` varchar(2) DEFAULT NULL,
  `documento_extranjero` varchar(2) DEFAULT NULL,
  `tipo_documento_extranjero` varchar(100) DEFAULT NULL,
  `numero_documento_extranjero` varchar(50) DEFAULT NULL,
  `identidad_genero` varchar(2) NOT NULL,
  `lugar_nacimiento` varchar(2) NOT NULL,
  `especificar_pais` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `piso` varchar(10) DEFAULT NULL,
  `departamento` varchar(10) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_Tecnicatura` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id_estudiante`, `numero_establecimiento`, `apellido`, `nombre`, `telefono`, `email`, `posee_dni`, `dni_numero`, `cuil`, `tiene_cpi`, `documento_extranjero`, `tipo_documento_extranjero`, `numero_documento_extranjero`, `identidad_genero`, `lugar_nacimiento`, `especificar_pais`, `provincia`, `ciudad`, `codigo_postal`, `calle`, `numero`, `piso`, `departamento`, `fecha_registro`, `id_Tecnicatura`, `id_usuario`) VALUES
(1, '1001', 'González', 'Carlos', '123456789', 'carlos.gonzalez@example.com', 'S', '12345678', '20123456789', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'CABA', '1000', 'Calle Falsa', '123', '1', 'A', '2024-09-01 03:00:00', 1, 1),
(2, '1002', 'Pérez', 'Ana', '987654321', 'ana.perez@example.com', 'S', '87654321', '20987654321', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'La Plata', '1900', 'Avenida Siempreviva', '456', '2', 'B', '2024-09-01 03:00:00', NULL, NULL),
(3, '1003', 'López', 'Martín', '222333444', 'martin.lopez@example.com', 'S', '13579246', '20135792468', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Tigre', '1600', 'Calle 13', '789', '3', 'C', '2024-09-01 03:00:00', NULL, NULL),
(4, '1004', 'Fernández', 'Lucía', '333444555', 'lucia.fernandez@example.com', 'S', '24681357', '20246813579', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Quilmes', '1876', 'Calle 9', '159', '4', 'D', '2024-09-01 03:00:00', NULL, NULL),
(5, '1005', 'Gómez', 'Juan', '444555666', 'juan.gomez@example.com', 'S', '35715948', '20357159482', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'San Isidro', '1642', 'Calle 10', '753', '5', 'E', '2024-09-01 03:00:00', NULL, NULL),
(6, '1006', 'Rodríguez', 'María', '555666777', 'maria.rodriguez@example.com', 'S', '46825713', '20468257135', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Morón', '1708', 'Avenida del Libertador', '202', '6', 'F', '2024-09-01 03:00:00', NULL, NULL),
(7, '1007', 'Martínez', 'Javier', '666777888', 'javier.martinez@example.com', 'S', '57931524', '20579315246', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Lomas de Zamora', '1832', 'Avenida Mitre', '666', '7', 'G', '2024-09-01 03:00:00', NULL, NULL),
(8, '1008', 'Sosa', 'Sofía', '777888999', 'sofia.sosa@example.com', 'S', '68024635', '20680246357', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Lanús', '1824', 'Calle Libertad', '111', '8', 'H', '2024-09-01 03:00:00', NULL, NULL),
(9, '1009', 'Álvarez', 'Matías', '888999000', 'matias.alvarez@example.com', 'S', '79135746', '20791357468', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Avellaneda', '1870', 'Calle Independencia', '222', '9', 'I', '2024-09-01 03:00:00', NULL, NULL),
(10, '1010', 'Ramírez', 'Laura', '999000111', 'laura.ramirez@example.com', 'S', '80246857', '20802468579', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Escobar', '1625', 'Calle República', '333', '10', 'J', '2024-09-01 03:00:00', NULL, NULL),
(11, '1011', 'Torres', 'Lucas', '000111222', 'lucas.torres@example.com', 'S', '91357968', '20913579680', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'San Fernando', '1646', 'Avenida Perón', '444', '11', 'K', '2024-09-01 03:00:00', NULL, NULL),
(12, '1012', 'Díaz', 'Clara', '111222333', 'clara.diaz@example.com', 'S', '02468135', '20024681357', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'San Miguel', '1663', 'Avenida San Martín', '555', '12', 'L', '2024-09-01 03:00:00', NULL, NULL),
(13, '1013', 'Moreno', 'Ignacio', '222333444', 'ignacio.moreno@example.com', 'S', '13579246', '20135792468', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'San Martín', '1650', 'Calle Buenos Aires', '666', '13', 'M', '2024-09-01 03:00:00', NULL, NULL),
(14, '1014', 'Muñoz', 'Valentina', '333444555', 'valentina.munoz@example.com', 'S', '24681357', '20246813579', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'José C. Paz', '1665', 'Avenida Presidente Perón', '777', '14', 'N', '2024-09-01 03:00:00', NULL, NULL),
(15, '1015', 'Rojas', 'Federico', '444555666', 'federico.rojas@example.com', 'S', '35715948', '20357159482', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Vicente López', '1638', 'Calle Italia', '888', '15', 'O', '2024-09-01 03:00:00', NULL, NULL),
(16, '1016', 'Herrera', 'Elena', '555666777', 'elena.herrera@example.com', 'S', '46825713', '20468257135', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Tres de Febrero', '1674', 'Avenida Urquiza', '999', '16', 'P', '2024-09-01 03:00:00', NULL, NULL),
(17, '1017', 'Flores', 'Emiliano', '666777888', 'emiliano.flores@example.com', 'S', '57931524', '20579315246', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Pilar', '1629', 'Calle San Lorenzo', '101', '17', 'Q', '2024-09-01 03:00:00', NULL, NULL),
(18, '1018', 'Paredes', 'Julieta', '777888999', 'julieta.paredes@example.com', 'S', '68024635', '20680246357', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Moreno', '1744', 'Avenida Rivadavia', '202', '18', 'R', '2024-09-01 03:00:00', NULL, NULL),
(19, '1019', 'Castro', 'Fernando', '888999000', 'fernando.castro@example.com', 'S', '79135746', '20791357468', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Ituzaingó', '1714', 'Calle Sarmiento', '303', '19', 'S', '2024-09-01 03:00:00', NULL, NULL),
(20, '1020', 'Vega', 'Camila', '999000111', 'camila.vega@example.com', 'S', '80246857', '20802468579', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Merlo', '1722', 'Avenida de Mayo', '404', '20', 'T', '2024-09-01 03:00:00', NULL, NULL),
(21, '1021', 'Gutiérrez', 'Santiago', '000111222', 'santiago.gutierrez@example.com', 'S', '91357968', '20913579680', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Hurlingham', '1686', 'Calle Roca', '505', '21', 'U', '2024-09-01 03:00:00', NULL, NULL),
(22, '1022', 'Silva', 'Alicia', '111222333', 'alicia.silva@example.com', 'S', '02468135', '20024681357', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Berazategui', '1884', 'Avenida Almirante Brown', '606', '22', 'V', '2024-09-01 03:00:00', NULL, NULL),
(23, '1023', 'Molina', 'Esteban', '222333444', 'esteban.molina@example.com', 'S', '13579246', '20135792468', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Florencio Varela', '1888', 'Calle Moreno', '707', '23', 'W', '2024-09-01 03:00:00', NULL, NULL),
(24, '1024', 'Ortiz', 'Gabriela', '333444555', 'gabriela.ortiz@example.com', 'S', '24681357', '20246813579', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Ezeiza', '1804', 'Avenida Belgrano', '808', '24', 'X', '2024-09-01 03:00:00', NULL, NULL),
(25, '1025', 'Suárez', 'Leandro', '444555666', 'leandro.suarez@example.com', 'S', '35715948', '20357159482', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Cañuelas', '1814', 'Calle San Juan', '909', '25', 'Y', '2024-09-01 03:00:00', NULL, NULL),
(26, '1026', 'Romero', 'Daniela', '555666777', 'daniela.romero@example.com', 'S', '46825713', '20468257135', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Luján', '6700', 'Avenida Alem', '1010', '26', 'Z', '2024-09-01 03:00:00', NULL, NULL),
(27, '1027', 'Ramón', 'Gustavo', '666777888', 'gustavo.ramon@example.com', 'S', '57931524', '20579315246', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'San Pedro', '2930', 'Calle Córdoba', '1111', '27', 'AA', '2024-09-01 03:00:00', NULL, NULL),
(28, '1028', 'Acosta', 'Verónica', '777888999', 'veronica.acosta@example.com', 'S', '68024635', '20680246357', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Tandil', '7000', 'Calle Francia', '1212', '28', 'BB', '2024-09-01 03:00:00', NULL, NULL),
(29, '1029', 'Maldonado', 'Roberto', '888999000', 'roberto.maldonado@example.com', 'S', '79135746', '20791357468', 'N', 'N', NULL, NULL, 'M', 'AR', NULL, 'Buenos Aires', 'Chivilcoy', '6620', 'Avenida Irigoyen', '1313', '29', 'CC', '2024-09-01 03:00:00', NULL, NULL),
(30, '1030', 'Sánchez', 'Lucía', '555555555', 'lucia.sanchez@example.com', 'S', '55555555', '20555555555', 'N', 'N', NULL, NULL, 'F', 'AR', NULL, 'Buenos Aires', 'Mar del Plata', '7600', 'Calle del Mar', '789', '7', 'G', '2024-09-01 03:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_materia`
--

CREATE TABLE `estudiante_materia` (
  `id_estudiante_materia` int(11) NOT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `id_Materia` int(11) DEFAULT NULL,
  `nota_primer_cuatrimestre` decimal(5,2) DEFAULT NULL,
  `nota_segundo_cuatrimestre` decimal(5,2) DEFAULT NULL,
  `asistencia_horas` int(11) DEFAULT NULL,
  `horas_cursadas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiante_materia`
--

INSERT INTO `estudiante_materia` (`id_estudiante_materia`, `id_estudiante`, `id_Materia`, `nota_primer_cuatrimestre`, `nota_segundo_cuatrimestre`, `asistencia_horas`, `horas_cursadas`) VALUES
(1, 1, 1, 8.50, 7.00, 100, 120),
(2, 1, 2, 2.00, 3.00, 90, 100),
(3, 1, 3, 7.50, 6.50, 110, 130),
(4, 2, 1, 6.00, 7.00, 95, 115),
(5, 2, 2, 8.50, 7.50, 85, 105),
(6, 2, 3, 7.00, 6.00, 100, 120),
(7, 3, 1, 2.00, 8.50, 110, 130),
(8, 3, 2, 8.00, 7.00, 90, 110),
(9, 3, 3, 6.50, 7.50, 105, 125),
(10, 4, 1, 8.00, 7.50, 100, 120),
(11, 4, 2, 7.00, 6.50, 90, 110),
(12, 4, 3, 8.50, 7.00, 95, 115),
(13, 5, 1, 7.50, 8.00, 100, 120),
(14, 5, 2, 6.50, 7.00, 85, 105),
(15, 5, 3, 9.00, 8.50, 110, 130),
(16, 6, 1, 7.00, 6.50, 95, 115),
(17, 6, 2, 8.00, 7.50, 90, 110),
(18, 6, 3, 8.50, 7.00, 100, 120),
(19, 7, 1, 2.00, 3.00, 105, 125),
(20, 7, 2, 7.50, 8.50, 95, 115),
(21, 7, 3, 8.00, 7.50, 100, 120),
(22, 8, 1, 8.50, 9.00, 110, 130),
(23, 8, 2, 7.00, 6.50, 85, 105),
(24, 8, 3, 6.50, 7.00, 90, 110),
(25, 9, 1, 7.50, 8.00, 95, 115),
(26, 9, 2, 8.00, 9.00, 100, 120),
(27, 9, 3, 6.00, 6.50, 85, 105),
(28, 10, 1, 8.00, 8.50, 100, 120),
(29, 10, 2, 7.50, 7.00, 95, 115),
(30, 10, 3, 9.00, 8.50, 105, 125);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_tecnicatura`
--

CREATE TABLE `estudiante_tecnicatura` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `id_Tecnicatura` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiante_tecnicatura`
--

INSERT INTO `estudiante_tecnicatura` (`id`, `id_estudiante`, `id_Tecnicatura`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 1),
(5, 5, 2),
(6, 6, 3),
(7, 7, 1),
(8, 8, 2),
(9, 9, 3),
(10, 10, 1),
(11, 11, 2),
(12, 12, 3),
(13, 13, 1),
(14, 14, 2),
(15, 15, 3),
(16, 16, 1),
(17, 17, 2),
(18, 18, 3),
(19, 19, 1),
(20, 20, 2),
(21, 21, 3),
(22, 22, 1),
(23, 23, 2),
(24, 24, 3),
(25, 25, 1),
(26, 26, 2),
(27, 27, 3),
(28, 28, 1),
(29, 29, 2),
(30, 30, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas_materias`
--

CREATE TABLE `fechas_materias` (
  `id` int(11) NOT NULL,
  `id_Tecnicatura` int(11) NOT NULL,
  `id_Materia` int(11) NOT NULL,
  `fecha1` date DEFAULT NULL,
  `fecha2` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fechas_materias`
--

INSERT INTO `fechas_materias` (`id`, `id_Tecnicatura`, `id_Materia`, `fecha1`, `fecha2`) VALUES
(77, 1, 2, '2024-10-08', '2024-10-29'),
(79, 1, 3, '2024-10-03', '2024-10-04'),
(81, 1, 1, '2024-10-14', '2024-10-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `finales`
--

CREATE TABLE `finales` (
  `id_final` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_tecnicatura` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nota` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `finales`
--

INSERT INTO `finales` (`id_final`, `id_estudiante`, `id_tecnicatura`, `id_materia`, `fecha`, `nota`) VALUES
(1, 1, 1, 1, '2024-06-01', 7.99),
(2, 1, 1, 2, '2024-06-02', 7.75),
(3, 3, 2, 1, '2024-06-03', 9.00),
(4, 1, 1, 3, '2024-06-04', 6.50),
(5, 5, 3, 2, '2024-06-05', 8.00),
(6, 6, 3, 4, '2024-06-06', 7.25),
(7, 7, 1, 5, '2024-06-07', 9.50),
(8, 8, 2, 1, '2024-06-08', 5.00),
(9, 9, 1, 3, '2024-06-09', 8.75),
(10, 1, 1, 1, '2024-06-25', 6.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_Materia` int(11) NOT NULL,
  `Materia` varchar(30) NOT NULL,
  `IdTec` int(11) NOT NULL,
  `AnioCursada` varchar(15) NOT NULL,
  `Estado` tinyint(4) NOT NULL DEFAULT 1,
  `IdCorrelativas` int(11) DEFAULT NULL,
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_Materia`, `Materia`, `IdTec`, `AnioCursada`, `Estado`, `IdCorrelativas`, `FechaMod`) VALUES
(1, 'Prácticas profesionalizantes', 1, 'Primero', 1, NULL, '2024-09-02 21:01:29'),
(2, 'Inglés I', 1, 'Primero', 1, NULL, '2024-09-02 21:01:29'),
(3, 'Inglés II', 1, 'Segundo', 1, 2, '2024-09-02 21:01:29'),
(4, 'Estadísticas y Probabilidad', 1, 'Segundo', 1, NULL, '2024-09-02 21:01:29'),
(5, 'Álgebra Lineal', 2, 'Tercero', 1, 5, '2024-09-02 21:01:29'),
(6, 'Cálculo Diferencial', 2, 'Tercero', 1, 6, '2024-09-02 21:01:29'),
(7, 'Gestión de Empresas', 2, 'Segundo', 1, NULL, '2024-09-02 21:01:29'),
(8, 'Física I', 3, 'Primero', 1, NULL, '2024-09-02 21:01:29'),
(9, 'Química General', 3, 'Primero', 1, NULL, '2024-09-02 21:01:29'),
(10, 'Biología Celular', 4, 'Primero', 1, NULL, '2024-09-02 21:01:29'),
(11, 'Ingeniería de Software', 5, 'Tercero', 1, 10, '2024-09-02 21:01:29'),
(12, 'Redes de Computadoras', 5, 'Tercero', 1, 11, '2024-09-02 21:01:29'),
(13, 'Economía Micro', 6, 'Segundo', 1, NULL, '2024-09-02 21:01:29'),
(14, 'Economía Macro', 6, 'Tercero', 1, 13, '2024-09-02 21:01:29'),
(15, 'Psicología del Desarrollo', 7, 'Primero', 1, NULL, '2024-09-02 21:01:29'),
(16, 'Sociología', 7, 'Segundo', 1, NULL, '2024-09-02 21:01:29'),
(17, 'Filosofía de la Ciencia', 8, 'Tercero', 1, 16, '2024-09-02 21:01:29'),
(18, 'Geografía Humana', 9, 'Primero', 1, NULL, '2024-09-02 21:01:29'),
(19, 'Geografía Física', 9, 'Segundo', 1, 18, '2024-09-02 21:01:29'),
(20, 'Materia Técnica I', 10, 'Primero', 1, NULL, '2024-09-02 21:01:29'),
(21, 'Materia Técnica II', 10, 'Segundo', 1, 20, '2024-09-02 21:01:29'),
(22, 'Prácticas Profesionalizantes', 11, 'Tercero', 1, NULL, '2024-09-02 21:01:29'),
(23, 'Taller de Investigación', 12, 'Tercero', 1, NULL, '2024-09-02 21:01:29'),
(24, 'Matemáticas Avanzadas', 1, 'Tercero', 1, 5, '2024-09-02 21:01:29'),
(25, 'Inglés III', 1, 'Tercero', 1, 3, '2024-09-02 21:01:29'),
(26, 'Física II', 3, 'Segundo', 1, 8, '2024-09-02 21:01:29'),
(27, 'Química Orgánica', 3, 'Segundo', 1, 9, '2024-09-02 21:01:29'),
(28, 'Biología Molecular', 4, 'Segundo', 1, 12, '2024-09-02 21:01:29'),
(29, 'Ingeniería de Sistemas', 5, 'Tercero', 1, 14, '2024-09-02 21:01:29'),
(30, 'Redes de Sensores', 5, 'Tercero', 1, 15, '2024-09-02 21:01:29'),
(31, 'Economía Internacional', 6, 'Tercero', 1, 17, '2024-09-02 21:01:29'),
(32, 'Psicología Social', 7, 'Segundo', 1, NULL, '2024-09-02 21:01:29'),
(33, 'Sociología de la Educación', 7, 'Tercero', 1, 19, '2024-09-02 21:01:29'),
(34, 'Filosofía de la Historia', 8, 'Tercero', 1, 21, '2024-09-02 21:01:29'),
(35, 'Geografía Económica', 9, 'Tercero', 1, 22, '2024-09-02 21:01:29'),
(36, 'Materia Técnica III', 10, 'Tercero', 1, 23, '2024-09-02 21:01:29'),
(37, 'Prácticas de Investigación', 11, 'Tercero', 1, NULL, '2024-09-02 21:01:29'),
(38, 'Taller de Desarrollo', 12, 'Tercero', 1, NULL, '2024-09-02 21:01:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_Persona` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codRol` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `cuil` varchar(12) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `nacionalidad` varchar(20) DEFAULT NULL,
  `estado_civil` varchar(15) DEFAULT NULL,
  `domicilio` varchar(150) DEFAULT NULL,
  `pais` varchar(170) DEFAULT NULL,
  `telefono_1` varchar(30) DEFAULT NULL,
  `telefono_2` varchar(30) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_Persona`, `idUsuario`, `nombre`, `apellido`, `email`, `codRol`, `dni`, `cuil`, `fecha_nacimiento`, `nacionalidad`, `estado_civil`, `domicilio`, `pais`, `telefono_1`, `telefono_2`, `titulo`, `FechaMod`) VALUES
(1, 1, 'Fernando', 'Zarra', 'fzarra@example.com', 5, '12345678', '12345678901', '1990-01-01', 'Argentina', 'Soltero', 'Calle 123', 'Argentina', '1234567890', '0987654321', 'Ingeniero', '2024-09-02 21:01:29'),
(2, 2, 'Gisela', 'Brasesco', 'gbrasesco@example.com', 5, '23456789', '23456789012', '1991-02-02', 'Argentina', 'Casada', 'Calle 456', 'Argentina', '2345678901', '0987654322', 'Abogada', '2024-09-02 21:01:29'),
(3, 3, 'Ana', 'Morales', 'amorales@example.com', 5, '34567890', '34567890123', '1992-03-03', 'Argentina', 'Soltera', 'Calle 789', 'Argentina', '3456789012', '0987654323', 'Médica', '2024-09-02 21:01:29'),
(4, 4, 'Natali', 'Perez', 'nperez@example.com', 4, '45678901', '45678901234', '1993-04-04', 'Argentina', 'Casada', 'Calle 012', 'Argentina', '4567890123', '0987654324', 'Contadora', '2024-09-02 21:01:29'),
(5, 5, 'Clide', 'Clide', 'cclide@example.com', 4, '56789012', '56789012345', '1994-05-05', 'Argentina', 'Soltero', 'Calle 345', 'Argentina', '5678901234', '0987654325', 'Ingeniero', '2024-09-02 21:01:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `codRol` int(11) NOT NULL,
  `nombreRol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`codRol`, `nombreRol`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'director'),
(4, 'preceptor'),
(5, 'docente'),
(6, 'alumno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicaturas`
--

CREATE TABLE `tecnicaturas` (
  `id_Tecnicatura` int(11) NOT NULL,
  `nombreTec` varchar(100) NOT NULL,
  `Resolucion` varchar(100) NOT NULL,
  `EstadoTec` tinyint(4) NOT NULL DEFAULT 1,
  `FechaModificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tecnicaturas`
--

INSERT INTO `tecnicaturas` (`id_Tecnicatura`, `nombreTec`, `Resolucion`, `EstadoTec`, `FechaModificacion`) VALUES
(1, 'Tecnicatura superior en desarrollo de software', '123-abc', 1, '2024-09-02 21:01:29'),
(2, 'Tecnicatura en Recursos Humanos', '456-def', 1, '2024-09-02 21:01:29'),
(3, 'Tecnicatura en Gastronomia', '789-ghi', 1, '2024-09-02 21:01:29'),
(4, 'Tecnicatura en Administracion General', '901-jkl', 1, '2024-09-02 21:01:29'),
(5, 'Tecnicatura en Administracion Agricola', '234-mno', 1, '2024-09-02 21:01:29'),
(6, 'Tecnicatura en Agroecologia', '567-pqr', 1, '2024-09-02 21:01:29'),
(7, 'Tecnicatura en Diseño Grafico', '890-stu', 1, '2024-09-02 21:01:29'),
(8, 'Tecnicatura en Marketing Digital', '345-vwx', 1, '2024-09-02 21:01:29'),
(9, 'Tecnicatura en Contabilidad', '678-yza', 1, '2024-09-02 21:01:29'),
(10, 'Tecnicatura en Analisis de Sistemas', '456-bcd', 1, '2024-09-02 21:01:29'),
(11, 'Tecnicatura en Logistica y Transporte', '901-efg', 1, '2024-09-02 21:01:29'),
(12, 'Tecnicatura en Turismo Sostenible', '234-hij', 1, '2024-09-02 21:01:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocursada`
--

CREATE TABLE `tipocursada` (
  `id_Tipocursada` int(11) NOT NULL,
  `tipocursada` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipocursada`
--

INSERT INTO `tipocursada` (`id_Tipocursada`, `tipocursada`) VALUES
(1, 'Regular'),
(2, 'Libre'),
(3, 'Libre_Desaprobado'),
(4, 'Equivalencia'),
(5, 'Oyente'),
(6, 'Vocacional'),
(7, 'Itinerante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'estudiante', '$2y$10$5hXLxf4GSELczk81C7RJWe6N8x5N/9pAgPAZPcAjmTSfWwEC.Q.im');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `codRol` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasenia` varchar(50) DEFAULT NULL,
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `codRol`, `usuario`, `contrasenia`, `FechaMod`) VALUES
(1, 1, 'admin', 'admin', '2024-09-02 21:01:29'),
(2, 2, 'user', 'user', '2024-09-02 21:01:29'),
(3, 3, 'director', 'director', '2024-09-02 21:01:29'),
(4, 4, 'preceptor', 'preceptor', '2024-09-02 21:01:29'),
(5, 5, 'docente', 'docente', '2024-09-02 21:01:29'),
(8, 6, 'estudiante', '$2y$10$YOvK.pe/XxTmIQYT5Eiik.HvnTSWetOyUxjnnhE6XiG', '2024-09-24 22:19:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`idCertificado`);

--
-- Indices de la tabla `correlativas`
--
ALTER TABLE `correlativas`
  ADD PRIMARY KEY (`id_corr`),
  ADD KEY `idTec` (`idTec`),
  ADD KEY `idMateria` (`idMateria`);

--
-- Indices de la tabla `docentesmaterias`
--
ALTER TABLE `docentesmaterias`
  ADD PRIMARY KEY (`iddocentesmaterias`),
  ADD KEY `id_Persona` (`id_Persona`),
  ADD KEY `id_Materia` (`id_Materia`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id_estudiante`);

--
-- Indices de la tabla `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  ADD PRIMARY KEY (`id_estudiante_materia`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_Materia` (`id_Materia`);

--
-- Indices de la tabla `estudiante_tecnicatura`
--
ALTER TABLE `estudiante_tecnicatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_Tecnicatura` (`id_Tecnicatura`);

--
-- Indices de la tabla `fechas_materias`
--
ALTER TABLE `fechas_materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_fecha` (`id_Tecnicatura`,`id_Materia`),
  ADD KEY `id_Materia` (`id_Materia`);

--
-- Indices de la tabla `finales`
--
ALTER TABLE `finales`
  ADD PRIMARY KEY (`id_final`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_tecnicatura` (`id_tecnicatura`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_Materia`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_Persona`),
  ADD UNIQUE KEY `idUsuario` (`idUsuario`),
  ADD KEY `codRol` (`codRol`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`codRol`);

--
-- Indices de la tabla `tecnicaturas`
--
ALTER TABLE `tecnicaturas`
  ADD PRIMARY KEY (`id_Tecnicatura`);

--
-- Indices de la tabla `tipocursada`
--
ALTER TABLE `tipocursada`
  ADD PRIMARY KEY (`id_Tipocursada`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `codRol` (`codRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `idCertificado` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `correlativas`
--
ALTER TABLE `correlativas`
  MODIFY `id_corr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `docentesmaterias`
--
ALTER TABLE `docentesmaterias`
  MODIFY `iddocentesmaterias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  MODIFY `id_estudiante_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `estudiante_tecnicatura`
--
ALTER TABLE `estudiante_tecnicatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `fechas_materias`
--
ALTER TABLE `fechas_materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `finales`
--
ALTER TABLE `finales`
  MODIFY `id_final` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_Materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_Persona` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `codRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tecnicaturas`
--
ALTER TABLE `tecnicaturas`
  MODIFY `id_Tecnicatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tipocursada`
--
ALTER TABLE `tipocursada`
  MODIFY `id_Tipocursada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `correlativas`
--
ALTER TABLE `correlativas`
  ADD CONSTRAINT `correlativas_ibfk_1` FOREIGN KEY (`idTec`) REFERENCES `tecnicaturas` (`id_Tecnicatura`),
  ADD CONSTRAINT `correlativas_ibfk_2` FOREIGN KEY (`idMateria`) REFERENCES `materias` (`id_Materia`);

--
-- Filtros para la tabla `docentesmaterias`
--
ALTER TABLE `docentesmaterias`
  ADD CONSTRAINT `docentesmaterias_ibfk_1` FOREIGN KEY (`id_Persona`) REFERENCES `personas` (`id_Persona`),
  ADD CONSTRAINT `docentesmaterias_ibfk_2` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`);

--
-- Filtros para la tabla `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  ADD CONSTRAINT `estudiante_materia_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`),
  ADD CONSTRAINT `estudiante_materia_ibfk_2` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`);

--
-- Filtros para la tabla `estudiante_tecnicatura`
--
ALTER TABLE `estudiante_tecnicatura`
  ADD CONSTRAINT `estudiante_tecnicatura_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`),
  ADD CONSTRAINT `estudiante_tecnicatura_ibfk_2` FOREIGN KEY (`id_Tecnicatura`) REFERENCES `tecnicaturas` (`id_Tecnicatura`);

--
-- Filtros para la tabla `fechas_materias`
--
ALTER TABLE `fechas_materias`
  ADD CONSTRAINT `fechas_materias_ibfk_1` FOREIGN KEY (`id_Tecnicatura`) REFERENCES `tecnicaturas` (`id_Tecnicatura`) ON DELETE CASCADE,
  ADD CONSTRAINT `fechas_materias_ibfk_2` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `finales`
--
ALTER TABLE `finales`
  ADD CONSTRAINT `finales_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`) ON DELETE CASCADE,
  ADD CONSTRAINT `finales_ibfk_2` FOREIGN KEY (`id_tecnicatura`) REFERENCES `tecnicaturas` (`id_Tecnicatura`) ON DELETE CASCADE,
  ADD CONSTRAINT `finales_ibfk_3` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_Materia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`codRol`) REFERENCES `roles` (`codRol`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`codRol`) REFERENCES `roles` (`codRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
