<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 21/01/2018
 * Time: 14:15
 */

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
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

    private function index(){

    }


}