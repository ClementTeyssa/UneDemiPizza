<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 21/01/2018
 * Time: 14:25
 */

namespace pizza\controleurs;

use amphux\vues\VueNavigation;
use amphux\conf\Authentication;
use amphux\models\Enseignant;
use amphux\models\Salon;
use amphux\models\Eleve;

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
     * Affichage de l'inscription
     */
    public function aff_inscription(){
        print (new VueNavigation())->render(VueNavigation::AFF_INSCRIPTION);
    }

    /*
     * Affichage de la connexion enseignant
     */
    public function aff_connexionEns(){
        print (new VueNavigation())->render(VueNavigation::AFF_CONNEXION_ENSEIGNANT);
    }

    /*
     * Affichage de la connexion etudiant
     */
    public function aff_connexionEtu(){
        print (new VueNavigation())->render(VueNavigation::AFF_CONNEXION_ETUDIANT);
    }
    
    /**
     * Affichage du menu de modification de compte enseignant
     */
    public function aff_modificationEns(){
    	print (new VueNavigation())->render(VueNavigation::AFF_MODIFICATION_ENSEIGNANT);
    }

    /*
     * ==============================================================
     *                          Traitement
     * ==============================================================
     */

    /*
     * Traitement d'une inscription
     */
    public function inscription(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $email = filter_var($requete->post('mailInscr'), FILTER_SANITIZE_EMAIL);
        $email2 = filter_var($requete->post('mailInscr2'), FILTER_SANITIZE_EMAIL);
        $mdp1 = $requete->post('mdp1Inscr');
        $mdp2 = $requete->post('mdp2Inscr');
        if($mdp1 == $mdp2 && $email == $email2){
            $nom = filter_var($requete->post('nomInscr'), FILTER_SANITIZE_STRING);
            $prenom = filter_var($requete->post('prenomInscr'), FILTER_SANITIZE_STRING);
            Authentication::createUser($nom, $prenom, $email, $mdp1);
        } else {
            $_SESSION['message'] = "L'inscription n'a pas été effectuée";
        }
        Authentication::authenticateEns($email, $mdp1);
        $app->redirect($app->urlFor("accueil"));
    }

    /*
     * Traitement de la connexion enseignant
     */
    public function connexionEns(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $email = filter_var($requete->post('mailCo'), FILTER_SANITIZE_EMAIL);
        $mdp = $requete->post('mdpCo');
        Authentication::authenticateEns($email, $mdp);
    }

    /*
     * Traitement de la connexion etudiant
     */
    public function connexionEtu(){
		$app = \Slim\Slim::getInstance();
		$requete = $app->request();
		$pseudo = filter_var($requete->post('nomCo'), FILTER_SANITIZE_STRING);
		$token = filter_var($requete->post('tokenSalon'), FILTER_SANITIZE_STRING);
		$salon = Salon::where('token','=',$token)->first();
		if(count($salon)>0){
			if($salon->ouvert == 1 || $salon->ouvert == 2){
                if(isset($_COOKIE['etudiant'])){
                    $tab = $_COOKIE['etudiant'];
                    $tab = unserialize($tab);
                    $token_cookie = $tab[1];
                    if($token_cookie == $token){  //on effecte une reconnexion
                        $eleve = Eleve::getById($tab[0]);
                        if($eleve->nom == $pseudo){
                            $_SESSION['message'] = "Reconexion effectuée";
                        } else {
                            $_SESSION['message'] = "Reconexion effectuée avec changement de pseudo";
                        }
                        $eleve->nom = $pseudo;
                        $eleve->save();
                        $app->redirect($app->urlFor('affsalon_etu'));
                    } else {
                        Authentication::authenticateEtu($pseudo,$salon);
                    }
                } else {
                    Authentication::authenticateEtu($pseudo,$salon);
                }
			}else{
				$_SESSION['message'] = "Le salon n'est pas ouvert";
				$app->redirect($app->urlFor("connexionEtu"));
			}
    	}else{
    		$_SESSION['message'] = "Aucun salon ne correspond au code";
    		$app->redirect($app->urlFor("connexionEtu"));
   		 }
    }

    /*
     * Traitement de la deconnexion d'un enseignant
     */
    public function deconnexionEns(){
      Authentication::deconnexion();
    }
    
    /**
     * Traitement du compte enseignant
     */
    public function modification(){
    	$app = \Slim\Slim::getInstance();
    	$requete = $app->request();
    	$nom = filter_var($requete->post('nom'), FILTER_SANITIZE_STRING);
    	$prenom = filter_var($requete->post('prenom'), FILTER_SANITIZE_STRING);
    	$mail = filter_var($requete->post('mail0'), FILTER_SANITIZE_EMAIL);
    	$mail1 = filter_var($requete->post('mail1'), FILTER_SANITIZE_EMAIL);
    	$mail2 = filter_var($requete->post('mail2'), FILTER_SANITIZE_EMAIL);
    	$mdp = filter_var($requete->post('mdp0'), FILTER_SANITIZE_STRING);
    	$mdp1 = filter_var($requete->post('mdp1'), FILTER_SANITIZE_STRING);
    	$mdp2 = filter_var($requete->post('mdp2'), FILTER_SANITIZE_STRING);
    	
    	if((empty($mail1) && !empty($mail2)) || (!empty($mail1) && empty($mail2))){
    		$_SESSION['message'] = "Veuillez donner tout les renseignements concernant le mail";
    		$app->redirect($app->urlFor('modificationEnseignant'));
    	}
    	if((empty($mdp) && empty($mdp1) && !empty($mdp2)) || (empty($mdp) && !empty($mdp1) && empty($mdp2))|| (!empty($mdp) && empty($mdp1) && empty($mdp2)) || (empty($mdp) && !empty($mdp1) && !empty($mdp2)) || (!empty($mdp) && empty($mdp1) && !empty($mdp2)) || (!empty($mdp) && !empty($mdp1) && empty($mdp2))){
    		$_SESSION['message'] = "Veuillez donner tout les renseignements concernant le mot de passe";
    		$app->redirect($app->urlFor('modificationEnseignant'));
    	}
    	if($mail1 != $mail2){
    		$_SESSION['message'] = "Veuillez vérifier que les deux adresses mail rentrées correspondent";
    		$app->redirect($app->urlFor('modificationEnseignant'));
    	}
    	if($mail == $mail1 || $mail == $mail2){
    		$_SESSION['message'] = "La nouvelle adresse mail ne doit pas être identique à l'ancienne";
    		$app->redirect($app->urlFor('modificationEnseignant'));
    	}
    	$user = Enseignant::getByEmail($_COOKIE['enseignant']);
    	if(empty($mail2)) $mail = $user->email;
    	else $mail = $mail2;
    	if(empty($mdp2)) $mdp = $user->mdp;
    	else{
    		if(!password_verify($mdp,$user->mdp)){
    			$_SESSION['message'] = "L'ancien mot de passe rentré ne correspond pas au réel mot de passe";
    			$app->redirect($app->urlFor('modificationEnseignant'));
    		}
    		if($mdp1 != $mdp2){
    			$_SESSION['message'] = "Veuillez vérifier que les deux mot de passe rentrés correspondent";
    			$app->redirect($app->urlFor('modificationEnseignant'));
    		}
    		if(password_verify($mdp1,$user->mdp)|| password_verify($mdp2,$user->mdp)){
    			$_SESSION['message'] = "Le nouveau mot de passe ne doit pas être identique à l'ancien";
    			$app->redirect($app->urlFor('modificationEnseignant'));
    		}
    		$mdp = $mdp2;
    	}
    	Authentication::updateUser($user,$nom,$prenom,$mail,$mdp);
    	$_SESSION['message'] = "Modification effectué avec succès";
    	$app->redirect($app->urlFor('accueil'));	
    }

}
