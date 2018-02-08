<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 21/01/2018
 * Time: 14:15
 */

namespace amphux\vues;
use amphux\models\Enseignant;

class VueNavigation
{
    const AFF_INDEX = 1;
    const AFF_INSCRIPTION = 2;
    const AFF_CONNEXION_ENSEIGNANT= 3;
    const AFF_CONNEXION_ETUDIANT= 4;
    const AFF_MODIFICATION_ENSEIGNANT = 5;

    private $objet;

    public function __construct($array = null)
    {
        $this->objet = $array;
    }

    public function render($selecteur, $tab = null)
    {
        /**
         * vérifier si il y a besoin de le supprimer
         */
        $content=null;
        if(isset($tab)){
            $this->objet = $tab;
        }
        switch ($selecteur) {
            case VueNavigation::AFF_INDEX :
                $content = $this->index();
                break;
            case VueNavigation::AFF_INSCRIPTION:
                $content = $this->inscription();
                break;
            case VueNavigation::AFF_CONNEXION_ENSEIGNANT:
            	$content = $this->connexionEnseignant();
            	break;
            case VueNavigation::AFF_CONNEXION_ETUDIANT:
            	$content = $this->connexionEtudiant();
            	break;
            case VueNavigation::AFF_MODIFICATION_ENSEIGNANT;
            	$content = $this->modificationEnseignant();
            	break;
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

    private function index(){
        $app = \Slim\Slim::getInstance();
        $content =  <<<end
end;
        if(isset($_COOKIE['enseignant'])){
            $content .= $this::indexEns();//"<br>Vous êtes connecté en tant que ".$_COOKIE['enseignant'];
        } else {
            $content .= "<br>Vous n'êtes pas connecté";
        }
        return $content;
    }

    private function indexEns(){
        $app = \Slim\Slim::getInstance();
        $mail_ens = $_COOKIE['enseignant'];
        $r_salons = $app->urlFor("affSalons");
        return <<<end
        <br>
        <p>Vous êtes connecté en tant que $mail_ens</p>
        <br>
        <a href="$r_salons" class="bouton">Mes salons</a>
end;
    }

    private function inscription(){
        $app = \Slim\Slim::getInstance();
        $r_inscription = $app->urlFor("inscription");
        return <<< end
        <h1>Inscription</h1>
        <br>
        <form id="form_inscription" class="for" method="POST" action="$r_inscription">
            <label class="black-text">Nom</label>
            <input placeholder="Johny" type="text" name="nomInscr" id="nomInscr" required>
            <br>
            <label class="black-text">Prénom</label>
            <input placeholder="John" type="text" name="prenomInscr" id="prenomInscr" required>
            <br>
			<label class="black-text">Adresse mail</label>
            <input placeholder="JohnJohny@gmail.com" type="email" name="mailInscr" required>
            <br>
            <label class="black-text">Confirmation de l'adresse mail</label>
            <input placeholder="JohnJohny@gmail.com" type="email" name="mailInscr2" required>
            <br>
            <label class="black-text">Mot de passe (taille de 6 à 20 charactères)</label>
            <input placeholder="**********"  type="password" name="mdp1Inscr" id="mdp1Inscr" pattern=".{6,20}" required>
            <br>
            <label class="black-text">Confirmation du mot de passe</label>
            <input placeholder="**********"  type="password" name="mdp2Inscr" id="mdp2Inscr" pattern=".{6,20}" required>
            <br>
            <br>
            <input type="submit" class="bouton" value="S'inscrire" class="bouton">
        </form>
end;

    }
        
    /**
     * Méthode pour afficher le menu de connexion
     * @return string
     */
    private function connexionEnseignant(){
    	$app = \Slim\Slim::getInstance();
    	$r_connexionEns = $app->urlFor("connexionEns");
    	$r_connexionEtu = $app->urlFor("connexionEtu");
    	$r_inscription = $app->urlFor("inscription");
    	return  <<<end
        <h1>Page de connexion enseignant</h1>
        <br>
		<p>Vous êtes un étudiant ? <a href="$r_connexionEtu" class="bouton">Connectez vous</a></p>
		<p>Pas encore de compte ? <a href="$r_inscription" class="bouton">Inscrivez vous</a></p>
        <br>
        <form id="form_connexion" class="formulaire" method="POST" action="$r_connexionEns">
            <label class="black-text">Adresse mail</label>
            <input placeholder="exemple@mail.com" type="email" name="mailCo" required>
            <br>
            <label class="black-text">Mot de passe</label>
            <input placeholder="mot de passe"  type="password" name="mdpCo" required>
            <br>
            <br>
            <button type="submit" name="Se connecter" value="formCo" class="bouton">Se connecter</button>
        </form>
		<br>
end;
    	
    }
    	
    private function connexionEtudiant(){
    	$app = \Slim\Slim::getInstance();
        $r_connexionEns = $app->urlFor("connexionEns");
        $r_connexionEtu = $app->urlFor("connexionEtu");
    	return  <<<end
        <h1>Page de connexion étudiant</h1>
        <br>
		<p>Vous êtes un enseignant ? <a href=$r_connexionEns  class="bouton">Connectez vous</a></p>
        <br>
        <form id="form_connexion" class="formulaire" method="POST" action="$r_connexionEtu">
            <label class="black-text">Votre nom :</label>
            <input placeholder="Votre nom ici" type="text" name="nomCo" required>
            <br><br>
			<label class="black-text">Insérez le nom du token ici :</label>
			<input placeholder="token du salon" type="text" name="tokenSalon" required>
            <br>
            <button type="submit" name="Se connecter" value="formCo" class="bouton">Se connecter</button>
        </form>
		<br>
end;
    	
    }
    	
    private function modificationEnseignant(){
    	$app = \Slim\Slim::getInstance();
    	$r_modification = $app->urlFor("modificationEns");
    	$r_accueil = $app->urlFor("accueil");
    	if(isset($_COOKIE['enseignant'])){
    		$mail = $_COOKIE['enseignant'];
    	}else{
    		$app->redirect($r_accueil);
    	}
    	$user = Enseignant::getByEmail($mail);
    	$affichage =  <<<end
        <h1>Profil de l'utilisateur</h1>
        <br/>
        <br/>
		<form id="formulaire_inscription" class="for" method="POST" action="$r_modification">
        <div class="row">
			<label class="black-text">Nom d'utilisateur</label>
            <div class="input-field">
                <input placeholder="Nom" value='$user->nom' type="text" name="nom" required>
            </div>
            <br/>
			<label class="black-text">Prénom d'utilisateur</label>
			<div class="input-field">
                <input placeholder="Prénom" value='$user->prenom' type="text" name="prenom" required>
            </div>
			<br/>
            <br/>
			<label class="black-text">Modification du mail :</label><br/>
			<label class="black-text">Ancien mail</label>
            <div class="input-field">
                <input placeholder="ancien mail" value='$user->email' type="text" name="mail0" readonly required>
            </div>
            <br/>
			<label class="black-text">Nouveau mail</label>
            <div class="input-field">
                <input placeholder="nouveau mail" type="text" name="mail1">
            </div>
            <br/>
			<label class="black-text">Confirmation du nouveau mail</label>
            <div class="input-field">
                <input placeholder="nouveau mail"  type="text" name="mail2">
            </div>
			<br/>
            <br/>
			<label class="black-text">Modification du mot de passe :</label><br/>
			<label class="black-text">Ancien mot de passe</label>
            <div class="input-field">
                <input placeholder="*********"  type="password" name="mdp0" id="inscription_mdp0" pattern=".{6,20}">
            </div>
            <br/>
			<label class="black-text">Nouveau mot de passe (taille de 6 à 20 charactères)</label>
            <div class="input-field">
                <input placeholder="*********"  type="password" name="mdp1" id="inscription_mdp1" pattern=".{6,20}">
            </div>
            <br/>
			<label class="black-text">Confirmation du mot de passe</label>
            <div class="input-field">
                <input placeholder="*********"  type="password" name="mdp2" id="inscription_mdp2" pattern=".{6,20}">
            </div>
        </div>
        <br/><br/>
        <button type="submit" name="inscription" value="formCo">Modifier</button>
    </form>
	<br>
end;
    	return $affichage;
    }
}