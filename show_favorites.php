<?php
namespace FilmFavoris;

session_start();

require_once('class/dao/lib/Connection.class.php');
require_once('class/view/lib/Page.class.php');
require_once('class/view/ShowFavorite.class.php');

$showFavorite = new ShowFavorite();
$showFavorite->checkDeleteFavorite();
$showFavorite->showDoc();
