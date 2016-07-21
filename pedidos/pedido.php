<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pedido">
    <meta name="author" content="Imprenta Hermanos Umpiérrez">

    <title>Pedido</title>

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
                        <a href="../registro.php">Registro</a>
                    </li>
                    <!--
                    <li>
                        <a href="services.html">Login</a>
                    </li>
                    -->
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

        <!-- ELECCIÓN DE FORMULARIO SEGÚN PRODUCTO -->
        <div class="form-group">
            <form action="index.php" method="post">
                Elija un producto: 
                <select id="status" name="status" onChange="mostrar(this.value);">
                    <option selected>Despliegue para ver los productos</option>
                    <option value="tarjeta">Tarjetas de Visita</option>
                    <option value="flyer">Flyers</option>
                    <option value="triptico">Trípticos</option>
                    <option value="cartel">Carteles</option>
                    <option value="carpeta">Carpetas</option>
                    <option value="talon">Talones</option>
                 </select>
            </form>
        </div>

        <!-- FORMULARIO DE TARJETAS DE VISITA -->
        <div id="tarjeta" class="row" style="display: none;">
            <div class="col-md-6">
                <img class="img-responsive img-portfolio img-hover" 
                src="http://placehold.it/545x522" alt="Tarjetas de Visita" 
                width="345px" height="250px">
                <h3>Detalles del Producto</h3>
                <p>Aquí los detalles del producto: <br>
                Información del producto, características...
                </p>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <fieldset>
                        <legend><span>Pedido de Tarjetas de Visita</span></legend>
                        <form class="form" method="POST" enctype="multipart/form-data"
                         action="../php/procesadoPedido.php">

                            <label for="emailCl">Email del cliente* </label><a name="emailCl"></a><br>
                            <input class="form-control" tabindex="1" type="email" name="emailCl" placeholder="Introduce un Email de cliente" required>

                            <label for="passCl">Password* </label><a name="passCl"></a><br>
                            <input class="form-control" tabindex="2" type="password" name="passCl" placeholder="Contraseña del cliente" required>
                            
                            <label for="impresion">Impresion* </label><a name="impresion"></a>
                                <select name="impresion" class="form-control" required>
                                        <option value="color1Cara" selected>Color 1 Cara</option>
                                        <option value="color1Cara">Color 2 Caras</option>
                                        <option value="color1Cara">Blanco/Negro 1 Cara</option>
                                        <option value="color1Cara">Blanco/Negro 2 Caras</option>                           
                                </select>

                            <label for="acabado">Acabado* </label><a name="acabado"></a>
                                <select name="acabado" class="form-control" required>
                                        <option value="sinSolapa" selected>Normal</option>                           
                                </select>

                            <label for="tipoPapel">Tipo de Papel* </label><a name="tipoPapel"></a>
                                <select name="tipoPapel" class="form-control" required>
                                        <option value="300GrBrillo" selected>300 Gr Brillo</option>
                                        <option value="80GrComun">80 Gr Común</option>                           
                                </select>

                            <label for="tamanoProducto">Tamaño* </label><a name="tamanoProducto"></a>
                                <select name="tamanoProducto" class="form-control" required>
                                        <option value="85x85" selected>85x85</option>                           
                                </select> 
                
                            <label for="cantidad">Cantidad* </label><a name="cantidad"></a>
                                <select id="cantidad" name="cantidad" class="form-control" required>
                                        <option value="100">100 (10€)</option> 
                                        <option value="500">500 (20€)</option>
                                        <option value="1000">1000 (35€)</option>
                                        <option value="2000" selected>2000 (50€)</option>                          
                                </select>

                            <label for="pago">Pago* </label><a name="pago"></a>
                                <select name="pago" class="form-control" required>
                                        <option value="tienda" selected>En tienda</option> 
                                        <option value="entrega">Con la entrega</option>                          
                                </select>

                            <label for="envio">Envio* </label><a name="envio"></a>
                                <select name="envio" class="form-control" required>
                                        <option value="recogida" selected>Recogida en tienda</option>
                                        <option value="domicilio">Envio al domicilio</option>                           
                                </select> 

                            <label for="compraTarjeta"></label><a name="compraTarjeta"></a>
                            <button type="submit" name="compraTarjeta" class="btn btn-default"/>Comprar</button>

                        </form> 

                    </fieldset>                     
                    
                </div>
            </div>
        </div>

        <!-- FORMULARIO DE FLYERS -->
        <div id="flyer" class="row" style="display: none;">
            <div class="col-md-6">
                <img class="img-responsive img-portfolio img-hover" 
                src="http://placehold.it/545x522" alt="Tarjetas de Visita" 
                width="345px" height="250px">
                <h3>Detalles del Producto</h3>
                <p>Aquí los detalles del producto: <br>
                Información del producto, características...
                </p>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <fieldset>
                        <legend><span>Pedido de Flyers</span></legend>
                        <form class="form" method="POST" enctype="multipart/form-data"
                         action="../php/procesadoPedido.php">

                            <label for="emailCl">Email del cliente* </label><a name="emailCl"></a><br>
                            <input class="form-control" tabindex="1" type="email" name="emailCl" placeholder="Introduce un Email de cliente" required>

                            <label for="passCl">Password* </label><a name="passCl"></a><br>
                            <input class="form-control" tabindex="2" type="password" name="passCl" placeholder="Contraseña del cliente" required>
                            
                            <label for="impresion">Impresion* </label><a name="impresion"></a>
                                <select name="impresion" class="form-control" required>
                                        <option value="color1Cara" selected>Color 1 Cara</option>
                                        <option value="color1Cara">Color 2 Caras</option>
                                        <option value="color1Cara">Blanco/Negro 1 Cara</option>
                                        <option value="color1Cara">Blanco/Negro 2 Caras</option>                           
                                </select>

                            <label for="acabado">Acabado* </label><a name="acabado"></a>
                                <select name="acabado" class="form-control" required>
                                        <option value="sinSolapa" selected>Normal</option>                           
                                </select>

                            <label for="tipoPapel">Tipo de Papel* </label><a name="tipoPapel"></a>
                                <select name="tipoPapel" class="form-control" required>
                                        <option value="300GrBrillo" selected>300 Gr Brillo</option>
                                        <option value="80GrComun">80 Gr Común</option>                           
                                </select>

                            <label for="tamanoProducto">Tamaño* </label><a name="tamanoProducto"></a>
                                <select name="tamanoProducto" class="form-control" required>
                                        <option value="85x85" selected>85x85</option>                           
                                </select> 
                
                            <label for="cantidad">Cantidad* </label><a name="cantidad"></a>
                                <select id="cantidad" name="cantidad" class="form-control" required>
                                        <option value="100">100 (10€)</option> 
                                        <option value="500">500 (20€)</option>
                                        <option value="1000">1000 (35€)</option>
                                        <option value="2000" selected>2000 (50€)</option>                          
                                </select>

                            <label for="pago">Pago* </label><a name="pago"></a>
                                <select name="pago" class="form-control" required>
                                        <option value="tienda" selected>En tienda</option> 
                                        <option value="entrega">Con la entrega</option>                          
                                </select>

                            <label for="envio">Envio* </label><a name="envio"></a>
                                <select name="envio" class="form-control" required>
                                        <option value="recogida" selected>Recogida en tienda</option>
                                        <option value="domicilio">Envio al domicilio</option>                           
                                </select> 

                            <label for="compraTarjeta"></label><a name="compraFlyer"></a>
                            <button type="submit" name="compraTarjeta" class="btn btn-default"/>Comprar</button>

                        </form> 

                    </fieldset>                     
                    
                </div>
            </div>
        </div>

        <!-- FORMULARIO DE TRIPTICOS -->
        <div id="triptico" class="row" style="display: none;">
            <div class="col-md-6">
                <img class="img-responsive img-portfolio img-hover" 
                src="http://placehold.it/545x522" alt="Tarjetas de Visita" 
                width="345px" height="250px">
                <h3>Detalles del Producto</h3>
                <p>Aquí los detalles del producto: <br>
                Información del producto, características...
                </p>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <fieldset>
                        <legend><span>Pedido de Trípticos</span></legend>
                        <form class="form" method="POST" enctype="multipart/form-data"
                         action="../php/procesadoPedido.php">

                            <label for="emailCl">Email del cliente* </label><a name="emailCl"></a><br>
                            <input class="form-control" tabindex="1" type="email" name="emailCl" placeholder="Introduce un Email de cliente" required>

                            <label for="passCl">Password* </label><a name="passCl"></a><br>
                            <input class="form-control" tabindex="2" type="password" name="passCl" placeholder="Contraseña del cliente" required>
                            
                            <label for="impresion">Impresion* </label><a name="impresion"></a>
                                <select name="impresion" class="form-control" required>
                                        <option value="color1Cara" selected>Color 1 Cara</option>
                                        <option value="color1Cara">Color 2 Caras</option>
                                        <option value="color1Cara">Blanco/Negro 1 Cara</option>
                                        <option value="color1Cara">Blanco/Negro 2 Caras</option>                           
                                </select>

                            <label for="acabado">Acabado* </label><a name="acabado"></a>
                                <select name="acabado" class="form-control" required>
                                        <option value="sinSolapa" selected>Normal</option>                           
                                </select>

                            <label for="tipoPapel">Tipo de Papel* </label><a name="tipoPapel"></a>
                                <select name="tipoPapel" class="form-control" required>
                                        <option value="300GrBrillo" selected>300 Gr Brillo</option>
                                        <option value="80GrComun">80 Gr Común</option>                           
                                </select>

                            <label for="tamanoProducto">Tamaño* </label><a name="tamanoProducto"></a>
                                <select name="tamanoProducto" class="form-control" required>
                                        <option value="85x85" selected>85x85</option>                           
                                </select> 
                
                            <label for="cantidad">Cantidad* </label><a name="cantidad"></a>
                                <select id="cantidad" name="cantidad" class="form-control" required>
                                        <option value="100">100 (10€)</option> 
                                        <option value="500">500 (20€)</option>
                                        <option value="1000">1000 (35€)</option>
                                        <option value="2000" selected>2000 (50€)</option>                          
                                </select>

                            <label for="pago">Pago* </label><a name="pago"></a>
                                <select name="pago" class="form-control" required>
                                        <option value="tienda" selected>En tienda</option> 
                                        <option value="entrega">Con la entrega</option>                          
                                </select>

                            <label for="envio">Envio* </label><a name="envio"></a>
                                <select name="envio" class="form-control" required>
                                        <option value="recogida" selected>Recogida en tienda</option>
                                        <option value="domicilio">Envio al domicilio</option>                           
                                </select> 

                            <label for="compraTarjeta"></label><a name="compraTriptico"></a>
                            <button type="submit" name="compraTarjeta" class="btn btn-default"/>Comprar</button>

                        </form> 

                    </fieldset>                     
                    
                </div>
            </div>
        </div>

        <!-- FORMULARIO DE CARTELES -->
        <div id="cartel" class="row" style="display: none;">
            <div class="col-md-6">
                <img class="img-responsive img-portfolio img-hover" 
                src="http://placehold.it/545x522" alt="Tarjetas de Visita" 
                width="345px" height="250px">
                <h3>Detalles del Producto</h3>
                <p>Aquí los detalles del producto: <br>
                Información del producto, características...
                </p>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <fieldset>
                        <legend><span>Pedido de Carteles</span></legend>
                        <form class="form" method="POST" enctype="multipart/form-data"
                         action="../php/procesadoPedido.php">

                            <label for="emailCl">Email del cliente* </label><a name="emailCl"></a><br>
                            <input class="form-control" tabindex="1" type="email" name="emailCl" placeholder="Introduce un Email de cliente" required>

                            <label for="passCl">Password* </label><a name="passCl"></a><br>
                            <input class="form-control" tabindex="2" type="password" name="passCl" placeholder="Contraseña del cliente" required>
                            
                            <label for="impresion">Impresion* </label><a name="impresion"></a>
                                <select name="impresion" class="form-control" required>
                                        <option value="color1Cara" selected>Color 1 Cara</option>
                                        <option value="color1Cara">Color 2 Caras</option>
                                        <option value="color1Cara">Blanco/Negro 1 Cara</option>
                                        <option value="color1Cara">Blanco/Negro 2 Caras</option>                           
                                </select>

                            <label for="acabado">Acabado* </label><a name="acabado"></a>
                                <select name="acabado" class="form-control" required>
                                        <option value="sinSolapa" selected>Normal</option>                           
                                </select>

                            <label for="tipoPapel">Tipo de Papel* </label><a name="tipoPapel"></a>
                                <select name="tipoPapel" class="form-control" required>
                                        <option value="300GrBrillo" selected>300 Gr Brillo</option>
                                        <option value="80GrComun">80 Gr Común</option>                           
                                </select>

                            <label for="tamanoProducto">Tamaño* </label><a name="tamanoProducto"></a>
                                <select name="tamanoProducto" class="form-control" required>
                                        <option value="85x85" selected>85x85</option>                           
                                </select> 
                
                            <label for="cantidad">Cantidad* </label><a name="cantidad"></a>
                                <select id="cantidad" name="cantidad" class="form-control" required>
                                        <option value="100">100 (10€)</option> 
                                        <option value="500">500 (20€)</option>
                                        <option value="1000">1000 (35€)</option>
                                        <option value="2000" selected>2000 (50€)</option>                          
                                </select>

                            <label for="pago">Pago* </label><a name="pago"></a>
                                <select name="pago" class="form-control" required>
                                        <option value="tienda" selected>En tienda</option> 
                                        <option value="entrega">Con la entrega</option>                          
                                </select>

                            <label for="envio">Envio* </label><a name="envio"></a>
                                <select name="envio" class="form-control" required>
                                        <option value="recogida" selected>Recogida en tienda</option>
                                        <option value="domicilio">Envio al domicilio</option>                           
                                </select> 

                            <label for="compraTarjeta"></label><a name="compraCartel"></a>
                            <button type="submit" name="compraTarjeta" class="btn btn-default"/>Comprar</button>

                        </form> 

                    </fieldset>                     
                    
                </div>
            </div>
        </div>
        <!-- FORMULARIO DE CARPETAS -->
        <div id="carpeta" class="row" style="display: none;">
            <div class="col-md-6">
                <img class="img-responsive img-portfolio img-hover" 
                src="http://placehold.it/545x522" alt="Tarjetas de Visita" 
                width="345px" height="250px">
                <h3>Detalles del Producto</h3>
                <p>Aquí los detalles del producto: <br>
                Información del producto, características...
                </p>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <fieldset>
                        <legend><span>Pedido de Carpetas</span></legend>
                        <form class="form" method="POST" enctype="multipart/form-data"
                         action="../php/procesadoPedido.php">

                            <label for="emailCl">Email del cliente* </label><a name="emailCl"></a><br>
                            <input class="form-control" tabindex="1" type="email" name="emailCl" placeholder="Introduce un Email de cliente" required>

                            <label for="passCl">Password* </label><a name="passCl"></a><br>
                            <input class="form-control" tabindex="2" type="password" name="passCl" placeholder="Contraseña del cliente" required>
                            
                            <label for="impresion">Impresion* </label><a name="impresion"></a>
                                <select name="impresion" class="form-control" required>
                                        <option value="color1Cara" selected>Color 1 Cara</option>
                                        <option value="color1Cara">Color 2 Caras</option>
                                        <option value="color1Cara">Blanco/Negro 1 Cara</option>
                                        <option value="color1Cara">Blanco/Negro 2 Caras</option>                           
                                </select>

                            <label for="acabado">Acabado* </label><a name="acabado"></a>
                                <select name="acabado" class="form-control" required>
                                        <option value="sinSolapa" selected>Normal</option>                           
                                </select>

                            <label for="tipoPapel">Tipo de Papel* </label><a name="tipoPapel"></a>
                                <select name="tipoPapel" class="form-control" required>
                                        <option value="300GrBrillo" selected>300 Gr Brillo</option>
                                        <option value="80GrComun">80 Gr Común</option>                           
                                </select>

                            <label for="tamanoProducto">Tamaño* </label><a name="tamanoProducto"></a>
                                <select name="tamanoProducto" class="form-control" required>
                                        <option value="85x85" selected>85x85</option>                           
                                </select> 
                
                            <label for="cantidad">Cantidad* </label><a name="cantidad"></a>
                                <select id="cantidad" name="cantidad" class="form-control" required>
                                        <option value="100">100 (10€)</option> 
                                        <option value="500">500 (20€)</option>
                                        <option value="1000">1000 (35€)</option>
                                        <option value="2000" selected>2000 (50€)</option>                          
                                </select>

                            <label for="pago">Pago* </label><a name="pago"></a>
                                <select name="pago" class="form-control" required>
                                        <option value="tienda" selected>En tienda</option> 
                                        <option value="entrega">Con la entrega</option>                          
                                </select>

                            <label for="envio">Envio* </label><a name="envio"></a>
                                <select name="envio" class="form-control" required>
                                        <option value="recogida" selected>Recogida en tienda</option>
                                        <option value="domicilio">Envio al domicilio</option>                           
                                </select> 

                            <label for="compraTarjeta"></label><a name="compraCarpeta"></a>
                            <button type="submit" name="compraTarjeta" class="btn btn-default"/>Comprar</button>

                        </form> 

                    </fieldset>                     
                    
                </div>
            </div>
        </div>

        <!-- FORMULARIO DE TALONES -->
        <div id="talon" class="row" style="display: none;">
            <div class="col-md-6">
                <img class="img-responsive img-portfolio img-hover" 
                src="http://placehold.it/545x522" alt="Tarjetas de Visita" 
                width="345px" height="250px">
                <h3>Detalles del Producto</h3>
                <p>Aquí los detalles del producto: <br>
                Información del producto, características...
                </p>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <fieldset>
                        <legend><span>Pedido de Talones</span></legend>
                        <form class="form" method="POST" enctype="multipart/form-data"
                         action="../php/procesadoPedido.php">

                            <label for="emailCl">Email del cliente* </label><a name="emailCl"></a><br>
                            <input class="form-control" tabindex="1" type="email" name="emailCl" placeholder="Introduce un Email de cliente" required>

                            <label for="passCl">Password* </label><a name="passCl"></a><br>
                            <input class="form-control" tabindex="2" type="password" name="passCl" placeholder="Contraseña del cliente" required>
                            
                            <label for="impresion">Impresion* </label><a name="impresion"></a>
                                <select name="impresion" class="form-control" required>
                                        <option value="color1Cara" selected>Color 1 Cara</option>
                                        <option value="color1Cara">Color 2 Caras</option>
                                        <option value="color1Cara">Blanco/Negro 1 Cara</option>
                                        <option value="color1Cara">Blanco/Negro 2 Caras</option>                           
                                </select>

                            <label for="acabado">Acabado* </label><a name="acabado"></a>
                                <select name="acabado" class="form-control" required>
                                        <option value="sinSolapa" selected>Normal</option>                           
                                </select>

                            <label for="tipoPapel">Tipo de Papel* </label><a name="tipoPapel"></a>
                                <select name="tipoPapel" class="form-control" required>
                                        <option value="300GrBrillo" selected>300 Gr Brillo</option>
                                        <option value="80GrComun">80 Gr Común</option>                           
                                </select>

                            <label for="tamanoProducto">Tamaño* </label><a name="tamanoProducto"></a>
                                <select name="tamanoProducto" class="form-control" required>
                                        <option value="85x85" selected>85x85</option>                           
                                </select> 
                
                            <label for="cantidad">Cantidad* </label><a name="cantidad"></a>
                                <select id="cantidad" name="cantidad" class="form-control" required>
                                        <option value="100">100 (10€)</option> 
                                        <option value="500">500 (20€)</option>
                                        <option value="1000">1000 (35€)</option>
                                        <option value="2000" selected>2000 (50€)</option>                          
                                </select>

                            <label for="pago">Pago* </label><a name="pago"></a>
                                <select name="pago" class="form-control" required>
                                        <option value="tienda" selected>En tienda</option> 
                                        <option value="entrega">Con la entrega</option>                          
                                </select>

                            <label for="envio">Envio* </label><a name="envio"></a>
                                <select name="envio" class="form-control" required>
                                        <option value="recogida" selected>Recogida en tienda</option>
                                        <option value="domicilio">Envio al domicilio</option>                           
                                </select> 

                            <label for="compraTarjeta"></label><a name="compraTalon"></a>
                            <button type="submit" name="compraTarjeta" class="btn btn-default"/>Comprar</button>

                        </form> 

                    </fieldset>                     
                    
                </div>
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

    <!-- jQuery -->
    <script src="../js/jquery-1.12.4.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Scripts elección formulario -->
    <script src="../js/scripts.js"></script>

</body>

</html>
