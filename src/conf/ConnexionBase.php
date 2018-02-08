<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 12/12/2017
 * Time: 12:18
 */

namespace amphux\conf;
use Illuminate\Database\Capsule\Manager as DB;

class ConnexionBase
{
    public static function initialisation($file){
        $connection = parse_ini_file($file);
        $db = new DB();
        $db->addConnection($connection);
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}