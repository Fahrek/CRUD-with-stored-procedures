CREATE DATABASE juegos;
USE juegos;


CREATE TABLE t_juegos (
    id_juego int auto_increment primary key,
    nombre   varchar(150),
    anio     varchar(150),
    empresa  varchar(150)
);

ALTER TABLE t_juegos CONVERT TO CHARACTER SET utf8;


DROP procedure IF EXISTS `sp_mostrar_datos`;

DELIMITER $$
USE `juegos`$$
CREATE PROCEDURE `sp_mostrar_datos` ()
BEGIN
    SELECT id_juego, nombre, anio, empresa FROM t_juegos;
END$$

DELIMITER ;


DROP procedure IF EXISTS `sp_insertar_datos`;

DELIMITER $$
USE `juegos`$$
CREATE PROCEDURE `sp_insertar_datos`
(
    in nombreI  varchar(50),
    in anioI 	varchar(50),
    in empresaI varchar(50)
)
BEGIN
    INSERT INTO t_juegos (nombre, anio, empresa)
    VALUES (nombreI, anioI, empresaI);
END$$

DELIMITER ;


DROP procedure IF EXISTS `sp_actualizar_datos`;

DELIMITER $$
USE `juegos`$$
CREATE PROCEDURE `sp_actualizar_datos`
(
    in nombreU  varchar(50),
    in anioU 	varchar(50),
    in empresaU varchar(50),
    in idJuegoU int
)
BEGIN
    UPDATE t_juegos
    SET nombre  = nombreU,
        anio    = anioU,
        empresa = empresaU
    WHERE id_Juego = idJuegoU;
END$$

DELIMITER ;


DROP procedure IF EXISTS `sp_eliminar_datos`;

DELIMITER $$
USE `juegos`$$
CREATE PROCEDURE `sp_eliminar_datos` (in idJuegoD int)
BEGIN
    DELETE FROM t_juegos WHERE id_juego = idJuegoD;
END$$

DELIMITER ;


DROP procedure IF EXISTS `sp_obtener_regJuego`;

DELIMITER $$
USE `juegos`$$
CREATE PROCEDURE `sp_obtener_regJuego` (in idJuegoO int)
BEGIN
    SELECT * FROM t_juegos WHERE id_juego = idJuegoO;
END$$

DELIMITER ;