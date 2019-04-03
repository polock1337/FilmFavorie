<?php
require_once("functions.php");

class Formulaire extends Page
{
    public function __construct()
    {
        $retStr = parent::initHTML("Modifier", "style.css");
        $retStr .= parent::insertHeading();
        $retStr .= parent::beginEndBal("p", "Pour ajouter un enregistrement, laisser l'ID vide !");
        $retStr .= parent::beginEndBal("h2", "Formulaire voitures");
        $retStr .= parent::beginForm("POST", 'record.php', "voiture");
        $retStr .= parent::insertInput("number", "id_voiture", "ID Voiture");
        $retStr .= parent::insertInput("number", "id_proprietaire", "ID Proprietaire");
        $retStr .= parent::insertInput("text", "marque", "Marque");
        $retStr .= parent::insertInput("text", "modele", "Modele");
        $retStr .= parent::insertInput("number", "annee", "Année");
        $retStr .= parent::insertInput("text", "vin", "VIN");
        $retStr .= parent::insertHidden("formname", "voitures");
        $retStr .= parent::beginEndBal("button", "Envoyer");
        $retStr .= parent::endBal("form");

        $retStr .= parent::beginForm("POST", 'record.php', "proprietaires");
        $retStr .= parent::insertInput("number", "id_proprietaire", "ID Proprietaire");
        $retStr .= parent::insertInput("text", "nom", "Nom");
        $retStr .= parent::insertInput("text", "adresse", "Adresse");
        $retStr .= parent::insertHidden("formname", "proprietaires");
        $retStr .= parent::beginEndBal("button", "Envoyer");
        $retStr .= parent::endBal("form");
        $retStr .= parent::endBal("body");
        $retStr .= parent::endBal("html");
        echo $retStr;
    }
}

$page = new Formulaire();