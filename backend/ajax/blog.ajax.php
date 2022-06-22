<?php

require_once "../controladores/blog.controlador.php";
require_once "../modelos/blog.modelo.php";

require_once "../modelos/categorias.modelo.php";
require_once "../modelos/subcategorias.modelo.php";

class AjaxBanner{

  /*=============================================
    ACTIVAR BANNER
    =============================================*/ 

  public $activarBanner;
  public $activarId;

  public function ajaxActivarBanner(){

    $respuesta = ModeloBlog::mdlActualizarBanner("blog", "estado", $this->activarBanner, "id", $this->activarId);

    echo $respuesta;

  }


  public $validarRuta;

    public function ajaxValidarRuta(){

      $item = "ruta";
      $valor = $this->validarRuta;

      $respuesta = ControladorBlog::ctrMostrarBlog($item, $valor);

      echo json_encode($respuesta);

    }

    /*=============================================
    EDITAR BANNER
    =============================================*/ 

    public $idBanner;

    public function ajaxEditarBanner(){

      $item = "id";
      $valor = $this->idBanner;

      $respuesta = ControladorBlog::ctrMostrarBlog($item, $valor);

      echo json_encode($respuesta);

    }

}

/*=============================================
ACTIVAR BANNER
=============================================*/

if(isset($_POST["activarBanner"])){

  $activarBanner = new AjaxBanner();
  $activarBanner -> activarBanner = $_POST["activarBanner"];
  $activarBanner -> activarId = $_POST["activarId"];
  $activarBanner -> ajaxActivarBanner();

}

/*=============================================
TRAER RUTAS DE ACUERDO A LA TABLA
=============================================*/
if(isset($_POST["tabla"])){

  $traerRutas = new AjaxBanner();
  $traerRutas -> tabla = $_POST["tabla"];
  $traerRutas -> ajaxTraerRutasBanner();

}

/*=============================================
VALIDAR NO REPETIR RUTA
=============================================*/

if(isset( $_POST["validarRuta"])){

  $valRuta = new AjaxBanner();
  $valRuta -> validarRuta = $_POST["validarRuta"];
  $valRuta -> ajaxValidarRuta();

}

/*=============================================
EDITAR BANNER
=============================================*/
if(isset($_POST["idBanner"])){

  $editar = new AjaxBanner();
  $editar -> idBanner = $_POST["idBanner"];
  $editar -> ajaxEditarBanner();

}
