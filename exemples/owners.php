<?php
require_once("functions.php");

class Proprietaires extends Page
{
    public function __construct()
    {
        $retStr = parent::initHTML("Proprietaires", "style.css");
        $retStr .= parent::insertHeading();
        $retStr .= parent::beginBal("table");
        $retStr .= Proprietaires::connectAndFetch();
        $retStr .= parent::endBal("table");
        $retStr .= parent::endBal("body");
        $retStr .= parent::endBal("html");
        echo $retStr;
    }

    public function connectAndFetch()
    {
        $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;",
                          "192.168.56.10",
                          '5432',
                          'testdb');
        $user = 'master';
        $pass = '123qweQWE';

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($conStr, $user, $pass, $options);
            $stmt = $pdo->query('SELECT * FROM proprietairesvoitures');

            return Proprietaires::displayFormatted($stmt);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function displayFormatted($stmt)
    {
        $retStr = parent::beginBal("tr");

        $retStr .= parent::beginEndBal("td", "ID");
        $retStr .= parent::beginEndBal("td", "Nom");
        $retStr .= parent::beginEndBal("td", "Adresse");
        $retStr .= parent::beginEndBal("td", "Supprimer");

        $retStr .= parent::endBal("tr");

        foreach ($stmt as $row) {
            $retStr .= parent::beginBal("tr");

            $retStr .= parent::beginEndBal("td", $row['id']);
            $retStr .= parent::beginEndBal("td", $row['nom']);
            $retStr .= parent::beginEndBal("td", $row['adresse']);
            $lienSupprimer = "delete.php?proprietaire_id=" . $row['id'];
            $retStr .= parent::beginEndBal("td", parent::createLink($lienSupprimer, 'Supprimer'));

            $retStr .= parent::endBal("tr");
        }
        return $retStr;
    }
}

$page = new Proprietaires();
