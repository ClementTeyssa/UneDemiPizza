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
                $content = $this->aff_catalogue();
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

    public function aff_catalogue(){
        return "<h1 class=\"center-align\">Catalogue</h1><br><br>".$this->aff_catalogue_v().$this->aff_catalogue_a();
    }

    private function aff_catalogue_v(){
        $cat = $this->objet['2'];
        $content =  <<<end
        <div class="row">
            <div class="s6">
                <h2>Catalogue des véhicules</h2>
                <br>
                <p>$cat</p>
                <br>
                <table class="highlight">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Reserver</th>
                    </tr>
end;
        $vehicules = $this->objet[0];
        foreach ($vehicules as $item){
            $vehicule = Item::getById($item);
            if($vehicule->id_categ == 1){
                $nom = $vehicule->nom;
                $desc = $vehicule->description;
                $content = <<<end
                <tr>
                    <td>$nom</td>
                    <td>$desc</td>
                    <td>BOUTON A FAIRE</td>
                </tr>
end;
            }
        }
        $content .= <<<end
                </table>
        <div class="s6">
end;

        return $content;
    }


    private function aff_catalogue_a(){
        $cat = $this->objet['3'];
        $content = <<<end
        <div class="col s6">
            <h3>Catalogue des ateliers</h3>
                <br>
                <p>$cat</p>
                <br>
                <table class="highlight">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Reserver</th>
                        </tr>
                    </thead>
                    <tbody>
end;
        $ateliers = $this->objet[1];
        foreach ($ateliers as $atelier) {
            $nom = $atelier->nom;
            $desc = $atelier->description;
            $content .= <<<end
                <tr>
                    <td>$nom</td>
                    <td>$desc</td>
                    <td>BOUTON A FAIRE</td>
                </tr>
end;
        }
        $content .= <<<end
                    </tbody>
                </table>
        </div class="col s6">
end;
        return $content;
    }
}