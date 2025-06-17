CREATE DATABASE Inventario;

USE Inventario;
CREATE TABLE Persona(
    idPersona       INT AUTO_INCREMENT PRIMARY KEY,
    apellidos       VARCHAR(50),
    nombres         VARCHAR(50),  
    tipoDoc         VARCHAR(50),
    nroDocumento    VARCHAR(20),
    telefono        CHAR(9),
    email           VARCHAR(70),
    direccion       VARCHAR(100)
)Engine=InnoDB;

CREATE TABLE AREAS(
    idArea      INT AUTO_INCREMENT PRIMARY KEY,
    area        VARCHAR(80)
)Engine=InnoDB;

CREATE TABLE ROLES(
    idRol       INT AUTO_INCREMENT PRIMARY KEY,
    rol         VARCHAR(80)
)Engine=InnoDB;

CREATE TABLE COLABORADORES(
    idColaborador       INT AUTO_INCREMENT PRIMARY KEY,
    inicio              DATE,
    fin                 DATE NULL,
    idPersona           INT,
    idArea              INT,
    idRol               INT,
    CONSTRAINT idpersona_fk FOREIGN KEY (idPersona) REFERENCES Persona(idPersona),
    CONSTRAINT idarea_fk FOREIGN KEY (idArea) REFERENCES AREAS(idArea),
    CONSTRAINT idrol_fk FOREIGN KEY (idRol) REFERENCES ROLES(idRol)
)Engine=InnoDB;

CREATE TABLE USUARIOS(
    idUsuario       INT AUTO_INCREMENT PRIMARY KEY,
    nomUser         VARCHAR(50),
    passUser        VARCHAR(50),
    estado          VARCHAR(20),
    idColaborador   INT,
    CONSTRAINT idcolaborador_fk FOREIGN KEY (idColaborador) REFERENCES COLABORADORES(idColaborador)
)Engine=InnoDB;

CREATE TABLE CATEGORIAS(
    idCategoria        INT AUTO_INCREMENT PRIMARY KEY,
    categoria           VARCHAR(40)
)Engine=InnoDB;

CREATE TABLE SUBCATEGORIAS(
    idSubCategoria      INT AUTO_INCREMENT PRIMARY KEY,
    subCategoria        VARCHAR(50),
    idCategoria         INT,
    CONSTRAINT idcategoria_fk FOREIGN KEY (idCategoria) REFERENCES CATEGORIAS(idCategoria)
)Engine=InnoDB;
CREATE TABLE MARCAS(
    idMarca     INT AUTO_INCREMENT PRIMARY KEY,
    marca       VARCHAR(50),
    idSubCategoria  INT,
    CONSTRAINT idSubCategoria_fk FOREIGN KEY (idSubCategoria) REFERENCES SUBCATEGORIAS(idSubCategoria)
)Engine=InnoDB;

CREATE TABLE BIENES(
    idBien              INT AUTO_INCREMENT PRIMARY KEY,
    condicion           VARCHAR(20),
    modelo              VARCHAR(40),
    numSerie            VARCHAR(30),
    descripcion         TEXT,
    fotografia          LONGBLOB,
    idMarca             INT,
    idUsuario           INT,
    CONSTRAINT idMarca_fk FOREIGN KEY (idMarca) REFERENCES MARCAS(idMarca),
    CONSTRAINT idUsuario_fk FOREIGN KEY (idUsuario) REFERENCES USUARIOS(idUsuario)
)Engine=InnoDB;

CREATE TABLE ASIGNACIONES(
    idAsignacion        INT AUTO_INCREMENT PRIMARY KEY,
    inicio              DATE,
    fin                 DATE,
    idBien              INT,
    idColaborador       INT,
    CONSTRAINT idBien_fk FOREIGN KEY (idBien) REFERENCES BIENES(idBien),
    CONSTRAINT idColaborador_Asignaciones_fk FOREIGN KEY (idColaborador) REFERENCES COLABORADORES(idColaborador)
)Engine=InnoDB;

CREATE TABLE CARACTERISTICAS(
    idCaracteristica        INT AUTO_INCREMENT PRIMARY KEY,
    segmento                VARCHAR(100),
    idBien                  INT,
    CONSTRAINT idCaracteristica_fk FOREIGN KEY (idBien) REFERENCES BIENES(idBien)
)Engine=InnoDB;

CREATE TABLE CONFIGURACIONES(
    idConfiguracion         INT AUTO_INCREMENT PRIMARY KEY,
    configuracion           VARCHAR(150),
    idCategoria             INT,
    CONSTRAINT idCategoria_config_fk FOREIGN KEY (idCategoria) REFERENCES CATEGORIAS(idCategoria)
)Engine=InnoDB;

CREATE TABLE DETALLES(
    idDetalle           INT AUTO_INCREMENT PRIMARY KEY,
    caracteristica      VARCHAR(150),
    idCaracteristica    INT,
    idConfiguracion     INT,
    CONSTRAINT idCaracteristica FOREIGN KEY (idCaracteristica) REFERENCES CARACTERISTICAS(idCaracteristica),
    CONSTRAINT idConfiguracion FOREIGN KEY (idConfiguracion) REFERENCES CONFIGURACIONES(idConfiguracion)
)Engine=InnoDB;
