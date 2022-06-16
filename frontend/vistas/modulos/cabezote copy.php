<?php

$servidor = Ruta::ctrRutaServidor();
$url = Ruta::ctrRuta();

/*=============================================
INICIO DE SESIÓN USUARIO
=============================================*/

if (isset($_SESSION["validarSesion"])) {

	if ($_SESSION["validarSesion"] == "ok") {

		echo '<script>
		
			localStorage.setItem("usuario","' . $_SESSION["id"] . '");

		</script>';
	}
}

/*=============================================
API DE GOOGLE
=============================================*/

// https://console.developers.google.com/apis
// https://github.com/google/google-api-php-client

/*=============================================
CREAR EL OBJETO DE LA API GOOGLE
=============================================*/

$cliente = new Google_Client();
$cliente->setAuthConfig('modelos/client_secret.json');
$cliente->setAccessType("offline");
$cliente->setScopes(['profile', 'email']);

/*=============================================
RUTA PARA EL LOGIN DE GOOGLE
=============================================*/

$rutaGoogle = $cliente->createAuthUrl();

/*=============================================
RECIBIMOS LA VARIABLE GET DE GOOGLE LLAMADA CODE
=============================================*/

if (isset($_GET["code"])) {

	$token = $cliente->authenticate($_GET["code"]);

	$_SESSION['id_token_google'] = $token;

	$cliente->setAccessToken($token);
}

/*=============================================
RECIBIMOS LOS DATOS CIFRADOS DE GOOGLE EN UN ARRAY
=============================================*/
$social = ControladorPlantilla::ctrEstiloPlantilla();

if ($cliente->getAccessToken()) {

	$item = $cliente->verifyIdToken();

	$datos = array(
		"nombre" => $item["name"],
		"email" => $item["email"],
		"foto" => $item["picture"],
		"password" => "null",
		"modo" => "google",
		"verificacion" => 0,
		"emailEncriptado" => "null"
	);

	$respuesta = ControladorUsuarios::ctrRegistroRedesSociales($datos);

	echo '<script>
		
	setTimeout(function(){

		window.location = localStorage.getItem("rutaActual");

	},1000);

 	</script>';
}

?>

<!--=====================================
TOP
======================================-->


