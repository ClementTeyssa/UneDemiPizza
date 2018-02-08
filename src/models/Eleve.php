<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class Eleve extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'eleve';
    protected $primaryKey = 'idEleve';
    public $timestamps = false;
    
    public function salon(){
    	return $this->belongsTo('\amphux\models\Salon','idSalon');
    }

    public static function getById($id){
        $id = filter_var($id, FILTER_SANITIZE_STRING);
        return Eleve::where('idEleve', '=', $id)->first();
    }
}