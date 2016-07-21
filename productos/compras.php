<?php
	session_start();
	require_once "../php/conectari.php";
    $mysqli=conectar();
	$arreglo=$_SESSION['carrito'];
	$numeroPedido=0;
	//$numeroFacturaSol=0;
	$cliente = $_POST['cliente'];
	

	$sql = "SELECT * FROM tSolicita ORDER BY numeroPedido DESC limit 1";
	
    $resultado=$mysqli->query($sql);
    

    while($fila=$resultado->fetch_assoc()) {
    	$numeroPedido=$fila['numeroPedido'];
    }
    if ($numeroPedido==0) {
    	$numeroPedido=1;
    } else {
    	$numeroPedido++;
    }
    
    $sql = "SELECT * FROM tSolicita ORDER BY nFacturaSol DESC limit 1";
	
    $resultado=$mysqli->query($sql);
    

    while($fila=$resultado->fetch_assoc()) {
    	$numeroFacturaSol=$fila['nFacturaSol'];
    }
    $numeroFacturaSol=100;

    for($i=0;$i<count($arreglo);$i++) {
    	$sql="INSERT INTO tSolicita (dniCifSol,idProductoSol,nFacturaSol,numeroPedido,precio,cantidad,subTotal) VALUES(
			'$cliente',
			".$arreglo[$i]['IdProducto'].",
			".$numeroFacturaSol. ",
			".$numeroPedido. ",
			".$arreglo[$i]['Precio'].",
			".$arreglo[$i]['Cantidad'].",
			".($arreglo[$i]['Cantidad']*$arreglo[$i]['Precio'])."
    		)";
    		echo $sql;
    	
    	$resultado=$mysqli->query($sql);
    	if($resultado){
    		echo "Todo bien";
    	} else {
    		echo "Error: " .$sql ."<br>" .$mysqli->error;
    	}
    	$numeroPedido++;
    	//$numeroFacturaSol++;

    }
    //$mysqli=close();
  	unset($_SESSION['carrito']);
    header("Location: ./gracias.html");
?>