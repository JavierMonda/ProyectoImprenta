<?php

include "../controlador/usuariosControlador.php";

if(isset($_POST["usuario"]) || isset($_POST["pass"])) {
	if(trim($_POST["usuario"]) == "" || trim($_POST["pass"]) == ""){
		echo "false";
	}else {
	$usuariosCon = new usuariosControlador();
		if($usuariosCon -> insertarUsuarios($_POST["usuario"],$_POST["pass"])) {
			echo "true";
		} else{
			echo"false";
		}
	}
}else{
	echo "false";
}
?>