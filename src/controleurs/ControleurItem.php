<?php
namespace pizza\controleurs;

use pizza\models\Item;
use pizza\vues\VueItem;

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
		$id = $requete->post('idItem');
		$item = Item::getById($id);
		$vue = new VueItem($item);
		print $vue->render(VueItem::AFF_ITEM, $item);
	}
	
	public function ajouter_item($nom, $desc, $id_categ){
		$i = new Item();
		$i->description = $desc;
		$i->nom = $nom;
		$i->id_categ = $id_categ;
		$i->save();
	}
	
	public function supprimer_item($id){
		$item = Item::select()->where('id', '=', $id)->first();
		$item->delete();
	}

	public function aff_item_res(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $itemid =  $requete->post('idItem');
        $item = Item::getById($itemid);
        $date = $requete->post('the_date');
        echo $date;
    }
}
