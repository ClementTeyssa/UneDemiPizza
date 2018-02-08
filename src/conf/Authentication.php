<?php
namespace pizza\conf;
use pizza\models\user;

class Authentication{

	public static function createUser( $name, $mail, $password){
		$password = password_hash($password, PASSWORD_DEFAULT, Array('cost' => 12));
		$u = new user();
		$u->email = $mail;
		$u->nom = $name;
		$u->mdp = $password;
		$u->save();
	}

	public static function authenticateEns($mail, $password){
		$app =  \Slim\Slim::getInstance();
		$user = User::getByEmail($mail);
		if($user != null) {
			if (password_verify($password,$user->mdp)) {
				self::loadProfileEns($mail);
			} else {
				$_SESSION['message'] = "Le mot de passe est incorrect";
				$app->redirect($app->urlFor("connexionEns"));
			}
		}else{
			$_SESSION['message'] = "L'utilisateur est introuvable";
			$app->redirect($app->urlFor("connexionEns"));
		}
	}

	public static function loadProfileEns( $mail ){
		$app =  \Slim\Slim::getInstance();
		setcookie('enseignant', $mail, time()+60*60*24*30, "/");
        unset($_COOKIE['etudiant']);
        setcookie('etudiant', '', time() - 60*60*24, '/');
        $_SESSION['message'] = "Vous vous êtes bien connecté";
		$app->redirect($app->urlFor("accueil"));
	}

	public static function deconnexion(){
		$app =  \Slim\Slim::getInstance();
        if (isset($_COOKIE['enseignant'])) {
            unset($_COOKIE['enseignant']);
            setcookie('enseignant', '', time() - 60*60*24, '/'); // valeur vide et temps dans le passé
            $_SESSION['message'] = "Vous avez bien été déconnecté";
        }
        $app->redirect($app->urlFor("accueil"));
	}

	
	public static function updateUser( $u, $surName, $firstName, $mail, $password ){
		$password = password_hash($password, PASSWORD_DEFAULT, Array('cost' => 12));
		$u->email = $mail;
		$u->nom = $surName;
		$u->prenom = $firstName;
		if(!empty($password)) $u->mdp = $password;
		$u->save();
		if (isset($_COOKIE['enseignant'])) {
			unset($_COOKIE['enseignant']);
			setcookie('enseignant', '', time() - 60*60*24, '/');
			setcookie("enseignant", $u->email, time()+60*60*24*30,"/");
		}
	}
	
	public static function authenticateEtu($pseudo, $salon){
		$app =  \Slim\Slim::getInstance();
		$eleve = new Eleve();
		$eleve->idSalon = $salon->idSalon;
		$eleve->nom = $pseudo;
		$eleve->save();
		$tab = array($eleve->idEleve, $salon->token);
		$tab = serialize($tab);
		setcookie('etudiant', $tab, time()+60*60*2, '/');
        unset($_COOKIE['enseignant']);
        setcookie('enseignant', '', time() - 60*60*24, '/');
		$app->redirect($app->urlFor('affsalon_etu'));
	}
}
