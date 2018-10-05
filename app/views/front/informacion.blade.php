@extends("tema.master")
@section("tittle")
	<title>Seguimiento a Labor de Venta</title>
@stop
<style type="text/css">
	label{
		color: #fff;
	}
    .modal-body label{
        color: #000;
    }
    .dividir{
        border: 2px solid #fcfcfc;
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
<nav class="navbar navbar-expand-lg navbar-dark  fixed-top" style="background-color: #000">
    <a class="navbar-brand" href="#">
        <img src="{{ URL::asset('img/logo.png') }}" width="120" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

   
</nav>

	<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <label>Fecha labor de venta</label>
                  <div class="col-8">
                    <input type="text" class="form-control" name="" value="{{$infor[0]->fecha_labor_venta}}" readonly="">          
                  </div>  
                </div>

                <div class="col-6">
                    <label>Motivo</label>
                  <div class="col-8">
                    <input type="text" class="form-control" name="" value="{{$infor[0]->motivo}}" readonly="">          
                  </div>  
                </div>
                <div class="col-6">
                    <label>Requerimiento del Cliente</label>
                  <div class="col-8">
                    <input type="text" class="form-control" name="" value="{{$infor[0]->requerimiento}}" readonly="">          
                  </div>  
                </div>
                <div class="col-6">
                    <label>Detalle del Requerimiento</label>
                  <div class="col-8">
                    <input type="text" class="form-control" name="" value="{{$infor[0]->detalle}}" readonly="">          
                  </div>  
                </div>
                 <div class="col-6">
                    <label>Actividad del Seguimiento</label>
                  <div class="col-8">
                    <input type="text" class="form-control" name="" value="{{$infor[0]->act_seguimiento}}" readonly="">          
                  </div>  
                </div>
                 <div class="col-6">
                    <label>Responsable del Seguimiento</label>
                  <div class="col-8">
                    <input type="text" class="form-control" name="" value="{{$infor[0]->responsable_segui}}" readonly="">          
                  </div>  
                </div>
                <div class="col-6">
                    <label>Correo Elec. del Responsable del Seguimiento</label>
                  <div class="col-8">
                    <input type="text" class="form-control" name="" value="{{$infor[0]->correo_rep}}" readonly="">          
                  </div>  
                </div>
                
            </div>
            <div class="row">
                    <div class="col-12">
                        <hr class="dividir">
                    </div>
                <div class="col-6">
                    <label>¿La Actividad de Seguimiento se Realizó Satisfactoriamente?</label>
                  <div class="col-8">
                    <select class="custom-select " name="" id="" >  
                        <option value="0">Selecciones una actividad</option>
                        <option value="REALIZADA">SI</option>
                        <option value="NO REALIZADA">NO</option>                         
                  </select>         
                  </div>  
                </div>

                <div class="col-6">
                        <label>Comentarios</label>
                      <div class="col-8">
                       <textarea class="form-control" id="message-text"></textarea>       
                      </div>  
                    </div>
        </div>
        <button type="button" class="btn btn-outline-danger">Guardar Informacion</button>
                                      
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
                "language": {
                 "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "Todos"]],
                "order": [[ 4, "asc" ],[ 0, "asc" ]]                
            });            
        });
   
	</script>
@stop