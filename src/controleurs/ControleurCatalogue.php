<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 08/02/2018
 * Time: 10:55
 */

namespace pizza\controleurs;


use pizza\models\Item;
use pizza\vues\VueCatalogue;

class ControleurCatalogue
{
    /*
     * ==============================================================
     *                          Affichage
     * ==============================================================
     */
    public function aff_catalogue(){
        /*
         * verification si il est connecté
        */
        $tab = array();
        $vehicules = Item::whereRaw("id_categ = 1")->get();
        $atelier = Item::select('id')->where('id_categ', '=', 2)->get();
        array_push($tab, $vehicules);
        array_push($tab, $atelier);
        $vue = new VueCatalogue($tab);
        print $vue->render(VueCatalogue::AFF_CATALOGUE, $tab);
    }
}