DROP DATABASE IF EXISTS dbUmpierrez;
CREATE DATABASE IF NOT EXISTS dbUmpierrez DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
USE dbUmpierrez;

-- CREACIÓN DE TABLAS SIN CLAVE FORÁNEA
--

-- TABLA tCodigoPostal
CREATE TABLE IF NOT EXISTS tCodigoPostal (
  cp CHAR(5) CHARACTER SET 'utf8' NOT NULL,
  localidad VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (cp))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tDiseno
CREATE TABLE IF NOT EXISTS tDiseno (
  idDiseno INT(11) NOT NULL AUTO_INCREMENT,
  tamanoDiseno DECIMAL(6,2) NOT NULL,
  formato ENUM('eps', 'dcs', 'jpg', 'tiff', 'psd', 'pdf') CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (idDiseno))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tFactura
CREATE TABLE IF NOT EXISTS tFactura (
  nFactura INT(11) NOT NULL AUTO_INCREMENT,
  pago ENUM('tienda', 'entrega') CHARACTER SET 'utf8' NOT NULL,
  importe DECIMAL(6,2) NOT NULL,
  envio ENUM('recogida', 'domicilio') CHARACTER SET 'utf8' NOT NULL,
  fecha DATE NOT NULL,
  PRIMARY KEY (nFactura))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tProducto
CREATE TABLE IF NOT EXISTS tProducto (
  idProducto INT(11) NOT NULL AUTO_INCREMENT,
  nombreProducto VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  imagenProducto VARCHAR(90) CHARACTER SET 'utf8' NOT NULL,
  precio DECIMAL(6,2) NOT NULL,
  descripcion TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  impresion ENUM('color1Cara', 'color2Caras', 'bn1Cara', 'bn2Caras', '1Tinta', '2Tintas') CHARACTER SET 'utf8' NOT NULL,
  acabado ENUM('conSolapa', 'sinSolapa', 'pegado', 'matriz') CHARACTER SET 'utf8' NOT NULL,
  tipoPapel ENUM('115GrBrillo', '300GrBrillo', 'cartulina', 'mate', '80GrComun') CHARACTER SET 'utf8' NOT NULL,
  tamanoProducto ENUM('a3', 'a4', 'a5', 'a6', '85x85') CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (idProducto))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tDepartamento
CREATE TABLE IF NOT EXISTS tDepartamento (
  nombreDep VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  emailDep VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (nombreDep))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- CREACIÓN DE TABLAS CON CLAVE FORÁNEA
--

-- TABLA tCliente
CREATE TABLE IF NOT EXISTS tCliente (
  dniCif CHAR(9) CHARACTER SET 'utf8' NOT NULL,
  nombreCl VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  apellidosCl VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  direccionCl VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  emailCl VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  passCl VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  imagenCl VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  cpCl CHAR(5) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (dniCif),
  INDEX fk_tCliente_1_idx (cpCl ASC),
  CONSTRAINT cpCli_Fk
    FOREIGN KEY (cpCl)
    REFERENCES tCodigoPostal (cp)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tCliente_Tf
CREATE TABLE IF NOT EXISTS tCliente_Tf (
  telefonoCl CHAR(9) CHARACTER SET 'utf8' NOT NULL,
  dniCif_Tf CHAR(9) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (telefonoCl, dniCif_Tf),
  INDEX dniCif_Tf_Fk_idx (dniCif_Tf ASC),
  CONSTRAINT dniCif_Tf_Fk
    FOREIGN KEY (dniCif_Tf)
    REFERENCES tCliente (dniCif)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tEmpleado
CREATE TABLE IF NOT EXISTS tEmpleado (
  dniEmp CHAR(9) CHARACTER SET 'utf8' NOT NULL,
  seguridadSocial CHAR(12) CHARACTER SET 'utf8' NOT NULL,
  nombreEmp VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  apellidosEmp VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  emailEmp VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  passEmp VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  direccionEmp VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  salario DECIMAL(6,2) NOT NULL,
  comision INT(2) NULL DEFAULT NULL,
  nombreDepEmp VARCHAR(45) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`dniEmp`),
  INDEX fk_tEmpleado_1_idx (nombreDepEmp ASC),
  CONSTRAINT nombreDepEmp_Fk
    FOREIGN KEY (nombreDepEmp)
    REFERENCES tDepartamento (nombreDep)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tEmpleado_Tf
CREATE TABLE IF NOT EXISTS tEmpleado_Tf (
  telefonoEmp CHAR(9) CHARACTER SET 'utf8' NOT NULL,
  dniEmp_Tf CHAR(9) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (telefonoEmp, dniEmp_Tf),
  INDEX fk_tEmpleado_Tf_1_idx (dniEmp_Tf ASC),
  CONSTRAINT fk_tEmpleado_Tf_1
    FOREIGN KEY (dniEmp_Tf)
    REFERENCES tEmpleado (dniEmp)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tRealiza
CREATE TABLE IF NOT EXISTS tRealiza (
  dniEmpRealiza CHAR(9) CHARACTER SET 'utf8' NOT NULL,
  idProductoRealiza INT(11) NOT NULL,
  PRIMARY KEY (dniEmpRealiza, idProductoRealiza),
  INDEX fk_tRealiza_1_idx (idProductoRealiza ASC),
  CONSTRAINT dniEmpRealiza_Fk
    FOREIGN KEY (dniEmpRealiza)
    REFERENCES tEmpleado (dniEmp)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT idProductoRealiza_Fk
    FOREIGN KEY (idProductoRealiza)
    REFERENCES tProducto (idProducto)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tTiene
CREATE TABLE IF NOT EXISTS tTiene (
  idDisenoTiene INT(11) NOT NULL,
  idProductoTiene INT(11) NOT NULL,
  PRIMARY KEY (idDisenoTiene),
  INDEX fk_tTiene_1_idx (idProductoTiene ASC),
  CONSTRAINT idDisenoTiene_Fk
    FOREIGN KEY (idDisenoTiene)
    REFERENCES tDiseno (idDiseno)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT idProductoTiene_Fk
    FOREIGN KEY (idProductoTiene)
    REFERENCES tProducto (idProducto)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

-- TABLA tSolicita
CREATE TABLE IF NOT EXISTS tSolicita (
  nFacturaSol INT(11) NOT NULL,
  idProductoSol INT(11) NOT NULL,
  dniCifSol CHAR(9) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (nFacturaSol, idProductoSol),
  INDEX fk_tSolicita_1_idx (idProductoSol ASC),
  INDEX dniCifSol_Fk_idx (dniCifSol ASC),
  CONSTRAINT dniCifSol_Fk
    FOREIGN KEY (dniCifSol)
    REFERENCES tCliente (dniCif)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT idProductoSol_Fk
    FOREIGN KEY (idProductoSol)
    REFERENCES tProducto (idProducto)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT nFacturaSol_Fk
    FOREIGN KEY (nFacturaSol)
    REFERENCES tFactura (nFactura)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;
