@extends("tema.master")
@section("tittle")
	<title>Labor de Venta</title>
@stop
<style type="text/css">
	label{
		color: #fff;
	}
    .modal-body label{
        color: #000;
    }
    .dividir{
        border: 2px solid #4d5061;
    }
    #otro_seg{
        display: none;
    }
    #act_seg{
        display: none;
    }

</style>
@section("titulo")
@stop
@section("contenido")
	<div class="card">
        <div class="card-body">
           

             @if ($datos))
                <table id="tabla" class="table table-dark table-bordered table-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ACTIVIDAD</th>
                            <th>CLIENTE</th>
                            <th>FECHA</th>
                             <th>MOTIVO</th>
                            <th>DECRIP. MOTIVO</th>                                                        
                            <th>RAZON SOCIAL</th>
                            <th>NOMBRE COMERCIAL</th>
                            <th>SUCURSAL</th>
                            <th>ESTATUS</th>
                            <th>MOT. CANCELACIÓN</th>
                            <th>USUARIO</th>
                        </tr>
                    </thead>       
                    <tbody>
                        @foreach ($datos as $dato)
                            <tr style="background-color: #000">
                                <td><!-- <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#{{ $dato->idventa }}">
                                          Registrar labor de venta
                                        </button> -->
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-outline-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Actividad
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                         @if ($dato->estatus_labor==1)   
                                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#{{ $dato->idventa }}" onclick="cargar('{{ $dato->idventa }}','{{ $dato->id_pais }}','{{ $dato->id_oficina_central}}')" >Cerrar Plan</a>                                  
                                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#{{ $dato->idventa }}1">Cancelar</a>
                                          @elseif ($dato->estatus_labor==2)
                                          <!-- <a class="dropdown-item" href="#">Editar</a> -->
                                          <a class="dropdown-item" href="#" onclick="borrar('{{ $dato->idventa }}')">Eliminar</a>
                                          @elseif ($dato->estatus_labor==3)
                                          <a class="dropdown-item" href="#">Sin Actividad</a>
                                          @endif
                                        </div>
                                    </div>
                                    </td>
                                <td>{{ $dato->cliente }}</td>       
                                <td>{{ $dato->fecha_labor_venta }}</td>
                                <td>{{ $dato->motivo}}</td>                                
                                <td>{{ $dato->otro_motivo}}</td>                                 
                                <td>{{ $dato->razon}}</td>
                                <td>{{ $dato->nombre_comercial}}</td>
                                <td>{{ $dato->sucursal }}</td>
                                <td>
                                  @if ($dato->estatus_labor==1)
                                    <span class="label" style="background-color:#5cb85c; font-size: 12px">Plan Abierto</span>
                                @elseif ($dato->estatus_labor==2)
                                    <span class="label" style="background-color:red; font-size: 12px" >Plan Cerrado</span>
                                @elseif ($dato->estatus_labor==3)
                                 <span class="label" style="background-color:#0033ff; font-size: 12px" >Plan Cancelado</span>    
                                @endif
                                </td>
                                <td>{{ $dato->motivo_cancelacion }}</td>  
                                <td>{{ $dato->usuario }}</td>                            
                            </tr>
                            <!-- Modal -->
                             
                              <div class="modal fade" id="{{ $dato->idventa }}"  tabindex="-1" role="dialog" aria-labelledby="{{ $dato->idventa }}" aria-hidden="true">
                                  <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Registro del Cierre Plan de Venta - {{ $dato->cliente }} - {{ $dato->fecha_labor_venta}}</h5>              
                                      </div>
                                      <div class="modal-body">
                                       
                                            <div class="row">
                                                <div class="col">
                                                    <label>FECHA DEL PLAN LABOR DE VENTA</label>
                                                    <div class="col-sm-10">
                                                        <input type='Date' class="form-control" id='fecha_plan{{$dato->idventa}}' name='fecha_plan' />
                                                       <div class="invalid-feedback">
                                                        Campo necesario !
                                                       </div>      
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label>ACTIVIDAD REALIZADA</label>
                                                    <div class="col-sm-10">
                                                       <select class="custom-select " name="actividad" id="actividad{{$dato->idventa}}" >  
                                                            <option value="">Selecciones una actividad</option>
                                                            <option value="VISITA">VISITA</option>
                                                            <option value="LLAMADA">LLAMADA</option>
                                                            <option value="CORREO ELECTRONICO">CORREO ELECTRONICO</option>                   
                                                        </select>
                                                        <div class="invalid-feedback">
                                                        Campo necesario !
                                                      </div>                   
                                                    </div>
                                                </div>                                               
                                                 <div class="col-12">
                                                   <label>AGREGAR INFORMACIÓN</label>
                                                    <div class="col-sm-10">
                                                        <input type="button" name="" value="Agregar Contacto" class="btn btn-danger" onclick="agregar('{{$dato->idventa}}')"/>
                                                        <input type="hidden" value="1" id="cont{{$dato->idventa}}" />
                                                        <input type="hidden" value="1" id="cont2{{$dato->idventa}}" name="cont2"/>
                                                     </div>
                                                     <hr class="dividir">   
                                                </div>
                                                 
                                                 <div class="container-fluid">                                                      
                                                        <div class="row" id="contacto1{{$dato->idventa}}">

                                                            <div id="div{{$dato->idventa}}">
                                                             <div class="col-12">                             
                                                                 <label>PERSONA CONTACTADA</label>
                                                                <div class="col-sm-10">
                                                                     <input type="text" class="form-control" id="contacto{{$dato->idventa}}" placeholder="Nombre de la Persona Contactada" value="" />
                                                                    <div class="invalid-feedback">
                                                                      Campo necesario !
                                                                    </div>      
                                                                  </div>
                                                                </div>
                                                            <div class="col-12">
                                                                <label>PUESTO</label>
                                                                <div class="col-sm-10">
                                                                     <input type="text" class="form-control" id="puesto{{$dato->idventa}}" placeholder="Puesto de la Persona Contactada" value=""/>
                                                                    <div class="invalid-feedback">
                                                                      Campo necesario !
                                                                    </div>      
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label>TELEFONO</label>
                                                                <div class="col-sm-10">
                                                                     <input type="text" class="form-control" id="telefono{{$dato->idventa}}" placeholder="Telefono de la Persona Contactada" value="" />
                                                                     <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                      </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label>CORREO</label>
                                                                <div class="col-sm-10">                                             
                                                                     <input type="email" class="form-control" id="correo{{$dato->idventa}}" placeholder="correo de la Persona Contactada" value=""/>
                                                                    <!--  <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                    </div>  -->       
                                                                </div>
                                                            </div>
                                                         </div> 
                                                      </div>
                                                    </div>
                                                       
                                                <div class="col-12">
                                                    <hr class="dividir">  
                                                </div>              
                                                         
                                                @if($dato->permiso==1)
                                                <div class="col-6">
                                                    
                                                    <label>REQUERIMIENTO DEL CLIENTE</label>
                                                    <div class="col-sm-10">
                                                        <select class="custom-select " name="requerimiento" id="requerimiento{{$dato->idventa}}" onchange="mostrar('{{$dato->idventa}}')" >  
                                                            <option value="0">Selecciones una actividad</option>
                                                            <option value="SERVICIO">SERVICIO</option>
                                                            <option value="COMPONENTES">COMPONENTES</option>
                                                            <option value="COMPRESOR RC">COMPRESOR RC</option>
                                                            <option value="COMPRESOR SC">COMPRESOR SC</option>
                                                            <option value="PAQUETES TORNILLO">PAQUETES TORNILLO</option>
                                                            <option value="PROYECTO">PROYECTO</option>
                                                            <option value="OTROS">OTROS</option>                                
                                                        </select>
                                                        <div class="invalid-feedback">
                                                        Campo necesario !
                                                        </div>     
                                                    </div>                                                    
                                                </div>
                                                 @else
                                                 <div class="col-6">
                                                    <label>REQUERIMIENTO DEL CLIENTE</label>
                                                    <div class="col-sm-10">
                                                        <select class="custom-select " name="requerimiento" id="requerimiento{{$dato->idventa}}" onchange="mostrar('{{$dato->idventa}}')" >  
                                                            <option value="0">Selecciones una actividad</option>
                                                            <option value="SERVICIO">SERVICIO</option>
                                                            <option value="COMPONENTES">COMPONENTES</option>
                                                            <option value="COMPRESOR RC">COMPRESOR RC</option>
                                                            <option value="COMPRESOR SC">COMPRESOR SC</option>
                                                            <!-- <option value="CORREO ELECTRONICO">PAQUETES TORNILLO</option> -->
                                                            <option value="PROYECTO">PROYECTO</option>
                                                            <option value="OTROS">OTROS</option>                                
                                                        </select>
                                                        <div class="invalid-feedback">
                                                        Campo necesario !
                                                        </div>     
                                                    </div>                                                    
                                                </div>                                                
                                                 @endif
                                                 <div class="col-6" id="otro_seg{{$dato->idventa}}" style="display: none;border: 2px solid #ef8181;">                                               
                                                </div>
                                                  <div class="col-6">                                                    
                                                    <label>DETALLES DEL REQUERIMIENTO</label>
                                                    <div class="col-sm-10">
                                                         <input type="text" class="form-control" id="detalle{{$dato->idventa}}" placeholder="Detalles del Requerimiento" value=""/>
                                                        <div class="invalid-feedback">
                                                        Campo necesario !
                                                        </div>      
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label>ACTIVIDAD DE SEGUIMIENTO</label>
                                                    <div class="col-sm-10">
                                                          <select class="custom-select " name="act_seguimiento" id="act_seguimiento{{$dato->idventa}}" onchange="mostrar1('{{$dato->idventa}}')">  
                                                                <option value="0">Selecciones una actividad</option>
                                                                <option value="ENVIAR COTIZACION">ENVIAR COTIZACION</option>
                                                                <option value="ASISTENCIA TECNICA">ASISTENCIA TECNICA</option>
                                                                <option value="ENVIAR INFORMACION DE PRODUCTO Y/ O SERVICIO">ENVIAR INFORMACION DE PRODUCTO Y/ O SERVICIO</option>
                                                                <option value="NO APLICA SEGUIMIENTO">NO APLICA SEGUIMIENTO</option>
                                                                <option value="OTROS">OTROS</option>                            
                                                          </select>
                                                          <div class="invalid-feedback">
                                                          Campo necesario !
                                                          </div>    
                                                    </div>
                                                </div>
                                                <div class="col-6" id="act_seg{{$dato->idventa}}" style="display: none;border: 2px solid #ef8181;">                                               
                                                </div>
                                                 <div class="col-6">
                                                    <label>RESPONSABLE DE DAR SEGUIMIENTO</label>
                                                    <div class="col-sm-10">
                                                          <!-- <input type="text" class="form-control" id="responsable_segui{{$dato->idventa}}" placeholder="Responsable de Dar Seguimiento" value="" required=""/>  --> 
                                                           <div id="responsable{{ $dato->idventa }}"></div>
                                                    </div>
                                                </div>
                                                 <div class="col">
                                                    <label>CORREO ELECTRONICO DEL RESPONSABLE DE DAR SEGUIMIENTO</label>
                                                    <div class="col-sm-10">
                                                          <!-- <input type="text" class="form-control" id="correo_resp{{$dato->idventa}}" placeholder="Correo electronico del responsable" value="" required=""/> -->
                                                          <div id="correo_resp1{{ $dato->idventa }}"></div>  
                                                    </div>
                                                </div>
                                                 <div class="col-6">
                                                    <label>FECHA DE PROXIMO PLAN LABOR DE VENTA</label>
                                                    <div class="col-sm-10">
                                                           <input type="Date"  name="fecha" id="date_range{{ $dato->idventa }}"  class="form-control has-feedback-left" placeholder="inicio(03/18/2017) - fin(03/23/2013)" />
                                                          <div class="invalid-feedback">
                                                          Campo necesario !
                                                          </div>  
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label>HORA DEL PROXIMO PLAN LABOR DE VENTA</label>
                                                    <div class="col-sm-10">
                                                          <input  id="hora{{$dato->idventa}}" name="desde" class="form-control">
                                                        <div class="invalid-feedback">
                                                          Campo necesario !
                                                        </div>   
                                                    </div>
                                                </div>
                                                                                             
                                                <div class="col-6">
                                                    <label>INDICACIONES DE LA ACTIVIDAD DE SEGUIMIENTO</label>
                                                    <div class="col-sm-10">
                                                          <input type="text" class="form-control" id="indicaciones{{$dato->idventa}}" placeholder="Indicaciones de la actividad" value="" required=""/>
                                                         <div class="invalid-feedback">
                                                          Campo necesario !
                                                         </div>  
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label>COMENTARIOS ADICIONALES</label>
                                                    <div class="col-sm-10">
                                                          <input type="text" class="form-control" id="comentarios{{$dato->idventa}}" placeholder="Comentarios Adicionales" value="" required=""/>
                                                         <div class="invalid-feedback">
                                                          Campo necesario !
                                                         </div>  
                                                    </div>
                                                </div>
                                                <div class="col-6">                                                              
                                                    <label>FECHA DE COMPROMISO PARA REALIZAR ACTIVIDAD DE SEGUIMIENTO</label>
                                                    <div class="col-sm-10">
                                                          <input type="Date" class="form-control" id="fecha_com{{$dato->idventa}}" placeholder="fecha de compromiso para realizar actividad de seguimiento" value="" required=""/><div class="invalid-feedback">
                                                          Campo necesario !
                                                          </div> 
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                      
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-danger" onclick="guardar('{{ $dato->cliente }}','{{ $dato->fecha_labor_venta}}','{{$dato->idventa}}')">Guardar</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              
                                <!--Inicia Modal Cancelar -->
                                <div class="modal fade" id="{{ $dato->idventa }}1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Cancelación de Agenda - {{ $dato->cliente }} - {{ $dato->fecha_labor_venta}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="message-text" class="col-form-label">Motivo de la cancelación:</label>
                                                    <textarea class="form-control" id="mot_cancelacion{{$dato->idventa}}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-danger" onclick="cancelar('{{ $dato->idventa }}')">Cancelar</button>
                                      </div>
                                    </div>
                                  </div>
                                </div> 
                        @endforeach
                    </tbody>
               <tfoot>
                      <tr>
                            <th>ACTIVIDAD</th>
                            <th>CLIENTE</th>
                            <th>FECHA</th>
                            <th>MOTIVO</th>
                            <th>DECRIP. MOTIVO</th>                                                        
                            <th>RAZON SOCIAL</th>
                            <th>NOMBRE COMERCIAL</th>
                            <th>SUCURSAL</th>
                            <th>ESTATUS</th>
                            <th>MOT. CANCELACIÓN</th>
                            <th>USUARIO</th>

                      </tr>
                  </tfoot>
                </table>
             @else
               <div class="alert alert-danger col-6" role="alert">
                 NO EXISTEN REGISTROS
                </div>
            @endif          
        </div>
    </div>	
