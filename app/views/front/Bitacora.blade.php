@extends("tema.master")
@section("tittle")
	<title>Bitacora de Labor de Venta</title>
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
            

             @if ($datos)
                <table id="tabla" class="table table-dark table-bordered table-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>INFORMACIÓN DE LA BITACORA </th>
                            <th>SEGUIMIENTO DE LA ACTIVIDAD</th>
                            <th>RESPONSABLE DEL SEGUIMIENTO</th>
                            <th>FECHA LABOR DE VENTA</th>
                            <th>MOTIVO</th>
                            <th>CODIGO CLIENTE</th>
                            <th>ESTATUS DEL PLAN</th>
                            <th>CONFIRMACION DE ACTIVIDAD</th>
                            <th>COMENTARIO DE LA ACTIVIDAD</th>
                            <th>FECHA DE ENVÍO</th>
                            <th>NÚMERO DE COTIZACIÓN</th>
                            <th>FECHA_COMPROMISO</th>                            
                        </tr>
                    </thead>       
                    <tbody>
                        @foreach ($datos as $dato)
                            <tr style="background-color: #000">
                                <!-- <td><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#{{ $dato->idventa}}" >Ver Bitacora</button></td> -->
                                <td><button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#{{ $dato->idventa}}" >Información Completa</button></td>
                                @if($dato->id_user_cerrar==Session::get('id_usuario') && $dato->responsable_segui==Session::get('id_usuario'))
                                <td><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#seguimiento{{ $dato->idventa}}" >Seguimiento de la Actividad</button></td>
                                @elseif ($dato->id_user_cerrar!=Session::get('id_usuario') && $dato->responsable_segui==Session::get('id_usuario'))
                                <td><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#seguimiento{{ $dato->idventa}}" >Seguimiento de la Actividad</button></td>
                                 @elseif ($dato->id_user_cerrar==Session::get('id_usuario') && $dato->responsable_segui!=Session::get('id_usuario'))
                                  <td></td>
                                 @endif
                                <td>{{ $dato->nombre.' '.$dato->paterno.' '.$dato->materno}}</td>
                                <td>{{ $dato->fecha_labor_venta}}</td>
                                <td>{{ $dato->motivo}}</td>
                                <td>{{ $dato->cliente}}</td>
                                 <td>
                                  @if ($dato->estatus_labor==1)
                                    <span class="label" style="background-color:#5cb85c; font-size: 12px">Plan Abierto</span>
                                @elseif ($dato->estatus_labor==2)
                                    <span class="label" style="background-color:red; font-size: 12px" >Plan Cerrado</span>
                                @elseif ($dato->estatus_labor==3)
                                 <span class="label" style="background-color:#0033ff; font-size: 12px" >Plan Cancelado</span>    
                                @endif
                                </td>
                                <td>{{ $dato->confirmacion_actividad}}</td>
                                <td>{{ $dato->comentario_confirmacion}}</td>
                                <td>{{ $dato->fecha_envio}}</td>
                                <td>{{ $dato->cotizacion}}</td>
                                <td>{{ $dato->fecha_compromiso}}</td>
                            </tr>

                            <!-- Modal -->
                                <div class="modal fade" id="{{$dato->idventa}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Bitacora de Labor de Venta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>Fecha de Labor de Venta</label>
                                                    <div class="col-sm-10">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->fecha_labor_venta}}" readonly=""> 
                                                    </div>
                                                </div>
                                                 <div class="col-6">
                                                    <label>Motivo</label>
                                                    <div class="col-sm-10">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->motivo}}" readonly=""> 
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label>Cod Cliente</label>
                                                    <div class="col-sm-10">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->cliente}}" readonly=""> 
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label>Estatus</label>
                                                    <div class="col-sm-10">
                                                        @if ($dato->estatus_labor==1)
                                                        <span class="label" style="background-color:#5cb85c; font-size: 12px">Plan Abierto</span>
                                                        @elseif ($dato->estatus_labor==2)
                                                         <span class="label" style="background-color:red; font-size: 12px" >Plan Cerrado</span>
                                                        @elseif ($dato->estatus_labor==3)
                                                        <span class="label" style="background-color:#0033ff; font-size: 12px" >Plan Cancelado</span>    
                                                        @endif 
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label>Razon Social</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->razon}}" readonly=""> 
                                                    </div>
                                                </div>
                                                  <div class="col-6">
                                                    <label>Sucursal</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->sucursal}}" readonly=""> 
                                                    </div>                                                    
                                                </div>
                                                <div class="col-6">
                                                    <label>Estatus Cliente</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->estatus_cliente}}" readonly=""> 
                                                    </div>                                                    
                                                </div>
                                                <div class="col-6">
                                                    <label>Actividad Realizada</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->actividad}}" readonly=""> 
                                                    </div>                                                    
                                                </div>
                                                <div class="row">
                                                   <div class="col-12">
                                                        <hr class="dividir"></hr>
                                                   </div>                                                   
                                                <div class="col-6">
                                                    
                                                    <label>Persona Contactada</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->persona_contacto}}" readonly=""> 
                                                    </div>                                                    
                                                </div>
                                                <div class="col-6">
                                                    <label>Puesto</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->puesto}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Telefono</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->telefono}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Correo</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->puesto}}" readonly="">
                                                    </div>                                           
                                                </div>

                                                <div class="col-6">
                                                    <label>Persona Contactada 2</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->persona_contacto1}}" readonly=""> 
                                                    </div>                                                    
                                                </div>
                                                <div class="col-6">
                                                    <label>Puesto 2</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->puesto1}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Telefono 2</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->telefono1}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Correo 2</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->correo1}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Persona Contactada 3</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->persona_contacto2}}" readonly=""> 
                                                    </div>                                                    
                                                </div>
                                                <div class="col-6">
                                                    <label>Puesto 3</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->puesto2}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Telefono 3</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->telefono2}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Correo 3</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->correo2}}" readonly="">

                                                    </div>                                           
                                                </div>
                                                 <div class="col-12">
                                                        <hr class="dividir"></hr>
                                                   </div>
                                                </div>
                                                  <div class="col-6">
                                                    <label>Requerimiento</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->requerimiento}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                 <div class="col-6">
                                                    <label>Detalle</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->detalle}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Actividad de Seguimiento</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->act_seguimiento}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Responsable del Seguimiento</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->nombre.' '.$dato->paterno.' '.$dato->materno}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Correo del Responsable</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->correo_rep}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Fecha Compromiso</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->fecha_com}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Indicaciones</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->indicaciones}}" readonly="">
                                                    </div>                                           
                                                </div> 
                                                <div class="col-6">
                                                    <label>Comentarios</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->comentarios}}" readonly="">
                                                    </div>                                           
                                                </div>                                                 
                                                 <div class="col-6">
                                                    <label>Fecha de Creación del Plan</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->fecha_creacion}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                 <div class="col-6">
                                                    <label>Fecha del Cierre. del Plan</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->fecha_cierre}}" readonly="">
                                                    </div>                                           
                                                </div>

                                                <div class="col-6">
                                                    <label>Fecha del Prox. Plan</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->fecha_prox}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Confirmacion de Actividad</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->confirmacion_actividad}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Comentario de Actividad</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->comentario_confirmacion}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>fecha de Envío</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->fecha_envio}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Número de Cotizacion</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->cotizacion}}" readonly="">
                                                    </div>                                           
                                                </div>
                                                <div class="col-6">
                                                    <label>Fecha Compromiso</label>
                                                    <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="" value="{{ $dato->fecha_compromiso}}" readonly="">
                                                    </div>                                           
                                                </div>

                                            </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                      
                                      </div>
                                    </div>
                                  </div>
                                </div>
                          

                                <!-- Modal siguimiento de labor de venta -->
                        <div class="modal fade" id="seguimiento{{$dato->idventa}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">SEGUIMIENTO - {{ $dato->fecha_labor_venta}} - {{ $dato->cliente}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Fecha de Labor de Venta</label>
                                            <div class="col-sm-12">
                                               <input type="text" class="form-control" id="" value="{{ $dato->fecha_labor_venta}}" readonly=""> 
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label>Requerimiento del Cliente</label>
                                            <div class="col-sm-12">
                                               <input type="text" class="form-control" id="" value="{{ $dato->requerimiento}}" readonly="">
                                            </div>                                           
                                        </div>

                                        <div class="col-6">
                                            <label>Correo del Responsable</label>
                                            <div class="col-sm-12">
                                               <input type="text" class="form-control" id="" value="{{ $dato->correo_rep}}" readonly="">
                                            </div>                                           
                                        </div>
                                        <div class="col-6">
                                            <label>Motivo</label>
                                            <div class="col-sm-12">
                                               <input type="text" class="form-control" id="" value="{{ $dato->motivo}}" readonly=""> 
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label>Detalle del Requerimiento</label>
                                            <div class="col-sm-12">
                                               <input type="text" class="form-control" id="" value="{{ $dato->detalle}}" readonly="">
                                            </div>                                           
                                        </div>
                                        <div class="col-6">
                                            <label>Responsable del Seguimiento</label>
                                            <div class="col-sm-12">
                                               <input type="text" class="form-control" id="" value="{{ $dato->nombre.' '.$dato->paterno.' '.$dato->materno}}" readonly="">
                                            </div>                                           
                                        </div>
                                        <div class="col-12"><hr class="dividir"></div>
                                        <div class="col-6">
                                            <label>¿La Actividad de Seguimiento se Realizó Satisfactoriamente?</label>
                                            <div class="col-sm-12">
                                               <select class="custom-select " name="respuesta" id="respuesta{{$dato->idventa}}" onchange="mostrar1('{{$dato->idventa}}')" >  
                                                    <option value="" selected="">Selecciones una opción</option>
                                                    <option value="REALIZADA">SI</option>
                                                    <option value="NO REALIZADA">NO</option>                                                    
                                                </select>
                                                <div class="invalid-feedback">
                                                Campo necesario !
                                              </div>                   
                                            </div>
                                        </div>
                                          <div class="col-6" id="comentario{{$dato->idventa}}" style="display: none;">
                                            <label>Comentario del Seguimiento</label>
                                            <div class="col-sm-12">
                                              <textarea class="form-control" id="mot_comentario{{$dato->idventa}}"></textarea>
                                                <div class="invalid-feedback">
                                                Campo necesario !
                                              </div>                   
                                            </div>
                                        </div>
                                        <div class="col-6" id="fecha_en{{$dato->idventa}}" style="display: none;">
                                            <label>Fecha de Envío</label>
                                            <div class="col-sm-12">
                                              <input type="Date" class="form-control" name="fecha_envio" id="fecha_envio{{$dato->idventa}}">
                                                <div class="invalid-feedback">
                                                Campo necesario !
                                              </div>                   
                                            </div>
                                        </div>
                                        <div class="col-6" id="coti{{$dato->idventa}}" style="display: none;">
                                            <label>Número de Cotización</label>
                                            <div class="col-sm-12">
                                              <input type="text" class="form-control" name="cotizacion" id="cotizacion{{$dato->idventa}}">
                                                <div class="invalid-feedback">
                                                Campo necesario !
                                              </div>                   
                                            </div>
                                        </div>
                                        <div class="col-6" id="compromiso{{$dato->idventa}}" style="display: none;">
                                            <label>Fecha de Nuevo Compromiso</label>
                                            <div class="col-sm-12">
                                              <input type="Date" class="form-control" name="compromiso" id="compromisos{{$dato->idventa}}">
                                                <div class="invalid-feedback">
                                                Campo necesario !
                                              </div>                   
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-success" onclick="guardar_seguimiento('{{ $dato->idventa }}')">Cerrar Seguimiento</button>
                              </div>
                            </div>
                          </div>
                        </div>
                       <!-- </div>  -->                         
                        @endforeach
                    </tbody>

                    <tfoot>
                      <tr>
                            <th></th>
                            <th></th>
                            <th>USUARIO</th>
                            <th>FECHA LABOR DE VENTA</th>
                            <th>MOTIVO</th>
                            <th>CODIGO CLIENTE</th>
                            <th>ESTATUS DEL PLAN</th>
                            <th>CONFIRMACION DE ACTIVIDAD</th>
                            <th>COMENTARIO DE LA ACTIVIDAD</th>
                            <th>FECHA DE ENVÍO</th>
                            <th>NÚMERO DE COTIZACIÓN</th>
                            <th>FECHA_COMPROMISO</th>
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
	
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
    {{HTML::script("//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js", array("type" => "text/javascript"))}}

    
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
             //     "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             //    }
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

       function mostrar1(id){
       var respuesta= $("#respuesta"+id).val();
       console.log(id,respuesta);
       // document.getElementById("comentario"+id).innerHTML = " ";
      if (respuesta=='REALIZADA') {
        $("#comentario"+id).show();
        $("#fecha_en"+id).show();
        $("#coti"+id).show();
        $("#compromiso"+id).hide();
      }else{
        $("#comentario"+id).show();
        $("#fecha_en"+id).hide();
        $("#coti"+id).hide();
        $("#compromiso"+id).show();
      }

     }
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

        function guardar_seguimiento(id){
           console.log(id);
           var respuesta=  validarcampo('respuesta'+id);
           var respuesta1= $("#respuesta"+id).val();
           var comentario1="";
           var fecha_envio="";
           var cotizacion="";
           var compromiso="";
               if (respuesta1=="REALIZADA") {                 
                  comentario1= $("#mot_comentario"+id).val();
                  fecha_envio= $("#fecha_envio"+id).val();
                  cotizacion=$("#cotizacion"+id).val();                 
               }else {
                 comentario1= $("#mot_comentario"+id).val();
                 compromiso=$("#compromisos"+id).val();
               }

               console.log(respuesta1,comentario1,fecha_envio,cotizacion,compromiso);
         
         if( respuesta == 0 ){

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
                           $.post("{{ URL::asset('registrar_seguimiento') }}",{respuesta:respuesta1,comentario:comentario1,fecha_envio:fecha_envio,cotizacion:cotizacion,compromiso:compromiso,id:id}, function(data) {
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
   
	</script>
@stop