<!--=====================================
HEADER 
======================================-->
<style>
	@import url("https://fonts.googleapis.com/css?family=Rubik:300,400,400i,500,700");

	.toolbar-dropdown,
	.site-header .site-menu>ul>li .sub-menu {
		display: none;
		position: absolute;
		top: 100%;
		left: 0;
		width: 200px;
		padding: 10px 0;
		border: 1px solid #e5e5e5;
		border-bottom-right-radius: 5px;
		border-bottom-left-radius: 5px;
		background-color: #fff;
		line-height: 1.5;
		box-shadow: 0 7px 22px -5px rgba(0, 0, 0, 0.2)
	}

	.toolbar-dropdown>li,
	.site-header .site-menu>ul>li .sub-menu>li {
		display: block;
		position: relative
	}

	.toolbar-dropdown>li>a,
	.site-header .site-menu>ul>li .sub-menu>li>a {
		display: block;
		position: relative;
		padding: 6px 20px !important;
		transition: color .3s;
		color: #505050;
		font-size: 14px;
		font-weight: normal;
		text-align: left;
		text-decoration: none
	}

	.toolbar-dropdown>li>a>i,
	.site-header .site-menu>ul>li .sub-menu>li>a>i {
		display: inline-block;
		margin-top: -2px;
		margin-right: 6px;
		font-size: .9em;
		vertical-align: middle
	}

	.toolbar-dropdown>li>a.p-0,
	.site-header .site-menu>ul>li .sub-menu>li>a.p-0 {
		padding: 0 !important
	}

	.toolbar-dropdown>li:hover>a,
	.site-header .site-menu>ul>li .sub-menu>li:hover>a {
		color: #BF202F
	}

	.toolbar-dropdown>li.active>a,
	.site-header .site-menu>ul>li .sub-menu>li.active>a {
		color: #BF202F
	}

	.toolbar-dropdown>li.has-children>a,
	.site-header .site-menu>ul>li .sub-menu>li.has-children>a {
		padding-right: 35px !important
	}

	.toolbar-dropdown>li.has-children>a::after,
	.site-header .site-menu>ul>li .sub-menu>li.has-children>a::after {
		display: block;
		position: absolute;
		top: 50%;
		right: 14px;
		margin-top: -11px;
		font-family: feather;
		content: '\e930'
	}

	.toolbar-dropdown>li.has-children:hover>.sub-menu,
	.site-header .site-menu>ul>li .sub-menu>li.has-children:hover>.sub-menu {
		display: block;
		-webkit-animation: submenu-show .35s;
		animation: submenu-show .35s
	}

	.toolbar-dropdown>li.has-children>.sub-menu,
	.site-header .site-menu>ul>li .sub-menu>li.has-children>.sub-menu {
		top: -11px;
		left: 100%;
		margin-left: -4px
	}

	.toolbar-dropdown>li.has-children:not(:first-child)>.sub-menu,
	.site-header .site-menu>ul>li .sub-menu>li.has-children:not(:first-child)>.sub-menu {
		border-radius: 5px
	}

	.site-header .site-menu>ul>li .mega-menu {
		display: none;
		position: absolute;
		top: 100%;
		left: 0;
		width: 100%;
		border-top: 1px solid #e5e5e5;
		border-bottom: 1px solid #e5e5e5;
		background-color: #fff;
		box-shadow: 0 7px 22px -5px rgba(0, 0, 0, 0.2);
		table-layout: fixed
	}

	.site-header .site-menu>ul>li .mega-menu>li {
		display: table-cell !important;
		position: relative;
		padding: 25px !important;
		border-left: 1px solid #e5e5e5;
		vertical-align: top
	}

	.site-header .site-menu>ul>li .mega-menu>li .mega-menu-title {
		display: block;
		margin-bottom: 16px;
		padding-bottom: 10px;
		border-bottom: 1px solid #e5e5e5;
		color: #999;
		text-align: left
	}

	.site-header .site-menu>ul>li .mega-menu>li:first-child {
		border-left: 0
	}

	.site-header .site-menu>ul>li .mega-menu .sub-menu {
		display: block !important;
		position: relative;
		width: 100%;
		padding: 0 !important;
		border: 0;
		border-radius: 0;
		background-color: transparent;
		box-shadow: none
	}

	.site-header .site-menu>ul>li .mega-menu .sub-menu>li>a {
		padding: 5px 0 !important
	}

	.slideable-menu {
		position: relative;
		border-top: 1px solid #e5e5e5;
		background-color: #fff;
		overflow: hidden
	}

	.slideable-menu ul {
		margin: 0;
		padding: 0
	}

	.slideable-menu .menu {
		display: block;
		position: relative;
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
		transition: all 0.4s cubic-bezier(0.86, 0, 0.07, 1)
	}

	.slideable-menu .menu.off-view {
		-webkit-transform: translate3d(-100%, 0, 0);
		transform: translate3d(-100%, 0, 0)
	}

	.slideable-menu .menu.in-view {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0)
	}

	.slideable-menu .menu li {
		display: block
	}

	.slideable-menu .menu li a {
		display: block;
		padding: 13px 20px;
		transition: color .3s;
		border-bottom: 1px solid #e5e5e5;
		border-left: 2px solid transparent;
		color: #505050;
		font-size: 16px;
		letter-spacing: .025em;
		text-decoration: none
	}

	.slideable-menu .menu li a:hover {
		color: #BF202F
	}

	.slideable-menu .menu li.active>a,
	.slideable-menu .menu li.active>span>a {
		border-left-color: #BF202F;
		color: #BF202F
	}

	.slideable-menu .menu li.has-children>span {
		display: block;
		position: relative;
		width: 100%
	}

	.slideable-menu .menu li.has-children .sub-menu-toggle {
		display: block;
		position: absolute;
		top: 0;
		right: 0;
		width: 60px;
		height: 100%;
		height: calc(100% - 1px);
		transition: background-color .3s;
		border-left: 1px solid #e5e5e5;
		color: #505050 !important;
		cursor: pointer;
		z-index: 1
	}

	.slideable-menu .menu li.has-children .sub-menu-toggle::before {
		display: block;
		position: absolute;
		top: 50%;
		left: 0;
		width: 100%;
		margin-top: -11px;
		font-family: feather;
		font-size: 22px;
		line-height: 1;
		text-align: center;
		content: '\e930'
	}

	.slideable-menu .menu li.has-children .sub-menu-toggle:hover {
		background-color: #f5f5f5
	}

	.slideable-menu .menu li.has-children .slideable-submenu {
		position: absolute;
		top: 0;
		right: -100%;
		width: 100%;
		height: auto;
		-webkit-transform: translate3d(100%, 0, 0);
		transform: translate3d(100%, 0, 0);
		transition: all 0.4s cubic-bezier(0.86, 0, 0.07, 1)
	}

	.slideable-menu .menu li.has-children .slideable-submenu.in-view {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0)
	}

	.slideable-menu .menu li.has-children .slideable-submenu.off-view {
		-webkit-transform: translate3d(-100%, 0, 0);
		transform: translate3d(-100%, 0, 0)
	}

	.slideable-menu .menu li.back-btn>a {
		background-color: #f5f5f5
	}

	.slideable-menu .menu li.back-btn>a:hover {
		color: #505050
	}

	.slideable-menu .menu li.back-btn>a::before {
		display: inline-block;
		margin-top: -2px;
		margin-right: 2px;
		font-family: feather;
		font-size: 22px;
		line-height: 1;
		content: '\e92f';
		vertical-align: middle
	}

	@-webkit-keyframes submenu-show {
		from {
			opacity: 0
		}

		to {
			opacity: 1
		}
	}

	@keyframes submenu-show {
		from {
			opacity: 0
		}

		to {
			opacity: 1
		}
	}

	html * {
		text-rendering: optimizeLegibility;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale
	}

	body {
		background-position: center;
		background-color: #fff;
		background-repeat: no-repeat;
		background-size: cover;
		color: #505050;
		font-family: "Rubik", Helvetica, Arial, sans-serif;
		font-size: 16px;
		font-weight: normal;
		line-height: 1.5;
		text-transform: none
	}

	a {
		color: #BF202F;
		text-decoration: underline
	}

	a:hover {
		color: #BF202F;
		text-decoration: none
	}

	a:focus {
		outline: none
	}

	.small,
	small {
		font-size: 85%
	}

	.navi-link {
		transition: color .3s;
		color: #505050;
		text-decoration: none
	}

	.navi-link:hover {
		color: #BF202F !important
	}

	.navi-link-light {
		transition: opacity .3s;
		color: #fff;
		text-decoration: none
	}

	.navi-link-light:hover {
		color: #fff;
		opacity: .6
	}

	img,
	figure {
		max-width: 100%;
		height: auto;
		vertical-align: middle
	}

	svg {
		max-width: 100%
	}

	iframe {
		width: 100%
	}

	* {
		box-sizing: border-box
	}

	*::before,
	*::after {
		box-sizing: border-box
	}

	hr {
		margin: 0;
		border: 0;
		border-top: 1px solid #e5e5e5
	}

	hr.hr-light {
		border-top-color: rgba(255, 255, 255, 0.13)
	}

	pre {
		display: block;
		padding: 15px;
		border: 1px solid #e5e5e5;
		border-radius: 6px;
		background-color: #f5f5f5
	}

	::-moz-selection {
		background: #232323;
		color: #fff
	}

	::selection {
		background: #232323;
		color: #fff
	}

	::-moz-selection {
		background: #232323;
		color: #fff
	}

	figure {
		position: relative;
		margin: 0
	}

	figure figcaption {
		display: block;
		position: absolute;
		bottom: 0;
		left: 0;
		width: 100%;
		margin: 0;
		padding: 12px;
		font-size: 13px
	}

	@media (min-width: 1200px) {
		.container {
			width: 1170px;
			max-width: 1170px
		}
	}

	@media (max-width: 1200px) {
		.container {
			width: 100% !important;
			max-width: 100% !important
		}
	}

	.container-fluid {
		max-width: 1920px;
		margin-right: auto;
		margin-left: auto;
		padding-right: 30px;
		padding-left: 30px
	}

	@media (max-width: 1200px) {
		.container-fluid {
			padding: 0 15px
		}
	}

	.close {
		transition: opacity .25s;
		border: 0;
		background: 0;
		color: #505050;
		font-family: sans-serif;
		font-size: 20px;
		cursor: pointer
	}

	.close:hover {
		opacity: .6
	}

	.position-relative {
		position: relative !important
	}

	.position-absolute {
		position: absolute !important
	}

	.position-fixed {
		position: fixed !important
	}

	.position-static {
		position: static !important
	}

	.top-0 {
		top: 0
	}

	.right-0 {
		right: 0
	}

	.bottom-0 {
		bottom: 0
	}

	.left-0 {
		left: 0
	}

	.w-90 {
		width: 90px !important
	}

	.w-110 {
		width: 110px !important
	}

	.w-150 {
		width: 150px !important
	}

	.w-200 {
		width: 200px !important
	}

	.w-250 {
		width: 250px !important
	}

	.w-270 {
		width: 270px !important
	}

	.w-300 {
		width: 300px !important
	}

	.w-400 {
		width: 400px !important
	}

	.border-default {
		border: 1px solid #e5e5e5
	}

	.border-default.border-light {
		border-color: rgba(255, 255, 255, 0.13)
	}

	.border-0 {
		border: 0 !important
	}

	.border-top-0 {
		border-top: 0 !important
	}

	.border-right-0 {
		border-right: 0 !important
	}

	.border-bottom-0 {
		border-bottom: 0 !important
	}

	.border-left-0 {
		border-left: 0 !important
	}

	.rounded {
		border-radius: 5px
	}

	.rounded-top {
		border-top-left-radius: 5px;
		border-top-right-radius: 5px
	}

	.rounded-right {
		border-top-right-radius: 5px;
		border-bottom-right-radius: 5px
	}

	.rounded-bottom {
		border-bottom-left-radius: 5px;
		border-bottom-right-radius: 5px
	}

	.rounded-left {
		border-top-left-radius: 5px;
		border-bottom-left-radius: 5px
	}

	.rounded-circle {
		border-radius: 50%
	}

	.rounded-0 {
		border-radius: 0 !important
	}

	.rounded-top-0 {
		border-top-left-radius: 0 !important;
		border-top-right-radius: 0 !important
	}

	.rounded-right-0 {
		border-top-right-radius: 0 !important;
		border-bottom-right-radius: 0 !important
	}

	.rounded-bottom-0 {
		border-bottom-left-radius: 0 !important;
		border-bottom-right-radius: 0 !important
	}

	.rounded-left-0 {
		border-top-left-radius: 0 !important;
		border-bottom-left-radius: 0 !important
	}

	.box-shadow {
		box-shadow: 0 7px 22px -5px rgba(25, 25, 25, 0.2)
	}

	.overflow-hidden {
		overflow: hidden !important
	}

	.img-thumbnail {
		padding: 5px !important;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff
	}

	.img-thumbnail.rounded-circle {
		border-radius: 50%
	}

	.img-cover {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover
	}

	[class^='col-'] .img-cover {
		left: 15px;
		width: calc(100% - 30px)
	}

	.opacity-100 {
		opacity: 1 !important
	}

	.opacity-90 {
		opacity: .9 !important
	}

	.opacity-80 {
		opacity: .8 !important
	}

	.opacity-75 {
		opacity: .75 !important
	}

	.opacity-70 {
		opacity: .7 !important
	}

	.opacity-60 {
		opacity: .6 !important
	}

	.opacity-50 {
		opacity: .5 !important
	}

	.opacity-25 {
		opacity: .25 !important
	}

	.opacity-15 {
		opacity: .15 !important
	}

	.clearfix::after {
		display: block;
		clear: both;
		content: ''
	}

	.text-muted {
		color: #999 !important
	}

	.text-primary {
		color: #BF202F !important
	}

	.text-info {
		color: #2196f3 !important
	}

	.text-warning {
		color: #ffa000 !important
	}

	.text-success {
		color: #4caf50 !important
	}

	.text-danger {
		color: #f44336 !important
	}

	.text-gray-dark {
		color: #232323 !important
	}

	.text-body {
		color: #505050 !important
	}

	.text-light,
	.text-white {
		color: #fff !important
	}

	.text-highlighted {
		background-color: #fff8b0 !important
	}

	.text-decoration-none {
		text-decoration: none !important
	}

	.text-crossed {
		text-decoration: line-through !important
	}

	.text-shadow {
		text-shadow: 0 1px rgba(0, 0, 0, 0.5) !important
	}

	.text-black {
		font-weight: 900 !important
	}

	.text-bold {
		font-weight: bold !important
	}

	.text-medium {
		font-weight: 500 !important
	}

	.text-normal {
		font-weight: normal !important
	}

	.text-thin {
		font-weight: 300 !important
	}

	.text-uppercase {
		letter-spacing: .025em
	}

	.bg-primary {
		background-color: #BF202F !important
	}

	.bg-success {
		background-color: #4caf50 !important
	}

	.bg-info {
		background-color: #2196f3 !important
	}

	.bg-warning {
		background-color: #ffa000 !important
	}

	.bg-danger {
		background-color: #f44336 !important
	}

	.bg-inverse {
		background-color: #232323 !important
	}

	.bg-faded,
	.bg-secondary {
		background-color: #f5f5f5 !important
	}

	.bg-dark {
		background-color: #232323 !important
	}

	.bg-white {
		background-color: #fff !important
	}

	.bg-no-repeat {
		background-repeat: no-repeat
	}

	.bg-repeat {
		background-repeat: repeat
	}

	.bg-center {
		background-position: center
	}

	.bg-cover {
		background-size: cover
	}

	.border-primary {
		border-color: #BF202F !important
	}

	.border-success {
		border-color: #4caf50 !important
	}

	.border-info {
		border-color: #2196f3 !important
	}

	.border-warning {
		border-color: #ffa000 !important
	}

	.border-danger {
		border-color: #f44336 !important
	}

	.border-secondary {
		border-color: #f5f5f5 !important
	}

	.border-dark {
		border-color: #232323 !important
	}

	.padding-top-1x {
		padding-top: 24px !important
	}

	@media (max-width: 768px) {
		.padding-top-1x {
			padding-top: 16px !important
		}
	}

	.padding-top-2x {
		padding-top: 48px !important
	}

	@media (max-width: 768px) {
		.padding-top-2x {
			padding-top: 32px !important
		}
	}

	.padding-top-3x {
		padding-top: 72px !important
	}

	@media (max-width: 768px) {
		.padding-top-3x {
			padding-top: 48px !important
		}
	}

	.padding-top-4x {
		padding-top: 96px !important
	}

	@media (max-width: 768px) {
		.padding-top-4x {
			padding-top: 64px !important
		}
	}

	.padding-top-5x {
		padding-top: 120px !important
	}

	@media (max-width: 768px) {
		.padding-top-5x {
			padding-top: 80px !important
		}
	}

	.padding-top-6x {
		padding-top: 144px !important
	}

	@media (max-width: 768px) {
		.padding-top-6x {
			padding-top: 96px !important
		}
	}

	.padding-top-7x {
		padding-top: 168px !important
	}

	@media (max-width: 768px) {
		.padding-top-7x {
			padding-top: 112px !important
		}
	}

	.padding-top-8x {
		padding-top: 192px !important
	}

	@media (max-width: 768px) {
		.padding-top-8x {
			padding-top: 128px !important
		}
	}

	.padding-top-9x {
		padding-top: 216px !important
	}

	@media (max-width: 768px) {
		.padding-top-9x {
			padding-top: 144px !important
		}
	}

	.padding-top-10x {
		padding-top: 240px !important
	}

	@media (max-width: 768px) {
		.padding-top-10x {
			padding-top: 160px !important
		}
	}

	.padding-bottom-1x {
		padding-bottom: 24px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-1x {
			padding-bottom: 16px !important
		}
	}

	.padding-bottom-2x {
		padding-bottom: 48px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-2x {
			padding-bottom: 32px !important
		}
	}

	.padding-bottom-3x {
		padding-bottom: 72px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-3x {
			padding-bottom: 48px !important
		}
	}

	.padding-bottom-4x {
		padding-bottom: 96px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-4x {
			padding-bottom: 64px !important
		}
	}

	.padding-bottom-5x {
		padding-bottom: 120px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-5x {
			padding-bottom: 80px !important
		}
	}

	.padding-bottom-6x {
		padding-bottom: 144px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-6x {
			padding-bottom: 96px !important
		}
	}

	.padding-bottom-7x {
		padding-bottom: 168px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-7x {
			padding-bottom: 112px !important
		}
	}

	.padding-bottom-8x {
		padding-bottom: 192px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-8x {
			padding-bottom: 128px !important
		}
	}

	.padding-bottom-9x {
		padding-bottom: 216px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-9x {
			padding-bottom: 144px !important
		}
	}

	.padding-bottom-10x {
		padding-bottom: 240px !important
	}

	@media (max-width: 768px) {
		.padding-bottom-10x {
			padding-bottom: 160px !important
		}
	}

	.margin-top-1x {
		margin-top: 24px !important
	}

	@media (max-width: 768px) {
		.margin-top-1x {
			margin-top: 16px !important
		}
	}

	.margin-top-2x {
		margin-top: 48px !important
	}

	@media (max-width: 768px) {
		.margin-top-2x {
			margin-top: 32px !important
		}
	}

	.margin-top-3x {
		margin-top: 72px !important
	}

	@media (max-width: 768px) {
		.margin-top-3x {
			margin-top: 48px !important
		}
	}

	.margin-top-4x {
		margin-top: 96px !important
	}

	@media (max-width: 768px) {
		.margin-top-4x {
			margin-top: 64px !important
		}
	}

	.margin-top-5x {
		margin-top: 120px !important
	}

	@media (max-width: 768px) {
		.margin-top-5x {
			margin-top: 80px !important
		}
	}

	.margin-top-6x {
		margin-top: 144px !important
	}

	@media (max-width: 768px) {
		.margin-top-6x {
			margin-top: 96px !important
		}
	}

	.margin-top-7x {
		margin-top: 168px !important
	}

	@media (max-width: 768px) {
		.margin-top-7x {
			margin-top: 112px !important
		}
	}

	.margin-top-8x {
		margin-top: 192px !important
	}

	@media (max-width: 768px) {
		.margin-top-8x {
			margin-top: 128px !important
		}
	}

	.margin-top-9x {
		margin-top: 216px !important
	}

	@media (max-width: 768px) {
		.margin-top-9x {
			margin-top: 144px !important
		}
	}

	.margin-top-10x {
		margin-top: 240px !important
	}

	@media (max-width: 768px) {
		.margin-top-10x {
			margin-top: 160px !important
		}
	}

	.margin-bottom-1x {
		margin-bottom: 24px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-1x {
			margin-bottom: 16px !important
		}
	}

	.margin-bottom-2x {
		margin-bottom: 48px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-2x {
			margin-bottom: 32px !important
		}
	}

	.margin-bottom-3x {
		margin-bottom: 72px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-3x {
			margin-bottom: 48px !important
		}
	}

	.margin-bottom-4x {
		margin-bottom: 96px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-4x {
			margin-bottom: 64px !important
		}
	}

	.margin-bottom-5x {
		margin-bottom: 120px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-5x {
			margin-bottom: 80px !important
		}
	}

	.margin-bottom-6x {
		margin-bottom: 144px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-6x {
			margin-bottom: 96px !important
		}
	}

	.margin-bottom-7x {
		margin-bottom: 168px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-7x {
			margin-bottom: 112px !important
		}
	}

	.margin-bottom-8x {
		margin-bottom: 192px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-8x {
			margin-bottom: 128px !important
		}
	}

	.margin-bottom-9x {
		margin-bottom: 216px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-9x {
			margin-bottom: 144px !important
		}
	}

	.margin-bottom-10x {
		margin-bottom: 240px !important
	}

	@media (max-width: 768px) {
		.margin-bottom-10x {
			margin-bottom: 160px !important
		}
	}

	.mb-30 {
		margin-bottom: 30px !important
	}

	.mt-30 {
		margin-top: 30px !important
	}

	.pt-30 {
		padding-top: 30px !important
	}

	.pb-30 {
		padding-bottom: 30px !important
	}

	.hidden-xs-up {
		display: none !important
	}

	@media (max-width: 575px) {
		.hidden-xs-down {
			display: none !important
		}
	}

	@media (min-width: 576px) {
		.hidden-sm-up {
			display: none !important
		}
	}

	@media (max-width: 767px) {
		.hidden-sm-down {
			display: none !important
		}
	}

	@media (min-width: 768px) {
		.hidden-md-up {
			display: none !important
		}
	}

	@media (max-width: 991px) {
		.hidden-md-down {
			display: none !important
		}
	}

	@media (min-width: 992px) {
		.hidden-lg-up {
			display: none !important
		}
	}

	@media (max-width: 1199px) {
		.hidden-lg-down {
			display: none !important
		}
	}

	@media (min-width: 1200px) {
		.hidden-xl-up {
			display: none !important
		}
	}

	.hidden-xl-down {
		display: none !important
	}

	.d-inline-block img {
		width: 100%
	}

	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.h1,
	.h2,
	.h3,
	.h4,
	.h5,
	.h6 {
		margin: 0;
		color: #232323;
		font-family: inherit;
		font-style: normal;
		text-transform: none
	}

	h1 small,
	h2 small,
	h3 small,
	h4 small,
	h5 small,
	h6 small,
	.h1 small,
	.h2 small,
	.h3 small,
	.h4 small,
	.h5 small,
	.h6 small {
		display: block;
		padding-top: 3px;
		color: #999
	}

	h1,
	.h1 {
		margin-bottom: 24px;
		font-size: 26px;
		font-weight: 300;
		line-height: 1.15
	}

	@media (max-width: 768px) {

		h1,
		.h1 {
			font-size: 26px
		}
	}

	h2,
	.h2 {
		margin-bottom: 20px;
		font-size: 24px;
		font-weight: 300;
		line-height: 1.2
	}

	@media (max-width: 768px) {

		h2,
		.h2 {
			font-size: 24px
		}
	}

	h3,
	.h3 {
		margin-bottom: 20px;
		font-size: 22px;
		font-weight: 300;
		line-height: 1.25
	}

	h4,
	.h4 {
		margin-bottom: 16px;
		font-size: 24px;
		font-weight: 300;
		line-height: 1.3
	}

	h5,
	.h5 {
		margin-bottom: 12px;
		font-size: 20px;
		font-weight: normal;
		line-height: 1.35
	}

	h6,
	.h6 {
		margin-bottom: 12px;
		font-size: 18px;
		font-weight: normal;
		line-height: 1.4
	}

	.display-1,
	.display-2,
	.display-3,
	.display-4 {
		font-weight: 300;
		line-height: 1.15
	}

	.display-1 {
		font-size: 72px
	}

	@media (max-width: 576px) {
		.display-1 {
			font-size: 57px
		}
	}

	.display-2 {
		font-size: 60px
	}

	@media (max-width: 576px) {
		.display-2 {
			font-size: 48px
		}
	}

	.display-3 {
		font-size: 50px
	}

	@media (max-width: 576px) {
		.display-3 {
			font-size: 42px
		}
	}

	.display-4 {
		font-size: 40px
	}

	@media (max-width: 576px) {
		.display-4 {
			font-size: 36px
		}
	}

	.display-404 {
		color: #fff;
		font-size: 240px;
		font-weight: 700;
		text-shadow: 12px 12px 30px rgba(0, 0, 0, 0.1)
	}

	@media (max-width: 768px) {
		.display-404 {
			font-size: 204px
		}
	}

	@media (max-width: 576px) {
		.display-404 {
			font-size: 132px
		}
	}

	p {
		margin: 0 0 20px
	}

	.lead {
		font-size: 18px
	}

	.text-lg {
		font-size: 16px
	}

	.text-md {
		font-size: 14px
	}

	.text-sm {
		font-size: 13px
	}

	.text-xs {
		font-size: 12px
	}

	strong {
		font-weight: 500
	}

	ul,
	ol {
		margin-top: 0;
		margin-bottom: 20px;
		padding-left: 18px;
		line-height: 1.8
	}

	ul ul,
	ul ol,
	ol ul,
	ol ol {
		margin-bottom: 0
	}

	.list-unstyled {
		padding-left: 0;
		list-style: none
	}

	.list-inline {
		padding-left: 0;
		list-style: none
	}

	.list-inline>li {
		display: inline-block;
		padding-right: 5px;
		padding-left: 5px
	}

	.list-icon {
		padding: 0;
		list-style: none
	}

	.list-icon>li {
		position: relative;
		margin-bottom: 6px;
		padding-left: 22px
	}

	.list-icon>li>i {
		display: block;
		position: absolute;
		left: 0;
		line-height: inherit
	}

	.list-icon.text-lg>li {
		padding-left: 25px
	}

	.list-icon.text-sm>li {
		padding-left: 18px
	}

	.list-icon.lead>li {
		padding-left: 26px
	}

	dl {
		margin-top: 0;
		margin-bottom: 16px
	}

	dt,
	dd {
		line-height: 1.5
	}

	dt {
		padding-top: 9px;
		border-top: 1px solid #e5e5e5;
		color: #232323;
		font-weight: 500
	}

	dt:first-child {
		padding-top: 0;
		border: 0
	}

	dd {
		margin-top: 3px;
		margin-bottom: 15px;
		margin-left: 0
	}

	blockquote {
		position: relative;
		margin: 0;
		margin: 50px 0;
		padding: 50px 30px 40px;
		border: 0;
		border-radius: 5px;
		background-color: #f5f5f5;
		color: #505050;
		font-size: 16px;
		font-style: italic;
		text-align: center
	}

	blockquote::before {
		position: absolute;
		top: -24px;
		left: 50%;
		width: 50px;
		height: 50px;
		margin-left: -25px;
		border-radius: 50%;
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDk1LjMzMyA5NS4zMzIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDk1LjMzMyA5NS4zMzI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMzAuNTEyLDQzLjkzOWMtMi4zNDgtMC42NzYtNC42OTYtMS4wMTktNi45OC0xLjAxOWMtMy41MjcsMC02LjQ3LDAuODA2LTguNzUyLDEuNzkzICAgIGMyLjItOC4wNTQsNy40ODUtMjEuOTUxLDE4LjAxMy0yMy41MTZjMC45NzUtMC4xNDUsMS43NzQtMC44NSwyLjA0LTEuNzk5bDIuMzAxLTguMjNjMC4xOTQtMC42OTYsMC4wNzktMS40NDEtMC4zMTgtMi4wNDUgICAgcy0xLjAzNS0xLjAwNy0xLjc1LTEuMTA1Yy0wLjc3Ny0wLjEwNi0xLjU2OS0wLjE2LTIuMzU0LTAuMTZjLTEyLjYzNywwLTI1LjE1MiwxMy4xOS0zMC40MzMsMzIuMDc2ICAgIGMtMy4xLDExLjA4LTQuMDA5LDI3LjczOCwzLjYyNywzOC4yMjNjNC4yNzMsNS44NjcsMTAuNTA3LDksMTguNTI5LDkuMzEzYzAuMDMzLDAuMDAxLDAuMDY1LDAuMDAyLDAuMDk4LDAuMDAyICAgIGM5Ljg5OCwwLDE4LjY3NS02LjY2NiwyMS4zNDUtMTYuMjA5YzEuNTk1LTUuNzA1LDAuODc0LTExLjY4OC0yLjAzMi0xNi44NTFDNDAuOTcxLDQ5LjMwNywzNi4yMzYsNDUuNTg2LDMwLjUxMiw0My45Mzl6IiBmaWxsPSIjRkZGRkZGIi8+CgkJPHBhdGggZD0iTTkyLjQ3MSw1NC40MTNjLTIuODc1LTUuMTA2LTcuNjEtOC44MjctMTMuMzM0LTEwLjQ3NGMtMi4zNDgtMC42NzYtNC42OTYtMS4wMTktNi45NzktMS4wMTkgICAgYy0zLjUyNywwLTYuNDcxLDAuODA2LTguNzUzLDEuNzkzYzIuMi04LjA1NCw3LjQ4NS0yMS45NTEsMTguMDE0LTIzLjUxNmMwLjk3NS0wLjE0NSwxLjc3My0wLjg1LDIuMDQtMS43OTlsMi4zMDEtOC4yMyAgICBjMC4xOTQtMC42OTYsMC4wNzktMS40NDEtMC4zMTgtMi4wNDVjLTAuMzk2LTAuNjA0LTEuMDM0LTEuMDA3LTEuNzUtMS4xMDVjLTAuNzc2LTAuMTA2LTEuNTY4LTAuMTYtMi4zNTQtMC4xNiAgICBjLTEyLjYzNywwLTI1LjE1MiwxMy4xOS0zMC40MzQsMzIuMDc2Yy0zLjA5OSwxMS4wOC00LjAwOCwyNy43MzgsMy42MjksMzguMjI1YzQuMjcyLDUuODY2LDEwLjUwNyw5LDE4LjUyOCw5LjMxMiAgICBjMC4wMzMsMC4wMDEsMC4wNjUsMC4wMDIsMC4wOTksMC4wMDJjOS44OTcsMCwxOC42NzUtNi42NjYsMjEuMzQ1LTE2LjIwOUM5Ni4wOTgsNjUuNTU5LDk1LjM3Niw1OS41NzUsOTIuNDcxLDU0LjQxM3oiIGZpbGw9IiNGRkZGRkYiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
		background-color: #BF202F;
		background-position: center;
		background-repeat: no-repeat;
		background-size: 18px 18px;
		box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.25);
		content: ''
	}

	blockquote cite {
		display: block;
		margin-top: 16px;
		color: #999;
		font-size: 13px;
		font-style: normal;
		font-weight: normal
	}

	blockquote cite::before {
		display: inline-block;
		margin-top: -1px;
		margin-right: 6px;
		color: #999;
		font-family: feather;
		font-size: 1.2em;
		content: '\e9f5';
		vertical-align: middle
	}

	blockquote cite.cite-avatar>img {
		display: inline-block;
		width: 30px;
		margin-right: 8px;
		border-radius: 50%;
		vertical-align: middle
	}

	blockquote cite.cite-avatar::before {
		display: none
	}

	blockquote p {
		margin-bottom: 0
	}

	kbd {
		background-color: #505050
	}

	.form-control {
		padding: 0 18px;
		transition: color .25s, background-color .25s, border-color .25s;
		border: 1px solid #e0e0e0;
		border-radius: 5px;
		background-color: #fff;
		color: #999;
		font-family: "Rubik", Helvetica, Arial, sans-serif;
		font-size: 14px;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none
	}

	.form-control:not(textarea) {
		height: 46px
	}

	.form-control::-moz-placeholder {
		color: #999;
		opacity: 1
	}

	.form-control:-ms-input-placeholder {
		color: #999
	}

	.form-control::-webkit-input-placeholder {
		color: #999
	}

	.form-control:focus {
		border-color: #BF202F;
		outline: none;
		background-color: rgba(230, 25, 35, 0.02);
		color: #999;
		box-shadow: none !important
	}

	.form-control[type='color'] {
		padding-bottom: 0 !important
	}

	.form-control:disabled,
	.form-control[readonly] {
		background-color: #f5f5f5;
		cursor: not-allowed
	}

	textarea.form-control {
		padding-top: 12px;
		padding-bottom: 12px
	}

	select.form-control {
		padding-right: 38px;
		background-position: center right 17px;
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDE4NS4zNDQgMTg1LjM0NCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTg1LjM0NCAxODUuMzQ0OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTkyLjY3MiwxNDQuMzczYy0yLjc1MiwwLTUuNDkzLTEuMDQ0LTcuNTkzLTMuMTM4TDMuMTQ1LDU5LjMwMWMtNC4xOTQtNC4xOTktNC4xOTQtMTAuOTkyLDAtMTUuMTggICAgYzQuMTk0LTQuMTk5LDEwLjk4Ny00LjE5OSwxNS4xOCwwbDc0LjM0Nyw3NC4zNDFsNzQuMzQ3LTc0LjM0MWM0LjE5NC00LjE5OSwxMC45ODctNC4xOTksMTUuMTgsMCAgICBjNC4xOTQsNC4xOTQsNC4xOTQsMTAuOTgxLDAsMTUuMThsLTgxLjkzOSw4MS45MzRDOTguMTY2LDE0My4zMjksOTUuNDE5LDE0NC4zNzMsOTIuNjcyLDE0NC4zNzN6IiBmaWxsPSIjNTA1MDUwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
		background-repeat: no-repeat;
		background-size: 10px 10px
	}

	select.form-control:not([size]):not([multiple]) {
		height: 46px
	}

	.form-group {
		margin-bottom: 20px
	}

	.form-group label {
		margin-bottom: 8px;
		padding-left: 18px;
		font-size: 12px;
		font-weight: 500;
		cursor: pointer
	}

	.form-group label.col-form-label {
		-ms-flex-item-align: center !important;
		align-self: center !important;
		margin-bottom: 0
	}

	.form-control-lg {
		border-radius: 6px;
		font-size: 16px
	}

	.form-control-lg:not(textarea) {
		height: 54px
	}

	.form-control-lg.form-control-pill {
		border-radius: 27px
	}

	.form-control-lg.form-control-square {
		border-radius: 0
	}

	select.form-control.form-control-lg:not([size]):not([multiple]) {
		height: 54px
	}

	.form-control-sm {
		border-radius: 4px;
		font-size: 13px
	}

	.form-control-sm:not(textarea) {
		height: 36px
	}

	.form-control-sm.form-control-pill {
		border-radius: 18px
	}

	.form-control-sm.form-control-square {
		border-radius: 0
	}

	select.form-control.form-control-sm:not([size]):not([multiple]) {
		height: 36px
	}

	.form-text {
		padding-left: 18px
	}

	.custom-control {
		margin-bottom: 6px !important;
		padding-left: 1.5rem !important
	}

	.custom-control:focus {
		outline: 0
	}

	.custom-control .custom-control-label {
		margin: 0;
		padding-left: 0;
		font-size: 14px !important;
		font-weight: normal !important;
		text-transform: none
	}

	.custom-control .custom-control-label::before {
		border: 1px solid #e0e0e0;
		background-color: #f5f5f5;
		box-shadow: none !important
	}

	.custom-control .custom-control-input:checked~.custom-control-label::before {
		border-color: #BF202F;
		background-color: #BF202F
	}

	.custom-control .custom-control-input:disabled~.custom-control-label {
		color: #999;
		cursor: not-allowed
	}

	.bg-secondary .custom-control .custom-control-label::before {
		background-color: #fff
	}

	.custom-control-inline {
		-webkit-box-align: center;
		-ms-flex-align: center;
		align-items: center
	}

	.custom-checkbox .custom-control-label::before {
		border-radius: 2px
	}

	.custom-radio .custom-control-input:checked~.custom-control-label::after {
		background-size: 12px 12px
	}

	.custom-file,
	.custom-file-input {
		height: 46px;
		border-radius: 5px;
		cursor: pointer
	}

	.custom-file:focus~.custom-file-label,
	.custom-file-input:focus~.custom-file-label {
		box-shadow: none
	}

	.custom-file-label {
		font-size: 14px !important;
		font-weight: normal !important
	}

	.custom-file-label,
	.custom-file-label::after {
		height: 46px;
		border-radius: 5px;
		border-color: #e0e0e0;
		color: #505050;
		line-height: 2.35
	}

	.custom-file-label::after {
		height: 44px;
		border-top-left-radius: 0 !important;
		border-bottom-left-radius: 0 !important;
		background-color: #f5f5f5;
		font-weight: 400 !important
	}

	.form-control-pill {
		border-radius: 23px
	}

	.form-control-pill .custom-file-control,
	.form-control-pill .custom-file-control::before {
		border-radius: 23px
	}

	.form-control-square {
		border-radius: 0
	}

	.form-control-square .custom-file-control,
	.form-control-square .custom-file-control::before {
		border-radius: 0
	}

	.input-group {
		display: block;
		position: relative
	}

	.input-group .input-group-addon,
	.input-group .input-group-btn {
		display: inline-block;
		position: absolute;
		top: 50%;
		margin-top: 2px;
		-webkit-transform: translateY(-50%);
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
		font-size: 1.1em
	}

	.input-group .input-group-btn {
		margin-top: 3px
	}

	.input-group .input-group-addon {
		left: 15px;
		transition: color .3s;
		background-color: transparent !important;
		color: #999
	}

	.input-group .form-control {
		padding-left: 37px
	}

	.input-group .form-control:focus~.input-group-addon {
		color: #BF202F
	}

	.input-group .input-group-btn {
		right: 10px
	}

	.input-group .input-group-btn button {
		transition: color .3s;
		border: 0;
		background: 0;
		color: #505050;
		font-size: 1.2em;
		cursor: pointer
	}

	.input-group .input-group-btn button:hover {
		color: #BF202F
	}

	.input-group .input-group-btn .btn {
		margin: 0;
		margin-top: -8px;
		margin-right: 3px;
		margin-bottom: 0;
		margin-left: 0;
		padding: 0
	}

	.input-group .input-group-btn~.form-control {
		padding-right: 38px;
		padding-left: 18px
	}

	.input-light.form-control,
	.input-light .form-control {
		border-color: rgba(255, 255, 255, 0.18);
		background-color: rgba(255, 255, 255, 0.02);
		color: #fff
	}

	.input-light.form-control::-moz-placeholder,
	.input-light .form-control::-moz-placeholder {
		color: rgba(255, 255, 255, 0.5);
		opacity: 1
	}

	.input-light.form-control:-ms-input-placeholder,
	.input-light .form-control:-ms-input-placeholder {
		color: rgba(255, 255, 255, 0.5)
	}

	.input-light.form-control::-webkit-input-placeholder,
	.input-light .form-control::-webkit-input-placeholder {
		color: rgba(255, 255, 255, 0.5)
	}

	.input-light.form-control:focus,
	.input-light .form-control:focus {
		border-color: rgba(255, 255, 255, 0.3);
		background-color: rgba(255, 255, 255, 0.04);
		color: #fff
	}

	.input-light.form-control:focus~.input-group-addon,
	.input-light .form-control:focus~.input-group-addon {
		color: #fff
	}

	.input-light.input-group .input-group-addon {
		color: rgba(255, 255, 255, 0.5)
	}

	.input-light select.form-control,
	select.form-control.input-light {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDI4NC45MjkgMjg0LjkyOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjg0LjkyOSAyODQuOTI5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTI4Mi4wODIsNzYuNTExbC0xNC4yNzQtMTQuMjczYy0xLjkwMi0xLjkwNi00LjA5My0yLjg1Ni02LjU3LTIuODU2Yy0yLjQ3MSwwLTQuNjYxLDAuOTUtNi41NjMsMi44NTZMMTQyLjQ2NiwxNzQuNDQxICAgTDMwLjI2Miw2Mi4yNDFjLTEuOTAzLTEuOTA2LTQuMDkzLTIuODU2LTYuNTY3LTIuODU2Yy0yLjQ3NSwwLTQuNjY1LDAuOTUtNi41NjcsMi44NTZMMi44NTYsNzYuNTE1QzAuOTUsNzguNDE3LDAsODAuNjA3LDAsODMuMDgyICAgYzAsMi40NzMsMC45NTMsNC42NjMsMi44NTYsNi41NjVsMTMzLjA0MywxMzMuMDQ2YzEuOTAyLDEuOTAzLDQuMDkzLDIuODU0LDYuNTY3LDIuODU0czQuNjYxLTAuOTUxLDYuNTYyLTIuODU0TDI4Mi4wODIsODkuNjQ3ICAgYzEuOTAyLTEuOTAzLDIuODQ3LTQuMDkzLDIuODQ3LTYuNTY1QzI4NC45MjksODAuNjA3LDI4My45ODQsNzguNDE3LDI4Mi4wODIsNzYuNTExeiIgZmlsbD0iI0ZGRkZGRiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=)
	}

	.input-light select.form-control option,
	select.form-control.input-light option {
		color: #505050 !important
	}

	.card-wrapper {
		margin: 30px 0
	}

	@media (max-width: 576px) {
		.jp-card-container {
			width: 285px !important
		}

		.jp-card {
			min-width: 250px !important
		}
	}

	.coupon-form .form-control {
		display: inline-block;
		width: 100%;
		max-width: 235px;
		margin-right: 12px
	}

	.coupon-form .btn {
		margin-right: 0
	}

	@media (max-width: 768px) {
		.coupon-form .form-control {
			display: block;
			max-width: 100%
		}
	}

	.was-validated .form-control:valid,
	.was-validated .form-control.is-valid {
		border-color: #e0e0e0 !important
	}

	.was-validated .form-control:valid:focus,
	.was-validated .form-control.is-valid:focus {
		border-color: #BF202F !important
	}

	.was-validated .form-control:invalid,
	.was-validated .form-control.is-invalid {
		border-color: #f44336 !important
	}

	.was-validated .form-control.input-light:valid,
	.was-validated .form-control.input-light.is-valid {
		border-color: rgba(255, 255, 255, 0.18) !important;
		background-color: rgba(255, 255, 255, 0.02) !important
	}

	.was-validated .form-control.input-light:valid:focus,
	.was-validated .form-control.input-light.is-valid:focus {
		border-color: rgba(255, 255, 255, 0.3) !important;
		background-color: rgba(255, 255, 255, 0.04) !important
	}

	.was-validated .form-control.input-light:invalid,
	.was-validated .form-control.input-light.is-invalid {
		border-color: #f44336 !important
	}

	.was-validated .form-control:valid,
	.was-validated .form-control.is-valid,
	.was-validated .fotm-control.input-light:valid,
	.was-validated .fotm-control.input-light.is-valid {
		padding-right: 42px;
		background-position: center right 15px;
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDUxMCA1MTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMCA1MTA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0iY2hlY2stY2lyY2xlLW91dGxpbmUiPgoJCTxwYXRoIGQ9Ik0xNTAuNDUsMjA2LjU1bC0zNS43LDM1LjdMMjI5LjUsMzU3bDI1NS0yNTVsLTM1LjctMzUuN0wyMjkuNSwyODUuNkwxNTAuNDUsMjA2LjU1eiBNNDU5LDI1NWMwLDExMi4yLTkxLjgsMjA0LTIwNCwyMDQgICAgUzUxLDM2Ny4yLDUxLDI1NVMxNDIuOCw1MSwyNTUsNTFjMjAuNCwwLDM4LjI1LDIuNTUsNTYuMSw3LjY1bDQwLjgwMS00MC44QzMyMS4zLDcuNjUsMjg4LjE1LDAsMjU1LDBDMTE0Ljc1LDAsMCwxMTQuNzUsMCwyNTUgICAgczExNC43NSwyNTUsMjU1LDI1NXMyNTUtMTE0Ljc1LDI1NS0yNTVINDU5eiIgZmlsbD0iIzRjYWY1MCIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=);
		background-repeat: no-repeat;
		background-size: 17px 17px
	}

	.was-validated .form-control:invalid,
	.was-validated .form-control.is-invalid,
	.was-validated .fotm-control.input-light:invalid,
	.was-validated .fotm-control.input-light.is-invalid {
		padding-right: 42px;
		background-position: center right 15px;
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ5MS44NTggNDkxLjg1OCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDkxLjg1OCA0OTEuODU4OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTI0NS45MjksMEMxMTAuMTA2LDAsMCwxMTAuMTA2LDAsMjQ1LjkyOXMxMTAuMTA2LDI0NS45MjksMjQ1LjkyOSwyNDUuOTI5YzEzNS44MjIsMCwyNDUuOTI5LTExMC4xMDYsMjQ1LjkyOS0yNDUuOTI5ICAgIFMzODEuNzUxLDAsMjQ1LjkyOSwweiBNNDMuNzIxLDI0NS45MjljMC0xMTEuNjc3LDkwLjUzMS0yMDIuMjA4LDIwMi4yMDgtMjAyLjIwOGM0Ni4xNDQsMCw4OC42NjgsMTUuNDY3LDEyMi42OTYsNDEuNDg1ICAgIEw4NS4yMDQsMzY4LjYyNUM1OS4xODcsMzM0LjU5Nyw0My43MjEsMjkyLjA3Miw0My43MjEsMjQ1LjkyOXogTTI0NS45MjksNDQ4LjEzN2MtNDUuODI4LDAtODguMDg3LTE1LjI1NS0xMjItNDAuOTUgICAgTDQwNy4xODYsMTIzLjkzYzI1LjY5NCwzMy45MTEsNDAuOTQ5LDc2LjE3MSw0MC45NDksMTIxLjk5OUM0NDguMTM2LDM1Ny42MDUsMzU3LjYwNSw0NDguMTM3LDI0NS45MjksNDQ4LjEzN3oiIGZpbGw9IiNmNDQzMzYiLz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
		background-repeat: no-repeat;
		background-size: 17px 17px
	}

	.was-validated .custom-file-input:valid~.custom-file-label,
	.was-validated .custom-file-input.is-valid~.custom-file-label {
		border-color: #e2e2e2 !important
	}

	.was-validated .custom-control-input:invalid~.custom-control-label,
	.was-validated .custom-control-input.is-invalid~.custom-control-label {
		color: #f44336
	}

	.was-validated .custom-control-input:invalid~.custom-control-label::before,
	.was-validated .custom-control-input.is-invalid~.custom-control-label::before {
		border-color: #f44336
	}

	.was-validated .custom-control-input:valid~.custom-control-label,
	.was-validated .custom-control-input.is-valid~.custom-control-label {
		color: #505050
	}

	.was-validated .custom-control-input:valid~.custom-control-label::before,
	.was-validated .custom-control-input.is-valid~.custom-control-label::before {
		background-color: #dee2e6
	}

	.was-validated .custom-control-input:valid:checked~.custom-control-label,
	.was-validated .custom-control-input.is-valid:checked~.custom-control-label {
		color: #505050
	}

	.was-validated .custom-control-input:valid:checked~.custom-control-label::before,
	.was-validated .custom-control-input.is-valid:checked~.custom-control-label::before {
		border-color: #BF202F;
		background-color: #BF202F
	}

	.valid-feedback,
	.invalid-feedback {
		margin-top: 5px;
		font-size: 80% !important
	}

	.valid-tooltip,
	.invalid-tooltip {
		padding-top: 2px;
		padding-bottom: 2px;
		font-size: 80%
	}

	.valid-feedback {
		color: #4caf50
	}

	.invalid-feedback {
		color: #f44336
	}

	.valid-tooltip {
		background-color: #4caf50
	}

	.invalid-tooltip {
		background-color: #f44336
	}

	.table thead th,
	.table td,
	.table th {
		border-color: #e5e5e5
	}

	.table thead th,
	.table th {
		font-weight: 500
	}

	.table.table-inverse {
		background-color: #232323;
		color: #fff
	}

	.table.table-inverse thead th,
	.table.table-inverse td,
	.table.table-inverse th {
		border-color: rgba(255, 255, 255, 0.13)
	}

	.thead-inverse th {
		background-color: #232323;
		color: #fff
	}

	.thead-default th {
		background-color: #f5f5f5;
		color: #505050
	}

	.table-striped tbody tr:nth-of-type(odd) {
		background-color: #f5f5f5
	}

	.table-striped.table-inverse tbody tr:nth-of-type(odd) {
		background-color: rgba(0, 0, 0, 0.08)
	}

	.table-hover tbody tr:hover {
		background-color: #f5f5f5
	}

	.table-hover.table-inverse tbody tr:hover {
		background-color: rgba(0, 0, 0, 0.08)
	}

	.table-active,
	.table-active td,
	.table-active th {
		background-color: rgba(0, 0, 0, 0.05)
	}

	.table-success,
	.table-success td,
	.table-success th {
		background-color: rgba(76, 175, 80, 0.09)
	}

	.table-info,
	.table-info td,
	.table-info th {
		background-color: rgba(33, 150, 243, 0.09)
	}

	.table-warning,
	.table-warning td,
	.table-warning th {
		background-color: rgba(255, 160, 0, 0.09)
	}

	.table-danger,
	.table-danger td,
	.table-danger th {
		background-color: rgba(244, 67, 54, 0.09)
	}

	.btn {
		display: inline-block;
		position: relative;
		height: 46px;
		margin-top: 8px;
		margin-right: 12px;
		margin-bottom: 8px;
		padding: 0 22px;
		-webkit-transform: translateZ(0);
		transform: translateZ(0);
		transition: all .4s;
		border: 1px solid transparent;
		border-radius: 5px;
		background-color: transparent;
		background-image: none;
		color: #505050;
		font-family: "Rubik", Helvetica, Arial, sans-serif;
		font-size: 14px;
		font-style: normal;
		font-weight: 400 !important;
		letter-spacing: .025em;
		line-height: 44px;
		white-space: nowrap;
		cursor: pointer;
		vertical-align: middle;
		text-transform: none;
		text-decoration: none;
		text-align: center;
		-ms-touch-action: manipulation;
		touch-action: manipulation;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none
	}

	.btn:hover,
	.btn:focus .btn:active,
	.btn.active {
		outline: none;
		background-image: none;
		text-decoration: none;
		box-shadow: none
	}

	.btn:hover {
		color: #505050
	}

	.btn>i {
		display: inline-block;
		margin-top: -1px;
		vertical-align: middle
	}

	.btn[disabled],
	.btn.disabled {
		cursor: not-allowed;
		opacity: .55;
		pointer-events: none
	}

	button:focus {
		outline: none
	}

	.btn-lg {
		height: 54px;
		border-radius: 6px;
		font-size: 16px;
		line-height: 52px
	}

	.btn-sm {
		height: 36px;
		padding: 0 18px;
		border-radius: 4px;
		font-size: 12px;
		line-height: 34px
	}

	.btn-pill {
		border-radius: 23px
	}

	.btn-pill.btn-lg {
		border-radius: 27px
	}

	.btn-pill.btn-sm {
		border-radius: 18px
	}

	.btn-square {
		border-radius: 0
	}

	.btn-secondary {
		border-color: #e5e5e5;
		background-color: #f5f5f5
	}

	.btn-secondary:hover {
		background-color: #ebebeb
	}

	.btn-primary,
	.btn-success,
	.btn-info,
	.btn-warning,
	.btn-danger {
		color: #fff
	}

	.btn-primary:hover,
	.btn-primary:active,
	.btn-primary:focus,
	.btn-success:hover,
	.btn-success:active,
	.btn-success:focus,
	.btn-info:hover,
	.btn-info:active,
	.btn-info:focus,
	.btn-warning:hover,
	.btn-warning:active,
	.btn-warning:focus,
	.btn-danger:hover,
	.btn-danger:active,
	.btn-danger:focus {
		color: #fff
	}

	.btn-primary {
		background-color: #BF202F
	}

	.btn-primary:hover {
		background-color: #bd151d
	}

	.btn-success {
		background-color: #4caf50
	}

	.btn-success:hover {
		background-color: #3e8f41
	}

	.btn-info {
		background-color: #2196f3
	}

	.btn-info:hover {
		background-color: #0c7fda
	}

	.btn-warning {
		background-color: #ffa000
	}

	.btn-warning:hover {
		background-color: #d18300
	}

	.btn-danger {
		background-color: #f44336
	}

	.btn-danger:hover {
		background-color: #ef1d0d
	}

	.btn-white {
		background-color: #fff
	}

	.btn-white:hover {
		background-color: #e8e8e8
	}

	.btn-outline-secondary {
		border-color: #e5e5e5
	}

	.btn-outline-secondary:hover {
		background-color: #f5f5f5
	}

	.btn-outline-primary {
		border-color: #BF202F;
		background-color: transparent;
		color: #BF202F
	}

	.btn-outline-primary:hover {
		background-color: #BF202F;
		color: #fff
	}

	.btn-outline-success {
		border-color: #4caf50;
		background-color: transparent;
		color: #4caf50
	}

	.btn-outline-success:hover {
		background-color: #4caf50;
		color: #fff
	}

	.btn-outline-info {
		border-color: #2196f3;
		background-color: transparent;
		color: #2196f3
	}

	.btn-outline-info:hover {
		background-color: #2196f3;
		color: #fff
	}

	.btn-outline-warning {
		border-color: #ffa000;
		background-color: transparent;
		color: #ffa000
	}

	.btn-outline-warning:hover {
		background-color: #ffa000;
		color: #fff
	}

	.btn-outline-danger {
		border-color: #f44336;
		background-color: transparent;
		color: #f44336
	}

	.btn-outline-danger:hover {
		background-color: #f44336;
		color: #fff
	}

	.btn-outline-white {
		border-color: #fff;
		background-color: transparent;
		color: #fff;
		border-color: rgba(255, 255, 255, 0.3)
	}

	.btn-outline-white:hover {
		background-color: #fff;
		color: #fff
	}

	.btn-outline-white:hover {
		color: #505050
	}

	.btn-link-secondary {
		color: #505050
	}

	.btn-link-secondary:hover {
		color: #393939
	}

	.btn-link-primary {
		color: #BF202F
	}

	.btn-link-primary:hover {
		color: #bd151d
	}

	.btn-link-success {
		color: #4caf50
	}

	.btn-link-success:hover {
		color: #3e8f41
	}

	.btn-link-info {
		color: #2196f3
	}

	.btn-link-info:hover {
		color: #0c7fda
	}

	.btn-link-warning {
		color: #ffa000
	}

	.btn-link-warning:hover {
		color: #d18300
	}

	.btn-link-danger {
		color: #f44336
	}

	.btn-link-danger:hover {
		color: #ef1d0d
	}

	.btn-link-white {
		color: #fff
	}

	.btn-link-white:hover {
		color: #e8e8e8
	}

	.btn-link-secondary>i,
	.btn-link-primary>i,
	.btn-link-success>i,
	.btn-link-info>i,
	.btn-link-warning>i,
	.btn-link-danger>i,
	.btn-link-white>i {
		margin-top: -3px
	}

	.btn-group {
		display: -webkit-inline-box;
		display: -ms-inline-flexbox;
		display: inline-flex;
		position: relative;
		margin-top: 8px;
		margin-right: 12px;
		margin-bottom: 8px;
		vertical-align: middle
	}

	.btn-group .btn {
		position: relative;
		-webkit-box-flex: 0;
		-ms-flex: 0 1 auto;
		flex: 0 1 auto;
		margin: 0
	}

	.btn-group .btn:first-child:not(:last-child):not(.dropdown-toggle) {
		margin-right: -1px;
		padding-right: 12px;
		border-top-right-radius: 0;
		border-bottom-right-radius: 0
	}

	.btn-group .btn:first-child:not(:last-child):not(.dropdown-toggle).btn-secondary,
	.btn-group .btn:first-child:not(:last-child):not(.dropdown-toggle).btn-outline-secondary {
		border-right: 0
	}

	.btn-group>.dropdown-toggle:not(:first-child) {
		border-top-left-radius: 0;
		border-bottom-left-radius: 0
	}

	.btn+.dropdown-toggle-split {
		padding-right: 15px;
		padding-left: 8px
	}

	.text-center .btn,
	.text-center .btn-group {
		margin-right: 6px;
		margin-left: 6px
	}

	.text-right .btn,
	.text-right .btn-group {
		margin-right: 0;
		margin-left: 12px
	}

	.btn-block {
		display: block;
		width: 100%;
		margin-top: 12px;
		margin-right: 0 !important;
		margin-bottom: 12px;
		margin-left: 0 !important;
		padding-right: 15px !important;
		padding-left: 15px !important
	}

	.scroll-to-top-btn {
		display: block;
		position: fixed;
		right: 16px;
		bottom: -92px;
		width: 46px;
		height: 46px;
		transition: bottom 400ms cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.3s, background-color 0.3s, border-color 0.3s;
		border-radius: 5px;
		background-color: rgba(0, 0, 0, 0.25);
		color: #fff;
		font-size: 20px;
		opacity: 0;
		z-index: 2000;
		text-align: center;
		text-decoration: none
	}

	.scroll-to-top-btn:hover {
		background-color: rgba(0, 0, 0, 0.8);
		color: #fff
	}

	.scroll-to-top-btn:focus,
	.scroll-to-top-btn:active {
		color: #fff
	}

	.scroll-to-top-btn.visible {
		bottom: 14px;
		opacity: 1
	}

	.scroll-to-top-btn>i {
		line-height: 46px
	}

	@media (max-width: 768px) {
		.scroll-to-top-btn {
			bottom: -72px;
			width: 36px;
			height: 36px;
			line-height: 31px
		}

		.scroll-to-top-btn>i {
			line-height: 36px
		}
	}

	.market-button {
		display: inline-block;
		margin-right: 14px;
		margin-bottom: 14px;
		padding: 5px 14px 5px 45px;
		transition: background-color .3s;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-position: center left 12px;
		background-color: #fff;
		background-size: 24px 24px;
		background-repeat: no-repeat;
		text-decoration: none
	}

	.market-button:hover {
		background-color: #f5f5f5
	}

	.market-button .mb-subtitle {
		display: block;
		margin-bottom: -4px;
		color: #999;
		font-size: 12px
	}

	.market-button .mb-title {
		display: block;
		color: #505050;
		font-size: 18px
	}

	.market-button.apple-button {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAzMDUgMzA1IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAzMDUgMzA1OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCI+CjxnIGlkPSJYTUxJRF8yMjhfIj4KCTxwYXRoIGlkPSJYTUxJRF8yMjlfIiBkPSJNNDAuNzM4LDExMi4xMTljLTI1Ljc4NSw0NC43NDUtOS4zOTMsMTEyLjY0OCwxOS4xMjEsMTUzLjgyQzc0LjA5MiwyODYuNTIzLDg4LjUwMiwzMDUsMTA4LjIzOSwzMDUgICBjMC4zNzIsMCwwLjc0NS0wLjAwNywxLjEyNy0wLjAyMmM5LjI3My0wLjM3LDE1Ljk3NC0zLjIyNSwyMi40NTMtNS45ODRjNy4yNzQtMy4xLDE0Ljc5Ny02LjMwNSwyNi41OTctNi4zMDUgICBjMTEuMjI2LDAsMTguMzksMy4xMDEsMjUuMzE4LDYuMDk5YzYuODI4LDIuOTU0LDEzLjg2MSw2LjAxLDI0LjI1Myw1LjgxNWMyMi4yMzItMC40MTQsMzUuODgyLTIwLjM1Miw0Ny45MjUtMzcuOTQxICAgYzEyLjU2Ny0xOC4zNjUsMTguODcxLTM2LjE5NiwyMC45OTgtNDMuMDFsMC4wODYtMC4yNzFjMC40MDUtMS4yMTEtMC4xNjctMi41MzMtMS4zMjgtMy4wNjZjLTAuMDMyLTAuMDE1LTAuMTUtMC4wNjQtMC4xODMtMC4wNzggICBjLTMuOTE1LTEuNjAxLTM4LjI1Ny0xNi44MzYtMzguNjE4LTU4LjM2Yy0wLjMzNS0zMy43MzYsMjUuNzYzLTUxLjYwMSwzMC45OTctNTQuODM5bDAuMjQ0LTAuMTUyICAgYzAuNTY3LTAuMzY1LDAuOTYyLTAuOTQ0LDEuMDk2LTEuNjA2YzAuMTM0LTAuNjYxLTAuMDA2LTEuMzQ5LTAuMzg2LTEuOTA1Yy0xOC4wMTQtMjYuMzYyLTQ1LjYyNC0zMC4zMzUtNTYuNzQtMzAuODEzICAgYy0xLjYxMy0wLjE2MS0zLjI3OC0wLjI0Mi00Ljk1LTAuMjQyYy0xMy4wNTYsMC0yNS41NjMsNC45MzEtMzUuNjExLDguODkzYy02LjkzNiwyLjczNS0xMi45MjcsNS4wOTctMTcuMDU5LDUuMDk3ICAgYy00LjY0MywwLTEwLjY2OC0yLjM5MS0xNy42NDUtNS4xNTljLTkuMzMtMy43MDMtMTkuOTA1LTcuODk5LTMxLjEtNy44OTljLTAuMjY3LDAtMC41MywwLjAwMy0wLjc4OSwwLjAwOCAgIEM3OC44OTQsNzMuNjQzLDU0LjI5OCw4OC41MzUsNDAuNzM4LDExMi4xMTl6IiBmaWxsPSIjMmUyZTJlIi8+Cgk8cGF0aCBpZD0iWE1MSURfMjMwXyIgZD0iTTIxMi4xMDEsMC4wMDJjLTE1Ljc2MywwLjY0Mi0zNC42NzIsMTAuMzQ1LTQ1Ljk3NCwyMy41ODNjLTkuNjA1LDExLjEyNy0xOC45ODgsMjkuNjc5LTE2LjUxNiw0OC4zNzkgICBjMC4xNTUsMS4xNywxLjEwNywyLjA3MywyLjI4NCwyLjE2NGMxLjA2NCwwLjA4MywyLjE1LDAuMTI1LDMuMjMyLDAuMTI2YzE1LjQxMywwLDMyLjA0LTguNTI3LDQzLjM5NS0yMi4yNTcgICBjMTEuOTUxLTE0LjQ5OCwxNy45OTQtMzMuMTA0LDE2LjE2Ni00OS43N0MyMTQuNTQ0LDAuOTIxLDIxMy4zOTUtMC4wNDksMjEyLjEwMSwwLjAwMnoiIGZpbGw9IiMyZTJlMmUiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K)
	}

	.market-button.google-button {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPHBvbHlnb24gc3R5bGU9ImZpbGw6IzVDREFERDsiIHBvaW50cz0iMjkuNTMsMCAyOS41MywyNTEuNTA5IDI5LjUzLDUxMiAyOTkuMDA0LDI1MS41MDkgIi8+Cjxwb2x5Z29uIHN0eWxlPSJmaWxsOiNCREVDQzQ7IiBwb2ludHM9IjM2OS4wNjcsMTgwLjU0NyAyNjIuMTc1LDExOS40NjcgMjkuNTMsMCAyOTkuMDA0LDI1MS41MDkgIi8+Cjxwb2x5Z29uIHN0eWxlPSJmaWxsOiNEQzY4QTE7IiBwb2ludHM9IjI5LjUzLDUxMiAyOS41Myw1MTIgMjYyLjE3NSwzODMuNTUxIDM2OS4wNjcsMzIyLjQ3IDI5OS4wMDQsMjUxLjUwOSAiLz4KPHBhdGggc3R5bGU9ImZpbGw6I0ZGQ0E5NjsiIGQ9Ik0zNjkuMDY3LDE4MC41NDdsLTcwLjA2Myw3MC45NjFsNzAuMDYzLDcwLjk2MWwxMDguNjg4LTYyLjg3N2M2LjI4OC0zLjU5Myw2LjI4OC0xMS42NzcsMC0xNS4yNyAgTDM2OS4wNjcsMTgwLjU0N3oiLz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==)
	}

	.market-button.windows-button {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDQ4MCA0ODAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4MCA0ODA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8cGF0aCBkPSJNMC4xNzYsMjI0TDAuMDAxLDY3Ljk2M2wxOTItMjYuMDcyVjIyNEgwLjE3NnogTTIyNC4wMDEsMzcuMjQxTDQ3OS45MzcsMHYyMjRIMjI0LjAwMVYzNy4yNDF6IE00NzkuOTk5LDI1NmwtMC4wNjIsMjI0ICAgbC0yNTUuOTM2LTM2LjAwOFYyNTZINDc5Ljk5OXogTTE5Mi4wMDEsNDM5LjkxOEwwLjE1Nyw0MTMuNjIxTDAuMTQ3LDI1NmgxOTEuODU0VjQzOS45MTh6IiBmaWxsPSIjMDBiY2YyIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==)
	}

	.market-button.blackberry-button {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MDMuMzIyIDUwMy4zMjIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUwMy4zMjIgNTAzLjMyMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIyNHB4IiBoZWlnaHQ9IjI0cHgiPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik0xMTYuMjg1LDYwLjc0Nkg0NS45OTNsLTIwLjgyNyw5NS40NThoNzMuNzYzYzU3LjI3NSwwLDczLjc2My0yOC42MzcsNzMuNzYzLTUzLjgwMyAgICBDMTczLjU1OSw4NC4xNzYsMTYyLjI3OCw2MC43NDYsMTE2LjI4NSw2MC43NDZ6IiBmaWxsPSIjMmUyZTJlIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMjM4LjY0NCwzNDcuMTE5aC03MS4xNTlsLTE5Ljk1OSw5NS40NThoNzMuNzYzYzU3LjI3NSwwLDczLjc2My0yOC42MzcsNzMuNzYzLTUzLjgwMyAgICBDMjk1LjA1MSwzNzAuNTQ5LDI4NC42MzcsMzQ3LjExOSwyMzguNjQ0LDM0Ny4xMTl6IiBmaWxsPSIjMmUyZTJlIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNOTEuMTE5LDE5OS41OTNIMTkuOTU5TDAsMjk1LjA1MWg3My43NjNjNTcuMjc1LDAsNzMuNzYzLTI4LjYzNyw3My43NjMtNTMuODAzICAgIEMxNDcuNTI1LDIyMy4wMjQsMTM3LjExMiwxOTkuNTkzLDkxLjExOSwxOTkuNTkzeiIgZmlsbD0iIzJlMmUyZSIvPgoJPC9nPgo8L2c+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQyMC44ODEsMjk1LjA1MWgtNzEuMTU5bC0xOS45NTksODYuNzhoNzMuNzYzYzU3LjI3NSwwLDczLjc2My0yNC4yOTgsNzMuNzYzLTQ5LjQ2NCAgICBDNDc3LjI4OCwzMTQuMTQyLDQ2Ni44NzUsMjk1LjA1MSw0MjAuODgxLDI5NS4wNTF6IiBmaWxsPSIjMmUyZTJlIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDQ2LjkxNSwxNDcuNTI1aC03MS4xNTlsLTE5Ljk1OSw4Ni43OGg3My43NjNjNTcuMjc1LDAsNzMuNzYzLTI0LjI5OCw3My43NjMtNDkuNDY0ICAgIEM1MDMuMzIyLDE2Ni42MTcsNDkyLjkwOCwxNDcuNTI1LDQ0Ni45MTUsMTQ3LjUyNXoiIGZpbGw9IiMyZTJlMmUiLz4KCTwvZz4KPC9nPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik0yNjUuNTQ2LDE5OS41OTNoLTcxLjE1OWwtMTkuOTU5LDk1LjQ1OGg3My43NjNjNTcuMjc1LDAsNzMuNzYzLTI4LjYzNyw3My43NjMtNTMuODAzICAgIEMzMjIuODIsMjIzLjAyNCwzMTEuNTM5LDE5OS41OTMsMjY1LjU0NiwxOTkuNTkzeiIgZmlsbD0iIzJlMmUyZSIvPgoJPC9nPgo8L2c+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTI5MS41OCw2MC43NDZIMjIwLjQybC0xOS45NTksOTUuNDU4aDczLjc2M2M1Ny4yNzUsMCw3My43NjMtMjguNjM3LDczLjc2My01My44MDMgICAgQzM0Ny45ODYsODQuMTc2LDMzNy41NzMsNjAuNzQ2LDI5MS41OCw2MC43NDZ6IiBmaWxsPSIjMmUyZTJlIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==)
	}

	.market-button.amazon-button {
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAYAAABV7bNHAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2FpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTExIDc5LjE1ODMyNSwgMjAxNS8wOS8xMC0wMToxMDoyMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0idXVpZDo1RDIwODkyNDkzQkZEQjExOTE0QTg1OTBEMzE1MDhDOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGQUJGNjhGNDRGNkMxMUU3OUY5REJEQzBGNkVBQUI5QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGQUJGNjhGMzRGNkMxMUU3OUY5REJEQzBGNkVBQUI5QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo2QUM1ODJFMkIxNEExMUUzQkY1NEUzQkNCRjlEODA1RSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo2QUM1ODJFM0IxNEExMUUzQkY1NEUzQkNCRjlEODA1RSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PgNXCVIAAAc7SURBVHja5FwJbFRVFH0tQimgUCiubKJCWWSwKIooVhG3aESkETRqBEEEEURExBXiVhElkRiIEFwTQEHciQiIMQhFkUGFihErIJjWUgg0LFXqPf4z9jvMTOe/v9ebnEw78+//b85/y7n33T8ZNTU1yo5FIhEdtxMEXQRtBGcLOglO5ftoUKagSrBLUCLYKCgVbBEcNJ8oGo0qN+045Z2dJCgU9BdcJ2igcY4DgsWC9wTvetHoTA+u0ZlfCL3hJcFATXJgzQS3C5YIKgWT3G58hotDDMNlvmCQy9+hAj1ThtqqMPWgywXlHpADayVYKTfq0bAQdJ9guaCR8tamCUlPBZ2gcYIXlH82RUgaFlSCCgQzlf82T0hqFzSCGgreUsGxqUEj6BkKvaBYofSi5kERihCAE2z4rxYs4qp3WNBY0F0wVtBC85xNKUrnBoGgUdBTGn4IH24UbEvwGQh7TDBdMNGGQA3EELtGw2eh4Jwk5JjtAcFDmu0633clLeMcweYOi24IOLta9CnR6BF/CE4Whf2Xnz3oKg2fJzR8PtTwyaXK9nWIHbF4PFIYn2hcZ6Vm+5r4SpB039c5T5RwqO0VHE3hgoByv8alSm3oM99XsecJxSUaUXyOoKPgTOIMEjdK8xrVYSbIbIeIMsGPDp43Q/lkmap+W0bQepDTliU43oam+bM+EIT5qZcyEve5nL9aCtpzHmtq49zVYSOoraCv4AZBHgPc3P/7EOsgGCoYzt4SKnOTIAyZGYJrwzzLu0XQi4Lx9WEZdJqg0wVfqmAlzwJDUB/BmvompJwiqLND5FQwXtuujJ3TA1TlmM8eDytB2P9absMfaVbshryN+DeJuDsrzATNor7RMezV3xvkWMwWQZFIpIe8jNB0v0kZuedAm91gdaSm31iL5NSEjiDuO92h4bqGwzIUMaOdHnSe0ktpztfwaRwqgqT3QAheqHnNZZoyIlQ9COT00/BDzrpcwy9fs51ZfhEEXdJRw+8AdY9XBPm2q4HyklM0/HRqE7H3f4mN2NAXgrKUXgUZihGsVl0Mt7GKDfKLIAyTIxp+2cqoj7bSeybb+H5DZEE5zQ+CsEn4u6avlb2x2cpI2tuxiX4Q9JOquzIjmaHOuXcax6H0ZaADK/V46UW9vCYIavgLG43+XHBRks9QLP6B3TsfZ6/pOmqXv8hdGSAvn9psOIiap4zcD5bkQsINQ+agKBqN/uZVjFOsjAdLsm2co4DwwhAgY5/sfk9iMbkT++TlVRUus7zTajfdMcvjL7hEWa9oi9llclMf9JQgueBmVVv64rY9p4yiz9kW/VC01U33YRcnqjtQQLXWZXIeFsTu/tOC9Wn6oR6yPW+kljmViOrDRp/rMDEourpeHVujiJ60VaXOEy0TYq72K9RIZEigLXbwfNBZJ6rEBZw7Uugo2CtOkOM0QbDBmAyVveqybwUDGMFXpDjuG5W4bmiKkDPSqS/0r1A8PEfvAZneL+ck+wgJNVR1RIhEuRkEvHhUcyNJhWwosdgElNEsYGA7pnh05ZI0fJARRSF7W8Z6hxhbQtv9+k+64q7tx8xBmEca2gwh4odIMYce5qaWJKkBswEQbfvZIPSGn1XqCtnEanV0ZYncpNHKKLz6uI7DeyojGwr0IlHZvFEoPF/H6AAPDO+J70GLKPNxwC10qC92heBJ3qx0rEh60OT4HnQrleZQ3s1xIVTKiexKVbtRUEEgL76XqyBSx/GZx6aJlnl0+5s5JlH0hO2Z25i/2RpigjaRgHKKxkTWjcMrRsy+VKsYHvp/n39fyskTlWKtQ0rQbmVU6lelOOYHwXem/0vrWuYhzpaa/p9A7TFJ+biJ55BlUZVv4nSiuHDE6icxOa9KRwehEnVu3ImLBDuV8Qhm85AR04TtRvufVcZvhtzNz9qYRshazsFpCUVUbsTX5eARI8zwSDwh2ZUfcGIwv8yh3kK7c00TdkxQ9jcdP9Oqkp7GSbsqwUw/jBpmC4dh94CQAvF4D1X59ySieZwK72wSpbGNhF9UXDFYusHqR7woqsAuSNKgGSaBCE21QfCVh6REGHoMZqiSzCBdzFUpOaYg+0470fxOqu0pglQ/AdFP1e7bl/IubuHEt07pPS8Wbw05tLHK9mDYkFeHTzV7/Jtx76PCLYOB9kqnYrF8jtWLLX4xSPrNXHrLuWJgQizj31Uc9kd58zBf4PmzTozsWzPm6mJxkXiHwndX3PvNTOFOh/8sdQliMSu2gb1kiDJ+qyPdffpGjId6ejTs0HORrF+R5PNWXKnHuJXuWMCAD3tY21Rw7GtGAV1TkKPYc0aoFNvoTuWDZlBoTWLj/LIV7NUISt8IYsJsOhtXoIxk/l4PSNlMZYzJGj/stNDJk7tVHLmaeIQTeV9qqTxOjHasjAm2pZwL17nJvtvVo8gQfEZMZXKqHXVHPlekFswgNFK1JXPwO8gVZg/lwnpKht1ejtm/BRgAKCaVSdcawG4AAAAASUVORK5CYII=)
	}

	.market-button.mb-light-skin {
		border-color: rgba(255, 255, 255, 0.13);
		background-color: transparent
	}

	.market-button.mb-light-skin .mb-subtitle,
	.market-button.mb-light-skin .mb-title {
		color: #fff
	}

	.market-button.mb-light-skin .mb-subtitle {
		opacity: .55
	}

	.market-button.mb-light-skin:hover {
		background-color: rgba(255, 255, 255, 0.06)
	}

	.market-button.mb-light-skin.apple-button {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAzMDUgMzA1IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAzMDUgMzA1OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCI+CjxnIGlkPSJYTUxJRF8yMjhfIj4KCTxwYXRoIGlkPSJYTUxJRF8yMjlfIiBkPSJNNDAuNzM4LDExMi4xMTljLTI1Ljc4NSw0NC43NDUtOS4zOTMsMTEyLjY0OCwxOS4xMjEsMTUzLjgyQzc0LjA5MiwyODYuNTIzLDg4LjUwMiwzMDUsMTA4LjIzOSwzMDUgICBjMC4zNzIsMCwwLjc0NS0wLjAwNywxLjEyNy0wLjAyMmM5LjI3My0wLjM3LDE1Ljk3NC0zLjIyNSwyMi40NTMtNS45ODRjNy4yNzQtMy4xLDE0Ljc5Ny02LjMwNSwyNi41OTctNi4zMDUgICBjMTEuMjI2LDAsMTguMzksMy4xMDEsMjUuMzE4LDYuMDk5YzYuODI4LDIuOTU0LDEzLjg2MSw2LjAxLDI0LjI1Myw1LjgxNWMyMi4yMzItMC40MTQsMzUuODgyLTIwLjM1Miw0Ny45MjUtMzcuOTQxICAgYzEyLjU2Ny0xOC4zNjUsMTguODcxLTM2LjE5NiwyMC45OTgtNDMuMDFsMC4wODYtMC4yNzFjMC40MDUtMS4yMTEtMC4xNjctMi41MzMtMS4zMjgtMy4wNjZjLTAuMDMyLTAuMDE1LTAuMTUtMC4wNjQtMC4xODMtMC4wNzggICBjLTMuOTE1LTEuNjAxLTM4LjI1Ny0xNi44MzYtMzguNjE4LTU4LjM2Yy0wLjMzNS0zMy43MzYsMjUuNzYzLTUxLjYwMSwzMC45OTctNTQuODM5bDAuMjQ0LTAuMTUyICAgYzAuNTY3LTAuMzY1LDAuOTYyLTAuOTQ0LDEuMDk2LTEuNjA2YzAuMTM0LTAuNjYxLTAuMDA2LTEuMzQ5LTAuMzg2LTEuOTA1Yy0xOC4wMTQtMjYuMzYyLTQ1LjYyNC0zMC4zMzUtNTYuNzQtMzAuODEzICAgYy0xLjYxMy0wLjE2MS0zLjI3OC0wLjI0Mi00Ljk1LTAuMjQyYy0xMy4wNTYsMC0yNS41NjMsNC45MzEtMzUuNjExLDguODkzYy02LjkzNiwyLjczNS0xMi45MjcsNS4wOTctMTcuMDU5LDUuMDk3ICAgYy00LjY0MywwLTEwLjY2OC0yLjM5MS0xNy42NDUtNS4xNTljLTkuMzMtMy43MDMtMTkuOTA1LTcuODk5LTMxLjEtNy44OTljLTAuMjY3LDAtMC41MywwLjAwMy0wLjc4OSwwLjAwOCAgIEM3OC44OTQsNzMuNjQzLDU0LjI5OCw4OC41MzUsNDAuNzM4LDExMi4xMTl6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8cGF0aCBpZD0iWE1MSURfMjMwXyIgZD0iTTIxMi4xMDEsMC4wMDJjLTE1Ljc2MywwLjY0Mi0zNC42NzIsMTAuMzQ1LTQ1Ljk3NCwyMy41ODNjLTkuNjA1LDExLjEyNy0xOC45ODgsMjkuNjc5LTE2LjUxNiw0OC4zNzkgICBjMC4xNTUsMS4xNywxLjEwNywyLjA3MywyLjI4NCwyLjE2NGMxLjA2NCwwLjA4MywyLjE1LDAuMTI1LDMuMjMyLDAuMTI2YzE1LjQxMywwLDMyLjA0LTguNTI3LDQzLjM5NS0yMi4yNTcgICBjMTEuOTUxLTE0LjQ5OCwxNy45OTQtMzMuMTA0LDE2LjE2Ni00OS43N0MyMTQuNTQ0LDAuOTIxLDIxMy4zOTUtMC4wNDksMjEyLjEwMSwwLjAwMnoiIGZpbGw9IiNGRkZGRkYiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K)
	}

	.market-button.mb-light-skin.blackberry-button {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MDMuMzIyIDUwMy4zMjIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUwMy4zMjIgNTAzLjMyMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIyNHB4IiBoZWlnaHQ9IjI0cHgiPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik0xMTYuMjg1LDYwLjc0Nkg0NS45OTNsLTIwLjgyNyw5NS40NThoNzMuNzYzYzU3LjI3NSwwLDczLjc2My0yOC42MzcsNzMuNzYzLTUzLjgwMyAgICBDMTczLjU1OSw4NC4xNzYsMTYyLjI3OCw2MC43NDYsMTE2LjI4NSw2MC43NDZ6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMjM4LjY0NCwzNDcuMTE5aC03MS4xNTlsLTE5Ljk1OSw5NS40NThoNzMuNzYzYzU3LjI3NSwwLDczLjc2My0yOC42MzcsNzMuNzYzLTUzLjgwMyAgICBDMjk1LjA1MSwzNzAuNTQ5LDI4NC42MzcsMzQ3LjExOSwyMzguNjQ0LDM0Ny4xMTl6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNOTEuMTE5LDE5OS41OTNIMTkuOTU5TDAsMjk1LjA1MWg3My43NjNjNTcuMjc1LDAsNzMuNzYzLTI4LjYzNyw3My43NjMtNTMuODAzICAgIEMxNDcuNTI1LDIyMy4wMjQsMTM3LjExMiwxOTkuNTkzLDkxLjExOSwxOTkuNTkzeiIgZmlsbD0iI0ZGRkZGRiIvPgoJPC9nPgo8L2c+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQyMC44ODEsMjk1LjA1MWgtNzEuMTU5bC0xOS45NTksODYuNzhoNzMuNzYzYzU3LjI3NSwwLDczLjc2My0yNC4yOTgsNzMuNzYzLTQ5LjQ2NCAgICBDNDc3LjI4OCwzMTQuMTQyLDQ2Ni44NzUsMjk1LjA1MSw0MjAuODgxLDI5NS4wNTF6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8L2c+CjwvZz4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDQ2LjkxNSwxNDcuNTI1aC03MS4xNTlsLTE5Ljk1OSw4Ni43OGg3My43NjNjNTcuMjc1LDAsNzMuNzYzLTI0LjI5OCw3My43NjMtNDkuNDY0ICAgIEM1MDMuMzIyLDE2Ni42MTcsNDkyLjkwOCwxNDcuNTI1LDQ0Ni45MTUsMTQ3LjUyNXoiIGZpbGw9IiNGRkZGRkYiLz4KCTwvZz4KPC9nPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik0yNjUuNTQ2LDE5OS41OTNoLTcxLjE1OWwtMTkuOTU5LDk1LjQ1OGg3My43NjNjNTcuMjc1LDAsNzMuNzYzLTI4LjYzNyw3My43NjMtNTMuODAzICAgIEMzMjIuODIsMjIzLjAyNCwzMTEuNTM5LDE5OS41OTMsMjY1LjU0NiwxOTkuNTkzeiIgZmlsbD0iI0ZGRkZGRiIvPgoJPC9nPgo8L2c+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTI5MS41OCw2MC43NDZIMjIwLjQybC0xOS45NTksOTUuNDU4aDczLjc2M2M1Ny4yNzUsMCw3My43NjMtMjguNjM3LDczLjc2My01My44MDMgICAgQzM0Ny45ODYsODQuMTc2LDMzNy41NzMsNjAuNzQ2LDI5MS41OCw2MC43NDZ6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==)
	}

	.market-button.mb-light-skin.amazon-button {
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAYAAABV7bNHAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2FpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTExIDc5LjE1ODMyNSwgMjAxNS8wOS8xMC0wMToxMDoyMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0idXVpZDo1RDIwODkyNDkzQkZEQjExOTE0QTg1OTBEMzE1MDhDOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo1QjFCQzQ2QjRGNkQxMUU3OUY5REJEQzBGNkVBQUI5QiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo1QjFCQzQ2QTRGNkQxMUU3OUY5REJEQzBGNkVBQUI5QiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo2QUM1ODJFMkIxNEExMUUzQkY1NEUzQkNCRjlEODA1RSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo2QUM1ODJFM0IxNEExMUUzQkY1NEUzQkNCRjlEODA1RSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pk2CzRIAAAcFSURBVHja5FxpbBZVFH2ULlhQCq2oiBWLWqCI0AoqKILgGo2KEqlGjSKKIuJaC9EgRKNYURL9YQ2KawKICO5RqZYYsKDFtS1VsSpaU2ypgQYo0HpP5lTGz2/pvNnrTU7yLXNn3px5775777tvurW3tysf5DDBEMEAwUmCEwX9+TsalCRoEfwuqBF8KagTVAt2e9nQZA+vdYRgimCi4GJBd41z7BK8LlgjeMOTVqMHuYxcwRrBgXZnZYegyO32d3NxiGG4LBVMdvkZN7JnfuzGyZNcavQkwXYPyIFkCsoED4SFoDsFHwpSPTb8CwQPO31Sp4fYbMFi5a9MEzwfRILGu2UHNORYwS9BGmIpgldVcGR+0GzQI3T0giKY1XoHZYjBAazHuTT1ywUrOOvtFfQQDBPMEmTYaNd0wZIgOIrzNB29zYKcBOcuseFIljjhKDoxxC7U0FkuGCnYmuC4ewVzNNt1ahCGGILNXy3qIOAcalEHAWuuRZ0/BUcKDvhppM/X0HlQQ+dtDZ0setm+zmKtFo9HCuM9jeuUabYv3e90x0uCfvReewoOZZAai3g4kjs1rlNnwz8LVKjRgwT1EeQIjicGCdoEM5gEsyonCGo19PIEVUFKmO0hGgRbnIwZ/fI4k1TXFtvEJgf8BtNo13R9mv1dgSDYpwJlJO6zaL/6MiLPofHXlX1hI+gYwVjBZYLBDHCz/u9DbKCgkK7AoLAZMTcJwpBZJLgozFbeLYKeFNzRFaZBpwk6TvCpClbyLDAEnS5Y39UcKacIynWInEbGa0i471DGUnMD7dk8XzxNB2IxrH/9wClcR5BmxVLRa4KvYjh3urEY4sAf/e5BT9sg5ynB7UGOxewSNFwZyXEduVIZyfpAi91g9SZNvVkWyWkPI0FYd7peQ289h2UoYkY7BI1SeinNpRo6PcJGEBzBMZq672u6EaEiCOSM09BrVsYKqlXJ12xnml8EwS/J0dDbRb/HK4LS/SIoW3CUhp5O4SbW/s+yERv6QlCa0qsgy1DWqy6m2ZjFJvtFEIZJq4beIcqoj7bSe4pt3N9UwdF+EIT1+D80dWdYOPYZZSTt7cg9fhD0vUpcmRFLrhOM7sRxJYJLHZipkbgr8JogeMPrbDT6E8EZMf7rJXjL7pOPkBf9SHecI/jAZsNB1HPKyP1gSp5CuCHIHCwU/OYVQZiN6ml4wyJPCO72Khb7S/CCCpfs93KIQVAp9p2HN7iKQbJOgu5spVHHbTcfhNKSxz0i5zHB5Zz6rQiKtvKUbpG7Q9uGNrS7K3Mjrrexk3pVgsygbIfaJDjF4V6DoqtL1H9rFDHEahPkiZBWucB2CxzegLbSwV5TnuDpF8TRfdape3Jjl94EQY0NYioFkzp5rdFR9Oe4suNwb2m2Xlh/c8xNNUiooarjZCJabgYBL2oWsWl3C92GGotNQBnNMga2M+U+VnVCBxnRkRyqiPX2MLbcKPjZfF/mNAKWjlNshhBmWccLjqJt6kuSujMbgOKmnWzQF8pY4GuznFYoza6Rm7lVGYVX7yY4fASzoWMYn/Wno4sHhcLzCkYH2DDc9C8/SC60gm4+DriaCl1FzhU8xIfVGVkopBdH9qBr6GkW8mnODqGnHE3OUwcXChoJ5MWbOQvmRMk8/lP2lxyRBLuKYxJFT1ieuZb5m9oQE/Q1CdhOpzGa5HF49TSFUTE9aWz6f5OfJ9B4olLs8JAShIC6Lg45iuHSN6bvdYlCDThnq03f72IWsUj5uIjnkCCffh97ViF/w8TRUT/ZZA5L4sViqERdEnFi5FO2KWMLZu+QEZPOdqP9jyrjnSG38L8BphHymTKVzCQKVlG5EVm4hC1GxUw8IdmVH3BiYF9K6W+h3Vkmg91RfDHRdPxiq9H8AhrtliiW/gb6MNUchsMCQgqcx9sEmwXfkghzj0ebc01OacdCwk/KeCmCijaLxZN3eFFUgZ0Wo0GLTA4ifKpKwQYPSYG3ji0LVzAdHEvgupirUvqYguwbIw+2siC3jd72XBX/FRDj1MF1+zo+xWoavgqlt18sUlI4tDHLDmfYMDiBzj72+FcifkeFGyrY8NqdspgZRYuxWD7H6pkWb6yVSbZ6+iVNNIgN/NzCYd/Ghwd7gf1nKOLsR0OKmGuIxUliJR3fyL1qvUzhzsBoMabukm4le8lUJsI7u06fynhohEfDDj0X1WxrY/yfyZl6plsp12UM+LCGtVUFRz5nFDA0DjmKPWe6irOM7tSGukV0tIrYOL9kLXs1gtKXnTih0zsOS9i48cpI5jd7QEoVPWMYa7zYabmTJ3erOLKcuJ+GfCx9qcE0jHakgQm21bSFFW6y73b1KDIEHxHzmZzKpt+RzxkpgxmEVHWwZA56uznDNNFd2ESXod7LMfu3AAMA3eQjZHI91/8AAAAASUVORK5CYII=)
	}

	.facebook-btn,
	.twitter-btn,
	.google-btn {
		text-transform: none
	}

	.facebook-btn>i,
	.twitter-btn>i,
	.google-btn>i {
		margin-top: 0
	}

	.facebook-btn {
		border-color: #3b5998;
		background-color: transparent;
		color: #3b5998
	}

	.facebook-btn:hover {
		background-color: #3b5998;
		color: #fff
	}

	.twitter-btn {
		border-color: #55acee;
		background-color: transparent;
		color: #55acee
	}

	.twitter-btn:hover {
		background-color: #55acee;
		color: #fff
	}

	.google-btn {
		border-color: #dd4b39;
		background-color: transparent;
		color: #dd4b39
	}

	.google-btn>i {
		font-size: 1.3em
	}

	.google-btn:hover {
		background-color: #dd4b39;
		color: #fff
	}

	.social-button {
		display: inline-block;
		margin-top: 5px;
		margin-right: 18px;
		margin-bottom: 5px;
		transition: color .3s;
		color: #505050;
		font-size: 12px;
		text-decoration: none;
		vertical-align: middle
	}

	.social-button.shape-circle,
	.social-button.shape-rounded,
	.social-button.shape-square {
		width: 36px;
		height: 36px;
		margin-right: 8px;
		border: 1px solid #e5e5e5;
		line-height: 35px;
		text-align: center
	}

	.social-button.shape-circle {
		border-radius: 50%
	}

	.social-button.shape-rounded {
		border-radius: 5px
	}

	.social-button:focus {
		text-decoration: none
	}

	.text-center .social-button {
		margin-right: 9px;
		margin-left: 9px
	}

	.text-center .social-button.shape-circle,
	.text-center .social-button.shape-rounded,
	.text-center .social-button.shape-square {
		margin-right: 4px;
		margin-left: 4px
	}

	.text-right .social-button {
		margin-right: 0;
		margin-left: 18px
	}

	.text-right .social-button.shape-circle,
	.text-right .social-button.shape-rounded,
	.text-right .social-button.shape-square {
		margin-right: 0;
		margin-left: 8px
	}

	.sb-amazon {
		font-size: 1.15em !important
	}

	.sb-amazon:hover,
	.sb-amazon:focus {
		color: #ff9900 !important
	}

	.sb-airbnb:hover,
	.sb-airbnb:focus {
		color: #fd5c63 !important
	}

	.sb-behance {
		font-size: 1.1em !important
	}

	.sb-behance:hover,
	.sb-behance:focus {
		color: #1769ff !important
	}

	.sb-deviantart {
		font-size: 1.2em !important
	}

	.sb-deviantart:hover,
	.sb-deviantart:focus {
		color: #4e6252 !important
	}

	.sb-digg {
		font-size: 1.2em !important
	}

	.sb-digg:hover,
	.sb-digg:focus {
		color: #000000 !important
	}

	.sb-disqus {
		font-size: 1.1em !important
	}

	.sb-disqus:hover,
	.sb-disqus:focus {
		color: #2e9fff !important
	}

	.sb-dribbble:hover,
	.sb-dribbble:focus {
		color: #ea4c89 !important
	}

	.sb-drupal {
		font-size: 1.1em !important
	}

	.sb-drupal:hover,
	.sb-drupal:focus {
		color: #0077c0 !important
	}

	.sb-email:hover,
	.sb-email:focus {
		color: #BF202F !important
	}

	.sb-facebook:hover,
	.sb-facebook:focus {
		color: #3b5998 !important
	}

	.sb-flickr:hover,
	.sb-flickr:focus {
		color: #0063dc !important
	}

	.sb-foursquare:hover,
	.sb-foursquare:focus {
		color: #ef4b78 !important
	}

	.sb-github:hover,
	.sb-github:focus {
		color: #4183c4 !important
	}

	.sb-google-plus {
		font-size: 1.2em !important
	}

	.sb-google-plus:hover,
	.sb-google-plus:focus {
		color: #dd4b39 !important
	}

	.sb-instagram:hover,
	.sb-instagram:focus {
		color: #3f729b !important
	}

	.sb-lastfm {
		font-size: 1.1em !important
	}

	.sb-lastfm:hover,
	.sb-lastfm:focus {
		color: #e31b23 !important
	}

	.sb-linkedin:hover,
	.sb-linkedin:focus {
		color: #0976b4 !important
	}

	.sb-odnoklassniki {
		font-size: 1.1em !important
	}

	.sb-odnoklassniki:hover,
	.sb-odnoklassniki:focus {
		color: #ed812b !important
	}

	.sb-paypal {
		font-size: .9em !important
	}

	.sb-paypal:hover,
	.sb-paypal:focus {
		color: #253b80 !important
	}

	.sb-pinterest:hover,
	.sb-pinterest:focus {
		color: #cc2127 !important
	}

	.sb-reddit {
		font-size: 1.1em !important
	}

	.sb-reddit:hover,
	.sb-reddit:focus {
		color: #ff4500 !important
	}

	.sb-rss {
		font-size: .9em !important
	}

	.sb-rss:hover,
	.sb-rss:focus {
		color: #f26522 !important
	}

	.sb-skype {
		font-size: .9em !important
	}

	.sb-skype:hover,
	.sb-skype:focus {
		color: #00aff0 !important
	}

	.sb-soundcloud {
		font-size: 1.2em !important
	}

	.sb-soundcloud:hover,
	.sb-soundcloud:focus {
		color: #ff8800 !important
	}

	.sb-stackoverflow:hover,
	.sb-stackoverflow:focus {
		color: #fe7a15 !important
	}

	.sb-steam:hover,
	.sb-steam:focus {
		color: #7da10e !important
	}

	.sb-stumbleupon:hover,
	.sb-stumbleupon:focus {
		color: #eb4924 !important
	}

	.sb-tumblr:hover,
	.sb-tumblr:focus {
		color: #35465c !important
	}

	.sb-twitch:hover,
	.sb-twitch:focus {
		color: #6441a5 !important
	}

	.sb-twitter:hover,
	.sb-twitter:focus {
		color: #55acee !important
	}

	.sb-vimeo:hover,
	.sb-vimeo:focus {
		color: #1ab7ea !important
	}

	.sb-vine:hover,
	.sb-vine:focus {
		color: #00b488 !important
	}

	.sb-vk {
		font-size: 1.1em !important
	}

	.sb-vk:hover,
	.sb-vk:focus {
		color: #45668e !important
	}

	.sb-wordpress:hover,
	.sb-wordpress:focus {
		color: #21759b !important
	}

	.sb-xing:hover,
	.sb-xing:focus {
		color: #026466 !important
	}

	.sb-yahoo {
		font-size: 1.1em !important
	}

	.sb-yahoo:hover,
	.sb-yahoo:focus {
		color: #400191 !important
	}

	.sb-yelp:hover,
	.sb-yelp:focus {
		color: #af0606 !important
	}

	.sb-youtube:hover,
	.sb-youtube:focus {
		color: #e52d27 !important
	}

	.sb-light-skin {
		transition: all .3s;
		background-color: transparent;
		color: rgba(255, 255, 255, 0.6) !important
	}

	.sb-light-skin:hover,
	.sb-light-skin:focus {
		color: #fff !important
	}

	.sb-light-skin.shape-circle,
	.sb-light-skin.shape-rounded,
	.sb-light-skin.shape-square {
		border-color: rgba(255, 255, 255, 0.13)
	}

	.sb-light-skin.shape-circle:hover,
	.sb-light-skin.shape-rounded:hover,
	.sb-light-skin.shape-square:hover {
		background-color: rgba(255, 255, 255, 0.06)
	}

	.nav-tabs {
		border-bottom-color: #e5e5e5
	}

	.nav-tabs .nav-link {
		padding: 10px 20px;
		transition: color .3s;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
		color: #505050;
		font-size: 15px;
		font-weight: normal;
		letter-spacing: .025em;
		text-decoration: none
	}

	.nav-tabs .nav-link:hover {
		color: #BF202F
	}

	.nav-tabs .nav-link:hover,
	.nav-tabs .nav-link:focus {
		border-color: transparent
	}

	.nav-tabs .nav-link.disabled {
		cursor: not-allowed
	}

	.nav-tabs .nav-link.disabled,
	.nav-tabs .nav-link.disabled:hover {
		color: #999
	}

	.nav-tabs .nav-link>i {
		margin-top: -3px;
		margin-right: 5px
	}

	.nav-tabs .nav-item.dropdown {
		margin-bottom: -3px
	}

	.nav-tabs .nav-item.dropdown .dropdown-menu {
		margin-top: -3px
	}

	.nav-tabs .nav-item.show .nav-link,
	.nav-tabs .nav-link.active {
		border-color: #e5e5e5 #e5e5e5 #fff;
		color: #919191
	}

	.tab-content {
		padding: 24px;
		border-right: 1px solid #e5e5e5;
		border-bottom: 1px solid #e5e5e5;
		border-left: 1px solid #e5e5e5;
		border-bottom-left-radius: 6px;
		border-bottom-right-radius: 6px;
		overflow: hidden
	}

	.tab-content p:last-child,
	.tab-content ul:last-child,
	.tab-content ol:last-child {
		margin-bottom: 0
	}

	.nav-pills .nav-link {
		margin-right: 5px;
		padding: 6px 16px;
		transition: all .3s;
		border: 1px solid transparent;
		border-radius: 5px;
		color: #505050;
		font-size: 14px;
		font-weight: 400;
		letter-spacing: .025em;
		text-transform: none;
		text-decoration: none
	}

	.nav-pills .nav-link:hover:not(.disabled) {
		border-color: #e5e5e5;
		background-color: #f5f5f5
	}

	.nav-pills .nav-link.disabled {
		color: #999;
		cursor: not-allowed
	}

	.nav-pills .nav-link>i {
		display: inline-block;
		margin-top: -1px;
		margin-right: 5px;
		vertical-align: middle
	}

	.nav-pills .nav-item.show .nav-link,
	.nav-pills .nav-link.active {
		border-color: #BF202F;
		background-color: #BF202F !important;
		color: #fff;
		cursor: default
	}

	.nav-pills+.tab-content {
		padding: 24px 0 0;
		border: 0;
		border-radius: 0
	}

	.nav-pills.nav-justified .nav-link {
		margin-right: 0
	}

	.nav-pills.justify-content-center .nav-link {
		margin: 0 3px
	}

	.nav-pills.justify-content-end .nav-link {
		margin: 0 0 0 5px
	}

	.nav-pills.flex-column .nav-link {
		margin: 0 0 5px
	}

	.transition.fade {
		transition: all .4s ease-in-out;
		opacity: 0;
		-webkit-backface-visibility: hidden;
		backface-visibility: hidden
	}

	.transition.fade.show {
		opacity: 1
	}

	.transition.scale.fade {
		-webkit-transform: scale(0.9);
		-ms-transform: scale(0.9);
		transform: scale(0.9)
	}

	.transition.scaledown.fade {
		-webkit-transform: scale(1.1);
		-ms-transform: scale(1.1);
		transform: scale(1.1)
	}

	.transition.scale.fade.show,
	.transition.scaledown.fade.show {
		-webkit-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1)
	}

	.transition.left.fade {
		-webkit-transform: translateX(40px);
		-ms-transform: translateX(40px);
		transform: translateX(40px)
	}

	.transition.right.fade {
		-webkit-transform: translateX(-40px);
		-ms-transform: translateX(-40px);
		transform: translateX(-40px)
	}

	.transition.left.fade.show,
	.transition.right.fade.show {
		-webkit-transform: translateX(0);
		-ms-transform: translateX(0);
		transform: translateX(0)
	}

	.transition.top.fade {
		-webkit-transform: translateY(-40px);
		-ms-transform: translateY(-40px);
		transform: translateY(-40px)
	}

	.transition.bottom.fade {
		-webkit-transform: translateY(40px);
		-ms-transform: translateY(40px);
		transform: translateY(40px)
	}

	.transition.top.fade.show,
	.transition.bottom.fade.show {
		-webkit-transform: translateY(0);
		-ms-transform: translateY(0);
		transform: translateY(0)
	}

	.transition.flip.fade {
		-webkit-transform: rotateY(-90deg) scale(1.1);
		transform: rotateY(-90deg) scale(1.1);
		-webkit-transform-origin: 50% 50%;
		-ms-transform-origin: 50% 50%;
		transform-origin: 50% 50%
	}

	.transition.flip.fade.show {
		-webkit-transform: rotateY(0deg) scale(1);
		transform: rotateY(0deg) scale(1);
		-webkit-transform-origin: 50% 50%;
		-ms-transform-origin: 50% 50%;
		transform-origin: 50% 50%
	}

	.card {
		border-radius: 5px;
		border-color: #e5e5e5
	}

	.card .google-map {
		border-top-left-radius: 5px;
		border-top-right-radius: 5px
	}

	a.card {
		color: inherit;
		text-decoration: none
	}

	.card-header {
		border-bottom-color: #e5e5e5
	}

	.card-header h1,
	.card-header .h1,
	.card-header h2,
	.card-header .h2,
	.card-header h3,
	.card-header .h3,
	.card-header h4,
	.card-header .h4,
	.card-header h5,
	.card-header .h5,
	.card-header h6,
	.card-header .h6 {
		margin-bottom: 0
	}

	.card-header:first-child {
		border-radius: 5px 5px 0 0
	}

	.card-header,
	.card-footer {
		background-color: #f5f5f5
	}

	.card-footer {
		border-top-color: #e5e5e5
	}

	.card-footer:last-child {
		border-radius: 0 0 5px 5px
	}

	.card-body p:last-child,
	.card-body ol:last-child,
	.card-body ul:last-child {
		margin-bottom: 0
	}

	.card-body .tab-content {
		padding: 0;
		border: 0
	}

	.card.bg-primary {
		border-color: #cf1720
	}

	.card.bg-primary .card-header {
		border-bottom-color: #cf1720;
		background-color: #dd1822
	}

	.card.bg-secondary .card-header,
	.card.bg-faded .card-header {
		background-color: #ededed
	}

	.card.bg-success {
		border-color: #409343
	}

	.card.bg-success .card-header {
		border-bottom-color: #409343;
		background-color: #439a46
	}

	.card.bg-info {
		border-color: #0b76cc
	}

	.card.bg-info .card-header {
		border-bottom-color: #0b76cc;
		background-color: #0d87e9
	}

	.card.bg-warning {
		border-color: #c27a00
	}

	.card.bg-warning .card-header {
		border-bottom-color: #c27a00;
		background-color: #e08d00
	}

	.card.bg-danger {
		border-color: #e11b0c
	}

	.card.bg-danger .card-header {
		border-bottom-color: #e11b0c;
		background-color: #f22819
	}

	.card.bg-dark {
		border-color: #0f0f0f
	}

	.card.bg-dark .card-header {
		border-bottom-color: #0f0f0f;
		background-color: #141414
	}

	.text-white .card-title,
	.text-light .card-title {
		color: #fff
	}

	.card-group .card .card-footer {
		border-radius: 0
	}

	.card-group .card:first-child .card-footer {
		border-bottom-left-radius: 5px
	}

	.card-group .card:last-child .card-footer {
		border-bottom-right-radius: 5px
	}

	.card-img-tiles {
		display: block;
		border-bottom: 1px solid #e5e5e5
	}

	.card-img-tiles>.inner {
		display: table;
		width: 100%
	}

	.card-img-tiles .main-img,
	.card-img-tiles .thumblist {
		display: table-cell;
		width: 65%;
		padding: 15px;
		vertical-align: middle
	}

	.card-img-tiles .main-img>img,
	.card-img-tiles .thumblist>img {
		display: block;
		width: 100%;
		margin-bottom: 6px
	}

	.card-img-tiles .main-img>img:last-child,
	.card-img-tiles .thumblist>img:last-child {
		margin-bottom: 0
	}

	.card-img-tiles .thumblist {
		width: 35%;
		border-left: 1px solid #e5e5e5
	}

	.card-label {
		display: inline-block;
		padding: 2px 4px;
		border: 1px solid #e5e5e5;
		border-radius: 3px;
		background-color: #f5f5f5;
		color: #232323;
		vertical-align: middle
	}

	.accordion .card {
		margin-bottom: 8px;
		border-bottom: 1px solid #e5e5e5 !important;
		border-radius: 5px !important
	}

	.accordion .card-header {
		padding: 0;
		transition: background-color .3s;
		background-color: #fff
	}

	.accordion .card-header:hover {
		background-color: #f5f5f5
	}

	.accordion [data-toggle='collapse'] {
		display: block;
		position: relative;
		padding: .85rem 1.25rem;
		color: #232323;
		font-size: 16px;
		text-decoration: none
	}

	.accordion [data-toggle='collapse']::after {
		position: absolute;
		top: 50%;
		right: 1rem;
		margin-top: -12px;
		transition: -webkit-transform .25s;
		transition: transform .25s;
		font-family: feather;
		font-size: 18px;
		content: '\e931'
	}

	.accordion [data-toggle='collapse'].collapsed::after {
		-webkit-transform: rotate(-180deg);
		-ms-transform: rotate(-180deg);
		transform: rotate(-180deg)
	}

	.accordion [data-toggle='collapse']>i {
		display: inline-block;
		margin-top: -3px;
		margin-right: 7px;
		vertical-align: middle
	}

	.accordion [data-toggle='collapse']>i.socicon-paypal {
		margin-top: 1px;
		font-size: .8em
	}

	.pagination {
		display: table;
		width: 100%;
		border-top: 1px solid #e5e5e5
	}

	.pagination>.column {
		display: table-cell;
		padding-top: 16px;
		vertical-align: middle
	}

	.pagination .pages {
		display: block;
		margin: 0;
		padding: 0;
		list-style: none
	}

	.pagination .pages>li {
		display: inline-block;
		width: 36px;
		height: 36px;
		font-size: 14px;
		font-weight: 400;
		line-height: 34px;
		text-align: center
	}

	.pagination .pages>li>a {
		display: block;
		width: 36px;
		height: 36px;
		transition: all .3s;
		border: 1px solid transparent;
		border-radius: 4px;
		color: #505050;
		line-height: 34px;
		text-decoration: none
	}

	.pagination .pages>li>a:hover {
		border-color: #e5e5e5;
		background-color: #f5f5f5
	}

	.pagination .pages>li.active>a {
		border-color: #BF202F;
		background-color: #BF202F;
		color: #fff
	}

	.pagination .btn-sm {
		font-size: 13px
	}

	.pagination .btn-sm>i {
		font-size: 1.1em
	}

	.entry-navigation {
		display: table;
		width: 100%;
		border-top: 1px solid #e5e5e5;
		border-bottom: 1px solid #e5e5e5;
		table-layout: fixed
	}

	.entry-navigation>.column {
		display: table-cell;
		padding-top: 15px;
		padding-bottom: 15px;
		text-align: center;
		vertical-align: middle
	}

	.entry-navigation .btn-sm {
		font-size: 13px
	}

	.entry-navigation .btn-sm>i {
		font-size: 1.1em
	}

	.entry-navigation .btn {
		margin: 0
	}

	.entry-navigation .btn.view-all {
		width: 46px;
		padding-right: 0;
		padding-left: 1px
	}

	.entry-navigation .btn.view-all>i {
		margin-top: -2px;
		font-size: 1.4em
	}

	.comment {
		display: block;
		position: relative;
		margin-bottom: 30px;
		padding-left: 66px
	}

	.comment .comment-author-ava {
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		width: 50px;
		border-radius: 50%;
		overflow: hidden
	}

	.comment .comment-author-ava>img {
		display: block;
		width: 100%
	}

	.comment .comment-body {
		position: relative;
		padding: 24px;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff
	}

	.comment .comment-body::after,
	.comment .comment-body::before {
		position: absolute;
		top: 12px;
		right: 100%;
		width: 0;
		height: 0;
		border: solid transparent;
		content: '';
		pointer-events: none
	}

	.comment .comment-body::after {
		border-width: 9px;
		border-color: transparent;
		border-right-color: #fff
	}

	.comment .comment-body::before {
		margin-top: -1px;
		border-width: 10px;
		border-color: transparent;
		border-right-color: #e5e5e5
	}

	.comment .comment-title {
		margin-bottom: 8px;
		font-size: 16px;
		font-weight: normal
	}

	.comment .comment-text {
		margin-bottom: 12px
	}

	.comment .comment-footer {
		display: table;
		width: 100%
	}

	.comment .comment-footer>.column {
		display: table-cell;
		vertical-align: middle
	}

	.comment .comment-footer>.column:last-child {
		text-align: right
	}

	.comment .comment-meta {
		color: #999;
		font-size: 12px
	}

	.comment .reply-link {
		transition: color .3s;
		color: #505050;
		font-size: 15px;
		font-weight: normal;
		letter-spacing: .025em;
		text-decoration: none
	}

	.comment .reply-link>i {
		display: inline-block;
		margin-top: -3px;
		margin-right: 4px;
		vertical-align: middle
	}

	.comment .reply-link:hover {
		color: #BF202F
	}

	.comment.comment-reply {
		margin-top: 30px;
		margin-bottom: 0
	}

	@media (max-width: 576px) {
		.comment {
			padding-left: 0
		}

		.comment .comment-author-ava {
			display: none
		}

		.comment .comment-body {
			padding: 15px
		}

		.comment .comment-body::before,
		.comment .comment-body::after {
			display: none
		}
	}

	.tooltip {
		font-family: "Rubik", Helvetica, Arial, sans-serif
	}

	.tooltip.bs-tooltip-top .arrow::before {
		border-top-color: #191919
	}

	.tooltip.bs-tooltip-right .arrow::before {
		border-right-color: #191919
	}

	.tooltip.bs-tooltip-bottom .arrow::before {
		border-bottom-color: #191919
	}

	.tooltip.bs-tooltip-left .arrow::before {
		border-left-color: #191919
	}

	.tooltip.show {
		opacity: 1
	}

	.tooltip-inner {
		border-radius: 3px;
		background-color: #191919;
		color: #fff;
		font-size: 12px
	}

	.popover {
		border-radius: 5px;
		border-color: #e5e5e5;
		font-family: "Rubik", Helvetica, Arial, sans-serif
	}

	.popover.bs-popover-top .arrow::before {
		border-top-color: #dbdbdb
	}

	.popover.bs-popover-right .arrow::before {
		border-right-color: #dbdbdb
	}

	.popover.bs-popover-bottom .arrow::before {
		border-bottom-color: #dbdbdb
	}

	.popover.bs-popover-bottom .arrow::after {
		border-bottom-color: #f7f7f7
	}

	.popover.bs-popover-left .arrow::before {
		border-left-color: #dbdbdb
	}

	.popover-header {
		color: #232323;
		font-family: inherit;
		font-weight: normal
	}

	.popover-body {
		color: #505050
	}

	.example-tooltip .tooltip {
		display: inline-block;
		position: relative;
		margin: 10px 20px;
		opacity: 1
	}

	.example-popover .popover {
		display: block;
		position: relative;
		width: 260px;
		margin: 1.25rem;
		float: left
	}

	.bs-tooltip-bottom-demo .arrow,
	.bs-tooltip-top-demo .arrow {
		left: 50%;
		margin-left: -2px
	}

	.bs-tooltip-left-demo .arrow,
	.bs-tooltip-right-demo .arrow {
		top: 50%;
		margin-top: -6px
	}

	.bs-popover-bottom-demo .arrow,
	.bs-popover-top-demo .arrow {
		left: 50%;
		margin-left: -11px
	}

	.bs-popover-left-demo .arrow,
	.bs-popover-right-demo .arrow {
		top: 50%;
		margin-top: -8px
	}

	.dropdown-menu {
		border-color: #e5e5e5;
		border-radius: 5px;
		font-size: 14px;
		box-shadow: 0 7px 22px -5px rgba(0, 0, 0, 0.2)
	}

	.dropdown-menu .dropdown-item {
		position: relative;
		padding-right: 20px;
		padding-left: 20px;
		transition: color .3s;
		color: #505050;
		text-decoration: none
	}

	.dropdown-menu .dropdown-item::before {
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		width: 2px;
		height: 100%;
		background-color: #BF202F;
		content: '';
		opacity: 0;
		visibility: hidden
	}

	.dropdown-menu .dropdown-item:hover,
	.dropdown-menu .dropdown-item.active,
	.dropdown-menu .dropdown-item:focus,
	.dropdown-menu .dropdown-item:active {
		background: 0
	}

	.dropdown-menu .dropdown-item:hover {
		color: #BF202F
	}

	.dropdown-menu .dropdown-item.active {
		color: #BF202F
	}

	.dropdown-menu .dropdown-item.active::before {
		opacity: 1;
		visibility: visible
	}

	.dropdown-menu a.dropdown-item {
		font-weight: normal
	}

	.dropdown-toggle::after,
	.dropup .dropdown-toggle::after {
		width: auto;
		height: auto;
		margin-top: -1px;
		margin-left: .3em;
		border: 0 !important;
		font-family: feather;
		font-size: 1.1em;
		content: '\e92e';
		vertical-align: middle
	}

	.dropup .dropdown-toggle::after {
		content: '\e931'
	}

	.mega-dropdown {
		width: 700px;
		padding: 30px 30px 0
	}

	.toolbar-dropdown {
		right: -1px;
		left: auto;
		z-index: 10
	}

	.toolbar-dropdown.lang-dropdown {
		width: 150px
	}

	.toolbar-dropdown.lang-dropdown>li>a {
		font-size: 13px
	}

	.toolbar-dropdown.cart-dropdown {
		right: 0;
		width: 280px;
		padding: 20px
	}

	.show .dropdown-menu {
		-webkit-animation: dropdown-show .25s;
		animation: dropdown-show .25s
	}

	@-webkit-keyframes dropdown-show {
		from {
			opacity: 0
		}

		to {
			opacity: 1
		}
	}

	@keyframes dropdown-show {
		from {
			opacity: 0
		}

		to {
			opacity: 1
		}
	}

	.list-group-item {
		border-color: #e5e5e5;
		background-color: #fff;
		font-size: 15px;
		text-decoration: none
	}

	.list-group-item:first-child {
		border-top-left-radius: 5px;
		border-top-right-radius: 5px
	}

	.list-group-item:last-child {
		border-bottom-left-radius: 5px;
		border-bottom-right-radius: 5px
	}

	.list-group-item i {
		display: inline-block;
		margin-top: -2px;
		margin-right: 8px;
		font-size: 1.1em;
		vertical-align: middle
	}

	.list-group-item p,
	.list-group-item ul,
	.list-group-item ol,
	.list-group-item li,
	.list-group-item span {
		font-weight: normal !important
	}

	a.list-group-item,
	.list-group-item-action {
		position: relative;
		transition: all .25s;
		color: #505050
	}

	a.list-group-item:hover,
	a.list-group-item:focus,
	a.list-group-item:active,
	.list-group-item-action:hover,
	.list-group-item-action:focus,
	.list-group-item-action:active {
		background-color: #fff;
		color: #BF202F
	}

	a.list-group-item::before,
	.list-group-item-action::before {
		position: absolute;
		top: 0;
		left: -1px;
		width: 2px;
		height: 100%;
		background-color: #BF202F;
		content: '';
		opacity: 0
	}

	a.list-group-item {
		padding-top: .87rem;
		padding-bottom: .87rem
	}

	.with-badge {
		position: relative;
		padding-right: 3.3rem
	}

	.with-badge .badge {
		position: absolute;
		top: 50%;
		right: 1.15rem;
		-webkit-transform: translateY(-50%);
		-ms-transform: translateY(-50%);
		transform: translateY(-50%)
	}

	.badge {
		color: #fff;
		font-size: 85%;
		font-weight: 500
	}

	.badge.badge-default {
		border: 1px solid #e5e5e5;
		background-color: #f5f5f5;
		color: #505050
	}

	.badge.badge-primary {
		background-color: #BF202F
	}

	.badge.badge-info {
		background-color: #2196f3
	}

	.badge.badge-success {
		background-color: #4caf50
	}

	.badge.badge-warning {
		background-color: #ffa000
	}

	.badge.badge-danger {
		background-color: #f44336
	}

	.list-group-item.active {
		border-color: #e5e5e5;
		background-color: #fff;
		color: #BF202F;
		cursor: default;
		pointer-events: none
	}

	.list-group-item.active::before {
		opacity: 1
	}

	.list-group-item.active h1,
	.list-group-item.active .h1,
	.list-group-item.active h2,
	.list-group-item.active .h2,
	.list-group-item.active h3,
	.list-group-item.active .h3,
	.list-group-item.active h4,
	.list-group-item.active .h4,
	.list-group-item.active h5,
	.list-group-item.active .h5,
	.list-group-item.active h6,
	.list-group-item.active .h6 {
		color: #fff
	}

	.list-group-item-info {
		background-color: rgba(33, 150, 243, 0.12);
		color: #2196f3 !important
	}

	.list-group-item-info>*,
	.list-group-item-info h1,
	.list-group-item-info h2,
	.list-group-item-info h3,
	.list-group-item-info h4,
	.list-group-item-info h5,
	.list-group-item-info h6,
	.list-group-item-info p,
	.list-group-item-info ul,
	.list-group-item-info ol,
	.list-group-item-info a {
		color: #2196f3 !important
	}

	.list-group-item-info::before {
		display: none
	}

	.list-group-item-success {
		background-color: rgba(76, 175, 80, 0.12);
		color: #47a44b !important
	}

	.list-group-item-success>*,
	.list-group-item-success h1,
	.list-group-item-success h2,
	.list-group-item-success h3,
	.list-group-item-success h4,
	.list-group-item-success h5,
	.list-group-item-success h6,
	.list-group-item-success p,
	.list-group-item-success ul,
	.list-group-item-success ol,
	.list-group-item-success a {
		color: #47a44b !important
	}

	.list-group-item-success::before {
		display: none
	}

	.list-group-item-warning {
		background-color: rgba(255, 160, 0, 0.12);
		color: #f09600 !important
	}

	.list-group-item-warning>*,
	.list-group-item-warning h1,
	.list-group-item-warning h2,
	.list-group-item-warning h3,
	.list-group-item-warning h4,
	.list-group-item-warning h5,
	.list-group-item-warning h6,
	.list-group-item-warning p,
	.list-group-item-warning ul,
	.list-group-item-warning ol,
	.list-group-item-warning a {
		color: #f09600 !important
	}

	.list-group-item-warning::before {
		display: none
	}

	.list-group-item-danger {
		background-color: rgba(244, 67, 54, 0.12);
		color: #f44336 !important
	}

	.list-group-item-danger>*,
	.list-group-item-danger h1,
	.list-group-item-danger h2,
	.list-group-item-danger h3,
	.list-group-item-danger h4,
	.list-group-item-danger h5,
	.list-group-item-danger h6,
	.list-group-item-danger p,
	.list-group-item-danger ul,
	.list-group-item-danger ol,
	.list-group-item-danger a {
		color: #f44336 !important
	}

	.list-group-item-danger::before {
		display: none
	}

	.list-group-item-action:hover.list-group-item-info,
	.list-group-item-action.active.list-group-item-info {
		background-color: rgba(33, 150, 243, 0.24)
	}

	.list-group-item-action:hover.list-group-item-success,
	.list-group-item-action.active.list-group-item-success {
		background-color: rgba(76, 175, 80, 0.24)
	}

	.list-group-item-action:hover.list-group-item-warning,
	.list-group-item-action.active.list-group-item-warning {
		background-color: rgba(255, 160, 0, 0.24)
	}

	.list-group-item-action:hover.list-group-item-danger,
	.list-group-item-action.active.list-group-item-danger {
		background-color: rgba(244, 67, 54, 0.24)
	}

	.card:not([class*='mb-']):not([class*='margin-bottom-'])+.list-group {
		margin-top: -1px
	}

	.card:not([class*='mb-']):not([class*='margin-bottom-'])+.list-group .list-group-item:first-child {
		border-radius: 0
	}

	.alert {
		display: block;
		position: relative;
		padding: 24px;
		border: 5px solid transparent;
		border-radius: 5px;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		background-clip: padding-box
	}

	.alert i {
		display: inline-block;
		font-size: 1.2em;
		vertical-align: middle
	}

	.alert>*:last-child:not(.btn),
	.alert h1:last-child:not(.btn),
	.alert h2:last-child:not(.btn),
	.alert h3:last-child:not(.btn),
	.alert h4:last-child:not(.btn),
	.alert h5:last-child:not(.btn),
	.alert h6:last-child:not(.btn),
	.alert p:last-child:not(.btn),
	.alert ul:last-child:not(.btn),
	.alert ol:last-child:not(.btn),
	.alert a:last-child:not(.btn) {
		margin: 0
	}

	.alert::before {
		display: block;
		position: absolute;
		top: -6px;
		right: -6px;
		bottom: -6px;
		left: -6px;
		border: 1px solid transparent;
		border-radius: 5px;
		content: '';
		z-index: -1
	}

	.alert .alert-dismissible {
		transition: opacity .4s
	}

	.alert .alert-dismissible.fade.show {
		opacity: 1
	}

	.alert .alert-close {
		display: block;
		position: absolute;
		top: 10px;
		right: 12px;
		font-family: feather;
		font-size: 16px;
		cursor: pointer
	}

	.alert .alert-close::before {
		content: '\ea04'
	}

	a.alert {
		text-decoration: none
	}

	.alert-default {
		background-color: #f5f5f5;
		color: #505050
	}

	.alert-default::before {
		border-color: rgba(80, 80, 80, 0.13)
	}

	.alert-default>*:not(.text-white),
	.alert-default>*:not(.text-light),
	.alert-default h1:not(.text-white),
	.alert-default h1:not(.text-light),
	.alert-default h2:not(.text-white),
	.alert-default h2:not(.text-light),
	.alert-default h3:not(.text-white),
	.alert-default h3:not(.text-light),
	.alert-default h4:not(.text-white),
	.alert-default h4:not(.text-light),
	.alert-default h5:not(.text-white),
	.alert-default h5:not(.text-light),
	.alert-default h6:not(.text-white),
	.alert-default h6:not(.text-light),
	.alert-default p:not(.text-white),
	.alert-default p:not(.text-light),
	.alert-default ul:not(.text-white),
	.alert-default ul:not(.text-light),
	.alert-default ol:not(.text-white),
	.alert-default ol:not(.text-light),
	.alert-default a:not(.text-white),
	.alert-default a:not(.text-light) {
		color: #505050
	}

	.alert-default .alert-close {
		color: #505050
	}

	.alert-primary {
		background-color: rgba(230, 25, 35, 0.11);
		color: #BF202F
	}

	.alert-primary::before {
		border-color: rgba(230, 25, 35, 0.25)
	}

	.alert-primary>*:not(.text-white),
	.alert-primary>*:not(.text-light),
	.alert-primary h1:not(.text-white),
	.alert-primary h1:not(.text-light),
	.alert-primary h2:not(.text-white),
	.alert-primary h2:not(.text-light),
	.alert-primary h3:not(.text-white),
	.alert-primary h3:not(.text-light),
	.alert-primary h4:not(.text-white),
	.alert-primary h4:not(.text-light),
	.alert-primary h5:not(.text-white),
	.alert-primary h5:not(.text-light),
	.alert-primary h6:not(.text-white),
	.alert-primary h6:not(.text-light),
	.alert-primary p:not(.text-white),
	.alert-primary p:not(.text-light),
	.alert-primary ul:not(.text-white),
	.alert-primary ul:not(.text-light),
	.alert-primary ol:not(.text-white),
	.alert-primary ol:not(.text-light),
	.alert-primary a:not(.text-white),
	.alert-primary a:not(.text-light) {
		color: #BF202F
	}

	.alert-primary .alert-close {
		color: #BF202F
	}

	.alert-info {
		background-color: rgba(33, 150, 243, 0.11);
		color: #2196f3
	}

	.alert-info::before {
		border-color: rgba(33, 150, 243, 0.3)
	}

	.alert-info>*:not(.text-white),
	.alert-info>*:not(.text-light),
	.alert-info h1:not(.text-white),
	.alert-info h1:not(.text-light),
	.alert-info h2:not(.text-white),
	.alert-info h2:not(.text-light),
	.alert-info h3:not(.text-white),
	.alert-info h3:not(.text-light),
	.alert-info h4:not(.text-white),
	.alert-info h4:not(.text-light),
	.alert-info h5:not(.text-white),
	.alert-info h5:not(.text-light),
	.alert-info h6:not(.text-white),
	.alert-info h6:not(.text-light),
	.alert-info p:not(.text-white),
	.alert-info p:not(.text-light),
	.alert-info ul:not(.text-white),
	.alert-info ul:not(.text-light),
	.alert-info ol:not(.text-white),
	.alert-info ol:not(.text-light),
	.alert-info a:not(.text-white),
	.alert-info a:not(.text-light) {
		color: #2196f3
	}

	.alert-info .alert-close {
		color: #2196f3
	}

	.alert-success {
		background-color: rgba(76, 175, 80, 0.11);
		color: #4caf50
	}

	.alert-success::before {
		border-color: rgba(76, 175, 80, 0.25)
	}

	.alert-success>*:not(.text-white),
	.alert-success>*:not(.text-light),
	.alert-success h1:not(.text-white),
	.alert-success h1:not(.text-light),
	.alert-success h2:not(.text-white),
	.alert-success h2:not(.text-light),
	.alert-success h3:not(.text-white),
	.alert-success h3:not(.text-light),
	.alert-success h4:not(.text-white),
	.alert-success h4:not(.text-light),
	.alert-success h5:not(.text-white),
	.alert-success h5:not(.text-light),
	.alert-success h6:not(.text-white),
	.alert-success h6:not(.text-light),
	.alert-success p:not(.text-white),
	.alert-success p:not(.text-light),
	.alert-success ul:not(.text-white),
	.alert-success ul:not(.text-light),
	.alert-success ol:not(.text-white),
	.alert-success ol:not(.text-light),
	.alert-success a:not(.text-white),
	.alert-success a:not(.text-light) {
		color: #4caf50
	}

	.alert-success .alert-close {
		color: #4caf50
	}

	.alert-warning {
		background-color: rgba(255, 160, 0, 0.11);
		color: #ffa000
	}

	.alert-warning::before {
		border-color: rgba(255, 160, 0, 0.25)
	}

	.alert-warning>*:not(.text-white),
	.alert-warning>*:not(.text-light),
	.alert-warning h1:not(.text-white),
	.alert-warning h1:not(.text-light),
	.alert-warning h2:not(.text-white),
	.alert-warning h2:not(.text-light),
	.alert-warning h3:not(.text-white),
	.alert-warning h3:not(.text-light),
	.alert-warning h4:not(.text-white),
	.alert-warning h4:not(.text-light),
	.alert-warning h5:not(.text-white),
	.alert-warning h5:not(.text-light),
	.alert-warning h6:not(.text-white),
	.alert-warning h6:not(.text-light),
	.alert-warning p:not(.text-white),
	.alert-warning p:not(.text-light),
	.alert-warning ul:not(.text-white),
	.alert-warning ul:not(.text-light),
	.alert-warning ol:not(.text-white),
	.alert-warning ol:not(.text-light),
	.alert-warning a:not(.text-white),
	.alert-warning a:not(.text-light) {
		color: #ffa000
	}

	.alert-warning .alert-close {
		color: #ffa000
	}

	.alert-danger {
		background-color: rgba(244, 67, 54, 0.11);
		color: #f44336
	}

	.alert-danger::before {
		border-color: rgba(244, 67, 54, 0.25)
	}

	.alert-danger>*:not(.text-white),
	.alert-danger>*:not(.text-light),
	.alert-danger h1:not(.text-white),
	.alert-danger h1:not(.text-light),
	.alert-danger h2:not(.text-white),
	.alert-danger h2:not(.text-light),
	.alert-danger h3:not(.text-white),
	.alert-danger h3:not(.text-light),
	.alert-danger h4:not(.text-white),
	.alert-danger h4:not(.text-light),
	.alert-danger h5:not(.text-white),
	.alert-danger h5:not(.text-light),
	.alert-danger h6:not(.text-white),
	.alert-danger h6:not(.text-light),
	.alert-danger p:not(.text-white),
	.alert-danger p:not(.text-light),
	.alert-danger ul:not(.text-white),
	.alert-danger ul:not(.text-light),
	.alert-danger ol:not(.text-white),
	.alert-danger ol:not(.text-light),
	.alert-danger a:not(.text-white),
	.alert-danger a:not(.text-light) {
		color: #f44336
	}

	.alert-danger .alert-close {
		color: #f44336
	}

	.alert-image-bg {
		border: 0
	}

	.alert-image-bg::before {
		display: none
	}

	.iziToast {
		border: 1px solid #e5e5e5;
		background: #f5f5f5
	}

	.iziToast::after {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		border-radius: 4px;
		box-shadow: 0 8px 10px -4px rgba(0, 0, 0, 0.2);
		content: '';
		z-index: -1
	}

	.iziToast>.iziToast-body {
		margin-left: 15px
	}

	.iziToast>.iziToast-close {
		width: 40px;
		transition: opacity .25s;
		background: none;
		background-position: center;
		background-color: transparent;
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDE1LjY0MiAxNS42NDIiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDE1LjY0MiAxNS42NDIiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTguODgyLDcuODIxbDYuNTQxLTYuNTQxYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjEgIGMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMEw3LjgyMSw2Ljc2TDEuMjgsMC4yMmMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMGMtMC4yOTMsMC4yOTMtMC4yOTMsMC43NjgsMCwxLjA2MSAgbDYuNTQxLDYuNTQxTDAuMjIsMTQuMzYyYy0wLjI5MywwLjI5My0wLjI5MywwLjc2OCwwLDEuMDYxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyczAuMzg0LTAuMDczLDAuNTMtMC4yMmw2LjU0MS02LjU0MSAgbDYuNTQxLDYuNTQxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyYzAuMTkyLDAsMC4zODQtMC4wNzMsMC41My0wLjIyYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjFMOC44ODIsNy44MjF6IiBmaWxsPSIjMzc0MjUwIi8+Cjwvc3ZnPgo=);
		background-size: 8px;
		background-repeat: no-repeat
	}

	.iziToast.iziToast-info {
		border-color: rgba(33, 150, 243, 0.3);
		background-color: #e3f2fd;
		color: #0d8aee
	}

	.iziToast.iziToast-info>.iziToast-close {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDE1LjY0MiAxNS42NDIiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDE1LjY0MiAxNS42NDIiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTguODgyLDcuODIxbDYuNTQxLTYuNTQxYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjEgIGMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMEw3LjgyMSw2Ljc2TDEuMjgsMC4yMmMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMGMtMC4yOTMsMC4yOTMtMC4yOTMsMC43NjgsMCwxLjA2MSAgbDYuNTQxLDYuNTQxTDAuMjIsMTQuMzYyYy0wLjI5MywwLjI5My0wLjI5MywwLjc2OCwwLDEuMDYxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyczAuMzg0LTAuMDczLDAuNTMtMC4yMmw2LjU0MS02LjU0MSAgbDYuNTQxLDYuNTQxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyYzAuMTkyLDAsMC4zODQtMC4wNzMsMC41My0wLjIyYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjFMOC44ODIsNy44MjF6IiBmaWxsPSIjMTg5NmJiIi8+Cjwvc3ZnPgo=)
	}

	.iziToast.iziToast-success {
		border-color: rgba(76, 175, 80, 0.3);
		background-color: #e7f5e7;
		color: #439a46
	}

	.iziToast.iziToast-success>.iziToast-close {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDE1LjY0MiAxNS42NDIiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDE1LjY0MiAxNS42NDIiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTguODgyLDcuODIxbDYuNTQxLTYuNTQxYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjEgIGMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMEw3LjgyMSw2Ljc2TDEuMjgsMC4yMmMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMGMtMC4yOTMsMC4yOTMtMC4yOTMsMC43NjgsMCwxLjA2MSAgbDYuNTQxLDYuNTQxTDAuMjIsMTQuMzYyYy0wLjI5MywwLjI5My0wLjI5MywwLjc2OCwwLDEuMDYxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyczAuMzg0LTAuMDczLDAuNTMtMC4yMmw2LjU0MS02LjU0MSAgbDYuNTQxLDYuNTQxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyYzAuMTkyLDAsMC4zODQtMC4wNzMsMC41My0wLjIyYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjFMOC44ODIsNy44MjF6IiBmaWxsPSIjMWY5NzZjIi8+Cjwvc3ZnPgo=)
	}

	.iziToast.iziToast-warning {
		border-color: rgba(255, 160, 0, 0.3);
		background-color: #fff2db;
		color: #f09600
	}

	.iziToast.iziToast-warning>.iziToast-close {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDE1LjY0MiAxNS42NDIiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDE1LjY0MiAxNS42NDIiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTguODgyLDcuODIxbDYuNTQxLTYuNTQxYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjEgIGMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMEw3LjgyMSw2Ljc2TDEuMjgsMC4yMmMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMGMtMC4yOTMsMC4yOTMtMC4yOTMsMC43NjgsMCwxLjA2MSAgbDYuNTQxLDYuNTQxTDAuMjIsMTQuMzYyYy0wLjI5MywwLjI5My0wLjI5MywwLjc2OCwwLDEuMDYxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyczAuMzg0LTAuMDczLDAuNTMtMC4yMmw2LjU0MS02LjU0MSAgbDYuNTQxLDYuNTQxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyYzAuMTkyLDAsMC4zODQtMC4wNzMsMC41My0wLjIyYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjFMOC44ODIsNy44MjF6IiBmaWxsPSIjZTg4OTAwIi8+Cjwvc3ZnPgo=)
	}

	.iziToast.iziToast-danger {
		border-color: rgba(244, 67, 54, 0.3);
		background-color: #fee6e4;
		color: #f44336
	}

	.iziToast.iziToast-danger>.iziToast-close {
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDE1LjY0MiAxNS42NDIiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDE1LjY0MiAxNS42NDIiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTguODgyLDcuODIxbDYuNTQxLTYuNTQxYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjEgIGMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMEw3LjgyMSw2Ljc2TDEuMjgsMC4yMmMtMC4yOTMtMC4yOTMtMC43NjgtMC4yOTMtMS4wNjEsMGMtMC4yOTMsMC4yOTMtMC4yOTMsMC43NjgsMCwxLjA2MSAgbDYuNTQxLDYuNTQxTDAuMjIsMTQuMzYyYy0wLjI5MywwLjI5My0wLjI5MywwLjc2OCwwLDEuMDYxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyczAuMzg0LTAuMDczLDAuNTMtMC4yMmw2LjU0MS02LjU0MSAgbDYuNTQxLDYuNTQxYzAuMTQ3LDAuMTQ2LDAuMzM4LDAuMjIsMC41MywwLjIyYzAuMTkyLDAsMC4zODQtMC4wNzMsMC41My0wLjIyYzAuMjkzLTAuMjkzLDAuMjkzLTAuNzY4LDAtMS4wNjFMOC44ODIsNy44MjF6IiBmaWxsPSIjZWIwMDAwIi8+Cjwvc3ZnPgo=)
	}

	.toast.position-fixed {
		min-width: 300px;
		z-index: 9900
	}

	.toast.position-fixed.top-center {
		top: 30px;
		left: 50%;
		-webkit-transform: translateX(-50%);
		-ms-transform: translateX(-50%);
		transform: translateX(-50%)
	}

	.toast.position-fixed.top-right {
		top: 30px;
		right: 30px
	}

	.toast.position-fixed.top-left {
		top: 30px;
		left: 30px
	}

	.toast.position-fixed.bottom-center {
		bottom: 30px;
		left: 50%;
		-webkit-transform: translateX(-50%);
		-ms-transform: translateX(-50%);
		transform: translateX(-50%)
	}

	.toast.position-fixed.bottom-right {
		bottom: 30px;
		right: 30px
	}

	.toast.position-fixed.bottom-left {
		bottom: 30px;
		left: 30px
	}

	@media (max-width: 360px) {

		.toast.position-fixed.top-right,
		.toast.position-fixed.top-left,
		.toast.position-fixed.bottom-right,
		.toast.position-fixed.bottom-left {
			right: auto;
			left: 50%;
			-webkit-transform: translateX(-50%);
			-ms-transform: translateX(-50%);
			transform: translateX(-50%)
		}
	}

	.modal {
		z-index: 9200
	}

	.modal-content {
		border-radius: 6px;
		border-color: #e5e5e5
	}

	.modal-header,
	.modal-body,
	.modal-footer {
		padding-right: 20px;
		padding-left: 20px
	}

	.modal-header {
		background-color: #f5f5f5
	}

	.modal-footer {
		padding-top: 12px;
		padding-bottom: 12px
	}

	.modal-footer .btn {
		margin-right: 0;
		margin-left: 12px
	}

	.modal-open.hasScrollbar .navbar-stuck {
		width: calc(100% - 15px)
	}

	.modal-backdrop {
		z-index: 9100
	}

	.example-modal .modal {
		display: block;
		position: relative;
		top: auto;
		right: auto;
		bottom: auto;
		left: auto;
		z-index: 1
	}

	.progress {
		height: auto;
		border-radius: 9px;
		background-color: #f0f0f0;
		font-size: 12px;
		font-weight: 500;
		line-height: 18px
	}

	.progress-bar {
		height: 18px;
		background-color: #BF202F
	}

	.owl-carousel {
		display: none;
		position: relative;
		width: 100%;
		z-index: 1;
		-webkit-tap-highlight-color: transparent
	}

	.owl-carousel .owl-stage {
		position: relative;
		-ms-touch-action: pan-Y;
		-moz-backface-visibility: hidden
	}

	.owl-carousel .owl-stage::after {
		display: block;
		height: 0;
		clear: both;
		line-height: 0;
		content: '.';
		visibility: hidden
	}

	.owl-carousel .owl-stage-outer {
		position: relative;
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
		overflow: hidden
	}

	.owl-carousel .owl-wrapper,
	.owl-carousel .owl-item {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
		-webkit-backface-visibility: hidden;
		backface-visibility: hidden
	}

	.owl-carousel .owl-item {
		position: relative;
		min-height: 1px;
		float: left;
		-webkit-backface-visibility: hidden;
		backface-visibility: hidden;
		-webkit-tap-highlight-color: transparent;
		-webkit-touch-callout: none
	}

	.owl-carousel .owl-item .owl-lazy {
		transition: opacity 400ms ease;
		opacity: 0
	}

	.owl-carousel .owl-item .from-top,
	.owl-carousel .owl-item .from-bottom,
	.owl-carousel .owl-item .from-left,
	.owl-carousel .owl-item .from-right,
	.owl-carousel .owl-item .scale-up,
	.owl-carousel .owl-item .scale-down {
		transition: all .45s .3s ease-in-out;
		opacity: 0;
		-webkit-backface-visibility: hidden;
		backface-visibility: hidden
	}

	.owl-carousel .owl-item .from-top {
		-webkit-transform: translateY(-45px);
		-ms-transform: translateY(-45px);
		transform: translateY(-45px)
	}

	.owl-carousel .owl-item .from-bottom {
		-webkit-transform: translateY(45px);
		-ms-transform: translateY(45px);
		transform: translateY(45px)
	}

	.owl-carousel .owl-item .from-left {
		-webkit-transform: translateX(-45px);
		-ms-transform: translateX(-45px);
		transform: translateX(-45px)
	}

	.owl-carousel .owl-item .from-right {
		-webkit-transform: translateX(45px);
		-ms-transform: translateX(45px);
		transform: translateX(45px)
	}

	.owl-carousel .owl-item .scale-up {
		-webkit-transform: scale(0.8);
		-ms-transform: scale(0.8);
		transform: scale(0.8)
	}

	.owl-carousel .owl-item .scale-down {
		-webkit-transform: scale(1.2);
		-ms-transform: scale(1.2);
		transform: scale(1.2)
	}

	.owl-carousel .owl-item .delay-1 {
		transition-delay: .5s
	}

	.owl-carousel .owl-item .delay-2 {
		transition-delay: .7s
	}

	.owl-carousel .owl-item .delay-3 {
		transition-delay: .9s
	}

	.owl-carousel .owl-item .delay-4 {
		transition-delay: 1.1s
	}

	.owl-carousel .owl-item.active .from-top,
	.owl-carousel .owl-item.active .from-bottom {
		-webkit-transform: translateY(0);
		-ms-transform: translateY(0);
		transform: translateY(0);
		opacity: 1
	}

	.owl-carousel .owl-item.active .from-left,
	.owl-carousel .owl-item.active .from-right {
		-webkit-transform: translateX(0);
		-ms-transform: translateX(0);
		transform: translateX(0);
		opacity: 1
	}

	.owl-carousel .owl-item.active .scale-up,
	.owl-carousel .owl-item.active .scale-down {
		-webkit-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1);
		opacity: 1
	}

	.owl-carousel .owl-item>img {
		display: block;
		width: 100%
	}

	.owl-carousel .owl-item>img.owl-lazy {
		-webkit-transform-style: preserve-3d;
		transform-style: preserve-3d
	}

	.owl-carousel .owl-nav.disabled,
	.owl-carousel .owl-dots.disabled {
		display: none
	}

	.owl-carousel .owl-nav .owl-prev,
	.owl-carousel .owl-nav .owl-next,
	.owl-carousel .owl-dot {
		cursor: pointer;
		cursor: hand;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none
	}

	.owl-carousel.owl-loaded {
		display: block
	}

	.owl-carousel.owl-loading {
		display: block;
		opacity: 0
	}

	.owl-carousel.owl-hidden {
		opacity: 0
	}

	.owl-carousel.owl-refresh .owl-item {
		visibility: hidden
	}

	.owl-carousel.owl-drag .owl-item {
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none
	}

	.owl-carousel.owl-grab {
		cursor: move;
		cursor: grab
	}

	.owl-carousel.owl-rtl {
		direction: rtl
	}

	.owl-carousel.owl-rtl .owl-item {
		float: right
	}

	.owl-carousel .animated {
		-webkit-animation-duration: 1000ms;
		animation-duration: 1000ms;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both
	}

	.owl-carousel .owl-animated-in {
		z-index: 0
	}

	.owl-carousel .owl-animated-out {
		z-index: 1
	}

	.owl-carousel .fadeOut {
		-webkit-animation-name: fadeOut;
		animation-name: fadeOut
	}

	.owl-carousel .owl-dots {
		display: block;
		width: 100%;
		margin-top: 18px;
		text-align: center
	}

	.owl-carousel .owl-dots .owl-dot {
		display: inline-block;
		width: 6px;
		height: 6px;
		margin: 0 6px;
		transition: opacity .25s;
		border-radius: 50%;
		background-color: #505050;
		opacity: .33
	}

	.owl-carousel .owl-dots .owl-dot.active {
		opacity: 1
	}

	.owl-carousel .owl-prev,
	.owl-carousel .owl-next {
		display: block;
		position: absolute;
		top: 50%;
		width: 46px;
		height: 46px;
		margin-top: -43px;
		transition: opacity .3s;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff;
		color: #232323;
		line-height: 44px;
		text-align: center;
		opacity: .75
	}

	.owl-carousel .owl-prev:hover,
	.owl-carousel .owl-next:hover {
		opacity: 1
	}

	.owl-carousel .owl-prev::before,
	.owl-carousel .owl-next::before {
		font-family: feather;
		font-size: 22px
	}

	.owl-carousel .owl-prev {
		left: 20px
	}

	.owl-carousel .owl-prev::before {
		content: '\e92f'
	}

	.owl-carousel .owl-next {
		right: 20px
	}

	.owl-carousel .owl-next::before {
		content: '\e930'
	}

	.owl-carousel.large-controls .owl-prev,
	.owl-carousel.large-controls .owl-next {
		width: 54px;
		height: 54px;
		margin-top: -47px;
		border-radius: 6px;
		line-height: 52px
	}

	.owl-carousel.large-controls .owl-prev {
		left: 30px
	}

	.owl-carousel.large-controls .owl-next {
		right: 30px
	}

	.owl-carousel.dots-inside .owl-dots {
		position: absolute;
		bottom: 0;
		margin: 0;
		padding-bottom: 24px
	}

	.owl-carousel.dots-inside .owl-dots .owl-dot {
		background-color: #fff;
		opacity: .5
	}

	.owl-carousel.dots-inside .owl-dots .owl-dot.active {
		opacity: 1
	}

	.owl-carousel.dots-inside .owl-prev,
	.owl-carousel.dots-inside .owl-next {
		margin-top: -23px
	}

	.owl-carousel.dots-inside.large-controls .owl-prev,
	.owl-carousel.dots-inside.large-controls .owl-next {
		margin-top: -27px
	}

	.owl-carousel .widget {
		margin-bottom: 0
	}

	.owl-carousel .widget.widget-featured-posts>.entry {
		margin-bottom: 0
	}

	.no-js .owl-carousel {
		display: block
	}

	@-webkit-keyframes fadeOut {
		0% {
			opacity: 1
		}

		100% {
			opacity: 0
		}
	}

	@keyframes fadeOut {
		0% {
			opacity: 1
		}

		100% {
			opacity: 0
		}
	}

	.owl-height {
		transition: height 500ms ease-in-out
	}

	.hero-slider {
		width: 100%;
		min-height: 400px;
		background-position: center;
		background-color: #fff;
		background-repeat: no-repeat;
		background-size: cover;
		box-shadow: 0 7px 30px -6px rgba(0, 0, 0, 0.15);
		overflow: hidden
	}

	.hero-slider>.owl-carousel {
		min-height: 400px
	}

	.hero-slider>.owl-carousel .owl-prev,
	.hero-slider>.owl-carousel .owl-next {
		top: auto;
		bottom: 18px;
		left: auto;
		width: 46px;
		height: 46px;
		margin: 0;
		transition: background-color .3s;
		border: 0;
		border-radius: 0;
		background-color: #fff;
		color: #505050;
		line-height: 44px;
		opacity: 1
	}

	.hero-slider>.owl-carousel .owl-prev:hover,
	.hero-slider>.owl-carousel .owl-next:hover {
		background-color: #f5f5f5
	}

	.hero-slider>.owl-carousel .owl-prev {
		right: 64px;
		border-top: 1px solid #e5e5e5;
		border-bottom: 1px solid #e5e5e5
	}

	.hero-slider>.owl-carousel .owl-next {
		right: 18px;
		border: 1px solid #e5e5e5;
		border-top-right-radius: 5px;
		border-bottom-right-radius: 5px
	}

	.hero-slider>.owl-carousel.dots-inside .owl-dots {
		display: inline-block;
		right: 110px;
		bottom: 18px;
		width: auto;
		height: 46px;
		padding: 10px 16px 14px;
		border: 1px solid #e5e5e5;
		border-top-left-radius: 5px;
		border-bottom-left-radius: 5px;
		background-color: #fff
	}

	.hero-slider>.owl-carousel.dots-inside .owl-dots .owl-dot {
		background-color: #505050
	}

	@media (max-width: 1100px) {
		.hero-slider {
			min-height: 430px
		}

		.hero-slider>.owl-carousel {
			min-height: 430px
		}
	}

	.gallery-item {
		margin-bottom: 30px
	}

	.gallery-item>a {
		display: block;
		position: relative;
		width: 100%;
		border-radius: 6px;
		text-decoration: none;
		overflow: hidden
	}

	.gallery-item>a>img {
		display: block;
		width: 100%
	}

	.gallery-item>a::before {
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: #000;
		content: '';
		opacity: 0;
		z-index: 1;
		transition: opacity .3s
	}

	.gallery-item>a::after {
		display: block;
		position: absolute;
		top: 50%;
		left: 0;
		width: 100%;
		margin-top: -24px;
		-webkit-transform: translateY(15px);
		-ms-transform: translateY(15px);
		transform: translateY(15px);
		transition: all .35s;
		color: #fff;
		font-family: feather;
		font-size: 32px;
		text-align: center;
		content: '\ea08';
		opacity: 0;
		z-index: 5
	}

	.gallery-item>a:hover::before {
		opacity: .45
	}

	.gallery-item>a:hover::after {
		-webkit-transform: translateY(0);
		-ms-transform: translateY(0);
		transform: translateY(0);
		opacity: 1
	}

	.gallery-item>a[data-type='video']::after {
		left: 50%;
		width: 46px;
		height: 46px;
		margin-top: -22px;
		margin-left: -22px;
		padding-left: 5px;
		-webkit-transform: none;
		-ms-transform: none;
		transform: none;
		border-radius: 50%;
		background-position: center;
		background-color: #fff;
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDEyNC41MTIgMTI0LjUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTI0LjUxMiAxMjQuNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTExMy45NTYsNTcuMDA2bC05Ny40LTU2LjJjLTQtMi4zLTksMC42LTksNS4ydjExMi41YzAsNC42LDUsNy41LDksNS4ybDk3LjQtNTYuMiAgIEMxMTcuOTU2LDY1LjEwNSwxMTcuOTU2LDU5LjMwNiwxMTMuOTU2LDU3LjAwNnoiIGZpbGw9IiMzMzMzMzMiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
		background-repeat: no-repeat;
		background-size: 10px 10px;
		box-shadow: 0 4px 15px 0 rgba(0, 0, 0, 0.25);
		content: '';
		opacity: 1
	}

	.gallery-item .caption {
		display: none
	}

	.gallery-item.no-hover-effect>a::before {
		display: none
	}

	.grid-no-gap .gallery-item {
		margin-bottom: 0
	}

	.grid-no-gap .gallery-item>a {
		border-radius: 0
	}

	.owl-carousel .gallery-item {
		margin-bottom: 0
	}

	.video-btn {
		margin-bottom: 0
	}

	.video-btn>a {
		display: inline-block;
		width: 80px;
		height: 80px;
		border-radius: 50%;
		background-position: center;
		background-color: #fff;
		background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDEyNC41MTIgMTI0LjUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTI0LjUxMiAxMjQuNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTExMy45NTYsNTcuMDA2bC05Ny40LTU2LjJjLTQtMi4zLTksMC42LTksNS4ydjExMi41YzAsNC42LDUsNy41LDksNS4ybDk3LjQtNTYuMiAgIEMxMTcuOTU2LDY1LjEwNSwxMTcuOTU2LDU5LjMwNiwxMTMuOTU2LDU3LjAwNnoiIGZpbGw9IiMzMzMzMzMiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
		background-repeat: no-repeat;
		background-size: 12px 12px;
		box-shadow: 0 7px 22px -5px rgba(0, 0, 0, 0.2)
	}

	.video-btn>a::before,
	.video-btn>a::after {
		display: none
	}

	.video-btn .caption {
		display: block;
		padding-top: 10px
	}

	.pswp__zoom-wrap {
		text-align: center
	}

	.pswp__zoom-wrap::before {
		display: inline-block;
		height: 100%;
		content: '';
		vertical-align: middle
	}

	.wrapper {
		display: inline-block;
		position: relative;
		width: 100%;
		max-width: 900px;
		margin: 0 auto;
		line-height: 0;
		text-align: left;
		vertical-align: middle;
		z-index: 1045
	}

	.video-wrapper {
		position: relative;
		width: 100%;
		height: 0;
		padding-top: 25px;
		padding-bottom: 56.25%
	}

	.video-wrapper iframe {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%
	}

	video {
		width: 100% !important;
		height: auto !important
	}

	.pswp__caption__center {
		padding: 20px 10px;
		font-size: 13px;
		font-weight: 500;
		text-align: center
	}

	.countdown {
		display: inline-block
	}

	.countdown::after {
		display: block;
		clear: both;
		content: ''
	}

	.countdown .item {
		display: block;
		margin: 7px;
		float: left;
		text-align: center
	}

	.countdown .item .days,
	.countdown .item .hours,
	.countdown .item .minutes,
	.countdown .item .seconds {
		width: 48px;
		height: 48px;
		margin-bottom: 5px;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff;
		font-size: 20px;
		line-height: 46px
	}

	.countdown .item .days_ref,
	.countdown .item .hours_ref,
	.countdown .item .minutes_ref,
	.countdown .item .seconds_ref {
		font-size: 12px
	}

	.countdown.countdown-inverse .item .days,
	.countdown.countdown-inverse .item .hours,
	.countdown.countdown-inverse .item .minutes,
	.countdown.countdown-inverse .item .seconds {
		border-color: rgba(255, 255, 255, 0.13);
		background-color: transparent;
		color: #fff
	}

	.countdown.countdown-inverse .item .days_ref,
	.countdown.countdown-inverse .item .hours_ref,
	.countdown.countdown-inverse .item .minutes_ref,
	.countdown.countdown-inverse .item .seconds_ref {
		color: rgba(255, 255, 255, 0.8)
	}

	.spinner-border {
		border-width: .15em
	}

	.spinner-border-sm {
		border-width: .1em
	}

	.sidebar {
		width: 100%
	}

	.sidebar-toggle,
	.sidebar-close {
		display: none
	}

	@media (max-width: 991px) {
		.sidebar-offcanvas {
			position: fixed;
			top: 0;
			width: 320px;
			height: 100%;
			padding: 42px 24px 30px;
			background-color: #fff;
			box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.15);
			z-index: 9910;
			overflow-y: auto;
			-ms-overflow-style: none
		}

		.sidebar-offcanvas.position-right {
			right: -320px;
			transition: right 0.4s cubic-bezier(0.785, 0.135, 0.15, 0.86) 0.3s, box-shadow 0.3s 0.3s
		}

		.sidebar-offcanvas.position-left {
			left: -320px;
			transition: left 0.4s cubic-bezier(0.785, 0.135, 0.15, 0.86) 0.3s, box-shadow 0.3s 0.3s
		}

		.sidebar-offcanvas.open {
			box-shadow: 0 0 50px 3px rgba(0, 0, 0, 0.15)
		}

		.sidebar-offcanvas.open.position-right {
			right: 0
		}

		.sidebar-offcanvas.open.position-left {
			left: 0
		}

		.sidebar-close {
			display: block;
			position: absolute;
			top: 8px;
			right: 15px;
			color: #505050;
			font-size: 22px;
			cursor: pointer
		}

		.sidebar-offcanvas::-webkit-scrollbar {
			display: none
		}

		.sidebar-toggle {
			display: block;
			position: fixed;
			top: 50%;
			width: 46px;
			height: 46px;
			margin-top: -23px;
			background-color: #fff;
			color: #505050;
			font-size: 20px;
			line-height: 48px;
			text-align: center;
			box-shadow: 0 3px 10px 0 rgba(0, 0, 0, 0.18);
			cursor: pointer;
			z-index: 9900
		}

		.sidebar-toggle.position-right {
			right: 0;
			transition: right .3s ease-in-out;
			border-top: 1px solid #e5e5e5;
			border-bottom: 1px solid #e5e5e5;
			border-left: 1px solid #e5e5e5;
			border-top-left-radius: 5px;
			border-bottom-left-radius: 5px
		}

		.sidebar-toggle.position-right.sidebar-open {
			right: -46px
		}

		.sidebar-toggle.position-left {
			left: 0;
			transition: left .3s ease-in-out;
			border-top: 1px solid #e5e5e5;
			border-right: 1px solid #e5e5e5;
			border-bottom: 1px solid #e5e5e5;
			border-top-right-radius: 5px;
			border-bottom-right-radius: 5px
		}

		.sidebar-toggle.position-left.sidebar-open {
			left: -46px
		}
	}

	.widget-title {
		position: relative;
		margin-bottom: 24px;
		padding-bottom: 12px;
		border-bottom: 1px solid #e5e5e5;
		color: #232323;
		font-size: 15px;
		font-weight: normal
	}

	.widget-title::after {
		display: block;
		position: absolute;
		bottom: -1px;
		left: 0;
		width: 90px;
		height: 1px;
		background-color: #BF202F;
		content: ''
	}

	.widget {
		margin-bottom: 40px
	}

	.widget .form-group {
		margin-bottom: 0
	}

	.widget ul {
		margin-bottom: 12px
	}

	.widget .market-button:last-child {
		margin-bottom: 0
	}

	.widget .custom-control:last-child {
		margin-bottom: 0 !important
	}

	.widget-categories ul,
	.widget-links ul {
		margin: 0;
		padding: 0;
		list-style: none
	}

	.widget-categories ul>li,
	.widget-links ul>li {
		position: relative;
		margin-bottom: 5px;
		padding-left: 16px
	}

	.widget-categories ul>li:last-child,
	.widget-links ul>li:last-child {
		margin-bottom: 0
	}

	.widget-categories ul>li::before,
	.widget-links ul>li::before {
		display: block;
		position: absolute;
		top: -1px;
		left: 0;
		-webkit-transform: rotate(-90deg);
		-ms-transform: rotate(-90deg);
		transform: rotate(-90deg);
		transition: -webkit-transform .35s;
		transition: transform .35s;
		color: #999;
		font-family: feather;
		font-size: 1.15em;
		content: '\e92e'
	}

	.widget-categories ul>li>a,
	.widget-links ul>li>a {
		display: inline-block;
		transition: color .3s;
		color: #505050;
		font-size: 14px;
		text-decoration: none
	}

	.widget-categories ul>li>a:hover,
	.widget-links ul>li>a:hover {
		color: #BF202F
	}

	.widget-categories ul>li.active>a,
	.widget-links ul>li.active>a {
		color: #BF202F
	}

	.widget-categories ul>li>span,
	.widget-links ul>li>span {
		margin-left: 4px;
		color: #999
	}

	.widget-categories ul>li.has-children ul,
	.widget-links ul>li.has-children ul {
		border-left: 1px solid #e2e2e2
	}

	.widget-categories ul>li.has-children ul li::before,
	.widget-links ul>li.has-children ul li::before {
		top: 14px;
		width: 8px;
		height: 1px;
		-webkit-transform: none;
		-ms-transform: none;
		transform: none;
		border: 0;
		background-color: #e2e2e2;
		color: transparent
	}

	.widget-categories ul>li.has-children ul li a,
	.widget-links ul>li.has-children ul li a {
		font-size: 13px
	}

	.widget-categories ul>li.has-children ul ul>li,
	.widget-links ul>li.has-children ul ul>li {
		margin-bottom: 0
	}

	.widget-categories ul>li.has-children>ul,
	.widget-links ul>li.has-children>ul {
		max-height: 0;
		transition: max-height .6s;
		overflow: hidden
	}

	.widget-categories ul>li.has-children.expanded::before,
	.widget-links ul>li.has-children.expanded::before {
		-webkit-transform: rotate(0);
		-ms-transform: rotate(0);
		transform: rotate(0)
	}

	.widget-categories ul>li.has-children.expanded>ul,
	.widget-links ul>li.has-children.expanded>ul {
		max-height: 800px
	}

	.widget-featured-posts>.entry,
	.widget-featured-products>.entry,
	.widget-cart>.entry {
		display: table;
		width: 100%;
		margin-bottom: 18px
	}

	.widget-featured-posts>.entry .entry-thumb,
	.widget-featured-posts>.entry .entry-content,
	.widget-featured-products>.entry .entry-thumb,
	.widget-featured-products>.entry .entry-content,
	.widget-cart>.entry .entry-thumb,
	.widget-cart>.entry .entry-content {
		display: table-cell;
		vertical-align: top
	}

	.widget-featured-posts>.entry .entry-thumb,
	.widget-featured-products>.entry .entry-thumb,
	.widget-cart>.entry .entry-thumb {
		width: 62px;
		padding-right: 12px
	}

	.widget-featured-posts>.entry .entry-thumb>a,
	.widget-featured-products>.entry .entry-thumb>a,
	.widget-cart>.entry .entry-thumb>a {
		display: block;
		border-radius: 5px;
		overflow: hidden
	}

	.widget-featured-posts>.entry .entry-thumb>a>img,
	.widget-featured-products>.entry .entry-thumb>a>img,
	.widget-cart>.entry .entry-thumb>a>img {
		width: 100%
	}

	.widget-featured-posts>.entry .entry-title,
	.widget-featured-products>.entry .entry-title,
	.widget-cart>.entry .entry-title {
		margin-bottom: 0;
		font-size: 14px
	}

	.widget-featured-posts>.entry .entry-title>a,
	.widget-featured-products>.entry .entry-title>a,
	.widget-cart>.entry .entry-title>a {
		transition: color .3s;
		color: #505050;
		font-weight: 400;
		text-decoration: none
	}

	.widget-featured-posts>.entry .entry-title>a:hover,
	.widget-featured-products>.entry .entry-title>a:hover,
	.widget-cart>.entry .entry-title>a:hover {
		color: #BF202F
	}

	.widget-featured-posts>.entry .entry-meta,
	.widget-featured-products>.entry .entry-meta,
	.widget-cart>.entry .entry-meta {
		display: block;
		margin-bottom: 0;
		padding-top: 4px;
		color: #999;
		font-size: 12px
	}

	.widget-featured-products>.entry,
	.widget-cart>.entry {
		margin-bottom: 12px
	}

	.widget-featured-products>.entry .entry-meta,
	.widget-cart>.entry .entry-meta {
		font-size: 13px
	}

	.widget-cart>.entry {
		position: relative;
		padding-right: 20px;
		padding-bottom: 10px;
		border-bottom: 1px dashed #ddd
	}

	.widget-cart>.entry:last-child {
		border-bottom: 1px solid #e5e5e5
	}

	.widget-cart>.entry .entry-delete {
		position: absolute;
		top: -1px;
		right: 0;
		color: #f44336;
		cursor: pointer
	}

	.tag {
		display: inline-block;
		height: 28px;
		margin-right: 4px;
		margin-bottom: 8px;
		padding: 0 12px;
		transition: all .3s;
		border: 1px solid #e5e5e5;
		border-radius: 4px;
		color: #505050 !important;
		font-size: 12px;
		line-height: 26px;
		text-decoration: none !important;
		white-space: nowrap
	}

	.tag:hover {
		background-color: #f5f5f5;
		color: #505050 !important
	}

	.tag.active {
		border-color: #BF202F;
		background-color: #BF202F;
		color: #fff !important;
		cursor: default
	}

	.text-right .tag {
		margin-right: 0;
		margin-left: 4px
	}

	.text-center .tag {
		margin-right: 2px;
		margin-left: 2px
	}

	.widget-order-summary .table td {
		padding: 6px 0;
		border: 0
	}

	.widget-order-summary .table td:last-child {
		text-align: right
	}

	.widget-order-summary .table tr:first-child>td {
		padding-top: 0
	}

	.widget-order-summary .table tr:last-child>td {
		padding-top: 12px;
		border-top: 1px solid #e5e5e5
	}

	.widget-order-summary .table tr:nth-last-child(2)>td {
		padding-bottom: 12px
	}

	.noUi-target,
	.noUi-target * {
		-ms-touch-action: none;
		touch-action: none;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none
	}

	.noUi-target {
		position: relative;
		border-radius: 3px;
		direction: ltr
	}

	.noUi-base {
		position: relative;
		width: 100%;
		height: 100%;
		z-index: 1
	}

	.noUi-origin {
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0
	}

	.noUi-handle {
		position: relative;
		z-index: 1
	}

	.noUi-stacking .noUi-handle {
		z-index: 10
	}

	.noUi-state-tap .noUi-origin {
		transition: left .3s, top .3s
	}

	.noUi-state-drag * {
		cursor: inherit !important
	}

	.noUi-base,
	.noUi-handle {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0)
	}

	.noUi-horizontal {
		height: 2px
	}

	.noUi-horizontal .noUi-handle {
		top: -7px;
		left: -3px;
		width: 8px;
		height: 16px
	}

	.noUi-background {
		background: #ededed
	}

	.noUi-connect {
		transition: background .45s;
		background: #505050
	}

	.noUi-draggable {
		cursor: w-resize
	}

	.noUi-vertical .noUi-draggable {
		cursor: n-resize
	}

	.noUi-handle {
		border-radius: 3px;
		background: #505050;
		cursor: default
	}

	.price-range-slider {
		padding-top: 9px
	}

	.price-range-slider .ui-range-slider-footer {
		display: table;
		width: 100%;
		padding-top: 30px
	}

	.price-range-slider .ui-range-slider-footer>.column {
		display: table-cell;
		vertical-align: middle
	}

	.price-range-slider .ui-range-slider-footer>.column:first-child {
		width: 40%
	}

	.price-range-slider .ui-range-slider-footer>.column:last-child {
		width: 60%;
		padding-left: 15px;
		text-align: right
	}

	.price-range-slider .ui-range-slider-footer .btn {
		height: 28px;
		margin: 0;
		padding: 0 15px;
		line-height: 26px
	}

	.price-range-slider .ui-range-values {
		display: inline-block
	}

	.price-range-slider .ui-range-values .ui-range-value-min,
	.price-range-slider .ui-range-values .ui-range-value-max {
		display: inline-block;
		font-size: 13px
	}

	.widget-light-skin .widget-title {
		border-color: rgba(255, 255, 255, 0.13);
		color: rgba(255, 255, 255, 0.9)
	}

	.widget-light-skin.widget-categories ul>li::before,
	.widget-light-skin.widget-links ul>li::before {
		color: rgba(255, 255, 255, 0.4)
	}

	.widget-light-skin.widget-categories ul>li>a,
	.widget-light-skin.widget-links ul>li>a {
		transition: opacity .25s;
		color: #fff
	}

	.widget-light-skin.widget-categories ul>li>a:hover,
	.widget-light-skin.widget-links ul>li>a:hover {
		opacity: .6
	}

	.widget-light-skin.widget-categories ul>li.active>a,
	.widget-light-skin.widget-links ul>li.active>a {
		opacity: .6
	}

	.widget-light-skin.widget-categories ul>li>span,
	.widget-light-skin.widget-links ul>li>span {
		color: rgba(255, 255, 255, 0.5)
	}

	.widget-light-skin.widget-featured-posts>.entry .entry-title>a,
	.widget-light-skin.widget-featured-products>.entry .entry-title>a,
	.widget-light-skin.widget-cart>.entry .entry-title>a {
		transition: opacity .25s;
		color: #fff
	}

	.widget-light-skin.widget-featured-posts>.entry .entry-title>a:hover,
	.widget-light-skin.widget-featured-products>.entry .entry-title>a:hover,
	.widget-light-skin.widget-cart>.entry .entry-title>a:hover {
		opacity: .6
	}

	.widget-light-skin.widget-featured-posts>.entry .entry-meta,
	.widget-light-skin.widget-featured-products>.entry .entry-meta,
	.widget-light-skin.widget-cart>.entry .entry-meta {
		color: rgba(255, 255, 255, 0.5)
	}

	.widget-light-skin .tag {
		border-color: rgba(255, 255, 255, 0.13);
		color: #fff !important
	}

	.widget-light-skin .tag:hover {
		background-color: #fff;
		color: #505050 !important
	}

	.widget-light-skin .tag.active {
		border-color: #BF202F;
		background-color: #BF202F;
		color: #fff !important
	}

	.steps {
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-wrap: wrap;
		flex-wrap: wrap;
		-webkit-box-pack: justify;
		-ms-flex-pack: justify;
		justify-content: space-between
	}

	.steps .step {
		display: block;
		position: relative;
		width: 100%;
		margin-bottom: -1px;
		margin-left: -1px;
		padding: 20px 15px;
		border: 1px solid #e5e5e5;
		background-color: #fff;
		z-index: 1;
		text-align: center;
		text-decoration: none
	}

	.steps .step:first-child {
		border-top-left-radius: 5px;
		border-bottom-left-radius: 5px
	}

	.steps .step:last-child {
		border-top-right-radius: 5px;
		border-bottom-right-radius: 5px
	}

	.steps .step .step-title {
		margin-bottom: 0;
		font-size: 14px;
		font-weight: normal;
		letter-spacing: .025em
	}

	.steps .step .step-title>i {
		margin-top: -2px;
		margin-right: 6px;
		color: #4caf50;
		font-size: 1.2em;
		vertical-align: middle
	}

	.steps .step>i {
		display: inline-block;
		margin-bottom: 12px;
		color: rgba(153, 153, 153, 0.6);
		font-size: 1.8em
	}

	.steps .step.active {
		border-color: #BF202F;
		cursor: default;
		z-index: 5;
		pointer-events: none
	}

	.steps .step.active .step-title,
	.steps .step.active>i {
		color: #BF202F
	}

	.steps a.step:not(.active) {
		transition: background-color .35s
	}

	.steps a.step:not(.active):hover {
		background-color: #f5f5f5
	}

	@media (max-width: 576px) {
		.steps .step:first-child {
			border-top-left-radius: 5px;
			border-top-right-radius: 5px;
			border-bottom-left-radius: 0
		}

		.steps .step:last-child {
			border-top-right-radius: 0;
			border-bottom-right-radius: 5px;
			border-bottom-left-radius: 5px
		}
	}

	.comparison-table {
		width: 100%;
		overflow-x: auto;
		-webkit-overflow-scrolling: touch;
		-ms-overflow-style: -ms-autohiding-scrollbar
	}

	.comparison-table table {
		min-width: 650px;
		table-layout: fixed
	}

	.comparison-table .comparison-item {
		position: relative;
		padding: 13px 12px 18px;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff;
		text-align: center
	}

	.comparison-table .comparison-item .comparison-item-thumb {
		display: block;
		width: 80px;
		margin-right: auto;
		margin-bottom: 12px;
		margin-left: auto
	}

	.comparison-table .comparison-item .comparison-item-thumb>img {
		display: block;
		width: 100%
	}

	.comparison-table .comparison-item .comparison-item-title {
		display: block;
		width: 100%;
		margin-bottom: 14px;
		transition: color .25s;
		color: #505050;
		font-size: 14px;
		font-weight: 500;
		text-decoration: none
	}

	.comparison-table .comparison-item .comparison-item-title:hover {
		color: #BF202F
	}

	.comparison-table .comparison-item .btn {
		margin: 0
	}

	.comparison-table .comparison-item .remove-item {
		display: block;
		position: absolute;
		top: -5px;
		right: -5px;
		width: 22px;
		height: 22px;
		border-radius: 50%;
		background-color: #f44336;
		color: #fff;
		line-height: 25px;
		text-align: center;
		cursor: pointer
	}

	.fw-section,
	.fh-section {
		position: relative;
		background-position: 50% 50%;
		background-repeat: no-repeat;
		background-size: cover
	}

	.fw-section>.overlay,
	.fh-section>.overlay {
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: #000;
		content: '';
		opacity: .6;
		z-index: 1
	}

	.fw-section>.container,
	.fw-section>.container-fluid,
	.fw-section>div,
	.fh-section>.container,
	.fh-section>.container-fluid,
	.fh-section>div {
		position: relative;
		z-index: 5
	}

	.fw-section.bg-fixed,
	.fh-section.bg-fixed {
		background-attachment: fixed
	}

	.fw-section.no-cover-bg,
	.fh-section.no-cover-bg {
		background-size: auto
	}

	.fw-section {
		width: 100%
	}

	.fh-section {
		height: 100vh
	}

	.isotope-grid {
		position: relative;
		overflow: hidden
	}

	.isotope-grid:not(.filter-grid) {
		min-height: 180px;
		background-position: center;
		background-image: url(../img/loading.gif);
		background-repeat: no-repeat;
		background-size: 50px
	}

	.isotope-grid:not(.filter-grid)>.grid-item {
		display: none
	}

	.isotope-grid:not(.filter-grid)[style] {
		background: none
	}

	.isotope-grid:not(.filter-grid)[style]>.grid-item {
		display: inline-block;
		-webkit-animation: showGrid .6s;
		animation: showGrid .6s
	}

	.isotope-grid .gutter-sizer {
		width: 30px
	}

	.isotope-grid .grid-item {
		margin-bottom: 30px
	}

	.isotope-grid .grid-item .post-tile,
	.isotope-grid .grid-item .portfolio-tile {
		margin-bottom: 0
	}

	.isotope-grid.cols-1 .gutter-sizer {
		width: 0
	}

	.isotope-grid.cols-1 .grid-sizer,
	.isotope-grid.cols-1 .grid-item {
		width: 100%
	}

	.isotope-grid.cols-2 .grid-sizer,
	.isotope-grid.cols-2 .grid-item {
		width: calc((100% / 2) - 15px)
	}

	.isotope-grid.cols-3 .grid-sizer,
	.isotope-grid.cols-3 .grid-item {
		width: calc((100% / 3) - 20px)
	}

	.isotope-grid.cols-4 .grid-sizer,
	.isotope-grid.cols-4 .grid-item {
		width: calc((100% / 4) - 22.5px)
	}

	.isotope-grid.cols-5 .grid-sizer,
	.isotope-grid.cols-5 .grid-item {
		width: calc((100% / 5) - 24px)
	}

	.isotope-grid.cols-6 .grid-sizer,
	.isotope-grid.cols-6 .grid-item {
		width: calc((100% / 6) - 25px)
	}

	@media (max-width: 1200px) {

		.isotope-grid.cols-6 .grid-sizer,
		.isotope-grid.cols-6 .grid-item,
		.isotope-grid.cols-5 .grid-sizer,
		.isotope-grid.cols-5 .grid-item,
		.isotope-grid.cols-4 .grid-sizer,
		.isotope-grid.cols-4 .grid-item,
		.isotope-grid.cols-3 .grid-sizer,
		.isotope-grid.cols-3 .grid-item {
			width: calc((100% / 3) - 22.5px)
		}
	}

	@media (max-width: 768px) {

		.isotope-grid.cols-6 .grid-sizer,
		.isotope-grid.cols-6 .grid-item,
		.isotope-grid.cols-5 .grid-sizer,
		.isotope-grid.cols-5 .grid-item,
		.isotope-grid.cols-4 .grid-sizer,
		.isotope-grid.cols-4 .grid-item,
		.isotope-grid.cols-3 .grid-sizer,
		.isotope-grid.cols-3 .grid-item {
			width: calc((100% / 2) - 15px)
		}
	}

	@media (max-width: 576px) {

		.isotope-grid.cols-6 .gutter-sizer,
		.isotope-grid.cols-5 .gutter-sizer,
		.isotope-grid.cols-4 .gutter-sizer,
		.isotope-grid.cols-3 .gutter-sizer,
		.isotope-grid.cols-2 .gutter-sizer {
			width: 0
		}

		.isotope-grid.cols-6 .grid-sizer,
		.isotope-grid.cols-6 .grid-item,
		.isotope-grid.cols-5 .grid-sizer,
		.isotope-grid.cols-5 .grid-item,
		.isotope-grid.cols-4 .grid-sizer,
		.isotope-grid.cols-4 .grid-item,
		.isotope-grid.cols-3 .grid-sizer,
		.isotope-grid.cols-3 .grid-item,
		.isotope-grid.cols-2 .grid-sizer,
		.isotope-grid.cols-2 .grid-item {
			width: 100%
		}
	}

	.isotope-grid.grid-no-gap .gutter-sizer {
		width: 0
	}

	.isotope-grid.grid-no-gap .grid-item {
		margin-bottom: 0
	}

	.isotope-grid.grid-no-gap.cols-2 .grid-sizer,
	.isotope-grid.grid-no-gap.cols-2 .grid-item {
		width: 50%
	}

	.isotope-grid.grid-no-gap.cols-3 .grid-sizer,
	.isotope-grid.grid-no-gap.cols-3 .grid-item {
		width: 33.3333333333%
	}

	.isotope-grid.grid-no-gap.cols-4 .grid-sizer,
	.isotope-grid.grid-no-gap.cols-4 .grid-item {
		width: 25%
	}

	.isotope-grid.grid-no-gap.cols-5 .grid-sizer,
	.isotope-grid.grid-no-gap.cols-5 .grid-item {
		width: 20%
	}

	.isotope-grid.grid-no-gap.cols-6 .grid-sizer,
	.isotope-grid.grid-no-gap.cols-6 .grid-item {
		width: 16.6666666667%
	}

	@media (max-width: 1200px) {

		.isotope-grid.grid-no-gap.cols-6 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-6 .grid-item,
		.isotope-grid.grid-no-gap.cols-5 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-5 .grid-item,
		.isotope-grid.grid-no-gap.cols-4 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-4 .grid-item,
		.isotope-grid.grid-no-gap.cols-3 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-3 .grid-item {
			width: 33.3333333333%
		}
	}

	@media (max-width: 768px) {

		.isotope-grid.grid-no-gap.cols-6 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-6 .grid-item,
		.isotope-grid.grid-no-gap.cols-5 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-5 .grid-item,
		.isotope-grid.grid-no-gap.cols-4 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-4 .grid-item,
		.isotope-grid.grid-no-gap.cols-3 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-3 .grid-item {
			width: 50%
		}
	}

	@media (max-width: 576px) {

		.isotope-grid.grid-no-gap.cols-6 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-6 .grid-item,
		.isotope-grid.grid-no-gap.cols-5 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-5 .grid-item,
		.isotope-grid.grid-no-gap.cols-4 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-4 .grid-item,
		.isotope-grid.grid-no-gap.cols-3 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-3 .grid-item,
		.isotope-grid.grid-no-gap.cols-2 .grid-sizer,
		.isotope-grid.grid-no-gap.cols-2 .grid-item {
			width: 100%
		}
	}

	@-webkit-keyframes showGrid {
		from {
			opacity: 0
		}

		to {
			opacity: 1
		}
	}

	@keyframes showGrid {
		from {
			opacity: 0
		}

		to {
			opacity: 1
		}
	}

	@supports (-ms-ime-align: auto) {
		.isotope-grid:not(.filter-grid) {
			min-height: auto;
			background: none
		}

		.isotope-grid:not(.filter-grid)>.grid-item {
			display: inline-block
		}

		.isotope-grid:not(.filter-grid)[style]>.grid-item {
			-webkit-animation: none;
			animation: none
		}
	}

	.site-header {
		position: relative;
		z-index: 1000
	}

	.site-header .topbar {
		border-top: 1px solid #e5e5e5;
		border-bottom: 1px solid #e5e5e5;
		background-color: #fff
	}

	.site-header .navbar {
		position: relative;
		width: 100%;
		border-bottom: 1px solid #e5e5e5;
		background-color: #f5f5f5
	}

	.site-header .site-branding {
		-ms-flex-preferred-size: auto;
		flex-basis: auto;
		-webkit-box-flex: 0;
		-ms-flex-positive: 0;
		flex-grow: 0;
		-ms-flex-negative: 0;
		flex-shrink: 0;
		padding: 18px 30px;
		border-right: 1px solid #e5e5e5
	}

	.site-header .site-branding .site-logo {
		display: block;
		width: 136px;
		color: #232323 !important;
		text-decoration: none
	}

	.site-header .site-branding .site-logo>img {
		display: block;
		width: 100%
	}

	.site-header .search-box-wrap {
		width: 100%;
		padding: 18px 30px
	}

	.site-header .search-box-wrap .search-box-inner {
		width: 100%
	}

	.site-header .search-box-wrap .search-box {
		width: 100%
	}

	.site-header .search-box-wrap .categories-btn {
		-ms-flex-preferred-size: auto;
		flex-basis: auto;
		-webkit-box-flex: 0;
		-ms-flex-positive: 0;
		flex-grow: 0;
		-ms-flex-negative: 0;
		flex-shrink: 0;
		margin: 0
	}

	.site-header .search-box-wrap .categories-btn .btn {
		padding: 0 15px;
		border-right: 0;
		border-top-right-radius: 0;
		border-bottom-right-radius: 0
	}

	.site-header .search-box-wrap .input-group {
		width: 100%
	}

	.site-header .search-box-wrap .input-group .form-control {
		border-top-left-radius: 0;
		border-bottom-left-radius: 0
	}

	.site-header .toolbar {
		-ms-flex-preferred-size: auto;
		flex-basis: auto;
		-webkit-box-flex: 0;
		-ms-flex-positive: 0;
		flex-grow: 0;
		-ms-flex-negative: 0;
		flex-shrink: 0
	}

	.site-header .toolbar .toolbar-item {
		position: relative;
		width: 96px;
		transition: background-color .3s;
		border-left: 1px solid #e5e5e5
	}

	.site-header .toolbar .toolbar-item.visible-on-mobile {
		display: none
	}

	.site-header .toolbar .toolbar-item>a {
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		padding: 5px;
		color: #505050;
		text-align: center;
		text-decoration: none
	}

	.site-header .toolbar .toolbar-item>a>div {
		position: absolute;
		top: 50%;
		left: 0;
		width: 100%;
		-webkit-transform: translateY(-50%);
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
		text-align: center
	}

	.site-header .toolbar .toolbar-item>a>div i {
		display: inline-block;
		margin-bottom: 6px;
		font-size: 20px
	}

	.site-header .toolbar .toolbar-item>a>div>.text-label {
		display: block;
		font-size: 12px
	}

	.site-header .toolbar .toolbar-item>a>div>.compare-icon,
	.site-header .toolbar .toolbar-item>a>div>.cart-icon {
		display: inline-block;
		position: relative
	}

	.site-header .toolbar .toolbar-item>a>div>.compare-icon>.count-label,
	.site-header .toolbar .toolbar-item>a>div>.cart-icon>.count-label {
		display: block;
		position: absolute;
		top: -6px;
		right: -13px;
		width: 18px;
		height: 18px;
		border-radius: 50%;
		background-color: #BF202F;
		color: #fff;
		font-size: 11px;
		line-height: 18px
	}

	.site-header .toolbar .toolbar-item>a>div>.compare-icon>.count-label {
		right: -17px;
		border: 1px solid #e5e5e5;
		background-color: #f5f5f5;
		color: #505050
	}

	.site-header .toolbar .toolbar-item:hover,
	.site-header .toolbar .toolbar-item.active {
		background-color: #f5f5f5
	}

	.site-header .toolbar .toolbar-item:hover>.toolbar-dropdown,
	.site-header .toolbar .toolbar-item.active>.toolbar-dropdown {
		display: block;
		-webkit-animation: submenu-show .35s;
		animation: submenu-show .35s
	}

	.site-header .toolbar .toolbar-item .flag-icon {
		display: inline-block;
		width: 20px;
		vertical-align: middle
	}

	.site-header .toolbar .toolbar-item .flag-icon>img {
		display: block;
		width: 100%
	}

	.site-header .site-menu {
		display: block;
		position: relative;
		width: 100%;
		z-index: 1
	}

	.site-header .site-menu ul {
		margin: 0;
		padding: 0;
		list-style: none
	}

	.site-header .site-menu ul>li>a {
		transition: all .3s;
		color: #505050;
		text-decoration: none
	}

	.site-header .site-menu>ul {
		display: table;
		margin: auto
	}

	.site-header .site-menu>ul>li {
		display: table-cell;
		position: relative;
		vertical-align: middle
	}

	.site-header .site-menu>ul>li>a {
		display: block;
		position: relative;
		padding: 20px 18px;
		border-right: 1px solid transparent;
		border-left: 1px solid transparent;
		font-size: 15px;
		font-weight: normal;
		z-index: 5
	}

	.site-header .site-menu>ul>li>a::after {
		display: none
	}

	.site-header .site-menu>ul>li:hover>a {
		color: #BF202F
	}

	.site-header .site-menu>ul>li:hover>.sub-menu {
		display: block;
		-webkit-animation: submenu-show .35s;
		animation: submenu-show .35s
	}

	.site-header .site-menu>ul>li:hover>.mega-menu {
		display: table;
		-webkit-animation: submenu-show .35s;
		animation: submenu-show .35s
	}

	.site-header .site-menu>ul>li.active>a {
		color: #BF202F
	}

	.site-header .site-menu>ul>li.active>a::before {
		display: block;
		position: absolute;
		top: -1px;
		left: 0;
		width: 100%;
		height: 2px;
		background-color: #BF202F;
		content: ''
	}

	.site-header .site-menu>ul>li.has-submenu:hover>a,
	.site-header .site-menu>ul>li.has-megamenu:hover>a {
		border-color: #e5e5e5;
		background-color: #fff
	}

	.site-header .site-menu>ul>li.has-submenu:hover>a::after,
	.site-header .site-menu>ul>li.has-megamenu:hover>a::after {
		display: block;
		position: absolute;
		bottom: -2px;
		left: 0;
		width: 100%;
		height: 4px;
		background-color: #fff;
		content: '';
		-webkit-animation: submenu-show .25s;
		animation: submenu-show .25s
	}

	.site-header .site-menu>ul>li.has-megamenu {
		position: static
	}

	.navbar .toolbar,
	.navbar .categories-btn {
		display: none
	}

	.navbar-stuck .navbar {
		position: fixed;
		top: 0;
		left: 0;
		background-color: #fff;
		box-shadow: 0 7px 30px -6px rgba(0, 0, 0, 0.15)
	}

	.navbar-stuck .navbar .toolbar {
		display: block;
		position: absolute;
		top: 0;
		right: 0;
		height: 100%;
		z-index: 5;
		-webkit-animation: toolbar-in .6s;
		animation: toolbar-in .6s
	}

	.navbar-stuck .navbar .toolbar>.toolbar-inner {
		display: table;
		width: 100%;
		height: 100%;
		min-height: 100%
	}

	.navbar-stuck .navbar .toolbar .toolbar-item {
		display: table-cell
	}

	@media screen {
		.navbar-stuck .navbar .toolbar .toolbar-item {
			width: 80px
		}

		.mobile-menu-myaccount.open {
			display: block
		}
	}

	@media (max-width: 1200px) {
		.navbar-stuck .navbar .toolbar .toolbar-item {
			width: 80px
		}

		.mobile-menu-myaccount.open {
			display: block
		}
	}

	.navbar-stuck .navbar .categories-btn {
		display: block;
		position: absolute;
		left: 30px;
		z-index: 5;
		-webkit-animation: toolbar-in .6s;
		animation: toolbar-in .6s
	}

	.navbar-stuck .navbar .categories-btn>.btn {
		padding: 0 15px
	}

	@media (max-width: 1200px) {
		.navbar-stuck .navbar .categories-btn {
			left: 15px
		}
	}

	@-webkit-keyframes toolbar-in {
		from {
			opacity: 0
		}

		to {
			opacity: 1
		}
	}

	@keyframes toolbar-in {
		from {
			opacity: 0
		}

		to {
			opacity: 1
		}
	}

	.mobile-menu {
		display: none;
		position: absolute;
		top: 100%;
		left: 0;
		width: 100%;
		padding-top: 15px;
		background-color: #f5f5f5;
		box-shadow: 0 7px 30px -6px rgba(0, 0, 0, 0.15)
	}

	.mobile-menu .mobile-search {
		padding-right: 15px;
		padding-bottom: 15px;
		padding-left: 15px
	}

	.mobile-menu .toolbar {
		display: table;
		width: 100%;
		margin-bottom: 15px
	}

	.mobile-menu .toolbar .toolbar-item {
		display: table-cell;
		height: 75px;
		border-top: 1px solid #e5e5e5;
		border-bottom: 1px solid #e5e5e5;
		background-color: #fff;
		vertical-align: middle
	}

	.mobile-menu-myaccount {
		display: none;
		position: absolute;
		top: 100%;
		left: 0;
		width: 100%;
		padding-top: 15px;
		background-color: #f5f5f5;
		box-shadow: 0 7px 30px -6px rgba(0, 0, 0, 0.15)
	}

	.mobile-menu-myaccount .mobile-search {
		padding-right: 15px;
		padding-bottom: 15px;
		padding-left: 15px
	}

	.mobile-menu-myaccount .toolbar {
		display: table;
		width: 100%;
		margin-bottom: 15px
	}

	.mobile-menu-myaccount .toolbar .toolbar-item {
		display: table-cell;
		height: 75px;
		border-top: 1px solid #e5e5e5;
		border-bottom: 1px solid #e5e5e5;
		background-color: #fff;
		vertical-align: middle
	}

	@media (max-width: 991px) {
		body {
			padding-top: 0 !important
		}

		.navbar,
		.search-box-wrap,
		.hidden-on-mobile {
			display: none !important
		}

		.site-header .site-branding {
			padding-right: 15px;
			padding-left: 15px;
			border: 0
		}

		.site-header .toolbar .toolbar-item.visible-on-mobile {
			display: block
		}

		.mobile-menu.open {
			display: block
		}

		.mobile-menu-myaccount.open {
			display: block
		}
	}

	@media (max-width: 360px) {
		.site-header .toolbar .toolbar-item {
			width: 75px
		}
	}

	.page-title {
		width: 100%;
		margin-bottom: 60px;
		padding: 36px 0;
		background-color: #fff;
		box-shadow: 0 7px 30px -6px rgba(0, 0, 0, 0.12)
	}

	.page-title>.container,
	.page-title>.container-fluid {
		display: table
	}

	.page-title .column {
		display: table-cell;
		vertical-align: middle
	}

	.page-title .column:first-child {
		width: 60%;
		padding-right: 20px
	}

	.page-title h1,
	.page-title h2,
	.page-title h3 {
		margin: 0;
		font-size: 24px;
		line-height: 1.3
	}

	.breadcrumbs {
		display: block;
		margin: 0;
		padding: 0;
		list-style: none;
		text-align: right
	}

	.breadcrumbs>li {
		display: inline-block;
		margin-left: -4px;
		padding: 5px 0;
		color: #999;
		font-size: 13px;
		cursor: default;
		vertical-align: middle
	}

	.breadcrumbs>li.separator {
		margin-top: 2px;
		margin-left: 3px;
		color: #505050;
		font-family: feather;
		font-size: 14px
	}

	.breadcrumbs>li.separator::before {
		content: '\e930'
	}

	.breadcrumbs>li>a {
		transition: color .25s;
		color: #505050;
		text-decoration: none
	}

	.breadcrumbs>li>a:hover {
		color: #BF202F
	}

	.breadcrumbs>li:first-child>a::before {
		display: inline-block;
		margin-top: -1px;
		margin-right: 6px;
		font-family: feather;
		font-size: 14px;
		content: '\e979';
		vertical-align: middle
	}

	@-moz-document url-prefix() {
		.breadcrumbs>li.separator {
			margin-top: 1px
		}

		.breadcrumbs>li:first-child>a::before {
			margin-top: -2px
		}
	}

	@media (max-width: 991px) {
		.page-title {
			margin-bottom: 53px
		}

		.page-title>.container,
		.page-title>.container-fluid {
			display: block
		}

		.page-title .column {
			display: block;
			width: 100%;
			text-align: center
		}

		.page-title .column:first-child {
			width: 100%;
			padding-right: 0
		}

		.breadcrumbs {
			padding-top: 15px;
			text-align: center
		}

		.breadcrumbs>li {
			margin-left: 3px;
			margin-margin-right: 3px
		}
	}

	.site-footer {
		padding-top: 72px;
		background-position: center bottom;
		background-color: #232323;
		background-repeat: no-repeat
	}

	@media (max-width: 768px) {
		.site-footer {
			padding-top: 48px
		}
	}

	.footer-copyright {
		margin: 0;
		padding-top: 10px;
		padding-bottom: 24px;
		color: rgba(255, 255, 255, 0.5);
		font-size: 13px;
		font-weight: normal
	}

	.footer-copyright>a {
		transition: color .25s;
		color: rgba(255, 255, 255, 0.5);
		text-decoration: none
	}

	.footer-copyright>a:hover {
		color: #fff
	}

	.footer-light {
		background-color: #f5f5f5
	}

	.footer-light .footer-copyright {
		color: #999
	}

	.footer-light .footer-copyright>a {
		color: #999
	}

	.footer-light .footer-copyright>a:hover {
		color: #BF202F
	}

	.user-info-wrapper {
		position: relative;
		width: 100%;
		margin-bottom: -1px;
		padding-top: 90px;
		padding-bottom: 30px;
		border: 1px solid #e5e5e5;
		border-top-left-radius: 6px;
		border-top-right-radius: 6px;
		overflow: hidden
	}

	.user-info-wrapper .user-cover {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 120px;
		background-position: center;
		background-color: #f5f5f5;
		background-repeat: no-repeat;
		background-size: cover
	}

	.user-info-wrapper .user-cover .tooltip .tooltip-inner {
		width: 230px;
		max-width: 100%;
		padding: 10px 15px
	}

	.user-info-wrapper .info-label {
		display: block;
		position: absolute;
		top: 18px;
		right: 18px;
		height: 26px;
		padding: 0 12px;
		border-radius: 4px;
		background-color: #fff;
		color: #505050;
		font-size: 12px;
		line-height: 26px;
		box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.18);
		cursor: pointer
	}

	.user-info-wrapper .info-label>i {
		display: inline-block;
		margin-right: 3px;
		font-size: 1.2em;
		vertical-align: middle
	}

	.user-info-wrapper .user-info {
		display: table;
		position: relative;
		width: 100%;
		padding: 0 18px;
		z-index: 5
	}

	.user-info-wrapper .user-info .user-avatar,
	.user-info-wrapper .user-info .user-data {
		display: table-cell;
		vertical-align: top
	}

	.user-info-wrapper .user-info .user-avatar {
		position: relative;
		width: 115px
	}

	.user-info-wrapper .user-info .user-avatar>img {
		display: block;
		width: 100%;
		border: 5px solid #fff;
		border-radius: 50%
	}

	.user-info-wrapper .user-info .user-avatar .edit-avatar {
		display: block;
		position: absolute;
		top: -2px;
		right: 2px;
		width: 36px;
		height: 36px;
		transition: opacity .3s;
		border-radius: 50%;
		background-color: #fff;
		color: #505050;
		line-height: 34px;
		box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.2);
		cursor: pointer;
		opacity: 0;
		text-align: center;
		text-decoration: none
	}

	.user-info-wrapper .user-info .user-avatar .edit-avatar::before {
		font-family: feather;
		font-size: 17px;
		content: '\e95a'
	}

	.user-info-wrapper .user-info .user-avatar:hover .edit-avatar {
		opacity: 1
	}

	.user-info-wrapper .user-info .user-data {
		padding-top: 48px;
		padding-left: 12px
	}

	.user-info-wrapper .user-info .user-data h4 {
		margin-bottom: 2px
	}

	.user-info-wrapper .user-info .user-data span {
		display: block;
		color: #999;
		font-size: 12px
	}

	.user-info-wrapper+.list-group .list-group-item:first-child {
		border-radius: 0
	}

	.product-card {
		display: block;
		position: relative;
		width: 100%;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff
	}

	.product-card .product-card-body {
		padding: 18px;
		padding-top: 15px;
		text-align: center
	}

	.product-card .product-thumb {
		display: block;
		width: 100%;
		padding-top: 20px;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
		overflow: hidden
	}

	.product-card .product-thumb>img {
		display: block;
		width: 100%
	}

	.product-card .product-category {
		width: 100%;
		margin-bottom: 6px;
		font-size: 12px
	}

	.product-card .product-category>a {
		transition: color .2s;
		color: #999;
		text-decoration: none
	}

	.product-card .product-category>a:hover {
		color: #BF202F
	}

	.product-card .product-title {
		margin-bottom: 18px;
		font-size: 16px;
		font-weight: normal
	}

	.product-card .product-title>a {
		transition: color .3s;
		color: #232323;
		text-decoration: none
	}

	.product-card .product-title>a:hover {
		color: #BF202F
	}

	.product-card .product-price {
		display: inline-block;
		margin-bottom: 10px;
		padding: 9px 15px;
		border-radius: 4px;
		background-color: #fff6e3;
		color: #232323;
		font-size: 16px;
		font-weight: normal;
		text-align: center
	}

	.product-card .product-price>del {
		margin-right: 5px;
		color: #999
	}

	.product-card .product-button-group {
		display: table;
		width: 100%;
		border-top: 1px solid #e5e5e5;
		table-layout: fixed
	}

	.product-card .product-button-group .product-button {
		display: table-cell;
		position: relative;
		height: 62px;
		padding: 10px;
		transition: background-color .3s;
		border: 0;
		border-right: 1px solid #e5e5e5;
		background: none;
		color: #505050;
		overflow: hidden;
		vertical-align: middle;
		text-align: center;
		text-decoration: none
	}

	.product-card .product-button-group .product-button:first-child {
		border-bottom-left-radius: 5px
	}

	.product-card .product-button-group .product-button:last-child {
		border-right: 0;
		border-bottom-right-radius: 5px
	}

	.product-card .product-button-group .product-button>i,
	.product-card .product-button-group .product-button>span {
		transition: all .3s
	}

	.product-card .product-button-group .product-button>i {
		display: inline-block;
		position: relative;
		margin-top: 5px;
		font-size: 18px
	}

	.product-card .product-button-group .product-button>span {
		display: block;
		position: absolute;
		bottom: 9px;
		left: 0;
		width: 100%;
		-webkit-transform: translateY(12px);
		-ms-transform: translateY(12px);
		transform: translateY(12px);
		font-size: 12px;
		white-space: nowrap;
		opacity: 0
	}

	.product-card .product-button-group .product-button:hover {
		background-color: #f5f5f5
	}

	.product-card .product-button-group .product-button:hover>i {
		-webkit-transform: translateY(-10px);
		-ms-transform: translateY(-10px);
		transform: translateY(-10px)
	}

	.product-card .product-button-group .product-button:hover>span {
		-webkit-transform: translateY(0);
		-ms-transform: translateY(0);
		transform: translateY(0);
		opacity: 1
	}

	.product-card .product-button-group .product-button.btn-wishlist.active>i {
		color: #f44336
	}

	.product-card .product-button-group .product-button.btn-compare.active>i::after {
		display: block;
		position: absolute;
		top: -5px;
		right: -6px;
		width: 7px;
		height: 7px;
		border-radius: 50%;
		background-color: #4caf50;
		content: ''
	}

	.product-card .product-badge {
		top: 12px;
		left: 12px
	}

	.product-card .rating-stars {
		position: absolute;
		top: 9px;
		right: 12px
	}

	@media (min-width: 576px) {
		.product-card.product-list {
			display: table;
			width: 100%;
			padding: 0
		}

		.product-card.product-list .product-thumb,
		.product-card.product-list .product-card-inner {
			display: table-cell;
			vertical-align: middle
		}

		.product-card.product-list .product-thumb {
			position: relative;
			width: 270px;
			border-right: 1px solid #e5e5e5;
			border-top-right-radius: 0
		}

		.product-card.product-list .product-card-body {
			padding: 32px 22px 18px;
			text-align: left
		}
	}

	.touchevents .product-card .product-button-group .product-button>i {
		-webkit-transform: translateY(-10px);
		-ms-transform: translateY(-10px);
		transform: translateY(-10px)
	}

	.touchevents .product-card .product-button-group .product-button>span {
		-webkit-transform: translateY(0);
		-ms-transform: translateY(0);
		transform: translateY(0);
		opacity: 1
	}

	.product-badge {
		position: absolute;
		height: 24px;
		padding: 0 14px;
		border-radius: 3px;
		color: #fff;
		font-size: 12px;
		font-weight: 400;
		letter-spacing: .025em;
		line-height: 24px;
		white-space: nowrap
	}

	.rating-stars {
		display: inline-block
	}

	.rating-stars>i {
		display: inline-block;
		margin-right: 2px;
		color: #bfbfbf;
		font-size: 12px
	}

	.rating-stars>i.filled {
		color: #ffa000
	}

	.rating-stars>i:last-child {
		margin-right: 0
	}

	.shop-toolbar {
		display: table;
		width: 100%
	}

	.shop-toolbar>.column {
		display: table-cell;
		vertical-align: middle
	}

	.shop-toolbar>.column:last-child {
		text-align: right
	}

	@media (max-width: 576px) {
		.shop-toolbar>.column {
			display: block;
			width: 100%;
			text-align: center
		}

		.shop-toolbar>.column:last-child {
			padding-top: 24px;
			text-align: center
		}
	}

	.shop-sorting label,
	.shop-sorting .form-control,
	.shop-sorting span {
		display: inline-block;
		vertical-align: middle
	}

	.shop-sorting span {
		padding: 8px 0
	}

	.shop-sorting label {
		margin: 0;
		padding: 8px 5px 8px 0;
		color: #999;
		font-size: 13px;
		font-weight: normal
	}

	.shop-sorting .form-control {
		width: 100%;
		max-width: 186px;
		margin-right: 10px
	}

	@media (max-width: 576px) {

		.shop-sorting label,
		.shop-sorting .form-control {
			display: block;
			width: 100%;
			max-width: 100%;
			margin: 0;
			padding-top: 0;
			padding-right: 0
		}
	}

	.shop-view {
		display: inline-block
	}

	.shop-view::after {
		display: block;
		clear: both;
		content: ''
	}

	.shop-view>a {
		display: block;
		width: 43px;
		height: 43px;
		margin-left: -1px;
		padding: 13px;
		float: left;
		transition: background-color .35s;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff
	}

	.shop-view>a:first-child {
		border-top-right-radius: 0;
		border-bottom-right-radius: 0
	}

	.shop-view>a:last-child {
		border-top-left-radius: 0;
		border-bottom-left-radius: 0
	}

	.shop-view>a span {
		display: block;
		position: relative;
		width: 3px;
		height: 3px;
		margin-bottom: 3px;
		background-color: #505050
	}

	.shop-view>a span::before,
	.shop-view>a span::after {
		display: block;
		position: absolute;
		background-color: #505050
	}

	.shop-view>a span:last-child {
		margin-bottom: 0
	}

	.shop-view>a:hover {
		background-color: #f5f5f5
	}

	.shop-view>a.active {
		border-color: #BF202F;
		background-color: #BF202F;
		cursor: default;
		pointer-events: none
	}

	.shop-view>a.active span,
	.shop-view>a.active span::before,
	.shop-view>a.active span::after {
		background-color: #fff
	}

	.shop-view>a.grid-view span::before,
	.shop-view>a.grid-view span::after {
		top: 0;
		width: 3px;
		height: 3px;
		content: ''
	}

	.shop-view>a.grid-view span::before {
		left: 6px
	}

	.shop-view>a.grid-view span::after {
		left: 12px
	}

	.shop-view>a.list-view span::before {
		top: 1px;
		left: 6px;
		width: 9px;
		height: 1px;
		content: ''
	}

	.shopping-cart,
	.wishlist-table,
	.order-table {
		margin-bottom: 20px
	}

	.shopping-cart .table,
	.wishlist-table .table,
	.order-table .table {
		margin-bottom: 0
	}

	.shopping-cart .btn,
	.wishlist-table .btn,
	.order-table .btn {
		margin: 0
	}

	.shopping-cart>table>thead>tr>th,
	.shopping-cart>table>thead>tr>td,
	.shopping-cart>table>tbody>tr>th,
	.shopping-cart>table>tbody>tr>td,
	.wishlist-table>table>thead>tr>th,
	.wishlist-table>table>thead>tr>td,
	.wishlist-table>table>tbody>tr>th,
	.wishlist-table>table>tbody>tr>td,
	.order-table>table>thead>tr>th,
	.order-table>table>thead>tr>td,
	.order-table>table>tbody>tr>th,
	.order-table>table>tbody>tr>td {
		vertical-align: middle !important
	}

	.shopping-cart>table thead th,
	.wishlist-table>table thead th,
	.order-table>table thead th {
		padding-top: 17px;
		padding-bottom: 17px;
		border-width: 1px
	}

	.shopping-cart .remove-from-cart,
	.wishlist-table .remove-from-cart,
	.order-table .remove-from-cart {
		display: inline-block;
		color: #f44336;
		font-size: 18px;
		line-height: 1;
		text-decoration: none
	}

	.shopping-cart .count-input,
	.wishlist-table .count-input,
	.order-table .count-input {
		display: inline-block;
		width: 100%;
		width: 86px
	}

	.shopping-cart .product-item,
	.wishlist-table .product-item,
	.order-table .product-item {
		display: table;
		width: 100%;
		min-width: 150px;
		margin-top: 5px;
		margin-bottom: 3px
	}

	.shopping-cart .product-item .product-thumb,
	.shopping-cart .product-item .product-info,
	.wishlist-table .product-item .product-thumb,
	.wishlist-table .product-item .product-info,
	.order-table .product-item .product-thumb,
	.order-table .product-item .product-info {
		display: table-cell;
		vertical-align: top
	}

	.shopping-cart .product-item .product-thumb,
	.wishlist-table .product-item .product-thumb,
	.order-table .product-item .product-thumb {
		width: 130px;
		padding-right: 20px
	}

	.shopping-cart .product-item .product-thumb>img,
	.wishlist-table .product-item .product-thumb>img,
	.order-table .product-item .product-thumb>img {
		display: block;
		width: 100%
	}

	@media screen and (max-width: 860px) {

		.shopping-cart .product-item .product-thumb,
		.wishlist-table .product-item .product-thumb,
		.order-table .product-item .product-thumb {
			display: none
		}
	}

	.shopping-cart .product-item .product-info span,
	.wishlist-table .product-item .product-info span,
	.order-table .product-item .product-info span {
		display: block;
		font-size: 12px
	}

	.shopping-cart .product-item .product-info span>em,
	.wishlist-table .product-item .product-info span>em,
	.order-table .product-item .product-info span>em {
		font-weight: 500;
		font-style: normal
	}

	.shopping-cart .product-item .product-title,
	.wishlist-table .product-item .product-title,
	.order-table .product-item .product-title {
		margin-bottom: 6px;
		padding-top: 5px;
		font-size: 16px;
		font-weight: normal
	}

	.shopping-cart .product-item .product-title>a,
	.wishlist-table .product-item .product-title>a,
	.order-table .product-item .product-title>a {
		transition: color .3s;
		color: #232323;
		line-height: 1.5;
		text-decoration: none
	}

	.shopping-cart .product-item .product-title>a:hover,
	.wishlist-table .product-item .product-title>a:hover,
	.order-table .product-item .product-title>a:hover {
		color: #BF202F
	}

	.shopping-cart .product-item .product-title small,
	.wishlist-table .product-item .product-title small,
	.order-table .product-item .product-title small {
		display: inline;
		margin-left: 6px;
		font-size: 90%
	}

	.wishlist-table .product-item .product-thumb {
		display: table-cell !important
	}

	@media screen and (max-width: 576px) {
		.wishlist-table .product-item .product-thumb {
			display: none !important
		}
	}

	.shopping-cart-footer {
		display: table;
		width: 100%;
		padding: 10px 0;
		border-top: 1px solid #e5e5e5
	}

	.shopping-cart-footer>.column {
		display: table-cell;
		padding: 5px 0;
		vertical-align: middle
	}

	.shopping-cart-footer>.column:last-child {
		text-align: right
	}

	.shopping-cart-footer>.column:last-child .btn {
		margin-right: 0;
		margin-left: 15px
	}

	@media (max-width: 768px) {
		.shopping-cart-footer>.column {
			display: block;
			width: 100%
		}

		.shopping-cart-footer>.column:last-child {
			text-align: center
		}

		.shopping-cart-footer>.column .btn {
			width: 100%;
			margin: 12px 0 !important
		}
	}

	.sp-categories>a,
	.sp-categories i {
		display: inline-block;
		margin-right: 3px;
		color: #999;
		font-size: 13px;
		text-decoration: none;
		vertical-align: middle
	}

	.sp-categories>a {
		transition: color .25s
	}

	.sp-categories>a:hover {
		color: #BF202F
	}

	.product-gallery {
		position: relative;
		padding-top: 40px;
		padding-right: 15px;
		padding-left: 15px;
		border: 1px solid #e5e5e5;
		border-radius: 6px
	}

	.product-gallery .product-carousel {
		margin-bottom: 15px
	}

	.product-gallery .gallery-item>a::before {
		top: 50%;
		left: 50%;
		width: 70px;
		height: 70px;
		margin-top: -35px;
		margin-left: -35px;
		border-radius: 5px
	}

	.product-gallery .gallery-item>a:hover::before {
		opacity: .7
	}

	.product-gallery .product-badge {
		top: 15px;
		left: 15px;
		z-index: 10
	}

	.product-gallery .product-thumbnails {
		display: block;
		margin: 0;
		margin-right: -15px;
		margin-left: -15px;
		padding: 12px;
		border-top: 1px solid #e5e5e5;
		background-color: #f5f5f5;
		list-style: none;
		text-align: center
	}

	.product-gallery .product-thumbnails>li {
		display: inline-block;
		margin: 10px 3px
	}

	.product-gallery .product-thumbnails>li>a {
		display: block;
		width: 94px;
		transition: all .25s;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff;
		opacity: .75;
		overflow: hidden
	}

	.product-gallery .product-thumbnails>li:hover>a {
		opacity: 1
	}

	.product-gallery .product-thumbnails>li.active>a {
		border-color: #BF202F;
		cursor: default;
		opacity: 1
	}

	.product-gallery .video-btn {
		position: absolute;
		top: 12px;
		right: 12px;
		z-index: 10
	}

	.product-gallery .video-btn>a {
		width: 60px;
		height: 60px
	}

	.category-card {
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		position: relative;
		-webkit-box-pack: justify;
		-ms-flex-pack: justify;
		justify-content: space-between;
		padding: 30px 40px;
		border: 1px solid #e5e5e5;
		background-color: #fff;
		text-decoration: none
	}

	.category-card .category-card-info {
		margin: 0 auto;
		padding: 15px 0
	}

	.category-card .category-card-title {
		margin-bottom: 12px;
		color: #232323;
		font-size: 24px
	}

	.category-card .category-card-subtitle {
		margin: 0;
		color: #999;
		font-size: 13px;
		font-weight: normal
	}

	.category-card .category-card-thumb {
		display: inline-block;
		width: 100%;
		max-width: 400px;
		margin: 0 auto;
		overflow: hidden
	}

	.category-card .category-card-thumb>img {
		display: block;
		width: 100%;
		transition: all .4s;
		-webkit-backface-visibility: hidden;
		backface-visibility: hidden
	}

	.category-card:hover .category-card-thumb>img {
		-webkit-transform: scale(0.94);
		-ms-transform: scale(0.94);
		transform: scale(0.94)
	}

	@media (max-width: 576px) {
		.category-card {
			padding: 15px 25px
		}
	}

	@media screen and (-ms-high-contrast: active),
	screen and (-ms-high-contrast: none) {

		.product-gallery .gallery-item>a::before,
		.product-gallery .gallery-item>a::after {
			display: none !important
		}

		.product-gallery .video-btn {
			display: none !important
		}

		.product-card .product-button-group .product-button>i {
			-webkit-transform: translateY(0) !important;
			-ms-transform: translateY(0) !important;
			transform: translateY(0) !important
		}

		.product-card .product-button-group .product-button>span {
			display: none
		}
	}

	@supports (-ms-ime-align: auto) {

		.product-gallery .gallery-item>a::before,
		.product-gallery .gallery-item>a::after {
			display: none !important
		}

		.product-gallery .video-btn {
			display: none !important
		}

		.product-card .product-button-group .product-button>i {
			-webkit-transform: translateY(0) !important;
			-ms-transform: translateY(0) !important;
			transform: translateY(0) !important
		}

		.product-card .product-button-group .product-button>span {
			display: none
		}
	}

	.blog-post {
		margin-bottom: 30px;
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		background-color: #fff;
		overflow: hidden
	}

	.blog-post .post-body {
		padding: 22px
	}

	.blog-post .post-body>p {
		margin-bottom: 0;
		color: #999;
		font-size: 13px
	}

	.grid-item .blog-post {
		margin-bottom: 0
	}

	.post-meta {
		display: block;
		margin: 0 0 20px;
		padding: 0 0 14px;
		border-bottom: 1px solid #e5e5e5;
		list-style: none
	}

	.post-meta>li {
		display: inline-block;
		margin-right: 14px;
		padding-bottom: 6px;
		color: #505050;
		font-size: 12px;
		cursor: default
	}

	.post-meta>li:last-child {
		border-bottom: 0
	}

	.post-meta>li>i,
	.post-meta>li>a {
		display: inline-block;
		vertical-align: middle
	}

	.post-meta>li>i {
		margin-top: -1px;
		margin-right: 5px;
		color: #999;
		font-size: 13px
	}

	.post-meta>li>a {
		transition: color .25s;
		color: #505050;
		text-decoration: none
	}

	.post-meta>li>a:hover {
		color: #BF202F
	}

	.post-thumb {
		display: block
	}

	.post-thumb>img {
		display: block;
		width: 100%
	}

	.post-title {
		margin-bottom: 12px;
		font-size: 18px;
		font-weight: normal;
		line-height: 1.4
	}

	.post-title>a {
		transition: color .3s;
		color: #232323;
		text-decoration: none
	}

	.post-title>a:hover {
		color: #BF202F
	}
