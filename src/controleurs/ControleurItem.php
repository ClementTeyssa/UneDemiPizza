<?php
namespace pizza\controleurs;

class ControleurItem{
	
	/*
	 * ==============================================================
	 *                          Affichage
	 * ==============================================================
	 */
	
	public function aff_item($id){
		// TODO: vérifier si la personne est connectée
		$item = Item::where('id','=',$id)->get();
		$vue = new VueItem($item);
		print $vue->render(VueItem::AFF_ITEM, $item);
	}
}
