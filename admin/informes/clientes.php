<?php

	require_once "../../php/conectari.php";
	$mysqli = conectar();

	$sql = "SELECT * FROM tCliente";
	$resultado = $mysqli -> query($sql);

	$numfilas = $resultado -> num_rows;

	if ($numfilas > 0) {
		
		$dom = new DOMDocument('1.0','utf-8');
		 // Se define el elemento
		 $clientes = $dom->createElement("clientes");
		 // Se crea el nodo del elemento
		 $dom->appendChild($clientes);

		 while ($fila = $resultado->fetch_assoc()) {
			 $dniCif = $dom->createElement("dniCif");
			 $clientes->appendChild($dniCif);
			 $dniCif = $dom->createTextNode($fila['dniCif']);
			 $clientes->appendChild($dniCif);

			 $nombreCl = $dom->createElement("nombreCl");
			 $clientes->appendChild($nombreCl);
			 $nombreCl = $dom->createTextNode($fila['nombreCl']);
			 $clientes->appendChild($nombreCl);

			 $apellidosCl = $dom->createElement("apellidosCl");
			 $clientes->appendChild($apellidosCl);
			 $apellidosCl = $dom->createTextNode($fila['apellidosCl']);
			 $clientes->appendChild($apellidosCl);

			 $direccionCl = $dom->createElement("direccionCl");
			 $clientes->appendChild($direccionCl);
			 $direccionCl = $dom->createTextNode($fila['direccionCl']);
			 $clientes->appendChild($direccionCl);

			 $emailCl = $dom->createElement("emailCl");
			 $clientes->appendChild($emailCl);
			 $elemento = $dom->createTextNode($fila['emailCl']);
			 $clientes->appendChild($emailCl);

			 $passCl = $dom->createElement("passCl");
			 $clientes->appendChild($passCl);
			 $elemento = $dom->createTextNode($fila['passCl']);
			 $clientes->appendChild($passCl);

			 $imagenCl = $dom->createElement("imagenCl");
			 $clientes->appendChild($imagenCl);
			 $elemento = $dom->createTextNode($fila['imagenCl']);
			 $clientes->appendChild($imagenCl);

			 $cpCli = $dom->createElement("cpCli");
			 $clientes->appendChild($cpCli);
			 $elemento = $dom->createTextNode($fila['cpCli']);
			 $clientes->appendChild($cpCli);
		}
		header("content-type: text/xml");
		echo $dom->saveXML();
		//Finalmente, guardarlo en una ubicación
		$dom->save('./clientes.xml');

	} //CIERRE IF

	$mysqli=close();

?>