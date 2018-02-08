<?php
namespace pizza\conf;
use pizza\models\User;

class Authentication{

	public static function createUser($name, $mail, $password){
		$password = password_hash($password, PASSWORD_DEFAULT, Array('cost' => 12));
		$u = new user();
		$u->email = $mail;
		$u->nom = $name;
		$u->mdp = $password;
		$u->type = 0;
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
        unset($_COOKIE['profile']);
        setcookie('profile', '', time() - 60*60*24, '/');
        $user = User::getByEmail($mail);
        $role = $user->type;
        $tab = array();
        array_push($tab, $mail);
        array_push($tab, $role);
        $ccokie = serialize($tab);
        setcookie('profile', $ccokie, time()+60*60*24*30, "/");
	}

	public static function deconnexion(){
		$app =  \Slim\Slim::getInstance();
        if (isset($_COOKIE['profile'])) {
            unset($_COOKIE['profile']);
            setcookie('profile', '', time() - 60*60*24, '/'); // valeur vide et temps dans le passés
        }
        $app->redirect($app->urlFor("accueil"));
	}
}