</style>
<header class="container-fluid">

	<?php

	if (isset($_SESSION["validarSesion"])) {
	} else {

	?>

		<!-- REGISTRATE -->
		<div class="alert alert-warning   alert-dismissible fade in text-center" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Regístrate y recíbe un 15% de descuento en tu primer compra. <a href="#modalRegistro" data-toggle="modal">REGISTRARSE</a> </strong>
		</div>


		<!-- FIN REGISTRATE -->
	<?php


	}

	?>
	<br>
	<nav class="navbar ">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>

			</div>

			<div class="container">

				<div class="row" id="navbar-collapse">
					<div class="col-md-2 text-center"> <a href="<?php echo $url; ?>">

							<img src="<?php echo $servidor . $social["logo"]; ?>" class="img-responsive">

						</a>

					</div>



					<div class="col-md-5">

						<a href="<?php echo $url; ?>" class=" btn  btn-rounded " id="boton" style="font-size: 12px;">
							INICIO</a>


						<a href="<?php echo $url; ?>categorias" class="dropdown btn  btn-rounded" id="productos" name="productos" style="font-size: 12px;">
							PRODUCTOS
							<ul class="dropdown-menu" role="menu" id="listaProductosa">
								<?php

								$item = null;
								$valor = null;

								$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

								foreach ($categorias as $key => $value) {
									/* 
								echo '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 ">

										<h4>
										<a href="' . $url . $value["ruta"] . '" class="pixelCategorias backColor " titulo="' . $value["categoria"] . '">
										<img  src="' . $servidor . $value["imgOferta"] . '" width="70%"><br>
										' . $value["categoria"] . '</a>
										</h4>

										<hr>

										<ul>'; */
									/* 			<img  src="' . $servidor . $value["imgOferta"] . '" width="70%">
										' . $value["categoria"] . '</a> */
									$item = "id_categoria";

									$valor = $value["id"];




									echo '<li><a href="' . $url . $value["ruta"] . '" class="pixelSubCategorias " titulo="' . $value["categoria"] . '">' . $value["categoria"] . '</a></li>';;
								}





								?>
							</ul>
						</a>


						<a href="<?php echo $url; ?>ofertas" class="btn  btn-rounded" id="boton" style="font-size: 12px;">
							OFERTAS</a>

						<a href="<?php echo $url; ?>" class="btn  btn-rounded" id="boton" style="font-size: 12px;">
							CONTACTO</a>


						<a href="<?php echo $url; ?>vistas/modulos/blog.php" class="btn  btn-rounded" id="boton" style="font-size: 12px;">
							BLOG</a>
					</div>
					<div class="col-md-3" id="buscador">
						<input type="search" name="buscar" class="form-control" placeholder="Buscar...">

						<a href="<?php echo $url; ?>buscador/1/recientes" style="color: black;">

							<!-- <button class="btn btn-default backColor" type="submit">

									<i class="fa fa-search"></i>

								</button> -->

						</a>

					</div>

					<div class="col-md-1">
						<li class="dropdown notifications-menu ">

							<a href="<?php echo $url; ?>carrito-de-compras" style="color: black; " id="">

								<!-- <i class="fa fa-shopping-bag" aria-hidden="true"></i> -->

								<img src="<?php echo $servidor; ?>vistas/img/plantilla/shopping-cart.png" class=" text-center " style="width: 30px; ">




								<span class="label label-info cantidadCesta text-rigth"></span>



							</a>
							<!-- 			<i class="fa fa-clock-o"></i><span class="cantidadCesta"></span> -->
							<!-- <p>TU CESTA  <br> USD $ <span class="sumaCesta"></span></p> -->
						</li>
					</div>
					<div class="col-md-1">



						<li class="dropdown user user-menu" id="usermenu">

							<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;">

								<!-- <i class="fa fa-user" aria-hidden="true"></i> -->
								<img src="<?php echo $servidor; ?>vistas/img/plantilla/user(1).png" style="width: 30px;">
								<!-- <span class="label label-info sumaCesta text-rigth" ></span>	 -->

							</a>
							<ul class="dropdown-menu" id="productsmenu">

								<?php

								if (isset($_SESSION["validarSesion"])) {

									if ($_SESSION["validarSesion"] == "ok") {

										if ($_SESSION["modo"] == "directo") {

											/* if ($_SESSION["foto"] != "") {

														echo '<li>

												<img class="img-circle" src="' . $url . $_SESSION["foto"] . '" width="25%">

											</li>';
													} else {

														echo '<li>

											<img class="img-circle" src="' . $servidor . 'vistas/img/usuarios/default/anonymous.png" width="25%">

														</li>';
													} */

											echo '
										<li><a href="' . $url . 'perfil">Ver Perfil</a></li>
										
										<li><a href="' . $url . 'salir">Salir</a></li>';
										}

										if ($_SESSION["modo"] == "facebook") {

											echo '<li>

												<img class="img-circle" src="' . $_SESSION["foto"] . '" width="10%">

											</li>
											
												<li><a href="' . $url . 'perfil">Ver Perfil</a></li>
												
												<li><a href="' . $url . 'salir" class="salir">Salir</a></li>';
										}

										if ($_SESSION["modo"] == "google") {

											echo '<li>

												<img class="img-circle" src="' . $_SESSION["foto"] . '" width="10%">

											</li>
											
												<li><a href="' . $url . 'perfil">Ver Perfil</a></li>
												
												<li><a href="' . $url . 'salir">Salir</a></li>';
										}
									}
								} else {

									echo '<li><a href="#modalIngreso" data-toggle="modal">Ingresar</a></li>
									
									<li><a href="#modalRegistro" data-toggle="modal">Crear una cuenta</a></li>';
								}

								?>
							</ul>
						</li>
					</div>
				</div>
			</div>


		</div>

	</nav>


