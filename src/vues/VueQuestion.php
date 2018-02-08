<?php
/**
 * Created by PhpStorm.
 * User: Clément Teyssandier
 * Date: 24/01/2018
 * Time: 09:56
 */

namespace amphux\vues;


class VueQuestion
{
	const AFF_QUESTION_QCM = 0;
	const AFF_QUESTION_VF = 1;
	const AFF_QUESTION_COURT = 2;

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
        	case VueQuestion::AFF_QUESTION_QCM:
        		$content = $this->affQuestionQCM();
        		break;
        	case VueQuestion::AFF_QUESTION_VF:
        		$content = $this->affQuestionVF();
        		break;
        	case VueQuestion:AFF_QUESTION_COURT:
        		$content = $this->affQuestionCourt();
        		break;
        }
        return VuePageHTML::getHeaders().$content.VuePageHTML::getFooter();
    }
    
    public function affQuestionQCM(){
    	$affichage = <<<end
		<h1>Menu de création de questions</h1>
		<textarea id="wysibb" rows="10" cols="50"></textarea>
end;
		return $affichage;
    }

}