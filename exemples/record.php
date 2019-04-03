<?php
require_once("functions.php");
if ($_REQUEST['formname'] == "voitures") {
    if (empty($_REQUEST['id_voiture'])) {
        // Insertion de nouveau record
        if (!empty($_REQUEST['id_proprietaire']) &&
           !empty($_REQUEST['vin']) &&
           !empty($_REQUEST['marque']) &&
           !empty($_REQUEST['modele']) &&
           !empty($_REQUEST['annee'])) {
            $pdo = ConnectReturnPDO();
            if (!empty($pdo)) {
                $query = 'INSERT INTO voituresexotiques (proprietaire_id, vin, marque, modele, annee)';
                $query .= "VALUES (" . $_REQUEST['id_proprietaire'] . ", '";
                $query .= $_REQUEST['vin'] . "', '" . $_REQUEST['marque'] . "', '";
                $query .= $_REQUEST['modele'] . "', " . $_REQUEST['annee'] . "); ";
                echo $query;
                $stmt = $pdo->query($query);
            }
        }
    } else {
        // Modification de ligne
        if (!empty($_REQUEST['id_voiture']) &&
           !empty($_REQUEST['id_proprietaire']) &&
           !empty($_REQUEST['vin']) &&
           !empty($_REQUEST['marque']) &&
           !empty($_REQUEST['modele']) &&
           !empty($_REQUEST['annee'])) {
            $pdo = ConnectReturnPDO();
            if (!empty($pdo)) {
                $query = "UPDATE voituresexotiques\n";
                $query .= "SET proprietaire_id = " . $_REQUEST['id_proprietaire'] . ", ";
                $query .= "vin ='" . $_REQUEST['vin'] . "',";
                $query .= "marque ='" . $_REQUEST['marque'] . "',";
                $query .= "modele ='" . $_REQUEST['modele'] . "',";
                $query .= "annee =" . $_REQUEST['annee'] . "\n";
                $query .= "WHERE voiture_id = " . $_REQUEST['id_voiture'];
                echo $query;
                $stmt = $pdo->query($query);
            }
        }
    }
}
if ($_REQUEST['formname'] == "proprietaires") {
    if (!empty($_REQUEST['nom']) &&
       !empty($_REQUEST['adresse'])) {
        if (empty($_REQUEST['id_proprietaire'])) {
            $pdo = ConnectReturnPDO();
            if (!empty($pdo)) {
                $query = 'INSERT INTO proprietairesvoitures (nom, adresse)';
                $query .= "VALUES ('" . $_REQUEST['nom'] . "', '";
                $query .= $_REQUEST['adresse'] . "');";
                echo $query;
                $stmt = $pdo->query($query);
            }
        } else {
            $pdo = ConnectReturnPDO();
            if (!empty($pdo)) {
                $query = "UPDATE proprietairesvoitures\n";
                $query .= "SET nom ='" . $_REQUEST['nom'] . "',";
                $query .= "adresse ='" . $_REQUEST['adresse'] . "\n";
                $query .= "WHERE id = " . $_REQUEST['id_proprietaire'];
                echo $query;
                $stmt = $pdo->query($query);
            }
        }
    }
}