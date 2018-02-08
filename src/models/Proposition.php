<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class Proposition extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'proposition';
    protected $primaryKey = 'idEleve';
    public $timestamps = false;

    public function salon(){
    	return $this->belongsTo('\amphux\models\Salon', 'idSalon');
    }
}