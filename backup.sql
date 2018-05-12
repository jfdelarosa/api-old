DROP TABLE IF EXISTS cajas;

CREATE TABLE `cajas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tienda_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cajas_tienda` (`tienda_id`),
  CONSTRAINT `cajas_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS categorias;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tienda_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categorias_tienda` (`tienda_id`),
  CONSTRAINT `categorias_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS permisos;

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `desc` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tienda_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permisos_tienda` (`tienda_id`),
  CONSTRAINT `permisos_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS productos;

CREATE TABLE `productos` (
  `categoria_id` int(11) NOT NULL,
  `unidad_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `sku` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `costo` decimal(4,2) NOT NULL,
  `precio` decimal(4,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `desc` text COLLATE utf8_spanish_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tienda_id` int(11) NOT NULL,
  `venta_productos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `productos_categorias` (`categoria_id`),
  KEY `productos_tienda` (`tienda_id`),
  KEY `productos_unidades` (`unidad_id`),
  KEY `productos_venta_productos` (`venta_productos_id`),
  CONSTRAINT `productos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  CONSTRAINT `productos_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id`),
  CONSTRAINT `productos_unidades` FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`),
  CONSTRAINT `productos_venta_productos` FOREIGN KEY (`venta_productos_id`) REFERENCES `venta_productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `permisos_id` int(11) NOT NULL,
  `tienda_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_permisos` (`permisos_id`),
  KEY `roles_tienda` (`tienda_id`),
  CONSTRAINT `roles_permisos` FOREIGN KEY (`permisos_id`) REFERENCES `permisos` (`id`),
  CONSTRAINT `roles_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS tienda;

CREATE TABLE `tienda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `licencia` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS unidades;

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `categoria` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tienda_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `unidades_tienda` (`tienda_id`),
  CONSTRAINT `unidades_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `rol_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tienda_id` int(11) NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_usuarios` (`rol_id`),
  KEY `usuarios_tienda` (`tienda_id`),
  CONSTRAINT `roles_usuarios` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `usuarios_tienda` FOREIGN KEY (`tienda_id`) REFERENCES `tienda` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS venta_productos;

CREATE TABLE `venta_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unitario` decimal(4,2) NOT NULL,
  `ponderado` decimal(4,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `venta_productos_ventas` (`venta_id`),
  CONSTRAINT `venta_productos_ventas` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS ventas;

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `cajas_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ventas_cajas` (`cajas_id`),
  CONSTRAINT `ventas_cajas` FOREIGN KEY (`cajas_id`) REFERENCES `cajas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




