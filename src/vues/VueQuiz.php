<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 24/01/2018
 * Time: 09:56
 */

namespace amphux\vues;


class VueQuiz
{
	const AFF_QUIZS_LISTE= 1;
	const AFF_QUIZS = 2;

    private $objet;

    public function __construct($array = null)
    {
        $this->objet = $array;
    }

    public function render($selecteur, $tab = null)
    {
        $content=null;
        if(isset($tab)){
            $this->objet = $tab;
        }
        switch ($selecteur) {
            case VueQuiz::AFF_QUIZS_LISTE :
                $content = $this->listeQuizs();
                break;
            case VueQuiz::AFF_QUIZS :
            	$content = $this->quiz($tab);
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

    /*
     * Affichage de la liste des quizs
     */
    private function listeQuizs(){
    	$app = \Slim\Slim::getInstance();
    	$ens = $this->objet[0];
    	$quizs = $this->objet[1];
    	$salon = $this->objet[2];
    	$r_creationQuiz = $app->urlFor('nouveauQuiz');
    	$affichage = <<<end
		<h1>Mes quizs :</h1>
		<form id="formQuiz2" class="form" method="POST" action="$r_creationQuiz">
			 <input type="submit" value="Nouveau quiz" name="crQuiz"/></td>
		</form>
		<table>
  				<tr>
   				 <th>Nom du quiz</th>
    			 <th>Date</th>
   				 <th>Options</th>
  				</tr>
end;
		foreach($quizs as $quiz){
			$r_lancer = $app->urlFor('creerSalon');
    		$r_resultat = $app->urlFor('accueil'/**'resultatQuiz',['no'=>$quiz]*/);
    		$r_modifier = $app->urlFor('accueil'/**'modifierQuiz',['no'=>$quiz]*/);
    		$r_supprimer = $app->urlFor('accueil'/**'supprimerQuiz'*/);
			$affichage .= <<<end
			<tr>
			 <td>$quiz->titre</td>
			 <td>Date de création : $quiz->date</td>
			 <td><form id="formQuiz1" class="form" method="POST" action="$r_lancer">
			 <label class="black-text">Nom du salon:</label>
			 <input placeholder="Nom du salon" type="text" name="nomSalon" required>
			 <input type="hidden" value="$quiz->idQuiz" name="idQuiz"/>
			 <input type="submit" class="bouton" value="Lancer quiz" name="btLancer"/>
			 </form>
			 <a href=$r_resultat>Resultats</a> <a href=$r_modifier>Editer</a>
			 <form id="formQuiz2" class="form" method="POST" action="$r_supprimer">
			 <input type="submit" class="bouton" value="Supprimer" name="btSupprimer"/></td>
			 </form>
			</tr>
end;
    	}
    	$affichage .= '</table>';
    	
		return $affichage;
    }
    
    private function quiz($no){
    	$app = \Slim\Slim::getInstance();
    	$r_question = $app->urlFor('nouvelleQuestion');
    	return <<<end
		<form class="form" method="POST" action="$r_question">
		<input type="hidden" value="$no" name="idQuiz"/>
		<input type="submit" value="Créer une nouvelle question" name="btCreer"/></td>
		</form>
end;
    }
}