<?php

    require_once "php/conectari.php";
        
    $mysqli = conectar();
    
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

        $mysqli->close();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Imprenta Hermanos Umpierrez.">
    <meta name="author" content="Imprenta Hermanos Umpierrez">

    <!-- CSS BootStrap -->
    <link rel='stylesheet' href='css/bootstrap.min.css' />
    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <title>Registro - Imprenta Hermanos Umpiérrez</title>
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
                        <a href="registro.php">Registro</a>
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

    <!-- IMAGEN HEADER -->
    <header>
    	<div class="container" align="center">
    		<img class="img img-responsive" src="imagenes/logo.jpg" width="1000px" height="520px"/>
    	</div>
    </header>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Registro
                    <small>Imprenta Hermanos Umpiérrez</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.html">Inicio</a>
                    </li>
                    <li class="active">Registro</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        <!-- Contact Form -->
        <!-- In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
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

                    <label for="imagenCl">Imagen (Opcional) </label><a name="imagenCl"></a><br>
                    <input class="form-control" tabindex="7" type="file" name="imagenCl">

                    <label for="cpCl">Código Postal </label><a name="cpCl"></a><br>
                    <input class="form-control" tabindex="8" type="text" name="cpCl" placeholder="Ej: 35600" required>

                    <label for="alta2"></label><a name="alta2"></a>
                    <button type="submit" name="alta2" class="btn btn-default"/>Alta</button>

                </form> 

            </fieldset>                     
            
        </div>
        

        
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

	<script src="js/jquery-1.12.4.min.js"></script>
    <script src='js/bootstrap.min.js'></script>
</body>

</html>