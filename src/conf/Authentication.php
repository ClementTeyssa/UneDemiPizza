<?php
namespace pizza\conf;
use pizza\models\user;

class Authentication{

	public static function createUser($name, $mail, $password){
		$password = password_hash($password, PASSWORD_DEFAULT, Array('cost' => 12));
		$u = new user();
		$u->email = $mail;
		$u->nom = $name;
		$u->mdp = $password;
		$u->save();
		Authentication::authenticate($mail,$password);
	}

	public static function authenticate($mail, $password){
		$app =  \Slim\Slim::getInstance();
		$user = User::getByEmail($mail);
		if($user != null) {
			if(password_verify($password,$user->mdp)) {
				self::loadProfile($mail);
			} else {
				$app->redirect($app->urlFor("connexion"));
			}
		}else{
			$app->redirect($app->urlFor("connexion"));
		}
	}

	public static function loadProfile( $mail ){
		$app =  \Slim\Slim::getInstance();
		setcookie('profile', $mail, time()+60*60*24*30, "/");
        unset($_COOKIE['profile']);
        setcookie('profile', '', time() - 60*60*24, '/');
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
}
