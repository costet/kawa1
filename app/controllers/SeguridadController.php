<?php

class SeguridadController extends BaseController {	

	public function iniciarSession()	
	{
	    $user = Input::get('user');
	    $pass = Input::get('pass');

	    $buscar= DB::table('usuario')->select('*')->where('usuario',$user)->where('password',md5($pass))->get();

	    if(count($buscar)>0){
	    	Session::flush();
	        Session::put("id_usuario",$buscar[0]->id );
	        Session::put("usuario",$buscar[0]->usuario );
	        Session::put("login", true);
	        Session::save();
	        return Redirect::to('/');
	    }else{
	    	return Redirect::to('login')->with(array('mensaje'=>'Error ! Usuario y/o contraseña invalidos !'));
	    }
	}
	public function salir(){
		Session::flush();
		Session::save();
		return Redirect::to("/login");
	}

}
