<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 21/01/2018
 * Time: 14:25
 */

namespace pizza\controleurs;
use pizza\conf\Authentication;
use pizza\models\Item;
use pizza\models\user;
use pizza\vues\VueNavigation;

class ControleurUser
{
    /*
     * ==============================================================
     *                          Affichage
     * ==============================================================
     */

    /*
     * Affichage de l'index
     */
    public function index(){
        $itemsV = Item::where('id_categ','=',1)->get();
        $itemsA = Item::where('id_categ','=',2)->get();

        $tab = array();
        array_push($tab, $itemsV);
        array_push($tab, $itemsA);

        $vue = new VueNavigation();
        print $vue->render(VueNavigation::AFF_INDEX, $tab);
    }
    
    /*
     * Affichage de la connexion
     */
    public function connexion(){
        $vue = new VueNavigation();
        print $vue->render(VueNavigation::AFF_CONNEXION);
    }
    
    /*
     * Affichage de l'inscription
     */
    public function inscription(){
        $vue = new VueNavigation();
        print $vue->render(VueNavigation::AFF_INSCRIPTION);
    }
    
    /*
     * ==============================================================
     *                          Traitement
     * ==============================================================
     */
    public function inscriptionT(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $email = filter_var($requete->post('mailInscr'), FILTER_SANITIZE_EMAIL);
        
        $emailVerif = User::where('email','=', $email)->first();
        
        if($emailVerif == null){
        	$nom = filter_var($requete->post('nomInscr'), FILTER_SANITIZE_EMAIL);
        	$mdp1 = $requete->post('mdp1Inscr');
        	$mdp2 = $requete->post('mdp2Inscr');
        	if($mdp1 == $mdp2){
        		Authentication::createUser($nom, $email, $mdp1);
        	}
        }else{
        	$_SESSION['message'] = "Erreur, email déjà associé à un compte.";
        }
        
        $app->redirect($app->urlFor("accueil"));
    }
    
    public function connexionT(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $email = filter_var($requete->post('mailCo'), FILTER_SANITIZE_EMAIL);
        $mdp = $requete->post('mdpCo');
        Authentication::authenticate($email, $mdp);
    }
}
