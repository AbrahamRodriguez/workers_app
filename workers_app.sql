-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-01-2022 a las 03:57:05
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `workers_app`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `AGREGAR_TRABAJADOR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AGREGAR_TRABAJADOR` (IN `new_last_name` VARCHAR(120), IN `new_name` VARCHAR(120), IN `new_phone` VARCHAR(120), IN `new_email` VARCHAR(120))  BEGIN
  insert into employees (name, last_name , phone, email , active ) values (new_name , new_last_name , new_phone , new_email , 1 );
END$$

DROP PROCEDURE IF EXISTS `BUSCAR_EMPLEADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `BUSCAR_EMPLEADO` (IN `IDU` INT(120))  SELECT name , last_name , phone , email FROM employees WHERE id_employees = IDU$$

DROP PROCEDURE IF EXISTS `ELIMINAR_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIMINAR_USUARIO` (IN `IDD` INT(120))  UPDATE employees SET active = 0 WHERE id_employees = IDD$$

DROP PROCEDURE IF EXISTS `MODIFICAR_NOMINA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `MODIFICAR_NOMINA` (IN `idu` INT(12), IN `new_last_name` VARCHAR(120), IN `new_name` VARCHAR(120), IN `new_phone` VARCHAR(120), IN `new_email` VARCHAR(120))  BEGIN
UPDATE employees SET name =  new_name , last_name = new_last_name, phone = new_phone , email = new_email
  WHERE id_employees = idu;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id_employees` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `last_name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(120) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id_employees`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id_employees`, `name`, `last_name`, `email`, `phone`, `active`) VALUES
(1, 'Allan', 'Poe', 'allan_poe_09@email.com', '4435679083', 1),
(2, 'Clive S.', 'Lewis', 'cs_lewis_98@email.com', '4437094524', 1),
(3, 'JK', 'Rowling', 'jk_rowling_65@email.com', '4436122456', 1),
(4, 'Cassandra', 'Clare', 'cassandra_clare_73@email.com', '4437972345', 1),
(5, 'Stephen', 'King', 'stephen_king_47@email.com', '4438996523', 1),
(6, 'Jose', 'Saramago', 'jsaramago@gmail.com', '4433886677', 1),
(7, 'Henry', 'Lee Lucas', 'portrait@gmail.com', '4431448899', 0),
(8, 'Isabel', 'Allende', 'iallende@gmail.com', '4435886677', 1),
(9, 'TERFA', 'Rowling', 'jk_rowling_65@email.com', '4436122456', 0),
(10, 'Ernesto', 'Sabato', 'esabato@gmail.com', '4437890300', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
