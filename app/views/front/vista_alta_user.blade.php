@extends("tema.master")
@section('tittle')
	<title>Alta de Usario</title>
@stop
<style type="text/css">
	label{
		color: #fff;
		font-size: 12px;
	}
	.tab-content a{
		font-size: 12px;
	}
	.list-group{
		font-size: 12px;
	}
    .modal-body label{
        color: #000;
    }
</style>
@section("contenido")
	<div class="container-fliud">
		<div class="card">
	        <div class="card-body">
	        	<div align="right"><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".agregar"><i class="fas fa-users"></i> Agregar Usario</button></div><br><br>
	        	
				<table id="tabla" class="table table-dark table-bordered" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>Usuario</th>
			                <th>Nombre</th>
			                <th>Correo</th>
			                <th>Ops</th>
			            </tr>
			        </thead>       
			        <tbody>
			        	<?php $auxi=0; ?>
			        	@foreach ($users as $user)
			        		
			        		@if ($auxi != $user->id_u)	        			
			        		
				        		<tr style="background-color: #000">
				        			<td>{{ $user->usuario }}</td>
				        			<td>{{ $user->nombre.' '.$user->paterno.' '.$user->materno }}</td>
				        			<td>{{ $user->correo }}</td>
				        			<td><button type="button" class="btn btn-outline-light btn-sm" data-toggle="modal" data-target=".editar{{$user->id_u}}"><i class="fas fa-user-edit"></i> Editar Usuario</button></td>
				        		</tr>
				        		<div class="modal fade editar{{$user->id_u}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									  <div class="modal-dialog modal-lg">
									    <div class="modal-content">
									    	<div class="modal-header">
										        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario {{ $user->usuario }}</h5>
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          	<span aria-hidden="true">&times;</span>
										        </button>
									      	</div>
											<div class="modal-body">
												<form id="form_datos{{$user->id_u}}">
												  	<div class="form-row">
												    	<div class="form-group col-md-4">
												      		<label for="">Nombre</label>
												      		<input type="text"  class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="{{ $user->nombre }}">
												      		<input type="hidden" name="id_user" value="{{$user->id_u}}">
												    	</div>
												   	 	<div class="form-group col-md-4">
												      		<label for="">Apellido paterno</label>
												      		<input type="text"  class="form-control" id="paterno" name="paterno" placeholder="Apellido paterno" value="{{ $user->paterno }}">
												    	</div>
												    	<div class="form-group col-md-4">
												      		<label for="">Apellido materno</label>
												      		<input type="text"  class="form-control" id="materno" name="materno" placeholder="Apellido materno" value="{{ $user->materno }}">
												    	</div>
												  	</div>
													<div class="form-row">
													  	<div class="form-group col-md-7">
													    	<label for="">Correo Electronico</label>
													    	<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electronico" value="{{ $user->correo }}">
													  	</div>
													  	<div class="form-group col-md-5">
													    	<label for="">Nombre de Usuario</label>
													    	<input type="text" class="form-control" readonly="" value="{{ $user->usuario }}" id="user" name="user" placeholder="Nombre de Usuario" onkeyup="validarUser(this.value,event)" >
													    	<div class="invalid-feedback" id="user_m">
														       	
													      	</div>
													  	</div>
												  	</div>
												  	<div class="form-row">
													  	<div class="form-group col-md-6">
													    	<label for="">Permiso de paises y cuidades</label>
													    	<div class="row">
																  <div class="col-4">
																    <div class="list-group" id="list-tab" role="tablist">
																    	<?php $i=0; ?>
																    	@foreach ($paises as $pais)
																    		@if ($i==0)
																    			<a class="list-group-item list-group-item-action active" id="list-home-list_{{$pais->id.$user->id_u}}" data-toggle="list" href="#list-home_{{$pais->id.$user->id_u}}" role="tab" aria-controls="home">{{$pais->pais}}</a>
																    		@else
																    			<a class="list-group-item list-group-item-action" id="list-profile-list_{{$pais->id.$user->id_u}}" data-toggle="list" href="#list-profile_{{$pais->id.$user->id_u}}" role="tab" aria-controls="profile">{{$pais->pais}}</a>
																    		@endif
																    		<?php  $i++; ?>
																    		
															    		@endforeach
																    </div>
																  </div>
																  <div class="col-8">
																    <div class="tab-content" id="nav-tabContent">
																    	<?php  $i=0; ?>
																    	@foreach ($paises as $pais)
																    		@if ($i==0)
																    			<div class="tab-pane fade show active" id="list-home_{{$pais->id.$user->id_u}}" role="tabpanel" aria-labelledby="list-home-list_{{$pais->id.$user->id_u}}">
																					@foreach ($cuidades as $element)
																						@if ($element->id_pais == $pais->id)
																							<?php $aux2=0; ?>
																							@foreach ($users as $bus)
																								@if ($bus->id_user == $user->id_u)
																									@if ($bus->id_oficina == $element->id )
																										<div class="form-check">
																					    					<input class="form-check-input" checked="" name="oficina_{{$element->id}}" id="ofici_{{$element->id}}" type="checkbox" value="{{$element->id}}">
																									  		<label class="form-check-label" for="ofici_{{$element->id}}">
																									    		{{$element->oficina}}
																									  		</label>
																										</div>
																										<?php $aux2=1; ?>
																									@endif
																								@endif
																							@endforeach
																							@if ($aux2 == 0 )
																								<div class="form-check">
																			    					<input class="form-check-input" name="oficina_{{$element->id}}" id="ofici_{{$element->id}}" type="checkbox" value="{{$element->id}}">
																							  		<label class="form-check-label" for="ofici_{{$element->id}}">
																							    		{{$element->oficina}}
																							  		</label>
																								</div>
																							@endif
																							
																						@endif
																					@endforeach																					
																    			</div>
																    		@else
																    			<div class="tab-pane fade" id="list-profile_{{$pais->id.$user->id_u}}" role="tabpanel" aria-labelledby="list-profile-list_{{$pais->id.$user->id_u}}">
																    				@foreach ($cuidades as $element)
																						@if ($element->id_pais == $pais->id)
																							<?php $aux2=0; ?>
																							@foreach ($users as $bus)
																								@if ($bus->id_user == $user->id_u)
																									@if ($bus->id_oficina == $element->id )
																										<div class="form-check">
																					    					<input class="form-check-input" checked="" name="oficina_{{$element->id}}" id="ofici_{{$element->id}}" type="checkbox" value="{{$element->id}}">
																									  		<label class="form-check-label" for="ofici_{{$element->id}}">
																									    		{{$element->oficina}}
																									  		</label>
																										</div>
																										<?php $aux2=1; ?>
																									@endif
																								@endif
																							@endforeach
																							@if ($aux2==0)
																								<div class="form-check">
																			    					<input class="form-check-input" name="oficina_{{$element->id}}" id="ofici_{{$element->id}}" type="checkbox" value="{{$element->id}}">
																							  		<label class="form-check-label" for="ofici_{{$element->id}}">
																							    		{{$element->oficina}}
																							  		</label>
																								</div>
																							@endif
																							
																						@endif
																					@endforeach																    				
																    			</div>
																    		@endif
																    		<?php  $i++; ?>
																		@endforeach

																      
																    </div>
																  </div>
															</div>
													  	</div>
													  	<div class="form-group col-md-6">
													    	<label for="">Permiso para aplicación</label>
													    	<div class="row">
															  <div class="col-4">
															    <div class="list-group" id="list-tab" role="tablist">
															    	<?php $i=0; $aux = 0; ?>
															    	@foreach ($permisos as $permiso)
															    		@if ($aux != $permiso->id_modulo )
															    			@if ($i==0)
																    			<a class="list-group-item list-group-item-action active" id="list-home-list{{$permiso->id.$permiso->permiso.$user->id_u}}" data-toggle="list" href="#list-home{{$permiso->id.$permiso->permiso.$user->id_u}}" role="tab" aria-controls="home">{{$permiso->modulo}}</a>
																    		@else
																    			<a class="list-group-item list-group-item-action" id="list-profile-list{{$permiso->id.$permiso->permiso.$user->id_u}}" data-toggle="list" href="#list-profile{{$permiso->id.$permiso->permiso.$user->id_u}}" role="tab" aria-controls="profile">{{$permiso->modulo}}</a>
																    		@endif
																    		<?php  $i++; ?>
															    		@endif
															    		<?php $aux = $permiso->id_modulo; ?>
														    		@endforeach

															    </div>
															  </div>
															  <div class="col-8">
															    <div class="tab-content" id="nav-tabContent">
															    	<?php $i=0; $aux = 0; ?>
															    	@foreach ($permisos as $permiso)
															    		@if ($aux != $permiso->id_modulo )
																    		@if ($i==0)
																    			<div class="tab-pane fade show active" id="list-home{{$permiso->id.$permiso->permiso.$user->id_u}}" role="tabpanel" aria-labelledby="list-home-list{{$permiso->id.$permiso->permiso.$user->id_u}}">

																    				@foreach ($permisos as $element)
																    					@if ($element->id_modulo == $permiso->id_modulo)														
																							<?php $aux2=0; ?>
																							
																    						@foreach ($detalle_permiso as $perm)
																    							@if ($perm->id_usuario == $user->id_u and $perm->id_permiso == $element->id )
																    								<div class="form-check">
																									  	<input checked="" class="form-check-input" name="permiso_{{$element->id}}" type="checkbox" value="{{$element->id}}"  id="check_p{{$element->id}}" >
																									  	<label class="form-check-label" for="check_p{{$element->id}}">
																									    	{{ $element->descripcion }}
																									  	</label>
																									</div>
																									<?php $aux2=1; ?>
																    							@endif
																    							
																    						@endforeach
																    						@if ($aux2 == 0)
																    							<div class="form-check">
																								  	<input class="form-check-input" name="permiso_{{$element->id}}" type="checkbox" value="{{$element->id}}"  id="check_p{{$element->id}}" >
																								  	<label class="form-check-label" for="check_p{{$element->id}}">
																								    	{{ $element->descripcion }}
																								  	</label>
																								</div>
																    						@endif
																    						
																    						
																    					@endif
																    				@endforeach																
																					
																    			</div>
																    		@else
																    			<div class="tab-pane fade" id="list-profile{{$permiso->id.$permiso->permiso.$user->id_u}}" role="tabpanel" aria-labelledby="list-profile-list{{$permiso->id.$permiso->permiso.$user->id_u}}">
																    				@foreach ($permisos as $element)
																    					@if ($element->id_modulo == $permiso->id_modulo)
																    						<?php $aux2=0; ?>
																							
																    						@foreach ($detalle_permiso as $perm)
																    							@if ($perm->id_usuario == $user->id_u and $perm->id_permiso == $element->id )
																    								<div class="form-check">
																									  	<input checked="" class="form-check-input" name="permiso_{{$element->id}}" type="checkbox" value="{{$element->id}}"  id="check_p{{$element->id}}" >
																									  	<label class="form-check-label" for="check_p{{$element->id}}">
																									    	{{ $element->descripcion }}
																									  	</label>
																									</div>
																									<?php $aux2=1; ?>
																    							@endif
																    							
																    						@endforeach
																    						@if ($aux2 == 0)
																    							<div class="form-check">
																								  	<input class="form-check-input" name="permiso_{{$element->id}}" type="checkbox" value="{{$element->id}}"  id="check_p{{$element->id}}" >
																								  	<label class="form-check-label" for="check_p{{$element->id}}">
																								    	{{ $element->descripcion }}
																								  	</label>
																								</div>
																    						@endif
																    					@endif
																    				@endforeach	
																    				
																    			</div>
																    		@endif
																    		<?php  $i++; ?>
															    		@endif
															    		<?php $aux = $permiso->id_modulo; ?>
															    		
																	@endforeach

															      
															    </div>
															  </div>
															</div>
													  	</div>
												  	</div>

												</form>
												
											</div>
											
									      	<div class="modal-footer">
										        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
										        
										        <button type="button" class="btn btn-primary" onclick="editar({{$user->id_u}})">Editar</button>
									      	</div>
									    </div>
									  </div>
								</div>
							@endif
							<?php $auxi=$user->id_u; ?>
			        	@endforeach
			     	</tbody>
			    </table>

			    <div class="modal fade agregar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg">
				    <div class="modal-content">
				    	<div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Usuario</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          	<span aria-hidden="true">&times;</span>
					        </button>
				      	</div>
						<div class="modal-body">
							<form id="form_datos">
							  	<div class="form-row">
							    	<div class="form-group col-md-4">
							      		<label for="">Nombre</label>
							      		<input type="text"  class="form-control" id="nombre" name="nombre" placeholder="Nombre">
							    	</div>
							   	 	<div class="form-group col-md-4">
							      		<label for="">Apellido paterno</label>
							      		<input type="text"  class="form-control" id="paterno" name="paterno" placeholder="Apellido paterno">
							    	</div>
							    	<div class="form-group col-md-4">
							      		<label for="">Apellido materno</label>
							      		<input type="text"  class="form-control" id="materno" name="materno" placeholder="Apellido materno">
							    	</div>
							  	</div>
								<div class="form-row">
								  	<div class="form-group col-md-7">
								    	<label for="">Correo Electronico</label>
								    	<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electronico">
								  	</div>
								  	<div class="form-group col-md-5">
								    	<label for="">Nombre de Usuario</label>
								    	<input type="text" class="form-control"  id="user" name="user" placeholder="Nombre de Usuario" onkeyup="validarUser(this.value,event)" >
								    	<div class="invalid-feedback" id="user_m">
									       	
								      	</div>
								  	</div>
							  	</div>
							  	<div class="form-row">
								  	<div class="form-group col-md-6">
								    	<label for="">Permiso de paises y cuidades</label>
								    	<div class="row">
											  <div class="col-4">
											    <div class="list-group" id="list-tab" role="tablist">
											    	<?php $i=0; ?>
											    	@foreach ($paises as $pais)
											    		@if ($i==0)
											    			<a class="list-group-item list-group-item-action active" id="list-home-list{{$pais->id}}" data-toggle="list" href="#list-home{{$pais->id}}" role="tab" aria-controls="home">{{$pais->pais}}</a>
											    		@else
											    			<a class="list-group-item list-group-item-action" id="list-profile-list{{$pais->id}}" data-toggle="list" href="#list-profile{{$pais->id}}" role="tab" aria-controls="profile">{{$pais->pais}}</a>
											    		@endif
											    		<?php  $i++; ?>
											    		
										    		@endforeach
											    </div>
											  </div>
											  <div class="col-8">
											    <div class="tab-content" id="nav-tabContent">
											    	<?php  $i=0; ?>
											    	@foreach ($paises as $pais)
											    		@if ($i==0)
											    			<div class="tab-pane fade show active" id="list-home{{$pais->id}}" role="tabpanel" aria-labelledby="list-home-list{{$pais->id}}">
																<div class="form-check">
																  	<input class="form-check-input" name="pais{{$pais->id}}" type="checkbox" value="{{$pais->id}}" id="check{{$pais->id}}" onclick="mostrar_cuidad(this.value)">
																  	<label class="form-check-label" for="check{{$pais->id}}">
																    	Activar {{ $pais->pais }}
																  	</label>
																</div>
																<div id="cuidades{{$pais->id}}">
																	
																</div>

																
											    			</div>
											    		@else
											    			<div class="tab-pane fade" id="list-profile{{$pais->id}}" role="tabpanel" aria-labelledby="list-profile-list{{$pais->id}}">
											    				<div class="form-check">
											    					<input class="form-check-input" name="pais{{$pais->id}}" type="checkbox" value="{{$pais->id}}" id="check{{$pais->id}}" onclick="mostrar_cuidad(this.value)">
															  		<label class="form-check-label" for="check{{$pais->id}}">
															    		Activar {{ $pais->pais }}
															  		</label>
																</div>
														  		<div id="cuidades{{$pais->id}}">
																
																</div>
											    				
											    			</div>
											    		@endif
											    		<?php  $i++; ?>
													@endforeach

											      
											    </div>
											  </div>
										</div>
								  	</div>
								  	<div class="form-group col-md-6">
								    	<label for="">Permiso para aplicación</label>
								    	<div class="row">
										  <div class="col-4">
										    <div class="list-group" id="list-tab" role="tablist">
										    	<?php $i=0; $aux = 0; ?>
										    	@foreach ($permisos as $permiso)
										    		@if ($aux != $permiso->id_modulo )
										    			@if ($i==0)
											    			<a class="list-group-item list-group-item-action active" id="list-home-list{{$permiso->id.$permiso->permiso}}" data-toggle="list" href="#list-home{{$permiso->id.$permiso->permiso}}" role="tab" aria-controls="home">{{$permiso->modulo}}</a>
											    		@else
											    			<a class="list-group-item list-group-item-action" id="list-profile-list{{$permiso->id.$permiso->permiso}}" data-toggle="list" href="#list-profile{{$permiso->id.$permiso->permiso}}" role="tab" aria-controls="profile">{{$permiso->modulo}}</a>
											    		@endif
											    		<?php  $i++; ?>
										    		@endif
										    		<?php $aux = $permiso->id_modulo; ?>
									    		@endforeach

										    </div>
										  </div>
										  <div class="col-8">
										    <div class="tab-content" id="nav-tabContent">
										    	<?php $i=0; $aux = 0; ?>
										    	@foreach ($permisos as $permiso)
										    		@if ($aux != $permiso->id_modulo )
											    		@if ($i==0)
											    			<div class="tab-pane fade show active" id="list-home{{$permiso->id.$permiso->permiso}}" role="tabpanel" aria-labelledby="list-home-list{{$permiso->id.$permiso->permiso}}">

											    				@foreach ($permisos as $element)
											    					@if ($element->id_modulo == $permiso->id_modulo)
											    						<div class="form-check">
																		  	<input class="form-check-input" name="permiso_{{$element->id}}" type="checkbox" value="{{$element->id}}"  id="check_p{{$element->id}}" >
																		  	<label class="form-check-label" for="check_p{{$element->id}}">
																		    	{{ $element->descripcion }}
																		  	</label>
																		</div>
											    						
											    					@endif
											    				@endforeach																
																
											    			</div>
											    		@else
											    			<div class="tab-pane fade" id="list-profile{{$permiso->id.$permiso->permiso}}" role="tabpanel" aria-labelledby="list-profile-list{{$permiso->id.$permiso->permiso}}">
											    				@foreach ($permisos as $element)
											    					@if ($element->id_modulo == $permiso->id_modulo)
											    						<div class="form-check">
																		  	<input class="form-check-input" name="permiso_{{$element->id}}" type="checkbox" value="{{$element->id}}" id="check_p{{$element->id}}" >
																		  	<label class="form-check-label" for="check_p{{$element->id}}">
																		    	{{ $element->descripcion }}
																		  	</label>
																		</div>
											    					@endif
											    				@endforeach	
											    				
											    			</div>
											    		@endif
											    		<?php  $i++; ?>
										    		@endif
										    		<?php $aux = $permiso->id_modulo; ?>
										    		
												@endforeach

										      
										    </div>
										  </div>
										</div>
								  	</div>
							  	</div>

							</form>
							
						</div>
						
				      	<div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					        <button type="button" class="btn btn-primary" onclick="registrar()">Agregar</button>
				      	</div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	

