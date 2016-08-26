drop database if exists dbUmpierrez2;
create database dbUmpierrez2;
use dbUmpierrez2;
ALTER SCHEMA `dbUmpierrez2`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_spanish_ci ;

CREATE TABLE IF NOT EXISTS `tCodigoPostal` (
  `cp` CHAR(5) NOT NULL,
  `localidad` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cp`));


CREATE TABLE IF NOT EXISTS `tCliente` (
  `dniCif` CHAR(9) NOT NULL,
  `nombreCl` VARCHAR(45) NOT NULL,
  `apellidosCl` VARCHAR(45) NOT NULL,
  `direccionCl` VARCHAR(45) NOT NULL,
  `emailCl` VARCHAR(45) NOT NULL,
  `passCl` VARCHAR(45) NOT NULL,
  `imagenCl` VARCHAR(45),
  `cpCli` CHAR(5) NOT NULL,
  PRIMARY KEY (`dniCif`),
  INDEX `fk_Cliente_CodigoPostal1_idx` (`cpCli` ASC),
  CONSTRAINT `cpCliFk`
    FOREIGN KEY (`cpCli`)
    REFERENCES `tCodigoPostal` (`cp`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT);

CREATE TABLE IF NOT EXISTS `tCliente_Tf` (
  `telefonosCl` CHAR(9) NOT NULL,
  `dniCifTf` CHAR(9) NOT NULL,
  PRIMARY KEY (`telefonosCl`, `dniCifTf`),
  INDEX `fk_Cliente_TF_Cliente1_idx` (`dniCifTf` ASC),
  CONSTRAINT `dniCifTfFk`
    FOREIGN KEY (`dniCifTf`)
    REFERENCES `tCliente` (`dniCif`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS `tDepartamento` (
  `nombreDepartamento` VARCHAR(45) NOT NULL,
  `emailDep` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`nombreDepartamento`));


CREATE TABLE IF NOT EXISTS `tEmpleado` (
  `dniEmp` CHAR(9) NOT NULL,
  `seguridadSocial` CHAR(12) NOT NULL,
  `nombreEmp` VARCHAR(45) NOT NULL,
  `apellidosEmp` VARCHAR(45) NOT NULL,
  `emailEmp` VARCHAR(45) NOT NULL,
  `passEmp` VARCHAR(45) NOT NULL,
  `direccionEmp` VARCHAR(45) NOT NULL,
  `salario` DECIMAL(7,2) NOT NULL,
  `comision` SMALLINT(6) NOT NULL,
  `nombreDepartamentoEmp` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`dniEmp`),
  INDEX `fk_Empleado_Departamento1_idx` (`nombreDepartamentoEmp` ASC),
  CONSTRAINT `nombreDepartamentoEmpFk`
    FOREIGN KEY (`nombreDepartamentoEmp`)
    REFERENCES `tDepartamento` (`nombreDepartamento`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT);

CREATE TABLE IF NOT EXISTS `tEmpleado_Tf` (
  `telefonosEmp` CHAR(9) NOT NULL,
  `dniEmpTf` CHAR(9) NOT NULL,
  PRIMARY KEY (`telefonosEmp`, `dniEmpTf`),
  INDEX `fk_Empleado_TF_Empleado1_idx` (`dniEmpTf` ASC),
  CONSTRAINT `dniEmpTfFk`
    FOREIGN KEY (`dniEmpTf`)
    REFERENCES `tEmpleado` (`dniEmp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE IF NOT EXISTS `tDiseno` (
  `idDiseno` INT(11) NOT NULL AUTO_INCREMENT,
  `formato` ENUM('EPS','DCS','JPG','Tiff','PSD','PDF') NOT NULL,
  `tamanoDiseno` DECIMAL(6,2) NOT NULL,
  `dniCifDis` CHAR(9) NOT NULL,
  PRIMARY KEY (`idDiseno`),
  INDEX `fk_Diseno_Cliente1_idx` (`dniCifDis` ASC),
  CONSTRAINT `dniCifDisFk`
    FOREIGN KEY (`dniCifDis`)
    REFERENCES `tCliente` (`dniCif`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS `tFactura` (
  `nFactura` INT(11) NOT NULL AUTO_INCREMENT,
  `pago` ENUM('tienda','entrega') NOT NULL,
  `importe` DECIMAL(10,2) NOT NULL,
  `envio` ENUM('domicilio','recogida') NOT NULL,
  PRIMARY KEY (`nFactura`));

CREATE TABLE IF NOT EXISTS `tProducto` (
  `idProducto` INT(11) NOT NULL AUTO_INCREMENT,
  `nombreProducto` VARCHAR(45) NOT NULL,
  `imagen` VARCHAR(45) NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`idProducto`));



CREATE TABLE IF NOT EXISTS `tSolicita` (
  `dniCifSol` CHAR(9) NOT NULL,
  `idProductoSol` INT(11) NOT NULL,
  `nFacturaSol` INT(11) NOT NULL AUTO_INCREMENT,
  `numeroPedido` INT(11) NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `subTotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`nFacturaSol`, `idProductoSol`),
  INDEX `fk_Solicita_Producto1_idx` (`idProductoSol` ASC),
  INDEX `fk_Solicita_Factura1_idx` (`nFacturaSol` ASC),
  CONSTRAINT `dniCifSolFk`
    FOREIGN KEY (`dniCifSol`)
    REFERENCES `tCliente` (`dniCif`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `idProductoSolFk`
    FOREIGN KEY (`idProductoSol`)
    REFERENCES `tProducto` (`idProducto`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `nFacturaSolFk`
    FOREIGN KEY (`nFacturaSol`)
    REFERENCES `tFactura` (`nFactura`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT);

CREATE TABLE IF NOT EXISTS `tRealiza` (
  `idProductoRe` INT(11) NOT NULL AUTO_INCREMENT,
  `dniEmpRe` CHAR(9) NOT NULL,
  PRIMARY KEY (`idProductoRe`, `dniEmpRe`),
  INDEX `fk_Realiza_Empleado1_idx` (`dniEmpRe` ASC),
  CONSTRAINT `idProductoReFk`
    FOREIGN KEY (`idProductoRe`)
    REFERENCES `tProducto` (`idProducto`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `dniEmpReFk`
    FOREIGN KEY (`dniEmpRe`)
    REFERENCES `tEmpleado` (`dniEmp`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);