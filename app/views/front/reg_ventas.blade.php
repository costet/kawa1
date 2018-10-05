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
    #mostrar{
        display: none;
    }

</style>
<link href="tabla/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="tabla/buttons.bootstrap.min.css" rel="stylesheet">
@section("titulo")
@stop
@section("contenido")
	<div class="card">
        <div class="card-body">
            
            <?php $a=0; ?>
            @if (Session::get('datos'))
                <?php 
                    $datos = Session::get('datos') ; 
                    $mercado = Session::get('mercado');
                    $cuidad = Session::get('cuidadess');
                    $area_venta_ = Session::get('area_de_venta');
                    $estatus_deta = Session::get('estatus_deta');
                    $cat_estados = Session::get('cat_estados');
                    $cat_paises = Session::get('cat_pais');
                    $estatus = Session::get('estatus');
                    $a=1;
                ?>
            @else
                @if (isset($datos))
                    
                     <?php 
                        $datos =$datos ; 
                        $mercado = $mercado;
                        $cuidad = $cuidadess;
                        $area_venta_ = $area_de_venta;
                        $estatus_deta = $estatus_deta;
                        $cat_estados =$cat_estados;
                        $cat_paises = $cat_pais;
                        $a=1; 

                     ?>
                @endif
            @endif
            <?php $asig_user = Permisos::permiso(Session::get('id_usuario') , 5 );  ?>
            {{-- @if ($a==1) --}}
                <div class="offset-md-4 offset-sm-4 ">
                    <form class="form-inline" action="{{ URL::asset('consulta') }}" method="post">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="" class="sr-only">Cuidad</label>
                            <select class="custom-select " name="id_of" id="cuidad" >  
                                <option value="0">Selecciones un cuidad</option>
                                @foreach ($cuid as $ele)
                                    <option value="{{$ele->id}}">{{$ele->cuidad}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger mb-2">Buscar Clientes</button>
                    </form>
                </div>
           {{--  @else
            <div class="col-md-5">
                <div class="alert alert-danger" role="alert">
                    Sin datos que mostrar
                </div>
            </div>
    

            @endif --}}
    
            @if ($a==1)
                <div class="table-responsive">
                    <table id="tabla" class="table table-dark table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>VER INFO. COMPLETA</th>
                                <th>AGENDAR ACTIVIDAD</th>
                                <th>PAIS</th>
                                <th>CODIGO UNICO</th>
                                <th>CODIGO_CLIENTE</th>
                                <th>RAZON</th>
                                <th>NOMBRE COMERCIAL</th>
                                <th>SUCURSAL</th>
                                <th>MERCADO</th>
                                <th>SEGMENTO</th>
                                <th>OFICINA</th>
                                <th>ESTATUS</th>
                                <th>ESTATUS DETALLE</th>
                                <th>ÁREA VENTA</th>
                            </tr>
                        </thead>       
                        <tbody>
                            @if (Permisos::permiso(Session::get('id_usuario') , 3 ))
                                <?php 
                                    $mostrar = ''; 
                                    $mostrar2 = ''; 
                                    $mostar = true;

                                ?>
                            @else
                                 <?php 
                                    $mostrar = '<fieldset disabled>'; 
                                    $mostrar2 = '</fieldset>'; 
                                    $mostar = false;

                                 ?>
                            @endif
                            <?php  $permiso= Permisos::permiso(Session::get('id_usuario') , 4 ); ?>
                            @foreach ($datos as $dato)
                                <tr style="background-color: #000">
                                    <td> <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target=".{{ $dato->cod_unico }}">Ver info. completa</button> </td>
                                    <td> <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#{{ $dato->cod_unico }}" onclick="usuario_asignado('{{$dato->cod_unico}}')">Agendar Actividad</button> </td>
                                    <td>{{ $dato->pais }}</td>
                                    <td>{{ $dato->cod_unico}}</td>
                                    <td>{{ $dato->cod_cliente}}</td>
                                    <td>{{ $dato->razon}}</td>
                                    <td>{{ $dato->nombre_comercial}}</td>
                                    <td>{{ $dato->sucursal }}</td>
                                    <td>{{ $dato->mercado }}</td>                            
                                    <td>
                                        @if ($dato->id_mercado == 14 )
                                            {{ $dato->otro }}
                                        @else
                                            {{ $dato->producto }}
                                        @endif
                                        
                                    </td>                            
                                    <td>{{ $dato->oficina }}</td>                            
                                    <td>{{ $dato->estatus }}</td>                            
                                    <td>{{ $dato->es_de }}</td>                            
                                    <td>{{ $dato->area }}</td>                            
                                </tr>
                             <!--Inicia Modal agenda labor de venta -->
                                    <div class="modal fade" id="{{ $dato->cod_unico }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                      <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Agendar Actividad Labor de venta - {{ $dato->cod_unico }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row">
                                            <div class="col-6">
                                                 <label>Fecha de Labor de Venta</label>
                                                <div class="col-sm-10">
                                                   <input type="Date" id="date_range{{$dato->cod_unico}}" name="desde" class="form-control">
                                                   <input type="hidden" name="id_pais1" id="id_pais1" value="{{$dato->id_pais}}">
                                                   <input type="hidden" name="id_codigo" id="id_codigo{{$dato->cod_unico}}" value="{{$dato->cod_unico}}">
                                                    <input type="hidden" name="id_pais1" id="id_oficina_central" value="{{$dato->id_oficina_central}}">
                                                    <div class="invalid-feedback">
                                                        Campo necesario !
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="col-6">
                                                 <label>Hora de Labor de Venta</label>
                                                <div class="col-sm-10">
                                                   <input  id="hora{{$dato->cod_unico}}" name="desde" class="form-control">
                                                   <div class="invalid-feedback">
                                                        Campo necesario !
                                                    </div>               
                                                </div>
                                            </div>                                        
                                            <div class="col-6">
                                                <label>* Motivo del plan labor de venta</label>
                                                <div class="col-sm-10">
                                                  <select class="custom-select " name="motivo" id="motivo{{ $dato->cod_unico }}" required="" onchange="vali('{{$dato->cod_unico}}')">  
                                                            <option value="0">Selecciones un motivo</option>
                                                            <option value="PLAN LABOR DE VENTA">PLAN LABOR DE VENTA</option>
                                                            <option value="SEGUIMIENTO A COTIZACION">SEGUIMIENTO A COTIZACIÓN</option> 
                                                            <option value="LEVANTAMIENTO DE INFORMACION">LEVANTAMIENTO DE INFORMACIÓN</option>
                                                            <option value="PROSPECCION CLIENTE NUEVO">PROSPECCIÓN CLIENTE NUEVO</option>
                                                            <option value="OTRO">OTRO</option>                    
                                                        </select>  
                                                     <div class="invalid-feedback">
                                                        Campo necesario !
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6" id="mostrar{{ $dato->cod_unico }}" style="display: none;border: 2px solid #ef8181;"></div>
                                            <div class="col-6">
                                                 <label>* Razon social / nombre del cliente</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="razon" placeholder="Razon social / nombre del cliente" name="razon" value="{{ $dato->razon}}" readonly="">
                                                        <div class="invalid-feedback">
                                                            Campo necesario !
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-6">
                                                  <label>* Nombre comerciaL</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="nom_comercial" placeholder="Nombre comercial" name="nom_comercial" onkeyup="" value="{{ $dato->nombre_comercial}}" readonly="">
                                                            <div class="invalid-feedback">
                                                                Campo necesario !
                                                            </div>
                                                        </div>
                                                </div>
                                                 <div class="col-6">
                                                  <label>* Sucursal o planta del cliente</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="sucursal" placeholder="Sucursal o planta del cliente" name="sucursal" onkeyup="" value="{{$dato->sucursal}}" readonly="">
                                                            <div class="invalid-feedback">
                                                                Campo necesario !
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="col-6">
                                                    <label>Estatus</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="sucursal" placeholder="" name="sucursal" value="{{$dato->estatus}}" onkeyup="" readonly="">

                                                            <div class="invalid-feedback">
                                                                Campo necesario !
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($asig_user) 
                                                       <div class="col-6">
                                                        <label>Asignar usuario</label>
                                                           <div class="col-sm-10">                                                      
                                                                <div id="tabla{{ $dato->cod_unico }}"></div>
                                                             <div class="invalid-feedback">
                                                                Campo necesario !
                                                            </div>   
                                                           </div>                                                   
                                                       </div>
                                                   @else
                                                       <div class="col-6">
                                                            <label>Asignar usuario</label>
                                                            <div class="col-sm-10">
                                                             <div id="tabla1{{ $dato->cod_unico }}">                                  
                                                                <select class="custom-select" name="usuario" id="usuario{{ $dato->cod_unico }}">
                                                                    <option  value="{{Session::get('id_usuario')}}" selected>El usuario se asigno autom.</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        </div>
                                                   @endif    

                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-danger" onclick="guardar('{{ $dato->cod_unico }}')">Agendar</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                               <!-- termina  Modal agenda labor de venta -->     


                                <div class="modal fade {{ $dato->cod_unico }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Información de {{$dato->nombre_comercial}} </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-row" id="form_datos{{$dato->id}}" action="{{ URL::asset('actualizar_cliente') }}" method="post">
                                                    {{ $mostrar }}
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6">
                                                            
                                                            <div class="form-group col-md-12">
                                                                <label for="">Código Cliente</label>
                                                                
                                                                    <input type="text" class="form-control" id="cod_cliente" placeholder="Código Cliente" name="cod_cliente" value="{{ $dato->cod_cliente}}" >
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                    </div>
                                                                
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="">* Razon social / nombre del cliente</label>                                                            
                                                                    <input type="text" class="form-control" id="razon{{$dato->id}}" placeholder="Razon social / nombre del cliente" name="razon" value="{{ $dato->razon}}" >
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                    </div>                                                            
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="" >* Nombre comercial</label>                                                            
                                                                    <input type="text" class="form-control" id="nom_comercial{{$dato->id}}" placeholder="Nombre comercial" name="nom_comercial" onkeyup="" value="{{ $dato->nombre_comercial}}">
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                    </div>                                                            
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="" >* Sucursal o planta del cliente</label>                                                            
                                                                    <input type="text" class="form-control" id="sucursal{{$dato->id}}" placeholder="Sucursal o planta del cliente" name="sucursal" onkeyup="" value="{{$dato->sucursal}}">
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                    </div>
                                                                
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="" >* País</label>
                                                                
                                                                    @if (count($pais) > 1)
                                                                        <select class="custom-select " disabled="" name="pais" id="pais{{$dato->id}}" onchange="buscarMercado(this.value,'{{$dato->id}}')">  
                                                                            <option value="{{ $dato->id_pais }}">{{ $dato->pais }}</option>
                                                                            <optgroup >
                                                                                @foreach ($pais as $paises)
                                                                                    <option value="{{ $paises->id }}">{{ $paises->pais }}</option>
                                                                                @endforeach 
                                                                            </optgroup>                      
                                                                        </select>
                                                                        <input type="hidden"  name="pais" value="{{ $dato->id_pais }}">
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    @else
                                                                        <input type="text" class="form-control" readonly=""  placeholder="" name="pais2" value="{{ $pais[0]->pais }}">
                                                                        <input type="hidden" id="pais{{$dato->id}}" name="pais" value="{{ $dato->id_pais }}">
                                                                    @endif
                                                                
                                                            </div> 
                                                            
                                                            <div class="form-group col-md-12">
                                                                <label for="" >* Mercado</label>
                                                                
                                                                <img src="{{ URL::asset('img/loading.gif') }}" id='img_mercado{{$dato->id}}' class="img-responsive" width="40px" style="display: none;">
                                                                
                                                                    <select class="custom-select " name="mer" id="mercado{{$dato->id}}" onchange="buscarSegmento(this.value,'{{$dato->id}}')">
                                                                        <option value="{{ $dato->id_mercado }}">{{ $dato->mercado }}</option>
                                                                        <optgroup >
                                                                            @foreach ($mercado as $mercadoo)
                                                                                <option value="{{ $mercadoo->id }}">{{ $mercadoo->mercado }}</option>
                                                                            @endforeach 
                                                                        </optgroup>
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                            </div>
                                                                   
                                                                
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="" >* Segmento</label>
                                                                
                                                                   <img src="{{ URL::asset('img/loading.gif') }}" id='img_segmento{{$dato->id}}' class="img-responsive" width="40px" style="display: none;">
                                                                    {{-- <div id="segmento{{$dato->id}}"> --}}
                                                                        @if ( $dato->id_mercado != 14 )
                                                                            <?php $estilo1 = 'style="display: none;" ' ; ?>
                                                                            <?php $estilo2 = '' ; $ban=0; ?>
                                                                        @else
                                                                           <?php $estilo1 = '' ; ?>
                                                                           <?php $estilo2 = 'style="display: none;" ';  $ban=1; ; ?>
                                                                        @endif
                                                                        <select class="custom-select " name="seg" id="segmento{{$dato->id}}" {{ $estilo2 }}> 
                                                                                <option value="{{ $dato->id_segmento }}">{{ $dato->producto }}</option>
                                                                        </select>
                                                                         <input type='text' class='form-control' {{ $estilo1 }} id='otro{{$dato->id}}' placeholder='Otro' name='otro' value="{{ $dato->otro }}">
                                                                        
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>

                                                                        <input type="hidden" name="bandera" id="bandera{{$dato->id}}" value="{{ $ban }}">
                                                                        
                                                                    {{-- </div> --}}
                                                                
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="" >* Oficina Responsable</label>
                                                                <img src="{{ URL::asset('img/loading.gif') }}" id='img_segmento{{$dato->id}}' class="img-responsive" width="40px" style="display: none;">
                                                               
                                                                {{-- <div id="oficina{{$dato->id}}"> --}}
                                                                    <select class="custom-select " name="oficina" id="oficina{{$dato->id}}" onchange="mostrarzona(this.value,{{ $dato->id }})" >    
                                                                        <option value="{{ $dato->id_oficina_central }}">{{ $dato->oficina }}</option>
                                                                        <optgroup >
                                                                            @foreach ($cuidad as $element)
                                                                                <option value="{{ $element->id }}">{{ $element->oficina }}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                    </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="" >Estatus</label>
                                                                    
                                                                        <select class="custom-select " name="estatus_client" id="estatus_client">
                                                                            @if ( ! is_null($dato->estatus ))
                                                                                <option value="{{$dato->id_estatus}}">{{$dato->estatus}}</option>
                                                                            @else
                                                                                <option value="0">Seleccione un Estatus</option>
                                                                           @endif   
                                                                            <optgroup> 
                                                                                @foreach ($estatus as $estatu)
                                                                                    <option value="{{ $estatu->id }}">{{ $estatu->estatus }}</option>
                                                                                @endforeach
                                                                            </optgroup>
                                                                        </select>
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="" >Zona</label>
                                                                    
                                                                        {{-- @if (count($pais) > 1)
                                                                            <input type="text" class="form-control" id="zona{{$dato->id}}" placeholder="" name="zona" value="{{ $dato->zona }}" readonly="" >
                                                                        @else --}}
                                                                            @if ($dato->id_pais == 1 )
                                                                                <input type="text" class="form-control" readonly="" id="zona{{$dato->id}}" placeholder="" name="zona" value="{{ $dato->zona }}" >
                                                                            @else
                                                                                <input type="text" class="form-control" id="zona{{$dato->id}}" placeholder="" name="zona" value="{{ $dato->zona }}" >
                                                                            @endif
                                                                            
                                                                        {{-- @endif --}}
                                                                        
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                
                                                                <div class="form-group col-md-12">
                                                                    <label for="">Área de venta</label>

                                                                        @if ($permiso)
                                                                            
                                                                            <select class="custom-select " name="area_de_venta" id="area_de_venta" onchange="most_cli(this.value,{{$dato->id}})">
                                                                                @if ( ! is_null($dato->area ))
                                                                                    <option value="{{$dato->area_venta}}">{{$dato->area}}</option>
                                                                                @else
                                                                                    <option value="0">Seleccione un Area de venta</option>
                                                                                @endif   
                                                                                <optgroup> 
                                                                                    @foreach ( $area_venta_ as $area_de_vent)
                                                                                        <option value="{{ $area_de_vent->id }}">{{ $area_de_vent->area }}</option>
                                                                                    @endforeach
                                                                                </optgroup>
                                                                            </select>
                                                                        @else

                                                                            <select class="custom-select " name="area_de_venta" id="area_de_venta" >
                                                                                <option value="{{$dato->area_venta}}">{{$dato->area}}</option>
                                                                                 @if ($dato->id_pais != 1 )
                                                                                    @foreach ( $area_venta_ as $area_de_vent)
                                                                                        <option value="{{ $area_de_vent->id }}">{{ $area_de_vent->area }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        @endif
                                                                        
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <?php $verr = ''; ?>
                                                                    @if ($dato->area_venta != 19 )
                                                                        <?php $verr=' style="display: none" ' ?>
                                                                    @endif
                                                                    <div id="cliente_dis{{$dato->id}}" {{$verr}}>
                                                                        <label for="">Cliente de distribuidor</label>
                                                                        <input type="text" class="form-control" id="cliente_d{{$dato->id}}" placeholder="CLIENTE DE DISTRIBUIDOR" name="cliente_d" value="{{ $dato->cliente_dis }}" >
                                                                    </div>                                                               
                                                                </div>
                                                                @if ($permiso)
                                                                    @if ($dato->id_pais == 1)
                                                                        <div class="form-group col-md-12">
                                                                            <label for="">Estatus detalle</label>
                                                                               
                                                                                <select class="custom-select " name="estatus_detalle" id="estatus_detalle">
                                                                                    @if ( ! is_null($dato->es_de ))
                                                                                        <option value="{{$dato->id_estatus_detalle}}">{{$dato->es_de}}</option>
                                                                                    @else
                                                                                        <option value="0">Seleccione un Estatus</option>
                                                                                    @endif   
                                                                                    <optgroup> 
                                                                                        @foreach ($estatus_deta as $estatus_de)
                                                                                            <option value="{{ $estatus_de->id }}">{{ $estatus_de->estatus }}</option>
                                                                                        @endforeach
                                                                                    </optgroup>
                                                                                </select>
                                                                                <div class="invalid-feedback">
                                                                                    Campo necesario !
                                                                                </div>
                                                                        </div>
                                                                        <div class="form-group col-md-12">
                                                                            <label for="" >Fecha estatus</label>
                                                                            
                                                                                <input type="date" class="form-control" id="fecha_esta{{$dato->id}}" placeholder="Fecha Estatus" name="fecha_esta" value="{{ $dato->fecha_estatus}}">
                                                                                <div class="invalid-feedback">
                                                                                    Campo necesario !
                                                                                </div>
                                                                            
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6 col-sm-6">
                                                            
                                                            @if ($dato->id_pais == 1 )
                                                              
                                                                @if ($mostar )
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="">Calle</label>
                                                                            <input type="text" class="form-control" placeholder="Calle" name="calle" id="calle" value="{{ $dato->calle }}"> 
                                                                            <div class="invalid-feedback">
                                                                                Campo necesario !
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="">Número</label>
                                                                            <input type="text" class="form-control" placeholder="Número" name="no" id="no" value="{{ $dato->numero }}">
                                                                            <div class="invalid-feedback">
                                                                                Campo necesario !
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="">Colonia</label>
                                                                            <input type="text" class="form-control" id="colonia" placeholder="Colonia" name="col" value="{{  $dato->colonia  }}">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="">Código postal</label>
                                                                            <input type="number" class="form-control" id="tags" placeholder="Código Postal" name="cp" {{-- onkeyup="buscar(this.value)" --}} min="0" value="{{ $dato->cp  }}">
                                                                            <div class="invalid-feedback">
                                                                                Campo necesario !
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="">Municipio</label>
                                                                            <input type="text" class="form-control" id="muni"  placeholder="Municipio" name="muni" value="{{ $dato->municipio }}">
                                                                        </div>
                                                                        <div class='form-group col-md-6'>
                                                                            <label>Estado</label>
                                                                            <select class='custom-select ' name='estado' id='estado' onchange="most_otro(this.value,{{$dato->id}})">
                                                                                <option value='{{$dato->id_estado}}'>{{ ($dato->id_estado == 32) ? $dato->otr : $dato->estado }}</option>
                                                                                <optgroup>
                                                                                @foreach ($cat_estados  as $cat_es)
                                                                                    <option value='{{ $cat_es->id }}'>{{ $cat_es->estado }}</option>
                                                                                @endforeach
                                                                                </optgroup>
                                                                            </select>
                                                                            <div class='invalid-feedback'>Campo necesario !</div>
                                                                        </div>
                                                                        <div class="form-group col-md-6" id='otro_pais{{$dato->id}}' style="display: none">
                                                                            <label>OTRO</label>
                                                                            <input type='text' class='form-control' id='otro_es'  placeholder='Estado' name='otro_es' >
                                                                            <div class='invalid-feedback'>
                                                                                Campo necesario !
                                                                            </div>
                                                                        </div>
                                                                        <div class='form-group col-md-6'>
                                                                            <label for="">País</label>
                                                                            <select class="custom-select " name="pais_cli" id="pais_cli">   
                                                                                <option value='{{$dato->id_ppa}}'>{{$dato->ppais}}</option>
                                                                                <optgroup>
                                                                                @foreach ($cat_paises as $cat_pai)
                                                                                    <option value="{{ $cat_pai->id }}">{{ $cat_pai->pais }}</option>
                                                                                @endforeach
                                                                                </optgroup>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                                Campo necesario !
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="form-group col-md-6">
                                                                            <label for="">Estado</label>
                                                                            <input type="text" class="form-control" id="estado"  placeholder="Estado" name="estado" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->id_estado : '' }}" >
                                                                        </div> --}}
                                                                             
                                                                    </div>
                                                                @else
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12">
                                                                            <label for="">DIRECCIÓN</label>
                                                                            <textarea class="form-control" name="direccion" id="direccion" rows="4">
                                                                                {{  $dato->calle. ' '.$dato->numero.' '.$dato->colonia.' '.$dato->cp.' '.$dato->municipio  }}
                                                                                {{ ($dato->id_estado == 32) ? $dato->otr : $dato->estado }}, {{ $dato->ppais }}
                                                                              
                                                                            </textarea>
                                                                            
                                                                            <div class="invalid-feedback">
                                                                                Campo necesario !
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                
                                                            @else
                                                                
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-8">
                                                                        <label for="">DIRECCIÓN</label>
                                                                        <textarea class="form-control" name="direccion" id="direccion" rows="4">
                                                                            {{ $dato->direccion }}
                                                                        </textarea>
                                                                        {{-- <input type="text" class="form-control" placeholder="Dirección" name="direccion" id="direccion" value=""> --}}
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="">Provincia</label>
                                                                        <input type="text" class="form-control" placeholder="Provincia" name="provincia" id="provincia" value="{{ $dato->provincia }}">
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            @endif
                                                            <?php $contactos = DB::select("select * from contactos where id_cliente=".$dato->id); $i=0; ?>

                                                            <nav>
                                                              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                <?php $i=1; ?>
                                                                 @foreach ($contactos as $contacto)
                                                                    @if ($i==1)
                                                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#{{$dato->id.$i}}" role="tab" aria-controls="{{$dato->id.$i+1}}" aria-selected="true">Contacto {{ $i }}</a>
                                                                    @else
                                                                        <a class="nav-item nav-link " id="{{$dato->id.$i+1}}-tab" data-toggle="tab" href="#{{$dato->id.$i}}" role="tab" aria-controls="{{$contacto->id}}" aria-selected="true">Contacto {{ $i }}</a>
                                                                    @endif
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                                @for ($j = $i ; $j <= 3 ; $j++)
                                                                    @if ($j==1)
                                                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#{{$dato->id.$j}}" role="tab" aria-controls="{{$dato->id.$j}}" aria-selected="true">Contacto {{ $j }}</a>
                                                                    @else
                                                                        <a class="nav-item nav-link " id="{{$dato->id.$j}}-tab" data-toggle="tab" href="#{{$dato->id.$j}}" role="tab" aria-controls="{{$dato->id.$j}}" aria-selected="true">Contacto {{ $j }}</a>
                                                                    @endif
                                                                @endfor
                                                              </div>
                                                            </nav>
                                                            <div class="tab-content" id="nav-tabContent">
                                                                <?php $i=1; ?>
                                                                @foreach ($contactos as $contacto)
                                                                    @if ($i==1)
                                                                        <div class="tab-pane fade show active" id="{{$dato->id.$i}}" role="tabpanel" aria-labelledby="{{$dato->id.$i}}-tab">
                                                                            <div class="card bg-light mb-3" style="max-width: 18rem; height: auto">
                                                                                <div class="card-header">{{ $contacto->nombre }}</div>
                                                                                    <div class="card-body">
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="user"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='nom_contac{{ $i }}' class="form-control" id="" placeholder="Nombre del contacto" value="{{ $contacto->nombre}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="credit-card"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='car_contac{{ $i }}' class="form-control" id="" placeholder="Cargo" value="{{ $contacto->cargo }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="phone"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='tel_contac{{ $i }}' class="form-control" id="" placeholder="Télefono" value="{{ $contacto->tel }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="smartphone"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='mov_contac{{ $i }}' class="form-control" id="" placeholder="Télefono Movil" value="{{ $contacto->cel }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="mail"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='correo_contac{{ $i }}' class="form-control" id="" placeholder="Correo" value="{{ $contacto->correo }}">
                                                                                            </div>
                                                                                        </div>
                                                                                       
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="tab-pane fade" id="{{$dato->id.$i}}" role="tabpanel" aria-labelledby="nav-home-tab">
                                                                            <div class="card bg-light mb-3" style="max-width: 18rem; height: auto">
                                                                                <div class="card-header">{{ $contacto->nombre }}</div>
                                                                                    <div class="card-body">
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="user"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='nom_contac{{ $i }}' class="form-control" id="" placeholder="Nombre del contacto" value="{{ $contacto->nombre}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="credit-card"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='car_contac{{ $i }}' class="form-control" id="" placeholder="Cargo" value="{{ $contacto->cargo }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="phone"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='tel_contac{{ $i }}' class="form-control" id="" placeholder="Télefono" value="{{ $contacto->tel }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="smartphone"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='mov_contac{{ $i }}' class="form-control" id="" placeholder="Télefono Movil" value="{{ $contacto->cel }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="mail"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='correo_contac{{ $i }}' class="form-control" id="" placeholder="Correo" value="{{ $contacto->correo }}">
                                                                                            </div>
                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                                @for ($j = $i ; $j <= 3 ; $j++)
                                                                    @if ($j==1)
                                                                        <div class="tab-pane fade show active" id="{{$dato->id.$j}}" role="tabpanel" aria-labelledby="{{$dato->id.$j}}-tab">
                                                                            <div class="card bg-light mb-3" style="max-width: 18rem; height: auto">
                                                                                <div class="card-header"></div>
                                                                                    <div class="card-body">
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="user"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='nom_contac{{ $j }}' class="form-control" id="" placeholder="Nombre del contacto" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="credit-card"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='car_contac{{ $j }}' class="form-control" id="" placeholder="Cargo" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="phone"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='tel_contac{{ $j }}' class="form-control" id="" placeholder="Télefono" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="smartphone"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='mov_contac{{ $j }}' class="form-control" id="" placeholder="Télefono Movil">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="mail"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='correo_contac{{ $j }}' class="form-control" id="" placeholder="Correo">
                                                                                            </div>
                                                                                        </div>
                                                                                       
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="tab-pane fade" id="{{$dato->id.$j}}" role="tabpanel" aria-labelledby="nav-home-tab">
                                                                            <div class="card bg-light mb-3" style="max-width: 18rem; height: auto">
                                                                                <div class="card-header"></div>
                                                                                    <div class="card-body">
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="user"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='nom_contac{{ $j }}' class="form-control" id="" placeholder="Nombre del contacto" value="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="credit-card"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='car_contac{{ $j }}' class="form-control" id="" placeholder="Cargo" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="phone"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='tel_contac{{ $j }}' class="form-control" id="" placeholder="Télefono" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="smartphone"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='mov_contac{{ $j }}' class="form-control" id="" placeholder="Télefono Movil" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <div class="input-group mb-2">
                                                                                                <div class="input-group-prepend">
                                                                                                    <div class="input-group-text"><span data-feather="mail"></span></div>
                                                                                                </div>
                                                                                                <input type="text" name='correo_contac{{ $j }}' class="form-control" id="" placeholder="Correo">
                                                                                            </div>
                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endfor

                                                                
                                                              
                                                              
                                                            </div>                                                      
                                                            
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="id_cliente" value="{{ $dato->id }}">
                                                {{$mostrar2}}
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                {{$mostrar}}
                                                    <button type="button" class="btn btn-primary" onclick="registrar({{ $dato->id }},'{{$dato->cod_unico}}')">Guardar Cambios</button>
                                                {{$mostrar2}}
                                            </div>
                                        </div>
                                    </div>
                                </div>                           
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>VER INFO. COMPLETA</th>
                                <th>AGENDAR ACTIVIDAD</th>
                                <th>PAIS</th>
                                <th>CODIGO UNICO</th>
                                <th>CODIGO_CLIENTE</th>
                                <th>RAZON</th>
                                <th>NOMBRE COMERCIAL</th>
                                <th>SUCURSAL</th>
                                <th>MERCADO</th>
                                <th>SEGMENTO</th>
                                <th>OFICINA</th>
                                <th>ESTATUS</th>
                                <th>ESTATUS DETALLE</th>
                                <th>ÁREA VENTA</th>
                            </tr>
                        </tfoot>
                    </table>  
                </div>
            @endif
        </div>
    </div>
	
@stop

@section("java")
	@parent
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
	{{HTML::script("//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js", array("type" => "text/javascript"))}}


    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script type="tabla/text/javascript" src="bootstrap.js"></script>
    <script type="tabla/text/javascript" src="jquery-1.12.3.js"></script>
    <script src="tabla/jquery.dataTables.min.js"></script>
    <script src="tabla/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript">
	
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#tabla tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        } );

        // DataTable
        var table = $('#tabla').DataTable();

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
    } );
     function most_cli(id,id2){
        console.log(id);
        if(id == 19){
            $("#cliente_dis"+id2).show();
        }else{
            $("#cliente_dis"+id2).hide();
        }
     }
     function most_otro(id,id2){
            // document.getElementById("otro_pais"+id2).innerHTML =" ";
            console.log(id);
            if(id==32){
                $("#otro_pais"+id2).show();
            }else{
                $("#otro_pais"+id2).hide();
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

        

        function registrar(id,modal){

            var razon = validarfile('razon'+id);
            var nombre = validarfile('nom_comercial'+id);
            var sucursal = validarfile('sucursal'+id);
            var pais = validarSelect('pais'+id);
            var mercado = validarSelect('mercado'+id);
            var segV = $("#mercado"+id).val();
            console.log(segV);
            if(segV == 14){
                // console.log('entre');
                var segmento = validarfile('otro'+id);
            }else{
                var segmento = validarSelect('segmento'+id);
            }
            
            var oficina = validarSelect('oficina'+id);        
            

            if(razon == 0 || nombre == 0 || sucursal==0 || mercado == 0 || segmento == 0 || oficina==0  || pais==0 ){

                swal ( "Alerta !" ,  "Es necesario todos los campos para realizar el registro" ,  "error" );
            }
            else{
                swal({
                      title: "¿Seguro de Actualizar datos?",
                      text: "Actualizar!",
                      type: "warning",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Si, Actualizar!",
                      cancelButtonText: "No, cancelar!",
                      showLoaderOnConfirm: true
                    }, function () {
                        setTimeout(function () {
                            var formData = new FormData(document.getElementById("form_datos"+id));
                                $.ajax({
                                     type: 'post',   
                                     cache: false,
                                     url:'{{ URL::asset("/actualizar_cliente") }}' ,    
                                     data: formData,
                                     contentType:false,
                                     processData: false,
                                     dataType: "json",
                                     success: 
                                        function(data) 
                                        {
                                            if(data.error == 0 ){
                                                swal({   
                                                    title: "Registro Exitoso",
                                                    html:true,   
                                                    text: data.mensaje+"<br><br><div class='alert alert-danger mensaje' role='alert'>Los cambios efectuados se verán reflejados al actualizar.</div>", 
                                                    type:"success" },
                                                    function(){   
                                                        $('.'+modal).modal('hide');
                                                        
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
                
        function buscarMercado(valor,id){
            document.getElementById("mercado"+id).innerHTML =" ";
            document.getElementById("oficina"+id).innerHTML =" ";
            // document.getElementById("verDirec"+id).innerHTML =" ";
            $("#img_mercado"+id).show();
            $("#img_oficina"+id).show();

            var pais = $("#pais"+id).val();

            $("#zona"+id).attr('readonly',true);
            $("#zona"+id).val('');

            if(pais != 1 ){
                $("#zona"+id).attr('readonly',false);
            }


            $.get("{{ URL::asset('ajax_mercado') }}", {id_pais: valor}, function(data) {
                $("#img_mercado"+id).hide();
                $("#img_oficina"+id).hide();
                $("#mercado"+id).append("<option value='0' selected  >Seleccione un Mercado</option>"+data.tipo);
                $("#oficina"+id).append("<option value='0' selected  >Seleccione una Oficina</option>"+data.cuidades);
            });
        }

        function buscarSegmento(valor,id){
            var pais = $('#pais'+id).val();
            // console.log(id);
            document.getElementById("segmento"+id).innerHTML =" ";

            $("#img_segmento"+id).show();
            $.get("{{ URL::asset('ajax_segmento') }}", {id_mercado: valor,id_pais:pais}, function(data) {
                $("#img_segmento"+id).hide();
                if(valor == 14){
                    // $("#segmento"+id).append("<input type='text' class='form-control' id='otro' placeholder='Otro' name='otro' ><div class='invalid-feedback'>Campo necesario !</div>");
                   $("#segmento"+id).hide();
                   $("#otro"+id).show();
                   $("#bandera"+id).val(1);                  
                }else{
                    $("#segmento"+id).show();
                    $("#bandera"+id).val(0); 
                   $("#otro"+id).hide(); 
                    if(data != ''){
                        $("#segmento"+id).append("<option readonly value='0' selected  >Seleccione una segmento</option>"+data);
                    }else{
                        $("#segmento"+id).append("<option readonly value='15' selected >Seleccione una segmento</option>");
                    }
                }
            });
        }

        function mostrarzona(id,id2){
            console.log(id);
            var pais = $("#pais"+id2).val();
            $("#zona"+id2).attr('readonly',true);
            $("#zona"+id2).val('');
            if(pais == 1 ){
                if(id == 3 || id == 6 || id == 5){
                    $("#zona"+id2).val('PACIFICO');
                }
                if(id == 1 || id == 2 || id == 4){
                    $("#zona"+id2).val('CENTRO');
                }
                if(id == 7 || id == 8 || id == 9){
                    $("#zona"+id2).val('SURESTE');
                }
            }else{
                $("#zona"+id2).attr('readonly',false);
            }
        }

        function agregarContac(id){
            
            var ii = $("#cont"+id).val();
            var num = parseInt(ii) + 1;

            var i = $("#cont2"+id).val();
            var num2 = parseInt(i) + 1;
            console.log(ii);
            if(ii <= 3 ){
                $("#contacto"+id).append("<div class='col-md-12 col-sm-12' id='div"+id+i+"' >"+
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
                                                "<label >Eliminar</label>"+
                                                "<input type='button' class='btn btn-danger btn-block ' id='eliminar_cont"+i+"' value='Eliminar Contacto' onclick='elimiar_btn("+id+i+","+id+")'  >"+
                                                "<div class='invalid-feedback'>"+
                                                    "Campo necesario !"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>");
                $("#cont"+id).val(num);
                $("#cont2"+id).val(num2);
            }
            
            
        }

        function elimiar_btn(id,id2){
            console.log(id);
            $("#div"+id).remove();
            var i = $("#cont"+id2).val();
            var num = parseInt(i) - 1;
            $("#cont"+id2).val(num);
        }

        // agenda labor
      
    function usuario_asignado(id_codigo){
         
        var pais1 = $('#id_pais1').val();
        var oficina1 = $('#id_oficina_central').val();
        var codigo = $('#id_codigo'+id_codigo).val();

         $('#hora'+codigo).timepicker();

        console.log(oficina1,pais1,codigo);         
            document.getElementById("tabla"+codigo).innerHTML =" ";
            $.get("{{ URL::asset('consulta_usuario') }}",{pais:pais1,oficina:oficina1}, function(data) {
                console.log(data);
                console.log('hola');
                var trs ='';
               data.usuario.forEach(function(elemento){
                  trs=trs+ "<option  value='"+elemento.id+"' >"+elemento.usuarios+"</option>";
                    console.log(trs);             
                  
               });   
               console.log(codigo);             
                 // $("#us").append("<select class='custom-select' name='usuario' id='usuario'><option  value='0' selected>Seleccione una usuario</option>"+trs+"</select>");
                 $("#tabla"+codigo).append("<select class='custom-select' name='usuario' id='usuario"+codigo+"'><option  value='0' selected>Seleccione una usuario</option>"+trs+"</select>"+
                     "<div class='invalid-feedback'>"+
                     "Campo necesario !"+
                    "</div>");

            //      var f = new Date();

            //         $('#date_range'+codigo).daterangepicker({
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
            //     "endDate": f.getFullYear() + "-" + (f.getMonth() +1) + "-" +(f.getDate()+1),
            //     "opens": "center"
            // });
                  
            },'json');

       }

       function vali(id_mot){
         var motivo = $('#motivo'+id_mot).val();
           console.log(motivo);
           document.getElementById("mostrar"+id_mot).innerHTML = " ";
             if (motivo=="OTRO") {                
                        $("#mostrar"+id_mot).show();
                         $("#mostrar"+id_mot).append("<label>OTRO MOTIVO</label>"+
                                               "<div class='col-sm-10'>"+
                                               "<input type='text' class='form-control' id='otro_motivo"+id_mot+"' placeholder='Motivo' value='' required=''/>"+
                                               "</div>");                                            
                    }
                    else{
                        console.log('no entro');
                         $("#mostrar"+id_mot).hide();
                    }
         }
       
    function guardar(id){
       
      var fecha_labor1= validarfile('date_range'+id);
      var hora1= validarfile('hora'+id);
      var motivo1= validarSelect('motivo'+id);
      var usuario1= validarSelect('usuario'+id);

      console.log(fecha_labor1);



        var fecha_labor=$('#date_range'+id).val();
        var hora=$('#hora'+id).val();
        var motivo = $('#motivo'+id).val();
        var otro_motivo="";

        if (motivo=="OTRO") {
         otro_motivo=$('#otro_motivo'+id).val();         
        }
        var cliente = id;
        var usuario = $('#usuario'+id).val();

        console.log(fecha_labor+" "+motivo+" "+usuario+" "+cliente+" "+otro_motivo+" "+hora);

        if(fecha_labor1 == 0 || hora1==0 || motivo1==0 || usuario1==0){

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
                           $.post("{{ URL::asset('registra') }}",{fecha: fecha_labor,motivo:motivo,usuario:usuario,cliente:cliente,otro_motivo:otro_motivo,hora:hora}, function(data) {
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