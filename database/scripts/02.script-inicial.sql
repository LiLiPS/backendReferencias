USE wuac69fxggq49kmt;

/* *************************************************** *
 * *********** INSERTS DE TABLA DE NIVELES *********** *
 * *************************************************** */
INSERT INTO nivel (nombre)
VALUES ('Licenciatura'),
       ('Maestría'),
       ('Doctorado');

/* *************************************************** *
 * ************ INSERTS DE TABLA DE ROLES ************ *
 * *************************************************** */
INSERT INTO rol (nombre, abreviatura)
VALUES ('Administrador', 'ADMIN'),
       ('Estudiante', 'EST');


/* ****************************************************** *
 * ************ INSERTS DE TABLA DE CONCEPTOS *********** *
 * ****************************************************** */
INSERT INTO concepto (nombre, descripcion, monto)
VALUES ('Matriculación 2o Enero Junio 2021', 'Matriculación 2o Enero Junio 2021', 3900),
       ('Matriculación 3o y 4o semestre Enero Junio 2021', 'Matriculación 3o y 4o semestre Enero Junio 2021', 3000),
       ('Matriculación 5o y 6o semestre Enero Junio 2021', 'Matriculación 5o y 6o semestre Enero Junio 2021', 2800),
       ('Matriculación 7o semestre en adelante Enero Junio 2021',
        'Matriculación 7o semestre en adelante Enero Junio 2021', 2500),
       ('Matriculación en maestría primer semestre', 'Matriculación en maestría primer semestre', 6700),
       ('Matriculación en maestría segundo semestre', 'Matriculación en maestría segundo semestre', 6700),
       ('Matriculación en maestría tercer semestre', 'Matriculación en maestría tercero semestre', 5200),
       ('Matriculación en maestría cuarto semestre', 'Matriculación en maestría cuarto semestre', 2200),
       ('Matriculación en doctorado primer semestre', 'Matriculación en doctorado primer semestre', 8700),
       ('Matriculación en doctorado segundo semestre', 'Matriculación en doctorado segundo semestre', 8700),
       ('Matriculación en doctorado tercer semestre', 'Matriculación en doctorado tercer semestre', 5100),
       ('Matriculación en doctorado cuarto semestre', 'Matriculación en doctorado cuarto semestre', 8700),
       ('Matriculación en doctorado quinto semestre', 'Matriculación en doctorado quinto semestre', 8700),
       ('Matriculación en doctorado sexto semestre', 'Matriculación en doctorado sexto semestre', 8700),
       ('Matriculación en doctorado séptimo semestre', 'Matriculación en doctorado séptimo semestre', 8700),
       ('Matriculación en doctorado octavo semestre', 'Matriculación en doctorado octavo semestre', 9300);

/* ****************************************************************************** *
 * ********** INSERTS DE TABLA DE RELACIONES ENTRE CONCEPTOS Y NIVELES ********* *
 * ****************************************************************************** */
INSERT INTO concepto_nivel (concepto_id, nivel_id, vigencia_inicial, vigencia_final, semestre)
VALUES ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 2o Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 2),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 3o y 4o semestre Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 3),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 3o y 4o semestre Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 4),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 5o y 6o semestre Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 5),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 5o y 6o semestre Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 6),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 7o semestre en adelante Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 7),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 7o semestre en adelante Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 8),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 7o semestre en adelante Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 9),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 7o semestre en adelante Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 10),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 7o semestre en adelante Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 11),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación 7o semestre en adelante Enero Junio 2021'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Licenciatura'),
        '2020-11-01', '2021-11-01', 12),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en maestría primer semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Maestría'),
        '2020-11-01', '2021-11-01', 1),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en maestría segundo semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Maestría'),
        '2020-11-01', '2021-11-01', 2),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en maestría tercer semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Maestría'),
        '2020-11-01', '2021-11-01', 3),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en maestría cuarto semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Maestría'),
        '2020-11-01', '2021-11-01', 4),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en doctorado primer semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Doctorado'),
        '2020-11-01', '2021-11-01', 1),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en doctorado segundo semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Doctorado'),
        '2020-11-01', '2021-11-01', 2),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en doctorado tercer semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Doctorado'),
        '2020-11-01', '2021-11-01', 3),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en doctorado cuarto semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Doctorado'),
        '2020-11-01', '2021-11-01', 4),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en doctorado quinto semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Doctorado'),
        '2020-11-01', '2021-11-01', 5),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en doctorado sexto semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Doctorado'),
        '2020-11-01', '2021-11-01', 6),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en doctorado séptimo semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Doctorado'),
        '2020-11-01', '2021-11-01', 7),
       ((SELECT concepto_id FROM concepto WHERE nombre = 'Matriculación en doctorado octavo semestre'),
        (SELECT nivel_id FROM nivel WHERE nombre = 'Doctorado'),
        '2020-11-01', '2021-11-01', 8);


/* *************************************************** *
 * ** INSERTS DE TABLA DE CONFIGURACÍON DEL SISTEMA ** *
 * *************************************************** */
INSERT INTO conf_sistema (nombre, abreviatura, estado)
VALUES ('MÓDULO DE REINSCRIPCION', 'MOD_REINS', 1);
