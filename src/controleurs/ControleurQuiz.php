<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 21/01/2018
 * Time: 14:25
 */

namespace amphux\controleurs;

use amphux\vues\VueQuiz;
use amphux\models\Quiz;
use amphux\models\Enseignant;
use amphux\models\Salon;

class ControleurQuiz
{
	/*
	 * ==============================================================
	 *                          Affichage
	 * ==============================================================
	 */
	public function aff_listeQuiz(){
		$app = \Slim\Slim::getInstance();
		if(isset($_COOKIE['enseignant'])){
			$idEns = Enseignant::getByEmail($_COOKIE['enseignant']);
			$quiz = Quiz::getByIdEns($idEns->idEns);
			$salon = Salon::all();
			$liste = array($idEns,$quiz,$salon);
			$vue = new VueQuiz($liste);
			print $vue->render(VueQuiz::AFF_QUIZS_LISTE);
		} else $app->redirect($app->urlFor('accueil'));
	}
	
	public function aff_quiz($no){
		if(isset($_COOKIE['enseignant'])){
			$vue = new VueQuiz();
			print $vue->render(VueQuiz::AFF_QUIZS,$no);
		}
	}
	
	/*
	 * ==============================================================
	 *                          Traitement
	 * ==============================================================
	 */
	

	public function lancer_Quiz(){
		
	}
		

	public function creationQuiz(){
		$app = \Slim\Slim::getInstance();
		$quiz = new Quiz();
		$quiz->idEns = Enseignant::getByEmail($_COOKIE['enseignant'])->idEns;
		$quiz->date = date("Y-m-d");
		$quiz->save();
		$app->redirect($app->urlFor('quizEnseignant',["no"=>$quiz->idQuiz]));
	}

}
