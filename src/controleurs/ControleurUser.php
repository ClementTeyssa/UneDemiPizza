<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 21/01/2018
 * Time: 14:25
 */

namespace pizza\controleurs;
use pizza\conf\Authentication;
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
        $vue = new VueNavigation();
        print $vue->render(VueNavigation::AFF_INDEX);
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
        $nom = filter_var($requete->post('nomInscr'), FILTER_SANITIZE_EMAIL);
        $mdp1 = $requete->post('mdp1Inscr');
        $mdp2 = $requete->post('mdp2Inscr');
        if($mdp1 == $mdp2){
            Authentication::createUser($nom, $email, $mdp1);
        }
        $app->redirect($app->urlFor("accueil"));
    }
}
