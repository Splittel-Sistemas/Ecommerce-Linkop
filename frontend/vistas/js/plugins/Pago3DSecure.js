OpenPay.setId(OpenPayConfig.setId); 
OpenPay.setApiKey(OpenPayConfig.setApiKey);
OpenPay.setSandboxMode(OpenPayConfig.setSandboxMode);

var Success = function(response) {
  let tokenId = response.data.id;
  let deviceSessionId = OpenPay.deviceData.setup();
  let monedaPago = getChecked('.monedaPago')
  let metodoPago = 'tarjeta'
  let paqueteria = document.getElementById('paqueteria')
  let referencia = document.getElementById('referencia-pedido-resumen')
  let cfdiUser   = document.getElementById('CFDIUser')
  let requiereFactura   = document.getElementById('RequiereFactura')
  let checkDatosEnvio       = getChecked('.datosEnvio')
  let checkDatosFacturacion = getChecked('.datosFacturacion')
      checkDatosFacturacion = requiereFactura.checked ? checkDatosFacturacion : '' 
  let data = {
    Action : "Pago3DSecure", 
    ActionOpenPay : true, 
    datosEnvio : checkDatosEnvio,
    datosFacturacion : checkDatosFacturacion,
    paqueteria : paqueteria.value,
    monedaPago : monedaPago,
    metodoPago : metodoPago,
    tokenId : tokenId, 
    deviceSessionId : deviceSessionId,
    CFDIUser : cfdiUser.value,
    referencia : referencia.value
  }

  // información pedido B2B

  if (document.getElementById('datosEnvio-correo-'+checkDatosEnvio)) {
    let contactoNombre   = document.getElementById('datosEnvio-nombre-'+checkDatosEnvio)
    let contactoTelefono = document.getElementById('datosEnvio-telefono-'+checkDatosEnvio)
    let contactoCorreo   = document.getElementById('datosEnvio-correo-'+checkDatosEnvio)

    data['ContactoNombre']    =  contactoNombre.value
    data['ContactoTelefono']  =  contactoTelefono.value
    data['ContactoCorreo']    =  contactoCorreo.value
  }else{
    data['RequiereFactura'] = requiereFactura.checked
  }

  ajax_('../../models/OpenPay/OpenPay.Route.php', 'POST', 'JSON', data, 
  function(response){
    document.getElementById("modal-body-3d-secure").innerHTML = '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'+response.openpay.url+'" allowfullscreen></iframe></div>'
    GlobalOpenModal("modal-3d-secure")
  })
}

var Errorr = function(response) {
  console.log(response)
  let desc = response.data.description != undefined ? response.data.description : response.message;
  alert("ERROR [" + response.status + "] " + desc);
}

var PagarPedido3DSecure = function(Elem){ 
  event.preventDefault();
  let CardNumber      = CleanSpaces(document.getElementById('number').value)
  let HolderName      = CleanSpaces(document.getElementById('name').value)
  let ExpirationMonth = CleanSpaces(document.getElementById('exp_month').value)
  let ExpirationYear  = CleanSpaces(document.getElementById('exp_year').value)
  let Cvv2            = CleanSpaces(document.getElementById('cvc').value)

    if ( OpenPay.card.validateCardNumber(CardNumber) ) {
      if (OpenPay.card.validateCVC(Cvv2)) {
        if (OpenPay.card.validateExpiry(ExpirationMonth, ExpirationYear)) {
          if (document.getElementById('TotalValidacion').value <= 100000) {
            $(Elem).prop( "disabled", true);
            OpenPay.token.create(
              {
                "card_number": CardNumber,
                "holder_name": HolderName,
                "expiration_year": ExpirationYear,
                "expiration_month": ExpirationMonth,
                "cvv2": Cvv2
              }, Success, Errorr
            );          
          }else{
            Alerts("AlertCart", "warning", "Recuerda que no puedes superar los 100000 pesos")
          }
        }else{
          addViewCheckout(document.getElementById('process-3'))
          Alerts("AlertPago", "warning", "¡<strong> Fecha de expiración </strong> no valida!")
        }
      }else{
        addViewCheckout(document.getElementById('process-3'))
        Alerts("AlertPago", "warning", "¡El <strong> Código de seguridad </strong> no es valido!")
      }
    }else{
      addViewCheckout(document.getElementById('process-3'))
      Alerts("AlertPago", "warning", "¡El <strong> número de tarjeta </strong> no es valida!")
    }
}

var Expiracion = function(Elem){
  var str = Elem.value;
  var res = str.split("/");
  document.getElementById("exp_month").value = res[0]
  document.getElementById("exp_year").value = res[1]
}

$("#modal-3d-secure").on('hidden.bs.modal', function () {
    ajax_('../../models/OpenPay/OpenPay.Route.php', 'POST', 'JSON', { Action : "ComprobarTransaccion3DSecure", ActionOpenPay : true }, 
    function(response){
      if(response.completed) window.parent.location.href = "../Cuenta/index.php?menu=4"
      if(response.status == "failed") window.location.reload()
    })
})