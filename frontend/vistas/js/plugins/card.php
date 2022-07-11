<!doctype html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            OpenPay.setId('mzpbsqxe2u5jgqywfd3u');
            OpenPay.setApiKey('pk_4c7ac187abf243d08a2893b31d78a6c3');
            OpenPay.setSandboxMode(true);
            //Se genera el id de dispositivo
            var deviceSessionId = OpenPay.deviceData.setup("formulario-tarjeta", "deviceIdHiddenFieldName");

            $('#pay-button').on('click', function(event) {
                event.preventDefault();
                $("#pay-button").prop("disabled", true);
                OpenPay.token.extractFormAndCreate('formulario-tarjeta', sucess_callbak, error_callbak);
            });

            var sucess_callbak = function(response) {
                var token_id = response.data.id;
                $('#token_id').val(token_id);
                $('#formulario-tarjeta').submit();
            };

            var error_callbak = function(response) {
                var desc = response.data.description != undefined ? response.data.description : response.message;
                alert("ERROR [" + response.status + "] " + desc);
                $("#pay-button").prop("disabled", false);
            };

        });
    </script>
  

</head>


            <form action="" id="formulario-tarjeta" method="POST" class="formulario-tarjeta">

                <div class="grupo">
                    <label for="inputNumero">Número Tarjeta</label>
                    <input type="text" class="form-control" id="inputNumero" maxlength="19" autocomplete="off" data-openpay-card="card_number">
                </div>
                <div class="grupo">
                    <label for="inputNombre">Nombre</label>
                    <input type="text" class="form-control" id="inputNombre" maxlength="19" autocomplete="off" data-openpay-card="holder_name">
                </div>
                <br>
                <div class="row">
                    <label for="inputNombre">Expiracion</label>

                    <br>
                    <div class="col-xs-6 text-center ">


                        <select name="mes" class="form-control" id="selectMes" data-openpay-card="expiration_month">
                            <option selected>05</option>
                        </select>
                    </div>
                    <div class="col-xs-6 text-center ">

                        <select name="year" class="form-control" id="selectYear" data-openpay-card="expiration_year">
                            <option selected>25</option>
                        </select>
                    </div>

                </div>

                <div class="grupo ccv">
                    <label for="inputCCV">CCV</label>
                    <input type="text" class="form-control" id="inputCCV" maxlength="3" data-openpay-card="cvv2">
                </div>
                Tus pagos se realizan de forma segura con encriptación de 256 bits
                <br>
                <!-- <button type="submit" class="btn-enviar">Enviar</button> -->
                <input type="hidden" name="token_id" id="token_id">
                <div class="sctn-row">
                    <a class="button rght" id="pay-button">Pagar</a>
                </div>

            </form>
     

</html>