/*=============================================
CABEZOTE
=============================================*/

$("#btnCategorias").click(function(){

	if(window.matchMedia("(max-width:767px)").matches){

		$("#btnCategorias").after($("#categorias").slideToggle("fast"))

	}else{

		$("#cabezote").after($("#categorias").slideToggle("fast"))
		
	}

		
});



$("#btnCategorias").hover(
  function() {
	if(window.matchMedia("(max-width:767px)").matches){

		$("#btnCategorias").after($("#categorias").slideToggle("fast"))

	}else{

		$("#cabezote").after($("#categorias").slideToggle("fast"))
		
	}
  }, function() {
    $( this ).removeClass( "hover" );
  }
);


  $("#usermenu").hover(
	function() {
	  
		$("#usermenu").after($("#productsmenu").slideToggle("fast"))

  
	 
		
		  
	  
	}, function() {
	  $( this ).removeClass( "hover" );
	}
  );
  
  $('#products-menu.dropdown-menu', this).stop( true, true ).fadeOut("fast");
  $(this).toggleClass('open');