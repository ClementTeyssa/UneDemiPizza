<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 22/01/2018
 * Time: 22:26
 */

namespace pizza\models;


class user extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'user';
    protected $primaryKey = 'email';
    public $timestamps = false;

    public static function getByEmail($email){
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        return user::where('email', '=', $email)->first();
    }
}