<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class Reponse extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'reponse';
    protected $primaryKey = 'idReponse';
    public $timestamps = false;
    
    public function eleve(){
    	return $this->hasOne('\amphux\models\Eleve','idEleve');
    }
    
    public function resultatEleve(){
    	return $this->belongsTo('\amphux\models\ResultatEleve','idResEleve');
    }
    
    public function question(){
    	return $this->belongsTo('\amphux\models\Question','idQuestion');
    }
    
    public function proposition(){
    	return $this->belongsTo('\amphux\models\Proposition','idProp');
    }
    
}