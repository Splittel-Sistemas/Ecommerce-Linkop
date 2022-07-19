/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
VISUALIZAR LA CESTA DEL CARRITO DE COMPRAS
=============================================*/

if (localStorage.getItem("cantidadCesta") != null) {
  $(".cantidadCesta").html(localStorage.getItem("cantidadCesta"));
  $(".sumaCesta").html(localStorage.getItem("sumaCesta"));
} else {
  $(".cantidadCesta").html("0");
  $(".sumaCesta").html("0");
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
VISUALIZAR LOS PRODUCTOS EN LA PÁGINA CARRITO DE COMPRAS
=============================================*/

if (localStorage.getItem("listaProductos") != null) {
  var listaCarrito = JSON.parse(localStorage.getItem("listaProductos"));
} else {
  $(".cuerpoCarrito").html(
    '<div class="well">Aún no hay productos en el carrito de compras.</div>'
  );
  $(".sumaCarrito").hide();
  $(".cabeceraCheckout").hide();
}

/*=============================================
CONFIRMAR PÁGINA DE CARRITO DE COMPRAS
=============================================*/

var url = window.location.href;
var indice = url.split("/");

for (var i = 0; i < indice.length; i++) {
  if (indice[i] == "carrito-de-compras") {
    listaCarrito.forEach(funcionForEach);

    function funcionForEach(item, index) {
      var datosProducto = new FormData();
      var precio = 0;

      datosProducto.append("id", item.idProducto);

      $.ajax({
        url: rutaOculta + "ajax/producto.ajax.php",
        method: "POST",
        data: datosProducto,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          cantidad = respuesta["cantidad"];

          if (
            respuesta["precioOferta"] == 0 ||
            respuesta["precioOferta"] == null
          ) {
            precio = respuesta["precio"];
          } else {
            precio = respuesta["precioOferta"];
          }
          $("#kg").val(item.peso * item.cantidad);

          $(".cuerpoCarrito").append(
            '<div clas="row itemCarrito">' +
              '<div class="col-sm-1 col-xs-12">' +
              "<br>" +
              "<center>" +
              '<button class="btn btn-default backColor quitarItemCarrito" idProducto="' +
              item.idProducto +
              '" peso="' +
              item.peso +
              '">' +
              '<i class="fa fa-times"></i>' +
              "</button>" +
              "</center>" +
              "</div>" +
              '<div class="col-sm-1 col-xs-12">' +
              "<figure>" +
              '<img src="' +
              item.imagen +
              '" class="img-thumbnail">' +
              "</figure>" +
              "</div>" +
              '<div class="col-sm-2 col-xs-12">' +
              "<br>" +
              '<p class="tituloCarritoCompra text-left">' +
              item.titulo +
              "</p>" +
              "</div>" +
              '<div class="col-md-2 col-sm-1 col-xs-12">' +
              "<br>" +
              '<p class="precioCarritoCompra text-center">MXN $<span>' +
              precio +
              "</span></p>" +
              "</div>" +
              '<div class="col-md-2 col-sm-1 col-xs-12">' +
              "<br>" +
              '<p class=" text-center"><span>' +
              cantidad +
              "</span></p>" +
              "</div>" +
              '<div class="col-md-2 col-sm-3 col-xs-8">' +
              "<br>" +
              '<div class="col-xs-8">' +
              "<center>" +
              '<input type="number" class="form-control cantidadItem" min="1" max="' +
              cantidad +
              '" value="' +
              item.cantidad +
              '" tipo="' +
              item.tipo +
              '" precio="' +
              precio +
              '" idProducto="' +
              item.idProducto +
              '" item="' +
              index +
              '">' +
              "</center>" +
              "</div>" +
              "</div>" +
              '<div class="col-md-2 col-sm-1 col-xs-4 text-center">' +
              "<br>" +
              '<p class="subTotal' +
              index +
              ' subtotales">' +
              "<strong>MXN $<span>" +
              Number(item.cantidad) * Number(precio) +
              "</span></strong>" +
              "</p>" +
              "</div>" +
              "</div>" +
              '<div class="clearfix"></div>' +
              "<hr>"
          );

          /*=============================================
					EVITAR MANIPULAR LA CANTIDAD EN PRODUCTOS VIRTUALES
					=============================================*/

          $(".cantidadItem[tipo='virtual']").attr("readonly", "true");

          // /*=============================================
          // /*=============================================
          // /*=============================================
          // /*=============================================
          // /*=============================================
          // ACTUALIZAR SUBTOTAL
          // =============================================*/
          var precioCarritoCompra = $(
            ".cuerpoCarrito .precioCarritoCompra span"
          );

          cestaCarrito(precioCarritoCompra.length);

          sumaSubtotales();
        },
      });
    }
  }
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
AGREGAR AL CARRITO
=============================================*/

$(".agregarCarrito").click(function () {
  var idProducto = $(this).attr("idProducto");
  var imagen = $(this).attr("imagen");
  var titulo = $(this).attr("titulo");
  var precio = $(this).attr("precio");
  var tipo = $(this).attr("tipo");
  var peso = $(this).attr("peso");

  var agregarAlCarrito = false;

  /*=============================================
	CAPTURAR DETALLES
	=============================================*/

  if (tipo == "virtual") {
    agregarAlCarrito = true;
  } else {
    var seleccionarDetalle = $(".seleccionarDetalle");

    for (var i = 0; i < seleccionarDetalle.length; i++) {
      /* 	if($(seleccionarDetalle[i]).val() == ""){

				swal({
					  title: "Debe seleccionar Talla y Color",
					  text: "",
					  type: "warning",
					  showCancelButton: false,
					  confirmButtonColor: "#DD6B55",
					  confirmButtonText: "¡Seleccionar!",
					  closeOnConfirm: false
					})

				return;

			}else{ */

      titulo = titulo + "-" + $(seleccionarDetalle[i]).val();

      agregarAlCarrito = true;
      /* 
			} */
    }
  }

  /*=============================================
	ALMACENAR EN EL LOCALSTARGE LOS PRODUCTOS AGREGADOS AL CARRITO
	=============================================*/

  if (agregarAlCarrito) {
    /*=============================================
		RECUPERAR ALMACENAMIENTO DEL LOCALSTORAGE
		=============================================*/

    if (localStorage.getItem("listaProductos") == null) {
      listaCarrito = [];
    } else {
      var listaProductos = JSON.parse(localStorage.getItem("listaProductos"));

      for (var i = 0; i < listaProductos.length; i++) {
        if (
          listaProductos[i]["idProducto"] == idProducto &&
          listaProductos[i]["tipo"] == "virtual"
        ) {
          swal({
            title: "El producto ya está agregado al carrito de compras",
            text: "",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "¡Volver!",
            closeOnConfirm: false,
          });

          return;
        }
      }

      listaCarrito.concat(localStorage.getItem("listaProductos"));
    }

    listaCarrito.push({
      idProducto: idProducto,
      imagen: imagen,
      titulo: titulo,
      precio: precio,
      tipo: tipo,
      peso: peso,
      cantidad: "1",
    });

    localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

    /*=============================================
		ACTUALIZAR LA CESTA
		=============================================*/

    var cantidadCesta = Number($(".cantidadCesta").html()) + 1;
    var sumaCesta = Number($(".sumaCesta").html()) + Number(precio);

    $(".cantidadCesta").html(cantidadCesta);
    $(".sumaCesta").html(sumaCesta);

    localStorage.setItem("cantidadCesta", cantidadCesta);
    localStorage.setItem("sumaCesta", sumaCesta);

    /*=============================================
		MOSTRAR ALERTA DE QUE EL PRODUCTO YA FUE AGREGADO
		=============================================*/

    swal(
      {
        title: "",
        text: "¡Se ha agregado un nuevo producto al carrito de compras!",
        type: "success",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "¡Continuar comprando!",
        confirmButtonText: "¡Ir a mi carrito de compras!",
        closeOnConfirm: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location = rutaOculta + "carrito-de-compras";
        }
      }
    );
  }
});

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
QUITAR PRODUCTOS DEL CARRITO
=============================================*/

