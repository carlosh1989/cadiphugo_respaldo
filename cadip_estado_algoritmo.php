<?php 
require __DIR__ . '/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use DB\Eloquent;
use Models\Clap2;
use Models\Clap;
use Models\Familia;
use Models\Jefe;
new Eloquent();

$claps = Clap::all();
$clapConteo = Clap::count();
$counter = 0;
$total = $clapConteo;

foreach ($claps as $clap) 
{
	echo "\n";
	echo "---------------------------------------------------------------------\n";
	echo "\033[32m NOMBRE CLAP \033[0m: -> ".$clap->nombre_clap." \n";
	//comenzar a buscar por miembro de clap uno por uno
	echo "---------------------------------------------------------------------\n";
	//lider de comunidad
	if($clap->l_com_cedula)
	{
		echo "LIDER COMUNIDAD: ".$clap->nombre_comunidad."";

		//buscando a integrante en tabla de jefes de familia
		$jefe = Jefe::where('cedula',$clap->l_com_cedula)->first();
		$familiar = Familia::where('cedula',$clap->l_com_cedula)->first();

		$clapA = Clap2::where('cedula', $clap->l_com_cedula)->first();

		if($clapA)
		{
			$jefeUbicacion = Jefe::where('cod_municipio', $clapA->municipio_id)->where('cod_parroquia', $clapA->parroquia_id)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapA->municipio_id)->where('cod_parroquia', $clapA->parroquia_id)->first();

			if($clapA->status == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapA->validado = 1;
					$clapA->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapA->validado = 1;
						$clapA->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapA->validado = 0;
						$clapA->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapA->validado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapA->save();
			}

			if($jefe)
			{
				$clapA->bodega_id = $jefe->bodega;
				$clapA->save();
				echo "\033[32m -> Bodega: ".$clapA->bodega_id." \033[0m";
			}
			else
			{
				if($familiar)
				{
					$clapA->bodega_id = $familiar->bodega;
					$clapA->save();
					echo "\033[32m -> Bodega: ".$clapA->bodega_id." \033[0m";
				}
			}
		}
		else
		{
			//Guardando en la tabla a integrante	
			$clapAcreate = Clap2::create([
				'estado_id'   	 => $clap->id_estado,
				'municipio_id'	 => $clap->id_municipio,
				'parroquia_id'	 => $clap->id_parroquia,
				'clap_codigo' 	 => $clap->codigo_clap,
				'clap_nombre' 	 => $clap->nombre_clap, 
				'bodega_id'		 => '',
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '1',
				'tipo'        	 => $clap->tipo_comunidad,
				'cedula'      	 => $clap->l_com_cedula,
				'nombre_apellido'=> $clap->nombre_comunidad,
				'telefono'       => $clap->l_com_telefono,
				'status'     	 => 0,
				'validado'		 => 0,
				'consolidado'    => 0,
			]);

			$clapA = Clap2::find($clapAcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapA->status = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapA->status = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapA->status = 0;
					echo "\033[32m -> no esta registrado \033[0m";
				}
			}
		}


		$clapA->save();

		echo "\n";
		echo "\n";
	}

	//ubch
	if ($clap->l_ubch_cedula) 
	{
		echo "UBCH: ".$clap->nombre_ubch."";
		//buscando a integrante en tabla de jefes de familia
		$jefe = Jefe::where('cedula',$clap->l_ubch_cedula)->first();
		$familiar = Familia::where('cedula',$clap->l_ubch_cedula)->first();

		$clapB = Clap2::where('cedula', $clap->l_ubch_cedula)->first();

		if($clapB)
		{
			$jefeUbicacion = Jefe::where('cod_municipio', $clapB->municipio_id)->where('cod_parroquia', $clapB->parroquia_id)->first();			
			$familiarUbicacion = Familia::where('cod_municipio', $clapB->municipio_id)->where('cod_parroquia', $clapB->parroquia_id)->first();

			if($clapB->status == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapB->validado = 1;
					$clapB->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapB->validado = 1;
						$clapB->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapB->validado = 0;
						$clapB->save();
						echo "\033[32m -> No Registrado \033[0m";
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapB->validado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapB->save();
			}

			if($jefe)
			{
				$clapB->bodega_id = $jefe->bodega;
				$clapB->save();
				echo "\033[32m -> Bodega: ".$clapB->bodega_id." \033[0m";
			}
			else
			{
				if($familiar)
				{
					$clapB->bodega_id = $familiar->bodega;
					$clapB->save();
					echo "\033[32m -> Bodega: ".$clapB->bodega_id." \033[0m";
				}
			}
		}
		else
		{
			//Guardando en la tabla a integrante	
			$clapBcreate = Clap2::create([
				'estado_id'   	 => $clap->id_estado,
				'municipio_id'	 => $clap->id_municipio,
				'parroquia_id'	 => $clap->id_parroquia,
				'clap_codigo' 	 => $clap->codigo_clap,
				'clap_nombre' 	 => $clap->nombre_clap, 
				'bodega_id'		 => '',
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '2',
				'tipo'        	 => $clap->tipo_ubch,
				'cedula'      	 => $clap->l_ubch_cedula,
				'nombre_apellido'=> $clap->nombre_ubch,
				'telefono'       => $clap->l_ubch_telefono,
				'status'     	 => 0,
				'validado'		 => 0,
				'consolidado'    => 0,
			]);

			$clapB = Clap2::find($clapBcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapB->status = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapB->status = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapB->status = 0;
					echo "\033[32m -> no esta registrado \033[0m";
				}
			}
		}


		$clapB->save();

		echo "\n";
		echo "\n";
	}

	//una mujer
	if($clap->l_unamujer_cedula)
	{
		echo "UNA MUJER: ".$clap->nombre_unamujer."";
		//buscando a integrante en tabla de jefes de familia
		$jefe = Jefe::where('cedula',$clap->l_unamujer_cedula)->first();
		$familiar = Familia::where('cedula',$clap->l_unamujer_cedula)->first();

		$clapC = Clap2::where('cedula', $clap->l_unamujer_cedula)->first();

		if($clapC)
		{
			$jefeUbicacion = Jefe::where('cod_municipio', $clapC->municipio_id)->where('cod_parroquia', $clapC->parroquia_id)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapC->municipio_id)->where('cod_parroquia', $clapC->parroquia_id)->first();

			if($clapC->status == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapC->validado = 1;
					$clapC->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapC->validado = 1;
						$clapC->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapC->validado = 0;
						$clapC->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapC->validado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapC->save();
			}

			if($jefe)
			{
				$clapC->bodega_id = $jefe->bodega;
				$clapC->save();
				echo "\033[32m -> Bodega: ".$clapC->bodega_id." \033[0m";
			}
			else
			{
				if($familiar)
				{
					$clapC->bodega_id = $familiar->bodega;
					$clapC->save();
					echo "\033[32m -> Bodega: ".$clapC->bodega_id." \033[0m";
				}
			}
		}
		else
		{
			//Guardando en la tabla a integrante	
			$clapCcreate = Clap2::create([
				'estado_id'   	 => $clap->id_estado,
				'municipio_id'	 => $clap->id_municipio,
				'parroquia_id'	 => $clap->id_parroquia,
				'clap_codigo' 	 => $clap->codigo_clap,
				'clap_nombre' 	 => $clap->nombre_clap, 
				'bodega_id'		 => '',
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '3',
				'tipo'        	 => $clap->tipo_unamujer,
				'cedula'      	 => $clap->l_unamujer_cedula,
				'nombre_apellido'=> $clap->nombre_unamujer,
				'telefono'       => $clap->l_unamujer_cedula_telefono,
				'status'     	 => 0,
				'validado'		 => 0,
				'consolidado'    => 0,
			]);

			$clapC = Clap2::find($clapCcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapC->status = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapC->status = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapC->status = 0;
					echo "\033[32m -> no esta registrado \033[0m";
				}
			}
		}


		$clapC->save();

		echo "\n";
		echo "\n";
	}

	//Lider FFM
	if($clap->l_ffm_cedula)
	{
		echo "LIDER FFM: ".$clap->nombre_ffm."";
		//buscando a integrante en tabla de jefes de familia
		$jefe = Jefe::where('cedula',$clap->l_ffm_cedula)->first();
		$familiar = Familia::where('cedula',$clap->l_ffm_cedula)->first();

		$clapD = Clap2::where('cedula', $clap->l_ffm_cedula)->first();

		if($clapD)
		{
			$jefeUbicacion = Jefe::where('cod_municipio', $clapD->municipio_id)->where('cod_parroquia', $clapD->parroquia_id)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapD->municipio_id)->where('cod_parroquia', $clapD->parroquia_id)->first();

			if($clapD->status == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapD->validado = 1;
					$clapD->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapD->validado = 1;
						$clapD->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapD->validado = 0;
						$clapD->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapD->validado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapD->save();
			}

			if($jefe)
			{
				$clapD->bodega_id = $jefe->bodega;
				$clapD->save();
				echo "\033[32m -> Bodega: ".$clapD->bodega_id." \033[0m";
			}
			else
			{
				if($familiar)
				{
					$clapD->bodega_id = $familiar->bodega;
					$clapD->save();
					echo "\033[32m -> Bodega: ".$clapD->bodega_id." \033[0m";
				}
			}
		}
		else
		{
			//Guardando en la tabla a integrante	
			$clapDcreate = Clap2::create([
				'estado_id'   	 => $clap->id_estado,
				'municipio_id'	 => $clap->id_municipio,
				'parroquia_id'	 => $clap->id_parroquia,
				'clap_codigo' 	 => $clap->codigo_clap,
				'clap_nombre' 	 => $clap->nombre_clap, 
				'bodega_id'		 => '',
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '4',
				'tipo'        	 => $clap->tipo_ffm,
				'cedula'      	 => $clap->l_ffm_cedula,
				'nombre_apellido'=> $clap->nombre_ffm,
				'telefono'       => $clap->l_ffm_telefono,
				'status'     	 => 0,
				'validado'		 => 0,
				'consolidado'    => 0,
			]);

			$clapD = Clap2::find($clapDcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapD->status = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapD->status = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapD->status = 0;
					echo "\033[32m -> no esta registrado \033[0m";
				}
			}
		}


		$clapD->save();

		echo "\n";
		echo "\n";
	}

	//l_ccomunal
	if($clap->l_ccomunal_cedula)
	{
		echo "LIDER CONSEJO COMUNAL: ".$clap->nombre_ccomunal."";
		//buscando a integrante en tabla de jefes de familia
		$jefe = Jefe::where('cedula',$clap->l_ccomunal_cedula)->first();
		$familiar = Familia::where('cedula',$clap->l_ccomunal_cedula)->first();

		$clapE = Clap2::where('cedula', $clap->l_ccomunal_cedula)->first();

		if($clapE)
		{
			$jefeUbicacion = Jefe::where('cod_municipio', $clapE->municipio_id)->where('cod_parroquia', $clapE->parroquia_id)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapE->municipio_id)->where('cod_parroquia', $clapE->parroquia_id)->first();

			if($clapE->status == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapE->validado = 1;
					$clapE->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapE->validado = 1;
						$clapE->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapE->validado = 0;
						$clapE->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapE->validado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapE->save();
			}

			if($jefe)
			{
				$clapE->bodega_id = $jefe->bodega;
				$clapE->save();
				echo "\033[32m -> Bodega: ".$clapE->bodega_id." \033[0m";
			}
			else
			{
				if($familiar)
				{
					$clapE->bodega_id = $familiar->bodega;
					$clapE->save();
					echo "\033[32m -> Bodega: ".$clapE->bodega_id." \033[0m";
				}
			}
		}
		else
		{
			//Guardando en la tabla a integrante	
			$clapEcreate = Clap2::create([
				'estado_id'   	 => $clap->id_estado,
				'municipio_id'	 => $clap->id_municipio,
				'parroquia_id'	 => $clap->id_parroquia,
				'clap_codigo' 	 => $clap->codigo_clap,
				'clap_nombre' 	 => $clap->nombre_clap, 
				'bodega_id'		 => '',
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '5',
				'tipo'        	 => $clap->tipo_ccomunal,
				'cedula'      	 => $clap->l_ccomunal_cedula,
				'nombre_apellido'=> $clap->nombre_ccomunal,
				'telefono'       => $clap->l_ccomunal_telefono,
				'status'     	 => 0,
				'validado'		 => 0,
				'consolidado'    => 0,
			]);

			$clapE = Clap2::find($clapEcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapE->status = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapE->status = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapE->status = 0;
					echo "\033[32m -> no esta registrado \033[0m";
				}
			}
		}

		$clapE->save();

		echo "\n";
		echo "\n";
	}

	//Lider Milicia
	if($clap->l_milicia_cedula)
	{
		echo "MILICIA: ".$clap->nombre_milicia."";
		//buscando a integrante en tabla de jefes de familia
		$jefe = Jefe::where('cedula',$clap->l_ccomunal_cedula)->first();
		$familiar = Familia::where('cedula',$clap->l_ccomunal_cedula)->first();

		$clapF = Clap2::where('cedula', $clap->l_milicia_cedula)->first();

		if($clapF)
		{
			$jefeUbicacion = Jefe::where('cod_municipio', $clapF->municipio_id)->where('cod_parroquia', $clapF->parroquia_id)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapF->municipio_id)->where('cod_parroquia', $clapF->parroquia_id)->first();

			if($clapF->status == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapF->validado = 1;
					$clapF->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapF->validado = 1;
						$clapF->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapF->validado = 0;
						$clapF->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapF->validado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapF->save();
			}

			if($jefe)
			{
				$clapF->bodega_id = $jefe->bodega;
				$clapF->save();
				echo "\033[32m -> Bodega: ".$clapF->bodega_id." \033[0m";
			}
			else
			{
				if($familiar)
				{
					$clapF->bodega_id = $familiar->bodega;
					$clapF->save();
					echo "\033[32m -> Bodega: ".$clapF->bodega_id." \033[0m";
				}
			}
		}
		else
		{
			//Guardando en la tabla a integrante	
			$clapFcreate = Clap2::create([
				'estado_id'   	 => $clap->id_estado,
				'municipio_id'	 => $clap->id_municipio,
				'parroquia_id'	 => $clap->id_parroquia,
				'clap_codigo' 	 => $clap->codigo_clap,
				'clap_nombre' 	 => $clap->nombre_clap, 
				'bodega_id'		 => '',
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '6',
				'tipo'        	 => $clap->tipo_milicia,
				'cedula'      	 => $clap->l_milicia_cedula,
				'nombre_apellido'=> $clap->nombre_milicia,
				'telefono'       => $clap->l_milicia_telefono,
				'status'     	 => 0,
				'validado'		 => 0,
				'consolidado'    => 0,
			]);

			$clapF = Clap2::find($clapFcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapF->status = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapF->status = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapF->status = 0;
					echo "\033[32m -> no esta registrado \033[0m";
				}
			}
		}

		$clapF->save();
		echo "\n";
	}
	echo "---------------------------------------------------------------------\n";
  	$counter++;
    $percentage = $counter/$total;
	$percentage = floor(round( (($counter / $clapConteo) * 100), 1 ));
    echo "Progreso: ".$percentage."% \n";
	echo "---------------------------------------------------------------------\n";
	echo "\n";

}

