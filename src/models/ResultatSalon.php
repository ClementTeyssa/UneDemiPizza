<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class ResultatSalon extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'resultat_salon';
    protected $primaryKey = 'idResSalon';
    public $timestamps = false;
    
    public function resultatQuiz(){
    	return $this->belongsTo('\amphux\models\ResultatSalon','idResQuiz');
    }
    
    public function salon(){
    	return $this->belongsTo('\amphux\models\Salon','idSalon');
    }
}