<?php
//MySQL PDO
//Se incluye el código con los datos de conexión

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	return $data;
}

function conectar()
{
require_once 'mysql-login.php';

// Uso de try-catch para manejar los errores

try {
	// Creación de un objeto para la clase PDO.
	// Realiza la conexión con el servidor MySQL
	// Para realizar la conexión es necesario incluir el estándar
	$pdo = new PDO("mysql:host=$hostname; dbname=$database", $username, $password);
	// Configura el modo de error para la excepción
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	print "Conexión exitosa!";
	return($pdo);
}
	// Se muestra el mensaje de error a través de las exepciones
catch (PDOException $e) {
	print "Error!: " .$e -> getMessage();
	//finaliza el proceso
	die();
}
}


?>