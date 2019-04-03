<?php
namespace FilmFavoris;

session_start();

require_once('class/dao/lib/Connection.class.php');
require_once('class/view/lib/Page.class.php');
require_once('class/view/Login.class.php');

$login = new Login();
$login->showDoc();

