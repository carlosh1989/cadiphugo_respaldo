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

$num = 1;
foreach ($clap_viejo as $clap) 
{

	$clapnuevo = Clap2::where('clap_codigo', $clap->codigo_clap)->get();

	$bodegas = array();
	
	foreach($clapnuevo as $n)
	{	
		$bo = array($n->bodega_id);
		var_dump($bo);	
		$bodegas = array_merge($bodegas,$bo);
	}

	//filtra los campos vacios 
	$bodegas = array_filter($bodegas);

	//se ordena desde el que menos coincide hasta el que mas se repite
	usort($bodegas, "strcmp");
	$bodega_ultima = array_pop($bodegas);

	//conteo de integrantes
	$conteo_integrantes = count($bodegas);

	$num2 = 0;
	$negativo = 0;
	$positivo = 0;
	foreach ($bodegas as $bo) 
	{
		if($bodega_ultima == $bo)
		{
			echo "es igual el array: ".$num2."\n";
			$positivo = $positivo + 1;
		}
		else
		{
			echo "no es igual a: ".$num2."\n";
			$negativo = $negativo + 1;
		}
		$num2 = $num2 + 1;
	}
	$comparacionCreate = BodegaComparacion::create([
	'clap_codigo' => $clap->codigo_clap,
	'comparacion' => $positivo.":".$negativo,
	]);

	echo "---------------------------------------------------------------------\n";	
	echo "RESULTADO: ".$positivo.":".$negativo."\n";
	echo "---------------------------------------------------------------------\n";	

	echo "\n";
	echo "conteo: ".count($bodegas)."\n";
	var_dump($bodegas);
	echo "\n";	
}

