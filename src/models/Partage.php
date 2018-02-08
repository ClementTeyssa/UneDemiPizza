<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class Partage extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'partage';
    protected $primaryKey = 'idPartage';
    public $timestamps = false;
    
    public function enseignant(){
    	return $this->hasMany('\amphux\models\Enseignant','idEns');
    }

    public function quiz(){
    	return $this->hasMany('\amphux\models\Quiz','idQuiz');
    }
}