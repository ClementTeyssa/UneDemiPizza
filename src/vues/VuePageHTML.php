<?php

namespace pizza\vues;

class VuePageHTML{

	public static function getHeaders(){
	     // TODO: faire ici les vérifications pour les connexion et les différents headers
        return VuePageHTML::getHeaderDeb().VuePageHTML::getHeaderFin();
    }

    public static function getHeaderDeb(){
        $app =  \Slim\Slim::getInstance();
        $requete = $app->request();
        $path = $requete->getRootUri();
	    return <<<end
        <!DOCTYPE html>
        <html>
        <head>
          <title>Une Demi Pizza</title>
          <!--Import des icones googleapis-->
          <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
          <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/base/jquery-ui.css">
          <!--Import materialize.css-->
          <link type="text/css" rel="stylesheet" href="$path/css/materialize.css"  media="screen,projection"/>
          <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
          <script type="text/javascript" src="$path/js/materialize.js"></script>
<script>
$(document).ready(function(){
    $('.fixed-action-btn.toolbar').openToolbar();
    $('.fixed-action-btn.toolbar').closeToolbar();
});
</script>
        </head>
        <body>
          <header>
end;

    }
	    
    public static function getHeaderFin(){
        if(isset($_COOKIE['profile'])) return VuePageHTML::getHeaderCo();
        else return VuePageHTML::getHeaderPasCo();
    }
    
    public static function getHeaderCo(){
        $app =  \Slim\Slim::getInstance();
        $deco = $app->urlFor("accueil");
        $acc = $app->urlFor("accueil");
        $tab = unserialize($_COOKIE['profile']);
        $deco = $app->urlFor('deconnexion');
        $content = <<<end
          <nav>
            <div class="nav-wrapper">
              <a href="$acc" class="brand-logo center">Accueil</a>
              <ul class="left hide-on-med-and-down">
                <li><a href="$deco">Deconnexion</a></li>
                <li>Connecté en tant que $tab[0]</li>
              </ul>
            </div>
          </nav>
        </header>
        <main>
            <div class="container">
end;
        if($_SESSION['message']){
            $msg = $_SESSION['message'];
            $content .= <<<end
            <script>alert($msg)</script>
end;
            $_SESSION = null;
        }
        return $content;
    }

    public static function getHeaderPasCo(){
        $app =  \Slim\Slim::getInstance();
        $inscr = $app->urlFor("inscription");
        $acc = $app->urlFor("accueil");
        $co = $app->urlFor("connexion");
        return <<<end
          <nav>
            <div class="nav-wrapper">
              <a href="$acc" class="brand-logo center">Accueil</a>
              <ul class="left hide-on-med-and-down">
                <li><a href="$co">Connexion</a></li>
                <li><a href="$inscr">inscription</a></li>
              </ul>
            </div>
          </nav>
        </header>
        <main>
            <div class="container">
end;
    }

	public static function getFooter(){
        return <<<end
            </div class="container">
        </main>
        <footer class="page-footer">
      <div class="container">
        <div class="row">
             <div class="col s3">BIALO Ian</div>
             <div class="col s3">HOLZHAMMER David</div>
             <div class="col s3">GOMAS Maximilien</div>
             <div class="col s3">TEYSSANDIER Clément</div>
        </div>
        <div class="row">
             <div class="col s3">OBERHAUSSER Ober</div>
             <div class="col s3">REMOIVILLE Guerric</div>
             <div class="col s3">HUBERT Baptiste</div>
        </div>
        <a href="http://factuel.univ-lorraine.fr/node/5865" class="grey-text text-lighten-4 right" href="#!">Cancer CharlyDay 2018</a>
        <br><br>
      </div>
  </footer>
end;

	}
}
