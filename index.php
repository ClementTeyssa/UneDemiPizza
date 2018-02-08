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

$app->get('/inscription(/)', function (){
    (new pizza\controleurs\ControleurUser())->inscription();
})->name("inscription");

$app->get('/connexion(/)', function (){
    (new pizza\controleurs\ControleurUser())->connexion();
})->name("connexion");



/*
 * ==============================================================
 *                          Traitement
 * ==============================================================
 */



/*
 * Lancement de Slim
 */
$app->run();
