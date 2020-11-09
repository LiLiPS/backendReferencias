USE wuac69fxggq49kmt;

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE NIVELES *********** *
 * *************************************************** */
DROP TABLE IF EXISTS nivel;
CREATE TABLE nivel
(
    nivel_id    INT             NOT NULL AUTO_INCREMENT,

    nombre      VARCHAR(255)    NOT NULL,                           -- 1 -> LICENCIATURA, 2 -> MAESTRIA, 3 -> DOCTORADO, 4 -> EXTERNO

    CONSTRAINT pk_nivel PRIMARY KEY (nivel_id ASC)
);
/* FIN TABLA NIVELES */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE USUARIOS ********** *
 * *************************************************** */
DROP TABLE IF EXISTS usuario;
CREATE TABLE usuario
(
    usuario_id          INT             NOT NULL AUTO_INCREMENT,
    nivel_id            INT             NULL,

    nombre              VARCHAR(255)    NOT NULL,
    primer_apellido     VARCHAR(255)    NOT NULL,
    segundo_apellido    VARCHAR(255)    DEFAULT NULL,
    curp                VARCHAR(18)     DEFAULT NULL,
    sexo                BIT             NOT NULL,                       -- 0 -> FEMENINO, 1 -> MASCULINO
    telefono            VARCHAR(10)     NOT NULL,
    correo_electronico  VARCHAR(255)    NOT NULL,
    password            VARCHAR(255)    NOT NULL,
    numero_control      VARCHAR(9)      NULL,
    semestre            TINYINT         NULL,
    estado              BIT             NOT NULL DEFAULT 1,             -- 1 -> ACTIVO, 0 -> INACTIVO

    CONSTRAINT pk_usuario PRIMARY KEY (usuario_id ASC)
);

ALTER TABLE usuario
    ADD CONSTRAINT fk_nivel_id_usuario FOREIGN KEY (nivel_id) REFERENCES nivel (nivel_id);
/* FIN TABLA USUARIOS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE CONCEPTOS ********* *
 * *************************************************** */
DROP TABLE IF EXISTS concepto;
CREATE TABLE concepto
(
    concepto_id         INT             NOT NULL AUTO_INCREMENT,

    nombre              VARCHAR(255)    NOT NULL,
    descripcion         TEXT            NOT NULL,
    monto               DECIMAL(18,2)   NOT NULL,
    estado              BIT             NOT NULL DEFAULT 1,             -- 1 -> ACTIVO, 0 -> INACTIVO
    
    CONSTRAINT pk_concepto PRIMARY KEY (concepto_id ASC)
);
/* FIN TABLA CONCEPTOS */

/* ****************************************************************************** *
 * ********** CREACIÓN DE TABLA DE RELACIONES ENTRE CONCEPTOS Y NIVELES ********* *
 * ****************************************************************************** */
DROP TABLE IF EXISTS concepto_nivel;
CREATE TABLE concepto_nivel
(
    concepto_nivel_id   INT     NOT NULL AUTO_INCREMENT,
    concepto_id         INT     NOT NULL,
    nivel_id            INT     NOT NULL,    

    vigencia_inicial    DATE    NOT NULL,
    vigencia_final      DATE    NOT NULL,
    semestre            TINYINT NULL,
    estado              BIT     NOT NULL DEFAULT 1,                     -- 1 -> ACTIVO, 0 -> INACTIVO

    CONSTRAINT pk_concepto_nivel PRIMARY KEY (concepto_nivel_id ASC)
);

ALTER TABLE concepto_nivel
    ADD CONSTRAINT fk_concepto_id_concepto_nivel FOREIGN KEY (concepto_id) REFERENCES concepto (concepto_id);

ALTER TABLE concepto_nivel
    ADD CONSTRAINT fk_nivel_id_concepto_nivel FOREIGN KEY (nivel_id) REFERENCES nivel (nivel_id);
/* FIN TABLA RELACIONES ENTRE CONCEPTOS Y NIVELES */


/* ***************************************************** *
 * ********** CREACIÓN DE TABLA DE REFERENCIAS ********* *
 * ***************************************************** */
DROP TABLE IF EXISTS referencia;
CREATE TABLE referencia
(
    referencia_id       INT             NOT NULL AUTO_INCREMENT,
    usuario_id          INT             NOT NULL,
    concepto_id         INT             NOT NULL,    

    fecha_generada      DATETIME        NOT NULL,
    fecha_expiracion    DATETIME        NOT NULL,
    monto               DECIMAL(18,2)   NOT NULL,
    monto_pagado        DECIMAL(18,2)   DEFAULT NULL,
    numero_ref_banco    VARCHAR(255)    NOT NULL,
    fecha_pago          DATE            DEFAULT NULL,
    tipo_pago           VARCHAR(3)      DEFAULT NULL,                   -- EFECTIVO (EFE), TARJETA DE CREDITO/DEBITO (TAR)
    cantidad_solicitada SMALLINT        NOT NULL,
    estado              BIT             NOT NULL DEFAULT 0,             -- GENERADA Y NO PAGADA (0) o GENERADA Y PAGADA (1)
    
    CONSTRAINT pk_referencia PRIMARY KEY (referencia_id ASC)
);

ALTER TABLE referencia
    ADD CONSTRAINT fk_usuario_id_referencia FOREIGN KEY (usuario_id) REFERENCES usuario (usuario_id);

ALTER TABLE referencia
    ADD CONSTRAINT fk_concepto_id_referencia FOREIGN KEY (concepto_id) REFERENCES concepto (concepto_id);
/* FIN TABLA REFERENCIAS */

/* ************************************************ *
 * ********** CREACIÓN DE TABLA DE ROLES ********** *
 * ************************************************ */
DROP TABLE IF EXISTS rol;
CREATE TABLE rol
(
    rol_id      INT             NOT NULL AUTO_INCREMENT,

    nombre      VARCHAR(255)    NOT NULL,                               -- ADMINISTRADOR, ESTUDIANTE
    abreviatura VARCHAR(10)     DEFAULT NULL,
    estado      BIT             NOT NULL DEFAULT 1,                     -- 1 -> ACTIVO, 0 -> INACTIVO
    
    CONSTRAINT pk_rol PRIMARY KEY (rol_id ASC)
);
/* FIN TABLA ROLES */


/* ************************************************************************* *
 * ********** CREACIÓN DE TABLA DE RELACIONES ENTRE ROL Y USUARIO ********** *
 * ************************************************************************* */
DROP TABLE IF EXISTS rol_usuario;
CREATE TABLE rol_usuario
(
    rol_usuario_id  INT     NOT NULL AUTO_INCREMENT,
    rol_id          INT     NOT NULL,
    usuario_id      INT     NOT NULL,
    
    CONSTRAINT pk_rol_usuario PRIMARY KEY (rol_usuario_id ASC)
);

ALTER TABLE rol_usuario
    ADD CONSTRAINT fk_rol_rol_usuario FOREIGN KEY (rol_id) REFERENCES rol (rol_id);

ALTER TABLE rol_usuario
    ADD CONSTRAINT fk_usuario_rol_usuario FOREIGN KEY (usuario_id) REFERENCES usuario (usuario_id);
/* FIN TABLA RELACIONES ENTRE ROL Y USUARIO */