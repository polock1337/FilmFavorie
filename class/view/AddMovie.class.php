<?php
namespace FilmFavoris;

class Addmovie extends Page 
{
    
    protected $name;
    protected $producer;
    protected $date;
    
    public function __construct()
    {
        $this->verifAddMovie();
        $this->doc = parent::initHTML("Add Movie",'');
        $this->doc .= parent::topNav(); 
        
        $this->doc .= $this->formAddMovie();
        
        $this->doc .= parent::endBal("body");
        $this->doc .= parent::endBal("html");
        
    }
    protected function formAddMovie()
    {
        $form ='<form class="add_movie" action="add_movie.php" method="POST" enctype="multipart/form-data">
            <label>cover :</label><br><br>
            <input type="file" name="cover" id="cover"><br><br>
            <label>name :</label><br>
            <input type="text" name="name" placeholder="name"><br>
            <label>producer :</label><br>
            <input type="text" name="producer" placeholder="producer"><br>
            <label>release date :</label><br>
            <input type="text" name="date" placeholder="date"><br><br>
            <button type="submit" name="submit">Sign Movie</button>
            <input name = "add_movie" type="hidden" value="add_movie">
            </form>';
        return $form;
        
        
        
    }
   
    protected function checkAddMovieCover()
    {
        if (isset($_POST['add_movie']))
        {   
            $type = $_FILES['cover']['type'];
            $size = $_FILES['cover']['size']; 
            if($type != 'image/png' && $type != 'image/jpeg')
            {
                header("location: add_movie.php?Cover=WrongType$type");
                exit(); 
            }
            else
            {
                if($size > 1000000)
                {
                    header("location: add_movie.php?Cover=SizeTooBig");
                    $this->doc .= '<a>photo trop grosse</a>';
                    exit();  
                }
                else
                {
                    return true;
                }
            }
            if ($movefile)
            {
              header("location: add_movie.php?upload=Sucess");
            }
        }
    }
    protected function setInfoMovie()
    {
        $namepg = pg_escape_string($_REQUEST['name']);
        $producerpg = pg_escape_string($_REQUEST['producer']);
        $datepg = pg_escape_string($_REQUEST['date']);
        


        $this->name = htmlspecialchars($namepg);
        $this->producer = htmlspecialchars($producerpg);
        $this->date = htmlspecialchars($datepg);  


    }
    protected function checkAddMovieInfo()
    {
        if (isset($_POST['add_movie']))
        {   
            $this->setInfoMovie();
            if(empty($this->name) || empty($this->producer) || empty($this->date))
            {  
                header("location:Add_movie.php?Addmovie=empty");
                exit(); 
            }
            else
            {
                return true;
            }
        }
              
    }
    protected function verifAddMovie()
    {
        $boolVerifInfo= $this->checkAddMovieInfo();
        $boolVerifCover = $this->checkAddMovieCover();
        if (!$boolVerifCover && !$boolVerifInfo )
        {
            
        }
        else
        {
            /*info*/
            $this->setInfoMovie();

            $conn = new Connection();
            $pdo = $conn->getPDO();

            $querry = "INSERT INTO public.movie (name, producer, release_date)";
            $querry .= " VALUES (:name,:producer,:date)";

            $sql = $pdo->prepare($querry);
           
            
            $sql->bindParam(':name', $this->name);
            $sql->bindParam(':producer', $this->producer);
            $sql->bindParam(':date', $this->date);
            $sql->execute();
            /*cover*/
            $stmt = $pdo->query("SELECT COUNT(*) FROM  movie as number");
        
         
            $row = $stmt->fetch();
            
            $file_tmp = $_FILES['cover']['tmp_name']; 
            $upload_folder = 'style/img/movie_cover/';
            $file_name = $row['count'];
            $movefile = move_uploaded_file($file_tmp,$upload_folder .$file_name."_movie_cover.png");

        }
              
    }
}