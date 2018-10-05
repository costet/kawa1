@extends("tema.master")
@section('tittle')
	<title>Pre Afiliación</title>
@stop
@section("titulo")
	<h1 class="h2">Pre Afiliación</h1>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@stop
@section("contenido")
	<div class="">
		<form class="form-inline" action="{{ URL::asset('curp') }}" method="post">			  
		  	<div class="form-group mx-sm-3 mb-2">
			    <input type="text" class="form-control" id="" placeholder="Ingresa el curp" name="curp">
		 	</div>
		  	<button type="submit" class="btn btn-outline-danger mb-2">Validar Curp</button>
		</form>

		@if (Session::get("Mensaje"))
			<div class="row">
				<div class="col-sm-4 col-md-4">
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  	{{ Session::get("Mensaje") }}
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
				</div>				
			</div>
		@else
			@if (Session::get("datos"))
				<form id="form_datos">
					<div class="form-row">
						<div class="form-group col-md-12">
				  			<h4>Datos personales</h4>
				  		</div>
						<div class="form-group col-md-4">
					    	<label for="">Curp</label>
					    	<input type="text" class="form-control" id="" placeholder="Curp" readonly="" name="curp" value="{{ Session::get("datos")['curp'] }}">
					  	</div>

					  	<div class="form-group col-md-4">
					      	<label for="">RFC</label>
					      	<input type="text" class="form-control" id="rfc" placeholder="RFC" name="rfc" >
					      	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
					    </div>
					    <div class="form-group col-md-4">
					      	<label for="">Confirmación rfc</label>
					      	<input type="text" class="form-control" onpaste="return false" id="divcon" placeholder="Confirmación rfc" name="con_rfc" onkeyup="validarrfc(this.value)">
					      	<div class="invalid-feedback">
						       	El campo es requerido o No coincide el rfc !
					      	</div>

					    </div>
					    
					</div>
				  	<div class="form-row">
				    	<div class="form-group col-md-4">
					      	<label for="">Nombre</label>
					      	<input type="text" class="form-control" id="" placeholder="Nombre" name="nombre" value="{{ Session::get("datos")['nombre'] }}" readonly="">
				    	</div>
					    <div class="form-group col-md-4">
					      	<label for="">Apellido Paterno</label>
					      	<input type="text" class="form-control" id="" placeholder="Apellido Paterno" name="paterno" value="{{ Session::get("datos")['paterno'] }}" readonly="" >
					    </div>
					    <div class="form-group col-md-4">
					      	<label for="">Apellido Materno</label>
					      	<input type="text" class="form-control" id="" placeholder="Apellido Materno" name="materno" value="{{ Session::get("datos")['materno'] }}" readonly="">
					    </div>
				  	</div>
				  	<div class="form-row">
						<div class="form-group col-md-2">
					    	<label for="">Código Postal</label>
					    	<input type="number" class="form-control" id="tags" placeholder="Código Postal" name="cp" onkeyup="buscar(this.value)" >
					    	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
					  	</div>
					  	<div class="form-group col-md-2">
					      	<label for="">Municipio</label>
					      	<input type="text" class="form-control" id="muni" readonly="" placeholder="Municipio" name="muni" >
					    </div>
					  	<div class="form-group col-md-4">
					      	<label for="">Colonia</label>
					      	{{-- <input type="text" class="form-control" id="colonia" placeholder="Colonia" name="col" > --}}
					      	<div id="cl">
					      		<select class="custom-select " name="col" id="colonia">							  
								</select>
					      	</div>
					      	
					    </div>
					    <div class="form-group col-md-4">
					      	<label for="">Calle y número</label>
					      	<input type="text" class="form-control" placeholder="Calle" name="calle" id="calle">
					      	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
					    </div>
					    
					</div>
				  	<div class="form-row">
				  		<div class="form-group col-md-12">
				  			<h4>Tipo de registro</h4>
				  		</div>
				    	<div class="form-group col-md-5 ">
				      		<div class="custom-control custom-radio custom-control-inline">
							  	<input type="radio" id="customRadioInline1" value="1" name="tipo" class="tipo custom-control-input" onclick="mostrar(1)">
							  	<label class="custom-control-label" for="customRadioInline1">Docente</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
							  	<input type="radio" id="customRadioInline2" value="2" name="tipo" class="tipo custom-control-input" onclick="mostrar(2)">
							  	<label class="custom-control-label" for="customRadioInline2">Administrativo</label>
							</div>
				    	</div>
				  	</div>

				  	<div class="form-row">
				  		<div class="form-group col-md-12">
				  			<h4>Archivos Digitales</h4>
				  		</div>
				  		<div class="form-group col-md-6">
				  			<label for="">CURP</label>
					      	<input type="file" class="form-control" name="doc_curp" id="doc_curp">
					      	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>			    	
				  		</div>
				  		<div class="form-group col-md-6">
				  			<label for="">RFC</label>
					    	<input type="file" class="form-control" name="doc_rfc" id="doc_rfc">
					    	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
				  		</div>
				  		<div class="form-group col-md-6">
				  			<label for="">ACTA DE NACIMIENTO</label>
					    	<input type="file" class="form-control" name="doc_acta" id="doc_acta">
					    	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
				  		</div>
				  		<div class="form-group col-md-6">
				  			<label for="">INE</label>
					    	<input type="file" class="form-control" name="doc_ine" id="doc_ine" >
					    	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
				  		</div>
				  	</div>
				  	<div class="form-row" id="most" >		  					  		
				  		
				  	</div>
				  	<div class="form-row" id="titu" >		  					  		
				  		
				  	</div>
				  	<div class="form-row" id="titu2" >		  					  		
				  		
				  	</div>
				  	<div class="form-row" id="titu3" >		  					  		
				  		
				  	</div>
				  	<button type="button" onclick="registrar()" class="btn btn-outline-danger">Pre Afiliar</button>
				</form>
			@endif

		@endif

		

		
	</div>
