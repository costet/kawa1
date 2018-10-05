<?php

class UserController extends BaseController {

	function alta_user(){
		$users = DB::select("select 
								*, a.id as id_u 
							from 
								usuario as a
								left join user_pais_oficina as b on a.id=b.id_user
								left join cat_paises as c on b.id_pais=c.id
								left join oficina_por_pais as d on b.id_oficina=d.id
							order by
								a.id asc");
		$paises = DB::select("select * from cat_paises");
		$cuidades = DB::select("select * from oficina_por_pais");
		$permisos = DB::select("select * from permisos");
		$detalle_permiso = DB::select("select * from detalle_permiso");
		return Response::view('front.vista_alta_user', compact('users','paises','permisos','cuidades','detalle_permiso'));
	}

	function editar_user(){
		$id_user =  Input::get('id_user');
		$nombre = Input::get('nombre');
		$paterno = Input::get('paterno');
		$materno = Input::get('materno');
		$correo = Input::get('correo');
		// $user = Input::get('user');

		$user_of = Usuario::find($id_user);
		$user_of->nombre = $nombre;
		$user_of->paterno = $paterno;
		$user_of->materno = $materno;
		// $user_of->usuario = $user;
		// $user_of->password = md5($user);
		$user_of->correo = $correo;
		$user_of->activo = 1;
		
		if ($user_of->save()) {
			DB::table('user_pais_oficina')->where('id_user', $id_user)->delete();
			DB::table('paises_por_user')->where('id_usuario', $id_user)->delete();
			DB::table('detalle_permiso')->where('id_usuario', $id_user)->delete();

			$num_of = DB::select("SELECT count(*) as num from oficina_por_pais");
			// $id_user = $user_of->id;
			for ($i=1; $i <= $num_of[0]->num ; $i++) { 
				if ( Input::has('oficina_'.$i) ) {
					$id_of = explode('_', Input::get('oficina_'.$i) );
					$buscar = DB::select("SELECT * from oficina_por_pais where id=".$id_of[0]);
					DB::table('user_pais_oficina')->insert(array(
						'id_pais' => $buscar[0]->id_pais, 
						'id_user' => $id_user,
						'id_oficina' => $buscar[0]->id,
						'estatus' => 1
					));

				}
			}

			$paises = DB::select("select distinct id_pais,id_user from user_pais_oficina where id_user=".$id_user );
			foreach ($paises as $pais) {
				DB::table('paises_por_user')->insert(array(
					'id_usuario' => $pais->id_user, 
					'id_pais' => $pais->id_pais,
					'activo' => 1
				));
			}

			$perm = DB::select("select count(*) as num from permisos");
			// $id_user = 1;
			for ($i=1; $i <= $perm[0]->num ; $i++) { 
				if ( Input::has('permiso_'.$i) ) {
					$id_pe = explode('_', Input::get('permiso_'.$i) );
					$buscar = DB::select("SELECT * from permisos where id=".$id_pe[0]);
					DB::table('detalle_permiso')->insert(array(
						'id_usuario' => $id_user, 
						'id_permiso' => $buscar[0]->id,
						'perfil' => 1,
						'activo' => 1
					));

				}
			}
			return Response::json(array('error'=>0,'mensaje'=>'Se ha registrado con exito al Usuario'));

		}else{
			return Response::json(array('error'=>1,'mensaje'=>'Error al registrar el cliente'));
		}
		
	}

	function ajax_cuidades(){
		$id_pais = Input::get('id_pais');
		$oficinas  = DB::select("select * from oficina_por_pais where id_pais =".$id_pais );
		$of='';
		foreach ($oficinas as $oficina) {
			$of = $of.'<div class="form-check"><input class="form-check-input" id="of'.$oficina->id.'" type="checkbox" value="'.$oficina->id.'" name="oficina_'.$oficina->id.'"><label class="form-check-label" for="of'.$oficina->id.'">'.$oficina->oficina.'</label></div>' ;
		}

		return $of;
	}
	function registrar_user()
	{
		$nombre = Input::get('nombre');
		$paterno = Input::get('paterno');
		$materno = Input::get('materno');
		$correo = Input::get('correo');
		$user = Input::get('user');

		$buscar = DB::select("select * from usuario where usuario='".$user."' ");

		if (count($buscar) > 0) {
			return Response::json(array('error'=>1,'mensaje'=>'Error ! nombre de usuario ya existe ! '));
		}else{
			$user_of = new Usuario();
			$user_of->nombre = $nombre;
			$user_of->paterno = $paterno;
			$user_of->materno = $materno;
			$user_of->usuario = $user;
			$user_of->password = md5($user);
			$user_of->correo = $correo;
			$user_of->activo = 1;
			
			if ($user_of->save()) {
				$num_of = DB::select("SELECT count(*) as num from oficina_por_pais");
				$id_user = $user_of->id;
				for ($i=1; $i <= $num_of[0]->num ; $i++) { 
					if ( Input::has('oficina_'.$i) ) {
						$id_of = explode('_', Input::get('oficina_'.$i) );
						$buscar = DB::select("SELECT * from oficina_por_pais where id=".$id_of[0]);
						DB::table('user_pais_oficina')->insert(array(
							'id_pais' => $buscar[0]->id_pais, 
							'id_user' => $id_user,
							'id_oficina' => $buscar[0]->id,
							'estatus' => 1
						));

					}
				}

				$paises = DB::select("select distinct id_pais,id_user from user_pais_oficina where id_user=".$id_user );
				foreach ($paises as $pais) {
					DB::table('paises_por_user')->insert(array(
						'id_usuario' => $pais->id_user, 
						'id_pais' => $pais->id_pais,
						'activo' => 1
					));
				}

				$perm = DB::select("select count(*) as num from permisos");
				// $id_user = 1;
				for ($i=1; $i <= $perm[0]->num ; $i++) { 
					if ( Input::has('permiso_'.$i) ) {
						$id_pe = explode('_', Input::get('permiso_'.$i) );
						$buscar = DB::select("SELECT * from permisos where id=".$id_pe[0]);
						DB::table('detalle_permiso')->insert(array(
							'id_usuario' => $id_user, 
							'id_permiso' => $buscar[0]->id,
							'perfil' => 1,
							'activo' => 1
						));

					}
				}
				return Response::json(array('error'=>0,'mensaje'=>'Se ha registrado con exito al Usuario'));

			}else{
				return Response::json(array('error'=>1,'mensaje'=>'Error al registrar el cliente'));
			}
		}
	}

	function ajax_validar_user(){
		$user = Input::get('user');
		$buscar = DB::select("select * from usuario where usuario='".$user."' ");
		if (count($buscar)>0) {
			return 1;
		}

		return 0;
	}
}
