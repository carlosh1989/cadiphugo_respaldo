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
			$jefeUbicacion = Jefe::where('cod_municipio', $clapA->id_municipio)->where('cod_parroquia', $clapA->id_parroquia)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapA->id_municipio)->where('cod_parroquia', $clapA->id_parroquia)->first();

			if($clapA->registrado == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapA->ubicado = 1;
					$clapA->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapA->ubicado = 1;
						$clapA->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapA->ubicado = 0;
						$clapA->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapA->ubicado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapA->save();
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
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '1',
				'tipo'        	 => $clap->tipo_comunidad,
				'cedula'      	 => $clap->l_com_cedula,
				'nombre_apellido'=> $clap->nombre_comunidad,
				'telefono'       => $clap->l_com_telefono,
				'registrado'     => '',
				'ubicado'		 => '',
			]);

			$clapA = Clap2::find($clapAcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapA->registrado = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapA->registrado = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapA->registrado = 0;
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
			$jefeUbicacion = Jefe::where('cod_municipio', $clapB->id_municipio)->where('cod_parroquia', $clapB->id_parroquia)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapB->id_municipio)->where('cod_parroquia', $clapB->id_parroquia)->first();

			if($clapA->registrado == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapB->ubicado = 1;
					$clapB->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapB->ubicado = 1;
						$clapB->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapB->ubicado = 0;
						$clapB->save();
						echo "\033[32m -> No Registrado \033[0m";
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapA->ubicado = 0;
				echo "\033[32m -> No Registrado \033[0m";echo "\033[32m -> No Ubicado \033[0m";
				$clapA->save();
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
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '2',
				'tipo'        	 => $clap->tipo_ubch,
				'cedula'      	 => $clap->l_ubch_cedula,
				'nombre_apellido'=> $clap->nombre_ubch,
				'telefono'       => $clap->l_ubch_telefono,
				'registrado'     => '',
				'ubicado'		 => '',
			]);

			$clapB = Clap2::find($clapBcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapB->registrado = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapB->registrado = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapB->registrado = 0;
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
			$jefeUbicacion = Jefe::where('cod_municipio', $clapC->id_municipio)->where('cod_parroquia', $clapC->id_parroquia)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapC->id_municipio)->where('cod_parroquia', $clapC->id_parroquia)->first();

			if($clapC->registrado == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapC->ubicado = 1;
					$clapC->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapC->ubicado = 1;
						$clapC->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapC->ubicado = 0;
						$clapC->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapC->ubicado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapC->save();
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
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '3',
				'tipo'        	 => $clap->tipo_unamujer,
				'cedula'      	 => $clap->l_unamujer_cedula,
				'nombre_apellido'=> $clap->nombre_unamujer,
				'telefono'       => $clap->l_unamujer_cedula_telefono,
				'registrado'     => '',
				'ubicado'		 => '',
			]);

			$clapC = Clap2::find($clapCcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapC->registrado = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapC->registrado = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapC->registrado = 0;
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
			$jefeUbicacion = Jefe::where('cod_municipio', $clapD->id_municipio)->where('cod_parroquia', $clapD->id_parroquia)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapD->id_municipio)->where('cod_parroquia', $clapD->id_parroquia)->first();

			if($clapD->registrado == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapD->ubicado = 1;
					$clapD->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapD->ubicado = 1;
						$clapD->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapD->ubicado = 0;
						$clapD->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapD->ubicado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapD->save();
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
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '4',
				'tipo'        	 => $clap->tipo_ffm,
				'cedula'      	 => $clap->l_ffm_cedula,
				'nombre_apellido'=> $clap->nombre_ffm,
				'telefono'       => $clap->l_ffm_telefono,
				'registrado'     => '',
				'ubicado'		 => '',
			]);

			$clapD = Clap2::find($clapDcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapD->registrado = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapD->registrado = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapD->registrado = 0;
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
			$jefeUbicacion = Jefe::where('cod_municipio', $clapE->id_municipio)->where('cod_parroquia', $clapE->id_parroquia)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapE->id_municipio)->where('cod_parroquia', $clapE->id_parroquia)->first();

			if($clapE->registrado == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapE->ubicado = 1;
					$clapE->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapE->ubicado = 1;
						$clapE->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapE->ubicado = 0;
						$clapE->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapE->ubicado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapE->save();
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
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '5',
				'tipo'        	 => $clap->tipo_ccomunal,
				'cedula'      	 => $clap->l_ccomunal_cedula,
				'nombre_apellido'=> $clap->nombre_ccomunal,
				'telefono'       => $clap->l_ccomunal_telefono,
				'registrado'     => '',
				'ubicado'		 => '',
			]);

			$clapE = Clap2::find($clapEcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapE->registrado = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapE->registrado = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapE->registrado = 0;
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
			$jefeUbicacion = Jefe::where('cod_municipio', $clapF->id_municipio)->where('cod_parroquia', $clapF->id_parroquia)->first();
			$familiarUbicacion = Familia::where('cod_municipio', $clapF->id_municipio)->where('cod_parroquia', $clapF->id_parroquia)->first();

			if($clapF->registrado == true)
			{
				echo "\033[32m -> Registrado \033[0m";
				if($jefeUbicacion)
				{
					$clapF->ubicado = 1;
					$clapF->save();
					echo "\033[32m -> Ubicado \033[0m";
				}
				else
				{
					if($familiarUbicacion)
					{
						$clapF->ubicado = 1;
						$clapF->save();
						echo "\033[32m -> Ubicado \033[0m";
					}
					else
					{
						$clapF->ubicado = 0;
						$clapF->save();
						echo "\033[32m -> No Ubicado \033[0m";
					}
				}
			}
			else
			{
				$clapF->ubicado = 0;
				echo "\033[32m -> No Registrado \033[0m";
				echo "\033[32m -> No Ubicado \033[0m";
				$clapF->save();
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
				'comunidad'   	 => $clap->comunidad, 
				'cargo_id'       	 => '6',
				'tipo'        	 => $clap->tipo_milicia,
				'cedula'      	 => $clap->l_milicia_cedula,
				'nombre_apellido'=> $clap->nombre_milicia,
				'telefono'       => $clap->l_milicia_telefono,
				'registrado'     => '',
				'ubicado'		 => '',
			]);

			$clapF = Clap2::find($clapFcreate->id);
			//verificando si lo encontro tanto como jefe o como carga familiar
			if($jefe) 
			{
				echo "\033[32m es jefe de familia \033[0m";
				//actualizando el estatus de esa integrante
				$clapF->registrado = 1;
				echo "\033[32m -> esta registrado \033[0m";
			}
			else
			{
				if($familiar) 
				{
					echo "\033[32m es carga familiar \033[0m";
					$clapF->registrado = 1;
					echo "\033[32m -> esta registrado \033[0m";
				}
				else
				{
					echo "\033[32m No se encuentra registrado \033[0m";
					$clapF->registrado = 0;
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

