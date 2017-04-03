<?php
//SECCIÓN DE CARGA DE LIBRERIAS Y MODELOS
require('autoload.php');
use DB\Eloquent;
use Models\Jefe;
new Eloquent();

extract($_GET);
extract($_POST);

$jefes = Jefe::where('n_personas', '>', 1)->where('cod_municipio',$municipio)->where('cod_parroquia',$parroquia)->where('bodega',$bodega)->orderBy('cedula', 'asc')->get();

$solos = Jefe::where('n_personas',1)->where('cod_municipio',$municipio)->where('cod_parroquia',$parroquia)->where('bodega',$bodega)->orderBy('cedula', 'desc')->get();

$jefe = Jefe::where('bodega', $bodega)->first();
//\krumo::dump($solos);
?>
<br>
<div class="bodega">
<strong>Datos de bodega</strong>
<br>
Responsable: <?php echo $jefe->bodeguera->responsable ?>
<br>  
Dirección: <?php echo $jefe->bodeguera->direccion ?>
</div>
<h3 align="center">Jefes y carga familiar</h3>
<table border=0 cellspacing=0 cellpadding=2 bordercolor="666633">
    <thead>
        <tr style="background-color:#DCDCDC;">
        <th>Nombre Apellido</th>
        <th>Cédula</th>
        <th>Parentesco</th>
        <th>Edad</th>
        <th>Discapacidad</th>
        <th>Certificado</th>
      </tr>
    </thead>
    <tbody>
		<?php foreach ($jefes as $jefe): ?>
        <tr style="background-color:#73C5FF;">
			<td align="left"><?php echo $jefe->nombre_apellido ?></td>
			<td align="left"><?php echo $jefe->tipo ?>-<?php echo $jefe->cedula ?></td>
			<td align="center">Jefe Familia</td>
			<td align="center"><?php echo $jefe->edad ?></td>
			<td align="center"></td>
			<?php if ($jefe->huella_certificada == true): ?>
				<td align="center">Si</td>
			<?php else: ?>
				<td align="center">No</td>
			<?php endif ?>

      	</tr>

      	<?php foreach ($jefe->familia as $familiar): ?>
        <tr class="bordered">
			<td align="left"><?php echo $familiar->nombre_y_apellido ?></td>
			<td align="left"><?php echo $familiar->nac ?>-<?php echo $familiar->cedula ?></td>
			<td align="center">
			<?php if ($familiar->parentesco=='1'): ?>
				<?php echo 'Padre' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='2'): ?>
				<?php echo 'Madre' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='3'): ?>
				<?php echo 'Hijo(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='4'): ?>
				<?php echo 'Concubino(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='5'): ?>
				<?php echo 'Esposo(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='6'): ?>
				<?php echo 'Abuelo(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='7'): ?>
				<?php echo 'Tio(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='8'): ?>
				<?php echo 'Sobrino(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='9'): ?>
				<?php echo 'Nieto(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='10'): ?>
				<?php echo 'Hermano(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='11'): ?>
				<?php echo 'Primo(a)' ?>
			<?php endif ?>
			<?php if ($familiar->parentesco=='12'): ?>
				<?php echo 'Cuñado(a)' ?>
			<?php endif ?>
			</td>
			<td align="center"><?php echo $familiar->edad ?></td>
			<?php if ($familiar->discapacidad == "NINGUNA"): ?>
			<td align="center"></td>	
			<?php else: ?>
			<td align="center"><?php echo $familiar->discapacidad ?></td>
			<?php endif ?>
			<td></td>
      	</tr>
      	<?php endforeach ?>
		<?php endforeach ?>
		<tr>
			<td colspan="6" align="center">
			<h3>Personas solas</h3>
			</td>
		</tr>
		<?php foreach ($solos as $solo): ?>
        <tr>
			<td align="left"><?php echo $solo->nombre_apellido ?></td>
			<td align="center"><?php echo $solo->cedula ?></td>
			<td align="center">Jefe Familia</td>
			<td align="center"><?php echo $solo->edad ?></td>
			<?php if ($familiar->discapacidad == "NINGUNA"): ?>
			<td align="center"></td>	
			<?php else: ?>
			<td align="center"><?php echo $familiar->discapacidad ?></td>
			<?php endif ?>
			<?php if ($solo->huella_certificada == true): ?>
				<td align="center">Si</td>
			<?php else: ?>
				<td align="center">No</td>
			<?php endif ?>
      	</tr>
		<?php endforeach ?>
    </tbody>
  </table>
<hr>
<?php 
$total_familias = $jefes->count() + $solos->count();
$total_personas = $jefes->sum('n_personas') + $solos->count();
?>



<?php
$jefes_certificados = Jefe::where('n_personas', '>', 1)->where('cod_municipio',$municipio)->where('cod_parroquia',$parroquia)->where('bodega',$bodega)->orderBy('cedula', 'asc')->where('huella_certificada',1)->get();

$solos_certificados = Jefe::where('n_personas',1)->where('cod_municipio',$municipio)->where('cod_parroquia',$parroquia)->where('bodega',$bodega)->orderBy('cedula', 'desc')->where('huella_certificada',1)->get();
?>
<pre>Número de Familias: <?php echo $total_familias ?></pre>
<pre>Jefes de familia certificados: <?php echo $jefes_certificados->count(); ?></pre>
<hr>
<pre>Número de Personas solas: <?php echo $solos->count() ?></pre>
<pre>Personas solas certificadas: <?php echo $solos_certificados->count() ?></pre>
<hr>
<pre>Número de Personas: <?php echo $total_personas ?></pre>