@stop

@section("java")
	@parent
	{{HTML::script("bootstrap/dist/js/jquery.min.js", array("type" => "text/javascript"))}}
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
	{{HTML::script("//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js", array("type" => "text/javascript"))}}
    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    
    
	<script type="text/javascript">
	   $(document).ready(function(){

        // Setup - add a text input to each footer cell
        $('#tabla tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        } );

        // DataTable
        var table = $('#tabla').DataTable(
           // "language": {
           //       "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
           //      }
        );

        // Apply the search
        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                    .search( this.value )
                    .draw();
                }
            } );
        } );



            // $('#tabla').DataTable({
            //     "language": {
            //      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            //     },
            //     "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "Todos"]],
            //     "order": [[ 4, "asc" ],[ 0, "asc" ]]
                
            // });
            
        });
      

      //validar campos para que sean 
       function validarcampo(nombre){
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




       function mostrar(id_venta){
        console.log(id_venta);
        var requerimiento= $("#requerimiento"+id_venta).val();        
             document.getElementById("otro_seg"+id_venta).innerHTML = " ";
                if (requerimiento=='OTROS') {
                    $("#otro_seg"+id_venta).show();
                     $("#otro_seg"+id_venta).append("<label>OTRO REQUERIMIENTO</label>"+
                                           "<div class='col-sm-10'>"+
                                           "<input type='text' class='form-control' id='otro_requerimiento"+id_venta+"' placeholder='Otro Requerimiento' value='' required=''/>"+
                                           "</div>");                                              
                                                            
                }
                else{
                    console.log('no entro');
                     $("#otro_seg"+id_venta).hide();
                }
            
       }
       function mostrar1(id_venta){
        var act_seguimiento= $("#act_seguimiento"+id_venta).val();
         console.log(act_seguimiento);
            document.getElementById("act_seg"+id_venta).innerHTML = " ";
                 if (act_seguimiento=='OTROS') {
                    $("#act_seg"+id_venta).show();
                     $("#act_seg"+id_venta).append("<label>OTRA ACT. DE SEGUIMIENTO</label>"+
                                           "<div class='col-sm-10'>"+
                                           "<input type='text' class='form-control' id='otro_act"+id_venta+"' placeholder='Actividad  Seguimiento' value='' required=''/>"+
                                           "</div>");                                              
                                                            
                }
                else{
                    console.log('no entro');
                     $("#act_seg"+id_venta).hide();
                }
       }

        function mostrar5(id_venta){
        var id_responsable= $("#responsable_segui"+id_venta).val();
         console.log(id_responsable);
            document.getElementById("correo_resp1"+id_venta).innerHTML = " ";
            $.get("{{ URL::asset('consulta_correo') }}",{id_responsable:id_responsable}, function(data) {
               console.log(data.correo[0].correo);
              $("#correo_resp1"+id_venta).append("<input type='text' class='form-control' id='correo_resp"+id_venta+"' placeholder='Correo electronico del responsable' value='"+data.correo[0].correo+"' required=''/>");

              },'json');  
                
        }

       function agregar(id_agenda){
            
             var ii = $("#cont"+id_agenda).val();
            var num = parseInt(ii) + 1;
            var i = $("#cont2"+id_agenda).val();
            var num2 = parseInt(i) + 1;
             console.log(num,num2);   

             console.log(i,ii);           

            if(ii <=2 ){
                $("#contacto"+id_agenda).append("<div id='div"+i+"'>"+
                                                  "<div class='col-12' id=per"+i+id_agenda+">"+                                               
                                                    "<label>PERSONA CONTACTADA</label>"+
                                                    "<div class='col-sm-10'>"+
                                                         "<input type='text' class='form-control' id='contacto"+i+id_agenda+"' placeholder='Nombre de la Persona Contactada' value='' required=''/>"+     
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='col-12'>"+
                                                    "<label>PUESTO</label>"+
                                                    "<div class='col-sm-10'>"+
                                                         "<input type='text' class='form-control' id='puesto"+i+id_agenda+"' placeholder='Puesto de la Persona Contactada' value='' required='/>"+     
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='col-12'>"+
                                                    "<label>TELEFONO</label>"+
                                                    "<div class='col-sm-10'>"+
                                                         "<input type='text' class='form-control' id='telefono"+i+id_agenda+"' placeholder='Telefono de la Persona Contactada' value='' required=''/>"+     
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='col-12'>"+
                                                    "<label>CORREO</label>"+
                                                    "<div class='col-sm-10'>"+
                                                         "<span data-feather='email'></span>"+                                                
                                                         "<input type='email' class='form-control ' id='correo"+i+id_agenda+"' placeholder='correo de la Persona Contactada' value='' />"+                                            
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='col-12'>"+
                                                "<label >Eliminar Contacto</label>"+
                                                "<input type='button' class='btn btn-danger btn-block' id='eliminar_cont"+i+"' value='Eliminar Contacto' onclick='elimiar_btn("+i+","+id_agenda+")'  >"+                            
                                                "</div>"+
                                                "</div>");
                $("#cont"+id_agenda).val(num);
                $("#cont2"+id_agenda).val(num2);
            }          
            
        }
        function elimiar_btn(id,id_a){
            console.log(id,id_a);
            $("#div"+id).remove();
            var i = $("#cont"+id_a).val();
            var num = parseInt(i) - 1;
            $("#cont").val(num);
        }



       function guardar(cliente,fecha_labor,idagenda){
               // var formData = new FormData(document.getElementById("form_datos"));
           console.log(idagenda);
           //se valida los campos antes de guardar
            

                        
            var fecha = $('#fecha_plan'+idagenda).val();
            var cont = $('#cont'+idagenda).val();
            var cont3 = $('#cont2'+idagenda).val();
            var actividad = $('#actividad'+idagenda).val();
            var per1="";
            var per2="";
            var per3="";
            var puesto1="";
            var puesto2="";
            var puesto3="";
            var telefono1="";
            var telefono2="";
            var telefono3="";
            var correo1="";
            var correo2="";
            var correo3="";
              console.log(cont,actividad);
            
                per1=  $('#contacto'+idagenda).val();
                puesto1=  $('#puesto'+idagenda).val();
                telefono1=  $('#telefono'+idagenda).val();
                correo1=  $('#correo'+idagenda).val();
            

              if (cont==2) {
                 per1=  $('#contacto'+idagenda).val();
                puesto1=  $('#puesto'+idagenda).val();
                 telefono1=  $('#telefono'+idagenda).val();
                correo1=  $('#correo'+idagenda).val(); 

                 per2=  $('#contacto1'+idagenda).val();
                puesto2=  $('#puesto1'+idagenda).val();
                 telefono2=  $('#telefono1'+idagenda).val();
                correo2=  $('#correo1'+idagenda).val();
              }else if (cont==3) {
                per1=  $('#contacto'+idagenda).val();
                puesto1=  $('#puesto'+idagenda).val();
                 telefono1=  $('#telefono'+idagenda).val();
                correo1=  $('#correo'+idagenda).val();

                 per2=  $('#contacto1'+idagenda).val();
                 puesto2=  $('#puesto1'+idagenda).val();
                 telefono2=  $('#telefono1'+idagenda).val();
                 correo2=  $('#correo1'+idagenda).val();

                 per3=  $('#contacto2'+idagenda).val();
                 puesto3=  $('#puesto2'+idagenda).val();
                 telefono3=  $('#telefono2'+idagenda).val();
                 correo3=  $('#correo2'+idagenda).val();
               }
              // }else if (cont==4) {
              //   per1=  $('#contacto1'+idagenda).val();
              //   puesto1=  $('#puesto1'+idagenda).val();
              //   telefono1=  $('#telefono1'+idagenda).val();
              //   correo1=  $('#correo1'+idagenda).val();
                
              //    per2=  $('#contacto2'+idagenda).val();
              //    puesto2=  $('#puesto2'+idagenda).val();
              //    telefono2=  $('#telefono2'+idagenda).val();
              //    correo2=  $('#correo2'+idagenda).val();

              //    per3=  $('#contacto3'+idagenda).val();
              //    puesto3=  $('#puesto3'+idagenda).val();
              //    telefono3=  $('#telefono3'+idagenda).val();
              //    correo3=  $('#correo3'+idagenda).val();
              // }
             
             var requerimiento = $('#requerimiento'+idagenda).val();
              var otro_requerimiento = " ";
             if (requerimiento=='OTROS') {
                otro_requerimiento=$('#otro_requerimiento'+idagenda).val();
             }
             var detalle= $('#detalle'+idagenda).val();
             var act_seguimiento = $('#act_seguimiento'+idagenda).val();
             var otro_act="";
             if (act_seguimiento=='OTROS') {
                otro_act=$('#otro_act'+idagenda).val();
             }
               var responsable_segui= $('#responsable_segui'+idagenda).val();
               var correo_resp= $('#correo_resp'+idagenda).val();
               var fecha_com= $('#fecha_com'+idagenda).val();
               var indicaciones= $('#indicaciones'+idagenda).val();
               var comentarios= $('#comentarios'+idagenda).val();
               var date_range= $('#date_range'+idagenda).val();
               var hora = $('#hora'+idagenda).val();
               console.log(date_range);       
             
           console.log(fecha,actividad,per1,per2,per3,puesto1,puesto2,puesto3,telefono1,telefono2,telefono3,correo1,correo2,correo3,requerimiento,otro_requerimiento,detalle,act_seguimiento,otro_act,responsable_segui,correo_resp,fecha_com,indicaciones,comentarios,date_range,hora);

              var fecha1= validarcampo('fecha_plan'+idagenda);
              var actividad1= validarcampo('actividad'+idagenda);
              var contacto4= validarcampo('contacto'+idagenda);
              var puesto4= validarcampo('puesto'+idagenda);
              var telefono4= validarcampo('telefono'+idagenda);
              var correo4= validarcampo('correo'+idagenda);
              var requerimiento1= validarSelect('requerimiento'+idagenda);
              var detalle1= validarcampo('detalle'+idagenda);
              var act_seguimiento1= validarSelect('act_seguimiento'+idagenda);
              var responsable_segui1= validarSelect('responsable_segui'+idagenda);
              var fecha_com1= validarcampo('fecha_com'+idagenda);
              var indicaciones1= validarcampo('indicaciones'+idagenda);
              var comentarios1= validarcampo('comentarios'+idagenda);
              var date_range1= validarcampo('date_range'+idagenda);
              var hora1= validarcampo('hora'+idagenda);


              if(fecha1 == 0 || actividad1==0 || contacto4==0 || puesto4==0 || telefono4==0 || correo4==0 || requerimiento1==0 || detalle1==0 || act_seguimiento1==0 || responsable_segui1==0 || fecha_com1==0 || indicaciones1==0 || comentarios1==0 || date_range1==0 ||  hora1==0){

                swal ( "Alerta !" , "Es necesario llenar todos los campos para realizar el registro" , "error");
             }else {        
            
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
                           $.post("{{ URL::asset('registrar_plan') }}",{fecha: fecha,acti:actividad,per1:per1,per2:per2,per3:per3,puesto1:puesto1,puesto2:puesto2,puesto3:puesto3,telefono1:telefono1,telefono2:telefono2,telefono3:telefono3,correo1:correo1,correo2:correo2,correo3:correo3,requerimiento:requerimiento,otro_requerimiento:otro_requerimiento,detalle:detalle,act_seguimiento:act_seguimiento,otro_act:otro_act,responsable_segui:responsable_segui,correo_resp:correo_resp,fecha_com:fecha_com,indicaciones:indicaciones,comentarios:comentarios,date_range:date_range,cliente:cliente,fecha_labor:fecha_labor,idagenda:idagenda,hora:hora}, function(data) {
                              console.log(data);
                              if(data.valida == 1 ){
                                    swal({   title: "Registro Exitoso",   text: " ", type:"success" }
                                        // function(){   
                                        //     location.reload();
                                        // }
                                    );
                                }else{
                                    swal({   title: "Error",   text: "Error al resgistrar", type:"error" });
                                }
                           },'json');

                        }, 1000);
                    });
              }
            }

        function cargar(id_codigo,id_pais,id_oficina){
            $('#hora'+id_codigo).timepicker();

            console.log(id_pais,id_oficina);


             $.get("{{ URL::asset('consulta_usuario') }}",{pais:id_pais,oficina:id_oficina}, function(data) {
                console.log(data);
                console.log('hola');
                var trs ='';
               data.usuario.forEach(function(elemento){
                  trs=trs+ "<option  value='"+elemento.id+"' >"+elemento.usuarios+"</option>";
                    console.log(trs);             
                  
               });   
               console.log(id_codigo);             
                 // $("#us").append("<select class='custom-select' name='usuario' id='usuario'><option  value='0' selected>Seleccione una usuario</option>"+trs+"</select>");
                 $("#responsable"+id_codigo).append("<select class='custom-select' onchange='mostrar5("+id_codigo+")' name='responsable_segui' id='responsable_segui"+id_codigo+"'><option  value='' selected>Seleccione un usuario</option>"+trs+"</select>"+
                  "<div class='invalid-feedback'>"+
                  "Campo necesario !"+
                  "</div>");      
                  
            },'json');

            

            //  var f = new Date();

            //         $('#date_range'+id_codigo).daterangepicker({
            //     "locale": {
            //         "format": "YYYY-MM-DD",
            //         "separator": " - ",
            //         "applyLabel": "Guardar",
            //         "cancelLabel": "Cancelar",
            //         "fromLabel": "Desde",
            //         "toLabel": "Hasta",
            //         "customRangeLabel": "Personalizar",
            //         "daysOfWeek": [
            //             "Do",
            //             "Lu",
            //             "Ma",
            //             "Mi",
            //             "Ju",
            //             "Vi",
            //             "Sa"
            //         ],
            //         "monthNames": [
            //             "Enero",
            //             "Febrero",
            //             "Marzo",
            //             "Abril",
            //             "Mayo",
            //             "Junio",
            //             "Julio",
            //             "Agosto",
            //             "Setiembre",
            //             "Octubre",
            //             "Noviembre",
            //             "Diciembre"
            //         ],
            //         "firstDay": 1
            //     },
            //     "startDate":  f.getFullYear() + "-" + (f.getMonth() +1) + "-" +f.getDate(),
            //     "endDate": f.getFullYear() + "-" + (f.getMonth() +1) + "-"+f.getDate(),
            //      "opens": "top"
            // });

        }

        function borrar(id_venta){
             console.log(id_venta);
              swal({
                      title: "¿Seguro de Eliminar?",
                      text: "Eliminar!",
                      type: "warning",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Si, registrar!",
                      cancelButtonText: "No, cancelar!",
                      showLoaderOnConfirm: true
                    }, function () {
                        setTimeout(function () {
                           $.get("{{ URL::asset('eliminar_plan') }}",{id_agenda:id_venta}, function(data) {
                              console.log(data);
                              if(data.valida == 1 ){
                                    swal({   title: "Eliminación Exitosa",   text: " ", type:"success" }
                                        // function(){   
                                        //     location.reload();
                                        // }
                                    );
                                }else{
                                    swal({   title: "Error",   text: "Error al eliminar", type:"error" });
                                }
                           },'json');

                        }, 1000);
                    });

        }

        function cancelar(id_agenda){
           var cancelacion= $('#mot_cancelacion'+id_agenda).val();
           console.log(cancelacion);
                swal({
                      title: "¿Seguro que Deseas Cancelar?",
                      text: "Cancelar!",
                      type: "warning",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Si, registrar!",
                      cancelButtonText: "No, cancelar!",
                      showLoaderOnConfirm: true
                    }, function () {
                        setTimeout(function () {
                           $.get("{{ URL::asset('cancelar_plan') }}",{id_agenda:id_agenda,cancelacion:cancelacion}, function(data) {
                              console.log(data);
                              if(data.valida == 1 ){
                                    swal({   title: "Cancelación Exitosa",   text: " ", type:"success" }
                                        // function(){   
                                        //     location.reload();
                                        // }
                                    );
                                }else{
                                    swal({   title: "Error",   text: "Error al Cancelar", type:"error" });
                                }
                           },'json');

                        }, 1000);
                    }); 

        }
	</script>
@stop