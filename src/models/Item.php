<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 08/02/2018
 * Time: 12:52
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