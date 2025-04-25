CREATE DATABASE Inventario;

use Inventario;
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
    fotografia          BLOB,
    idMarca             INT,
    idUsuario           INT,
    CONSTRAINT idMarca_fk FOREIGN KEY (idMarca) REFERENCES MARCAS(idMarca),
    CONSTRAINT idUsuario_fk FOREIGN KEY (idUsuario) REFERENCES USUARIOS(idUsuario)
)Engine=InnoDB;

INSERT INTO BIENES (condicion, modelo, numSerie, descripcion, fotografia, idMarca, idUsuario)
VALUES 
('Nuevo', 'Pavilion 15', 'SN123456', 'Laptop HP con procesador i5, 8GB RAM', 'http://example.com/images/laptop1.jpg', 1, 1),

('Usado', 'Inspiron 14', 'SN654321', 'Laptop Dell para oficina, disco SSD', 'http://example.com/images/laptop1.jpg', 1, 1);

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

--LISTADO PARA SUB CATEGORIAS --
CREATE VIEW vista_categorias_subcategorias
AS
	SELECT
		SC.idSubCategoria,
        SC.subCategoria,
        CT.categoria
    FROM SUBCATEGORIAS SC
    INNER JOIN CATEGORIAS CT ON CT.idCategoria = SC.idCategoria
    ORDER BY SC.idSubCategoria;

--LISTADO PARA MARCAS--

CREATE VIEW vista_marcas_categorias_subcategorias
AS
	SELECT
		MC.idMarca,
        MC.marca,
        SC.subCategoria,
        CT.categoria
    FROM MARCAS MC
    INNER JOIN SUBCATEGORIAS SC ON SC.idSubCategoria=MC.idSubCategoria
    INNER JOIN CATEGORIAS CT ON CT.idCategoria = SC.idCategoria
    ORDER BY SC.idSubCategoria;

--LISTADO DE SUBCATEGORIAS EN MARCAS--

    CREATE VIEW vista_subcategorias_con_categorias AS
    SELECT 
        SC.idSubCategoria,
        SC.subCategoria,
        SC.idCategoria,
        CT.categoria
    FROM 
        SUBCATEGORIAS SC
    JOIN 
        CATEGORIAS CT ON SC.idCategoria = CT.idCategoria;


--LISTADO DE COLABORADORES--
CREATE VIEW vista_colaboradores AS
    SELECT 
        CL.idColaborador,
        PS.apellidos,
        PS.nombres,
        AR.area,
        RL.rol,
        CL.inicio,
        CL.fin
    FROM 
        COLABORADORES CL
    INNER JOIN PERSONA PS ON PS.idPersona = CL.idPersona
    INNER JOIN AREAS AR ON AR.idArea=CL.idArea
    INNER JOIN ROLES RL ON RL.idRol=CL.idRol
    ORDER BY idColaborador;

--LISTADO PARA USUARIOS --
    
CREATE VIEW vista_usuarios AS
SELECT 
    UR.idUsuario,
    UR.nomUser,
    UR.estado,
    PS.apellidos,
    PS.nombres
FROM USUARIOS UR
JOIN COLABORADORES CL ON CL.idColaborador = UR.idColaborador
JOIN PERSONA PS ON PS.idPersona = CL.idPersona
ORDER BY UR.idUsuario;

--LISTADO DE COLABORADORES DENTRO DE USUARIOS--
CREATE VIEW vista_usuarios_colaboradores AS
SELECT
        CL.idColaborador,
        PS.nombres,
        PS.apellidos
    FROM COLABORADORES CL 
    INNER JOIN PERSONA PS ON PS.idPersona = CL.idPersona
    ORDER BY CL.idColaborador;

--LISTADO DE BIENES--
CREATE VIEW vista_bienes_registrados AS 
    SELECT
        BN.idBien,
        MC.marca,
        BN.modelo,
        BN.numSerie,
        BN.descripcion,
        BN.condicion,
        BN.fotografia,
        US.nomUser
    FROM BIENES BN
    INNER JOIN MARCAS MC ON BN.idMarca = MC.idMarca
    INNER JOIN USUARIOS US ON BN.idUsuario = US.idUsuario;

