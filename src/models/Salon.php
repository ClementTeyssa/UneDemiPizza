<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class Salon extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'salon';
    protected $primaryKey = 'idSalon';
    public $timestamps = false;
    
    public function enseignant(){
    	return $this->belongsTo('\amphux\models\Enseignant','idEns');
    }

    public function eleves(){
        return $this->hasMany('\amphux\models\Eleve', 'idSalon');
    }
    
    public static function maxDate($idQuiz){
    	return Salon::where('idQuiz','=',$idQuiz)->max('date');
    }

    public static function getById($id){
        $id = filter_var($id, FILTER_SANITIZE_STRING);
        return Salon::where('idSalon', '=', $id)->first();
    }

    public static function getByToken($token){
        $token = filter_var($token, FILTER_SANITIZE_STRING);
        return Salon::where('token', '=', $token)->first();
    }
}