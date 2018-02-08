<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 08/02/2018
 * Time: 10:59
 */

namespace pizza\vues;
use pizza\models\Item;
use Slim\Slim;

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
        $tab = unserialize($_COOKIE['profile']);
        if($tab[1] == 0) return "<h1 class=\"center-align\">Catalogue</h1><br><br>".$this->aff_catalogue_v_client().$this->aff_catalogue_a_client();
        else return "<h1 class=\"center-align\">Catalogue</h1><br><br>".$this->aff_catalogue_v_admin().$this->aff_catalogue_a_admin();
    }

    private function aff_catalogue_v_admin(){
        $app = \Slim\Slim::getInstance();
        $cat = $this->objet['2'];
        $tab = unserialize($_COOKIE['profile']);
        $add = $app->urlFor("editionItem");
        $content =  <<<end
        <div class="row">
        <div class="col s6">
            <h3>Catalogue des véhicules</h3>
                <br>
                <p>$cat</p>
                <div align="right">
                <a href="$add" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
                </div>
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
        $vehicules = $this->objet[0];
        foreach ($vehicules as $vehicule){
                $nom = $vehicule->nom;
                $desc = $vehicule->description;
                $idtem = $vehicule->id;
                $app = Slim::getInstance();
                $r_item = $app->urlFor("item");
                $delete = $app->urlFor("itemDelete");
                $content .= <<<end
                <tr>
                    <td>$nom</td>
                    <td>$desc</td>
                    <td>
                <div style="position: relative; height: 70px;">
                 <div class="fixed-action-btn horizontal click-to-toggle" style="position: absolute; right: 2px;">
                  <a class="btn-floating btn-large red">
                  <i class="material-icons">settings</i>
                  </a>
                    <ul>
                     <li><form id="form_button" class="formulaire" method="POST" action="$r_item"><button class="btn-floating green"><i class="material-icons">publish</i><input id="idItem" name="idItem" type="hidden" value="$idtem"></button></form></li>
                     <li><a class="btn-floating yellow darken-1"><i class="material-icons">settings</i></a></li>
                     <li><form id="form_button" class="formulaire" method="POST" action="$delete"><button class="btn-floating red" onclick="return confirm('Êtes vous sûr de vouloir supprimer ?')"><input id="idItem" name="idItem" type="hidden" value="$idtem"><i class="material-icons">delete_forever</i></button></form></li>
                    </ul>
                 </div>
                </div>
                    </td>
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


    private function aff_catalogue_a_admin(){
        $cat = $this->objet['3'];
        $app = \Slim\Slim::getInstance();
        $add = $app->urlFor("editionItem");
        $content = <<<end
        <div class="col s6">
            <h3>Catalogue des ateliers</h3>
                <br>
                <p>$cat</p>
                <div align="right">
                <a href="$add" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
                </div>
                <table class="highlight">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Accéder</th>
                        </tr>
                    </thead>
                    <tbody>
end;
        $ateliers = $this->objet[1];
        foreach ($ateliers as $atelier) {
            $nom = $atelier->nom;
            $desc = $atelier->description;
            $idtem = $atelier->id;
            $app = Slim::getInstance();
            $r_item = $app->urlFor("item");
            $content .= <<<end
                <tr>
                    <td>$nom</td>
                    <td>$desc</td>
                    <td>
                        <div style="position: relative; height: 70px;">
                 <div class="fixed-action-btn horizontal click-to-toggle" style="position: absolute; right: 2px;">
                  <a class="btn-floating btn-large red">
                  <i class="material-icons">settings</i>
                  </a>
                    <ul>
                     <li><button class="btn-floating green"><i class="material-icons">publish</i></button></li>
                     <li><a class="btn-floating yellow darken-1"><i class="material-icons">settings</i></a></li>
                     <li><a class="btn-floating red"><i class="material-icons">delete_forever</i></a></li>
                    </ul>
                 </div>
                </div>
                    </td>
                </tr>
end;
        }
        $content .= <<<end
                    </tbody>
                </table>
        </div class="col s6">
        </div class="row">
end;
        return $content;
    }
    
    private function aff_catalogue_v_client(){
        $cat = $this->objet['2'];
        $tab = unserialize($_COOKIE['profile']);
        $app = \Slim\Slim::getInstance();
        $add = $app->urlFor("editionItem");
        $content =  <<<end
        <div class="row">
        <div class="col s6">
            <h3>Catalogue des véhicules</h3>
                <br>
                <p>$cat</p>
                <div align="right">
                <a href="$add" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
                </div>
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
        $vehicules = $this->objet[0];
        foreach ($vehicules as $vehicule){
            $nom = $vehicule->nom;
            $desc = $vehicule->description;
            $idtem = $vehicule->id;
            $app = Slim::getInstance();
            $r_item = $app->urlFor("item");
            $content .= <<<end
                <tr>
                    <td>$nom</td>
                    <td>$desc</td>
                    <td>
                <div style="position: relative; height: 70px;">
                 <div class="fixed-action-btn horizontal click-to-toggle" style="position: absolute; right: 2px;">
                  <a class="btn-floating btn-large red">
                  <i class="material-icons">settings</i>
                  </a>
                    <ul>
                     <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
                     <li><a class="btn-floating yellow darken-1"><i class="material-icons">settings</i></a></li>
                     <li><a class="btn-floating red"><i class="material-icons">delete_forever</i></a></li>
                    </ul>
                 </div>
                </div>
                    </td>
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
    
    
    private function aff_catalogue_a_client(){
        $cat = $this->objet['3'];
        $app = \Slim\Slim::getInstance();
        $add = $app->urlFor("editionItem");
        $content = <<<end
        <div class="col s6">
            <h3>Catalogue des ateliers</h3>
                <br>
                <p>$cat</p>
                <div align="right">
                <a href="$add" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
                </div>
                <table class="highlight">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Accéder</th>
                        </tr>
                    </thead>
                    <tbody>
end;
        $ateliers = $this->objet[1];
        foreach ($ateliers as $atelier) {
            $nom = $atelier->nom;
            $desc = $atelier->description;
            $idtem = $atelier->id;
            $app = Slim::getInstance();
            $r_item = $app->urlFor("item");
            $content .= <<<end
                <tr>
                    <td>$nom</td>
                    <td>$desc</td>
                    <td>
                        <div style="position: relative; height: 70px;">
                 <div class="fixed-action-btn horizontal click-to-toggle" style="position: absolute; right: 2px;">
                  <a class="btn-floating btn-large red">
                  <i class="material-icons">settings</i>
                  </a>
                    <ul>
                     <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
                     <li><a class="btn-floating yellow darken-1"><i class="material-icons">settings</i></a></li>
                     <li><a class="btn-floating red"><i class="material-icons">delete_forever</i></a></li>
                    </ul>
                 </div>
                </div>
                    </td>
                </tr>
end;
        }
        $content .= <<<end
                    </tbody>
                </table>
        </div class="col s6">
        </div class="row">
end;
        return $content;
    }
}