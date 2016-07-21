function mostrar(id) {
    if (id == "tarjeta") {
        $("#tarjeta").show();
        $("#flyer").hide();
        $("#triptico").hide();
        $("#cartel").hide();
        $("#carpeta").hide();
        $("#talon").hide();
    }

    if (id == "flyer") {
        $("#tarjeta").hide();
        $("#flyer").show();
        $("#triptico").hide();
        $("#cartel").hide();
        $("#carpeta").hide();
        $("#talon").hide();
    }

    if (id == "triptico") {
        $("#tarjeta").hide();
        $("#flyer").hide();
        $("#triptico").show();
        $("#cartel").hide();
        $("#carpeta").hide();
        $("#talon").hide();
    }

    if (id == "cartel") {
        $("#tarjeta").hide();
        $("#flyer").hide();
        $("#triptico").hide();
        $("#cartel").show();
        $("#carpeta").hide();
        $("#talon").hide();
    }
    if (id == "carpeta") {
        $("#tarjeta").hide();
        $("#flyer").hide();
        $("#triptico").hide();
        $("#cartel").hide();
        $("#carpeta").show();
        $("#talon").hide();
    }
    if (id == "talon") {
        $("#tarjeta").hide();
        $("#flyer").hide();
        $("#triptico").hide();
        $("#cartel").hide();
        $("#carpeta").hide();
        $("#talon").show();
    }
}

var inicio=function () {
	$(".cantidad").keyup(function(e) {
		if($(this).val()!=='') {
			if(e.keyCode==13) {

				var id=$(this).attr('data-id');
				var precio=$(this).attr('data-precio');
				var cantidad=$(this).val();
				var dniCifSol=$(this).val();
				$(this).parentsUntil('.producto').find('.subtotal').text('Subtotal: '+(precio*cantidad));
				$(this).parentsUntil('.producto').find('.cliente').text('Cliente: ');
				$.post('../js/modificarDatos.php',{
					Id:id,
					Precio:precio,
					Cantidad:cantidad,
					Cliente:dniCifSol
				},function(e){
					$("#total").text('Total: '+e);
				});
			}
		}
	});
}
$(document).on('ready',inicio);