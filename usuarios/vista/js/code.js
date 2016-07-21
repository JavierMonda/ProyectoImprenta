$(document).ready(ini);

function ini() {
	$("#btnregistrar").click(enviarDatos);
	

	// formulario login validacion
	    $(".form-login").bind("submit",function(){


        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data:$(this).serialize(),

            beforeSend: function(){
                $(".btn").text("enviando...");
                $(".btn").attr("disabled", true);
            },
            complete:function(data){
               $(".btn").text("ingresar");
                $(".btn").attr("disabled", false);
            },
            success: function(data){
                
               if(data == "true") {
				document.location.href="admin.php";
			}else{
				$("#resultado").html("<div class='alert alert-danger' role='alert'><b>Acceso denegado, </b>no se pudo comprobar el usuario</div>");
			}
          
 			$("#modal").action("hide"); // bootstrap

            },
            error: function(data){
                // que hacer si se cumplio la petición
                alert("falso");
            }
         

        });
  
    return false;
    
});
}
function enviarDatos() {
	var usuario = $("#usuario").val();
	var pass = $("#pass").val();
	$.ajax({
		url:"insertar.php",
		success:function(result){
			if(result == "true") {
				$("#resultado").html("se ha registrado el usuario correctamente");
			}else{
				$("#resultado").html("no se ha podido registrar el usuario");
			}
		},
		data:{
			usuario:usuario,
			pass:pass
		},
		type:"GET"
	});
}