</header>

<!--=====================================
VENTANA MODAL PARA EL REGISTRO
======================================-->

<div class="modal fade modalFormulario" id="modalRegistro" role="dialog">

	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="backColor">REGISTRARSE</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<!--=====================================
			REGISTRO FACEBOOK
			======================================-->

			<div class="col-sm-6 col-xs-12 facebook">

				<p>
					<i class="fa fa-facebook"></i>
					Registro con Facebook
				</p>

			</div>

			<!--=====================================
			REGISTRO GOOGLE
			======================================-->
			<a href="<?php echo $rutaGoogle; ?>">

				<div class="col-sm-6 col-xs-12 google">

					<p>
						<i class="fa fa-google"></i>
						Registro con Google
					</p>

				</div>
			</a>

			<!--=====================================
			REGISTRO DIRECTO
			======================================-->

			<form method="post" onsubmit="return registroUsuario()">

				<hr>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-user"></i>

						</span>

						<input type="text" class="form-control text-uppercase" id="regUsuario" name="regUsuario" placeholder="Nombre Completo" required>

					</div>

				</div>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-envelope"></i>

						</span>

						<input type="email" class="form-control" id="regEmail" name="regEmail" placeholder="Correo Electrónico" required>

					</div>

				</div>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-lock"></i>

						</span>

						<input type="password" class="form-control" id="regPassword" name="regPassword" placeholder="Contraseña" required>

					</div>

				</div>

				<!--=====================================
				https://www.iubenda.com/ CONDICIONES DE USO Y POLÍTICAS DE PRIVACIDAD
				======================================-->

				<div class="checkBox">

					<label>

						<input id="regPoliticas" type="checkbox">

						<small>

							Al registrarse, usted acepta nuestras condiciones de uso y políticas de privacidad

							<br>

							<a href="https://www.iubenda.com/privacy-policy/26778001" class="iubenda-white iubenda-noiframe iubenda-embed iubenda-noiframe " title="Política de Privacidad ">Política de Privacidad</a>
							<script type="text/javascript">
								(function(w, d) {
									var loader = function() {
										var s = d.createElement("script"),
											tag = d.getElementsByTagName("script")[0];
										s.src = "https://cdn.iubenda.com/iubenda.js";
										tag.parentNode.insertBefore(s, tag);
									};
									if (w.addEventListener) {
										w.addEventListener("load", loader, false);
									} else if (w.attachEvent) {
										w.attachEvent("onload", loader);
									} else {
										w.onload = loader;
									}
								})(window, document);
							</script>
						</small>

					</label>

				</div>

				<?php

				$registro = new ControladorUsuarios();
				$registro->ctrRegistroUsuario();

				?>

				<input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">

			</form>

		</div>

		<div class="modal-footer">

			¿Ya tienes una cuenta registrada? | <strong><a href="#modalIngreso" data-dismiss="modal" data-toggle="modal">Ingresar</a></strong>

		</div>

	</div>

