<?php
namespace FilmFavoris;

session_start();

require_once('class/view/lib/Page.class.php');
require_once('class/view/Index.class.php');

$index = new Index();
$index->showDoc();
