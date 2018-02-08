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
			case  VueItem::AFF_ITEM:
				$content = $this->aff_item_entete();
		}
		return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
	}
	
	
	public function aff_item_entete(){
		
		$nom = $this->objet->nom;
		$id = $this->objet->id;
		$desc = $this->objet->description;
        $mois = date('m');
        $annee = date('Y');

        $content = <<<end
		<h1>Item $nom </h1>
		<div class="row">
		    <div class="col s6">
                <p>Id : $id.</p>
                <br>
                <p>$desc</p>
            </div>
            <div class="col s1">
                <i class="material-icons" id="prev">arrow_back</i>
            </div>
            <div class="col s4">
end;
	     $content .=
             "<script>
             $(function($){
	                    var mois = $mois;
	                    var annee = $annee;
	                    $(document).ready(function(){
	                        $(\"#content\").load(\"calendrier.php?mois=\"+mois+\"&annee=\"+annee+\"\");
	                    });
	                    $(\"#prev\").click(function(){
	                        mois--;
                            if (mois < 1) {
                                annee--;
                                mois = 12;
                            }
                            $(\"#content\").load(\"calendrier.php?mois=\"+mois+\"&annee=\"+annee+\"\");
                        });
	                    $(\"#next\").click(function(){
                            mois++;
                            if (mois > 12) {
                                annee++;
                                mois = 1;
                            }
		                    $(\"#content\").load(\"calendrier.php?mois=\"+mois+\"&annee=\"+annee+\"\"); 
	                    });

                });";
	     $content .= "
	            </script>
            </div>
            <div class='col s1'>
                <i class='material-icons' id='prev'>arrow_forward</i>
            </div>
		</div>";
		return $content;
	}
}