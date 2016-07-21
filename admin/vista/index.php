<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSS BootStrap -->
    <link rel='stylesheet' href='../css/bootstrap.min.css' />
    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="../css/sign-in.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="js/jquery-1.12.4.min.js"></script>	
	<script type="text/javascript" src="js/code.js"></script>
    <script src='../js/bootstrap.min.js'></script>
</head>
<body>
	
	<div class="container">
		<form class="form-signin form-login" role="form" method="POST" action="validar.php">
        	<h2 class="form-signin-heading">Ingrese los datos</h2>
        	<!-- <label for="usuario" class="sr-only">Usuario</label> -->
        	<input type="email" name="usuario" class="form-control" placeholder="Usuario" required autofocus>
        	<!-- <label for="pass" class="sr-only">Password</label> -->
        	<input type="password" name="pass" class="form-control" placeholder="Contraseña" required>
        	<button type="submit" name="enviar" class="btn btn-lg btn-primary btn-block">Ingresar</button>
     	</form>
	</div>
	<div class="container" id="resultado">

	</div>

	
</body>
</html>