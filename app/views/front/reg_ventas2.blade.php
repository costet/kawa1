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
</style>
@section("titulo")
@stop
@section("contenido")
	<div class="card">
        <div class="card-body">
            
            

            @if (count($datos)>0)
                <table id="tabla" class="table table-dark table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>VER INFO. COMPLETA</th>
                            <th>PAIS</th>
                            <th>CODIGO UNICO</th>
                            <th>CODIGO_CLIENTE</th>
                            <th>RAZON</th>
                            <th>NOMBRE COMERCIAL</th>
                            <th>SUCURSAL</th>
                            <th>MERCADO</th>
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
                                <td>{{ $dato->pais }}</td>
                                <td>{{ $dato->cod_unico}}</td>
                                <td>{{ $dato->cod_cliente}}</td>
                                <td>{{ $dato->razon}}</td>
                                <td>{{ $dato->nombre_comercial}}</td>
                                <td>{{ $dato->sucursal }}</td>
                                <td>{{ $dato->mercado }}</td>                            
                            </tr>
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
                                                                    @if ( is_null($dato->otro))
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
                                                                        @foreach ($cuidades as $element)
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
                                                                
                                                                    @if ($dato->id_pais == 1 )
                                                                            <input type="text" class="form-control" readonly="" id="zona{{$dato->id}}" placeholder="" name="zona" value="{{ $dato->zona }}" >
                                                                        @else
                                                                            <input type="text" class="form-control" id="zona{{$dato->id}}" placeholder="" name="zona" value="{{ $dato->zona }}" >
                                                                        @endif
                                                                    
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                    </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            
                                                            <div class="form-group col-md-12">
                                                                <label for="">Área de venta</label>

                                                                    @if ($permiso)
                                                                        
                                                                        <select class="custom-select " name="area_de_venta" id="area_de_venta">
                                                                            @if ( ! is_null($dato->area ))
                                                                                <option value="{{$dato->area_venta}}">{{$dato->area}}</option>
                                                                            @else
                                                                                <option value="0">Seleccione un Area de venta</option>
                                                                            @endif   
                                                                            <optgroup> 
                                                                                @foreach ( $area_de_venta as $area_de_vent)
                                                                                    <option value="{{ $area_de_vent->id }}">{{ $area_de_vent->area }}</option>
                                                                                @endforeach
                                                                            </optgroup>
                                                                        </select>
                                                                    @else
                                                                        <select class="custom-select " name="area_de_venta" id="area_de_venta">
                                                                            <option value="{{$dato->area_venta}}">{{$dato->area}}</option>
                                                                            @if ($dato->id_pais != 1 )
                                                                                @foreach ( $area_de_venta as $area_de_vent)
                                                                                    <option value="{{ $area_de_vent->id }}">{{ $area_de_vent->area }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    @endif
                                                                    
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
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
                                                            <?php $datos_direc = DB::select("select * from direccion_mexico as a left join estados_mexico as b on a.id_estado=b.id left join paises as c on a.id_pais=c.id where a.id_cliente = ".$dato->id); ?>
                                                            @if ($mostar )
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="">Calle</label>
                                                                        <input type="text" class="form-control" placeholder="Calle" name="calle" id="calle" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->calle : '' }}"> 
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="">Número</label>
                                                                        <input type="text" class="form-control" placeholder="Número" name="no" id="no" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->numero : '' }}">
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="">Colonia</label>
                                                                        <input type="text" class="form-control" id="colonia" placeholder="Colonia" name="col" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->colonia : '' }}">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="">Código postal</label>
                                                                        <input type="number" class="form-control" id="tags" placeholder="Código Postal" name="cp" {{-- onkeyup="buscar(this.value)" --}} min="0" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->cp : '' }}">
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="">Municipio</label>
                                                                        <input type="text" class="form-control" id="muni"  placeholder="Municipio" name="muni" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->municipio : '' }}">
                                                                    </div>
                                                                    <div class='form-group col-md-6'>
                                                                        <label>Estado</label>
                                                                        <select class='custom-select ' name='estado' id='estado' onchange="most_otro(this.value,{{$dato->id}})">
                                                                            <option value='{{$datos_direc[0]->id_estado}}'>{{ ($datos_direc[0]->id_estado == 32) ? $datos_direc[0]->otro : $datos_direc[0]->estado }}</option>
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
                                                                            <option value='{{$datos_direc[0]->id_pais}}'>{{$datos_direc[0]->pais}}</option>
                                                                            <optgroup>
                                                                            @foreach ($cat_pais as $cat_pai)
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
                                                                            {{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->calle. ' '.$datos_direc[0]->numero.' '.$datos_direc[0]->colonia.' '.$datos_direc[0]->cp.' '.$datos_direc[0]->municipio.' ' : '' }},{{($datos_direc[0]->id_estado == 32) ? $datos_direc[0]->otro : $datos_direc[0]->estado}}, {{ $dato->pais }}
                                                                        </textarea>
                                                                        
                                                                        <div class="invalid-feedback">
                                                                            Campo necesario !
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
                                                        @else
                                                            <?php $datos_direc = DB::select("select * from direccion_pais as a left join paises as c on a.id_pais=c.id where a.id_cliente = ".$dato->id); ?>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-8">
                                                                    <label for="">DIRECCIÓN</label>
                                                                    <input type="text" class="form-control" placeholder="Dirección" name="direccion" id="direccion" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->direccion : ''   }}">
                                                                    <div class="invalid-feedback">
                                                                        Campo necesario !
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">Provincia</label>
                                                                    <input type="text" class="form-control" placeholder="Provincia" name="provincia" id="provincia" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->provincia : ''   }}">
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
                </table>  
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
		    $('#tabla').DataTable({
                // "language": {
                //   "url": "{{URL::to('js/lenguajeDataTable/es_es.json')}}"
                // },
                "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "Todos"]],
                "order": [[ 4, "asc" ],[ 0, "asc" ]]

                
            });
            
		});
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

	    	
	</script>
@stop