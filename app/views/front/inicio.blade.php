@extends("tema.master")
@section("tittle")
	<title>Inicio</title>
@stop
<style type="text/css">
	.card{
        background-color: rgba(000,000,000,0.7);
        height: 100%;
        /*opacity: rgba (000,000,000, .5);*/
    }

</style>

@section("titulo")
@stop
@section("contenido")
	<div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ URL::asset('img/logo.png') }}" class="" >
            </div>
        </div>
    </div>
@stop
