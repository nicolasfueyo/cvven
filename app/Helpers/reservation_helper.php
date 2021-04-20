<?php

use App\Models\TypeLogementModel;

function calculerPrixReservation($typeLogementId, $nbLogements, $dateDebut, $dateFin, $menageInclus, $typeSejour)
{

    # Calcule prix total
    # Prix résa = (nb logements * ppn du tl*nb nuitées) + (ménage*nb logements) + (nb personnes*prix demi-p * nbnuits)
    $typeLogement = (new TypeLogementModel())->find($typeLogementId);
    $nbNuitee = calculeNbJoursEntreDates($dateDebut, $dateFin);
    $prixTotal = $nbLogements * $typeLogement['prix_par_nuitee'] * $nbNuitee;

    if ($menageInclus==true) {// Ménage
        $prixTotal += 25 * $nbLogements;
    }

    if ($typeSejour == 'PENSION COMPLETE') {// +20€ / logement / nuitée
        $prixTotal += $nbLogements * $nbNuitee * 20;
    }

    return $prixTotal;
}

function calculeNbJoursEntreDates($strDateDebut, $strDateFin)
{
    $dtDebut = \DateTime::createFromFormat('Y-m-d', $strDateDebut);
    $dtFin = \DateTime::createFromFormat('Y-m-d', $strDateFin);

    $di = $dtFin->diff($dtDebut);
    $nbJours = $di->format('%a');

    return $nbJours;
}

/**
 * Renvoie true si la date est un samedi, sinon renvoie false.
 * @param $strDate Date au format '20/02/2021'
 * @return bool
 */
function estSamedi($strDate)
{
    $dt = \DateTime::createFromFormat('Y-m-d', $strDate);
    $numJour = $dt->format('w');
    return $numJour == 6;
}

/**
 * Renvoie TRUE si la date strDateA < strDateB
 * @param $strDateA
 * @param $strDateB
 * @return bool
 */
function dateAnterieure($strDateA, $strDateB)
{
    $dateA = \DateTime::createFromFormat('Y-m-d', $strDateA);
    $dateB = \DateTime::createFromFormat('Y-m-d', $strDateB);

    return $dateA->getTimestamp() < $dateB->getTimestamp();
}