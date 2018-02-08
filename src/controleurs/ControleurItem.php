<?php
namespace pizza\controleurs;

class ControleurItem{
	
	/*
	 * ==============================================================
	 *                          Affichage
	 * ==============================================================
	 */
	
	public function aff_item(){
		// TODO: vérifier si la personne est connectée
		$app = \Slim\Slim::getInstance();
		$requete = $app->request();
		$id = $requete->post('');
		$item = Item::where('id','=',$id)->get();
		$vue = new VueItem($item);
		print $vue->render(VueItem::AFF_ITEM, $item);
	}
}
