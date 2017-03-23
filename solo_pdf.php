<?php
require __DIR__ . '/vendor/autoload.php';
use DB\Eloquent;
use Models\Jefe;
new Eloquent();
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
extract($_GET);

//VERIFICANDO SI SE GENERO EL REPORTE
$certificado = Jefe::where('cedula',$cedula)->get();

if($certificado)
{

}
else
{
	$certificado->certificacion_solo = 1;
}

$mpdf = new mPDF('','Letter',11,'arial');
ob_start();
include('encabezado.php');
$mpdf->SetHTMLHeader(ob_get_clean());
$mpdf->setFooter('{PAGENO}');
$mpdf->AddPage('', // L - landscape, P - portrait 
'', '', '', '',
5, // margen izquierdo
5, // margen derecho
40, // margin arriba
2.5, // margin abajo
0, // margin encabezado
0); // margin pie de pagina

ob_start();
include("solo.php");
$stylesheet = file_get_contents('style.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML(ob_get_clean(),2);
$nombre = "Solos.pdf";
$mpdf->Output($nombre,'D');
