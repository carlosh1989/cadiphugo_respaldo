<?php 
require __DIR__ . '/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use DB\Eloquent;
use Models\BodegaComparacion;
use Models\Clap2;
use Models\Clap;
use Models\Familia;
use Models\Jefe;
new Eloquent();

//buscando todos los claps de la tabla vieja
$clap_viejo = Clap::all();

foreach ($clap_viejo as $clap) 
{
	//buscando con el codigo de clap en la tabla nuevo los integrantes
	$clap_nuevo = Clap2::where('clap_codigo', $clap->codigo_clap)->get();
	
	foreach ($clap_nuevo as $clap2) 
	{
		echo "\n";
		echo "---------------------------------------------------------------------\n";
		echo "\033[32m NOMBRE INTEGRANTE \033[0m: -> ".$clap2->nombre_apellido." \n";
		echo "CEDULA: ".$clap2->cedula."\n";
		echo "CARGO: ".$clap2->cargo_id."\n";
	}

	//VERIFICANDO SI HAY INTEGRANTE DE MILICIA
	echo "---------------------------------------------------------------------\n";	
	if($clap_nuevo[5]->bodega_id)
	{
		$bodegas = array($clap_nuevo[0]->bodega_id, $clap_nuevo[1]->bodega_id, $clap_nuevo[2]->bodega_id, $clap_nuevo[3]->bodega_id,$clap_nuevo[4]->bodega_id,$clap_nuevo[5]->bodega_id);
		//$arr2 = array("1971", "1971", "101", "1971","1971","056165165");
		usort($bodegas, "strcmp");
		$bodega_ultima = array_pop($bodegas);

		if($bodega_ultima == $clap_nuevo[0]->bodega_id)
		{
			echo "6:0\n";
			$comparacionCreate = BodegaComparacion::create([
			'clap_codigo' => $clap_nuevo[5]->clap_codigo,
			'comparacion' => '6:0',
			]);
		}
		else
		{
			//VERIFICANDO ULTIMO REGISTRO CON EL SEGUNDO
			if($bodega_ultima == $clap_nuevo[1]->bodega_id)
			{
				echo "5:1\n";
				$comparacionCreate = BodegaComparacion::create([
				'clap_codigo' => $clap_nuevo[5]->clap_codigo,
				'comparacion' => '5:1',
				]);
			}
			else
			{
				//VERIFICANDO ULTIMO REGISTRO CON EL TERCERO
				if($bodega_ultima == $clap_nuevo[2]->bodega_id)
				{
					echo "4:2\n";
					$comparacionCreate = BodegaComparacion::create([
					'clap_codigo' => $clap_nuevo[5]->clap_codigo,
					'comparacion' => '4:2',
					]);
				}
				else
				{
					//VERIFICANDO ULTIMO REGISTRO CON EL CUARTO
					if($bodega_ultima == $clap_nuevo[3]->bodega_id)
					{
						echo "3:3\n";
						$comparacionCreate = BodegaComparacion::create([
						'clap_codigo' => $clap_nuevo[5]->clap_codigo,
						'comparacion' => '3:3',
						]);
					}
					else
					{
						//VERIFICANDO ULTIMO REGISTRO CON EL QUINTO'
						if($bodega_ultima == $clap_nuevo[4]->bodega_id)
						{
							echo "2:4\n";
							$comparacionCreate = BodegaComparacion::create([
							'clap_codigo' => $clap_nuevo[5]->clap_codigo,
							'comparacion' => '2:4',
							]);
						}
						else
						{
							//VERIFICANDO ULTIMO REGISTRO CON EL SEXTO
							if($bodega_ultima == $clap_nuevo[5]->bodega_id)
							{
								echo "1:5\n";
								$comparacionCreate = BodegaComparacion::create([
								'clap_codigo' => $clap_nuevo[5]->clap_codigo,
								'comparacion' => '1:5',
								]);
							}
							else
							{

							}
						}
					}
				}
			}
		}

	}
	else
	{
		if($clap_nuevo[4]->bodega_id)
		{
			$bodegas = array($clap_nuevo[0]->bodega_id, $clap_nuevo[1]->bodega_id, $clap_nuevo[2]->bodega_id, $clap_nuevo[3]->bodega_id,$clap_nuevo[4]->bodega_id);
			//$arr2 = array("1971", "1971", "101", "1971","1971","056165165");
			usort($bodegas, "strcmp");
			$bodega_ultima = array_pop($bodegas);
			echo "\n";
			if($bodega_ultima == $clap_nuevo[0]->bodega_id)
			{
				echo "5:0\n";
				$comparacionCreate = BodegaComparacion::create([
				'clap_codigo' => $clap_nuevo[5]->clap_codigo,
				'comparacion' => '5:0',
				]);
			}
			else
			{
				//VERIFICANDO ULTIMO REGISTRO CON EL SEGUNDO
				if($bodega_ultima == $clap_nuevo[1]->bodega_id)
				{
					echo "4:1\n";
					$comparacionCreate = BodegaComparacion::create([
					'clap_codigo' => $clap_nuevo[5]->clap_codigo,
					'comparacion' => '4:1',
					]);
				}
				else
				{
					//VERIFICANDO ULTIMO REGISTRO CON EL TERCERO
					if($bodega_ultima == $clap_nuevo[2]->bodega_id)
					{
						echo "3:2\n";
						$comparacionCreate = BodegaComparacion::create([
						'clap_codigo' => $clap_nuevo[5]->clap_codigo,
						'comparacion' => '3:2',
						]);
					}
					else
					{
						//VERIFICANDO ULTIMO REGISTRO CON EL CUARTO
						if($bodega_ultima == $clap_nuevo[3]->bodega_id)
						{
							echo "2:3\n";
							$comparacionCreate = BodegaComparacion::create([
							'clap_codigo' => $clap_nuevo[5]->clap_codigo,
							'comparacion' => '2:3',
							]);
						}
						else
						{
							//VERIFICANDO ULTIMO REGISTRO CON EL QUINTO
							if($bodega_ultima == $clap_nuevo[4]->bodega_id)
							{
								echo "1:4\n";
								$comparacionCreate = BodegaComparacion::create([
								'clap_codigo' => $clap_nuevo[5]->clap_codigo,
								'comparacion' => '1:4',
								]);
							}
							else
							{

							}
						}
					}
				}
			}
		}
		else
		{

		}
	}
	echo "---------------------------------------------------------------------\n";	
	var_dump($bodegas);
	echo "---------------------------------------------------------------------\n";	
	echo "\n";
}

