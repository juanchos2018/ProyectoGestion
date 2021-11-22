-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.14-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sistemagc
CREATE DATABASE IF NOT EXISTS `sistemagc` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `sistemagc`;

-- Volcando estructura para tabla sistemagc.cronograma
CREATE TABLE IF NOT EXISTS `cronograma` (
  `id_cronograma` int(100) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` varchar(100) DEFAULT NULL,
  `fecha_termino` varchar(100) DEFAULT NULL,
  `id_proyecto` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_cronograma`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.cronograma: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `cronograma` DISABLE KEYS */;
INSERT INTO `cronograma` (`id_cronograma`, `fecha_inicio`, `fecha_termino`, `id_proyecto`) VALUES
	(1, '2021-11-22', '2022-01-27', 1);
/*!40000 ALTER TABLE `cronograma` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.cronogramafase
CREATE TABLE IF NOT EXISTS `cronogramafase` (
  `id_cronograma_fase` int(100) NOT NULL AUTO_INCREMENT,
  `coronogramaId` int(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `id_fase` int(100) DEFAULT NULL,
  `porcentaje` int(100) DEFAULT NULL,
  `porcentaje_avance` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_cronograma_fase`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.cronogramafase: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `cronogramafase` DISABLE KEYS */;
INSERT INTO `cronogramafase` (`id_cronograma_fase`, `coronogramaId`, `nombre`, `id_fase`, `porcentaje`, `porcentaje_avance`) VALUES
	(1, 1, 'Inicio', 1, 25, 13),
	(2, 1, 'Planificacion', 2, 25, 0),
	(3, 1, 'Implementación', 3, 25, 0),
	(4, 1, 'Revisión', 4, 25, 0);
/*!40000 ALTER TABLE `cronogramafase` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.cronograma_elemento
CREATE TABLE IF NOT EXISTS `cronograma_elemento` (
  `id_cronograma_elemento` int(100) NOT NULL AUTO_INCREMENT,
  `id_elemento` varchar(100) DEFAULT NULL,
  `nombre_elemento` varchar(100) DEFAULT NULL,
  `coronogramaId` int(100) DEFAULT NULL,
  `id_cronograma_fase` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_cronograma_elemento`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.cronograma_elemento: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `cronograma_elemento` DISABLE KEYS */;
INSERT INTO `cronograma_elemento` (`id_cronograma_elemento`, `id_elemento`, `nombre_elemento`, `coronogramaId`, `id_cronograma_fase`) VALUES
	(1, '2', 'prototipos', 1, 1),
	(2, '3', 'Casos de uso', 1, 1),
	(3, '4', 'diagrama de clases', 2, 2),
	(4, '5', 'diagrama de secuencia', 2, 2),
	(5, '6', 'diagrama de  despliegue', 3, 3),
	(6, '7', 'sat', 3, 3),
	(7, '22', 'Manual de Usuario', 4, 4),
	(8, '23', 'Manual de Instalación', 4, 4);
/*!40000 ALTER TABLE `cronograma_elemento` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.elementoconfiguracion
CREATE TABLE IF NOT EXISTS `elementoconfiguracion` (
  `id_elemento` int(100) NOT NULL AUTO_INCREMENT,
  `codigo_elemento` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_elemento`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.elementoconfiguracion: ~24 rows (aproximadamente)
/*!40000 ALTER TABLE `elementoconfiguracion` DISABLE KEYS */;
INSERT INTO `elementoconfiguracion` (`id_elemento`, `codigo_elemento`, `nombre`) VALUES
	(2, 'e-001', 'prototipos'),
	(3, 'e-002', 'Casos de uso'),
	(4, 'e-003', 'diagrama de clases'),
	(5, 'e-004', 'diagrama de secuencia'),
	(6, 'e-005', 'diagrama de  despliegue'),
	(7, 'e-006', 'sat'),
	(8, 'e-007', 'especificar información sobre el inventario'),
	(9, 'e-008', 'reporte'),
	(10, 'ere', 'neuvo'),
	(11, 'E-010', 'elemnto 10'),
	(12, 'E-011', 'elemnto 11'),
	(13, 'E-012', 'elemnto 12'),
	(14, 'E13', 'modificrere'),
	(15, 'E-014', 'elemeto 13'),
	(16, 'EE', 'Esepecificación de Requerimientos'),
	(17, 'EP', 'Esepecificación de Paquetes'),
	(18, 'ECU', 'Especificación de Casos de usos'),
	(19, 'PT', 'Prototipos de Pantalla'),
	(20, 'DC', 'Diagrama de Componentes'),
	(21, 'SW', 'Sistema Web'),
	(22, 'MU', 'Manual de Usuario'),
	(23, 'MI', 'Manual de Instalación'),
	(24, 'MT', 'Manual de Tecnico'),
	(25, 'AIF', 'Acta de Informe Final');
/*!40000 ALTER TABLE `elementoconfiguracion` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.fase
CREATE TABLE IF NOT EXISTS `fase` (
  `id_fase` int(100) NOT NULL AUTO_INCREMENT,
  `nombre_fase` varchar(50) DEFAULT NULL,
  `metodologiaId` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_fase`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.fase: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `fase` DISABLE KEYS */;
INSERT INTO `fase` (`id_fase`, `nombre_fase`, `metodologiaId`) VALUES
	(1, 'Inicio', 1),
	(2, 'Planificacion', 1),
	(3, 'Implementación', 1),
	(4, 'Revisión', 1);
/*!40000 ALTER TABLE `fase` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.historial_tarea_ecs
CREATE TABLE IF NOT EXISTS `historial_tarea_ecs` (
  `id_historial` int(100) NOT NULL AUTO_INCREMENT,
  `id_timeline` int(100) DEFAULT NULL,
  `miembroresponsableID` int(100) DEFAULT NULL,
  `id_tarea` int(100) DEFAULT NULL,
  `fecha` varchar(100) DEFAULT NULL,
  `porcentajeavance` int(100) DEFAULT NULL,
  `urlevidencia` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_historial`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.historial_tarea_ecs: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `historial_tarea_ecs` DISABLE KEYS */;
INSERT INTO `historial_tarea_ecs` (`id_historial`, `id_timeline`, `miembroresponsableID`, `id_tarea`, `fecha`, `porcentajeavance`, `urlevidencia`, `descripcion`) VALUES
	(1, 1, 2, 26, '22/11/2021', 23, 'https://www.proturbiomarspa.com/files/_pdf-prueba.pdf', 'avance de proyecto'),
	(2, 2, 2, 26, '22/11/2021', 37, 'https://www.proturbiomarspa.com/files/_pdf-prueba.pdf', 'avance de proyecto 2 '),
	(3, 3, 2, 26, '22/11/2021', 58, 'https://www.proturbiomarspa.com/files/_pdf-prueba.pdf', 'avance de proyecto mejorado '),
	(4, 4, 2, 27, '22/11/2021', 19, 'https://www.proturbiomarspa.com/files/_pdf-prueba.pdf', 'iniciando esta tarea'),
	(5, 5, 2, 27, '22/11/2021', 55, 'https://www.proturbiomarspa.com/files/_pdf-prueba.pdf', 'iniciando esta tarea otra vez'),
	(6, 6, 2, 26, '22/11/2021', 100, 'https://www.proturbiomarspa.com/files/_pdf-prueba.pdf', 'termine al tarea jefe');
/*!40000 ALTER TABLE `historial_tarea_ecs` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.informecambio
CREATE TABLE IF NOT EXISTS `informecambio` (
  `id_informe` int(100) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `solicitudcambioId` int(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `tiempo` varchar(100) DEFAULT NULL,
  `costo` decimal(10,2) DEFAULT NULL,
  `impactoproblema` varchar(100) DEFAULT NULL,
  `fecha` varchar(100) DEFAULT NULL,
  `miembrojefeId` int(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_informe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.informecambio: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `informecambio` DISABLE KEYS */;
/*!40000 ALTER TABLE `informecambio` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.informecambiodetalle
CREATE TABLE IF NOT EXISTS `informecambiodetalle` (
  `id_detalle` int(100) NOT NULL AUTO_INCREMENT,
  `id_informecambio` int(100) DEFAULT NULL,
  `cronogramaelemetoId` int(100) DEFAULT NULL,
  `miembroresponsableId` int(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `fechainicio` varchar(100) DEFAULT NULL,
  `fechatermino` varchar(100) DEFAULT NULL,
  `porcentajeavance` int(100) DEFAULT NULL,
  `predecesota` varchar(100) DEFAULT NULL,
  `nombreelemento` varchar(100) DEFAULT NULL,
  `tiempo` varchar(100) DEFAULT NULL,
  `costo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_detalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.informecambiodetalle: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `informecambiodetalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `informecambiodetalle` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.metodologia
CREATE TABLE IF NOT EXISTS `metodologia` (
  `id_metodologia` int(100) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_metodologia`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.metodologia: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `metodologia` DISABLE KEYS */;
INSERT INTO `metodologia` (`id_metodologia`, `nombre`) VALUES
	(1, 'scrum');
/*!40000 ALTER TABLE `metodologia` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.miembroproyecto
CREATE TABLE IF NOT EXISTS `miembroproyecto` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `usuario_miembroid` int(100) DEFAULT NULL,
  `rolId` int(100) DEFAULT NULL,
  `proyectoId` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.miembroproyecto: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `miembroproyecto` DISABLE KEYS */;
INSERT INTO `miembroproyecto` (`id`, `usuario_miembroid`, `rolId`, `proyectoId`) VALUES
	(1, 1, 1, 1),
	(2, 2, 2, 1),
	(3, 3, 2, 1);
/*!40000 ALTER TABLE `miembroproyecto` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.plantillaconfiguracion
CREATE TABLE IF NOT EXISTS `plantillaconfiguracion` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `faseId` int(100) DEFAULT NULL,
  `elementoId` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.plantillaconfiguracion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `plantillaconfiguracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `plantillaconfiguracion` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.plantillaelementoconfiguracion
CREATE TABLE IF NOT EXISTS `plantillaelementoconfiguracion` (
  `id_plantilla` int(100) NOT NULL AUTO_INCREMENT,
  `faseId` int(100) DEFAULT NULL,
  `elementoId` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_plantilla`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.plantillaelementoconfiguracion: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `plantillaelementoconfiguracion` DISABLE KEYS */;
INSERT INTO `plantillaelementoconfiguracion` (`id_plantilla`, `faseId`, `elementoId`) VALUES
	(1, 1, 2),
	(2, 1, 3),
	(3, 2, 4),
	(4, 2, 5),
	(5, 3, 6),
	(6, 3, 7),
	(7, 4, 22),
	(8, 4, 23);
/*!40000 ALTER TABLE `plantillaelementoconfiguracion` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.proyecto
CREATE TABLE IF NOT EXISTS `proyecto` (
  `id_proyecto` int(100) NOT NULL AUTO_INCREMENT,
  `codigo_proyecto` varchar(10) DEFAULT NULL,
  `nombre_proyecto` varchar(50) DEFAULT NULL,
  `fecha_inicio` varchar(50) DEFAULT NULL,
  `fecha_termino` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `metodologiaId` int(100) DEFAULT NULL,
  `usuariojefeId` int(100) DEFAULT NULL,
  `porcentaje` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.proyecto: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` (`id_proyecto`, `codigo_proyecto`, `nombre_proyecto`, `fecha_inicio`, `fecha_termino`, `descripcion`, `estado`, `metodologiaId`, `usuariojefeId`, `porcentaje`) VALUES
	(1, '', 'Proyecto Prueba', '2021-11-22', '2022-01-27', 'descripcion de proyecto', 'activo', 1, 1, 3);
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.proyectoelementos
CREATE TABLE IF NOT EXISTS `proyectoelementos` (
  `idprolemento` int(100) NOT NULL AUTO_INCREMENT,
  `id_proyecto` int(100) DEFAULT NULL,
  `id_metodologia` int(100) DEFAULT NULL,
  `id_fase` int(100) DEFAULT NULL,
  `id_elemeto` int(100) DEFAULT NULL,
  PRIMARY KEY (`idprolemento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.proyectoelementos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `proyectoelementos` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectoelementos` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.prueba
CREATE TABLE IF NOT EXISTS `prueba` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nombreproyecto` varchar(100) DEFAULT NULL,
  `tarea1` int(100) DEFAULT NULL,
  `tarea2` int(100) DEFAULT NULL,
  `tarea3` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.prueba: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `prueba` DISABLE KEYS */;
/*!40000 ALTER TABLE `prueba` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.rol
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(100) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.rol: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
	(1, 'Jefe de Proyecto'),
	(2, 'Analista de Sistemas'),
	(3, 'Desarollador'),
	(4, 'Diseñador'),
	(5, 'Arquitecto de Software'),
	(6, 'Auditor');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.solicitudcambio
CREATE TABLE IF NOT EXISTS `solicitudcambio` (
  `id_solicitud` int(100) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `id_proyecto` int(100) DEFAULT NULL,
  `miembrojefeId` int(100) DEFAULT NULL,
  `miembrosolicitanteId` int(100) DEFAULT NULL,
  `fecha` varchar(100) DEFAULT NULL,
  `objetivo` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `respuesta` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `documento` varchar(500) DEFAULT NULL,
  `elemento` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.solicitudcambio: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `solicitudcambio` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitudcambio` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.tareas2
CREATE TABLE IF NOT EXISTS `tareas2` (
  `id_tarea` int(100) NOT NULL AUTO_INCREMENT,
  `nombre_tarea` varchar(100) DEFAULT NULL,
  `estado_tarea` varchar(100) DEFAULT NULL,
  `fecha_tarea` varchar(100) DEFAULT NULL,
  `id_proyecto` int(100) DEFAULT NULL,
  `id_fase` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_tarea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.tareas2: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tareas2` DISABLE KEYS */;
/*!40000 ALTER TABLE `tareas2` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.tarea_ecs
CREATE TABLE IF NOT EXISTS `tarea_ecs` (
  `id_tarea` int(100) NOT NULL AUTO_INCREMENT,
  `verionID` int(100) DEFAULT NULL,
  `miembroresponsableID` int(100) DEFAULT NULL,
  `fecha_inicio` varchar(100) DEFAULT NULL,
  `fecha_termino` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `porcentajeavance` int(100) DEFAULT NULL,
  `urlevidencia` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `estado1` varchar(100) DEFAULT NULL,
  `estado2` varchar(100) DEFAULT NULL,
  `respuesta` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_tarea`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.tarea_ecs: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `tarea_ecs` DISABLE KEYS */;
INSERT INTO `tarea_ecs` (`id_tarea`, `verionID`, `miembroresponsableID`, `fecha_inicio`, `fecha_termino`, `descripcion`, `porcentajeavance`, `urlevidencia`, `estado`, `estado1`, `estado2`, `respuesta`) VALUES
	(26, 1, 2, '2021-11-22', '2021-11-26', 'tarea neuva', 100, 'https://www.proturbiomarspa.com/files/_pdf-prueba.pdf', 'Terminado', 'Terminado', 'Aprobado', 'Aprobado'),
	(27, 1, 2, '2021-11-22', '', 'Tarea  2', 55, 'https://www.proturbiomarspa.com/files/_pdf-prueba.pdf', 'Proceso', 'Proceso', NULL, NULL),
	(28, 2, 2, '2021-11-25', '2021-11-30', 'tarea 3', 0, 'nulo', 'Nuevo', 'Nuevo', NULL, NULL);
/*!40000 ALTER TABLE `tarea_ecs` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.timeline
CREATE TABLE IF NOT EXISTS `timeline` (
  `id_timeline` int(100) NOT NULL AUTO_INCREMENT,
  `miembroresponsableID` int(100) DEFAULT NULL,
  `fecha` varchar(100) DEFAULT NULL,
  `hora` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `id_tarea` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_timeline`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.timeline: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `timeline` DISABLE KEYS */;
INSERT INTO `timeline` (`id_timeline`, `miembroresponsableID`, `fecha`, `hora`, `estado`, `id_tarea`) VALUES
	(1, 2, '22/11/2021', '10:20:35', 'Proceso', 26),
	(2, 2, '22/11/2021', '10:20:35', 'Proceso', 26),
	(3, 2, '22/11/2021', '10:20:35', 'Proceso', 26),
	(4, 2, '22/11/2021', '10:20:35', 'Proceso', 27),
	(5, 2, '22/11/2021', '10:20:35', 'Proceso', 27),
	(6, 2, '22/11/2021', '10:24:11', 'Proceso', 26);
/*!40000 ALTER TABLE `timeline` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.tipousuario
CREATE TABLE IF NOT EXISTS `tipousuario` (
  `id_tipo` int(100) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.tipousuario: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `tipousuario` DISABLE KEYS */;
INSERT INTO `tipousuario` (`id_tipo`, `nombre`) VALUES
	(1, 'Administrador'),
	(2, 'Jefe'),
	(3, 'Miembro'),
	(4, 'Cliente');
/*!40000 ALTER TABLE `tipousuario` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(100) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `tiposusuarioId` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.usuario: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `correo`, `password`, `tiposusuarioId`) VALUES
	(1, 'jesus', 'jesus', 'jesus@gmail.com', '123456', 2),
	(2, 'pedro', 'huilca', 'pedro@gmail.com', '123456', 3),
	(3, 'adres', 'laura', 'laura@gmail.com', '123456', 3),
	(4, 'ingeniero', 'valcarcel', 'valcarcel@gmail.com', '123456', 1),
	(5, 'jose', 'jose', 'jose@gmail.com', '123456', 2),
	(6, 'pepe', 'pepe', 'pepe@gmail.com', '123456', 3),
	(7, 'pedro', 'pedro', 'pedro@gmail.com', '123456', 2),
	(8, 'miguel', 'migeul', 'miguel@gmail.com', '123456', 2),
	(9, 'julio', 'julio', 'julio@gmail.com', '123456', 3),
	(10, 'randy', 'randy', 'randy@gmail.com', '123456', 3);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

-- Volcando estructura para tabla sistemagc.version
CREATE TABLE IF NOT EXISTS `version` (
  `id_version` int(100) NOT NULL AUTO_INCREMENT,
  `elemntoconfiguracionID` int(100) DEFAULT NULL,
  `version` varchar(100) DEFAULT NULL,
  `fecha_inicio` varchar(100) DEFAULT NULL,
  `fecha_termino` varchar(100) DEFAULT NULL,
  `miembroresponsableID` int(100) DEFAULT NULL,
  PRIMARY KEY (`id_version`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sistemagc.version: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `version` DISABLE KEYS */;
INSERT INTO `version` (`id_version`, `elemntoconfiguracionID`, `version`, `fecha_inicio`, `fecha_termino`, `miembroresponsableID`) VALUES
	(1, 1, '1', '2021-11-22', '2021-11-27', 2),
	(2, 2, '1', '2021-11-22', '2022-01-27', 2);
/*!40000 ALTER TABLE `version` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
