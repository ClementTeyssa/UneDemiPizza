<?php

namespace pizza\vues;

class VueNavigation
{
    const AFF_INDEX = 1;

    private $objet;

    public function __construct($array = null)
    {
        $this->objet = $array;
    }

    public function render($selecteur, $tab = null)
    {
        switch ($selecteur){
            case  VueNavigation::AFF_INDEX:
                $content = $this->index();
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

    private function index(){
        return "<h1>Index</h1>";
    }


}