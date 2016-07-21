<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Productos,">
    <meta name="author" content="Imprenta Hermanos Umpiérrez">

    <title>Últimas Compras</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="../js/jquery-1.12.4.min.js"></script>

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
                        <a href="#">Registro</a>
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
                <h1 class="page-header">Últimas Compras
                    <small>Productos</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../index.html">Inicio</a>
                    </li>
                    <li class="active">Últimas Compras</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Related Projects Row -->
        <div class="row">

            <div class="col-lg-12">
                <h3 class="page-header">Últimas Compras</h3>
            </div>
            <div class="container-fluid">
                <table class="table-hover table-responsive table-striped">
                    <tr>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                <?php
                    require_once "../php/conectari.php";
                    $mysqli=conectar();

                    $numeroPedido=0;
                    $sql = "SELECT * FROM tSolicita";    
                    $resultado=$mysqli->query($sql);

                    while($fila=$resultado->fetch_assoc()) {
                        if($numeroPedido != $fila['numeroPedido']) {
                            echo '<tr><td>Línea de producto: '.$fila['numeroPedido'].'</td></tr>';
                        }
                        $numeroPedido=$fila['numeroPedido'];
                        echo 
                            '<tr>
                                <td>' .$fila['dniCifSol'] .'</td>
                                <td>' .$fila['nombreProductoSol'] .'</td>
                                <td>' .$fila['precio'] .'</td>
                                <td>' .$fila['cantidad'] .'</td>
                                <td>' .$fila['subTotal'] .'</td>
                            </tr>';
                    }

                ?>
                </table>
        
        
            </div>
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
