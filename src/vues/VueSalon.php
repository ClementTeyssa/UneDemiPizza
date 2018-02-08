<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 24/01/2018
 * Time: 09:56
 */

namespace amphux\vues;


use amphux\models\Salon;
use Slim\Slim;

class VueSalon
{
    const AFF_SALONS = 1;
    const AFF_SALON_ENS = 2;
    const AFF_SALON_ETU = 3;

    private $objet;

    public function __construct($array = null)
    {
        $this->objet = $array;
    }

    public function render($selecteur, $tab = null)
    {
        $content=null;
        if(isset($tab)){
            $this->objet = $tab;
        }
        switch ($selecteur) {
            case VueSalon::AFF_SALONS :
                $content = $this->salons();
                break;
            case VueSalon::AFF_SALON_ENS :
                $content = $this->aff_salon_ens();
                break;
            case VueSalon::AFF_SALON_ETU :
                $content = $this->aff_salon_etu();
                break;
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }

    /*
     * Affichage de la liste des salons
     */
    private function salons(){
        $salonsE = $this->objet[0];
        $salonsT = $this->objet[1];
        $nbE = $this->objet[2];
        $nbT = $this->objet[3];
        $app = \Slim\Slim::getInstance();
        $content = <<<end
        <h1>Affichage de vos salons</h1>    
end;
        if(isset($nbE)){
            $content .= <<<end
        <br>
        <h3>Vos salons en cours</h3>
        <br>
        <table>
  		    <tr>
			 <th>Nom</th>
   			 <th>Token</th>
    		 <th>Date de création</th>
    		 <th>Status</th>
   			 <th></th>
   			 <th></th>
  		</tr>
end;
            foreach ($salonsE as $salon){
                $nom = $salon->nom;
                $token = $salon->token;
                $date = $salon->date;
                $acceder = $app->urlFor('affsalon_ens');
                $terminer = $app->urlFor('arretSalon');
                $salonid = $salon->idSalon;
                if($salon->ouvert == 2){
                    $status = "En attente";
                } else {
                    $status = "En cours";
                }
                $content .= <<<end
                <tr>
                    <td>$nom</td>
                    <td>$token</td>
                    <td>$date</td>
                    <td>$status</td>
                    <td><form method="post" action="$acceder"><button type="submit" class="bouton">Accéder</button><input type="hidden" name="salon" value="$salonid"></form></td>
                    <td><form method="post" action="$terminer"><button type="submit" class="bouton">Terminer</button><input type="hidden" name="salon" value="$salonid"></form></td>
                </tr>
end;
            }
            $content .= "</table>";
        } else {
            $content .= <<<end
            <br>
            <p>Vous n'avez pas de salons en cours</p>
end;
        }
        
        if(isset($nbT)){
            $content .= <<<end
            <br>
            <h3>Vos salons terminés</h3>
            <br>
            <table>
                <tr>
                 <th>Nom</th>
                 <th>Token</th>
                 <th>Date de création</th>
                 <th>Status</th>
                 <th></th>
                 <th></th>
            </tr>
end;
            foreach ($salonsT as $salon) {
                $nom = $salon->nom;
                $token = $salon->token;
                $date = $salon->date;
                $salonid = $salon->idSalon;
                $acceder = $app->urlFor('affsalon_ens');
                $supprimer = $app->urlFor('suppressionSalon');
                $content .= <<<end
                    <tr>
                        <td>$nom</td>
                        <td>$token</td>
                        <td>$date</td>
                        <td>Terminé</td>
                        <td><form method="post" action="$acceder"><button type="submit" class="bouton">Accéder</button><input type="hidden" name="salon" value="$salonid"></form></td>
                        <td><form method="post" action="$supprimer"><button type="submit" class="bouton">Supprimer</button><input type="hidden" name="salon" value="$salonid"></form></td>
                    </tr>
end;
            }
            $content .= "</table>";
        } else {
            $content .= <<<end
            <br>
            <p>Vous n'avez pas de salons terminés</p>
end;
        }
        $r_quiz = $app->urlFor('quizEnseignant');
        $content .= <<<end
		
		<br>
		<a class="bouton" href="$r_quiz">Choisir un quiz</a>
end;
        /*
         * bouton non lié
         */
        return $content;
    }

    /*
     * Affihage d'un salon vue par un enseignant
     */
    private function aff_salon_ens(){
        $salon = $this->objet[0];
        switch ($salon->ouvert){
            case 0 : // terminé
                return $this->aff_salon_ens_TE();
                break;
            case 1 : // en cours
                return $this->aff_salon_ens_EC();
                break;
            case 2 : // en attente
                return $this->aff_salon_ens_AT();
                break;
        }
        return "";
    }

    /*
     * Affichage d'un salon en cours vue par un enseignant
     */
    private function aff_salon_ens_EC()
    {
        $app = \Slim\Slim::getInstance();
        $salon = $this->objet[0];
        $salonid = $salon->idSalon;
        $s_nom = $salon->nom;
        $s_token = $salon->token;
        $eleves = $this->objet[1];
        $r_supprimer = $app->urlFor('suppressionSalon');
        $r_terminer = $app->urlFor('arretSalon');
        $content = <<<end
        <h1>Tableau de bord du salon : $s_nom</h1>
        <br>
        <p>Vous pouvez partager ce code pour que les personnes rejoignent votre salle <span class="token">$s_token</span></p>
        <br>
        <div id="boutonTB">
            <form method="post" action="$r_terminer"><button type="submit" class="bouton">Terminer</button><input type="hidden" name="salon" value="$salonid"></form>
            <form method="post" action="$r_supprimer"><button type="submit" class="bouton">Supprimer</button><input type="hidden" name="salon" value="$salonid"></form>
        </div>
        <br>
        <br>
end;
        /*
         *===============================================================================================================================
         *
         * Modifier quand les questions seront faites
         *
         *
         */
        if(count($eleves) > 0){ // il y a des élèves qui participent
            $content .= <<<end
            <table>
                <tr>
                 <th>Nom de l'élève</th>
                 <th>Question 1</th>
                 <th>Question 2</th>
                 <th>Question 3</th>
                 <th>Question 4</th>
                </tr>
end;
            foreach ($eleves as $eleve){
                $e_nom = $eleve->nom;
                $content .= <<<end
                <tr>
                    <td>$e_nom</td>
                    <td class="repJuste"></td>
                    <td class="repFausse"></td>
                    <td class="repPas"></td>
                    <td class="repPas"></td>
                </tr>
end;
            }
            $content .= <<<end
            </table>
end;
        } else {                // il n'y a pas d'élèves
            $content .= "<p>Aucun élève n'est dans le salon.</p>";
        }
        $content .= <<<end
        
end;
        return $content;
    }

    /*
     * Affichage d'un salon en attente vue par un enseignant
     */
    private function aff_salon_ens_AT()
    {
        $app = \Slim\Slim::getInstance();
        $salon = $this->objet[0];
        $salonid = $salon->idSalon;
        $s_nom = $salon->nom;
        $s_token = $salon->token;
        $eleves = $this->objet[1];
        $r_supprimer = $app->urlFor('suppressionSalon');
        $r_lancer = $app->urlFor('lancementSalon');
        $content =  <<<end
        <h1>Tableau de bord du salon : $s_nom</h1>
        <br>
        <p>Vous pouvez partager ce code pour que les personnes rejoignent votre salle <span class="token">$s_token</span></p>
        <br>
        <div id="boutonTB">
            <form method="post" action="$r_lancer"><button type="submit" class="bouton">Lancer</button><input type="hidden" name="salon" value="$salonid"></form>
            <form method="post" action="$r_supprimer"><button type="submit" class="bouton">Supprimer</button><input type="hidden" name="salon" value="$salonid"></form>
        </div>
        <br>
        <br>
end;
        if(count($eleves) > 0){
            $content .= <<<end
            <table>
                <tr>
                 <th>Nom de l'élève</th>
                 <th>Heure d'arrivée</th>
                </tr>
end;
            foreach ($eleves as $eleve){
                $e_nom = $eleve->nom;
                $content .= <<<end
                <tr>
                    <td>$e_nom</td>
                    <td>L'heure d'arrivée</td>
                </tr>
end;
            }
            $content .= <<<end
            </table>
end;
        } else {
            $content .= "<p>Aucun élève n'est dans le salon.</p>";
        }

        return $content;
    }

    /*
     * Affichage d'un salon terminé par un enseignant
     */
    private function aff_salon_ens_TE()
    {
        $app = \Slim\Slim::getInstance();
        $salon = $this->objet[0];
        $salonid = $salon->idSalon;
        $s_nom = $salon->nom;
        $eleves = $this->objet[1];
        $r_supprimer = $app->urlFor('suppressionSalon');
        $content =  <<<end
        <h1>Tableau de bord du salon : $s_nom</h1>
        <br>
        <div id="boutonTB">
            <form method="post" action="$r_supprimer"><button type="submit" class="bouton">Supprimer</button><input type="hidden" name="salon" value="$salonid"></form>
            <form method="post" action=""><button type="submit" class="bouton">Récuperer les résultats</button><input type="hidden" name="salon" value="$salonid"></form>
        </div>
        <br>
        <br>        
end;
        /*
         *===============================================================================================================================
         *
         * Modifier quand les questions seront faites + modifier lien résultats
         *
         *
         */
        if(count($eleves) > 0){ // il y a des élèves qui participent
            $content .= <<<end
            <table>
                <tr>
                 <th>Nom de l'élève</th>
                 <th>Question 1</th>
                 <th>Question 2</th>
                 <th>Question 3</th>
                 <th>Question 4</th>
                </tr>
end;

            foreach ($eleves as $eleve){
                $e_nom = $eleve->nom;
                $content .= <<<end
                <tr>
                    <td>$e_nom</td>
                    <td class="repJuste"></td>
                    <td class="repFausse"></td>
                    <td class="repPas"></td>
                    <td class="repPas"></td>
                </tr>
end;
            }
            $content .= <<<end
            </table>
end;
        } else {                // il n'y a pas d'élèves
            $content .= "<p>Aucun élève n'est dans le salon.</p>";
        }

        $content .= <<<end
        
end;
        return $content;
    }


    /*
     * A modifier
     */
    private function aff_salon_etu(){
        $salon = $this->objet[0];
        switch ($salon->ouvert){
            case 0 : // terminé
                $app = \Slim\Slim::getInstance();
                $app->redirect($app->urlFor('connexionEtudiant'));
                break;
            case 1 : // en cours
                return $this->aff_salon_etu_EC();
                break;
            case 2 : // en attente
                return $this->aff_salon_etu_AT();
                break;
        }
        return "";
    }

    /*
     * Affichage d'un salon en attente par un élève
     */
    private function aff_salon_etu_AT(){
        $salon = $this->objet[0];
        $s_nom = $salon->nom;
        $eleves = $this->objet[1];

        $content = <<<end
        <h1>Tableau de bord du salon : $s_nom</h1>
        <br>
end;
        if(count($eleves) > 0){
            $content .= <<<end
            <table>
                <tr>
                 <th>Nom de l'élève</th>
                 <th>Heure d'arrivée</th>
                </tr>
end;
            foreach ($eleves as $eleve){
                $e_nom = $eleve->nom;
                $content .= <<<end
                <tr>
                    <td>$e_nom</td>
                    <td>L'heure d'arrivée</td>
                </tr>
end;
            }
            $content .= <<<end
            </table>
end;
        } else {
            $content .= "<p>Aucun élève n'est dans le salon.</p>";
        }
        return $content;
    }

    private function aff_salon_etu_EC(){
        return "doit etre redirigé ver le quiz";
    }
}