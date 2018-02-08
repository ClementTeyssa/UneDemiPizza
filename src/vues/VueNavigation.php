<?php

namespace pizza\vues;

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
        return "<h1>Index</h1>";
    }
    
    private function inscription(){
        return "<h1>Inscription</h1>";
    }


}