$(document).on("click", ".quitarItemCarrito", function () {
  $(this).parent().parent().parent().remove();

  var idProducto = $(".cuerpoCarrito button");
  var imagen = $(".cuerpoCarrito img");
  var titulo = $(".cuerpoCarrito .tituloCarritoCompra");
  var precio = $(".cuerpoCarrito .precioCarritoCompra span");
  var cantidad = $(".cuerpoCarrito .cantidadItem");

  /*=============================================
	SI AÚN QUEDAN PRODUCTOS VOLVERLOS AGREGAR AL CARRITO (LOCALSTORAGE)
	=============================================*/

  listaCarrito = [];

  if (idProducto.length != 0) {
    for (var i = 0; i < idProducto.length; i++) {
      var idProductoArray = $(idProducto[i]).attr("idProducto");
      var imagenArray = $(imagen[i]).attr("src");
      var tituloArray = $(titulo[i]).html();
      var precioArray = $(precio[i]).html();
      var pesoArray = $(idProducto[i]).attr("peso");
      var tipoArray = $(cantidad[i]).attr("tipo");
      var cantidadArray = $(cantidad[i]).val();

      listaCarrito.push({
        idProducto: idProductoArray,
        imagen: imagenArray,
        titulo: tituloArray,
        precio: precioArray,
        tipo: tipoArray,
        peso: pesoArray,
        cantidad: cantidadArray,
      });
    }

    localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

    sumaSubtotales();
    cestaCarrito(listaCarrito.length);
  } else {
    /*=============================================
		SI YA NO QUEDAN PRODUCTOS HAY QUE REMOVER TODO
		=============================================*/

    localStorage.removeItem("listaProductos");

    localStorage.setItem("cantidadCesta", "0");

    localStorage.setItem("sumaCesta", "0");

    $(".cantidadCesta").html("0");
    $(".sumaCesta").html("0");

    $(".cuerpoCarrito").html(
      '<div class="well">Aún no hay productos en el carrito de compras.</div>'
    );
    $(".sumaCarrito").hide();
    $(".cabeceraCheckout").hide();
  }
});

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
GENERAR SUBTOTAL DESPUES DE CAMBIAR CANTIDAD
=============================================*/
$(document).on("change", ".cantidadItem", function () {
  var peso = $(this).attr("peso");
  var cantidad = $(this).val();
  var precio = $(this).attr("precio");
  var idProducto = $(this).attr("idProducto");
  var item = $(this).attr("item");
  $(".subTotal" + item).html(
    "<strong>MXN $<span>" + cantidad * precio + "</span></strong>"
  );

  /*=============================================
	ACTUALIZAR LA CANTIDAD EN EL LOCALSTORAGE
	=============================================*/

  var idProducto = $(".cuerpoCarrito button");
  var imagen = $(".cuerpoCarrito img");
  var titulo = $(".cuerpoCarrito .tituloCarritoCompra");
  var precio = $(".cuerpoCarrito .precioCarritoCompra span");
  var cantidad = $(".cuerpoCarrito .cantidadItem");

  listaCarrito = [];

  for (var i = 0; i < idProducto.length; i++) {
    var idProductoArray = $(idProducto[i]).attr("idProducto");
    var imagenArray = $(imagen[i]).attr("src");
    var tituloArray = $(titulo[i]).html();
    var precioArray = $(precio[i]).html();
    var pesoArray = $(idProducto[i]).attr("peso");
    var tipoArray = $(cantidad[i]).attr("tipo");
    var cantidadArray = $(cantidad[i]).val();
    $("#kg").val(pesoArray * cantidadArray);

    listaCarrito.push({
      idProducto: idProductoArray,
      imagen: imagenArray,
      titulo: tituloArray,
      precio: precioArray,
      tipo: tipoArray,
      peso: pesoArray,
      cantidad: cantidadArray,
    });
  }

  localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

  sumaSubtotales();
  cestaCarrito(listaCarrito.length);
});

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
SUMA DE TODOS LOS SUBTOTALES
=============================================*/
function sumaSubtotales() {
  var subtotales = $(".subtotales span");
  var arraySumaSubtotales = [];

  for (var i = 0; i < subtotales.length; i++) {
    var subtotalesArray = $(subtotales[i]).html();
    arraySumaSubtotales.push(Number(subtotalesArray));
  }

  function sumaArraySubtotales(total, numero) {
    return total + numero;
  }

  var sumaTotal = arraySumaSubtotales.reduce(sumaArraySubtotales);

  $(".sumaSubTotal").html(
    "<strong>MXN $<span>" + sumaTotal.toFixed(2) + "</span></strong>"
  );

  $(".sumaCesta").html(sumaTotal.toFixed(2));

  localStorage.setItem("sumaCesta", sumaTotal.toFixed(2));
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
ACTUALIZAR CESTA AL CAMBIAR CANTIDAD
=============================================*/
function cestaCarrito(cantidadProductos) {
  /*=============================================
	SI HAY PRODUCTOS EN EL CARRITO
	=============================================*/

  if (cantidadProductos != 0) {
    var cantidadItem = $(".cuerpoCarrito .cantidadItem");

    var arraySumaCantidades = [];

    for (var i = 0; i < cantidadItem.length; i++) {
      var cantidadItemArray = $(cantidadItem[i]).val();
      arraySumaCantidades.push(Number(cantidadItemArray));
    }

    function sumaArrayCantidades(total, numero) {
      return total + numero;
    }

    var sumaTotalCantidades = arraySumaCantidades.reduce(sumaArrayCantidades);

    $(".cantidadCesta").html(sumaTotalCantidades);
    localStorage.setItem("cantidadCesta", sumaTotalCantidades);
  }
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
CHECKOUT
=============================================*/

$("#btnCheckout").click(function () {
  $(".listaProductos table.tablaProductos tbody").html("");

  $("#checkPaypal").prop("checked", true);
  $("#checkPayu").prop("checked", false);

  var idUsuario = $(this).attr("idUsuario");
  var peso = $(".cuerpoCarrito button, .comprarAhora button");
  var titulo = $(
    ".cuerpoCarrito .tituloCarritoCompra, .comprarAhora .tituloCarritoCompra"
  );
  var cantidad = $(".cuerpoCarrito .cantidadItem, .comprarAhora .cantidadItem");
  var subtotal = $(
    ".cuerpoCarrito .subtotales span, .comprarAhora .subtotales span"
  );
  var tipoArray = [];
  var cantidadPeso = [];

  /*=============================================
	SUMA SUBTOTAL
	=============================================*/

  var sumaSubTotal = $(".sumaSubTotal span");

  $(".valorSubtotal").html($(sumaSubTotal).html());
  $(".valorSubtotal").attr("valor", $(sumaSubTotal).html());

  /*=============================================
	TASAS DE IMPUESTO
	=============================================*/

  var impuestoTotal =
    ($(".valorSubtotal").html() * $("#tasaImpuesto").val()) / 100;

  $(".valorTotalImpuesto").html(impuestoTotal.toFixed(2));
  $(".valorTotalImpuesto").attr("valor", impuestoTotal.toFixed(2));

  sumaTotalCompra();

  /*=============================================
	VARIABLES ARRAY 
	=============================================*/

  for (var i = 0; i < titulo.length; i++) {
    var pesoArray = $(peso[i]).attr("peso");
    var tituloArray = $(titulo[i]).html();
    var cantidadArray = $(cantidad[i]).val();
    var subtotalArray = $(subtotal[i]).html();

    /*=============================================
		EVALUAR EL PESO DE ACUERDO A LA CANTIDAD DE PRODUCTOS
		=============================================*/

    cantidadPeso[i] = pesoArray * cantidadArray;

    function sumaArrayPeso(total, numero) {
      return total + numero;
    }

    var sumaTotalPeso = cantidadPeso.reduce(sumaArrayPeso);

    /*=============================================
		MOSTRAR PRODUCTOS DEFINITIVOS A COMPRAR
		=============================================*/

    $(".listaProductos table.tablaProductos tbody").append(
      "<tr>" +
        '<td class="valorTitulo">' +
        tituloArray +
        "</td>" +
        '<td class="valorCantidad">' +
        cantidadArray +
        "</td>" +
        '<td>$<span class="valorItem" valor="' +
        subtotalArray +
        '">' +
        subtotalArray +
        "</span></td>" +
        "<tr>"
    );

    /*=============================================
		SELECCIONAR PAÍS DE ENVÍO SI HAY PRODUCTOS FÍSICOS
		=============================================*/

    tipoArray.push($(cantidad[i]).attr("tipo"));

    function checkTipo(tipo) {
      return tipo == "fisico";
    }
  }

  /*=============================================
	EXISTEN PRODUCTOS FÍSICOS **************SE COMENTA EL PAIS EN LUGAR DE ESTADO
	=============================================*/

  if (tipoArray.find(checkTipo) == "fisico") {
    /* 	$(".seleccionePais").html('<select class="form-control" id="seleccionarPais" required>'+
						
						          '<option value="">Seleccione el país</option>'+

					              '</select>'); */

    $(".seleccioneEstado").html(
      '<select class="form-control" id="seleccionarEstado" required>' +
        '<option value="">Seleccione el Estado</option>' +
        "</select>"
    );
    $(".formEnvio").show();

    $(".btnPagar").attr("tipo", "fisico");
    /* SELECCIONAR EL PAIS */
    $.ajax({
      url: rutaOculta + "vistas/js/plugins/countries.json",
      type: "GET",
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        respuesta.forEach(seleccionarPais);

        function seleccionarPais(item, index) {
          var pais = item.name;
          var codPais = item.code;

          $("#seleccionarPais").append(
            '<option value="' + codPais + '">' + pais + "</option>"
          );
        }
      },
    });
    /* SELECCIONAR EL ESTADO */

    $.ajax({
      url: rutaOculta + "vistas/js/plugins/estados.php",
      type: "GET",
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        respuesta.forEach(seleccionarEstado);

        function seleccionarEstado(item, index) {
          var estado = item.name;
          var codEstado = item.code;
          var costo = item.costo;

          $("#seleccionarEstado").append(
            '<option value="' + costo + '">' + estado + "</option>"
          );
        }
      },
    });
    /*=============================================
		EVALUAR TASAS DE ENVÍO SI EL PRODUCTO ES FÍSICO
		=============================================*/

    $("#seleccionarPais").change(function () {
      $(".alert").remove();

      var pais = $(this).val();
      var tasaPais = $("#tasaPais").val();

      if (pais == tasaPais) {
        var resultadoPeso = sumaTotalPeso * $("#envioNacional").val();

        if (resultadoPeso < $("#tasaMinimaNal").val()) {
          $(".valorTotalEnvio").html($("#tasaMinimaNal").val());
          $(".valorTotalEnvio").attr("valor", $("#tasaMinimaNal").val());
        } else {
          $(".valorTotalEnvio").html(resultadoPeso);
          $(".valorTotalEnvio").attr("valor", resultadoPeso);
        }
      } else {
        var resultadoPeso = sumaTotalPeso * $("#envioInternacional").val();

        if (resultadoPeso < $("#tasaMinimaInt").val()) {
          $(".valorTotalEnvio").html($("#tasaMinimaInt").val());
          $(".valorTotalEnvio").attr("valor", $("#tasaMinimaInt").val());
        } else {
          $(".valorTotalEnvio").html(resultadoPeso);
          $(".valorTotalEnvio").attr("valor", resultadoPeso);
        }
      }

      sumaTotalCompra();
      pagarConPayu();
    });

    $("#seleccionarEstado").change(function () {
      $(".alert").remove();
      var total = $(".valorSubtotal").html();

      if (total < 500) {
        var costo = $(this).val();
      } else {
        var costo = 0;
      }

      $(".valorTotalEnvio").html(costo);
      $(".valorTotalEnvio").attr("valor", costo);

      sumaTotalCompra();
      pagarConPayu();
    });

    /*  */
  } else {
    $(".btnPagar").attr("tipo", "virtual");
  }
});

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
SUMA TOTAL DE LA COMPRA
=============================================*/
function sumaTotalCompra() {
  var sumaTotalTasas =
    Number($(".valorSubtotal").html()) +
    Number($(".valorTotalEnvio").html()) +
    Number($(".valorTotalImpuesto").html());

  $(".valorTotalCompra").html(sumaTotalTasas.toFixed(2));
  $(".valorTotalCompra").attr("valor", sumaTotalTasas.toFixed(2));

  localStorage.setItem("total", hex_md5($(".valorTotalCompra").html()));
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
MÉTODO DE PAGO PARA CAMBIO DE DIVISA
=============================================*/
/* var metodoPago = "paypal"; */
$(document).ready(function () {
  var metodoPago = $("input[name='pago']:checked").val();
  divisas(metodoPago);
});

/* if (metodoPago == "paypal") {
  $(".btnPagar").show();
  $(".formPayu").hide();
  $("#tarjetasr").css("display", "none");
  cambioDivisa("MXN");
  pagarConPaypal();
} */
$("input[name='pago']").change(function () {
  var metodoPago = $("input[name='pago']:checked").val();
  /* var metodoPago = $("input[name='pago']:checked").val(); */
  divisas(metodoPago);

  if (metodoPago == "payu") {
    $(".btnPagar").hide();
    $(".formPayu").show();
    $("#tarjetasr").css("display", "none");
    pagarConPayu();
    cambioDivisa("MXN");
  } else if (metodoPago == "open") {
    $(".btnPagar").show();
    $(".formPayu").hide();
    $("#tarjetasr").css("display", "block");

    cambioDivisa("MXN");

    pagarConOpen();
  } else if (metodoPago == "paypal") {
    $(".btnPagar").show();
    $(".formPayu").hide();
    $("#tarjetasr").css("display", "none");
    cambioDivisa("MXN");
    pagarConPaypal();
  } else if (metodoPago == "oxxo") {
    $(".btnPagar").show();
    $(".formPayu").hide();
    $("#tarjetasr").css("display", "none");
    cambioDivisa("MXN");
    pagarConOxxo();
  }
});
/* if (metodoPago == "paypal") {
  $(".btnPagar").show();
  $(".formPayu").hide();
  $("#tarjetasr").css("display", "none");
  cambioDivisa("MXN");
  pagarConPaypal();
} */
/*=============================================
/*=============================================
/*=============================================
/*=============================================
FUNCIÓN PARA EL CAMBIO DE DIVISA
=============================================*/

function divisas(metodoPago) {
  $("#cambiarDivisa").html("");

  if (metodoPago == "paypal") {
    $("#cambiarDivisa").append(
      '<option value="MXN">MXN</option>' /* +
			                       '<option value="EUR">EUR</option>'+
			                       '<option value="GBP">GBP</option>'+
			                       '<option value="USD">USD</option>'+
			                       '<option value="JPY">JPY</option>'+
			                       '<option value="CAD">CAD</option>'+
			                       '<option value="BRL">BRL</option>' */
    );
  } else {
    $("#cambiarDivisa").append(
      '<option value="MXN">MXN</option>' /* +
			                       '<option value="PEN">PEN</option>'+
			                       '<option value="COP">COP</option>'+
			                       '<option value="USD">USD</option>'+
			                       '<option value="CLP">CLP</option>'+
			                       '<option value="ARS">ARS</option>'+
			                       '<option value="BRL">BRL</option>' */
    );
  }
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
CAMBIO DE DIVISA
=============================================*/

var divisaBase = "MXN";

$("#cambiarDivisa").change(function () {
  $(".alert").remove();

  if ($("#seleccionarPais").val() == "") {
    $("#cambiarDivisa").after(
      '<div class="alert alert-warning">No ha seleccionado el país de envío</div>'
    );

    return;
  }

  var divisa = $(this).val();

  cambioDivisa(divisa);
});

function cambioDivisa(divisa) {
  $.ajax({
    url:
      "https://free.currconv.com/api/v7/convert?q=" +
      divisaBase +
      "_" +
      divisa +
      "&compact=ultra&apiKey=bdaab752b1d5aefb5db0-",
    type: "GET",
    cache: false,
    contentType: false,
    processData: false,
    dataType: "jsonp",
    success: function (respuesta) {
      var conversion = respuesta["MXN_" + divisa];

      $(".cambioDivisa").html(divisa);

      if (divisa == "MXN") {
        $(".valorSubtotal").html($(".valorSubtotal").attr("valor"));
        $(".valorTotalEnvio").html($(".valorTotalEnvio").attr("valor"));
        $(".valorTotalImpuesto").html($(".valorTotalImpuesto").attr("valor"));
        $(".valorTotalCompra").html($(".valorTotalCompra").attr("valor"));

        var valorItem = $(".valorItem");

        localStorage.setItem("total", hex_md5($(".valorTotalCompra").html()));

        for (var i = 0; i < valorItem.length; i++) {
          $(valorItem[i]).html($(valorItem[i]).attr("valor"));
        }
      } else {
        $(".valorSubtotal").html(
          Math.ceil(
            Number(conversion) * Number($(".valorSubtotal").attr("valor")) * 100
          ) / 100
        );

        $(".valorTotalEnvio").html(
          (
            Number(conversion) * Number($(".valorTotalEnvio").attr("valor"))
          ).toFixed(2)
        );

        $(".valorTotalImpuesto").html(
          (
            Number(conversion) * Number($(".valorTotalImpuesto").attr("valor"))
          ).toFixed(2)
        );

        $(".valorTotalCompra").html(
          (
            Number(conversion) * Number($(".valorTotalCompra").attr("valor"))
          ).toFixed(2)
        );

        var valorItem = $(".valorItem");

        localStorage.setItem("total", hex_md5($(".valorTotalCompra").html()));

        for (var i = 0; i < valorItem.length; i++) {
          $(valorItem[i]).html(
            (
              Number(conversion) * Number($(valorItem[i]).attr("valor"))
            ).toFixed(2)
          );
        }
      }

      sumaTotalCompra();

      pagarConPayu();
    },
    error: function (jqXHR, textStatus, errorThrow) {
      if (textStatus == "error") {
        /* 	$("#cambiarDivisa").after('<div class="alert alert-warning">Tenemos problemas para hacer la conversión, intente más tarde</div>'); */

        return;
      }
    },
  });
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
BOTÓN PAGAR PAYPAL
=============================================*/
function pagarConPaypal() {
  $("#pay-button").on("click", function (event) {
    event.preventDefault();
    $("#pay-button").prop("disabled", true);
  });
  $(".btnPagar").click(function () {
    var tipo = $(this).attr("tipo");

    if (tipo == "fisico" && $("#direccion").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Ingrese la Direccion de Envio</div>'
      );

      return;
    }
    if (tipo == "fisico" && $("#telefono").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Ingrese el  telefono </div>'
      );

      return;
    }
    if (tipo == "fisico" && $("#codigo").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Ingrese el codigo postal </div>'
      );

      return;
    }

    if (tipo == "fisico" && $("#seleccionarEstado").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Seleccione el Estado </div>'
      );
      $("#pay-button").prop("disabled", false);

      return;
    }
    if (tipo == "fisico" && $("#ciudad").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Ingrese la ciudad </div>'
      );

      return;
    }

    var idUsuario = $("#idUsuario").val();

    var divisa = $("#cambiarDivisa").val();
    var total = $(".valorTotalCompra").html();
    var totalEncriptado = localStorage.getItem("total");
    var impuesto = $(".valorTotalImpuesto").html();
    var envio = $(".valorTotalEnvio").html();
    var subtotal = $(".valorSubtotal").html();
    var titulo = $(".valorTitulo");
    var cantidad = $(".valorCantidad");
    var valorItem = $(".valorItem");
    var idProducto = $(".cuerpoCarrito button, .comprarAhora button");

    var direccion = $("#direccion").val();
    var codigo = $("#codigo").val();
    var telefono = $("#telefono").val();
    var ciudad = $("#ciudad").val();

    var tituloArray = [];
    var cantidadArray = [];
    var valorItemArray = [];
    var idProductoArray = [];

    for (var i = 0; i < titulo.length; i++) {
      tituloArray[i] = $(titulo[i]).html();
      cantidadArray[i] = $(cantidad[i]).html();
      valorItemArray[i] = $(valorItem[i]).html();
      idProductoArray[i] = $(idProducto[i]).attr("idProducto");
    }

    var datos = new FormData();

    datos.append("divisa", divisa);
    datos.append("total", total);
    datos.append("totalEncriptado", totalEncriptado);
    datos.append("impuesto", impuesto);
    datos.append("envio", envio);
    datos.append("subtotal", subtotal);
    datos.append("tituloArray", tituloArray);
    datos.append("cantidadArray", cantidadArray);
    datos.append("valorItemArray", valorItemArray);
    datos.append("idProductoArray", idProductoArray);
    /* RMN */
    datos.append("metodoPago", "paypal");

    datos.append("direccion", direccion);
    datos.append("codigo", codigo);
    datos.append("telefono", telefono);
    datos.append("ciudad", ciudad);
    datos.append("idUsuario", idUsuario);
    datos.append("token_id", token_id);

    $.ajax({
      url: rutaOculta + "ajax/carrito.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        window.location = respuesta;
      },
    });
  });
}
if (metodoPago == "paypal") {
  $("#pay-button").on("click", function (event) {
    event.preventDefault();
    $("#pay-button").prop("disabled", true);
  });
  $(".btnPagar").click(function () {
    var tipo = $(this).attr("tipo");

    if (tipo == "fisico" && $("#direccion").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Ingrese la Direccion de Envio</div>'
      );

      return;
    }
    if (tipo == "fisico" && $("#telefono").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Ingrese el  telefono </div>'
      );

      return;
    }
    if (tipo == "fisico" && $("#codigo").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Ingrese el codigo postal </div>'
      );

      return;
    }

    if (tipo == "fisico" && $("#seleccionarEstado").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Seleccione el Estado </div>'
      );
      $("#pay-button").prop("disabled", false);

      return;
    }
    if (tipo == "fisico" && $("#ciudad").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Ingrese la ciudad </div>'
      );

      return;
    }

    var idUsuario = $("#idUsuario").val();

    var divisa = $("#cambiarDivisa").val();
    var total = $(".valorTotalCompra").html();
    var totalEncriptado = localStorage.getItem("total");
    var impuesto = $(".valorTotalImpuesto").html();
    var envio = $(".valorTotalEnvio").html();
    var subtotal = $(".valorSubtotal").html();
    var titulo = $(".valorTitulo");
    var cantidad = $(".valorCantidad");
    var valorItem = $(".valorItem");
    var idProducto = $(".cuerpoCarrito button, .comprarAhora button");

    var direccion = $("#direccion").val();
    var codigo = $("#codigo").val();
    var telefono = $("#telefono").val();
    var ciudad = $("#ciudad").val();

    var tituloArray = [];
    var cantidadArray = [];
    var valorItemArray = [];
    var idProductoArray = [];

    for (var i = 0; i < titulo.length; i++) {
      tituloArray[i] = $(titulo[i]).html();
      cantidadArray[i] = $(cantidad[i]).html();
      valorItemArray[i] = $(valorItem[i]).html();
      idProductoArray[i] = $(idProducto[i]).attr("idProducto");
    }

    var datos = new FormData();

    datos.append("divisa", divisa);
    datos.append("total", total);
    datos.append("totalEncriptado", totalEncriptado);
    datos.append("impuesto", impuesto);
    datos.append("envio", envio);
    datos.append("subtotal", subtotal);
    datos.append("tituloArray", tituloArray);
    datos.append("cantidadArray", cantidadArray);
    datos.append("valorItemArray", valorItemArray);
    datos.append("idProductoArray", idProductoArray);
    datos.append("metodoPago", "paypal");

    datos.append("direccion", direccion);
    datos.append("codigo", codigo);
    datos.append("telefono", telefono);
    datos.append("ciudad", ciudad);
    datos.append("idUsuario", idUsuario);
    datos.append("token_id", token_id);

    $.ajax({
      url: rutaOculta + "ajax/carrito.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        window.location = respuesta;
      },
    });
  });
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
BOTÓN PAGAR PAYU
=============================================*/

