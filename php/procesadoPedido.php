<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pedido">
    <meta name="author" content="Imprenta Hermanos Umpiérrez">

    <title>Procesando</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Imprenta Hermanos Umpiérrez</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="about.html">Registro</a>
                    </li>
                    <li>
                        <a href="services.html">Login</a>
                    </li>
                    <li>
                        <a href="contacto.html">Contacto</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Recepción de pedido
                    <small>Pedido</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../index.html">Inicio</a>
                    </li>
                    <li class="active">Tarjetas de Visita</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

<?php

        require_once "conectari.php";
        
        $mysqli = conectar();

		// SI HACEMOS CLICK EN COMPRATARJETA
		if (isset($_POST["compraTarjeta"])){
			$emailCl = $_POST["emailCl"];
            $passCl = $_POST["passCl"];
            $impresion = $_POST["impresion"];
            $acabado = $_POST["acabado"];
            $tipoPapel = $_POST["tipoPapel"];
            $tamanoProducto = $_POST["tamanoProducto"];
            $pago = $_POST["pago"];
            $envio = $_POST["envio"];
            $cantidad = $_POST["cantidad"];
            $fecha= date("Y-m-d");
            
            // OBTENEMOS LOS DATOS DEL PRODUCTO SELECCIONADO
            $sql= "SELECT * FROM tProducto,tCliente WHERE nombreProducto= 'Tarjeta de Visita'
            AND emailCl='$emailCl'";
            $resultado = $mysqli -> query($sql);
            while ($fila = $resultado -> fetch_assoc()){
                $idProducto=$fila['idProducto'];
                $dniCif=$fila['dniCif'];
                $importe=$cantidad*$fila['precio'];
            }

			// COMPROBAMOS SI EL CLIENTE EXISTE, SI NO MOSTRAMOS BOTON REGISTRARSE
			$sql = "SELECT * FROM tCliente WHERE emailCl= '$emailCl' AND passCl='$passCl'";
			
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                // DAMOS DE ALTA UNA NUEVA FACTURA
			    $sql= "INSERT INTO tFactura (pago,importe,envio,fecha) 
                VALUES('$pago',$importe,'$envio','$fecha')";
				
                if ($mysqli->query($sql)) {
                    
                    // DAMOS DE ALTA UN REGISTRO EN LA TABLA TSOLICITA
                    $sql="INSERT INTO tSolicita VALUES(
                    (select nFactura FROM tFactura order by nFactura desc limit 1),
                     $idProducto,'$dniCif')";
                     if ($mysqli->query($sql)) {
                        
                    } else {
                        echo "Error: " .$sql ."<br>" .$mysqli->error;
                    }
            } else {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }
                echo "<div class='alert alert-success'>Compra realizada con éxito";
                echo "<button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
			} else {
				echo "<div class='alert alert-danger'>Email o password incorrectos.<br>";
                echo "<button class='btn btn-default'><a href='../registro.php'>Registrarse</a></button> 
                    <button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
			}
		} // CIERRE IF compraTarjeta

        // SI HACEMOS CLICK EN COMPRAFLYER
        if (isset($_POST["compraFlyer"])){
            $emailCl = $_POST["emailCl"];
            $passCl = $_POST["passCl"];
            $impresion = $_POST["impresion"];
            $acabado = $_POST["acabado"];
            $tipoPapel = $_POST["tipoPapel"];
            $tamanoProducto = $_POST["tamanoProducto"];
            $pago = $_POST["pago"];
            $envio = $_POST["envio"];
            $cantidad = $_POST["cantidad"];
            $fecha= date("Y-m-d");
            
            // OBTENEMOS LOS DATOS DEL PRODUCTO SELECCIONADO
            $sql= "SELECT * FROM tProducto,tCliente WHERE nombreProducto= 'Tarjeta de Visita'
            AND emailCl='$emailCl'";
            $resultado = $mysqli -> query($sql);
            while ($fila = $resultado -> fetch_assoc()){
                $idProducto=$fila['idProducto'];
                $dniCif=$fila['dniCif'];
                $importe=$cantidad*$fila['precio'];
            }

            // COMPROBAMOS SI EL CLIENTE EXISTE, SI NO MOSTRAMOS BOTON REGISTRARSE
            $sql = "SELECT * FROM tCliente WHERE emailCl= '$emailCl' AND passCl='$passCl'";
            
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                // DAMOS DE ALTA UNA NUEVA FACTURA
                $sql= "INSERT INTO tFactura (pago,importe,envio,fecha) 
                VALUES('$pago',$importe,'$envio','$fecha')";
                
                if ($mysqli->query($sql)) {
                    
                    // DAMOS DE ALTA UN REGISTRO EN LA TABLA TSOLICITA
                    $sql="INSERT INTO tSolicita VALUES(
                    (select nFactura FROM tFactura order by nFactura desc limit 1),
                     $idProducto,'$dniCif')";
                     if ($mysqli->query($sql)) {
                        
                    } else {
                        echo "Error: " .$sql ."<br>" .$mysqli->error;
                    }
            } else {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }
                echo "<div class='alert alert-success'>Compra realizada con éxito";
                echo "<button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            } else {
                echo "<div class='alert alert-danger'>Email o password incorrectos.<br>";
                echo "<button class='btn btn-default'><a href='../registro.php'>Registrarse</a></button> 
                    <button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            }
        } // CIERRE IF compraflyer

        // SI HACEMOS CLICK EN COMPRATRIPTICO
        if (isset($_POST["compraTriptico"])){
            $emailCl = $_POST["emailCl"];
            $passCl = $_POST["passCl"];
            $impresion = $_POST["impresion"];
            $acabado = $_POST["acabado"];
            $tipoPapel = $_POST["tipoPapel"];
            $tamanoProducto = $_POST["tamanoProducto"];
            $pago = $_POST["pago"];
            $envio = $_POST["envio"];
            $cantidad = $_POST["cantidad"];
            $fecha= date("Y-m-d");
            

            $sql= "SELECT * FROM tProducto,tCliente WHERE nombreProducto= 'Triptico'
            AND emailCl='$emailCl'";
            echo $sql;
            $resultado = $mysqli -> query($sql);
            while ($fila = $resultado -> fetch_assoc()){
                $idProducto=$fila['idProducto'];
                $dniCif=$fila['dniCif'];
                $importe=$cantidad*$fila['precio'];
            }

            //Se describe la inserción de datos en SQL
            $sql = "SELECT * FROM tCliente WHERE emailCl= '$emailCl' AND passCl='$passCl'";
            echo $sql;
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {

                 $sql= "INSERT INTO tFactura (pago,importe,envio,fecha) 
                VALUES('$pago',$importe,'$envio','$fecha')";
                echo $sql;
                if ($mysqli->query($sql)) {
                echo "Se ha insertado con éxito";
            } else {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }
                echo "<div>pedido realizado<br>";
                echo "<button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            } else {
                echo "<div>Email o password incorrectos.<br>";
                echo "<button class='btn btn-default'><a href='../registro.php'>Registrarse</a></button> 
                    <button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            }
        } // CIERRE IF compraTriptico

        // SI HACEMOS CLICK EN COMPRACARTEL
        if (isset($_POST["compraCartel"])){
            $emailCl = $_POST["emailCl"];
            $passCl = $_POST["passCl"];
            $impresion = $_POST["impresion"];
            $acabado = $_POST["acabado"];
            $tipoPapel = $_POST["tipoPapel"];
            $tamanoProducto = $_POST["tamanoProducto"];
            $pago = $_POST["pago"];
            $envio = $_POST["envio"];
            $cantidad = $_POST["cantidad"];
            $fecha= date("Y-m-d");
            
            // OBTENEMOS LOS DATOS DEL PRODUCTO SELECCIONADO
            $sql= "SELECT * FROM tProducto,tCliente WHERE nombreProducto= 'Tarjeta de Visita'
            AND emailCl='$emailCl'";
            $resultado = $mysqli -> query($sql);
            while ($fila = $resultado -> fetch_assoc()){
                $idProducto=$fila['idProducto'];
                $dniCif=$fila['dniCif'];
                $importe=$cantidad*$fila['precio'];
            }

            // COMPROBAMOS SI EL CLIENTE EXISTE, SI NO MOSTRAMOS BOTON REGISTRARSE
            $sql = "SELECT * FROM tCliente WHERE emailCl= '$emailCl' AND passCl='$passCl'";
            
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                // DAMOS DE ALTA UNA NUEVA FACTURA
                $sql= "INSERT INTO tFactura (pago,importe,envio,fecha) 
                VALUES('$pago',$importe,'$envio','$fecha')";
                
                if ($mysqli->query($sql)) {
                    
                    // DAMOS DE ALTA UN REGISTRO EN LA TABLA TSOLICITA
                    $sql="INSERT INTO tSolicita VALUES(
                    (select nFactura FROM tFactura order by nFactura desc limit 1),
                     $idProducto,'$dniCif')";
                     if ($mysqli->query($sql)) {
                        
                    } else {
                        echo "Error: " .$sql ."<br>" .$mysqli->error;
                    }
            } else {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }
                echo "<div class='alert alert-success'>Compra realizada con éxito";
                echo "<button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            } else {
                echo "<div class='alert alert-danger'>Email o password incorrectos.<br>";
                echo "<button class='btn btn-default'><a href='../registro.php'>Registrarse</a></button> 
                    <button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            }
        } // CIERRE IF compraCartel

        // SI HACEMOS CLICK EN COMPRACARPETA
        if (isset($_POST["compraCarpeta"])){
            $emailCl = $_POST["emailCl"];
            $passCl = $_POST["passCl"];
            $impresion = $_POST["impresion"];
            $acabado = $_POST["acabado"];
            $tipoPapel = $_POST["tipoPapel"];
            $tamanoProducto = $_POST["tamanoProducto"];
            $pago = $_POST["pago"];
            $envio = $_POST["envio"];
            $cantidad = $_POST["cantidad"];
            $fecha= date("Y-m-d");
            
            // OBTENEMOS LOS DATOS DEL PRODUCTO SELECCIONADO
            $sql= "SELECT * FROM tProducto,tCliente WHERE nombreProducto= 'Tarjeta de Visita'
            AND emailCl='$emailCl'";
            $resultado = $mysqli -> query($sql);
            while ($fila = $resultado -> fetch_assoc()){
                $idProducto=$fila['idProducto'];
                $dniCif=$fila['dniCif'];
                $importe=$cantidad*$fila['precio'];
            }

            // COMPROBAMOS SI EL CLIENTE EXISTE, SI NO MOSTRAMOS BOTON REGISTRARSE
            $sql = "SELECT * FROM tCliente WHERE emailCl= '$emailCl' AND passCl='$passCl'";
            
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                // DAMOS DE ALTA UNA NUEVA FACTURA
                $sql= "INSERT INTO tFactura (pago,importe,envio,fecha) 
                VALUES('$pago',$importe,'$envio','$fecha')";
                
                if ($mysqli->query($sql)) {
                    
                    // DAMOS DE ALTA UN REGISTRO EN LA TABLA TSOLICITA
                    $sql="INSERT INTO tSolicita VALUES(
                    (select nFactura FROM tFactura order by nFactura desc limit 1),
                     $idProducto,'$dniCif')";
                     if ($mysqli->query($sql)) {
                        
                    } else {
                        echo "Error: " .$sql ."<br>" .$mysqli->error;
                    }
            } else {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }
                echo "<div class='alert alert-success'>Compra realizada con éxito";
                echo "<button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            } else {
                echo "<div class='alert alert-danger'>Email o password incorrectos.<br>";
                echo "<button class='btn btn-default'><a href='../registro.php'>Registrarse</a></button> 
                    <button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            }
        } // CIERRE IF compraCarpeta

        // SI HACEMOS CLICK EN COMPRATALON
        if (isset($_POST["compraTalon"])){
            $emailCl = $_POST["emailCl"];
            $passCl = $_POST["passCl"];
            $impresion = $_POST["impresion"];
            $acabado = $_POST["acabado"];
            $tipoPapel = $_POST["tipoPapel"];
            $tamanoProducto = $_POST["tamanoProducto"];
            $pago = $_POST["pago"];
            $envio = $_POST["envio"];
            $cantidad = $_POST["cantidad"];
            $fecha= date("Y-m-d");
            
            // OBTENEMOS LOS DATOS DEL PRODUCTO SELECCIONADO
            $sql= "SELECT * FROM tProducto,tCliente WHERE nombreProducto= 'Tarjeta de Visita'
            AND emailCl='$emailCl'";
            $resultado = $mysqli -> query($sql);
            while ($fila = $resultado -> fetch_assoc()){
                $idProducto=$fila['idProducto'];
                $dniCif=$fila['dniCif'];
                $importe=$cantidad*$fila['precio'];
            }

            // COMPROBAMOS SI EL CLIENTE EXISTE, SI NO MOSTRAMOS BOTON REGISTRARSE
            $sql = "SELECT * FROM tCliente WHERE emailCl= '$emailCl' AND passCl='$passCl'";
            
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                // DAMOS DE ALTA UNA NUEVA FACTURA
                $sql= "INSERT INTO tFactura (pago,importe,envio,fecha) 
                VALUES('$pago',$importe,'$envio','$fecha')";
                
                if ($mysqli->query($sql)) {
                    
                    // DAMOS DE ALTA UN REGISTRO EN LA TABLA TSOLICITA
                    $sql="INSERT INTO tSolicita VALUES(
                    (select nFactura FROM tFactura order by nFactura desc limit 1),
                     $idProducto,'$dniCif')";
                     if ($mysqli->query($sql)) {
                        
                    } else {
                        echo "Error: " .$sql ."<br>" .$mysqli->error;
                    }
            } else {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }
                echo "<div class='alert alert-success'>Compra realizada con éxito";
                echo "<button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            } else {
                echo "<div class='alert alert-danger'>Email o password incorrectos.<br>";
                echo "<button class='btn btn-default'><a href='../registro.php'>Registrarse</a></button> 
                    <button class='btn btn-default'><a href='../pedidos/pedido.php'>Volver</a></button>
                    </div>";
            }
        } // CIERRE IF compraTalon

?>

<hr>

        <!-- FOOTER -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Imprenta Hermanos Umpiérrez. Web desarrollada por <a href="http://javierjimenez.mondaenlaweb.com">Javier Jiménez</a></p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="../js/jquery-1.12.4.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Scripts elección formulario -->
    <script src="../js/scripts.js"></script>

</body>

</html>