/*=============================================
CARGAR LA TABLA DINÁMICA DE BANNER
=============================================*/

// $.ajax({

// 	url:"ajax/tablaBlog.ajax.php",
// 	success:function(respuesta){

// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaBlog").DataTable({
  ajax: "ajax/tablaBlog.ajax.php",
  deferRender: true,
  retrieve: true,
  processing: true,
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});

/*=============================================
ACTIVAR BANNER
=============================================*/

$(".tablaBlog tbody").on("click", ".btnActivar", function () {
  var idBanner = $(this).attr("idBanner");
  var estadoBanner = $(this).attr("estadoBanner");

  var datos = new FormData();
  datos.append("activarId", idBanner);
  datos.append("activarBanner", estadoBanner);

  $.ajax({
    url: "ajax/blog.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      console.log("respuesta", respuesta);
    },
  });

  if (estadoBanner == 0) {
    $(this).removeClass("btn-success");
    $(this).addClass("btn-danger");
    $(this).html("Desactivado");
    $(this).attr("estadoBanner", 1);
  } else {
    $(this).addClass("btn-success");
    $(this).removeClass("btn-danger");
    $(this).html("Activado");
    $(this).attr("estadoBanner", 0);
  }
});

/*=============================================
SUBIENDO LA FOTO DE BANNER
=============================================*/

$(".fotoBanner").change(function () {
  var imagen = this.files[0];

  /*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/
  if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
    $(".fotoBanner").val("");

    swal({
      title: "Error al subir la imagen",
      text: "¡La imagen debe estar en formato JPG o PNG!",
      type: "error",
      confirmButtonText: "¡Cerrar!",
    });

    return;
  } else if (imagen["size"] > 2000000) {
    $(".fotoBanner").val("");

    swal({
      title: "Error al subir la imagen",
      text: "¡La imagen no debe pesar más de 2MB!",
      type: "error",
      confirmButtonText: "¡Cerrar!",
    });

    return;
  } else {
    var datosImagen = new FileReader();
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function (event) {
      var rutaImagen = event.target.result;

      $(".previsualizarBanner").attr("src", rutaImagen);
    });
  }
});

/*=============================================
SELECCIONAR RUTA DE BANNER
=============================================*/


/*=============================================
REVISAR SI LA RUTA DEL BANNER YA EXISTE
=============================================*/

/*=============================================
EDITAR BANNER
=============================================*/

$(".tablaBlog tbody").on("click", ".btnEditarBanner", function () {
  var idBanner = $(this).attr("idBanner");

  var datos = new FormData();
  datos.append("idBanner", idBanner);

  $.ajax({
    url: "ajax/blog.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#modalEditarBanner .idBanner").val(respuesta["id"]);

      /*=============================================
			CARGAMOS LA IMAGEN DE BANNER
			=============================================*/

      $("#modalEditarBanner .previsualizarBanner").attr(
        "src",
        respuesta["img"]
      );
      $("#modalEditarBanner .antiguaFotoBanner").val(respuesta["img"]);

      /*=============================================
			CARGAMOS EL TIPO DE BANNER
			=============================================*/
      $("#modalEditarBanner .seleccionarRutaBanner").val(respuesta["ruta"]);

      $("#modalEditarBanner .seleccionarTipoBanner").val(respuesta["tipo"]);

      $("#modalEditarBanner .entradaRutaBanner").show();

      $("#modalEditarBanner .optionEditarRutaBanner").val(respuesta["ruta"]);

      $("#modalEditarBanner .seleccionarRutaBanner").attr("name", "rutaBanner");
    },
  });
});

/*=============================================
ELIMINAR BANNER
=============================================*/
$(".tablaBlog tbody").on("click", ".btnEliminarBanner", function () {
  var idBanner = $(this).attr("idBanner");
  var imgBanner = $(this).attr("imgBanner");

  swal({
    title: "¿Está seguro de borrar el blog?",
    text: "¡Si no lo está puede cancelar la accíón!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Si, borrar blog!",
  }).then(function (result) {
    if (result.value) {
      window.location =
        "index.php?ruta=blog&idBanner=" + idBanner + "&imgBanner=" + imgBanner;
    }
  });
});
