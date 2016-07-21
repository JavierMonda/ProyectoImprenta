<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administración - Clientes</title>

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
		
        require_once "../mpdf/mpdf.php";
		require_once "../../php/conectari.php";
		
		$mysqli = conectar();

        // SI PULSAMOS EL BOTON GENERAR XML
        if (isset($_POST["generarxml"])) {

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

                     $cpCl = $dom->createElement("cpCl");
                     $clientes->appendChild($cpCl);
                     $elemento = $dom->createTextNode($fila['cpCl']);
                     $clientes->appendChild($cpCl);
                }
                //header("content-type: text/xml");
                echo $dom->saveXML();
                //Finalmente, guardarlo en una ubicación
                $dom->save('../informes/clientes.xml');

            } //CIERRE IF

        } //CIERRE ISSET GENERARXML

        // SI PULSAMOS GENERAR
        if (isset($_POST["generar"])) {
            $cabecera = "<span><img src='../../imagenes/logo.jpg' width='200px' height='100px'/><b>Informe PDF</b></span>";
            $pie = "<span>Tabla Clientes. Imprenta Hermanos Umpierrez</span>";
            $mpdf=new mPDF();
            $style=file_get_contents('../css/tabla.css');
            $mpdf->WriteHTML($style, 1);
            $mpdf->SetHTMLHeader($cabecera);
            $mpdf->SetHTMLFooter($pie);

            $sql = "SELECT * FROM  tCliente";                       
            $resultado = $mysqli -> query($sql);

            $mpdf->WriteHTML('<table class="table-hover table-responsive table-striped">
                <tr>
                    <th>DNI o CIF</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Direccion</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Imagen</th>
                    <th>Codigo Postal</th>
                </tr>',2);
            while ($fila = $resultado -> fetch_assoc()){

                $mpdf->WriteHTML('<tr>
                                <td>' .$fila['dniCif'] .'</td>
                                <td>' .$fila['nombreCl'] .'</td>
                                <td>' .$fila['apellidosCl'] .'</td>
                                <td>' .$fila['direccionCl'] .'</td>
                                <td>' .$fila['emailCl'] .'</td>
                                <td>' .$fila['passCl'] .'</td>
                                <td><p>'.$fila['imagenCl'].'</p></td>
                                <td>' .$fila['cpCl'] .'</td>
                            </tr>', 2);
            }
            $mpdf->WriteHTML('</table>',2);             
            $mpdf->Output('archivo.pdf','I');
            exit;

        } // CIERRE DE IF GENERAR
		

		// SI HACEMOS CLICK EN ALTA 2
		if (isset($_POST["alta2"])){
			$seleccionar = $_POST["seleccionar"];
			$dniCif = $_POST["dniCif"];
			$nombreCl = $_POST["nombreCl"];
			$apellidosCl = $_POST["apellidosCl"];
			$direccionCl = $_POST["direccionCl"];
			$passCl = $_POST["passCl"];
			$emailCl = $_POST["emailCl"];
			$cpCl = $_POST["cpCl"];

            //Comprobamos si el archivo fue subido OK mediante HTTP POST
            $nombreCompleto=NULL;
            if (is_uploaded_file ($_FILES['imagenCl']['tmp_name'])) {
                    $nombreCompleto = "../imagenes/clientes/". $_FILES['imagenCl']['name'];
                    //si el fichero ya existe, debemos cambiarle el nombre
                    if (is_file($nombreCompleto)) {
                    // para conseguir un nombre único, especificamos el tiempo
                        $nombreCompleto = "../imagenes/clientes/". "-" . time() . "-" . $_FILES['imagenCl']['name'];
                    }
                    
                    //y finalmente movemos el fichero a la ubicación indicada
                    move_uploaded_file ($_FILES['imagenCl']['tmp_name'], $nombreCompleto);
                    
            } 
            if ($_FILES['imagen']['error']!=0)
                echo "Error de subida del fichero".$_FILES['imagenCl']['error'];


			//Se describe la inserción de datos en SQL
			$sql = "INSERT INTO tCliente VALUES ('$dniCif','$nombreCl','$apellidosCl','$direccionCl',
            '$emailCl','$passCl','$nombreCompleto','$cpCl');";
			
			if ($mysqli->query($sql)) {
				echo "Se ha insertado con éxito";
			} else {
				echo "Error: " .$sql ."<br>" .$mysqli->error;
			}
		} // CIERRE IF ALTA 2

		// SI HACEMOS CLICK EN GUARDAR
		if (isset($_POST["guardar"]) && (isset($_POST["seleccionar"]))) {
			$seleccionar = $_POST["seleccionar"];
			$dniCif = $_POST["dniCif"];
			$nombreCl = $_POST["nombreCl"];
			$apellidosCl = $_POST["apellidosCl"];
			$direccionCl = $_POST["direccionCl"];
			$passCl = $_POST["passCl"];
			$emailCl = $_POST["emailCl"];
			$cpCl = $_POST["cpCl"];
            $oldfile = $_POST["oldfile"];
							
			for ($i=0;$i < count($dniCif);$i++) {
			   	$nombreCl[$i] = test_input($nombreCl[$i]);
    			$apellidosCl[$i] = test_input($apellidosCl[$i]);
    			$direccionCl[$i] = test_input($direccionCl[$i]);
    			$passCl[$i] = test_input($passCl[$i]);
    			$emailCl[$i] = test_input($emailCl[$i]);
    			$cpCl[$i] = test_input($cpCl[$i]);
    			  
    			$j = 0;
    			$sql = ""; 
    			while ($j < count($seleccionar)) { 
    				if ($seleccionar[$j ++] == $dniCif[$i]){
                        //Comprobamos si el archivo fue subido OK mediante HTTP POST
                        $nombreCompleto=$oldfile[$i];
                        if (is_uploaded_file ($_FILES['imagenCl']['tmp_name'][$i])) {
                            $nombreCompleto = "../imagenes/clientes/" .$_FILES['imagenCl']['name'][$i];
                            //si el fichero ya existe, debemos cambiarle el nombre
                            if (is_file($nombreCompleto)) {
                            // para conseguir un nombre único, especificamos el tiempo
                                $nombreCompleto = "../imagenes/clientes/" .time() ."-" .$_FILES['imagenCl']['name'][$i];
                            }   
                            //y finalmente movemos el fichero a la ubicación indicada
                            move_uploaded_file ($_FILES['imagenCl']['tmp_name'][$i], $nombreCompleto);

                            if (($oldfile[$i] != $nombreCompleto) && ($oldfile[$i] != "")) {
                                unlink($oldfile[$i]);
                            }
                        
                        }
                        if (!$_FILES['imagenCl']['error'])
                            echo "Error de subida del fichero";

        				$sql = "UPDATE tCliente SET nombreCl= '$nombreCl[$i]', 
        				apellidosCl= '$apellidosCl[$i]', direccionCl= '$direccionCl[$i]', 
        				emailCl= '$emailCl[$i]',passCl= '$passCl[$i]', imagenCl= '$nombreCompleto', cpCl= '$cpCl[$i]' 
        				WHERE dniCif='$dniCif[$i]'";
    					if ($mysqli->query($sql)){
                			echo "Registro " .$dniCif[$i] ." modificado satisfactoriamente";
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
			$dniCif = $_POST["dniCif"];
			$nombreCl = $_POST["nombreCl"];
			$apellidosCl = $_POST["apellidosCl"];
			$direccionCl = $_POST["direccionCl"];
			$emailCl = $_POST["emailCl"];
            $passCl = $_POST["passCl"];
            $oldfile = $_POST["oldfile"];
			$cpCl = $_POST["cpCl"];

			for ($i=0;$i < count($dniCif);$i++) {
			   	$nombreCl[$i] = test_input($nombreCl[$i]);
    			$apellidosCl[$i] = test_input($apellidosCl[$i]);
    			$direccionCl[$i] = test_input($direccionCl[$i]);
    			$emailCl[$i] = test_input($emailCl[$i]);
                $passCl[$i] = test_input($passCl[$i]);
    			$cpCl[$i] = test_input($cpCl[$i]);
    			  
    			$j = 0;
    			$sql = "";       			
        		while ($j < count($seleccionar)){
            		if ($seleccionar[$j ++] == $dniCif[$i]){
                        //borra el fichero anterior
                        if ($oldfile[$i]!="")
                        unlink($oldfile[$i]);

                		$sql = "DELETE FROM tCliente WHERE dniCif='$dniCif[$i]'";
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
                            <a href="pedidos.php"><i class="fa fa-edit fa-fw"></i> Tabla tSolicita</a>
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
                    	<small>Clientes</small>
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
                                    <legend><span>Alta de clientes</span></legend>
                                    <form class="form" method="POST" enctype="multipart/form-data"
                                     action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                        
                                        <label for="dniCif">DNI/CIF </label><a name="dniCif"></a>
                                        <input class="form-control" tabindex="1" type="text" name="dniCif" placeholder="DNI o CIF del Cliente" required>

                                        <label for="nombreCl">Nombre </label><a name="nombreCl"></a> 
                                        <input class="form-control" tabindex="2" type="text" name="nombreCl" placeholder="Nombre del Cliente" required>

                                        <label for="apellidosCl">Apellidos </label><a name="apellidosCl"></a>
                                        <input class="form-control" tabindex="3" type="text" name="apellidosCl" placeholder="Apellidos del Cliente" required>

                                        <label for="direccionCl">Dirección </label><a name="direccionCl"></a>
                                        <input class="form-control" tabindex="4" type="text" name="direccionCl" placeholder="Dirección del Cliente" required>

                                        <label for="emailCl">Email </label><a name="emailCl"></a>
                                        <input class="form-control" tabindex="5" type="email" name="emailCl" placeholder="email@ejemplo.com" required>

                                        <label for="passCl">Password </label><a name="passCl"></a><br>
                                        <input class="form-control" tabindex="6" type="password" name="passCl" placeholder="Introduce una contraseña" required>

                                        <label for="imagenCl">Imagen </label><a name="imagenCl"></a><br>
                                        <input class="form-control" tabindex="7" type="file" name="imagenCl">

                                        <label for="cpCl">Código Postal </label><a name="cpCl"></a><br>
                                        <input class="form-control" tabindex="8" type="text" name="cpCl" placeholder="Ej: 35600" required>

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
							
							$sql = "SELECT DISTINCT dniCif, nombreCl, apellidosCl, direccionCl,  
                            emailCl, passCl, GROUP_CONCAT(telefonoCl), imagenCl, cpCl 
                            FROM  tCliente, tCliente_Tf WHERE dniCif = dniCif_Tf
                            GROUP BY dniCif";						
							$resultado = $mysqli -> query($sql);						
						?>
							<legend><span>Alta, baja y modificación de Clientes</span></legend> 

							<form class="form" method="POST" enctype="multipart/form-data" 
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

								<table class="table-hover table-responsive table-striped">
									<tr><td colspan="6">Dar de alta un nuevo Cliente: </td></tr>
									<tr><td colspan="6"><button type="submit" name="alta" class="btn btn-default" />Alta</button></td></tr>
									<tr>
										<th>Seleccionar</th>
										<th>DNI/CIF</th>
										<th>Nombre</th>
										<th>Apellidos</th>
										<th>Dirección</th>
										<th>Email</th>
										<th>Password</th>
                                        <th>Teléfonos</th>
                                        <th>Imagen</th>
										<th>C.P.</th>
									</tr>
							<?php
								while ($fila = $resultado -> fetch_assoc()){
									echo '
									<tr>
										<td><input type="checkbox" name="seleccionar[]" class="form-control" value="' .$fila['dniCif'] .'"/></td>
										<td><input type="text" name="dniCif[]" class="form-control" value="' .$fila['dniCif'] .'" readonly></td>
										<td><input type="text" name="nombreCl[]" class="form-control" value="' .$fila['nombreCl'] .'"></td>
										<td><input type="text" name="apellidosCl[]" class="form-control" value="' .$fila['apellidosCl'] .'"></td>
										<td><input type="text" name="direccionCl[]" class="form-control" value="' .$fila['direccionCl'] .'"></td>
										<td><input type="email" name="emailCl[]" class="form-control" value="' .$fila['emailCl'] .'"></td>
										<td><input type="password" name="passCl[]" class="form-control" value="' .$fila['passCl'] .'"></td>
                                        <td><input type="text" name="telefonoCl[]" class="form-control" value="' .$fila['GROUP_CONCAT(telefonoCl)'] .'" readonly></td>
                                        <td>
                                            <img class="img-responsive" width="50px" height="50px" src="' .$fila['imagenCl'] .'"/>
                                            <p>'.$fila['imagenCl'].'</p>
                                            <input type="hidden" name="oldfile[]" class="form-control" value="' .$fila['imagenCl'] .'">
                                            <input type="file" name="imagenCl[]" class="form-control">
                                        </td>
										<td><input type="text" name="cpCl[]" class="form-control" value="' .$fila['cpCl'] .'"></td>
									</tr>';
									
								}
								echo '<tr><td colspan="2"><button type="submit" name="guardar" class="btn btn-default"/>Modificar</button></td>';
								echo '<td colspan="2"><button type="submit" name="eliminar" class="btn btn-default"/>Eliminar</button></td>';
								echo '<td colspan="2"><button type="submit" class="btn btn-default" name="generar"/>Generar PDF</button></td>';
								echo '<td><a href="../informes/clientes.php">
                                        <button type="submit" name="generarxml" class="btn btn-default"/>Generar XML</button>
                                    </a></td></tr>';

								
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