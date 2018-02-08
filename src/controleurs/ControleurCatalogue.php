<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 08/02/2018
 * Time: 10:55
 */

namespace pizza\controleurs;


use pizza\models\Item;
use pizza\models\Categorie;
use pizza\vues\VueCatalogue;

class ControleurCatalogue
{
    /*
     * ==============================================================
     *                          Affichage
     * ==============================================================
     */
    public function aff_catalogue(){
        // TODO: vérifier si la personne est connectée
        $tab = array();
        $vehicules = Item::where('id_categ', '=', 1)->get();
        $atelier = Item::where('id_categ', '=', 2)->get();
        $cat1 = Categorie::where('id', '=', 1)->first();
        $cat1d = $cat1->description;
        $cat2 = Categorie::where('id', '=', 2)->first();
        $cat2d = $cat2->description;
        array_push($tab, $vehicules);
        array_push($tab, $atelier);
        array_push($tab, $cat1d);
        array_push($tab, $cat2d);
        $vue = new VueCatalogue($tab);
        print $vue->render(VueCatalogue::AFF_CATALOGUE, $tab);
    }
}