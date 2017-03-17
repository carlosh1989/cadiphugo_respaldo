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
	
/*	foreach ($clap_nuevo as $clap2) 
	{
		echo "\n";
		echo "---------------------------------------------------------------------\n";
		echo "\033[32m NOMBRE INTEGRANTE \033[0m: -> ".$clap2->nombre_apellido." \n";
		echo "CEDULA: ".$clap2->cedula."\n";
		echo "CARGO: ".$clap2->cargo_id."\n";
	}*/

	//VERIFICANDO SI HAY INTEGRANTE DE MILICIA
	echo "---------------------------------------------------------------------\n";	

	$bodegas = array($clap_nuevo[0]->bodega_id, $clap_nuevo[1]->bodega_id, $clap_nuevo[2]->bodega_id, $clap_nuevo[3]->bodega_id,$clap_nuevo[4]->bodega_id);
	//$arr2 = array("1971", "1971", "101", "1971","1971","056165165");
	usort($bodegas, "strcmp");
	$bodega_ultima = array_pop($bodegas);

	$BodegaComparacion = BodegaComparacion::find($clap->codigo_clap);

	if($BodegaComparacion)
	{
		echo "---------------------------------------------------------------------\n";	
		echo "YA SE HIZO COMPARACION DE BODEGAS EN ESTE CLAP\n";
		echo "---------------------------------------------------------------------\n";	
	}
	else
	{
		if($bodega_ultima == $bodegas[0])
		{
			echo "6:0\n";
			$comparacionCreate = BodegaComparacion::create([
			'clap_codigo' => $clap_nuevo[5]->clap_codigo,
			'comparacion' => '6:0',
			]);
		}

		if($bodega_ultima == $bodegas[1])
		{
			echo "5:1\n";
			$comparacionCreate = BodegaComparacion::create([
			'clap_codigo' => $clap_nuevo[5]->clap_codigo,
			'comparacion' => '5:1',
			]);
		}

		if($bodega_ultima == $bodegas[2])
		{
			echo "4:2\n";
			$comparacionCreate = BodegaComparacion::create([
			'clap_codigo' => $clap_nuevo[5]->clap_codigo,
			'comparacion' => '4:2',
			]);
		}

		if($bodega_ultima == $bodegas[3])
		{
			echo "3:3\n";
			$comparacionCreate = BodegaComparacion::create([
			'clap_codigo' => $clap_nuevo[5]->clap_codigo,
			'comparacion' => '3:3',
			]);
		}

		if($bodega_ultima == $bodegas[4])
		{
			echo "2:4\n";
			$comparacionCreate = BodegaComparacion::create([
			'clap_codigo' => $clap_nuevo[5]->clap_codigo,
			'comparacion' => '2:4',
			]);
		}

		if($bodega_ultima == $bodegas[5])
		{
			echo "1:5\n";
			$comparacionCreate = BodegaComparacion::create([
			'clap_codigo' => $clap_nuevo[5]->clap_codigo,
			'comparacion' => '1:5',
			]);
		}

		if($bodega_ultima == $bodegas[6])
		{
			echo "0:6\n";
			$comparacionCreate = BodegaComparacion::create([
			'clap_codigo' => $clap_nuevo[5]->clap_codigo,
			'comparacion' => '0:6',
			]);
		}
	}



	echo "---------------------------------------------------------------------\n";	
	var_dump($bodegas);
	echo "---------------------------------------------------------------------\n";	
	echo "\n";
}






