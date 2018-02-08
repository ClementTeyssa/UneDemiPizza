<?php
namespace pizza\vues;

use pizza\controleurs\Calendar;
use Slim\Slim;

class VueItem{
	
	const AFF_ITEM = 1;
	const AFF_RES = 2;
	
	private $objet;

	public function __construct($obj = null)
	{
		$this->objet = $obj;
	}

	public function render($selecteur, $obj = null)
	{
		$content=null;
		if(isset($obj)){
			$this->objet = $obj;
		}
		switch ($selecteur){
			case  VueItem::AFF_ITEM:
				$content = $this->aff_item_entete();
				break;
            case VueItem::AFF_RES:
                $content = $this->aff_item_res();
                break;
		}
		return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
	}
	
	
	public function aff_item_entete(){
        $app =  \Slim\Slim::getInstance();
        $requete = $app->request();
        $path = $requete->getRootUri();
        $item = $this->objet;
		$nom = $item->nom;
		$id = $item->id;
		$desc = $item->description;
		$img = $item->id;
		$img = $path.'/images/item/'.$img.".jpg";

        $content = <<<end
		<h1 class="">Item $nom </h1>
		<div class="row">
                <div class="col s6">
                    <p>$desc</p>
                 <img class="responsive-img" src="$img">
            </div>
            <div class="col s6">
end;
        $content .= "
                <script>
                  $(function() {
                    $( '#datepicker').datepicker();
                  });
                </script>";
        // TODO: Faire le lien de l'action
        $r_item = $app->urlFor("itemR");
        $content .= <<<end
                <form id="form_item" method="POST" action="$r_item">
                            <label>Date à reserver</label>
                            <input type="hidden" name="idItem" value="$id">
                            <input type="date" name="the_date">
                            <button type="submit" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add_box</i></button>
                </form>
            </div>
        </div>
end;

		return $content;
	}

	public function aff_item_res(){
        $app = Slim::getInstance();
        $requete = $app->request();
        $date = $requete->post('the_date');
        $r_add = $app->urlFor("resItemT");
        $id = $requete->post('idItem');
        return <<<end
        <h1 class="center-align">Reservation</h1>
        <div class="row center-align">
            <div class="col s6">
                <form id="form_itemRes" method="POST" action="$r_cat">
                    <label>Date de début : $date$</label>
                    
            </div>
            <div class="col s6">
                    <label>Date de fin</label>
                    <input type="hidden" name="idItem" value="$id">
                    <input type="hidden" name="dateD" value="$date">
                    <input type="date" name="dateF">
            </div>
                <button type="submit" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add_box</i></button>
            </form>
        </div>
end;

    }
}