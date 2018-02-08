<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 14/11/2017
 * Time: 16:54
 */
session_start();
require_once "vendor/autoload.php";


/*
 * connexion a la base de données
 */
amphux\conf\ConnexionBase::initialisation('src/conf/conf.ini');

/*
 * initialisation de Slim
 */
$app = new \Slim\Slim();

/*
 * ==============================================================
 *                          Affichage
 * ==============================================================
 */

/*
 * Affichage de l'accueil
 */
$app->get('/', function (){
    (new amphux\controleurs\ControleurUser())->index();
})->name("accueil");




/*
 * ==============================================================
 *                          Traitement
 * ==============================================================
 */



/*
 * Lancement de Slim
 */
$app->run();
