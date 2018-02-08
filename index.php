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
 * Affichage du menu d'inscription
 */
$app->get('/inscription(/)', function (){
    (new amphux\controleurs\ControleurUser())->aff_inscription();
})->name("inscription");

/*
* Affichage du menu de connexion enseignant
*/
$app->get('/connexion/enseignant(/)', function (){
    (new amphux\controleurs\ControleurUser())->aff_connexionEns();
})->name('connexionEnseignant');

/*
* Affichage du menu de connexion etudiant
*/
$app->get('/connexion/etudiant(/)', function (){
    (new amphux\controleurs\ControleurUser())->aff_connexionEtu();
})->name('connexionEtudiant');

/**
 * Affichage du menu de modification de compte enseignant
 */
$app->get('/modification/enseignant(/)',function(){
	(new amphux\controleurs\ControleurUser())->aff_modificationEns();
})->name('modificationEnseignant');

/**
 * Affichage des quizs
 */
$app->get('/quiz(/)',function(){
	(new amphux\controleurs\ControleurQuiz())->aff_listeQuiz();
})->name('listeQuizEnseignant');

/**
 * Affichage d'un nouveau quiz
 */
$app->get('/quiz/:no(/)',function($no){
	(new amphux\controleurs\ControleurQuiz())->aff_quiz($no);
})->name('quizEnseignant');

/**
 * Affichage d'une nouvelle question
 */
$app->get('/quiz/:no/question/:num(/)',function($no,$num){
	(new amphux\controleurs\ControleurQuestion())->aff_question($no,$num);
})->name('nouvelleQ');

/*
 * Affichage des salons de l'enseignant
 */
$app->get('/salons(/)', function (){
    (new amphux\controleurs\ControleurSalon())->aff_salons();
})->name('affSalons');

/*
 * Affichage d'un salon vue d'un enseignant
 */
$app->post('/salon/enseignant(/)', function (){
    (new amphux\controleurs\ControleurSalon())->aff_salon_ens();
})->name('affsalon_ens');

/*
 * Affichage d'un salon vue d'un étudiant
 */
$app->get('/salon/etudiant(/)', function (){
    (new amphux\controleurs\ControleurSalon())->aff_salon_etu();
})->name('affsalon_etu');


/*
 * ==============================================================
 *                          Traitement
 * ==============================================================
 */

/*
 * Traitement de l'inscription
 */
$app->post('/inscription(/)', function (){
    (new amphux\controleurs\ControleurUser())->inscription();
})->name("inscr");

/*
 * Traitement de la connexion enseignant
 */
$app->post('/connexion/enseignant(/)', function (){
    (new amphux\controleurs\ControleurUser())->connexionEns();
})->name("connexionEns");

/*
 * Traitement de la connexion etudiant
 */
$app->post('/connexion/etudiant(/)', function (){
    (new amphux\controleurs\ControleurUser())->connexionEtu();
})->name("connexionEtu");

/*
 * Traitement  de la deconnexion d'un enseignant
 */
 $app->get('/deconnexion/enseignant', function (){
     (new amphux\controleurs\ControleurUser())->deconnexionEns();
 })->name("deconnexionEns");
 
 /**
  * Traitement du compte enseignant
  */
 $app->post('/modification/enseignant(/)',function(){
 	(new amphux\controleurs\ControleurUser())->modification();
 })->name('modificationEns');
 
 /**
  * Traitement création nouveau quiz
  */
 $app->post('/quiz/nouveau(/)',function(){
 	(new amphux\controleurs\ControleurQuiz())->creationQuiz();
 })->name('nouveauQuiz');
 
 /**
  * Traitement création de question
  */
 $app->post('/quiz/question/nouveau(/)',function(){
 	(new amphux\controleurs\ControleurQuestion())->creationQuestion();
 })->name('nouvelleQuestion');

 /**
  * Traitement de la création d'un salon suite à lancer quiz
  */
 $app->post('/salon/creer(/)',function(){
 	(new amphux\controleurs\ControleurSalon())->creer_salon();
 })->name('creerSalon');
 
 /*
  * Traitement ppour terminer un salon
  */
$app->post('/salon/arret(/)', function (){
    (new amphux\controleurs\ControleurSalon())->terminer_salon();
})->name('arretSalon');

 /*
  * Traitement de la suppression d'un salon
  */
 $app->post('/salon/suppression(/)', function (){
     (new amphux\controleurs\ControleurSalon())->supprimer_salon();
 })->name('suppressionSalon');

 /*
  * Traitement du lancement d'un salon
  */
 $app->post('/salon/lancement(/)', function (){
     (new amphux\controleurs\ControleurSalon())->lancer_salon();
 })->name('lancementSalon');


/*
 * Lancement de Slim
 */
$app->run();