--PROCEDIMIENTO PARA REGISTRAR NUEVA SUBCATEGORIA--
DELIMITER //
CREATE PROCEDURE spu_SubCategorias_registrar(
    IN _subcategoria		VARCHAR(50),
    IN _idCategoria	        INT
)
BEGIN
	INSERT INTO SUBCATEGORIAS ( subCategoria, idCategoria) 
		VALUES
        ( _subCategoria, _idCategoria);
END //

--PROCEDIMIENTO PARA REGISTRAR NUEVA MARCA--

DELIMITER //
CREATE PROCEDURE spu_marcas_registrar(
    IN _marcas		VARCHAR(50),
    IN _idSubCategoria	        INT
)
BEGIN
	INSERT INTO MARCAS ( marcas, idSubCategoria) 
		VALUES
        ( _marca, _idSubCategoria);
END //

--PROCEDIMIENTO PARA REGISTRAR UN NUEVO COLABORADOR--

DELIMITER //
CREATE PROCEDURE spu_colaborador_registrar(
    IN _inicio	        DATE,
    IN _fin	            DATE,
    IN _idPersona       INT,
    IN _idArea          INT,
    IN _idRol           INT
)
BEGIN
	INSERT INTO COLABORADORES ( inicio,fin,idPersona,idArea,idRol) 
		VALUES
        ( _inicio, _fin,_idPersona,_idArea,_idRol);
END //

--PROCEDIMIENTO PARA REGISTRAR UN NUEVO USUARIO--

DELIMITER //
CREATE PROCEDURE spu_usuario_registrar(
    IN _nomUser	        VARCHAR(50),
    IN _passUser	    VARCHAR(50),
    IN _estado          VARCHAR(20),
    IN _idColaborador   INT

)
BEGIN
	INSERT INTO USUARIOS ( nomUser,passUser,estado,idColaborador) 
		VALUES
        ( _nomUser, _passUser,_estado,_idColaborador);
END //

--PROCEDIMIENTOS PARA REGISTRAR BIENES--
DELIMITER //
CREATE PROCEDURE spu_bienes_registrar(
    IN _condicion        VARCHAR(20),
    IN _modelo	         VARCHAR(40),
    IN _numSerie         VARCHAR(30),
    IN _descripcion      TEXT,
    IN _fotografia       BLOB,
    IN _idMarca         INT,
    IN _idUsuario        INT
)
BEGIN
	INSERT INTO BIENES (condicion, modelo,numSerie,descripcion,fotografia,idMarca,idUsuario) 
		VALUES
        ( _condicion, _modelo,_numSerie,_descripcion,_fotografia,_idMarca,_idUsuario);
END //

SELECT*FROM vista_bienes_registrados;

CALL spu_colaborador_registrar("2025-02-10","2025-06-15", 9,17,4);

INSERT INTO AREAS(area)VALUES("Secretaria");
INSERT INTO AREAS(area)VALUES("contabilidad");
INSERT INTO ROLES(rol) VALUES("Contador");
INSERT INTO CATEGORIAS(categoria)VALUES("computo");
INSERT INTO CATEGORIAS(categoria)VALUES("muebles");

INSERT INTO MARCAS(marca,idsubcategoria)VALUES("hp",1);
INSERT INTO PERSONA(apellidos,nombres,tipoDoc,nroDocumento,telefono,email,direccion)VALUES
("Anton Felix","Gian Franco","DNI","75626327","924207711","antonfelixFranco@gmail.com","av jerusalen 130-1");
INSERT INTO SUBCATEGORIAS(subcategoria,idCategoria)VALUES("laptop",1);
INSERT INTO MARCAS(marca,idSubCategoria)VALUES("lenovo",1);
INSERT INTO COLABORADORES(inicio,fin,idPersona,idArea,idRol)VALUES("2023-10-05","2026-05-10",1,1,1);

DELETE FROM bienes
WHERE idbien = 16;


