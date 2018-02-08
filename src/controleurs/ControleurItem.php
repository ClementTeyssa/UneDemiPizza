<?php
namespace pizza\controleurs;

use pizza\models\Item;
use pizza\vues\VueItem;
use pizza\models\Reservation;
use Slim\Slim;

class ControleurItem{

    /*
     * ==============================================================
     *                          Traitement
     * ==============================================================
     */
    public function aff_item_resT(){
        $app = \Slim\Slim::getInstance();
        $requete = $app->request();
        $itemid =  $requete->post('idItem');
        $item = Item::getById($itemid);
        $date = $requete->post('the_date');
        $date = date( "Y-m-d", strtotime($date) );
        $nbD = Reservation::where('dateDeb')->count()+Reservation::where('dateFin')->count();
        if($nbD != 0 ){
            $_SESSION['message'] = "Il y a déjà une réservation à cette date";
            $app->redirect("catalogue");
        } else {
            $this->aff_res_item($item);
        }
    }
	
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


	public function aff_res_item($item){
        $vue = new VueItem();
        print $vue->render(VueItem::AFF_RES);
    }

}
