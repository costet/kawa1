<?php
// Route::get('/inicioGoogle', array('uses' => 'SeguridadController@iniciarSession') );
Route::post('/iniciosesion', array('uses' => 'SeguridadController@iniciarSession') );
Route::get('/salir', array('uses' => 'SeguridadController@salir') );
Route::get("/login",function(){return View::make('front.login');});
Route::get("/seguimiento_labor_venta","ClienteController@informacion");
Route::group(array("before" => "is_login"), function(){
	Route::get("/",function(){return View::make('front.inicio');});
	Route::get("/alta_cliente","ClienteController@showRegistro");
	Route::get("/ajax_segmento","ClienteController@ajax_segmento");
	Route::get("/ajax_mercado","ClienteController@ajax_mercado");
	Route::post("/registrar","ClienteController@registrar_cliente");
	Route::get("/consultar_clientes","ClienteController@consultar_clientes");
	Route::get("/consultar_clientes2",function(){return View::make('front.reg_ventas2');});
	Route::post("/consulta","ClienteController@consulta");
	Route::post("/actualizar_cliente","ClienteController@actualizar_cliente");
    Route::get("/consulta_usuario","ClienteController@consulta_usuario");
	Route::get("/registro_venta","ClienteController@registro_venta");
	Route::get("/consultar_labor","ClienteController@consulta_labor");
	Route::get("/consulta1","ClienteController@consulta1");
	Route::get("/registrar_actividad","ClienteController@registrar_actividad");
	Route::post("/registra","ClienteController@registra");
	Route::post("/registrar_plan","ClienteController@registrar_plan");
	Route::get("/eliminar_plan","ClienteController@eliminar_plan");
	Route::get("/cancelar_plan","ClienteController@cancelar_plan");
	Route::get("/alta_user","UserController@alta_user");
	Route::get("/consultar_bitacora","ClienteController@consulta_bitacora");
	Route::get("/con_bitacora","ClienteController@consulta_bita");
	Route::get("/ajax_cuidades","UserController@ajax_cuidades");
	Route::post("/registrar_user","UserController@registrar_user");
	Route::get("/ajax_validar_user","UserController@ajax_validar_user");
	Route::post("/editar_user","UserController@editar_user");
	Route::get("/enviar","ClienteController@enviar");
	Route::get("/consulta_correo","ClienteController@consulta_correo");
	Route::post("/registrar_seguimiento","ClienteController@registrar_seguimiento");
   
});