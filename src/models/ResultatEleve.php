<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class ResultatEleve extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'resultat_eleve';
    protected $primaryKey = 'idResEleve';
    public $timestamps = false;
    
    public function resultatSalon(){
    	return $this->belongsTo('\amphux\models\ResultatSalon','idResSalon');
    }
    
    public function eleve(){
    	return $this->belongsTo('\amphux\models\Eleve','idEleve');
    }
    
}