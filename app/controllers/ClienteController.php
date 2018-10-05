<?php

class ClienteController extends BaseController {

	function showRegistro(){
		$mercado = null;
		$cuidades = null;
		$pais = DB::select("select 
								c.*
							from
								usuario as a
								inner join paises_por_user as b on a.id=b.id_usuario
								inner join cat_paises as c on b.id_pais=c.id
							where 
								b.activo=1 and a.id=".Session::get('id_usuario')); 

		if ( count($pais) <= 1 ) {
			$mercado = DB::select("select 
										b.*
									from 	
										cat_mercado_pais as a 
										inner join cat_mercado as b on a.mercado=b.id
									where 
										a.id_pais=".$pais[0]->id);
			// $cuidades= DB::table('oficina_por_pais')->select('*')->where('id_pais',$pais[0]->id)->get();
			$cuidades= DB::select("select  
										* 
									from 
									 	user_pais_oficina as a 
									 	inner join oficina_por_pais as b on a.id_pais=b.id_pais and a.id_oficina=b.id
									where 
										a.id_pais = ".$pais[0]->id." and a.estatus and a.id_user=".Session::get('id_usuario')) ;
		}

		$estatus = Cat_status_cliente::all();
		$cat_pais = DB::select("select * from paises ");
		$cat_estados = DB::select("select * from estados_mexico order by estado asc ");
		return View::make('front.vista_alta_cliente',compact('pais','mercado','cuidades','estatus','cat_pais','cat_estados'));
	}

	function ajax_mercado(){
		$pais = Input::get('id_pais');
    	$datos =  DB::select("select 
								*
							from 
								cat_mercado_pais as a 
								inner join cat_mercado as b on a.mercado=b.id
							where 
								a.id_pais=".$pais);
    	$cuidad=DB::select("select  
								* 
							from 
							 	user_pais_oficina as a 
							 	inner join oficina_por_pais as b on a.id_pais=b.id_pais and a.id_oficina=b.id
							where 
								a.id_pais = ".$pais." and a.estatus and a.id_user=".Session::get('id_usuario'));
    	// $cuidad= DB::table('oficina_por_pais')->select('*')->where('id_pais',$pais)->get();
    	$tipos='';
    	$cuidades='';
    	foreach ($datos as $tip) {
			$tipos= $tipos."<option value='".$tip->id."' >".$tip->mercado."</option>";
		}
		foreach ($cuidad as $cuida) {
			$cuidades= $cuidades."<option value='".$cuida->id."' >".$cuida->oficina."</option>";
		}

    	return array('tipo'=>$tipos,'cuidades'=>$cuidades);
	}
	

	function ajax_segmento(){
		$mercado= Input::get('id_mercado');
		$pais = Input::get('id_pais');
    	$datos =  DB::select("select 
								*
							from 
								cat_mercado_segmento as a
							where 
								a.id_mercado=".$mercado." and a.id_pais=".$pais);
    	$tipos='';
    	foreach ($datos as $tip) {
			$tipos= $tipos."<option value='".$tip->id."' >".$tip->producto."</option>";
		}

    	return $tipos;
	}


	function registrar_cliente(){

		$validator = Validator::make(
		    array('razon' => Input::get('razon'),'nom_comer'=>Input::get('nom_comercial'),'sucursal'=>Input::get('sucursal'), 'mercado'=>Input::get('mer'), 'segmento'=>(Input::has('seg')) ? Input::get('seg') : Input::get('otro'),'pais'=>Input::get('pais'),'of_resp'=>Input::get('oficina')  ),
		    array('razon' => 'required','nom_comer' => 'required','sucursal' => 'required','mercado' => 'required','segmento' => 'required','of_resp' => 'required')
		);

		if (!$validator->fails() ){
			$razon =  strtoupper(Input::get('razon'));
			$nom_comer = strtoupper(Input::get('nom_comercial'));
			$sucursal = strtoupper(Input::get('sucursal'));
			$id_mercado = Input::get('mer');
			$id_segmento = Input::get('seg');
			$id_pais = Input::get('pais');
			$id_of_resp= Input::get('oficina');
			$zona= strtoupper(Input::get('zona'));

			$cliente = new Cliente();
			$cliente->razon = $razon;
			$cliente->nombre_comercial = $nom_comer;
			$cliente->sucursal = $sucursal;
			$cliente->id_mercado = $id_mercado;
			if (Input::has('seg')) {
				$cliente->id_segmento = $id_segmento;
			}else{
				$cliente->otro =strtoupper(Input::get('otro'));
			}
			
			$cliente->id_oficina_central = $id_of_resp;
			$cliente->id_pais = $id_pais;
			$cliente->zona = $zona;
			$cliente->cod_cliente = (Input::has('cod_cliente')) ?  strtoupper(Input::get('cod_cliente')) : null ;
			$cliente->id_estatus = (Input::has('estatus_client')) ?  Input::get('estatus_client') : null ;

			if ($cliente->save()) {
				$cont = Input::get('cont2');
				if ($id_pais == 1 ) {
					$direccion = new Direccion_mex();
					$direccion->id_cliente = $cliente->id;
					$direccion->calle = strtoupper(Input::get('calle'));
					$direccion->numero = strtoupper(Input::get('no'));
					$direccion->colonia = strtoupper(Input::get('col'));
					$direccion->cp = strtoupper(Input::get('cp'));
					$direccion->municipio = strtoupper(Input::get('muni'));
					$direccion->id_estado = strtoupper(Input::get('estado'));
					$direccion->id_pais = Input::get('pais_cli');
					$direccion->otro = (Input::has('otro_es') ) ? strtoupper(Input::get('otro_es')) : null ;
					$direccion->save();
				}else{
					$direccion = new Direccion_paises();
					$direccion->direccion= strtoupper(Input::get('direccion'));
					$direccion->id_cliente = $cliente->id;
					$direccion->id_pais =$id_pais;
					$direccion->provincia = strtoupper(Input::get('provincia'));
					$direccion->otro = (Input::has('otro_es') ) ? strtoupper(Input::get('otro_es')) : null ;
					$direccion->save();
				}
				$client = Cliente::find($cliente->id);
				$cod_pais = DB::table('cat_paises')->select('*')->where('id',$id_pais)->get();
				$consecutivo = DB::select("SELECT consecutivo  from cliente where id_pais = ".$id_pais."  order by id desc limit 1");
				$client->cod_unico = $cod_pais[0]->cod.$consecutivo[0]->consecutivo ;			
				$client->save(); 

				for ($i=1; $i <= $cont ; $i++) { 
					if(Input::get('nom_contac'.$i ) ){
						$contacto = new Contacto();
						$contacto->id_cliente = $cliente->id;
						$contacto->nombre = strtoupper(Input::get('nom_contac'.$i ));
						$contacto->cargo = strtoupper(Input::get('car_contac'.$i ));
						$contacto->tel = Input::get('tel_contac'.$i );
						$contacto->cel = Input::get('mov_contac'.$i );
						$contacto->correo = Input::get('correo_contac'.$i );
						$contacto->save();
					}
				}
				return Response::json(array('error'=>0,'mensaje'=>'Se ha registrado con exito el Cliente'));

			}else{
				return Response::json(array('error'=>1,'mensaje'=>'Error al registrar el cliente'));
			}		

		}else{
			return Response::json(array('error'=>1,'mensaje'=>$validator->failed() ));
		}
	}

	function consultar_clientes(){
		$cuid =DB::select("select distinct
									b.id,concat(b.oficina,' - ', c.pais) as cuidad,b.oficina
								FROM 	
									cliente as a
									inner join oficina_por_pais as b on a.id_oficina_central=b.id
									inner join cat_paises as c on b.id_pais=c.id
									inner join user_pais_oficina as d on b.id=d.id_oficina and b.id_pais=d.id_pais
								where 
									a.id_pais in ((select id_pais from paises_por_user where id_usuario=".Session::get('id_usuario')." and activo=1)) and b.id in (select id_oficina from user_pais_oficina where id_user=".Session::get('id_usuario')." and estatus = 1)
								order by
									b.oficina");
		// dd($cuid);
		
		if ( count($cuid) > 1) {
			$mercado = null;
			// $cuids = null;
			
			$pais = DB::select("select 
									c.*
								from
									usuario as a
									inner join paises_por_user as b on a.id=b.id_usuario
									inner join cat_paises as c on b.id_pais=c.id
								where 
									b.activo=1 and a.id=".Session::get('id_usuario')); 
			if ( count($pais) <= 1 ) {
				$mercado = DB::select("select 
											b.*
										from 	
											cat_mercado_pais as a 
											inner join cat_mercado as b on a.mercado=b.id
										where 
											a.id_pais=".$pais[0]->id);
				// $cuids= DB::table('oficina_por_pais')->select('*')->where('id_pais',$pais[0]->id)->get();
			}

			
			return View::make('front.reg_ventas',compact('cuid', 'pais' ,'mercado','estatus'));
		}else{
			if ( count($cuid) > 0) {
				$id_of=$cuid[0]->id;
				return $this->info_consulta($id_of,1);
			}else{
				return View::make('front.reg_ventas',compact('cuid'));
			}
			// $datos=DB::select("select
			// 						a.*,b.mercado,c.producto,d.oficina,e.estatus,f.estatus as es_de ,g.pais,h.area
			// 					from
			// 						cliente as a
			// 						inner join cat_mercado as b on a.id_mercado=b.id
			// 						left join cat_mercado_segmento as c on c.id=a.id_segmento
			// 						inner join oficina_por_pais as d on a.id_oficina_central=d.id
			// 						left join cat_status_cliente as e on a.id_estatus=e.id
			// 						left join 	cat_estatus_detalle as f on a.id_estatus_detalle=f.id
			// 						inner join cat_paises as g on a.id_pais=g.id
			// 						left join cat_area_venta as h on h.id=a.area_venta
			// 					where 
			// 						id_oficina_central = ".$id_of);

			// $area_de_venta = DB::select("select * from cat_area_venta where id_pais =".$datos[0]->id_pais); 
			// // $cuidadess= DB::table('oficina_por_pais')->select('*')->where('id_pais',$datos[0]->id_pais)->get();
			// $mercado = DB::select("select b.* from   cat_mercado_pais as a inner join cat_mercado as b on a.mercado=b.id where a.id_pais=".$datos[0]->id_pais);
	  //  		$estatus_deta = DB::select("select * from cat_estatus_detalle");
	  //  		$cat_pais = DB::select("select * from paises ");
			// $cat_estados = DB::select("select * from estados_mexico ");
	  //        // dd($datos);
	  //  		return View::make('front.reg_ventas',compact('datos', 'area_de_venta' ,'cuidades','estatus','mercado','estatus_deta','pais','cat_pais','cat_estados'));
			// // return Redirect::to('/consultar_clientes2')->with(array('datos'=>$datos,'area_de_venta'=> $area_de_venta,'cuidadess'=>$cuidadess, 'estatus'=>$estatus,'mercado'=>$mercado,'estatus_deta'=>$estatus_deta,'pais'=>$pais));
		}
			
	}


	function consulta(){
		$id_of = Input::get('id_of');		
		return $this->info_consulta($id_of,2);
		
		

		
		
	}

	function info_consulta($id_of,$tipo){
		$cuid =DB::select("select distinct
									b.id,concat(b.oficina,' - ', c.pais) as cuidad,b.oficina
								FROM 	
									cliente as a
									inner join oficina_por_pais as b on a.id_oficina_central=b.id
									inner join cat_paises as c on b.id_pais=c.id
									inner join user_pais_oficina as d on b.id=d.id_oficina and b.id_pais=d.id_pais
								where 
									a.id_pais in ((select id_pais from paises_por_user where id_usuario=".Session::get('id_usuario')." and activo=1)) and b.id in (select id_oficina from user_pais_oficina where id_user=".Session::get('id_usuario')." and estatus = 1)
								order by
									b.oficina");

		
		

		$pais = DB::select("select 
									c.*
								from
									usuario as a
									inner join paises_por_user as b on a.id=b.id_usuario
									inner join cat_paises as c on b.id_pais=c.id
								where 
									b.activo=1 and a.id=".Session::get('id_usuario')); 
		$estatus = Cat_status_cliente::all();
		$of = DB::select("select * from oficina_por_pais where id =".$id_of);
		if ($of[0]->id_pais == 1) {
			$sql = 'left join direccion_mexico as i on a.id=i.id_cliente left join estados_mexico as j on i.id_estado=j.id left join paises as k on i.id_pais=k.id';
			$sql2='i.calle,i.numero,i.colonia,i.cp,i.municipio,i.id_estado,i.id_pais as id_pp,i.otro as otr ,j.estado,k.id as id_ppa, k.pais as ppais ';
		}else{
			$sql ='left join direccion_pais as i on a.id=i.id_cliente';
			$sql2='i.direccion,i.provincia,i.otro';
		}
		$datos=DB::select("select
								a.*,b.mercado,c.producto,d.oficina,e.estatus,f.estatus as es_de ,g.pais,h.area,".$sql2."
							from
								cliente as a
								inner join cat_mercado as b on a.id_mercado=b.id
								left join cat_mercado_segmento as c on c.id=a.id_segmento
								inner join oficina_por_pais as d on a.id_oficina_central=d.id
								left join cat_status_cliente as e on a.id_estatus=e.id
								left join 	cat_estatus_detalle as f on a.id_estatus_detalle=f.id
								inner join cat_paises as g on a.id_pais=g.id
								left join cat_area_venta as h on h.id=a.area_venta
								".$sql."
							where 
								id_oficina_central = ".$id_of);

		$area_de_venta = DB::select("select * from cat_area_venta where id_pais =".$datos[0]->id_pais); 

		$cuidadess= DB::select("select  
										* 
									from 
									 	user_pais_oficina as a 
									 	inner join oficina_por_pais as b on a.id_pais=b.id_pais and a.id_oficina=b.id
									where 
										a.id_pais = ".$datos[0]->id_pais." and a.estatus=1 and a.id_user=".Session::get('id_usuario')) ;
		
		$mercado = DB::select("select b.* from   cat_mercado_pais as a inner join cat_mercado as b on a.mercado=b.id where a.id_pais=".$datos[0]->id_pais);
   		$estatus_deta = DB::select("select * from cat_estatus_detalle");
         // dd($datos);
   		$cat_pais = DB::select("select * from paises ");
		$cat_estados = DB::select("select * from estados_mexico order by estado asc ");

		if ($tipo==2) {
			return Redirect::to('/consultar_clientes')->with(array('datos'=>$datos,'area_de_venta'=> $area_de_venta,'cuidadess'=>$cuidadess,'mercado'=>$mercado,'estatus_deta'=>$estatus_deta,'cat_estados'=>$cat_estados,'cat_pais'=>$cat_pais,'estatus'=>$estatus,'cuidades'=>$cuid ));
		}else{
			return View::make('front.reg_ventas',compact('datos', 'area_de_venta' ,'cuidadess','estatus','mercado','estatus_deta','pais','cat_pais','cat_estados','cuid'));
		}
		// return Redirect::to('/consultar_clientes')->with(array('datos'=>$datos,'area_de_venta'=> $area_de_venta,'cuidadess'=>$cuidadess,'mercado'=>$mercado,'estatus_deta'=>$estatus_deta,'cat_estados'=>$cat_estados,'cat_pais'=>$cat_pais));

		
	}


	function actualizar_cliente()
	{
		$validator = Validator::make(
		    array('razon' => Input::get('razon'),'nom_comer'=>Input::get('nom_comercial'),'sucursal'=>Input::get('sucursal'), 'mercado'=>Input::get('mer'), 'segmento'=>(Input::has('seg')) ? Input::get('seg') : Input::get('otro'),'pais'=>Input::get('pais'),'of_resp'=>Input::get('oficina')  ),
		    array('razon' => 'required','nom_comer' => 'required','sucursal' => 'required','mercado' => 'required','segmento' => 'required','of_resp' => 'required')
		);

		if (!$validator->fails() ){
			$razon = strtoupper(Input::get('razon'));
			$nom_comer = strtoupper(Input::get('nom_comercial'));
			$sucursal = strtoupper(Input::get('sucursal'));
			$id_mercado = Input::get('mer');
			
			$id_pais = Input::get('pais');
			$id_of_resp= Input::get('oficina');
			$zona= strtoupper(Input::get('zona'));

			$id_cliente = Input::get('id_cliente');

			$cliente = Cliente::find($id_cliente);
			$cliente->razon = $razon;
			$cliente->nombre_comercial = $nom_comer;
			$cliente->sucursal = $sucursal;
			$cliente->id_mercado = $id_mercado;

			$bandera = Input::get('bandera');
			if ($bandera == 0) {
				$id_segmento = Input::get('seg');
				$cliente->id_segmento = $id_segmento;
				$cliente->otro =null;
			}else{
				$cliente->id_segmento= null;
				$cliente->otro =strtoupper(Input::get('otro'));
			}
			
			$cliente->id_oficina_central = $id_of_resp;
			// $cliente->id_pais = $id_pais;
			$cliente->zona = $zona;
			$cliente->cod_cliente = (Input::has('cod_cliente')) ?  strtoupper(Input::get('cod_cliente')) : null ;
			$cliente->id_estatus = (Input::has('estatus_client')) ?  Input::get('estatus_client') : null ;
			$cliente->id_estatus_detalle =  (Input::has('estatus_detalle')) ?  Input::get('estatus_detalle') : null ;
			$cliente->area_venta =  (Input::has('area_de_venta')) ?  Input::get('area_de_venta') : null ;
			$cliente->cliente_dis =  (Input::has('cliente_d')) ?  Input::get('cliente_d') : null ;
			$cliente->fecha_estatus = (Input::has('fecha_esta')) ?  Input::get('fecha_esta') : null ;

			if ($cliente->save()) {
				$cont = Input::get('cont2');
				if ($id_pais == 1 ) {
					$buscar = Direccion_mex::where('id_cliente',$id_cliente)->get();
					if ( count($buscar)>0 ) {
						$direccion = Direccion_mex::where('id_cliente',$id_cliente)->update(array(
									'calle' => strtoupper(Input::get('calle')),
									'numero' => Input::get('no'),
									'colonia' => strtoupper(Input::get('col')),
									'cp' => strtoupper(Input::get('cp')),
									'municipio' => strtoupper(Input::get('muni')),
									'id_estado' => strtoupper(Input::get('estado')),
									'id_pais' => strtoupper(Input::get('pais_cli')),
									'otro' => strtoupper(Input::get('otro_es')
								)
							));
					}else{
						$direccion = new Direccion_mex();
						$direccion->id_cliente = $cliente->id;
						$direccion->calle = strtoupper(Input::get('calle'));
						$direccion->numero = Input::get('no');
						$direccion->colonia = strtoupper(Input::get('col'));
						$direccion->cp = strtoupper(Input::get('cp'));
						$direccion->municipio = strtoupper(Input::get('muni'));
						$direccion->id_estado = strtoupper(Input::get('estado'));
						$direccion->id_pais = Input::get('pais_cli');
						$direccion->otro = strtoupper(Input::get('otro_es')) ;
						$direccion->save();
					}
					
					
				}else{
					$buscar = Direccion_paises::where('id_cliente',$id_cliente)->get();
					if (count($buscar)>0) {
						$direccion = Direccion_paises::where('id_cliente',$id_cliente)->update(array(
									'direccion' => strtoupper(Input::get('direccion')),
									'provincia' => strtoupper(Input::get('provincia')),
									'otro' => strtoupper(Input::get('otro_es'))
							));
					}else{
						$direccion = new Direccion_paises();
						$direccion->direccion= strtoupper(Input::get('direccion'));
						$direccion->id_cliente = $cliente->id;
						$direccion->id_pais =$id_pais;
						$direccion->provincia = strtoupper(Input::get('provincia'));
						$direccion->otro = strtoupper(Input::get('otro_es'));
						$direccion->save();
					}
					
				}
				Contacto::where('id_cliente', $id_cliente )->delete();
				for ($i=1; $i <= 3 ; $i++) { 
					if(Input::get('nom_contac'.$i ) ){
						$contacto = new Contacto();
						$contacto->id_cliente = $cliente->id;
						$contacto->nombre = strtoupper(Input::get('nom_contac'.$i ));
						$contacto->cargo = strtoupper(Input::get('car_contac'.$i ));
						$contacto->tel = Input::get('tel_contac'.$i );
						$contacto->cel = Input::get('mov_contac'.$i );
						$contacto->correo = strtoupper(Input::get('correo_contac'.$i ));
						$contacto->save();
					}
				}
				return Response::json(array('error'=>0,'mensaje'=>'Se ha actualizado con exito el Cliente'));

			}else{
				return Response::json(array('error'=>1,'mensaje'=>'Error al registrar el cliente'));
			}		

		}else{
			return Response::json(array('error'=>1,'mensaje'=>$validator->failed() ));
		}
	}
// aquin

function consulta_usuario(){
		$id_pais = Input::get('pais');
        $oficina = Input::get('oficina');

		$usuarios=DB::select("select b.id , concat(b.nombre,' ',b.paterno,' ',b.materno,' (',c.oficina,')') as usuarios from user_pais_oficina a inner join usuario b on a.id_user=b.id inner join oficina_por_pais c on c.id=a.id_oficina  where a.id_pais=".$id_pais." and a.id_oficina=".$oficina);
        
		return Response::json(array('usuario'=>$usuarios));
	}

	function registra(){
		$fecha = Input::get('fecha');
		$motivo = Input::get('motivo');
		$usuario = Input::get('usuario');
		$cliente = Input::get('cliente');
		$otro_motivo=Input::get('otro_motivo');
		$hora = Input::get('hora');

		DB::table('labor_venta')->insert(
			    		array('idventa'=>'default',
			    			  'fecha_labor_venta' => $fecha." ".$hora,
			    		      'motivo' =>$motivo,
			    		      'otro_motivo'=>$otro_motivo,
			    		      'id_usuario'=> $usuario,
			    		      'cliente'=>$cliente,
			    		      'estatus'=>1,
			    		      'fecha_creacion'=>date('Y-m-d'),
			    		      'fecha_cierre'=>date('Y-m-d'))
							  );
		$validar=DB::select("select * from labor_venta where fecha_labor_venta='".$fecha." ".$hora."' and motivo='".$motivo."' and id_usuario=".$usuario); 
         $valida=0;
         if (count($validar)>0) {
         	$valida=1;
         }else{
         	$valida=0;
         }

		return Response::json(array('valida'=>$valida));

	}

	function consulta_labor(){
		$ciudades =DB::select("select distinct
									b.id,concat(b.oficina,' - ', c.pais) as cuidad
								FROM 	
									cliente as a
									inner join oficina_por_pais as b on a.id_oficina_central=b.id
									inner join cat_paises as c on b.id_pais=c.id
								where 
									a.id_pais in ((select id_pais from paises_por_user where id_usuario=".Session::get('id_usuario')."))
								order by
									b.oficina");

	 //dd($cuidades);
	 // dd(Session::get('id_usuario'));

		return View::make('front.consulta_labor_venta',compact('ciudades'));
	}

	function consulta_bitacora(){
		$ciudades =DB::select("select distinct
									b.id,concat(b.oficina,' - ', c.pais) as cuidad
								FROM 	
									cliente as a
									inner join oficina_por_pais as b on a.id_oficina_central=b.id
									inner join cat_paises as c on b.id_pais=c.id
								where 
									a.id_pais in ((select id_pais from paises_por_user where id_usuario=".Session::get('id_usuario')."))
								order by
									b.oficina");

	 //dd($cuidades);
	 // dd(Session::get('id_usuario'));

		return View::make('front.Bitacora',compact('ciudades'));
	}

	function consulta1(){
		// $id_of = Input::get('id_of');
		$datos=DB::select("SELECT a.id_pais,a.id_oficina_central,b.motivo_cancelacion, b.idventa,b.otro_motivo, b.estatus as estatus_labor,b.idventa,b.cliente,b.fecha_labor_venta, b.motivo,a.razon,a.nombre_comercial,a.sucursal,c.estatus,concat(d.nombre,' ',d.paterno,' ',d.materno) as usuario ,(select count(*) from paises_por_user where id_pais=1 and id_usuario=d.id) as permiso
								FROM cliente a
								INNER JOIN labor_venta b ON a.cod_unico=b.cliente
								left JOIN cat_status_cliente c on a.id_estatus=c.id
								left JOIN usuario d on b.id_usuario=d.id  where d.id=".Session::get('id_usuario'));
		
         
		// return Redirect::to('/consultar_labor')->with(array('datos'=>$info));
		return View::make('front.consulta_labor_venta',compact('datos'));

	}

	function registrar_actividad(){
		return View::make('front.registrar_actividad_labor');
		}

	function registrar_plan(){

        $plan=new Plan();
		$id_plan_labor_venta = 'default';
		$plan->id_agenda=Input::get('idagenda');
		$plan->id_user_cerrar=Session::get('id_usuario');
		$plan->fecha_plan = Input::get('fecha');
		$plan->actividad = Input::get('acti');
		$plan->persona_contacto = Input::get('per1');
		$plan->puesto = Input::get('puesto1');
		$plan->telefono = Input::get('telefono1');
		$plan->correo = Input::get('correo1');
		$plan->persona_contacto1 = Input::get('per2');
		$plan->puesto1 = Input::get('puesto2');
		$plan->telefono1 = Input::get('telefono2');
		$plan->correo1 = Input::get('correo2');
		$plan->persona_contacto2 = Input::get('per3');		
		$plan->puesto2 = Input::get('puesto3');	
		$plan->telefono2 = Input::get('telefono3');	
		$plan->correo2 = Input::get('correo3');
        $plan->requerimiento = Input::get('requerimiento');
        $plan->otro_requerimiento = Input::get('otro_requerimiento');
        $plan->detalle = Input::get('detalle');
        $plan->act_seguimiento = Input::get('act_seguimiento');
        $plan->otro_actividad = Input::get('otro_act');
        $plan->responsable_segui = Input::get('responsable_segui');     
        $plan->correo_rep = Input::get('correo_resp');
        $plan->fecha_com = Input::get('fecha_com');
        $plan->indicaciones = Input::get('indicaciones');
        $plan->comentarios = Input::get('comentarios');
        $plan->fecha_prox = Input::get('date_range')." ".Input::get('hora');
        $plan->confirmacion_actividad = "En espera";
        $plan->comentario_confirmacion = "En espera";

        $cliente=Input::get('cliente');
        $fecha_labor=Input::get('fecha_labor');
        $id_agenda=Input::get('idagenda');
        $fecha_validar = Input::get('date_range');
        $hora = Input::get('hora');
              
		$datos=DB::select("select * from labor_venta where idventa=".$id_agenda);
		$fecha_actual=date('Y-m-d');
        $fecha_actual1=$fecha_actual." - ".$fecha_actual;
         
        if ($fecha_validar!=$fecha_actual) {

        	DB::table('labor_venta')->insert(
			    		array('idventa'=>'default',
			    			  'fecha_labor_venta' => $fecha_validar." ".$hora,
			    		      'motivo' =>$datos[0]->motivo,
			    		      'otro_motivo'=>$datos[0]->otro_motivo,
			    		      'id_usuario'=> $datos[0]->id_usuario,
			    		      'cliente'=>$datos[0]->cliente,
			    		      'estatus'=>1,
			    		      'fecha_creacion'=>date('Y-m-d'),
			    		      'fecha_cierre'=>date('Y-m-d'))
							  );
        }
		
         $valida=0;
         if ($plan->save()) {
         	DB::table('labor_venta')
	            ->where('cliente', $cliente)
	            ->where('fecha_labor_venta',$fecha_labor)
	            ->update(array('estatus' => 2,'fecha_cierre'=>date('Y-m-d')));
         	$valida=1;
         }else{
         	$valida=0;
         }

		return Response::json(array('valida'=>$valida));


		
		// // $id_plan_labor_venta = 'default';
		// $fecha_plan = Input::get('fecha');
		// $actividad = Input::get('acti');
		// $persona_contacto = Input::get('per1');
		// $persona_contacto1 = Input::get('per2');
		// $persona_contacto2 = Input::get('per3');
		// $puesto = Input::get('puesto1');
		// $puesto1 = Input::get('puesto2');
		// $puesto2 = Input::get('puesto3');
		// $telefono = Input::get('telefono1');
		// $telefono1 = Input::get('telefono2');
		// $telefono2 = Input::get('telefono3');
		// $correo = Input::get('correo1');
		// $correo1 = Input::get('correo2');
		// $correo2 = Input::get('correo3');
  //       $requerimiento = Input::get('requerimiento');
  //       $otro_requerimiento = Input::get('otro_requerimiento');
  //       $detalle = Input::get('detalle');
  //       $act_seguimiento = Input::get('act_seguimiento');
  //       $otro_actividad = Input::get('otro_act');
  //       $responsable_segui = Input::get('responsable_segui');     
  //       $correo_rep = Input::get('correo_resp');
  //       $fecha_com = Input::get('fecha_com');
  //       $indicaciones = Input::get('indicaciones');
  //       $comentarios = Input::get('comentarios');
  //       $fecha_prox = Input::get('date_range');


  //       $cliente=Input::get('cliente');



       
		// DB::table('plan_labor_venta')->insert(
		// 	    		array('id_plan_labor_venta'=>'default',
		// 	    			  'fecha_plan' => $fecha_plan,
		// 	    		      'actividad' =>$actividad,
		// 	    		      'persona_contacto'=>$persona_contacto,
		// 	    		      'puesto'=> $puesto,
		// 	    		      'telefono'=>$telefono,
		// 	    		      'correo'=>$correo,
		// 	    		      'persona_contacto1'=>$persona_contacto1,
		// 	    		      'puesto1'=>$puesto1,
		// 	    		      'telefono1'=>$telefono1,
		// 	    		      'correo1'=>$correo1,
		// 	    		      'persona_contacto2'=>$persona_contacto2,
		// 	    		      'puesto2'=>$puesto2,
		// 	    		      'telefono2'=>$telefono2,
		// 	    		      'correo2'=>$correo2,
		// 	    		      'requerimiento'=>$requerimiento,
		// 	    		      'otro_requerimiento'=>$otro_requerimiento,
		// 	    		      'detalle'=>$detalle,
		// 	    		      'act_seguimiento'=>$act_seguimiento,
		// 	    		      'otro_actividad'=>$otro_actividad,
		// 	    		      'responsable_segui'=>$responsable_segui,
		// 	    		      'correo_rep'=>$correo_rep,
		// 	    		      'fecha_com'=>$fecha_com,
		// 	    		      'indicaciones'=>$indicaciones,
		// 	    		      'comentarios'=>$comentarios,
		// 	    		      'fecha_prox'=>$fecha_prox)
		// 					  );
		// $validar=DB::select("select * from plan_labor_venta where fecha_plan='".$fecha_plan."' and actividad='".$actividad."' and persona_contacto='".$persona_contacto."'");
  //        $valida=0;
  //        if (count($validar)>0) {
  //        	$valida=1;
  //        }else{
  //        	$valida=0;
  //        }

		// return Response::json(array('valida'=>$valida));

	}

	function eliminar_plan(){
		$id_agenda=Input::get('id_agenda');

		 DB::table('plan_labor_venta')->where('id_agenda',$id_agenda)->delete();

         DB::table('labor_venta')
	            ->where('idventa', $id_agenda)	           
	            ->update(array('estatus' => 1));

	     $validar=DB::select("select * from plan_labor_venta where id_agenda=".$id_agenda);

    $valida=0;
         if (count($validar)>0) {
         	$valida=0;
         }else{
         	$valida=1;
         }

		return Response::json(array('valida'=>$valida));

	}

	function cancelar_plan(){
        $id_agenda=Input::get('id_agenda');
        $mot_cancelacion=Input::get('cancelacion');

         DB::table('labor_venta')
	            ->where('idventa', $id_agenda)	           
	            ->update(array('estatus' => 3,'motivo_cancelacion'=>$mot_cancelacion));

	    $validar=DB::select("select * from labor_venta where idventa=".$id_agenda." and estatus=3");

    $valida=0;
         if (count($validar)>0) {
         	$valida=1;
         }else{
         	$valida=0;
         }

		return Response::json(array('valida'=>$valida));        

	}

	function alta_user(){
		echo "string";
	}


    function consulta_bita(){
		$id_of = Input::get('id_of');
		// dd($id_of);
		$datos=DB::select("select *,e.estatus as estatus_cliente,a.estatus as estatus_labor from
								labor_venta a
								INNER JOIN plan_labor_venta b   ON a.idventa=b.id_agenda
								INNER JOIN cliente c ON a.cliente=c.cod_unico
								INNER JOIN usuario d ON b.responsable_segui=d.id
								INNER JOIN cat_status_cliente e on c.id_estatus=e.id
								WHERE b.responsable_segui=".Session::get('id_usuario')." or b.id_user_cerrar=".Session::get('id_usuario'));
		
         // dd($datos);
		// return Redirect::to('/consultar_bitacora')->with(array('datos'=>$info));
		return View::make('front.Bitacora',compact('datos'));


	}

	function informacion(){
		$infor=DB::select("select *,e.estatus as estatus_cliente,a.estatus as estatus_labor from
								 labor_venta a 
								 INNER JOIN plan_labor_venta b   ON a.idventa=b.id_agenda  
								 INNER JOIN cliente c ON a.cliente=c.cod_unico
								 INNER JOIN usuario d ON a.id_usuario=d.id
								 INNER JOIN cat_status_cliente e on c.id_estatus=e.id
								 WHERE b.id_plan_labor_venta=1");
      // dd($infor);
		// return View::make('front.informacion');
		  return View::make('front.informacion',compact('infor'));
	}

	function enviar(){
		
		Mail::send('front.enviar', array('key' => 'Hola'), function($message)
			{
			    $message->to('jose.costet@iebem.edu.mx', 'tu hombre');
				$message->from('jose.costet@iebem.edu.mx', 'tu hombre');
				$message->subject('Prueba');
			});
	}

	function consulta_correo(){
		$id_responsable = Input::get('id_responsable');
	 
	    $correo=DB::select("select correo from usuario where id=".$id_responsable);

	    return Response::json(array('correo'=>$correo));

	}

	function registrar_seguimiento(){
		$respuesta = Input::get('respuesta');
		$comentario = Input::get('comentario');
		$fecha_envio = Input::get('fecha_envio');
		$cotizacion = Input::get('cotizacion');
		$compromiso = Input::get('compromiso');
		$id = Input::get('id');

		 DB::table('plan_labor_venta')
	            ->where('id_agenda', $id)	           
	            ->update(array('confirmacion_actividad' => $respuesta,'comentario_confirmacion'=>$comentario,'fecha_envio'=>$fecha_envio,'cotizacion'=>$cotizacion,'fecha_compromiso'=>$compromiso));


        
         $valida=1;
        return Response::json(array('valida'=>$valida));  
         	

	}	

}
