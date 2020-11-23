USE wuac69fxggq49kmt;

/* *************************************************** *
 * *********** INSERTS DE TABLA DE NIVELES *********** *
 * *************************************************** */
INSERT INTO nivel (nombre)
VALUES  ('Licenciatura'),
        ('Maestría'),
        ('Doctorado'),
        ('Externo');

/* *************************************************** *
 * ************ INSERTS DE TABLA DE ROLES ************ *
 * *************************************************** */
INSERT INTO rol (nombre, abreviatura)
VALUES  ('Administrador', 'ADMIN'),
        ('Estudiante', 'ESTU');


/* *************************************************** *
 * ** INSERTS DE TABLA DE CONFIGURACÍON DEL SISTEMA ** *
 * *************************************************** */
INSERT INTO conf_sistema (nombre, abreviatura, estado)
VALUES ('MÓDULO DE REINSCRIPCION', 'MOD_REINS', 1);
