alter table usuario
    drop column sexo;
    
/* CREAR TABLA PARA LA CONFIGURACIÓN DE LOS SISTEMAS O MÓDULOS */
DROP TABLE IF EXISTS conf_sistema;
CREATE TABLE conf_sistema
(
    conf_sistema_id         INT             NOT NULL AUTO_INCREMENT,
    nombre                  VARCHAR(100)   NOT NULL,
    abreviatura             VARCHAR(10)    NOT NULL,
    fecha_inicial           DATE            NULL,
    fecha_final             DATE            NULL,
    estado                  BIT             NOT NULL,
    CONSTRAINT pk_conf_sistema PRIMARY KEY (conf_sistema_id ASC)
);
