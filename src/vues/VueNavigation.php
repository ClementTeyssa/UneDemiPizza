<?php

namespace pizza\vues;

use Slim\Slim;

class VueNavigation
{
    const AFF_INDEX = 1;
    const AFF_INSCRIPTION = 2;
    const AFF_CONNEXION = 3;

    private $objet;

    public function __construct($array = null)
    {
        $this->objet = $array;
    }

    public function render($selecteur, $tab = null)
    {
        switch ($selecteur){
            case VueNavigation::AFF_INDEX:
                $content = $this->index();
                break;
            case VueNavigation::AFF_INSCRIPTION:
                $content = $this->inscription();
                break;
            case VueNavigation::AFF_CONNEXION:
                $content = $this->connexion();
                break;
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

    // TODO: faire les verifs en fonctions de si il est co
    private function index(){
        $app = Slim::getInstance();
        $catalogue = $app->urlFor('catalogue');
        return <<<end
        <h1>Accueil</h1>
        <br>
        <a href="$catalogue">Accéder au catalogue</a>
end;
    }
    
    private function inscription(){
        $app = \Slim\Slim::getInstance();
        $r_inscr = $app->urlFor("inscriptionT");
        $r_accueil = $app->urlFor("accueil");
        return  <<<end
        <h1>Page d'inscription</h1>
        <br>
        <br>
        <form id="form_connexion" class="formulaire" method="POST" action="$r_inscr">
            <div class="row">
                <label class="black-text">Mail de connexion</label>
                <div class="input-field">                  
                    <input placeholder="exemple@mail.com" type="email" name="mailInscr" required>
                </div>
                <br/>
                <label class="black-text">Nom</label>
                <div class="input-field">                  
                    <input placeholder="johnny" type="text" name="nomInscr" required>
                </div>
                <br/>
                <label class="black-text">Mot de passe</label>
                 <div class="input-field">
                    <input placeholder="mot de passe"  type="password" name="mdp1Inscr" required>
                 </div>
                 <br/>
                 <label class="black-text">Répeter mot de passe</label>
                 <div class="input-field">
                    <input placeholder="mot de passe"  type="password" name="mdp2Inscr" required>
                 </div>
             </div>
            <button type="submit" name="Se connecter" value="formCo">Se connecter</button>
        </form>
		<br>
end;
    }
        
    private function connexion(){
        $app = \Slim\Slim::getInstance();
        $r_connexion = $app->urlFor("connexion");
        $r_accueil = $app->urlFor("accueil");
        return  <<<end
        <h1>Page de connexion</h1>
        <br>
        <br>
        <form id="form_connexion" class="formulaire" method="POST" action="$r_connexion">
            <div class="row">
                <label class="black-text">Mail de connexion</label>
                <div class="input-field">
                    <input placeholder="exemple@mail.com" type="email" name="mailCo" id="connexion_mail" required>
                </div>
                <br/>
                <label class="black-text">Mot de passe</label>
                 <div class="input-field">
                    <input placeholder="mot de passe"  type="password" name="mdpCo" id="connexion_mdp" required>
                 </div>
             </div>
            <br/><br/>
            <button type="submit" name="Se connecter" value="formCo">Se connecter</button>
        </form>
		<br>
		<a href='$r_accueil' id="accueil" >Accueil</a>
end;
    }
}