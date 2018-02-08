<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace pizza\models;


class Item extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function getById($id){
        $id = filter_var($id, FILTER_SANITIZE_STRING);
        return Item::where('id', '=', $id)->first();
    }
}