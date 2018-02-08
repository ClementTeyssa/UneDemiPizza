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

$app->get('/catalogue(/)', function (){
    (new pizza\controleurs\ControleurCatalogue())->aff_catalogue();
})->name("catalogue");

$app->get('/connexion(/)', function (){
    (new pizza\controleurs\ControleurUser())->connexion();
})->name("connexion");


$app->post('/item(/)', function (){
    (new \pizza\controleurs\ControleurItem())->aff_item();
})->name("item");


/*
 * ==============================================================
 *                          Traitement
 * ==============================================================
 */
$app->post('/inscription(/)', function (){
    (new pizza\controleurs\ControleurUser())->inscriptionT();
})->name("inscriptionT");

$app->post('/connexionT', function (){
    (new pizza\controleurs\ControleurUser())->connexionT();
})->name("connexionT");

$app->get('/deconnexion(/)', function (){
    (new pizza\conf\Authentication())->deconnexion();
})->name("deconnexion");




/*
 * Lancement de Slim
 */
$app->run();
