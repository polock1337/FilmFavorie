<?php
namespace FilmFavoris;

class ShowMovie extends Page 
{
    private $moviesList = [];
    public function __construct()
    {
        $conn = new Connection();
        $pdo = $conn->getPDO();
        $query = "SELECT * FROM movie";
        $moviesList = $pdo->query($query);
        
        $this->doc = parent::initHTML("Show Movie",''); 
            
        $this->doc .= parent::topNav(); 
        
        $this->createFormatted($moviesList);
        
        $this->doc .= parent::endBal("body");
        $this->doc .= parent::endBal("html");
    }

    public function makeFavorite()
    {
        if(!empty($_REQUEST['movie_id']) && $_REQUEST['favorite'] == "true" && !empty($_SESSION['user_id']))
        {
            $conn = new Connection();
            $pdo = $conn->getPDO();

            $queryCheckFav = "SELECT * FROM favorite_movie WHERE movie_id=".$_REQUEST['movie_id']." AND user_id=".$_SESSION['user_id'];
            $list_fav = $pdo->query($queryCheckFav);
            $row = $list_fav->fetch();

            if($row > 0){
                $this->doc .= "Film deja Favori !";
            }
            else{
                $query = "INSERT INTO favorite_movie (user_id, movie_id)";
                $query .= "VALUES ('" . $_SESSION['user_id'] . "', '" . $_REQUEST['movie_id'] . "');";
                $pdo->query($query);
                $this->doc .= "vous avez favoriter un film!";
            }
        }
    }

    private function createFormatted($stmt)
    {
        $retStr = parent::beginBal('table class = "steelBlueCols"');
        $retStr .=parent::beginBal("tr");

        $retStr .= parent::beginEndBal("td", "ID");
        $retStr .= parent::beginEndBal("td", "Couverture");
        $retStr .= parent::beginEndBal("td", "Name");
        $retStr .= parent::beginEndBal("td", "Producer");
        $retStr .= parent::beginEndBal("td", "Date");
        $retStr .= parent::beginEndBal("td", "Favorite");

        $retStr .= parent::endBal("tr");
        

        foreach ($stmt as $row) {

            $isFav=$this->checkIfFav($row['id']);
            $retStr .= parent::beginBal("tr");
            $lienDetail = 'detail_movie.php?movie_id='.$row['id'].'';
            $retStr .= parent::beginEndBal("td",$row['id']);
            $coverUrl = 'style/img/movie_cover/' . $row['id'] . '_movie_cover.png';
            if(file_exists($coverUrl))
            {
                $src = $coverUrl; 
            } else {
                $src = 'style/img/movie_cover/Default_movie_cover.png';
            }

            $retStr .= parent::beginEndBal("td", '<img src="' . $src . '" alt = "Cover" height="100" width="100">');
            $retStr .= parent::beginEndBal("td", parent::createLink($lienDetail,$row['name']));
            $retStr .= parent::beginEndBal("td", $row['producer']);
            $retStr .= parent::beginEndBal("td", $row['release_date']);
            $lienFavoriter = "show_movies.php?movie_id=" . $row['id'] . "&favorite=true";
            if($isFav){
                $retStr .= parent::beginEndBal("td", "Deja favori !");
            }
            else{
                $retStr .= parent::beginEndBal("td", parent::createLink($lienFavoriter, 'Make Favorite'));
            }
            

            $retStr .= parent::endBal("tr");
        }
        $retStr .= parent::endBal("table");
        $this->doc .= $retStr;
    }

    protected function checkIfFav($movie_id)
    {
        $conn = new Connection();
        $pdo = $conn->getPDO();
        if(isset($_SESSION['user_id']))
        {
            $queryCheckFav = "SELECT * FROM favorite_movie WHERE movie_id=".$movie_id." AND user_id=".$_SESSION['user_id'];
            $list_fav = $pdo->query($queryCheckFav);
            $row = $list_fav->fetch();
            if($row > 0){
                return true;
            }
        }
    }  
}