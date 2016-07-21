<?php 
class conexion {
	function conectar() {
		return mysqli_connect(
			"localhost",
			"root",
			"B0quep@s");
	}
}

?>