<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		@section("tittle")
			<title>Plantilla maestra</title>
		@show

		@section("css")
			{{HTML::style("bootstrap/dist/css/bootstrap.min.css", array("type" => "text/css"))}}
			{{HTML::style("bootstrap/dist/css/sweetalert.css", array("type" => "text/css"))}}
			{{HTML::style("dist/css/lightbox.css", array("type" => "text/css"))}}
    		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    		<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">


    		<style type="text/css">
    			#piedepagina{
					width:800px; <!--Esto es referencial de mi pagina ;) -->
					position: absolute;
					bottom: 0 !important;
					bottom: -1px;
				}
				body{
					background-color: #f2f2f2;

				}
				.card{
					background-color: rgba(000,000,000,0.7);
					/*height: 100%;*/
					/*opacity: rgba (000,000,000, .5);*/
				}
				html 
				{
			        height:100%;
			        width:100%;
			    }
			    body{
			    	padding-top: 65px;
			    	background-color: #330000;
		        	/*background:#8ba987 url({{ URL::asset('img/fondo2.jpg')  }}) no-repeat center center;*/
			        /*background-size:100% 100%;*/
		    	}
    		</style>
		@show
		@section("encabezado")
			@if (Session::get('login') == true)
	  			 @include('tema.menu')
	  		@endif
		@show
	</head>
	<body>
		
		<div class="container-fluid">		
			@section("contenido")  	
			@show
		</div>
		@section("pie_pagina")
			<br><br><br><br>
			<center>
				
			</center>
			
		@show

		@section("java")
			{{HTML::script("bootstrap/assets/js/vendor/popper.min.js", array("type" => "text/javascript"))}}
			{{HTML::script("bootstrap/dist/js/jquery.min.js", array("type" => "text/javascript"))}}
			{{HTML::script("bootstrap/dist/js/bootstrap.min.js", array("type" => "text/javascript"))}}
			{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
		    <script>window.jQuery || document.write('<script src="bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
		   	<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
		    <script>
		      feather.replace()
		    </script>
		    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>		     --}}
		    {{HTML::script("bootstrap/dist/js/sweetalert.min.js", array("type" => "text/javascript"))}}
		    {{HTML::script("dist/js/lightbox.js", array("type" => "text/javascript"))}}			
		    {{HTML::script("//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", array("type" => "text/javascript"))}}			
		@show
	</body>
</html>