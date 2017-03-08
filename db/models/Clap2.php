<?php 
namespace Models;
use \Illuminate\Database\Eloquent\Model;
 
class Clap2 extends Model {
	public $timestamps = false;
    protected $table = 'claps';
    protected $fillable = ['estado_id','municipio_id','parroquia_id','clap_codigo','clap_nombre','comunidad','cargo_id','tipo','cedula','nombre_apellido','telefono','registrado','ubicado'];
    //Ejemplo de definir campos
}
