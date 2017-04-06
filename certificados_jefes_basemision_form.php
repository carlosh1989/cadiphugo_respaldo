<form action="huellaNocertificadasJefes.php" method="GET">
municipio:
<br>
    <input type="text" name="municipio" placeholder="municipio">
  <br><br>
parroquia:
<br>
    <input type="text" name="parroquia" placeholder="parroquia">
<br><br>
bodega_ID:
<br>
    <input type="text" name="bodega_id" placeholder="bodega id">
<br><br>
base de misión n°:
<br>
    <input type="text" name="basemisiones" placeholder="base de misiones">
<br>
<br>
    <select name="tipo" id="">
    	<option value="1">Jefe de familia</option>
    	<option value="0">Carga familiar</option>
    </select>
<br>
<br>
    <select name="tipo" id="">
    	<option value="1">si certificados</option>
    	<option value="0">no certificados</option>
    </select>
<br>
<br>
    <input type="submit" value="descargar">
</form>