<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administración - Facturas</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

 	<?php
		session_start();
		//if(isset($_SESSION["usuario"]) && isset($_SESSION["pass"])) {
		require_once "../../php/conectari.php";
		$mysqli = conectar();

		// SI HACEMOS CLICK EN ALTA 2
		if (isset($_POST["alta2"])){
			$seleccionar = $_POST["seleccionar"];
			$nFactura = $_POST["nFactura"];
			$pago = $_POST["pago"];
            $importe = $_POST["importe"];
            $envio = $_POST["envio"];
            $fecha = $_POST["fecha"];

			//Se describe la inserción de datos en SQL
			$sql = "INSERT INTO tFactura VALUES ($nFactura,'$pago',$importe,'$envio','$fecha');";
			
			if ($mysqli->query($sql)) {
				echo "Se ha insertado con éxito";
			} else {
				echo "Error: " .$sql ."<br>" .$mysqli->error;
			}
		} // CIERRE IF ALTA 2

		// SI HACEMOS CLICK EN GUARDAR
		if (isset($_POST["guardar"]) && (isset($_POST["seleccionar"]))) {
			$seleccionar = $_POST["seleccionar"];
			$nFactura = $_POST["nFactura"];
			$pago = $_POST["pago"];
            $importe = $_POST["importe"];
            $envio = $_POST["envio"];
            $fecha = $_POST["fecha"];
							
			for ($i=0;$i < count($nFactura);$i++) {
			   	$pago[$i] = test_input($pago[$i]);
                $importe[$i] = test_input($importe[$i]);
                $envio[$i] = test_input($envio[$i]);
                $fecha[$i] = test_input($fecha[$i]);
    			  
    			$j = 0;
    			$sql = ""; 
    			while ($j < count($seleccionar)) { 
    				if ($seleccionar[$j ++] == $nFactura[$i]){

        				$sql = "UPDATE tFactura SET pago= '$pago[$i]', importe= $importe, 
                        envio= '$envio', fecha= '$fecha' 
        				WHERE nFactura= $nFactura[$i]";
    					if ($mysqli->query($sql)){
                			echo "Registro " .$nFactura[$i] ." modificado satisfactoriamente";
                		} else if (($sql != '') && (!$mysqli->query($sql))){
        					echo "Error: " .$mysqli->error;
    					}
                	}
    			}
    		}
    	} // CIERRE IF GUARDAR

    	// SI HACEMOS CLICK EN ELIMINAR
    	if ((isset($_POST["eliminar"])) && (isset($_POST["seleccionar"]))) {
    		
			$seleccionar = $_POST["seleccionar"];
			$nFactura = $_POST["nFactura"];
            $pago = $_POST["pago"];
            $importe = $_POST["importe"];
            $envio = $_POST["envio"];
            $fecha = $_POST["fecha"];

			for ($i=0;$i < count($dniCif);$i++) {
			   	$nFactura[$i] = test_input($nFactura[$i]);
    			$pago[$i] = test_input($pago[$i]);
                $importe[$i] = test_input($importe[$i]);
                $envio[$i] = test_input($envio[$i]);
                $fecha[$i] = test_input($fecha[$i]);
    			  
    			$j = 0;
    			$sql = "";       			
        		while ($j < count($seleccionar)){
            		if ($seleccionar[$j ++] == $nFactura[$i]){
                		$sql = "DELETE FROM tFactura WHERE nFactura= $nFactura[$i]";
                	}
        		}  
        		if ($sql!="" and (! $mysqli->query($sql)))
        			echo "Error: " . $mysqli->error;     			
    		}
		} // CIERRE IF ELIMINAR
    ?>



	
	<div id="wrapper">	
		<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                	<span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../../index.html">Inicio</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                    <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li> -->
                        <li class="divider"></li>
                        <li><a href="cerrarSesion.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="admin.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="codigoPostal.php"><i class="fa fa-edit fa-fw"></i> Código Postal</a>
                        </li>
                        <li>
                            <a href="clientes.php"><i class="fa fa-user fa-fw"></i> Clientes</a>
                        </li>
                        <li>
                            <a href="telCliente.php"><i class="fa fa-edit fa-fw"></i> Teléfonos Cliente</a>
                        </li>
                        <li>
                            <a href="departamentos.php"><i class="fa fa-edit fa-fw"></i> Departamentos</a>
                        </li>
                        <li>
                            <a href="empleados.php"><i class="fa fa-edit fa-fw"></i> Empleados</a>
                        </li>
                        <li>
                            <a href="telEmpleado.php"><i class="fa fa-edit fa-fw"></i> Teléfonos Empleados</a>
                        </li>
                        <!-- 
                        <li>
                            <a href="disenos.php"><i class="fa fa-edit fa-fw"></i> Diseños de Clientes</a>
                        </li>
                        -->
                        <li>
                            <a href="facturas.php"><i class="fa fa-edit fa-fw"></i> Facturas</a>
                        </li>                      
                        <li>
                            <a href="productos.php"><i class="fa fa-edit fa-fw"></i> Productos</a>
                        </li>
                        <li>
                        <li>
                            <a href="pedidos.php"><i class="fa fa-edit fa-fw"></i> Pedidos</a>
                        </li>
                        <li>
                            <a href="realizado.php"><i class="fa fa-edit fa-fw"></i> Empleado que realiza el producto</a>
                        </li>

                    </ul>
                </div>
            </div>
