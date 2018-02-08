<?php
namespace pizza\vues;


class VueItem{
	
	const AFF_ITEM = 1;
	const AFF_NEW_ITEM = 2;
	const AFF_EDIT_ITEM = 3;
	
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
			case  VueItem::AFF_NEW_ITEM:
			    $content = $this->aff_item_nouveau();
			    break;
			case  VueItem::AFF_EDIT_ITEM:
			    $content = $this->aff_item_edit();
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
	
	public function aff_item_nouveau(){
	    $app =  \Slim\Slim::getInstance();
	    $requete = $app->request();
	    $path = $requete->getRootUri();
	    $r_inscr = $app->urlFor("ajoutItem");
	    $content = <<<end
		<form id="form_connexion" class="formulaire" method="POST" action="$r_inscr">
            <div class="row">
                <div class="col s6">
                    <label class="black-text">Nom</label>
                     <div class="input-field">
                        <input type="text" name="nom" required>
                     </div>
                     <br/>
                     <label class="black-text">Description</label>
                     <div class="input-field">
                        <input type="text" name="descr" required>
                     </div>
                     <label class="black-text">Type de l'item (1 pour véhicule, 2 pour atelier)</label>
                     <div class="input-field">
                        <input type="number" name="it" min="1" max="2" required>
                     </div>
                 </div>
             </div>
             <div class="row">
                <button class="btn-floating btn-large waves-effect waves-light red" type="submit" name="Se connecter" value="formCo"><i class="material-icons">add</i></button>
            </div>
        </form>
end;
	    return $content;
	}
}