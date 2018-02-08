<?php
namespace pizza\vues;

use pizza\controleurs\Calendar;
use Slim\Slim;

class VueItem{
	
	const AFF_ITEM = 1;
	
	private $objet;

	public function __construct($obj = null)
	{
		$this->objet = $obj;
	}

	public function render($selecteur, $obj)
	{
		$content=null;
		if(isset($obj)){
			$this->objet = $obj;
		}
		switch ($selecteur){
			case  VueItem::AFF_ITEM:
				$content = $this->aff_item_entete();
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
        $content .= <<<end
                <form id="form_item" method="POST" action="">
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
}