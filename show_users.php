<?php
namespace FilmFavoris;

session_start();

require_once('class/dao/lib/Connection.class.php');
require_once('class/view/lib/Page.class.php');
require_once('class/view/ShowUser.class.php');



$showUser = new ShowUser();
$showUser->showDoc();