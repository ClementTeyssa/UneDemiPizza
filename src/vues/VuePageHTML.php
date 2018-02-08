<?php

namespace amphux\vues;

class VuePageHTML{

	public static function getHeaders(){
		$content = self::headersDeb();
		if(isset($_COOKIE['enseignant'])){
			$content .= self::headersCo();
		}else{
			$content .= self::headersPasCo();
		}
		$content .=self::finHeader();
		return $content;
	}

	/**
	 * @return string
	 *
	 * HTML du Début de chaque page (header)
	 */
	public static function headersDeb(){
		$app =  \Slim\Slim::getInstance();
		$index = $app->urlFor('accueil');
		$requete = $app->request();
		$path = $requete->getRootUri();
		#$img =$path.'/doc/Images/Logo.png';
		$favi=$path.'/images/favicon.png';
        $inscr = $app->urlFor("inscription");
        $coEleve = $app->urlFor('connexionEtudiant');
        $coProf = $app->urlFor('connexionEnseignant');
		return <<<end
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Amphux</title>                       <!-- Changer le titre !!!-->
		<link rel="stylesheet" href="$path./css/wbbtheme.css" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="$path./css/materialize.css"  media="screen,projection"/>
        <link rel="icon" type="image/png" href="$favi" />
        <script type="text/javascript" src="$path./js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="$path./js/materialize.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="$path./js/jquery.wysibb.min.js"></script>
		<script src="$path./js/jquery.wysibb.fr.js"></script>
		<script>
		$(function() {
		var wbbOpt = {
		buttons: "bold,italic,underline,|,img,link,|,code,quote",
		lang: "fr"
		}
  		$("#wysibb").wysibb(wbbOpt);
		})
		</script>
    </head>
    <body>
        <header>
            <!-- Dropdown bouton -->
            <ul id="dropdown1" class="dropdown-content">
              <li>
                <a href="#!"> <i class="material-icons">perm_identity</i>Enseignant</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="$inscr">Insciption</a>
              </li>
              <li>
                <a href="$coProf">Connexion</a>
              </li>
            </ul>
            <ul id="dropdown2" class="dropdown-content">
              <li>
                <a href="#!"><i class="material-icons">person</i>Etudiant</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="$coEleve">Connexion</a>
              </li>
            </ul>
        
            <div class="navbar-fixed">
              <nav>
                <div class="nav-wrapper container">
                  <a href="#" class="brand-logo center">Accueil</a>
                  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
end;

}

/**
 * @return string
 *
 * Appel HMTL d'affichage Header si un utilisateur est co
 */
public static function headersCo(){
        $app =  \Slim\Slim::getInstance();
	    $r_profil = $app->urlFor('modificationEnseignant');
		$r_decon = $app->urlFor('deconnexionEns');
		return <<<end
		<ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>
              <a class="dropdown-button" href="$r_profil" data-activates="dropdown1">Profil</a>
            </li>
            <li>
              <a class="dropdown-button" href="$r_decon" data-activates="dropdown2">Se déconnecter</a>
            </li>
          </ul>
end;
	}

	/**
	 * @return string
	 *
	 * Appel HMTL d'affichage Header si un utilisateur n'est pas co
	 */
	public static function headersPasCo(){
		return <<<end
		<ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>
              <a class="dropdown-button" href="#!" data-activates="dropdown1">
              <i class="material-icons right">arrow_drop_down</i>
              Enseignant
              </a>
            </li>
            <li>
              <a class="dropdown-button" href="#!" data-activates="dropdown2">
              <i class="material-icons right">arrow_drop_down</i>
              Etudiant
              </a>
            </li>
          </ul>
end;
	}

	/**
	 * @return string
	 *
	 * HTML pour finir le header
	 */
	public static function finHeader(){
        $app =  \Slim\Slim::getInstance();
        $inscr = $app->urlFor("inscription");
        $coEleve = $app->urlFor('connexionEtudiant');
        $coProf = $app->urlFor('connexionEnseignant');
		$content =  <<<end
                    <!--Version mobile -->
                  <ul class="side-nav" id="mobile-demo">
                    <li><a href="$coEleve">Connexion Enseignant</a></li>
                    <li><a href="$inscr">Insciption Enseignant</a></li>
                    <li><a href="$coProf">Connexion Etudiant</a></li>
                  </ul>
                </div>
              </nav>
            </div>
          </header>
          <main class="grey lighten-1">
            <div class="container">
end;
		if(isset($_SESSION['message'])){
            $message = $_SESSION['message'];
            $content .= <<<end
            <p class="message">$message</p>
end;
        }
        $_SESSION['message'] = null;
        return $content;
	}

	/**
	 * @return string
	 *
	 * Affichage du footer sur chaque page
	 */
	public static function getFooter(){
		$app =  \Slim\Slim::getInstance();
		$contact = $app->urlFor('accueil');
		return <<<end
		</div class="container">
    </main>
    <footer class="page-footer">
      <div class="container">
        <div class="row">
             <div class="col s3">IALO Ian</div>
             <div class="col s3">HOLZHAMMER David</div>
             <div class="col s3">FRASCHINI Théo</div>
             <div class="col s3">TEYSSANDIER Clément</div>
        </div>
        <a class="grey-text text-lighten-4 right" href="#!">IUT Nancy Charlemagne 2017-2018</a>
        <br><br>
      </div>
  </footer>
</body>
</html>
end;
	}
}