@stop
@section("java")
	@parent
	{{HTML::script("bootstrap/dist/js/jquery.min.js", array("type" => "text/javascript"))}}
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript">
		// $( function() {
		// 	$.get("{{URL::to('/codigos')}}", function(data) {
		//     	$( "#tags" ).autocomplete({
		//       		source: data
		//     	});
		// 	},'json');
		// });

		function validarfile(nombre){
			valor = $("#"+nombre).val();
			// console.log(nombre+'-'+valor);
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor == '' ) {
				$("#"+nombre).attr('class','form-control is-invalid');
				// $("#"+nombre).parent().attr("class", "form-group has-error has-feedback");
				return 0;
            }else{
            	$("#"+nombre).attr('class','form-control is-valid');
            	return 1;
            }
		}

		function validarSelect(nombre){
			valor = $("#"+nombre).val();
			if( valor == '0' ) {
				$("#"+nombre).attr('class','form-control is-invalid');
				// $("#"+nombre).parent().attr("class", "form-group has-error has-feedback");
				return 0;
            }else{
            	$("#"+nombre).attr('class','form-control is-valid');
            	return 1;
            }
		}

		function validarChe(){
			if ($('input:radio[name=tipo]:checked').prop('checked') ) {
				$(".tipo").attr('class','tipo custom-control-input');
				return 1;
				// console.log("Checkbox seleccionado");
			}else{
				$(".tipo").attr('class','tipo custom-control-input is-invalid');
				return 0;
				// console.log("Checkbox no  seleccionado");
			}
		}

		function registrar(){

			var curp = validarfile('doc_curp');
			var ine = validarfile('doc_ine');
			var rfc_doc = validarfile('doc_rfc');
			var acta = validarfile('doc_acta');
			var rfc = validarfile('rfc');
			var calle = validarfile('calle');
			var cp = validarfile('tags');
			var divcon = validarfile('divcon');
			var col = validarSelect('colonia');
			var rfc2= validarrfc2();
			var check= validarChe();
			var pas= validarSelect('titulado');
			var tipo_per = $('input:radio[name=tipo]:checked').val();
			var tipo_per2;
			// console.log(tipo_per);
			if(tipo_per== 1){
				tipo_per2 = 1 ;
			}else{
				tipo_per2 = validarSelect('ultimo_grado');
				// console.log('hola');
			}

			if(curp == 0 || ine == 0 || rfc_doc==0 || acta == 0 || calle == 0 || rfc==0 || cp == 0 || divcon == 0 || col== 0 || check==0 || rfc2 == 0 || pas==0 || tipo_per2==0 ){

				swal ( "Alerta !" ,  "Es necesario todos los campos para realizar el registro" ,  "error" );
			}
			else{
				swal({
					  title: "¿Seguro de Registrar?",
					  text: "REGISTRO!",
					  type: "warning",
					  showCancelButton: true,
					  closeOnConfirm: false,
					  confirmButtonColor: "#DD6B55",
		              confirmButtonText: "Si, registrar!",
		              cancelButtonText: "No, cancelar!",
					  showLoaderOnConfirm: true
					}, function () {
					  	setTimeout(function () {
						    var formData = new FormData(document.getElementById("form_datos"));
			              		$.ajax({
					                 type: 'post',   
					                 cache: false,
					                 url:'{{ URL::asset("/registrar") }}' ,    
					                 data: formData,
					                 contentType:false,
					                 processData: false,
					                 dataType: "json",
					                 success: 
					                    function(data) 
					                    {
					                    	if(data.tipo == 1 ){
					                    		swal({   title: "Registro Exitoso",   text: data.mensaje, type:"success" },
													function(){   
														window.location.href = '{{ URL::asset('/pre_afiliacion') }}';
													}
												);
					                    	}else{
					                    		swal({   title: "Error",   text: data.mensaje, type:"error" });
					                    	}
					                    	
				                    		
					                    }
					             });
					  	}, 1000);
					});
			}
			
		}

		function validarrfc(valor) {
			var rfc = $("#rfc").val();
			if(rfc.toUpperCase() != valor.toUpperCase()){
				$('#divcon').attr('class','form-control is-invalid');
				
			}else{
				$('#divcon').attr('class','form-control is-valid');
				$('#rfc').attr('class','form-control is-valid');
			}
			
		}

		function validarrfc2() {
			var rfc = $("#rfc").val();
			var rfc2 = $("#divcon").val();
			if(rfc.toUpperCase() != rfc2.toUpperCase()){
				$('#divcon').attr('class','form-control is-invalid');
				return 0;
				
			}else{
				$('#divcon').attr('class','form-control is-valid');
				$('#rfc').attr('class','form-control is-valid');
				return 1;
			}
			
		}

		function mostrar(id){
			document.getElementById("most").innerHTML =" ";
			document.getElementById("titu").innerHTML =" ";
			document.getElementById("titu2").innerHTML =" ";
			if(id==1){
				
				$("#most").append("<div class='form-group col-md-6'>"+
										"<label for=''>¿Pasante o Titulado?</label>"+
										"<select class='custom-select' name='titulado' id='titulado' onchange='mostrarDocente(this.value)'>"+
									  		"<option value='0' selected>Seleccione una opción</option>"+
									  		"<option value='1'>Pasante</option>"+
									  		"<option value='2'>Titulado</option>"+
									  	"</select>"+
								  	"</div>");
				
			}else{
				$("#most").append("<div class='form-group col-md-6'>"+
										"<label for=''>Último Grado de Estudios</label>"+
										"<select class='custom-select' name='ultimo_grado' id='ultimo_grado' onchange='mostrarAdmin(this.value)'>"+
									  		"<option value='0' selected>Seleccione una opción</option>"+
									  		"<option value='1'>EDUCACIÓN PRIMARIA</option>"+
									  		"<option value='2'>EDUCACIÓN SECUNDARIA</option>"+
									  		"<option value='3'>EDUCACIÓN MEDIA SUPERIOR</option>"+
									  		"<option value='4'>EDUCACIÓN SUPERIOR</option>"+
									  		"<option value='5'>MAESTRÍA</option>"+
									  		"<option value='6'>DOCTORADO</option>"+
									  	"</select>"+
								  	"</div>"); 
			}
			
		}

		function mosto(id){
			document.getElementById("titu3").innerHTML =" ";
			if(id==1){
				$("#titu3").append("<div class='form-group col-md-6'>"+
						  			"<label for=''>Carta Pasante</label>"+
							    	"<input type='file' class='form-control' name='doc_carta_pas' >"+
						  		"</div>");
			}else{
				$("#titu3").append(" <div class='form-group col-md-6'>"+
										"<label for=''>Cedula</label>"+
								    	"<input type='file' class='form-control' name='doc_cedula' >"+
				  					"</div>"+
				  					"<div class='form-group col-md-6'>"+
										"<label for=''>Titulo</label>"+
								    	"<input type='file' class='form-control' name='doc_titulo' >"+
				  					"</div>"+
				  					"<div class='form-group col-md-6'>"+
										"<label for=''>Certificado</label>"+
								    	"<input type='file' class='form-control' name='doc_certificado' >"+
				  					"</div>");
			}
		}

		function mostrarDocente(id){
			document.getElementById("titu").innerHTML =" ";
			if(id==1){
				$("#titu").append("<div class='form-group col-md-6'>"+
						  			"<label for=''>Carta Pasante</label>"+
							    	"<input type='file' class='form-control' name='doc_carta_pas' >"+
						  		"</div>");
			}else{
				$("#titu").append(" <div class='form-group col-md-6'>"+
										"<label for=''>Cedula</label>"+
								    	"<input type='file' class='form-control' name='doc_cedula' >"+
				  					"</div>"+
				  					"<div class='form-group col-md-6'>"+
										"<label for=''>Titulo</label>"+
								    	"<input type='file' class='form-control' name='doc_titulo' >"+
				  					"</div>"+
				  					"<div class='form-group col-md-6'>"+
										"<label for=''>Certificado</label>"+
								    	"<input type='file' class='form-control' name='doc_certificado' >"+
				  					"</div>");
			}
			// console.log(id);
		}
		function mostrarAdmin(id){
			// document.getElementById("most").innerHTML =" ";
			document.getElementById("titu2").innerHTML =" ";
			if(id >= 1 && id <= 3){
				$("#titu2").append("<div class='form-group col-md-6'>"+
						  			"<label for=''>Certificado</label>"+
							    	"<input type='file' class='form-control' name='doc_carta_pas' >"+
						  		"</div>");
			}
			if(id >= 4 && id <= 6){
				$("#titu2").append("<div class='form-group col-md-6'>"+
										"<label for=''>¿Pasante o Titulado?</label>"+
										"<select class='custom-select' name='titulado' id='titulado' onchange='mosto(this.value)'>"+
									  		"<option value='0' selected>Seleccione una opción</option>"+
									  		"<option value='1'>Pasante</option>"+
									  		"<option value='2'>Titulado</option>"+
									  	"</select>"+
								  	"</div>");
			}
		}

		function buscar(valor){
			// console.log(valor.length);
			if(valor.length == 5){
				document.getElementById("cl").innerHTML =" ";
				$("#muni").val('');
	      		// $("#imgTipo").show();
	      		$.get("{{ URL::asset('ajax_asentamiento') }}", {cp: valor}, function(data) {
	      			// console.log(data);
					// $("#imgTipo").hide();
					$("#muni").val(data.muni);
					$("#cl").append("<select class='custom-select' name='col'  id='colonia'><option readonly value='0' selected  >Seleccione una colonia</option>"+data.tipos+"</select><div class='invalid-feedback'>Campo necesario !</div>");
				});
			}
	  //   	
		}
	</script>
@stop