function pagarConPayu() {
  if ($("#seleccionarPais").val() == "") {
    $(".formPayu").after(
      '<div class="alert alert-warning">No ha seleccionado el país de envío</div>'
    );

    $(".formPayu input[name='Submit']").attr("type", "button");

    return;
  }

  var divisa = $("#cambiarDivisa").val();
  var total = $(".valorTotalCompra").html();
  var impuesto = $(".valorTotalImpuesto").html();
  var envio = $(".valorTotalEnvio").html();
  var subtotal = $(".valorSubtotal").html();
  var titulo = $(".valorTitulo");
  var cantidad = $(".valorCantidad");
  var valorItem = $(".valorItem");
  var idProducto = $(".cuerpoCarrito button, .comprarAhora button");
  var tituloArray = [];
  var cantidadArray = [];
  var idProductoArray = [];
  var valorItemArray = [];

  for (var i = 0; i < titulo.length; i++) {
    tituloArray[i] = $(titulo[i]).html();
    cantidadArray[i] = $(cantidad[i]).html();
    idProductoArray[i] = $(idProducto[i]).attr("idProducto");
    valorItemArray[i] = $(valorItem[i]).html();
  }

  var valorItemString = valorItemArray.toString();
  var pago = valorItemString.replace(",", "-");

  var datos = new FormData();
  datos.append("metodoPago", "payu");
  datos.append("cantidadArray", cantidadArray);
  datos.append("valorItemArray", valorItemArray);
  datos.append("idProductoArray", idProductoArray);
  datos.append("divisaPayu", divisa);

  if (hex_md5(total) == localStorage.getItem("total")) {
    $.ajax({
      url: rutaOculta + "ajax/carrito.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta.charAt(0) == "{") {
          var merchantId = JSON.parse(respuesta).merchantIdPayu;
          var accountId = JSON.parse(respuesta).accountIdPayu;
          var apiKey = JSON.parse(respuesta).apiKeyPayu;
          var modo = JSON.parse(respuesta).modoPayu;
          var description = tituloArray.toString();
          var referenceCode =
            Number(Math.ceil(Math.random() * 1000000)) +
            Number(total).toFixed();
          var productosToString = idProductoArray.toString();
          var productos = productosToString.replace(/,/g, "-");
          var cantidadToString = cantidadArray.toString();
          var cantidad = cantidadToString.replace(/,/g, "-");
          var signature = hex_md5(
            apiKey +
              "~" +
              merchantId +
              "~" +
              referenceCode +
              "~" +
              total +
              "~" +
              divisa
          );

          if (divisa == "MXN") {
            var taxReturnBase = (total - impuesto).toFixed(2);
          } else {
            var taxReturnBase = 0;
          }

          if (modo == "sandbox") {
            var url = "https://sandbox.gateway.payulatam.com/ppp-web-gateway/";
            var test = 1;
          } else {
            var url = "https://gateway.payulatam.com/ppp-web-gateway/";
            var test = 0;
          }

          if (envio != 0) {
            var tipoEnvio = "YES";
          } else {
            var tipoEnvio = "NO";
          }

          $(".formPayu").attr("method", "POST");
          $(".formPayu").attr("action", url);
          $(".formPayu input[name='merchantId']").attr("value", merchantId);
          $(".formPayu input[name='accountId']").attr("value", accountId);
          $(".formPayu input[name='description']").attr("value", description);
          $(".formPayu input[name='referenceCode']").attr(
            "value",
            referenceCode
          );
          $(".formPayu input[name='amount']").attr("value", total);
          $(".formPayu input[name='tax']").attr("value", impuesto);
          $(".formPayu input[name='taxReturnBase']").attr(
            "value",
            taxReturnBase
          );
          $(".formPayu input[name='shipmentValue']").attr("value", envio);
          $(".formPayu input[name='currency']").attr("value", divisa);
          $(".formPayu input[name='responseUrl']").attr(
            "value",
            rutaOculta +
              "index.php?ruta=finalizar-compra&payu=true&productos=" +
              productos +
              "&cantidad=" +
              cantidad +
              "&pago=" +
              pago
          );
          $(".formPayu input[name='declinedResponseUrl']").attr(
            "value",
            rutaOculta + "carrito-de-compras"
          );
          $(".formPayu input[name='displayShippingInformation']").attr(
            "value",
            tipoEnvio
          );
          $(".formPayu input[name='test']").attr("value", test);
          $(".formPayu input[name='signature']").attr("value", signature);

          /*=============================================
				GENERADOR DE TARJETAS DE CRÉDITO
				https://www.mercadopago.com.co/developers/es/guides/resources/localization/local-cards
				=============================================*/
        }
      },
    });
  }
}

