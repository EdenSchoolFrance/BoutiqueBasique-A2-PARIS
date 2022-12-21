<?php


function calculerAge($naissance)
{
    $aujourdhui = date("Y-m-d");
    $diff = date_diff(date_create($naissance), date_create($aujourdhui));
    return $diff->format('%y');
}

function trouverSigneZodiaque($dateNaissance)
{
    //ON EXTRAIT LE JOUR ET LE MOIS DE LA DATE DE NAISSANCE
    $jour = substr($dateNaissance, 0, 2);
    $mois = substr($dateNaissance, 3, 2);

    if ((($jour >= 21) && ($mois == 03)) || (($jour <= 20) && ($mois == 04))) {
        $signe = "belier.jpg";
    }
    if ((($jour >= 21) && ($mois == 04)) || (($jour <= 21) && ($mois == 05))) {
        $signe = "taureau.jpg";
    }
    if ((($jour >= 22) && ($mois == 05)) || (($jour <= 21) && ($mois == 06))) {
        $signe = "gemeaux.jpg";
    }
    if ((($jour >= 22) && ($mois == 06)) || (($jour <= 22) && ($mois == 07))) {
        $signe = "cancer.jpg";
    }
    if ((($jour >= 23) && ($mois == 07)) || (($jour <= 22) && ($mois == 8))) {
        $signe = "lion.jpg";
    }
    if ((($jour >= 23) && ($mois == 8)) || (($jour <= 22) && ($mois == 9))) {
        $signe = "vierge.jpg";
    }
    if ((($jour >= 23) && ($mois == 9)) || (($jour <= 22) && ($mois == 10))) {
        $signe = "balance.jpg";
    }
    if ((($jour >= 23) && ($mois == 10)) || (($jour <= 22) && ($mois == 11))) {
        $signe = "scorpion.jpg";
    }
    if ((($jour >= 23) && ($mois == 11)) || (($jour <= 21) && ($mois == 12))) {
        $signe = "sagittaire.jpg";
    }
    if ((($jour >= 20) && ($mois == 02)) || (($jour <= 20) && ($mois == 03))) {
        $signe = "poissons.jpg";
    }
    if ((($jour >= 21) && ($mois == 01)) || (($jour <= 19) && ($mois == 02))) {
        $signe = "verseau.jpg";
    }
    if ((($jour >= 22) && ($mois == 12)) || (($jour <= 20) && ($mois == 01))) {
        $signe = "capricorne.jpg";
    }
    return $signe;
}

function dateEnClair($date) : string
{
    setlocale(LC_TIME, 'french');
    $jour = strftime('%d', strtotime($date));
    $mois = strftime('%B', strtotime($date));
    $mois = substr($mois, 0, 4);
    $annee = strftime('%Y', strtotime($date));

    return $jour."/".$mois."/".$annee;
}