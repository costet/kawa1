@extends("tema.master")
@section("tittle")
	<title>Inicio</title>
@stop
<style type="text/css">
	label{
		color: #fff;
	}
</style>
@section("titulo")
@stop
@section("contenido")


<div class="card">
  <div class="card-body">
   <form id="form_datos">
   		<div class="container">
   			<div class="row">
   				<div class="col-md-6 col-sm-6">
   					<div class="form-row">
   						<div class="form-group col-md-12">
					      	<label for="">* País</label>
					      	@if (count($pais) > 1)
					      		<select class="custom-select " name="pais" id="pais" onchange="buscarMercado(this.value)">	
					      			<option value="0">Selecciones un país</option>
					      			@foreach ($pais as $paises)
									  	<option value="{{ $paises->id }}">{{ $paises->pais }}</option>
								  	@endforeach						  
								</select>
								<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
						 	@else
						 		<input type="text" class="form-control" readonly=""  placeholder="" name="pais2" value="{{ $pais[0]->pais }}">
						 		<input type="hidden" id="pais" name="pais" value="{{ $pais[0]->id }}">
					      	@endif
					      	
				      		
					    </div>	
						@if ( Permisos::permiso(Session::get('id_usuario') , 1 ) )
							<div class="form-group col-md-12">
						      	<label for="">Código Cliente</label>
						      	<input type="text" class="form-control" id="cod_cliente" placeholder="Código Cliente" name="cod_cliente" >
						      	<div class="invalid-feedback">
							       	Campo necesario !
						      	</div>
						    </div>
						@endif
					  	<div class="form-group col-md-12">
					      	<label for="">* Razon social / nombre del cliente</label>
					      	<input type="text" class="form-control" id="razon" placeholder="Razon social / nombre del cliente" name="razon" >
					      	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
					    </div>
					    <div class="form-group col-md-12">
					      	<label for="">* Nombre comerciaL</label>
					      	<input type="text" class="form-control" id="nom_comercial" placeholder="Nombre comercial" name="nom_comercial" onkeyup="">
					      	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
					    </div>
					    <div class="form-group col-md-12">
					      	<label for="">* Sucursal o planta del cliente</label>
					      	<input type="text" class="form-control" id="sucursal" placeholder="Sucursal o planta del cliente" name="sucursal" onkeyup="">
					      	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
					    </div>
					</div>
					<div class="form-row">
					  	
					    <div class="form-group col-md-4">
					      	<label for="">* Mercado</label>
					      	@if (count($pais) > 1)
					      		<br>
					      		<img src="{{ URL::asset('img/loading.gif') }}" id='img_mercado' class="img-responsive" width="40px" style="display: none;">
					      		<div id="mercado">
						      		<select class="custom-select " name="mer" id="mer" onchange="buscarSegmento(this.value)">	
						      			<option value="0">Selecciones un Mercado</option>
									</select>
									<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
						      	</div>
						 	@else
						 		<div id="mercado">
						      		<select class="custom-select " name="mer" id="mer" onchange="buscarSegmento(this.value)">	
						      			<option value="0">Selecciones un Mercado</option>
						      			@foreach ($mercado as $mercado)
										  	<option value="{{ $mercado->id }}">{{ $mercado->mercado }}</option>
									  	@endforeach	
									</select>
									<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
						      	</div>
					      	@endif
					      	
					    </div>
					    <div class="form-group col-md-4">
					      	<label for="">* Segmento</label><br>
					      	<img src="{{ URL::asset('img/loading.gif') }}" id='img_segmento' class="img-responsive" width="40px" style="display: none;">
					      	<div id="segmento">
					      		<select class="custom-select " name="seg" id="seg">	
					      			<option value="0">Selecciones un segmento</option>
								</select>
								<div class="invalid-feedback">
							       	Campo necesario !
						      	</div>
					      	</div>
					    </div>
					    <div class="form-group col-md-4">
					      	<label for="">* Oficina Responsable</label><br>
					      	@if (count($pais) > 1)
						      	<img src="{{ URL::asset('img/loading.gif') }}" id='img_segmento' class="img-responsive" width="40px" style="display: none;">
								<div id="oficina">
						      		<select class="custom-select " name="oficina" id="oficinaa" onchange="mostrarzona(this.value)" >	
						      			<option value="0">Selecciones una Cuidad</option>
									</select>
									<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
						      	</div>
					      	@else
					      		<select class="custom-select " name="oficina" id="oficinaa" onchange="mostrarzona(this.value)">	
					      			<option value="0">Selecciones una Cuidad</option>
					      			@foreach ($cuidades as $element)
					      				<option value="{{ $element->id }}">{{ $element->oficina }}</option>
					      			@endforeach
								</select>
								<div class="invalid-feedback">
							       	Campo necesario !
						      	</div>
					      	@endif
					      	
					    </div>
					</div>

   				</div>
   				<div class="col-md-6 col-sm-6">
   					<div class="form-row">
				  		
					    @if ( Permisos::permiso(Session::get('id_usuario') , 2 ) )
						    <div class="form-group col-md-4">
						    	<label for="">Estatus</label>
						    	<select class="custom-select " name="estatus_client" id="estatus_client">	
					      			<option value="0">Selecciones un estatus</option>
					      			@foreach ($estatus as $estatu)
					      				<option value="{{ $estatu->id }}">{{ $estatu->estatus }}</option>
					      			@endforeach
								</select>
						    	<div class="invalid-feedback">
							       	Campo necesario !
						      	</div>
						  	</div>
					  	@endif
					  	<div class="form-group col-md-12">
					    	<label for="">Zona</label>
					    	@if (count($pais) > 1)
								<input type="text" class="form-control" id="zona" placeholder="" name="zona" value="" readonly="" >
					    	@else
					    		@if ($pais[0]->id == 1 )
									<input type="text" class="form-control" id="zona" placeholder="" name="zona" value="" readonly="" >
					    		@else
									<input type="text" class="form-control" id="zona" placeholder="" name="zona" value="" >
					    		@endif
								
					    	@endif
					    	
					    	<div class="invalid-feedback">
						       	Campo necesario !
					      	</div>
					  	</div>
					    
					</div>
					@if (count($pais) > 1)
				  		<div id="verDirec">
				  			
				  		</div>
				 	@else
				 		@if ($pais[0]->id == 1 )
							<div class="form-row">
								<div class="form-group col-md-4">
							      	<label for="">Calle</label>
							      	<input type="text" class="form-control" placeholder="Calle" name="calle" id="calle" >
							      	<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
							    </div>
							    <div class="form-group col-md-4">
							      	<label for="">Número</label>
							      	<input type="text" class="form-control" placeholder="Número" name="no" id="no" >
							      	<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
							    </div>
							    <div class="form-group col-md-4">
							      	<label for="">Colonia</label>
							      	<input type="text" class="form-control" id="colonia" placeholder="Colonia" name="col" >
							    </div>
								<div class="form-group col-md-4">
							    	<label for="">Código postal</label>
							    	<input type="number" class="form-control" id="tags" placeholder="Código Postal" name="cp" {{-- onkeyup="buscar(this.value)" --}} min="0" >
							    	<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
							  	</div>
							  	<div class="form-group col-md-4">
							      	<label for="">Municipio</label>
							      	<input type="text" class="form-control" id="muni"  placeholder="Municipio" name="muni" >
							    </div>
							    {{-- <div class="form-group col-md-4">
							      	<label for="">Estado</label>
							      	<input type="text" class="form-control" id="estado"  placeholder="Estado" name="estado" >

							    </div> --}}
							    <div class='form-group col-md-4'>
							    	<label>Estado</label>
							    	<select class='custom-select ' name='estado' id='estado' onchange="most_otro(this.value)">
							    		{{-- <option value='14'>México</option> --}}
							    		@foreach ($cat_estados as $cat_es)
							    			<option value='{{ $cat_es->id }}'>{{ $cat_es->estado }}</option>
							    		@endforeach
							    	</select>
							    	<div class='invalid-feedback'>Campo necesario !</div>
							    </div>
							    <div class="form-group col-md-4">
							    	<div id='otro_pais'></div>
							    </div>
							    <div class="form-group col-md-4">
							      	<label for="">País</label>
							      	<select class="custom-select " name="pais_cli" id="pais_cli">	
					      				<option value='157'>MÉXICO</option>
						      			@foreach ($cat_pais as $cat_pai)
						      				<option value="{{ $cat_pai->id }}">{{ $cat_pai->pais }}</option>
						      			@endforeach
									</select>
									<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
							    </div>
							    							
							</div>
				 		@else
				 			<div class="form-row">
								<div class="form-group col-md-8">
							      	<label for="">Dirección</label>
							      	<input type="text" class="form-control" placeholder="Dirección" name="direccion" id="direccion" >
							      	<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
							    </div>
							    <div class="form-group col-md-4">
							      	<label for="">Provincia</label>
							      	<input type="text" class="form-control" placeholder="Provincia" name="provincia" id="provincia" >
							      	<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
							    </div>
							   {{--  <div class="form-group col-md-4">
							      	<label for="">País</label>
							      	<select class="custom-select " name="pais_cli" id="pais_cli">	
					      				<option value='157'>MÉXICO</option>
						      			@foreach ($cat_pais as $cat_pai)
						      				<option value="{{ $cat_pai->id }}">{{ $cat_pai->pais }}</option>
						      			@endforeach
									</select>
									<div class="invalid-feedback">
								       	Campo necesario !
							      	</div>
							    </div> --}}
							    
							</div>
				 		@endif
				  	@endif
				  	
				  	<input type="button" name="" value="Agregar Contacto" class="btn btn-danger" onclick="agregarContac()">
				  	<input type="hidden" value="1" id="cont" >
				  	<input type="hidden" value="1" id="cont2" name="cont2">
   				</div>
   				
   				
   			</div>
   		</div>
   		<div class="container">
			<div class="row" id="contacto">
				
			</div>			
		</div>
		<div class="container">
			<button type="button" onclick="registrar()" class="btn btn-danger">Registar</button>
		</div>	
				  	
	  	
		
		


		
	  	
	</form>
  </div>
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

		function most_otro(id){
			document.getElementById("otro_pais").innerHTML =" ";
			console.log(id);
			if(id==32){
				$("#otro_pais").append("<label>OTRO</label><input type='text' class='form-control' id='otro_es'  placeholder='Estado' name='otro_es' ><div class='invalid-feedback'>Campo necesario !</div>");
			}
			
		}

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

		

		function registrar(){

			var razon = validarfile('razon');
			var nombre = validarfile('nom_comercial');
			var sucursal = validarfile('sucursal');
			var pais = validarSelect('pais');
			var mercado = validarSelect('mer');
			var segV = $("#mer").val();
			if(segV == 14){
				var segmento = validarfile('otro');
			}else{
				var segmento = validarSelect('seg');
			}
			
			var oficina = validarSelect('oficinaa');		
			

			if(razon == 0 || nombre == 0 || sucursal==0 || mercado == 0 || segmento == 0 || oficina==0  || pais==0 ){

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
					                    	if(data.error == 0 ){
					                    		swal({   title: "Registro Exitoso",   text: data.mensaje, type:"success" },
													function(){   
														location.reload();
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
				
		function buscarMercado(valor){
			document.getElementById("mercado").innerHTML =" ";
			document.getElementById("oficina").innerHTML =" ";
			document.getElementById("verDirec").innerHTML =" ";
      		$("#img_mercado").show();
      		$("#img_oficina").show();

      		var pais = $("#pais").val();

      		$("#zona").attr('readonly',true);
      		$("#zona").val('');

      		if(pais != 1 ){
      			$("#zona").attr('readonly',false);
      		}

      		if(pais == 1){
      		
      			$("#verDirec").append("<div class='form-row'><div class='form-group col-md-4'><label >Calle</label><input type='text' class='form-control' placeholder='Calle' name='calle' id='calle' ><div class='invalid-feedback'>Campo necesario !</div></div><div class='form-group col-md-4'><label >Número</label><input type='text' class='form-control' placeholder='Número' name='no' id='no' ><div class='invalid-feedback'>Campo necesario !</div></div><div class='form-group col-md-4'><label >Colonia</label><input type='text' class='form-control' id='colonia' placeholder='Colonia' name='col' ></div><div class='form-group col-md-4'><label >Código postal</label><input type='number' class='form-control' id='tags' placeholder='Código Postal' name='cp' min='0' ><div class='invalid-feedback'>Campo necesario !</div></div><div class='form-group col-md-4'><label >Municipio</label><input type='text' class='form-control' id='muni'  placeholder='Municipio' name='muni' ></div><div class='form-group col-md-4'><label>Estado</label><select class='custom-select ' name='estado' id='estado' onchange='most_otro(this.value)'>@foreach ($cat_estados as $cat_es)<option value='{{ $cat_es->id }}'>{{ $cat_es->estado }}</option>@endforeach</select><div class='invalid-feedback'>Campo necesario !</div></div><div class='form-group col-md-4'><div id='otro_pais'></div></div><div class='form-group col-md-4'><label>País</label><select class='custom-select ' name='pais_cli' id='pais_cli' ><option value='157'>MÉXICO</option>@foreach ($cat_pais as $cat_pai)<option value='{{ $cat_pai->id }}'>{{ $cat_pai->pais }}</option>@endforeach </select><div class='invalid-feedback'>Campo necesario !</div></div></div>");
      		}else if(pais > 1){
      			$("#verDirec").append("<div class='form-row'>"+
										"<div class='form-group col-md-8'>"+
									      	"<label>Dirección</label>"+
									      	"<input type='text' class='form-control' placeholder='Dirección' name='direccion' id='direccion' >"+
									      	"<div class='invalid-feedback'>"+
										       	"Campo necesario !"+
									      	"</div>"+
									    "</div>"+
										"<div class='form-group col-md-4'>"+
									      	"<label>Provincia</label>"+
									      	"<input type='text' class='form-control' placeholder='Provincia' name='provincia' id='provincia' >"+
									      	"<div class='invalid-feedback'>"+
										       	"Campo necesario !"+
									      	"</div>"+
									    "</div>"+
									    
									"</div>");
      		}

      		$.get("{{ URL::asset('ajax_mercado') }}", {id_pais: valor}, function(data) {
				$("#img_mercado").hide();
				$("#img_oficina").hide();
				$("#mercado").append("<select class='custom-select' name='mer'  id='mer' onchange='buscarSegmento(this.value)'><option readonly value='0' selected  >Seleccione una mercado</option>"+data.tipo+"</select><div class='invalid-feedback'>Campo necesario !</div>");
				$("#oficina").append("<select class='custom-select' name='oficina'  id='oficinaa'onchange='mostrarzona(this.value)' ><option readonly value='0' selected  >Seleccione una Oficina</option>"+data.cuidades+"</select><div class='invalid-feedback'>Campo necesario !</div>");
				

			});
		}

		function buscarSegmento(valor){
			var pais = $('#pais').val();
			console.log(valor);
			document.getElementById("segmento").innerHTML =" ";

      		$("#img_segmento").show();
      		$.get("{{ URL::asset('ajax_segmento') }}", {id_mercado: valor,id_pais:pais}, function(data) {
				$("#img_segmento").hide();
				if(valor == 14){
					$("#segmento").append("<input type='text' class='form-control' id='otro' placeholder='Otro' name='otro' ><div class='invalid-feedback'>Campo necesario !</div>");
				}else{
					if(data != ''){
						$("#segmento").append("<select class='custom-select' name='seg'  id='seg'><option readonly value='0' selected  >Seleccione una segmento</option>"+data+"</select><div class='invalid-feedback'>Campo necesario !</div>");
					}else{
						$("#segmento").append("<select class='custom-select' name='seg'><option readonly value='15' selected >Seleccione una segmento</option></select><div class='invalid-feedback'>Campo necesario !</div>");
					}
				}
			});
		}

		function mostrarzona(id){
			var pais = $("#pais").val();
			$("#zona").attr('readonly',true);
			$("#zona").val('');
			if(pais == 1 ){
				if(id == 3 || id == 6 || id == 5){
					$("#zona").val('PACIFICO');
				}
				if(id == 1 || id == 2 || id == 4){
					$("#zona").val('CENTRO');
				}
				if(id == 7 || id == 8 || id == 9){
					$("#zona").val('SURESTE');
				}
			}else{
				$("#zona").attr('readonly',false);
			}
		}

		function agregarContac(){
			var ii = $("#cont").val();
			var num = parseInt(ii) + 1;

			var i = $("#cont2").val();
			var num2 = parseInt(i) + 1;

			if(ii <= 3 ){
				$("#contacto").append("<div class='col-md-6 col-sm-6' id='div"+i+"' >"+
										"<label>Contacto</label>"+
										"<div class='form-row'>"+
											"<div class='form-group col-md-4'>"+
										      	"<label >Nombre</label>"+
										      	"<input type='text' class='form-control' placeholder='Nombre' name='nom_contac"+i+"' id='nom_contac"+i+"' >"+
										      	"<div class='invalid-feedback'>"+
											       	"Campo necesario !"+
										      	"</div>"+
										    "</div>"+
										    "<div class='form-group col-md-4'>"+
										      	"<label >Cargo</label>"+
										      	"<input type='text' class='form-control' placeholder='Cargo' name='car_contac"+i+"' id='car_contac"+i+"' >"+
										      	"<div class='invalid-feedback'>"+
											       	"Campo necesario !"+
										      	"</div>"+
										    "</div>"+
										    "<div class='form-group col-md-4'>"+
										      	"<label >Télefono</label>"+
										      	"<input type='text' class='form-control' id='tel_contac"+i+"' placeholder='Télefono' name='tel_contac"+i+"' >"+
										    "</div>"+
											"<div class='form-group col-md-4'>"+
										    	"<label >Móvil</label>"+
										    	"<input type='text' class='form-control' id='mov_contac"+i+"' placeholder='Móvil' name='mov_contac"+i+"'  >"+
										    	"<div class='invalid-feedback'>"+
											       	"Campo necesario !"+
										      	"</div>"+
										  	"</div>"+
										  	"<div class='form-group col-md-4'>"+
										    	"<label >Correo</label>"+
										    	"<input type='text' class='form-control' id='correo_contac"+i+"' placeholder='Correo' name='correo_contac"+i+"'  >"+
										    	"<div class='invalid-feedback'>"+
											       	"Campo necesario !"+
										      	"</div>"+
										  	"</div>"+
										  	"<div class='form-group col-md-4'>"+
										    	"<label >Eliminar Contacto</label>"+
										    	"<input type='button' class='btn btn-danger btn-block' id='eliminar_cont"+i+"' value='Eliminar Contacto' onclick='elimiar_btn("+i+")'  >"+
										    	"<div class='invalid-feedback'>"+
											       	"Campo necesario !"+
										      	"</div>"+
										  	"</div>"+
										"</div>"+
									"</div>");
				$("#cont").val(num);
				$("#cont2").val(num2);
			}
			
			
		}

		function elimiar_btn(id){
			console.log(id);
			$("#div"+id).remove();
			var i = $("#cont").val();
			var num = parseInt(i) - 1;
			$("#cont").val(num);
		}


	    	
	</script>
@stop