function pagarConOpen() {
  $("#pay-button").on("click", function (event) {
    event.preventDefault();
    $("#pay-button").prop("disabled", true);
    OpenPay.token.extractFormAndCreate(
      "formulario-tarjeta",
      sucess_callbak,
      error_callbak
    );
  });

  var sucess_callbak = function (response) {
    var token_id = response.data.id;

    /* 	alert(token_id); */
    var divisa = $("#cambiarDivisa").val();
    var total = $(".valorTotalCompra").html();
    var impuesto = $(".valorTotalImpuesto").html();
    var envio = $(".valorTotalEnvio").html();
    var subtotal = $(".valorSubtotal").html();
    var titulo = $(".valorTitulo");
    var cantidad = $(".valorCantidad");
    var valorItem = $(".valorItem");
    var idProducto = $(".cuerpoCarrito button, .comprarAhora button");
    var tituloArray = [];
    var cantidadArray = [];
    var idProductoArray = [];
    var valorItemArray = [];
    var direccion = $("#direccion").val();
    var codigo = $("#codigo").val();
    var telefono = $("#telefono").val();
    var ciudad = $("#ciudad").val();
    var idUsuario = $("#idUsuario").val();
    var correoE = $("#correoE").val();

    var inputNumero = $("#inputNumero").val();
    var inputNombre = $("#inputNombre").val();
    var selectMes = $("#selectMes").val();
    var selectYear = $("#selectYear").val();

    for (var i = 0; i < titulo.length; i++) {
      tituloArray[i] = $(titulo[i]).html();
      cantidadArray[i] = $(cantidad[i]).html();
      idProductoArray[i] = $(idProducto[i]).attr("idProducto");
      valorItemArray[i] = $(valorItem[i]).html();
    }

    var valorItemString = valorItemArray.toString();
    var pago = valorItemString.replace(",", "-");

    var address = direccion + " " + codigo;
    var deviceIdHiddenFieldName = $("#deviceIdHiddenFieldName").val();

    var formData = new FormData();

    formData.append("phone_number", telefono);
    formData.append("holder_name", inputNombre);
    formData.append("card_number", inputNumero);
    formData.append("expiration_month", selectMes);
    formData.append("expiration_year", selectYear);
    formData.append("cvv", inputCCV);
    formData.append("address", address);
    formData.append("amount", total);
    formData.append("email", "prueba@gmail.com");
    formData.append("token_id", token_id);
    formData.append("deviceIdHiddenFieldName", deviceIdHiddenFieldName);
    formData.append("metodoPago", "open");
    formData.append("cantidadArray", cantidadArray);
    formData.append("valorItemArray", valorItemArray);
    formData.append("idProductoArray", idProductoArray);
    formData.append("divisaPayu", divisa);
    formData.append("direccion", direccion);
    formData.append("codigo", codigo);
    formData.append("telefono", telefono);
    formData.append("ciudad", ciudad);
    formData.append("idUsuario", idUsuario);
    formData.append("token_id", token_id);
    formData.append("tituloArray", tituloArray);
    formData.append("idUsuario", idUsuario);
    formData.append("subtotal", subtotal);
    formData.append("correoE", correoE);

    formData.append("function", "addPay");

    // $('#payment-form').submit();
    if ($("#seleccionarEstado").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Seleccione el Estado </div>'
      );
      $("#pay-button").prop("disabled", false);
    } else {
      $("#pay-button").prop("disabled", true);

      $.ajax({
        data: formData, //send data via AJAX
        url: "vistas/modulos/crearPago.php", //url file controller PHP
        dataType: "json",
        contentType: false,
        processData: false,
        type: "post", //send POST data
        success: function (response) {
          //get request
          /*    console.log(response); */
          if (response.status == true) {
            /*  */

            $.ajax({
              url: rutaOculta + "vistas/modulos/finalizar-compra.php",
              method: "POST",
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {
                localStorage.removeItem("listaProductos");
                localStorage.removeItem("cantidadCesta");
                localStorage.removeItem("sumaCesta");
                window.location = rutaOculta + "ofertas/aviso";
              },
            });
          } else {
            alert("ERORO AL REALIZAR EL PAGO : " + response.charge);
            $("#pay-button").prop("disabled", false);
          }
        },
      });
    }
  };

  var error_callbak = function (response) {
    var desc =
      response.data.description != undefined
        ? response.data.description
        : response.message;
    alert("ERROR [" + response.status + "] " + desc);
    $("#pay-button").prop("disabled", false);
  };
}

