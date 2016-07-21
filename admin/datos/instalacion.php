<?php 

include "conexion.php";

function crearBd() {
	$cnn = new conexion();
	$con = $cnn->conectar();

	$sql = "CREATE DATABASE formLogin";
	if (mysqli_query($con,$sql)) {
		echo "consulta correcta";
	} else
		echo "consulta no realizada";
	mysqli_close($con);
}

function crearTablas() {
	$cnn = new conexion();
	$con = $cnn->conectar();
	mysqli_select_db($con, "formLogin");
	$sql = "CREATE TABLE usuarios(
		id INT(11) NOT NULL AUTO_INCREMENT,
		usuario CHAR(50),
		contrasena CHAR(50),
		PRIMARY KEY(id)
		)";
		if (mysqli_query($con,$sql)) {
			echo "tabla creada";
		} else 
			echo "Tabla no creada";

		mysqli_close($con);
}

crearTablas();

?>