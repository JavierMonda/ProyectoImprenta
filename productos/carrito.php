<?php
    session_start();
    include "../php/conectari.php";
    $mysqli=conectar();
    if(isset($_SESSION['carrito'])) {
        if(isset($_GET['id'])) {
            $arreglo=$_SESSION['carrito'];
            $encontro=false;
            $numero=0;
            for($i=0;$i<count($arreglo);$i++) {
                if($arreglo[$i]['Id']==$_GET['id']) {
                    $encontro=true;
                    $numero=$i;
                }
            }
            if($encontro==true) {
                $arreglo[$numero]['Cantidad']=$arreglo[$numero]['Cantidad']+1;
                $_SESSION['carrito']=$arreglo;
            } else {
                $idProducto=0;
                $nombre="";
                $precio=0;
                $imagen="";
                $ide=$_GET['id'];
                $sql = "SELECT * FROM tProducto WHERE nombreProducto= '$ide';";
                
                $resultado=$mysqli->query($sql);
                if($resultado){
                    echo "Todo bien";
                } else {
                    echo "Algo va mal";
                }
                while($fila=$resultado->fetch_assoc()) {
                    $idProducto=$fila['idProducto'];
                    $nombre=$fila['nombreProducto'];
                    $precio=$fila['precio'];
                    $imagen=$fila['imagenProducto'];
                }
                $datosNuevos=array(
                    'Id'=>$_GET['id'],
                    'IdProducto'=>$idProducto,
                    'Nombre'=>$nombre,
                    'Precio'=>$precio,
                    'Imagen'=>$imagen,
                    'Cantidad'=>1);
                array_push($arreglo, $datosNuevos);
                $_SESSION['carrito']=$arreglo;
            }
        }
    } else {
        if(isset($_GET['id'])) {
            $idProducto=0;
            $nombre="";
            $precio=1;
            $imagen="";
            //$mysqli=conectar();
            $id=$_GET['id'];
            $sql = "SELECT * FROM tProducto WHERE nombreProducto= '$id';";
            
            $resultado=$mysqli->query($sql);
            if($resultado){
                    echo "Todo bien";
                } else {
                    echo "Algo va mal";
                }
            while($fila=$resultado->fetch_assoc()) {
                $idProducto=$fila['idProducto'];
                $nombre=$fila['nombreProducto'];
                $precio=$fila['precio'];
                $imagen=$fila['imagen'];
            }
            $arreglo[]=array(
                'Id'=>$_GET['id'],
                'IdProducto'=>$idProducto,
                'Nombre'=>$nombre,
                'Precio'=>$precio,
                'Imagen'=>$imagen,
                'Cantidad'=>1);
            $_SESSION['carrito']=$arreglo;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Productos,">
    <meta name="author" content="Imprenta Hermanos Umpiérrez">

    <title>Carrito de Compra</title>

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
                <h1 class="page-header">Carrito de Compra
                    <small>Productos</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="../index.html">Inicio</a>
                    </li>
                    <li class="active">Carrito de compra</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Related Projects Row -->
        <div class="row">

            <div class="col-lg-12">
                <h3 class="page-header">Detalles del carrito</h3>
            </div>

        <!-- CÓDIGO PHP -->
        <?php
            $total=0;
            if(isset($_SESSION['carrito'])) {
                $datos=$_SESSION['carrito'];

                $total=0;
                for($i=0;$i<count($datos);$i++) {
        ?>
                    <div class="producto">
                        <img src"../imagenes/productos/<?php echo $datos[$i]['Imagen'];?>"><br>
                        <span><?php echo $datos[$i]['Nombre'];?></span><br>
                        <span>Precio: <?php echo $datos[$i]['Precio'];?></span><br>
                        <span>Cantidad: 
                            <input class="cantidad" type="text" value="<?php echo $datos[$i]['Cantidad'];?>" 
                            data-precio="<?php echo $datos[$i]['Precio'];?>" 
                            data-id="<?php echo $datos[$i]['Id'];?>" 
                            >
                        </span><br>
                        <span class="subtotal">Subtotal: <?php echo $datos[$i]['Cantidad']*$datos[$i]['Precio'];?></span><br>
                    </div> 
        <?php   
                    $total=($datos[$i]['Cantidad']*$datos[$i]['Precio'])+$total;        
                }
            } else {
                echo "<h2>El carrito está vacío</h2>";
            }

            echo "<h2 id='total'>Total: ".$total."</h2>";
            if($total!=0) {
                echo '<form class="form" method="POST" action="./compras.php">';
                echo '<span><input type="text" name="cliente" value="DNI del cliente"></span>';
                echo '<button type="submit" name="aceptar" class="aceptar btn btn-default"/>Comprar</button>';
                echo '</form>';
            }

        ?>

            <div class="col-lg-12">
                <a href="./">Ver catálogo</a><br>
                <a href="../admin/vista/cerrarSesion.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </div>
            <div id="error" class="" role="alert">
            </div>

        </div>

        <hr>
        <?php
            //$mysqli=close();
        ?>

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