/* pago con oxxo  */

/* pago con oxxo  */
function pagarConOxxo() {
  $("#pay-button").on("click", function (event) {
    event.preventDefault();
    $("#pay-button").prop("disabled", true);

    /* 	alert(token_id); */
    var divisa = $("#cambiarDivisa").val();
    var total = $(".valorTotalCompra").html();
    var impuesto = $(".valorTotalImpuesto").html();
    var envio = $(".valorTotalEnvio").html();
    var subtotal = $(".valorSubtotal").html();
    var titulo = $(".valorTitulo");
    var cantidad = $(".valorCantidad");
    var valorItem = $(".valorItem");
    var idProducto = $(".cuerpoCarrito button, .comprarAhora button");
    var tituloArray = [];
    var cantidadArray = [];
    var idProductoArray = [];
    var valorItemArray = [];
    var direccion = $("#direccion").val();
    var codigo = $("#codigo").val();
    var telefono = $("#telefono").val();
    var ciudad = $("#ciudad").val();
    var idUsuario = $("#idUsuario").val();
    var correoE = $("#correoE").val();

    var inputNumero = $("#inputNumero").val();
    var inputNombre = $("#inputNombre").val();
    var selectMes = $("#selectMes").val();
    var selectYear = $("#selectYear").val();

    for (var i = 0; i < titulo.length; i++) {
      tituloArray[i] = $(titulo[i]).html();
      cantidadArray[i] = $(cantidad[i]).html();
      idProductoArray[i] = $(idProducto[i]).attr("idProducto");
      valorItemArray[i] = $(valorItem[i]).html();
    }

    var valorItemString = valorItemArray.toString();
    var pago = valorItemString.replace(",", "-");

    var address = direccion + " " + codigo;
    var deviceIdHiddenFieldName = $("#deviceIdHiddenFieldName").val();

    var formData = new FormData();

    formData.append("phone_number", telefono);
    formData.append("holder_name", inputNombre);
    formData.append("card_number", inputNumero);
    formData.append("expiration_month", selectMes);
    formData.append("expiration_year", selectYear);
    formData.append("cvv", inputCCV);
    formData.append("address", address);
    formData.append("amount", total);
    formData.append("email", "prueba@gmail.com");
    formData.append("token_id", token_id);
    formData.append("deviceIdHiddenFieldName", deviceIdHiddenFieldName);
    formData.append("metodoPago", "open");
    formData.append("cantidadArray", cantidadArray);
    formData.append("valorItemArray", valorItemArray);
    formData.append("idProductoArray", idProductoArray);
    formData.append("divisaPayu", divisa);
    formData.append("direccion", direccion);
    formData.append("codigo", codigo);
    formData.append("telefono", telefono);
    formData.append("ciudad", ciudad);
    formData.append("idUsuario", idUsuario);
    formData.append("token_id", token_id);
    formData.append("tituloArray", tituloArray);
    formData.append("idUsuario", idUsuario);
    formData.append("subtotal", subtotal);
    formData.append("correoE", correoE);

    /* formData.append("function", "addPay"); */

    // $('#payment-form').submit();
    if ($("#seleccionarEstado").val() == "") {
      $(".btnPagar").after(
        '<div class="alert alert-danger">Seleccione el Estado </div>'
      );
      $("#pay-button").prop("disabled", false);
    } else {
      $("#pay-button").prop("disabled", true);

      $.ajax({
        data: formData, //send data via AJAX
        url: "vistas/modulos/Conekta/conekta_oxxo.php", //url file controller PHP
        dataType: "json",
        contentType: false,
        processData: false,
        type: "post", //send POST data
        success: function (response) {
          //get request
        /*   console.log(response); */
/*   if (response.status == true) {

            $.ajax({
              url: rutaOculta + "vistas/modulos/finalizar-compra.php",
              method: "POST",
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {
                localStorage.removeItem("listaProductos");
                localStorage.removeItem("cantidadCesta");
                localStorage.removeItem("sumaCesta");
                window.location = rutaOculta + "ofertas/aviso";
              },
            });
          } else {
            alert("ERORO AL REALIZAR EL PAGO : " + response.charge);
            $("#pay-button").prop("disabled", false);
          } */
        },
        
      }); swal(
        {
          title: "",
          text: "Se ha enviado a su correo el codigo de barras",
          type: "success",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          /*   cancelButtonText: "salir", */
          confirmButtonText: "ok",
          closeOnConfirm: false,
        },
        function (isConfirm) {
          if (isConfirm) {
            window.location = rutaOculta + "perfil";
          }
        }
      );
    }
  });
}

