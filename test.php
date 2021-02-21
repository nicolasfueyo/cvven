<?php

function estSamedi($strDate)
{
    $dt = DateTime::createFromFormat('d/m/Y',$strDate );
    $numJour = $dt->format('w');
    return $numJour==6;
}

/**
 * Renvoie TRUE si la date strDateA < strDateB
 * @param $strDateA
 * @param $strDateB
 * @return bool
 */
function dateAnterieure($strDateA, $strDateB){
    $dateA = DateTime::createFromFormat('d/m/Y',$strDateA );
    $dateB = DateTime::createFromFormat('d/m/Y',$strDateB );

    return $dateA->getTimestamp() < $dateB->getTimestamp();

}

echo dateAnterieure('20/02/2021','21/02/2021');