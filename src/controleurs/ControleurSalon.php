<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 24/01/2018
 * Time: 09:55
 */

namespace amphux\controleurs;


use amphux\models\Enseignant;
use amphux\models\Salon;
use amphux\vues\VueSalon;

class ControleurSalon
{
    /*
     * ==============================================================
     *                          Affichage
     * ==============================================================
     */

    /*
     * Affichage des salons d'un enseignant
     */
    public function aff_salons(){
        if(isset($_COOKIE['enseignant'])){
            $ens = Enseignant::getByEmail($_COOKIE['enseignant']);
            $salonsE = Salon::whereRaw("idEns = $ens->idEns and ouvert != 0")->get();
            $salonsT = Salon::whereRaw("idEns = $ens->idEns and ouvert = 0")->get();
            $nbE = count($salonsE);
            $nbT = count($salonsT);
            $tab = array($salonsE, $salonsT);
            if($nbE > 0){
                array_push($tab, $nbE);
            } else {
                array_push($tab, null);
            }
            if($nbT > 0){
                array_push($tab, $nbT);
            } else {
                array_push($tab, null);
            }
            $vue = new VueSalon();
            print $vue->render(VueSalon::AFF_SALONS, $tab);
        } else {
            $app = \Slim\Slim::getInstance();
            $_SESSION['message'] = "Vous devez être connecté pour accéder à cela";
            $app->redirect($app->urlFor("connexionEns"));
        }
    }

    /*
     * Affichage d'un salon d'un enseignant
     */
    public function aff_salon_ens(){
        $app = \Slim\Slim::getInstance();
        if(isset($_COOKIE['enseignant'])){
            $requete = $app->request();
            $salon_id = $requete->post('salon');
            $salon = Salon::getById($salon_id);
            $eleves = $salon->eleves;
            $tab = array($salon, $eleves);
            $vue = new VueSalon();
            print  $vue->render(VueSalon::AFF_SALON_ENS, $tab);
        } else {
            $_SESSION['message'] = "Vous devez être connecté pour accéder à cela";
            $app->redirect($app->urlFor("connexionEns"));
        }
    }

    /*
     * Affichage d'un salon d'un étudiant
     */
    public function aff_salon_etu(){
        $app = \Slim\Slim::getInstance();
        if(isset($_COOKIE['etudiant'])){
            $tab1 = $_COOKIE['etudiant'];
            $tab1 = unserialize($tab1);
            $salon_token = $tab1[1];
            $salon = Salon::getByToken($salon_token);
            $eleves = $salon->eleves;
            $tab = array($salon, $eleves);
            $vue = new VueSalon();
            print  $vue->render(VueSalon::AFF_SALON_ETU, $tab);
        }else {
            $_SESSION['message'] = "Vous devez être connecté pour accéder à cela";
            $app->redirect($app->urlFor("connexionEtu"));
        }
    }


    /*
     * ==============================================================
     *                          Traitement
     * ==============================================================
     */

    /*
     * Traitement de la suppression d'un salon par un enseignant
     */
    public function supprimer_salon(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $salon_id = $requete->post('salon');
        $salon = Salon::getById($salon_id);
        $salon->delete();
        $app->redirect($app->urlFor('affSalons'));
    }

    /*
     * Traitement pour terminer un salon
     */
    public function terminer_salon(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $salon_id = $requete->post('salon');
        $salon = Salon::getById($salon_id);
        $salon->ouvert = 0;
        $salon->save();
        $app->redirect($app->urlFor('affSalons'));
    }

    /*
     * Traitement pour lancer un salon
     */
    public function lancer_salon(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $salon_id = $requete->post('salon');
        $salon = Salon::getById($salon_id);
        $salon->ouvert = 1;
        $salon->save();
        $app->redirect($app->urlFor('affSalons'));
    }
    
    /**
     * Traitement pour la création d'un salon
     */
    public function creer_salon(){
    	$app = \Slim\Slim::getInstance();
    	$requete = $app->request();
    	$nomSalon = filter_var($requete->post('nomSalon'));
    	$idEns = Enseignant::getByEmail($_COOKIE['enseignant'])->idEns;
    	$idQuiz = filter_var($requete->post('idQuiz'));
    	$salon = new Salon();
    	$salon->idQuiz = $idQuiz;
    	$salon->nom = $nomSalon;
    	$salon->idEns = $idEns;
    	$salon->ouvert = 2;
    	$token = substr(uniqid(), -5, 5);
    	$salon->token = $token;
    	$salon->date = date("Y-m-d");
    	$salon->save();
    	$app->redirect($app->urlFor('affSalons'));
    }
}