</div>

<!--=====================================
VENTANA MODAL PARA EL INGRESO
======================================-->

<div class="modal fade modalFormulario" id="modalIngreso" role="dialog">

	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="backColor">INGRESAR</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<!--=====================================
			INGRESO FACEBOOK
			======================================-->

			<div class="col-sm-6 col-xs-12 facebook">

				<p>
					<i class="fa fa-facebook"></i>
					Ingreso con Facebook
				</p>

			</div>

			<!--=====================================
			INGRESO GOOGLE
			======================================-->
			<a href="<?php echo $rutaGoogle; ?>">

				<div class="col-sm-6 col-xs-12 google">

					<p>
						<i class="fa fa-google"></i>
						Ingreso con Google
					</p>

				</div>

			</a>

			<!--=====================================
			INGRESO DIRECTO
			======================================-->

			<form method="post">

				<hr>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-envelope"></i>

						</span>

						<input type="email" class="form-control" id="ingEmail" name="ingEmail" placeholder="Correo Electrónico" required>

					</div>

				</div>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-lock"></i>

						</span>

						<input type="password" class="form-control" id="ingPassword" name="ingPassword" placeholder="Contraseña" required>

					</div>

				</div>



				<?php

				$ingreso = new ControladorUsuarios();
				$ingreso->ctrIngresoUsuario();

				?>

				<input type="submit" class="btn btn-default backColor btn-block btnIngreso" value="ENVIAR">

				<br>

				<center>

					<a href="#modalPassword" data-dismiss="modal" data-toggle="modal">¿Olvidaste tu contraseña?</a>

				</center>

			</form>

		</div>

		<div class="modal-footer">

			¿No tienes una cuenta registrada? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Registrarse</a></strong>

		</div>

	</div>

