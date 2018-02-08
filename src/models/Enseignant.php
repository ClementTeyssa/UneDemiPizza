<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace amphux\models;


class Enseignant extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'enseignant';
    protected $primaryKey = 'idEns';
    public $timestamps = false;

    public static function getByEmail($mail){
        $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
        return Enseignant::where('email', '=', $mail)->first();
    }


    public function salons(){
        return $this->hasMany('\amphux\models\Salon', 'idEns');
    }
}