/* fin pago con oxxo  */

/* fin pago con oxxo  */
/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
AGREGAR PRODUCTOS GRATIS
=============================================*/
$(".agregarGratis").click(function () {
  var idProducto = $(this).attr("idProducto");
  var idUsuario = $(this).attr("idUsuario");
  var tipo = $(this).attr("tipo");
  var titulo = $(this).attr("titulo");
  var agregarGratis = false;

  /*=============================================
	VERIFICAR QUE NO TENGA EL PRODUCTO ADQUIRIDO
	=============================================*/

  var datos = new FormData();

  datos.append("idUsuario", idUsuario);
  datos.append("idProducto", idProducto);

  $.ajax({
    url: rutaOculta + "ajax/carrito.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta != "false") {
        swal({
          title: "¡Usted ya adquirió este producto!",
          text: "",
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Regresar",
          closeOnConfirm: false,
        });
      } else {
        if (tipo == "virtual") {
          agregarGratis = true;
        } else {
          var seleccionarDetalle = $(".seleccionarDetalle");

          for (var i = 0; i < seleccionarDetalle.length; i++) {
            /* 	if($(seleccionarDetalle[i]).val() == ""){

								swal({
									  title: "Debe seleccionar Talla y Color",
									  text: "",
									  type: "warning",
									  showCancelButton: false,
									  confirmButtonColor: "#DD6B55",
									  confirmButtonText: "¡Seleccionar!",
									  closeOnConfirm: false
									})

						}else{ */

            titulo = titulo + "-" + $(seleccionarDetalle[i]).val();

            /* 	agregarGratis = true;

						} */
          }
        }

        if (agregarGratis) {
          window.location =
            rutaOculta +
            "index.php?ruta=finalizar-compra&gratis=true&producto=" +
            idProducto +
            "&titulo=" +
            titulo;
        }
      }
    },
  });
});
