<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 21/01/2018
 * Time: 14:25
 */

namespace amphux\controleurs;

use amphux\models\Question;
use amphux\vues\VueQuestion;

class ControleurQuestion
{
	/*
	 * ==============================================================
	 *                          Affichage
	 * ==============================================================
	 */
		public function aff_question($no,$num){
			$app = \Slim\Slim::getInstance();
			if(isset($_COOKIE['enseignant'])){
				$vue = new VueQuestion();
				$liste = array($no,$num);
				$type = Question::getByIdNum($no,$num)->type;
				switch($type){
					case 0:
						print $vue->render(VueQuestion::AFF_QUESTION_QCM,$liste);
						break;
					case 1:
						print $vue->render(VueQuestion::AFF_QUESTION_VF,$liste);
						break;
					case 2:
						print $vue->render(VueQuestion::AFF_QUESTION_COURT,$liste);
						break;
				}
			}else{
				$app->redirect($app->urlFor("accueil"));
			}
		}
	
	
	/*
	 * ==============================================================
	 *                          Traitement
	 * ==============================================================
	 */
		public function creationQuestion(){
			$app = \Slim\Slim::getInstance();
			$q = new Question();
			$q->idQuiz = $_POST["idQuiz"];
			$num = Question::where('idQuiz','=',$_POST["idQuiz"])->max('num');
			if(empty($num)) $q->num = 1;
			else $q->num = $num+1;
			$q->type = 0;
			$q->barrage = 0;
			$q->dateCrea = date("Y-m-d");
			$q->dateModif = date("Y-m-d");
			$q->save();
			$app->redirect($app->urlFor("nouvelleQ",["no"=>$_POST["idQuiz"],"num"=>$q->num]));
	}
	

}
