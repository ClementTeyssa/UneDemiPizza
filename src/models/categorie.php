<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace pizza\models;


class categorie extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}