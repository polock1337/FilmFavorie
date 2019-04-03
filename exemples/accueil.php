<?php
require_once("functions.php");

class Accueil extends Page
{
    public function __construct()
    {
        $retStr = parent::initHTML("Accueil", "style.css");
        $retStr .= parent::insertHeading();
        $retStr .= parent::beginBal("p");
        $retStr .= parent::createLink("owners.php", "Voir les propriétaires.");
        $retStr .= parent::br();
        $retStr .= parent::createLink("voitures.php", "Voir les voitures.");
        $retStr .= parent::br();
        $retStr .= parent::createLink("form.php", "Modifier les enregistrements.");
        $retStr .= parent::br();
        $retStr .= parent::endBal("p");
        $retStr .= parent::endBal("body");
        $retStr .= parent::endBal("html");
        echo $retStr;
    }
}

$page = new Accueil();