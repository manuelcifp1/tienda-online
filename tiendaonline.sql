-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-06-2025 a las 15:29:42
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendaonline`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

DROP TABLE IF EXISTS `carritos`;
CREATE TABLE IF NOT EXISTS `carritos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id` (`usuario_id`,`producto_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Marvel'),
(2, 'DC'),
(3, 'Independiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos`
--

DROP TABLE IF EXISTS `detalles_pedidos`;
CREATE TABLE IF NOT EXISTS `detalles_pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `compra_id` (`pedido_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos`
--

INSERT INTO `detalles_pedidos` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 1, 1, 9.99),
(2, 1, 3, 1, 12.50),
(3, 1, 4, 1, 13.99),
(4, 1, 10, 1, 14.00),
(5, 2, 3, 1, 12.50),
(6, 2, 5, 1, 10.99),
(7, 2, 7, 1, 13.50),
(8, 5, 2, 1, 11.99),
(9, 5, 5, 1, 10.99),
(10, 6, 2, 1, 11.99),
(11, 6, 5, 1, 10.99),
(12, 7, 10, 1, 14.00),
(13, 7, 20, 1, 9.95),
(14, 8, 10, 1, 14.00),
(15, 8, 22, 1, 12.00),
(16, 8, 24, 1, 13.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `fecha`, `total`) VALUES
(1, 1, '2025-06-04 08:16:53', 50.48),
(2, 3, '2025-06-04 11:24:04', 36.99),
(3, 3, '2025-06-07 19:18:28', 0.00),
(4, 3, '2025-06-07 19:19:10', 0.00),
(5, 3, '2025-06-07 19:27:38', 0.00),
(6, 3, '2025-06-08 12:19:27', 0.00),
(7, 3, '2025-06-08 12:24:15', 0.00),
(8, 3, '2025-06-08 15:28:04', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `precio` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `categoria_id` int DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `categoria_id`, `imagen`) VALUES
(1, 'Spider-Man: El regreso', 'Una nueva amenaza llega a Nueva York y Peter Parker deberá enfrentarse a sus peores miedos.', 9.99, 19, 1, 'comic2.jpg'),
(2, 'Batman: Año Uno', 'Los primeros pasos de Bruce Wayne como vigilante en Gotham.', 11.99, 13, 2, 'comic3.jpg'),
(3, 'X-Men: Génesis Mortal', 'Los mutantes descubren un oscuro secreto del pasado.', 12.50, 10, 1, 'comic4.jpg'),
(4, 'Superman: Hijo Rojo', '¿Y si Superman hubiera caído en la URSS en lugar de Kansas?', 13.99, 9, 2, 'comic5.jpg'),
(5, 'Iron Man: Extremis', 'Tony Stark debe enfrentarse a una tecnología que lo supera.', 10.99, 15, 1, 'comic1.jpg'),
(6, 'Flash: Punto de Inflexión', 'Barry Allen altera la línea temporal... y lo paga caro.', 11.50, 14, 2, 'comic2.jpg'),
(7, 'Avengers: Invasión Secreta', '¿Quién es real? ¿Quién es un skrull?', 13.50, 15, 1, 'comic3.jpg'),
(8, 'Wonder Woman: Renacimiento', 'Diana intenta redescubrir su verdadero origen.', 12.99, 11, 2, 'comic4.jpg'),
(9, 'Doctor Strange: El juramento', 'Stephen Strange lucha por salvar a su fiel amigo Wong.', 10.50, 20, 1, 'comic5.jpg'),
(10, 'Green Lantern: Sinestro Corps', 'La guerra de las luces comienza.', 14.00, 6, 2, 'comic1.jpg'),
(11, 'Deadpool: Masacre Ilimitada', 'Más humor, más violencia, más Deadpool.', 9.99, 25, 1, 'comic2.jpg'),
(12, 'Aquaman: El trono de Atlantis', 'La guerra entre la superficie y el mar se desata.', 12.75, 13, 2, 'comic3.jpg'),
(13, 'Guardianes de la Galaxia: Origen', 'Star-Lord reúne a un grupo bastante... disfuncional.', 11.20, 17, 1, 'comic4.jpg'),
(14, 'Harley Quinn: Rompiendo reglas', 'Harley busca su propio camino... explosivamente.', 10.80, 14, 2, 'comic5.jpg'),
(15, 'Black Panther: Nación bajo nuestros pies', 'T’Challa lucha por restaurar Wakanda.', 13.25, 12, 1, 'comic1.jpg'),
(16, 'JLA: La nueva frontera', 'La Liga se enfrenta a su mayor crisis existencial.', 11.75, 8, 2, 'comic2.jpg'),
(17, 'Capitán América: El Soldado de Invierno', 'Bucky ha vuelto... y no es quien solía ser.', 13.00, 10, 1, 'comic3.jpg'),
(18, 'Shazam!: Poder mágico', 'Billy Batson descubre lo que significa ser héroe.', 10.50, 15, 2, 'comic4.jpg'),
(19, 'Moon Knight: Locura y redención', 'Marc Spector lidia con sus múltiples identidades.', 11.99, 13, 1, 'comic5.jpg'),
(20, 'Arrow: Vigilante de Star City', 'Oliver Queen lucha por salvar su ciudad.', 9.95, 17, 2, 'comic1.jpg'),
(21, 'Invencible: Primer golpe', 'Un joven con poderes hereda una gran responsabilidad.', 10.50, 14, 3, 'comic2.jpg'),
(22, 'Saga: Capítulo Uno', 'Una historia de amor y guerra intergaláctica.', 12.00, 15, 3, 'comic3.jpg'),
(23, 'The Walking Dead: Días pasados', 'Rick despierta en un mundo... muerto.', 11.50, 11, 3, 'comic4.jpg'),
(24, 'Hellboy: Semilla de destrucción', 'El origen del demonio más carismático de la BPRD.', 13.99, 9, 3, 'comic5.jpg'),
(25, 'Sandman: Preludios y Nocturnos', 'Neil Gaiman teje un universo de sueños y pesadillas.', 14.50, 9, 3, 'comic1.jpg'),
(26, 'Kick-Ass: Aprendiendo a pelear', '¿Qué pasa si un adolescente decide ser superhéroe?', 10.90, 20, 3, 'comic2.jpg'),
(27, 'Spawn: Renacimiento oscuro', 'Al Simmons vuelve del infierno... con sed de venganza.', 13.25, 12, 3, 'comic3.jpg'),
(28, 'Watchmen', '¿Quién vigila a los vigilantes?', 14.99, 8, 3, 'comic4.jpg'),
(29, 'V de Vendetta', 'Un revolucionario lucha contra un gobierno totalitario.', 13.75, 10, 3, 'comic5.jpg'),
(30, 'Scott Pilgrim contra el mundo', 'El amor verdadero puede ser una batalla épica.', 11.95, 15, 3, 'comic1.jpg'),
(31, 'Moon Knight', 'Primer número de la nueva colección del Caballero Luna, el puño de Konshu.', 5.00, 30, 1, 'comic6.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_general_ci,
  `rol` enum('cliente','admin') COLLATE utf8mb4_general_ci DEFAULT 'cliente',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `direccion`, `rol`, `creado_en`) VALUES
(3, 'Ana', 'ana@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(2, 'admin', 'admin@tienda.com', '$2y$10$Is4c.QQm0Qy4X5Wmwi8sNuKWmVIuD/J0MmyEiU1UkTn1NJOSRQUJO', NULL, 'admin', '2025-06-04 08:44:06'),
(4, 'Luis', 'luis@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(5, 'Eva', 'eva@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(6, 'Juan', 'juan@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(7, 'Laura', 'laura@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(8, 'Pedro', 'pedro@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(9, 'Sara', 'sara@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(10, 'Mario', 'mario@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(11, 'Irene', 'irene@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52'),
(12, 'Nico', 'nico@correo.com', '$2y$10$M9KZcrgdheggFxfY1LiaeOvAJEMs0tgfHod5qAyr/.8JTNseJUpfu', NULL, 'cliente', '2025-06-04 09:48:52');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
