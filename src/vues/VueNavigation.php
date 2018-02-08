<?php

namespace pizza\vues;

use Slim\Slim;

class VueNavigation
{
    const AFF_INDEX = 1;
    const AFF_INSCRIPTION = 2;

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
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

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
        return "<h1>Inscription</h1>";
    }


}