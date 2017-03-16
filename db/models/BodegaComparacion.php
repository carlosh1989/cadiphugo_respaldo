<?php 
namespace Models;
use \Illuminate\Database\Eloquent\Model;
 
class BodegaComparacion extends Model {
	public $timestamps = false;
    protected $table = 'bodega_comparacion';
	protected $primaryKey = 'id';
    protected $fillable = ['clap_codigo','comparacion'];
    //Ejemplo de definir campos
}
