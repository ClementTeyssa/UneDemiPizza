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
            $res = new Reservation();
            $res->idItem = $itemid;
            $res->dateDeb = $date;
            $res->dateFin = $date;
            $tab = unserialize($_COOKIE['profile']);
            $email = $tab[0];
            $res->emailUser = $email;
            $res->save();
            $app->redirect("catalogue");
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
	
	public function edition(){
	    $app = \Slim\Slim::getInstance();
	    $requete = $app->request();
	    $id = $requete->post('idItem');
	    if($id == "") {
	        $vue = new VueItem();
	        print $vue->render(VueItem::AFF_NEW_ITEM);
	    } else {
	        $vue = new VueItem($item);
	        print $vue->render(VueItem::AFF_EDIT_ITEM, $item);
	    }
	}
	
	public function ajouter_item($nom, $desc, $id_categ){
	    $app = \Slim\Slim::getInstance();
		$i = new Item();
		$i->description = $desc;
		$i->nom = $nom;
		$i->id_categ = $id_categ;
		$i->save();
		$app->redirect($app->urlFor("catalogue"));
	}
	
	public function supprimer_item(){
	    $app = \Slim\Slim::getInstance();
	    $requete = $app->request();
	    $id = $requete->post('idItem');
		$item = Item::select()->where('id', '=', $id)->first();
		$item->delete();
		$app->redirect($app->urlFor('catalogue'));
	}


}