</nav>
            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard
                    	<small>Facturas</small>
                    </h1>
                    
                </div>

                <!-- /.col-lg-12 -->
                <div class="col-lg-12">

                <?php
                    // SI HACEMOS CLICK EN ALTA
                    if (isset($_POST["alta"])){
                        // FORMULARIO DE ALTA
                ?>
                        <div class="form-group">
                            <fieldset>
                                <legend><span>Alta de Facturas</span></legend>
                                <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                    
                                    <label for="nFactura">ID Diseño </label><a name="nFactura"></a>
                                    <input class="form-control" tabindex="1" type="number" name="nFactura" placeholder="Nº de Factura" required>

                                    <label for="pago">Tipo de pago </label><a name="pago"></a> 
                                    <input class="form-control" tabindex="2" type="text" name="pago" placeholder="Tipo de pago" required>

                                    <label for="importe">Importe </label><a name="importe"></a> 
                                    <input class="form-control" tabindex="2" type="number" name="importe" placeholder="Importe" required>

                                    <label for="envio">Tipo de envío </label><a name="envio"></a> 
                                    <input class="form-control" tabindex="2" type="text" name="envio" placeholder="Tipo de envío" required>

                                    <label for="fecha">Fecha </label><a name="fecha"></a> 
                                    <input class="form-control" tabindex="2" type="date" name="fecha" placeholder="Fecha" required>

                                    <label for="alta2"></label><a name="alta2"></a>
                                    <button type="submit" name="alta2" class="btn btn-default"/>Alta</button>

                                </form> 

                            </fieldset>                     
                            
                        </div>

                <?php 
                    } // CIERRE IF ALTA
                            
                ?>

                </div>


                <!-- /.col-lg-12 -->
                <div class="col-lg-12">

                	<!-- FORMULARIO -->
					
					<div class="form-group">
						<fieldset>

						<?php 
							// LANZAMOS LA CONSULTA DE TODOS LOS DATOS DE LA TABLA MANUALES
							// PARA MOSTRARLOS EN EL FORMULARIO
							
							$sql = "SELECT * FROM  tFactura";						
							$resultado = $mysqli -> query($sql);						
						?>
							<legend><span>Alta, Baja y Modificación de Facturas</span></legend> 

							<form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

								<table class="table-hover table-responsive table-striped">
									<tr><td colspan="6">Dar de alta una nueva Factura: </td></tr>
									<tr><td colspan="6"><button type="submit" name="alta" class="btn btn-default" />Alta</button></td></tr>
									<tr>
										<th>Seleccionar</th>
										<th>Número de Factura</th>
										<th>Tipo de pago</th>
                                        <th>Importe</th>
                                        <th>Tipo de envío</th>
                                        <th>Fecha</th>
									</tr>
							<?php
								while ($fila = $resultado -> fetch_assoc()){
									echo '
									<tr>
										<td><input type="checkbox" name="seleccionar[]" class="form-control" value="' .$fila['nFactura'] .'"/></td>
										<td><input type="number" name="nFactura[]" class="form-control" value="' .$fila['nFactura'] .'" readonly></td>
										<td><input type="text" name="pago[]" class="form-control" value="' .$fila['pago'] .'"></td>
                                        <td><input type="number" name="importe[]" class="form-control" value="' .$fila['importe'] .'"></td>
                                        <td><input type="text" name="envio[]" class="form-control" value="' .$fila['envio'] .'"></td>
                                        <td><input type="date" name="fecha[]" class="form-control" value="' .$fila['fecha'] .'"></td>
									</tr>';
									
								}
								echo '<tr><td colspan="2"><button type="submit" name="guardar" class="btn btn-default"/>Modificar</button></td>';
								echo '<td colspan="2"><button type="submit" name="eliminar" class="btn btn-default"/>Eliminar</button></td>';
								echo '<td colspan="2"><button type="submit" class="btn btn-default" name="generar"/>Generar PDF</button></td>';
								echo '<td><button type="submit" name="generarxml" class="btn btn-default"/>Generar XML</button></td></tr>';

								
								echo "</table>";
								echo "</form>"
							?> 
						
						</fieldset>
						<div id="error" class="" role="alert">
						</div>
					</div>

                </div>
            </div>
            <!-- /.row -->
            
	</div>
    <!-- /#wrapper -->
    <?php
    	$mysqli -> close();
    //}else {
	//			echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	//	}
	?>
   

	<!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>