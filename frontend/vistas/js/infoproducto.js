/*=============================================
CARRUSEL
=============================================*/

$(".flexslider").flexslider({

	animation: "slide",
    controlNav: true,
    animationLoop: false,
    slideshow: false,
    itemWidth: 100,
    itemMargin: 5

});

$(".flexslider ul li img").click(function(){

	var capturaIndice = $(this).attr("value");

	$(".infoproducto figure.visor img").hide();

	$("#lupa"+capturaIndice).show();
})

/*=============================================
EFECTO LUPA
=============================================*/
$(".infoproducto figure.visor img").mouseover(function(event){

	var capturaImg = $(this).attr("src");

	$(".lupa img").attr("src", capturaImg);

	$(".lupa").fadeIn("fast");

	$(".lupa").css({

		"height":$(".visorImg").height()+"px",
		"background":"#eee",
		"width":"100%"

	})

})
$("#seleccionarColor").change(function() {
	var num = $(this).val();
	var ruta = $("#rmn").val();
	var lastIndex = ruta.lastIndexOf("-");
	ruta = ruta.substring(0, lastIndex);
/* 	alert("https://linkop.com.mx/"+ruta+"-"+num); */
	location.href ="https://linkop.com.mx/"+ruta+"-"+num;
	/* se comenta cambia de imagen dependiendo el color */


});  

$("#seleccionarTalla").change(function() {
	var num = $(this).val();
	var ruta = $("#rmn").val();
	var ultima  = ruta.split(" ").splice(-1);
	var lastIndex = ruta.lastIndexOf("-");
	ruta1 = ruta.substring(0, lastIndex);
	var lastIndex2 = ruta1.lastIndexOf("-");
	ruta2 = ruta1.substring(0, lastIndex2);

	/* alert(ruta2+num); */

/* 	alert("https://linkop.com.mx/"+ruta2+"-"+num+"-"+ultima); */
	location.href ="https://linkop.com.mx/"+ruta2+"-"+num+"-"+ultima;

	/* se comenta cambia de imagen dependiendo el color */


}); 
$(".infoproducto figure.visor img").mouseout(function(event){

	$(".lupa").fadeOut("fast");

})

$(".infoproducto figure.visor img").mousemove(function(event){

	var posX = event.offsetX;
	var posY = event.offsetY;

	$(".lupa img").css({

		"margin-left":-posX+"px",
		"margin-top":-posY+"px"

	})

})

/*=============================================
CONTADOR DE VISTAS
=============================================*/

var contador = 0;

$(window).on("load", function(){

	var vistas = $("span.vistas").html();
	var precio = $("span.vistas").attr("tipo");

	contador = Number(vistas) + 1;

	$("span.vistas").html(contador);

	// EVALUAMOS EL PRECIO PARA DEFINIR CAMPO A ACTUALIZAR

	if(precio == 0){

		var item = "vistasGratis";

	}else{

		var item = "vistas";

	}

	// EVALUAMOS LA RUTA PARA DEFINIR EL PRODUCTO A ACTUALIZAR

	var urlActual = location.pathname;
	var ruta = urlActual.split("/");

	var datos = new FormData();

	datos.append("valor", contador);
	datos.append("item", item);
	datos.append("ruta", ruta.pop());


	$.ajax({

		url:rutaOculta+"ajax/producto.ajax.php",
		method:"POST",
		data: datos,
		cache: false,
		contentType: false,
		processData:false,
		success: function(respuesta){}

	});

})

/*=============================================
ALTURA COMENTARIOS
=============================================*/

$(".comentarios").css({"height":$(".comentarios .alturaComentarios").height()+"px",
						"overflow":"hidden",
						"margin-bottom":"20px"})

$("#verMas").click(function(e){

	e.preventDefault();

	if($("#verMas").html() == "Ver más"){

		$(".comentarios").css({"overflow":"inherit"});

		$("#verMas").html("Ver menos"); 
	
	}else{

		$(".comentarios").css({"height":$(".comentarios .alturaComentarios").height()+"px",
								"overflow":"hidden",
								"margin-bottom":"20px"})

		$("#verMas").html("Ver más"); 
	}

})
