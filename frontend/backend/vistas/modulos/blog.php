<div class="content-wrapper">

  <section class="content-header">

    <h1>
      Gestor Blog
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Gestor Blog</li>

    </ol>

  </section>
  <script src="vistas/plugins/tinymce5.7/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
     function example_image_upload_handler (blobInfo, success, failure, progress) {
  var xhr, formData;

  xhr = new XMLHttpRequest();
  xhr.withCredentials = false;
  xhr.open('POST', 'vistas/modulos/postAcceptor.php');

  xhr.upload.onprogress = function (e) {
    progress(e.loaded / e.total * 100);
  };

  xhr.onload = function() {
    var json;

    if (xhr.status === 403) {
      failure('HTTP Error: ' + xhr.status, { remove: true });
      return;
    }

    if (xhr.status < 200 || xhr.status >= 300) {
      failure('HTTP Error: ' + xhr.status);
      return;
    }

    json = JSON.parse(xhr.responseText);

    if (!json || typeof json.location != 'string') {
      failure('Invalid JSON: ' + xhr.responseText);
      return;
    }

    success(json.location);
  };

  xhr.onerror = function () {
    failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
  };

  formData = new FormData();
  formData.append('file', blobInfo.blob(), blobInfo.filename());

  xhr.send(formData);
};
    tinymce.init({
      content_css: "/mycontent.css",
      language: 'es_MX',
      selector: 'textarea',
      height: 450,
      fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
      fontsize: '6pt',

      menubar: false,
      plugins: [
        'print preview anchor ',
        'searchreplace visualblocks  fullscreen',
        'paste tinycomments',
        'insertdatetime media table contextmenu powerpaste    ',
        'wordcount     casechange', 'link', 'image'

      ],
      toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
      toolbar_drawer: 'sliding',
      permanentpen_properties: {
        fontname: 'helvetica,sans-serif,arial',
        forecolor: '#FF0000',
        fontsize: '6pt',
        hilitecolor: '',
        bold: true,
        italic: false,
        strikethrough: false,
        underline: false
      },
      images_upload_handler: example_image_upload_handler,
      relative_urls: false,
    remove_script_host: false,
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Supervisor',
      table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
      powerpaste_allow_local_images: true,
      powerpaste_word_import: 'prompt',
      powerpaste_html_import: 'prompt',
      spellchecker_language: 'es',
      spellchecker_dialog: true,
      browser_spellcheck: true,
      content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'
      ]
    });
  </script>
  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarBanner">

          Agregar Blog

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaBlog" width="100%">

          <thead>

            <tr>

              <th style="width:10px">#</th>
              <th>Imagen</th>
              <th>Estado</th>
              <th>Titulo</th>
              <th>Descripcion</th>
              <th>Acciones</th>

            </tr>

          </thead>

        </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR BANNER
======================================-->

<div id="modalAgregarBanner" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar BLOG</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <div class="form-group  entradaRutaBanner text-center">

              <div class="input-group">
                <label for="">TITULO </label>
                <input type="text" class="form-control input-lg seleccionarRutaBanner " name="rutaBanner" placeholder="Ingrese el titulo" required>

              </div>

            </div>
            <!--=====================================
            SELECCIONAR TIPO BANNER
            ======================================-->

            <div class="form-group">

              <div class="input-group">


                <textarea class="form-control input-lg seleccionarTipoBanner" name="tipoBanner"></textarea>
              </div>

            </div>

            <!--=====================================
            ENTRADA PARA SUBIR IMAGEN DEL BANNER
            ======================================-->

            <div class="form-group">

              <div class="panel">SUBIR IMAGEN BLOG</div>

              <input type="file" class="fotoBanner" name="fotoBanner" required>

              <p class="help-block">Tamaño recomendado <br> Peso máximo de la foto 2MB</p>

              <img src="vistas/img/banner/default/default.jpg" class="img-thumbnail previsualizarBanner" width="100%">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar blog</button>

        </div>

      </form>

      <?php

      $crearBanner = new ControladorBlog();
      $crearBanner->ctrCrearBlog();

      ?>

    </div>

  </div>

</div>


<!--=====================================
MODAL EDITAR BANNER
======================================-->

<div id="modalEditarBanner" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar blog</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
            <!--=====================================
            EDITAR RUTA BANNER
            ======================================-->

            <div class="form-group entradaRutaBanner">

              <div class="input-group">

                <span class="input-group-addon">TITULO</span>


                <input class="form-control input-lg seleccionarRutaBanner" type="text" value="">

                </select>

              </div>

            </div>
            <!--=====================================
            ENTRADA PARA EDITAR FOTO DE BANNER
            ======================================-->

            <div class="form-group">

              <input type="hidden" class="idBanner" name="idBanner">

              <div class="panel">CAMBIAR IMAGEN DEl BLOG</div>

              <input type="file" class="fotoBanner" name="fotoBanner">
              <input type="hidden" class="antiguaFotoBanner" name="antiguaFotoBanner">

              <p class="help-block">Tamaño recomendado 550px * 1600px <br> Peso máximo de la foto 2MB</p>

              <img src="vistas/img/blog/default/default.jpg" class="img-thumbnail previsualizarBanner" width="100%">

            </div>

            <!--=====================================
            ENTRADA PARA SELECCIONAR EL TIPO DE BANNER
            ======================================-->

            <div class="form-group">

              <div class="input-group">



                <textarea class="form-control input-lg seleccionarTipoBanner" name="editarTipoBanner"></textarea>

              </div>

            </div>



          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios blog</button>

        </div>

      </form>

      <?php

      $editarBanner = new ControladorBlog();
      $editarBanner->ctrEditarBanner();

      ?>

    </div>

  </div>

</div>

<?php

$eliminarBanner = new ControladorBlog();
$eliminarBanner->ctrEliminarBanner();

?>