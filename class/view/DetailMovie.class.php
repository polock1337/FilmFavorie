<?php
namespace FilmFavoris;
    
    class DetailMovie extends Page
    {
        
        public function __construct()
        {

            $this->doc = parent::initHTML("Detail Movie",'');

            $this->doc .= parent::topNav(); 

            $this->connectVerif();
  
            $this->doc .= parent::endBal("body");
            $this->doc .= parent::endBal("html");
                      
        }
        public function connectVerif()
        {
            if(isset($_SESSION['user_id']))
            {
                $this->coverDetailImage(); 
                $this->coverDetailInfo();
            }
            else
            {
                $this->doc .= '<h1>Veuillez vous connecter pour accéder aux détails des films!</h1>';
            }
            
            
        }
        public function coverDetailImage()
        {
            
            $coverUrl = 'style/img/movie_cover/';
            if(!empty($_REQUEST['movie_id']))
            {
                $coverUrl .= $_REQUEST['movie_id'];
            }
            else
            {
                $coverUrl.='';
            }
            $coverUrl.='_movie_cover.png';
            
            if(file_exists($coverUrl))
            {

                $src = $coverUrl;
                $src .= '"  alt = "Cover" style="max-height:500px;
                max-width:500px;
                height:auto;
                width:auto;"';
            
            }
            else
            {
                $src ='style/img/movie_cover/Default_movie_cover.png" alt="Cover" width="475" height="360"';

            }
            
            $this->doc .= '<h1>Movie Detail</h1>';
            $this->doc .= '<img src="'.$src.' >';
            

        }
        public function coverDetailInfo()
        {
            
            $conn = new Connection();
            $pdo = $conn->getPDO();

            $stmt = $pdo->query("SELECT * FROM movie WHERE id=".$_REQUEST['movie_id']);
            $row = $stmt->fetch();

            $this->doc .= '<h1>'.$row['name'].'</h1>';
            $this->doc .= '<h1>'.$row['producer'].'</h1>';
            $this->doc .= '<h1>'.$row['release_date'].'</h1>';

            $query = "SELECT (username) FROM favorite_movie ";
            $query .= "INNER JOIN movie_user ";
            $query .= "ON favorite_movie.user_id = movie_user.id ";
            $query .= "WHERE movie_id = " . $_REQUEST['movie_id'];
            $stmt = $pdo->query($query);
            //TODO: NOT DO THIS - use naked request var

            $this->doc .= "<p>Utilisateurs dont ce film est favori</p>";
            $this->doc .= "<ul>";
            foreach($stmt as $row){
                $this->doc .= "<li>".$row['username']."</li>";
            }
            $this->doc .= "</ul>";
        }
    
    }

?>