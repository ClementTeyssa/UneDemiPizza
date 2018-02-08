<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class Question extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'question';
    protected $primaryKey = 'idQuestion';
    public $timestamps = false;
    
    public static function getByIdNum($no,$num){
    	$no = filter_var($no, FILTER_SANITIZE_STRING);
    	$num = filter_var($num,FILTER_SANITIZE_STRING);
    	return  Question::where('idQuiz','=',$no)->where('num','=',$num)->first();
    }

    public function proposition(){
    	return $this->hasOne('\amphux\models\Proposition','idProp');
    }
    
    public function quiz(){
    	return $this->belongsTo('\amphux\models\Quiz','idQuiz');
    }
}