<?php
/**
 * Created by PhpStorm.
 * User: Clement
 * Date: 08/02/2018
 * Time: 14:40
 */

namespace pizza\controleurs;


class Date
{
    public function getAll($year){
        $r = array();
        $date = new \DateTime($year.'-01-01');
        while ($date->format('Y') <= $year){
            $y = $date->format('Y');
            $m = $date->format('n');
            $d = $date->format('j');
            $w = str_replace('0', '7', $date->format('w'));
            $r[$y][$m][$d] = $w;
            $date->add(new \DateInterval('P1D'));
        }
        return $r;
    }
}