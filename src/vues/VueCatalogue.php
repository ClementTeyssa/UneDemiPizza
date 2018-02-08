<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 08/02/2018
 * Time: 10:59
 */

namespace pizza\vues;
use pizza\models\Item;

class VueCatalogue
{

    const AFF_CATALOGUE = 1;
    const AFF_CATALOGUE_ADMIN = 2;

    private $objet;

    public function __construct($array = null)
    {
        $this->objet = $array;
    }

    public function render($selecteur, $tab = null)
    {
        $content=null;
        if(isset($tab)){
            $this->objet = $tab;
        }
        switch ($selecteur){
            case  VueCatalogue::AFF_CATALOGUE:
                $content = $this->index();
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

    public function aff_catalogue(){
        $content =  <<<end
        <div class="row">
            <div class="s6">
                <h2>Catalogue des véhicules</h2>
                <br>
                <p>description vehicule</p>
                <br>
                <table class="highlight">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Reserver</th>
                    </tr>
end;
        $items = $this->objet[0];
        foreach ($items as $item){
            $vehicule = Item::getById($item);
            if($vehicule->id_categ == 1){
                $nom = $vehicule->nom;
                $desc = $vehicule->description;
                $content = <<<end
                <td>$nom</td>
                <td>$desc</td>
                <td>BOUTON A FAIRE</td>
end;
            }
        }
        $content = <<<end
                </table>
end;


    }
}