</div>


<!--=====================================
VENTANA MODAL PARA OLVIDO DE CONTRASEÑA
======================================-->

<div class="modal fade modalFormulario" id="modalPassword" role="dialog">

	<div class="modal-content modal-dialog">

		<div class="modal-body modalTitulo">

			<h3 class="backColor">SOLICITUD DE NUEVA CONTRASEÑA</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<!--=====================================
			OLVIDO CONTRASEÑA
			======================================-->

			<form method="post">

				<label class="text-muted">Escribe el correo electrónico con el que estás registrado y allí te enviaremos una nueva contraseña:</label>

				<div class="form-group">

					<div class="input-group">

						<span class="input-group-addon">

							<i class="glyphicon glyphicon-envelope"></i>

						</span>

						<input type="email" class="form-control" id="passEmail" name="passEmail" placeholder="Correo Electrónico" required>

					</div>

				</div>

				<?php

				$password = new ControladorUsuarios();
				$password->ctrOlvidoPassword();

				?>

				<input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">

			</form>

		</div>

		<div class="modal-footer">

			¿No tienes una cuenta registrada? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Registrarse</a></strong>

		</div>

	</div>

</div>

<header class="site-header navbar-sticky">
	

	<!-- Menu normal  -->

	<!-- Navbar-->
	<div class="navbar">
		<div class="btn-group categories-btn">
			<button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="icon-menu text-lg"></i>&nbsp;Categorías</button>
			<div class="dropdown-menu mega-dropdown">
				<div class="row">
					<div class="col-sm-3">
						<a class="d-block navi-link text-center mb-30" href="../Productos/categorias.php?id_ct=A10&amp;nom=solucion-hibrida">
							<img class="d-block" src="../../public/images/img_spl/categorias/41.png">
							<span class="text-gray-dark">Solución Híbrida</span>
						</a>
					</div>
					<div class="col-sm-3">
						<a class="d-block navi-link text-center mb-30" href="../Productos/categorias.php?id_ct=A5&amp;nom=sistema-de-cobre">
							<img class="d-block" src="../../public/images/img_spl/categorias/36.png">
							<span class="text-gray-dark">Sistema De Cobre</span>
						</a>
					</div>
					<div class="col-sm-3">
						<a class="d-block navi-link text-center mb-30" href="../Productos/categorias.php?id_ct=A2&amp;nom=sistema-de-fibra-optica">
							<img class="d-block" src="../../public/images/img_spl/categorias/33.png">
							<span class="text-gray-dark">Sistema De Fibra Óptica</span>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<a class="d-block navi-link text-center mb-30" href="../Productos/categorias.php?id_ct=A3&amp;nom=organizacion-de-redes">
							<img class="d-block" src="../../public/images/img_spl/categorias/34.png">
							<span class="text-gray-dark">Organización De Redes</span>
						</a>
					</div>
					<div class="col-sm-3">
						<a class="d-block navi-link text-center mb-30" href="../Productos/categorias.php?id_ct=A4&amp;nom=equipo-activo">
							<img class="d-block" src="../../public/images/img_spl/categorias/35.png">
							<span class="text-gray-dark">Equipo Activo</span>
						</a>
					</div>
					<div class="col-sm-3">
						<a class="d-block navi-link text-center mb-30" href="../Productos/categorias.php?id_ct=A9&amp;nom=fib2u">
							<img class="d-block" src="../../public/images/img_spl/categorias/40.png">
							<span class="text-gray-dark">FIB2U</span>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<a class="d-block navi-link text-center mb-30" href="../Productos/categorias.php?id_ct=A1&amp;nom=planta-externa">
							<img class="d-block" src="../../public/images/img_spl/categorias/32.png">
							<span class="text-gray-dark">Planta Externa</span>
						</a>
					</div>
					<div class="col-sm-3">
						<a class="d-block navi-link text-center mb-30" href="../Productos/categorias.php?id_ct=A11&amp;nom=redsenciales">
							<img class="d-block" src="../../public/images/img_spl/categorias/42.png">
							<span class="text-gray-dark">Redsenciales</span>
						</a>
					</div>
				</div>

			</div>
		</div>
		<nav class="site-menu">
			<ul>
				<li class="has-submenu active">
					<a href="../Home/">Home </a>
				</li>
				<li class="has-submenu ">
					<a href="../Nosotros/">Nosotros</a>
				</li>
				<li class="has-megamenu">
					<a href="#">Productos</a>
					<ul class="mega-menu">
						<li><span class="mega-menu-title">Categorías</span>
							<ul class="sub-menu">
								<li>
									<a class="d-inline-block m-1" href="../Productos/categorias.php?id_ct=A10&amp;nom=solucion-hibrida">
										<img style="width: 12%; height: 12%;" class="d-inline-block" src="../../public/images/img_spl/categorias/41.png">
										Solución Híbrida </a>
								</li>
								<li>
									<a class="d-inline-block m-1" href="../Productos/categorias.php?id_ct=A5&amp;nom=sistema-de-cobre">
										<img style="width: 12%; height: 12%;" class="d-inline-block" src="../../public/images/img_spl/categorias/36.png">
										Sistema De Cobre </a>
								</li>
								<li>
									<a class="d-inline-block m-1" href="../Productos/categorias.php?id_ct=A2&amp;nom=sistema-de-fibra-optica">
										<img style="width: 12%; height: 12%;" class="d-inline-block" src="../../public/images/img_spl/categorias/33.png">
										Sistema De Fibra Óptica </a>
								</li>
								<li>
									<a class="d-inline-block m-1" href="../Productos/categorias.php?id_ct=A3&amp;nom=organizacion-de-redes">
										<img style="width: 12%; height: 12%;" class="d-inline-block" src="../../public/images/img_spl/categorias/34.png">
										Organización De Redes </a>
								</li>
								<li>
									<a class="d-inline-block m-1" href="../Productos/categorias.php?id_ct=A4&amp;nom=equipo-activo">
										<img style="width: 12%; height: 12%;" class="d-inline-block" src="../../public/images/img_spl/categorias/35.png">
										Equipo Activo </a>
								</li>
								<li>
									<a class="d-inline-block m-1" href="../Productos/categorias.php?id_ct=A9&amp;nom=fib2u">
										<img style="width: 12%; height: 12%;" class="d-inline-block" src="../../public/images/img_spl/categorias/40.png">
										FIB2U </a>
								</li>
								<li>
									<a class="d-inline-block m-1" href="../Productos/categorias.php?id_ct=A1&amp;nom=planta-externa">
										<img style="width: 12%; height: 12%;" class="d-inline-block" src="../../public/images/img_spl/categorias/32.png">
										Planta Externa </a>
								</li>
								<li>
									<a class="d-inline-block m-1" href="../Productos/categorias.php?id_ct=A11&amp;nom=redsenciales">
										<img style="width: 12%; height: 12%;" class="d-inline-block" src="../../public/images/img_spl/categorias/42.png">
										Redsenciales </a>
								</li>
							</ul>
						</li>
						<li><span class="mega-menu-title">Top Subcategorías</span>
							<ul class="sub-menu">
								<li>
									<a href="../Productos/categorias.php?id_sbct=62&amp;nom=microducto">
										Microducto </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=18&amp;nom=acopladores-monomodo-multimodo">
										Acopladores monomodo - multimodo </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=24&amp;nom=equipos-de-medicion-planta-interna">
										Equipos de medición planta interna </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=12&amp;nom=cables-preconectorizados">
										Cables preconectorizados </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=25&amp;nom=herramientas-sistema-de-fibra">
										Herramientas sistema de fibra </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=66&amp;nom=distribuidores">
										Distribuidores </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=21&amp;nom=atenuadores-monomodo">
										Atenuadores monomodo </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=1&amp;nom=patch-panel-multimedios">
										Patch panel multimedios </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=72&amp;nom=organizacion-de-redes">
										Organización de redes </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=51&amp;nom=ont">
										ONT </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=68&amp;nom=corte-y-desforre-planta-externa">
										Corte y desforre planta externa </a>
								</li>
								<li>
									<a href="../Productos/categorias.php?id_sbct=61&amp;nom=tritubo">
										Tritubo </a>
								</li>
							</ul>
						</li>
						<li>
							<span class="mega-menu-title">Ubicación</span>
							<div class="card mb-3">
								<div class="card-body">
									<ul class="list-icon">
										<li>
											<i class="icon-map-pin text-muted"></i>Parque Tecnológico Innovación Querétaro, Lateral de la carretera Estatal 431, km.2+200, Int.28, C.P.76246
										</li>
										<li>
											<i class="icon-phone text-muted"></i>800 134 26 90
										</li>
										<li class="mb-0">
											<i class="icon-mail text-muted"></i>
											<a class="navi-link" href="mailto: ventas@fibremex.com.mx">
												ventas@fibremex.com.mx </a>
										</li>
										<li>
											<i class="icon-clock text-muted"></i>Lunes-Viernes: 8:00 am - 8:00 pm<br>A partir del 19 de febrero tendremos horario sabatino de 9:00 am - 5:00 pm
										</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<a class="card border-0 bg-secondary rounded-0" href="../Catalogo/">
								<img class="d-block mx-auto" alt="Catalogo" src="../../public/images/img_spl/adicionales/descarga_catalogo.jpg"></a>
						</li>
					</ul>
				</li>
				<li class="has-submenu ">
					<a href="../Soluciones/">Soluciones</a>
				</li>
				
				<li class="has-megamenu">
					<a href="#">Capacitaciones</a>
					<ul class="mega-menu">
						<li><span class="mega-menu-title">FINTEC</span>
							<ul class="sub-menu">
								<li>
									<a class="d-inline-block" href="../Capacitaciones/1-fintec">
										<img style="width: 15%; height: 15%;" class="d-inline-block" src="../../public/images/img_spl/capacitaciones/1.jpg">
										¿Qué es Fintec?
									</a>
								</li>
								<!--
              
              -->
								<li>
									<a class="d-inline-block m-1" href="../Capacitaciones/1-fintec">
										<img class="d-inline-block" src="../../public/images/img_spl/capacitaciones/logo-fintec.jpg">

									</a>
								</li>
							</ul>
						</li>
						<li><span class="mega-menu-title">INSIDER</span>
							<ul class="sub-menu">
								<li>
									<a href="../Capacitaciones/2-insider">
										¿Qué es Insider?
									</a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Capacitaciones/2-Insider#I1">
										Implementación de redes subterráneas de fibra óptica </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Capacitaciones/2-Insider#I2">
										Planificación de la instalación aérea </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Capacitaciones/2-Insider#I3">
										De la planificación a la conectividad en Data Center </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Capacitaciones/2-Insider#I4">
										Desafíos del cableado estructurado con sistema de cobre </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Capacitaciones/2-Insider#I5">
										Tendencias en el futuro de la transmisión, Redes Ópticas Pasivas </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Capacitaciones/2-Insider#I6">
										El tramo final es esencial, última milla </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Capacitaciones/2-Insider#I7">
										Equipos de medición y fusión para construir y operar enlaces de fibra óptica </a>
								</li>
							</ul>
						</li>
						<li>
							<span class="mega-menu-title">DEVELOP</span>
							<ul class="sub-menu">
								<li>
									<a href="../Capacitaciones/3-develop">
										¿Qué es Develop?
									</a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Cursos/1-curso-de-planta-externa">
										Curso de Planta Externa </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Cursos/2-curso-de-planta-interna">
										Curso de Planta Interna </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Cursos/3-curso-fib2u-fibra-hasta-el-usuario">
										Curso FIB2U (Fibra hasta el Usuario) </a>
								</li>
								<li>
									<a class="text-decoration-none" href="../Cursos/4-soplado-de-fibra-optica">
										Soplado de fibra óptica </a>
								</li>

							</ul>
						</li>
						<li>
							<span class="mega-menu-title">CERTIFICACIÓN OPTRONICS</span>
							<ul class="sub-menu">
								<li>
									<a href="../Capacitaciones/4-partners">
										¿Qué es?
									</a>
								</li>
								<li>
									<a href="../Capacitaciones/4-partners#banner2">
										Proceso para certificar una red
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="has-submenu "><a href="#">Biblioteca Técnica</a>
					<ul class="sub-menu">
						<li><a href="../Biblioteca/catalogo-telecomunicaciones-fibra-optica.php">Catálogo</a></li>
						<li><a href="../Biblioteca/videos-tutoriales-fibra-optica.php">Videos</a></li>
						<li><a href="../Biblioteca/infografias-fibra-optica.php">Infografías</a></li>
						<li><a href="../Biblioteca/glosario-fibra-optica.php?r=A-E">Glosarío</a></li>
						<li><a href="../Biblioteca/informacion-tecnica-fibra-optica.php?id=A1">Info. Técnica</a></li>
						<li><a href="../Biblioteca/fichas-tecnicas-fibra-optica.php?id=A1">Hojas Técnicas</a></li>
						<li><a href="../Consultecnico">Consultécnico</a></li>
						<!-- <li><a href="../Biblioteca/cursos.php">Cursos</a></li> -->
					</ul>
				</li>
				<li class="has-submenu "><a href="../Blog/index.php?pag=1">Blog </a></li>

				<li class="has-submenu"><a href="#">Contacto</a>
					<ul class="sub-menu">
						<li><a href="../Login/solicitud.php">Pre-registro para empresas</a></li>
						<li><a href="../Login/registro.php">Darme de alta como cliente</a></li>
						<li><a href="../Contacto">Dirección y teléfono</a></li>
					</ul>
				</li>

				<!--
        <li class="has-submenu "><a href="../Catalogo/">Cat&aacute;logo</a></li>
        -->
			</ul>
		</nav>
		<!-- Toolbar ( Put toolbar here only if you enable sticky navbar )-->
		<div class="toolbar">
			<div class="toolbar-inner">
				<div class="toolbar-item"><a href="javascript:void(0);">
						<div><span class="text-label "><strong>TIPO DE CAMBIO</strong><br>1 USD = 20.6675 MXP</span></div>
					</a></div>
				<div class="toolbar-item" id="ListResumenProductosCarritoMovil">

					<a href="../Carrito/">
						<div>
							<span class="cart-icon"><i class="icon-shopping-cart"></i><span class="count-label"> 0 </span></span><span class="text-label">Carrito</span>
						</div>
					</a>
					<div class="toolbar-dropdown cart-dropdown widget-cart hidden-on-mobile tamano_carrito_resumen">
						<div class="text-right">
							<p class="text-gray-dark py-2 mb-0"><span class="text-muted">Subtotal:</span> &nbsp;0</p>
						</div>
						<div class="d-flex">
							<div class="pr-2 w-50"><a class="btn btn-secondary btn-sm btn-block mb-0" href="../Carrito/">Ir al carrito</a></div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</header>