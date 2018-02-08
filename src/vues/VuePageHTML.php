<?php

namespace pizza\vues;

class VuePageHTML{

	public static function getHeaders(){
	    /*
	     * faire ici les vérifications pour les connexion et les différents headers
	     */
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
          <!--Import materialize.css-->
          <link type="text/css" rel="stylesheet" href="$path/css/materialize.css"  media="screen,projection"/>
        
          <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
          <script type="text/javascript" src="$path/./js/jquery-3.2.1.min.js"></script>
          <script type="text/javascript" src="$path/js/materialize.js"></script>
        </head>
        <body>
          <header>
end;

    }

    public static function getHeaderFin(){
        $app =  \Slim\Slim::getInstance();
        $inscr = $app->urlFor("inscription");
        $co = $app->urlFor("connexion");
        return <<<end
          <nav>
            <div class="nav-wrapper">
              <a href="$inscr" class="brand-logo center">Accueil</a>
              <ul class="left hide-on-med-and-down">
                <li><a href="$co">Connexion Administrateur</a></li>
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
        <a class="grey-text text-lighten-4 right" href="#!">Cancer CharlyDay 2018</a>
        <br><br>
      </div>
  </footer>
end;

	}
}
