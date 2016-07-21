<?php
    session_start();
        
        require_once "../mpdf/mpdf.php";
        require_once "../../php/conectari.php";
        
        $mysqli = conectar();

        //SI PULSAMOS EL BOTÓN GENERAR XML
        if (isset($_POST["generarxml"])) {

            $sql = "SELECT * FROM tEmpleado";
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                
                $dom = new DOMDocument('1.0','utf-8');
                 // Se define el elemento
                 $empleados = $dom->createElement("empleados");
                 // Se crea el nodo del elemento
                 $dom->appendChild($empleados);

                 while ($fila = $resultado->fetch_assoc()) {
                     $dniEmp = $dom->createElement("dniEmp");
                     $empleados->appendChild($dniEmp);
                     $dniEmp = $dom->createTextNode($fila['dniEmp']);
                     $empleados->appendChild($dniEmp);

                     $seguridadSocial = $dom->createElement("seguridadSocial");
                     $empleados->appendChild($seguridadSocial);
                     $seguridadSocial = $dom->createTextNode($fila['seguridadSocial']);
                     $empleados->appendChild($seguridadSocial);

                     $nombreEmp = $dom->createElement("nombreEmp");
                     $empleados->appendChild($nombreEmp);
                     $nombreEmp = $dom->createTextNode($fila['nombreEmp']);
                     $empleados->appendChild($nombreEmp);

                     $apellidosEmp = $dom->createElement("apellidosEmp");
                     $empleados->appendChild($apellidosEmp);
                     $apellidosEmp = $dom->createTextNode($fila['apellidosEmp']);
                     $empleados->appendChild($apellidosEmp);

                     $emailEmp = $dom->createElement("emailEmp");
                     $empleados->appendChild($emailEmp);
                     $elemento = $dom->createTextNode($fila['emailEmp']);
                     $empleados->appendChild($emailEmp);

                     $passEmp = $dom->createElement("passEmp");
                     $empleados->appendChild($passEmp);
                     $elemento = $dom->createTextNode($fila['passEmp']);
                     $empleados->appendChild($passEmp);

                     $direccionEmp = $dom->createElement("direccionEmp");
                     $empleados->appendChild($direccionEmp);
                     $direccionEmp = $dom->createTextNode($fila['direccionEmp']);
                     $empleados->appendChild($direccionEmp);

                     $salario = $dom->createElement("salario");
                     $empleados->appendChild($salario);
                     $elemento = $dom->createTextNode($fila['salario']);
                     $empleados->appendChild($salario);

                     $comision = $dom->createElement("comision");
                     $empleados->appendChild($comision);
                     $elemento = $dom->createTextNode($fila['comision']);
                     $empleados->appendChild($comision);

                     $nombreDepEmp = $dom->createElement("nombreDepEmp");
                     $empleados->appendChild($nombreDepEmp);
                     $elemento = $dom->createTextNode($fila['nombreDepEmp']);
                     $empleados->appendChild($nombreDepEmp);
                }
                //header("content-type: text/xml");
                echo $dom->saveXML();
                //Finalmente, guardarlo en una ubicación
                $dom->save('../informes/empleados.xml');

            } //CIERRE IF

        } //CIERRE ISSET GENERARXML
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administración - Empleados</title>

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
		

        // SI PULSAMOS GENERAR
        if (isset($_POST["generar"])) {
            $cabecera = "<span><img src='../../imagenes/logo.jpg' width='200px' height='100px'/><b>Informe PDF</b></span>";
            $pie = "<span>Tabla Empleados. Imprenta Hermanos Umpierrez</span>";
            $mpdf=new mPDF();
            $style=file_get_contents('../css/tabla.css');
            $mpdf->WriteHTML($style, 1);
            $mpdf->SetHTMLHeader($cabecera);
            $mpdf->SetHTMLFooter($pie);

            $sql = "SELECT * FROM  tEmpleado";                       
            $resultado = $mysqli -> query($sql);

            $mpdf->WriteHTML('<table class="table-hover table-responsive table-striped">
                <tr>
                    <th>DNI</th>
                    <th>Seguridad Social</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Direccion</th>
                    <th>Salario</th>                   
                    <th>Comision</th>
                    <th>Nombre Departamento</th>
                </tr>',2);
            while ($fila = $resultado -> fetch_assoc()){

                $mpdf->WriteHTML('<tr>
                                <td>' .$fila['dniEmp'] .'</td>
                                <td>' .$fila['seguridadSocial'] .'</td>
                                <td>' .$fila['nombreEmp'] .'</td>
                                <td>' .$fila['apellidosEmp'] .'</td>
                                <td>' .$fila['emailEmp'] .'</td>
                                <td>' .$fila['passEmp'] .'</td>
                                <td>' .$fila['direccionEmp'] .'</td>
                                <td>' .$fila['salario'] .'</td>                                                             
                                <td>' .$fila['comision'] .'</td>
                                <td>' .$fila['nombreDepEmp'] .'</td>
                            </tr>', 2);
            }
            $mpdf->WriteHTML('</table>',2);             
            $mpdf->Output('empleados.pdf','I');
            exit;

        } // CIERRE DE IF GENERAR

		// SI HACEMOS CLICK EN ALTA 2
		if (isset($_POST["alta2"])){
			$seleccionar = $_POST["seleccionar"];
			$dniEmp = $_POST["dniEmp"];
			$seguridadSocial = $_POST["seguridadSocial"];
			$nombreEmp = $_POST["nombreEmp"];
			$apellidosEmp = $_POST["apellidosEmp"];
			$direccionEmp = $_POST["direccionEmp"];
			$emailEmp = $_POST["emailEmp"];
            $passEmp = $_POST["passEmp"];
			$salario = $_POST["salario"];
            $comision = $_POST["comision"];
            $nombreDepEmp = $_POST["nombreDepEmp"];

			//Se describe la inserción de datos en SQL
			$sql = "INSERT INTO tEmpleado VALUES ('$dniEmp','$seguridadSocial','$nombreEmp','$apellidosEmp',
            '$emailEmp','$passEmp','$direccionEmp','$salario','$comision','$nombreDepEmp');";
			
			if ($mysqli->query($sql)) {
				echo "Se ha insertado con éxito";
			} else {
				echo "Error: " .$sql ."<br>" .$mysqli->error;
			}
		} // CIERRE IF ALTA 2

		// SI HACEMOS CLICK EN GUARDAR
		if (isset($_POST["guardar"]) && (isset($_POST["seleccionar"]))) {
			$seleccionar = $_POST["seleccionar"];
			$dniEmp = $_POST["dniEmp"];
			$seguridadSocial = $_POST["seguridadSocial"];
			$nombreEmp = $_POST["nombreEmp"];
			$apellidosEmp = $_POST["apellidosEmp"];
			$direccionEmp = $_POST["direccionEmp"];
			$emailEmp = $_POST["emailEmp"];
            $telefonoEmp = $_POST["telefonoEmp"];
            $passEmp = $_POST["passEmp"];
			$salario = $_POST["salario"];
            $comision = $_POST["comision"];
            $nombreDepEmp = $_POST["nombreDepEmp"];
							
			for ($i=0;$i < count($dniEmp);$i++) {
			   	$seguridadSocial[$i] = test_input($seguridadSocial[$i]);
    			$nombreEmp[$i] = test_input($nombreEmp[$i]);
    			$apellidosEmp[$i] = test_input($apellidosEmp[$i]);
    			$direccionEmp[$i] = test_input($direccionEmp[$i]);
                $telefonoEmp[$i] = test_input($telefonoEmp[$i]);
    			$emailEmp[$i] = test_input($emailEmp[$i]);
                $passEmp[$i] = test_input($passEmp[$i]);
    			$salario[$i] = test_input($salario[$i]);
                $comision[$i] = test_input($comision[$i]);
                $nombreDepEmp[$i] = test_input($nombreDepEmp[$i]);
    			  

    			$j = 0;
    			$sql = ""; 
    			while ($j < count($seleccionar)) { 
    				if ($seleccionar[$j ++] == $dniEmp[$i]){

                        

        				$sql = "UPDATE tEmpleado SET seguridadSocial= '$seguridadSocial[$i]', 
        				nombreEmp= '$nombreEmp[$i]', apellidosEmp= '$apellidosEmp[$i]', 
        				emailEmp= '$emailEmp[$i]', passEmp= '$passEmp[$i]', direccionEmp= '$direccionEmp[$i]',
                        salario = $salario[$i], comision = $comision[$i], 
                        nombreDepEmp = '$nombreDepEmp[$i]' 
        				WHERE dniEmp='$dniEmp[$i]' ";
    					if ($mysqli->query($sql)){
                			echo "Registro " .$dniEmp[$i] ." modificado satisfactoriamente";
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
			$dniEmp = $_POST["dniEmp"];
			$seguridadSocial = $_POST["seguridadSocial"];
			$nombreEmp = $_POST["nombreEmp"];
			$apellidosEmp = $_POST["apellidosEmp"];
			$direccionEmp = $_POST["direccionEmp"];
			$emailEmp = $_POST["emailEmp"];
            $passEmp = $_POST["passEmp"];
			$salario = $_POST["salario"];
            $comision = $_POST["comision"];
            $nombreDepEmp = $_POST["nombreDepEmp"];

			for ($i=0;$i < count($dniEmp);$i++) {
			   	$seguridadSocial[$i] = test_input($seguridadSocial[$i]);
    			$nombreEmp[$i] = test_input($nombreEmp[$i]);
    			$apellidosEmp[$i] = test_input($apellidosEmp[$i]);
    			$direccionEmp[$i] = test_input($direccionEmp[$i]);
                $passEmp[$i] = test_input($passEmp[$i]);
    			$emailEmp[$i] = test_input($emailEmp[$i]);
    			$salario[$i] = test_input($salario[$i]);
                $comision[$i] = test_input($comision[$i]);
                $nombreDepEmp[$i] = test_input($nombreDepEmp[$i]);
    			  
    			$j = 0;
    			$sql = "";       			
        		while ($j < count($seleccionar)){
            		if ($seleccionar[$j ++] == $dniEmp[$i]){
                		$sql = "DELETE FROM tEmpleado WHERE dniEmp='$dniEmp[$i]'";
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
                    	<small>Empleados</small>
                    </h1>
                    
                </div>

            <div class="col-lg-12">
                <?php
                // SI HACEMOS CLICK EN ALTA
                if (isset($_POST["alta"])){
                    // FORMULARIO DE ALTA
            ?>

                <div class="form-group">
                <fieldset>
                    <legend><span>Alta de empleados</span></legend>
                    <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        
                        <label for="dniEmp">DNI </label><a name="dniEmp"></a>
                        <input class="form-control" tabindex="1" type="text" name="dniEmp" placeholder="DNI del Empleado" required>

                        <label for="seguridadSocial">Seguridad Social </label><a name="seguridadSocial"></a> 
                        <input class="form-control" tabindex="2" type="text" name="seguridadSocial" placeholder="Seguridad Social" required>

                        <label for="nombreEmp">Nombre </label><a name="nombreEmp"></a>
                        <input class="form-control" tabindex="3" type="text" name="nombreEmp" placeholder="Nombre del Empleado" required>

                        <label for="apellidosEmp">Apellidos </label><a name="apellidosEmp"></a>
                        <input class="form-control" tabindex="4" type="text" name="apellidosEmp" placeholder="Apellidos del Empleado" required>

                        <label for="emailEmp">Email </label><a name="emailEmp"></a><br>
                        <input class="form-control" tabindex="5" type="email" name="emailEmp" placeholder="email@ejemplo.com" required>

                        <label for="passEmp">Password </label><a name="passEmp"></a>
                        <input class="form-control" tabindex="6" type="text" name="passEmp" placeholder="Introduzca una contraseña" required>

                        <label for="direccionEmp">Dirección </label><a name="direccionEmp"></a>
                        <input class="form-control" tabindex="7" type="text" name="direccionEmp" placeholder="Dirección del Empleado" required>

                        <label for="salario">Salario </label><a name="salario"></a><br>
                        <input class="form-control" tabindex="8" type="number" name="salario" placeholder="Ej: 1200.00" required>

                        <label for="comision">Comision </label><a name="comision"></a><br>
                        <input class="form-control" tabindex="9" type="number" name="comision" placeholder="Ej: 20" required>

                        <label for="nombreDepEmp">Departamento </label><a name="nombreDepEmp"></a><br>
                        <input class="form-control" tabindex="10" type="text" name="nombreDepEmp" placeholder="Ej: DISENO" required>

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
							
							$sql = "SELECT DISTINCT dniEmp, seguridadSocial, nombreEmp, apellidosEmp, 
                            direccionEmp, GROUP_CONCAT(telefonoEmp), emailEmp, passEmp, salario, comision, nombreDepEmp 
                            FROM  tEmpleado, tEmpleado_Tf WHERE dniEmp = dniEmp_Tf
                            GROUP BY dniEmp";						
							$resultado = $mysqli -> query($sql);						
						?>
							<legend><span>Alta, baja y modificación de Empleados</span></legend> 

							<form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

								<table class="table-hover table-responsive table-striped">
									<tr><td colspan="6">Dar de alta un nuevo Empleado: </td></tr>
									<tr><td colspan="6"><button type="submit" name="alta" class="btn btn-default" />Alta</button></td></tr>
									<tr>
										<th>Seleccionar</th>
										<th>DNI</th>
										<th>Seguridad Social</th>
										<th>Nombre</th>
										<th>Apellidos</th>
                                        <th>Dirección</th>
                                        <th>Teléfonos</th>
										<th>Email</th>
										<th>PassWord</th>
										<th>Salario</th>
                                        <th>Comisión</th>
                                        <th>Departamento</th>
									</tr>
							<?php
								while ($fila = $resultado -> fetch_assoc()){
									echo '
									<tr>
										<td><input type="checkbox" name="seleccionar[]" class="form-control" value="' .$fila['dniEmp'] .'"/></td>
										<td><input type="text" name="dniEmp[]" class="form-control" value="' .$fila['dniEmp'] .'" readonly></td>
										<td><input type="text" name="seguridadSocial[]" class="form-control" value="' .$fila['seguridadSocial'] .'"></td>
										<td><input type="text" name="nombreEmp[]" class="form-control" value="' .$fila['nombreEmp'] .'"></td>
										<td><input type="text" name="apellidosEmp[]" class="form-control" value="' .$fila['apellidosEmp'] .'"></td>
                                        <td><input type="text" name="direccionEmp[]" class="form-control" value="' .$fila['direccionEmp'] .'"></td>
                                        <td><input type="text" name="telefonoEmp[]" class="form-control" value="' .$fila['GROUP_CONCAT(telefonoEmp)'] .'" readonly></td>
										<td><input type="email" name="emailEmp[]" class="form-control" value="' .$fila['emailEmp'] .'"></td>
                                        <td><input type="password" name="passEmp[]" class="form-control" value="' .$fila['passEmp'] .'"></td>
										<td><input type="number" name="salario[]" class="form-control" value="' .$fila['salario'] .'"></td>
                                        <td><input type="number" name="comision[]" class="form-control" value="' .$fila['comision'] .'"></td>
                                        <td><input type="text" name="nombreDepEmp[]" class="form-control" value="' .$fila['nombreDepEmp'] .'"></td>
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