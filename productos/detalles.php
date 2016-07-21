<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Productos,">
    <meta name="author" content="Imprenta Hermanos Umpiérrez">

    <title>Detalles</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="../js/jquery-1.12.4.min.js"></script>

    <!-- JavaScript -->
    <script src="../js/scripts.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

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
                        <a href="../registro.php">Registro</a>
                    </li>
                    <li>
                        <a href="#">Login</a>
                    </li>
                    <li>
                        <a href="../contacto.html">Contacto</a>
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
                <h1 class="page-header">Detalles
                    <small>Productos</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../index.html">Inicio</a>
                    </li>
                    <li class="active">detalles</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Related Projects Row -->
        <div class="row">

            <div class="col-lg-12">
                <h3 class="page-header">Detalles del producto</h3>
            </div>

        <!-- CÓDIGO PHP -->
        <?php

            include "../php/conectari.php";

            $mysqli = conectar();
            $id=$_GET['id'];

            $sql = "SELECT * FROM tProducto WHERE nombreProducto= '$id'";

            $resultado = $mysqli->query($sql);

            if (!$mysqli->query($sql)) {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }

            while($fila = $resultado -> fetch_assoc()) {
        ?>
            
                
                <img class="img-responsive img-hover img-related" width="300px" height="100px" 
                src="../imagenes/productos/<?php echo $fila['imagenProducto'];?>">
                <span><?php echo $fila['nombreProducto'];?></span><br>
                <span>Precio: <?php echo $fila['precio'];?></span><br>
                <a href="./carrito.php?id=<?php echo $fila['nombreProducto'];?>">Añadir al carrito</a>
            

        <?php
            }

        ?>

        </div>

        <div id="error" class="" role="alert">
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

    

</body>

</html>
