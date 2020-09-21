CREATE TABLE `rack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etiqueta` varchar(50) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
)

CREATE TABLE `servidor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `coste_anual` double DEFAULT NULL,
  `id_rack` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `servidor_rack_id_fk` (`id_rack`),
  CONSTRAINT `servidor_rack_id_fk` FOREIGN KEY (`id_rack`) REFERENCES `rack` (`id`)
)
