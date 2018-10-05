<form class="form-row" id="form_datos{{$dato->id}}" action="{{ URL::asset('actualizar_cliente') }}" method="post">
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
    {{ $mostrar }}
    <div class="row">
        <div class="col-md-6 col-sm-6">
            
            <div class="form-group col-md-12">
                <label for="">Código Cliente</label>
                
                    <input type="text" class="form-control" id="cod_cliente" placeholder="Código Cliente" name="cod_cliente" value="{{ $dato->cod_unico}}" >
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
                <label for="" >* Nombre comerciaL</label>                                                            
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
                        <select class="custom-select " name="pais" id="pais{{$dato->id}}" onchange="buscarMercado(this.value)">  
                            <option value="{{ $dato->id_pais }}">{{ $dato->pais }}</option>
                            <optgroup >
                                @foreach ($pais as $paises)
                                    <option value="{{ $paises->id }}">{{ $paises->pais }}</option>
                                @endforeach 
                            </optgroup>                      
                        </select>
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
                
                    @if (count($pais) > 1)
                        <br>
                        <img src="{{ URL::asset('img/loading.gif') }}" id='img_mercado' class="img-responsive" width="40px" style="display: none;">
                        <div id="mercado">
                            <select class="custom-select " name="mer" id="mer{{$dato->id}}" onchange="buscarSegmento(this.value,'{{$dato->id}}')">
                                <option value="{{ $dato->id_mercado }}">{{ $dato->mercado }}</option>
                            </select>
                            <div class="invalid-feedback">
                                Campo necesario !
                            </div>
                        </div>
                    @else
                        <div id="mercado">
                            <select class="custom-select " name="mer" id="mer" onchange="buscarSegmento(this.value)">   
                                <option value="{{ $dato->id_mercado }}">{{ $dato->mercado }}</option>
                                <optgroup 
                                    @foreach ($mercado as $mercado)
                                        <option value="{{ $mercado->id }}">{{ $mercado->mercado }}</option>
                                    @endforeach 
                                </optgroup>
                            </select>
                            <div class="invalid-feedback">
                                Campo necesario !
                            </div>
                        </div>
                    @endif
                
            </div>
            <div class="form-group col-md-12">
                <label for="" >* Segmento</label>
                
                   <img src="{{ URL::asset('img/loading.gif') }}" id='img_segmento{{$dato->id}}' class="img-responsive" width="40px" style="display: none;">
                    <div id="segmento{{$dato->id}}">
                        <select class="custom-select " name="seg" id="seg{{$dato->id}}"> 
                            <option value="{{ $dato->id_segmento }}">{{ $dato->producto }}</option>
                        </select>
                        <div class="invalid-feedback">
                            Campo necesario !
                        </div>
                    </div>
                
            </div>
            <div class="form-group col-md-12">
                <label for="" >* Oficina Responsable</label>
                
                    @if (count($pais) > 1)
                        <img src="{{ URL::asset('img/loading.gif') }}" id='img_segmento' class="img-responsive" width="40px" style="display: none;">
                        <div id="oficina">
                            <select class="custom-select " name="oficina" id="oficinaa" onchange="mostrarzona(this.value)" >    
                                <option value="{{ $dato->id_oficina_central }}">{{ $dato->oficina }}</option>
                            </select>
                            <div class="invalid-feedback">
                                Campo necesario !
                            </div>
                        </div>
                    @else
                        <select class="custom-select " name="oficina" id="oficinaa{{$dato->id}}"> 
                            <option value="{{ $dato->id_oficina_central }}">{{ $dato->oficina }}</option>
                            <optgroup 
                                @foreach ($cuidadess as $element)
                                    <option value="{{ $element->id }}">{{ $element->oficina }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <div class="invalid-feedback">
                            Campo necesario !
                        </div>
                    @endif
                
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
                    
                        @if (count($pais) > 1)
                            <input type="text" class="form-control" id="zona{{$dato->id}}" placeholder="" name="zona" value="{{ $dato->zona }}" readonly="" >
                        @else
                            @if ($dato->id_pais == 1 )
                                <input type="text" class="form-control" id="zona{{$dato->id}}" placeholder="" name="zona" value="{{ $dato->zona }}" >
                            @else
                                <input type="text" class="form-control" id="zona{{$dato->id}}" placeholder="" name="zona" value="{{ $dato->zona }}" >
                            @endif
                            
                        @endif
                        
                        <div class="invalid-feedback">
                            Campo necesario !
                        </div>
                    
                </div>
            </div>
            <div class="form-row">
                <?php  $permiso= Permisos::permiso(Session::get('id_usuario') , 4 ); ?>
                <div class="form-group col-md-4">
                    <label for="">Área de venta</label>

                        @if ($permiso)
                            <?php $area_de_venta = DB::select("select * from cat_area_venta where id_pais =".$dato->id_pais);  ?>
                            <select class="custom-select " name="area_de_venta" id="area_de_venta">
                                @if ( ! is_null($dato->area ))
                                    <option value="{{$dato->area_venta}}">{{$dato->area}}</option>
                                @else
                                    <option value="0">Seleccione un Area de venta</option>
                                @endif   
                                <optgroup> 
                                    @foreach ($area_de_venta as $area_de_vent)
                                        <option value="{{ $area_de_vent->id }}">{{ $area_de_vent->area }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        @else
                            <select class="custom-select " name="area_de_venta" id="area_de_venta">
                                <option value="{{$dato->area_venta}}">{{$dato->area}}</option>
                            </select>
                        @endif
                        
                        <div class="invalid-feedback">
                            Campo necesario !
                        </div>
                    
                </div>
                @if ($permiso)
                    <div class="form-group col-md-4">
                        <label for="">Estatus detalle</label>
                            <?php $estatus_deta = DB::select("select * from cat_estatus_detalle");  ?>
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
                    <div class="form-group col-md-4">
                        <label for="" >Fecha estatus</label>
                        
                            <input type="date" class="form-control" id="fecha_esta{{$dato->id}}" placeholder="Fecha Estatus" name="fecha_esta" value="{{ $dato->fecha_estatus}}">
                            <div class="invalid-feedback">
                                Campo necesario !
                            </div>
                        
                    </div>
                @endif
            </div>

        </div>

        <div class="col-md-6 col-sm-6">
            
            @if ($dato->id_pais == 1 )
                <?php $datos_direc = DB::select("select * from direccion_mexico where id_cliente = ".$dato->id); ?>
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
                        <div class="form-group col-md-6">
                            <label for="">Estado</label>
                            <input type="text" class="form-control" id="estado"  placeholder="Estado" name="estado" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->id_estado : '' }}" >
                        </div>      
                    </div>
                @else
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">DIRECCIÓN</label>
                            <input type="text" value="{{ ( count($datos_direc) > 0 ) ? $datos_direc[0]->calle. ' '.$datos_direc[0]->numero.' '.$datos_direc[0]->colonia.' '.$datos_direc[0]->cp.' '.$datos_direc[0]->municipio.' '.$datos_direc[0]->id_estado : '' }}" class="form-control" placeholder="Dirección" name="direccion" id="direccion" >
                            <div class="invalid-feedback">
                                Campo necesario !
                            </div>
                        </div>
                    </div>
                @endif
                
            @else
                <?php $datos_direc = DB::select("select * from direccion_pais where id_cliente = ".$dato->id); ?>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">DIRECCIÓN</label>
                        <input type="text" class="form-control" placeholder="Dirección" name="direccion" id="direccion" value="{{$datos_direc[0]->direccion }}">
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
                                                <input type="text" name='car_contac{{ $i }}' class="form-control" id="" placeholder="Télefono" value="{{ $contacto->cargo }}">
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
                                                <input type="text" name='car_contac{{ $i }}' class="form-control" id="" placeholder="Télefono" value="{{ $contacto->cargo }}">
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
                                                <input type="text" name='car_contac{{ $j }}' class="form-control" id="" placeholder="Télefono" >
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
                                                <input type="text" name='car_contac{{ $j }}' class="form-control" id="" placeholder="Télefono" >
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
{{$mostrar2}}
<button type="submit" class="btn btn-primary" >Guardar Cambios</button>
</form>
<script type="text/javascript">
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

        

        function registrar(id){

            var razon = validarfile('razon'+id);
            var nombre = validarfile('nom_comercial'+id);
            var sucursal = validarfile('sucursal'+id);
            var pais = validarSelect('pais'+id);
            var mercado = validarSelect('mer'+id);
            var segV = $("#mer").val();
            if(segV == 14){
                var segmento = validarfile('otro'+id);
            }else{
                var segmento = validarSelect('seg'+id);
            }
            
            var oficina = validarSelect('oficinaa'+id);        
            

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
                
        function buscarMercado(valor,id){
            document.getElementById("mercado").innerHTML =" ";
            document.getElementById("oficina").innerHTML =" ";
            // document.getElementById("verDirec"+id).innerHTML =" ";
            $("#img_mercado").show();
            $("#img_oficina").show();

            var pais = $("#pais").val();

            $("#zona").attr('readonly',true);
            $("#zona").val('');

            if(pais != 1 ){
                $("#zona").attr('readonly',false);
            }


            $.get("{{ URL::asset('ajax_mercado') }}", {id_pais: valor}, function(data) {
                $("#img_mercado").hide();
                $("#img_oficina").hide();
                $("#mercado").append("<select class='custom-select' name='mer'  id='mer' onchange='buscarSegmento(this.value)'><option readonly value='0' selected  >Seleccione una mercado</option>"+data.tipo+"</select><div class='invalid-feedback'>Campo necesario !</div>");
                $("#oficina"+id).append("<select class='custom-select' name='oficina'  id='oficinaa'onchange='mostrarzona(this.value)' ><option readonly value='0' selected  >Seleccione una Oficina</option>"+data.cuidades+"</select><div class='invalid-feedback'>Campo necesario !</div>");
                

            });
        }

        function buscarSegmento(valor,id){
            var pais = $('#pais'+id).val();
            console.log(id);
            document.getElementById("segmento"+id).innerHTML =" ";

            $("#img_segmento"+id).show();
            $.get("{{ URL::asset('ajax_segmento') }}", {id_mercado: valor,id_pais:pais}, function(data) {
                $("#img_segmento"+id).hide();
                if(valor == 14){
                    $("#segmento"+id).append("<input type='text' class='form-control' id='otro' placeholder='Otro' name='otro' ><div class='invalid-feedback'>Campo necesario !</div>");
                }else{
                    if(data != ''){
                        $("#segmento"+id).append("<select class='custom-select' name='seg'  id='seg'><option readonly value='0' selected  >Seleccione una segmento</option>"+data+"</select><div class='invalid-feedback'>Campo necesario !</div>");
                    }else{
                        $("#segmento"+id).append("<select class='custom-select' name='seg'><option readonly value='0' selected >Seleccione una segmento</option></select><div class='invalid-feedback'>Campo necesario !</div>");
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
                    $("#zona"+id2).val(1);
                }
                if(id == 1 || id == 2 || id == 4){
                    $("#zona"+id2).val(2);
                }
                if(id == 7 || id == 8 || id == 9){
                    $("#zona"+id2).val(3);
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