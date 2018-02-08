<?php
session_start();
require_once "vendor/autoload.php";


/*
 * connexion a la base de données
 */
pizza\conf\ConnexionBase::initialisation('src/conf/conf.ini');

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
    (new pizza\controleurs\ControleurUser())->index();
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
