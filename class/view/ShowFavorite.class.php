<?php
namespace FilmFavoris;

class ShowFavorite extends Page {
    private $favoriteList = [];
    public function __construct(){
        $this->doc = parent::initHTML("Show Favorite",'');

        $this->doc .= parent::topNav(); 

        if(empty($_SESSION['user_id'])){
            $this->doc .= parent::beginEndBal("p", "Il faut etre connecté pour voir les favoris.");
            $this->doc .= parent::endBal("body");
            $this->doc .= parent::endBal("html");
            return;
        }

        $conn = new Connection();
        $pdo = $conn->getPDO();
        $query = "SELECT * FROM favorite_movie ";
        $query .= "INNER JOIN movie ON favorite_movie.movie_id=movie.id ";
        $query .= "WHERE user_id = " . $_SESSION['user_id'];
        $favoriteList = $pdo->query($query);
        $this->createFormatted($favoriteList);
        
        $this->doc .= parent::endBal("body");
        $this->doc .= parent::endBal("html");
    }

    private function createFormatted($stmt)
    {
        $retStr = parent::beginBal('table class ="steelBlueCols"');
        $retStr .=parent::beginBal("tr");

        $retStr .= parent::beginEndBal("td", "ID User");
        $retStr .= parent::beginEndBal("td", "ID Movie");
        $retStr .= parent::beginEndBal("td", "Couverture");
        $retStr .= parent::beginEndBal("td", "Name");
        $retStr .= parent::beginEndBal("td", "Producer");
        $retStr .= parent::beginEndBal("td", "Date");
        $retStr .= parent::beginEndBal("td", "");
        
        

        $retStr .= parent::endBal("tr");

        foreach ($stmt as $row) {

            $lienDeleteFav = 'show_favorites.php?movie_id='.$row['id'].'&del_fav=true';
            $lienDetail = 'detail_movie.php?movie_id='.$row['id'].'';

            $retStr .= parent::beginBal("tr");
            $retStr .= parent::beginEndBal("td", $row['user_id']);
            $retStr .= parent::beginEndBal("td", $row['movie_id']);
            $coverUrl = 'style/img/movie_cover/' . $row['id'] . '_movie_cover.png';
            if(file_exists($coverUrl))
            {
                $src = $coverUrl; 
            } else {
                $src = 'style/img/movie_cover/Default_movie_cover.png';
            }

            $retStr .= parent::beginEndBal("td", '<img  src="' . $src . '" alt = "Cover" height="100" width="100">');
            $retStr .= parent::beginEndBal("td", parent::createLink($lienDetail,$row['name']));
            $retStr .= parent::beginEndBal("td", $row['producer']);
            $retStr .= parent::beginEndBal("td", $row['release_date']);
            $retStr .= parent::beginEndBal("td", parent::createLink($lienDeleteFav, 'Delete Favorite'));
            $retStr .= parent::endBal("tr");
        }
        $retStr .= parent::endBal("table");
        $this->doc .= $retStr;
    }

    public function checkDeleteFavorite()
    {
        if (!empty($_REQUEST['movie_id']) && $_REQUEST['del_fav'] == "true" && !empty($_SESSION['user_id']))
        {   
            $conn = new Connection();
            $pdo = $conn->getPDO();
            $query = "DELETE FROM favorite_movie WHERE user_id=";
            $query .= $_SESSION['user_id']." AND movie_id=".$_REQUEST['movie_id'];
            $pdo->query($query);
            $this->doc .= "Favorite deleted ! Refreshing in 3 sec...";
            header("Refresh:3");

        }
    }
}