@stop

@section("java")
	@parent
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
	{{HTML::script("//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js", array("type" => "text/javascript"))}}
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#tabla').DataTable({
                // "language": {
                //   "url": "{{URL::to('js/lenguajeDataTable/es_es.json')}}"
                // },
                "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "Todos"]],
                "order": false

                
            });
            
		});
		function espacios(nombre){
			valor = $("#"+nombre).val();
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) || valor == '' ) {
				$("#"+nombre).attr('class','form-control is-invalid');
				return 0;
			}else{
				if (valor.split(' ').length>=2){
					document.getElementById("user_m").innerHTML =" ";
					$("#user_m").append("No se permiten espacios");
					$("#user").attr('class','form-control is-invalid');
					return 0;
				}else{
					$("#"+nombre).attr('class','form-control is-valid');
            		return 1;
				}
            	
            }
		}
		function validarNombre(nombre){
			valor = $("#"+nombre).val();
			var v ;
			v = $.get("{{ URL::asset('ajax_validar_user') }}", {user: valor}, function(data) {
				if(data == 1 ){
					document.getElementById("user_m").innerHTML =" ";
					$("#user_m").append("EL usuario ya existe");
					$("#user").attr('class','form-control is-invalid');
					return 0;
				}else{
					return 1;
				}
			});
			console.log(v);
		}
		function validarUser(valor,e){
			
			espacios('user');
			validarNombre('user');			
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

		function registrar(){

			var nombre = validarfile('nombre');
			var paterno = validarfile('paterno');
			var materno = validarfile('materno');
			var correo = validarfile('correo');
			var user = 	espacios('user');
			var userNom = 	validarNombre('user');
			
			console.log(userNom);
			if(nombre == 0 || paterno==0 || materno == 0 || correo == 0 || user== 0 || userNom == 0 ){

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
					                 url:'{{ URL::asset("/registrar_user") }}' ,    
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

		function editar(id){

			swal({
				  title: "¿Seguro de Editar?",
				  text: "REGISTRO!",
				  type: "warning",
				  showCancelButton: true,
				  closeOnConfirm: false,
				  confirmButtonColor: "#DD6B55",
	              confirmButtonText: "Si, editar!",
	              cancelButtonText: "No, cancelar!",
				  showLoaderOnConfirm: true
				}, function () {
				  	setTimeout(function () {
					    var formData = new FormData(document.getElementById("form_datos"+id));
		              		$.ajax({
				                 type: 'post',   
				                 cache: false,
				                 url:'{{ URL::asset("/editar_user") }}' ,    
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

		function mostrar_cuidad(pais) {

			document.getElementById("cuidades"+pais).innerHTML =" ";

			if( $('#check'+pais).prop('checked') ) {
				$.get("{{ URL::asset('ajax_cuidades') }}", {id_pais: pais}, function(data) {
					$("#cuidades"+pais).append(data);
					// console.log(data);
				});
			    // alert('Seleccionado');
			}else{
				// alert('no Seleccionado');
			}
		}
	</script>
	
@stop