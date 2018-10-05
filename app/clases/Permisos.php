<?php

class Permisos extends BaseController {

	public static function permiso($id_usuario,$permiso)
	{
		$verificar = DB::table('detalle_permiso')->select('*')->where('id_usuario',$id_usuario)->where('id_permiso',$permiso)->where('activo',1)->get();
		if(count($verificar)>0){
			return true;
		}else{
			return false;
		}

	}

}
