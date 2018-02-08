<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class Quiz extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'quiz';
    protected $primaryKey = 'idQuiz';
    public $timestamps = false;
    
    public static function getByIdEns($id){
    	$id = filter_var($id, FILTER_SANITIZE_STRING);
    	return Quiz::where('idEns', '=', $id)->get();
    }

    public function enseignant(){
    	return $this->belongsTo('\amphux\models\Enseignant','idEns');
    }
}