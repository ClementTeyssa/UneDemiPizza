<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 08/02/2018
 * Time: 15:35
 */

function calendrier($m, $a){
    $nbJ = cal_days_in_month(CAL_GREGORIAN, $m, $a);
    $content = <<<end
    <table>
        <tr>
            <th>Lun</th>
            <th>Mar</th>
            <th>Mer</th>
            <th>Jeu</th>
            <th>Ven</th>
            <th>Sam</th>
            <th>Dim</th>
        </tr>
end;
    for ($i = 1; $i <= $nbJ; $i++){
        $j = cal_to_jd(CAL_GREGORIAN, $m, $i, $a);
        $jSem = jddayofweek($j);
        if($i == $nbJ){
            if($jSem == 1){
                $content .= "<tr>";
            }
            $content .= "<td class='case'>".$i."</td></tr>";
        } elseif ($i == 1){
            $content .= "<tr>";
            if($jSem == 0){
                $jSem = 7;
            }
            for ($k = 1; $k != $jSem; $k++){
                $content .= "<td></td>";
            }
            $content .= "<td class='case'>".$i."</td>";
            if($jSem == 7){
                $content .= "</tr>";
            }
        } else {
            if($jSem == 1){
                $content .= "<tr>";
            }
            $content .= "<td class='case'>".$i."</td>";
            if($jSem == 0){
                $content .= "</tr>";
            }

        }
    }
    $content .= "<table>";
    return $content;
}