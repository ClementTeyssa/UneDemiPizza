<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 21/01/2018
 * Time: 14:25
 */

namespace pizza\controleurs;
use pizza\vues\VueNavigation;

class ControleurUser
{
    /*
     * ==============================================================
     *                          Affichage
     * ==============================================================
     */

    /*
     * Affichage de l'index
     */
    public function index(){
        $vue = new VueNavigation();
        print $vue->render(VueNavigation::AFF_INDEX);
    }
    
    /*
     * Affichage de l'inscription
     */
    public function inscription(){
        $vue = new VueNavigation();
        print $vue->render(VueNavigation::AFF_INSCRIPTION);
    }

}
