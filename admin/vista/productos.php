<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administración - Productos</title>

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

            $sql = "SELECT * FROM tProducto";
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                
                $dom = new DOMDocument('1.0','utf-8');
                 // Se define el elemento
                 $productos = $dom->createElement("productos");
                 // Se crea el nodo del elemento
                 $dom->appendChild($productos);

                 while ($fila = $resultado->fetch_assoc()) {
                     $idProducto = $dom->createElement("idProducto");
                     $productos->appendChild($idProducto);
                     $idProducto = $dom->createTextNode($fila['idProducto']);
                     $productos->appendChild($idProducto);

                     $nombreProducto = $dom->createElement("nombreProducto");
                     $productos->appendChild($nombreProducto);
                     $nombreProducto = $dom->createTextNode($fila['nombreProducto']);
                     $productos->appendChild($nombreProducto);

                     $imagenProducto = $dom->createElement("imagenProducto");
                     $productos->appendChild($imagenProducto);
                     $imagenProducto = $dom->createTextNode($fila['imagenProducto']);
                     $productos->appendChild($imagenProducto);

                     $precio = $dom->createElement("precio");
                     $productos->appendChild($precio);
                     $precio = $dom->createTextNode($fila['precio']);
                     $productos->appendChild($precio);
                }
                //header("content-type: text/xml");
                echo $dom->saveXML();
                //Finalmente, guardarlo en una ubicación
                $dom->save('../informes/productos.xml');

            } //CIERRE IF

        } //CIERRE ISSET GENERARXML

        // SI PULSAMOS GENERAR
        if (isset($_POST["generar"])) {
            $cabecera = "<span><img src='../../imagenes/logo.jpg' width='200px' height='100px'/><b>Informe PDF</b></span>";
            $pie = "<span>Tabla Productos. Imprenta Hermanos Umpierrez</span>";
            $mpdf=new mPDF();
            $style=file_get_contents('../css/tabla.css');
            $mpdf->WriteHTML($style, 1);
            $mpdf->SetHTMLHeader($cabecera);
            $mpdf->SetHTMLFooter($pie);

            $sql = "SELECT * FROM  tProducto";                       
            $resultado = $mysqli -> query($sql);

            $mpdf->WriteHTML('<table class="table-hover table-responsive table-striped">
                <tr>
                    <th>Id Producto</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Impresion</th>
                    <th>Acabado</th>
                    <th>Tipo de Papel</th>
                    <th>Tamaño</th>
                </tr>',2);
            while ($fila = $resultado -> fetch_assoc()){

                $mpdf->WriteHTML('<tr>
                                <td>' .$fila['idProducto'] .'</td>
                                <td>' .$fila['nombreProducto'] .'</td>
                                <td>' .$fila['imagenProducto'] .'</td>
                                <td>' .$fila['precio'] .'</td>
                                <td>' .$fila['descripcion'] .'</td>
                                <td>' .$fila['impresion'] .'</td>
                                <td>' .$fila['acabado'] .'</td>
                                <td>' .$fila['tipoPapel'] .'</td>
                                <td>' .$fila['tamanoProducto'] .'</td>
                            </tr>', 2);
            }
            $mpdf->WriteHTML('</table>',2);             
            $mpdf->Output('productos.pdf','I');
            exit;

        } // CIERRE DE IF GENERAR
		

		// SI HACEMOS CLICK EN ALTA 2
		if (isset($_POST["alta2"])){
			$seleccionar = $_POST["seleccionar"];
            $idProducto = $_POST["idProducto"];
			$nombreProducto = $_POST["nombreProducto"];
            $precio = $_POST["precio"];
            $descripcion = $_POST["descripcion"];
            $impresion = $_POST["impresion"];
            $acabado = $_POST["acabado"];
            $tipoPapel = $_POST["tipoPapel"];
            $tamanoProducto = $_POST["tamanoProducto"];

            //Comprobamos si el archivo fue subido OK mediante HTTP POST
            $nombreCompleto=NULL;
            if (is_uploaded_file ($_FILES['imagenProducto']['tmp_name'])) {
                    $nombreCompleto = "../../imagenes/productos/". $_FILES['imagenProducto']['name'];
                    //si el fichero ya existe, debemos cambiarle el nombre
                    if (is_file($nombreCompleto)) {
                    // para conseguir un nombre único, especificamos el tiempo
                        $nombreCompleto = "../../imagenes/productos/". "-" . time() . "-" . $_FILES['imagenProducto']['name'];
                    }
                    
                    //y finalmente movemos el fichero a la ubicación indicada
                    move_uploaded_file ($_FILES['imagenProducto']['tmp_name'], $nombreCompleto);
                    
            } 
            if ($_FILES['imagenProducto']['error']!=0)
                echo "Error de subida del fichero".$_FILES['imagenProducto']['error'];

			//Se describe la inserción de datos en SQL
			$sql = "INSERT INTO tProducto(nombreProducto,imagenProducto,precio,descripcion,impresion,
            acabado,tipoPapel,tamanoProducto) 
            VALUES ('$nombreProducto','$nombreCompleto',$precio,'$descripcion','$impresion',
            '$acabado','$tipoPapel','$tamanoProducto');";
			
			if ($mysqli->query($sql)) {
				echo "Se ha insertado con éxito";
			} else {
				echo "Error: " .$sql ."<br>" .$mysqli->error;
			}
		} // CIERRE IF ALTA 2

		// SI HACEMOS CLICK EN GUARDAR
		if (isset($_POST["guardar"]) && (isset($_POST["seleccionar"]))) {
			$seleccionar = $_POST["seleccionar"];
            $idProducto = $_POST["idProducto"];
			$nombreProducto = $_POST["nombreProducto"];
            $precio = $_POST["precio"];
            $descripcion = $_POST["descripcion"];
            $impresion = $_POST["impresion"];
            $acabado = $_POST["acabado"];
            $tipoPapel = $_POST["tipoPapel"];
            $tamanoProducto = $_POST["tamanoProducto"];
            $oldfile = $_POST["oldfile"];
							
			for ($i=0;$i < count($idProducto);$i++) {
			   	$nombreProducto[$i] = test_input($nombreProducto[$i]);
                $precio[$i] = test_input($precio[$i]);
                $descripcion[$i] = test_input($descripcion[$i]);
                $impresion[$i] = test_input($impresion[$i]);
                $acabado[$i] = test_input($acabado[$i]);
                $tipoPapel[$i] = test_input($tipoPapel[$i]);
                $tamanoProducto[$i] = test_input($tamanoProducto[$i]);
    			  
    			$j = 0;
    			$sql = ""; 
    			while ($j < count($seleccionar)) { 
    				if ($seleccionar[$j ++] == $idProducto[$i]){
                        //Comprobamos si el archivo fue subido OK mediante HTTP POST
                        $nombreCompleto=$oldfile[$i];
                        if (is_uploaded_file ($_FILES['imagenProducto']['tmp_name'][$i])) {
                            $nombreCompleto = "../../imagenes/productos/" .$_FILES['imagenProducto']['name'][$i];
                            //si el fichero ya existe, debemos cambiarle el nombre
                            if (is_file($nombreCompleto)) {
                            // para conseguir un nombre único, especificamos el tiempo
                                $nombreCompleto = "../../imagenes/productos/" .time() ."-" .$_FILES['imagenProducto']['name'][$i];
                            }   
                            //y finalmente movemos el fichero a la ubicación indicada
                            move_uploaded_file ($_FILES['imagenProducto']['tmp_name'][$i], $nombreCompleto);

                            if (($oldfile[$i] != $nombreCompleto) && ($oldfile[$i] != "")) {
                                unlink($oldfile[$i]);
                            }
                        
                        }
                        if (!$_FILES['imagenProducto']['error'])
                            echo "Error de subida del fichero";


        				$sql = "UPDATE tProducto SET nombreProducto= '$nombreProducto[$i]', imagenProducto= '$nombreCompleto', precio= $precio[$i], descripcion = '$descripcion[$i]',
                        impresion= '$impresion[$i]', acabado= '$acabado[$i]', tipoPapel= '$tipoPapel[$i]',
                        tamanoProducto= '$tamanoProducto[$i]'  
        				WHERE idProducto=$idProducto[$i]";
    					if ($mysqli->query($sql)){
                			echo "Registro " .$nombreProducto[$i] ." modificado satisfactoriamente";
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
			$idProducto = $_POST["idProducto"];
			$nombreProducto = $_POST["nombreProducto"];
			$precio = $_POST["precio"];
			$oldfile = $_POST["oldfile"];
			

			for ($i=0;$i < count($idProducto);$i++) {
			   	$nombreProducto[$i] = test_input($nombreProducto[$i]);
    			$precio[$i] = test_input($precio[$i]);
    			
    			  
    			$j = 0;
    			$sql = "";       			
        		while ($j < count($seleccionar)){
            		if ($seleccionar[$j ++] == $idProducto[$i]){
                        //borra el fichero anterior
                        if ($oldfile[$i]!="")
                        unlink($oldfile[$i]);
                		$sql = "DELETE FROM tProducto WHERE idProducto= $idProducto[$i]";
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
                    	<small>Productos</small>
                    </h1>
                    
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-12">

                	<!-- FORMULARIO -->
					
					<div class="form-group">

					<?php 

                        // SI HACEMOS CLICK EN ALTA
                        if (isset($_POST["alta"])){
                        // FORMULARIO DE ALTA
                    ?>
                        <div class="form-group">
                            <fieldset>
                                <legend><span>Alta de productos</span></legend>
                                <form class="form" method="POST" enctype="multipart/form-data" 
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                                    <label for="nombreProducto">Nombre </label><a name="nombreProducto"></a> 
                                    <input class="form-control" tabindex="2" type="text" name="nombreProducto" placeholder="Nombre del Producto" required>

                                    <label for="imagenProducto">Imagen </label><a name="imagenProducto"></a>
                                    <input class="form-control" tabindex="3" type="file" name="imagenProducto" placeholder="Imagen del Producto" required>

                                    <label for="precio">Precio </label><a name="precio"></a>
                                    <input class="form-control" tabindex="4" type="number" step="any" name="precio" placeholder="Precio del Producto" required>

                                    <label for="descripcion">Descripción </label><a name="descripcion"></a>
                                    <input class="form-control" tabindex="5" type="text" name="descripcion" placeholder="Descripción del Producto">

                                    <label for="impresion">Impresión </label><a name="impresion"></a>
                                    <select name="impresion" class="form-control" required>
                                                <optgroup label="Tipo de Impresión">
                                                    <option selected>color1Cara</option>
                                                    <option>color2Caras</option>
                                                    <option>bn1Cara</option>
                                                    <option>bn2Caras</option>
                                                    <option>1Tinta</option>
                                                    <option>2Tintas</option>
                                                </optgroup>
                                            </select>

                                    <label for="acabado">Acabado </label><a name="acabado"></a>
                                    <select name="acabado" class="form-control" required>
                                                <optgroup label="Acabado">
                                                    <option selected>conSolapa</option>
                                                    <option>sinSolapa</option>
                                                    <option>pegado</option>
                                                    <option>matriz</option>
                                                </optgroup>
                                            </select>

                                    <label for="tipoPapel">Tipo de Papel </label><a name="tipoPapel"></a>
                                    <select name="tipoPapel" class="form-control" required>
                                                <optgroup label="Tipo de Papel">
                                                    <option selected>115GrBrillo</option>
                                                    <option>300GrBrillo</option>
                                                    <option>cartulina</option>
                                                    <option>mate</option>
                                                    <option>80GrComun</option>
                                                </optgroup>
                                            </select>

                                    <label for="tamanoProducto">Tamaño del Producto </label><a name="tamanoProducto"></a>
                                    <select name="tamanoProducto" class="form-control" required>
                                                <optgroup label="Tamaño del Producto">
                                                    <option selected>a3</option>
                                                    <option>a4</option>
                                                    <option>a5</option>
                                                    <option>a6</option>
                                                    <option>85x85</option>
                                                </optgroup>
                                            </select>




                                    <label for="alta2"></label><a name="alta2"></a>
                                    <button type="submit" name="alta2" class="btn btn-default"/>Alta</button>

                                </form> 

                            </fieldset>                     
                            
                        </div>

                            <?php 
                                } // CIERRE IF ALTA
                                        
							// LANZAMOS LA CONSULTA DE TODOS LOS DATOS DE LA TABLA MANUALES
							// PARA MOSTRARLOS EN EL FORMULARIO
							
							$sql = "SELECT * FROM  tProducto";						
							$resultado = $mysqli -> query($sql);						
						?>
                        <fieldset>
							<legend><span>Alta, baja y modificación de Productos</span></legend> 

							<form class="form" method="POST" enctype="multipart/form-data" 
                            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

								<table class="table-hover table-responsive table-striped">
									<tr><td colspan="6">Dar de alta un nuevo Producto: </td></tr>
									<tr><td colspan="6"><button type="submit" name="alta" class="btn btn-default" />Alta</button></td></tr>
									<tr>
										<th>Seleccionar</th>
										<th>Id Producto</th>
										<th>Nombre</th>
										<th>Imagen</th>
										<th>Precio</th>
                                        <th>Descripción</th>
                                        <th>Impresión</th>
                                        <th>Acabado</th>
                                        <th>Tipo de Papel</th>
                                        <th>Tamaño</th>
									</tr>
							<?php
								while ($fila = $resultado -> fetch_assoc()){
									echo '
									<tr>
										<td><input type="checkbox" name="seleccionar[]" class="form-control" value="' .$fila['idProducto'] .'"/></td>
										<td><input type="number" name="idProducto[]" class="form-control" value="' .$fila['idProducto'] .'" readonly></td>
										<td><input type="text" name="nombreProducto[]" class="form-control" value="' .$fila['nombreProducto'] .'"></td>
										<td>
                                            <img class="img-responsive" width="50px" height="50px" src="' .$fila['imagenProducto'] .'"/>
                                            <p>'.$fila['imagenProducto'].'</p>
                                            <input type="hidden" name="oldfile[]" class="form-control" value="' .$fila['imagenProducto'] .'">
                                            <input type="file" name="imagenProducto[]" class="form-control">
                                        </td>
										<td><input type="number" step="any" name="precio[]" class="form-control" value="' .$fila['precio'] .'"></td>
                                        <td><input type="descripcion" name="descripcion[]" class="form-control" value="' .$fila['descripcion'] .'"></td>
                                        <td>
                                            <select name="impresion[]" class="form-control">
                                                <optgroup label="Tipo de Impresión">
                                                    <option selected>' .$fila['impresion'] .'</option>
                                                    <option>color1Cara</option>
                                                    <option>color2Caras</option>
                                                    <option>bn1Cara</option>
                                                    <option>bn2Caras</option>
                                                    <option>1Tinta</option>
                                                    <option>2Tintas</option>
                                                </optgroup>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="acabado[]" class="form-control">
                                                <optgroup label="Acabado">
                                                    <option selected>' .$fila['acabado'] .'</option>
                                                    <option>conSolapa</option>
                                                    <option>sinSolapa</option>
                                                    <option>pegado</option>
                                                    <option>matriz</option>
                                                </optgroup>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="tipoPapel[]" class="form-control">
                                                <optgroup label="Tipo de Papel">
                                                    <option selected>' .$fila['tipoPapel'] .'</option>
                                                    <option>115GrBrillo</option>
                                                    <option>300GrBrillo</option>
                                                    <option>cartulina</option>
                                                    <option>mate</option>
                                                    <option>80GrComun</option>
                                                </optgroup>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="tamanoProducto[]" class="form-control">
                                                <optgroup label="Tamaño del Producto">
                                                    <option selected>' .$fila['tamanoProducto'] .'</option>
                                                    <option>a3</option>
                                                    <option>a4</option>
                                                    <option>a5</option>
                                                    <option>a6</option>
                                                    <option>85x85</option>
                                                </optgroup>
                                            </select>
                                        </td>
									<tr>';
									
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

    <!-- JavaScript -->
    <script src="../js/scripts.js"></script>

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