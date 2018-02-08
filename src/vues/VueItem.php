<?php
namespace pizza\vues;

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
			case  VueCatalogue::AFF_ITEM:
				$content = $this->aff_item();
		}
		return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
	}
	
	
	public function aff_item_entete(){
		$nom = $this->objet->nom;
		$id = $this->objet->id;
		$desc = $this->objet->description;
		
		$content = <<<end
		<h1>Item $nom </h1>
		<br>
		<p>Id : $id.</p>
		<br>
		<p>$desc</p>
		<br>
		
end;
	}
}