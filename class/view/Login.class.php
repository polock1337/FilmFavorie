<?php
namespace FilmFavoris;

use PDO;

class Login extends Page 
{
    public $doc;    
    
    public function __construct()
    {        
        
        $this->doc = parent::initHTML("Login", "");
        
        $this->doc .= parent::topNav();
        
        $this->doc .= parent::beginForm("POST","","formLogin");
        $this->doc .= parent::insertInput("text","username","username :");
        $this->doc .= parent::insertInput("password","password","password :");
        $this->doc .= parent::insertInputWithValue("submit","btn-submit","","Valider");
        $this->doc .= parent::endForm();
        
        $this->doc .= parent::endBal("body");
        $this->doc .= parent::endBal("html");
        
        

        $this->checkLogin();

        
    }

    private function checkLogin()
    {
        $conn = new Connection();
        $pdo = $conn->getPDO();

        #session_start();
   
        if($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            
            $myusername = $_REQUEST['username'];
            $mypassword = $_REQUEST['password'];            

            $sql = $pdo->prepare('SELECT * FROM public.movie_user WHERE username=:myusername');
            $sql->bindParam(':myusername', $myusername);
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_OBJ);
            $rows = count($data);
            
                
            if($rows>0) 
            {
                if(!$data[0]->confirmed)
                    $this->doc .= "You need to confirm your user account before using this website!";


                $passwordpg = $data[0]->hashed_password;
                if(password_verify($mypassword,$passwordpg) && $data[0]->confirmed)
                {
                    $_SESSION['user_id'] = $data[0]->id;
                    $_SESSION['user_name'] = $data[0]->username;
                    header("location: index.php?Login_success");
                }
                else 
                {
                    if($data[0]->confirmed)
                        $this->doc .= "Your Login Name or Password is invalid";
                }
                
            }
            else 
            {
                $this->doc .= "Your Login Name or Password is invalid";
            }
            
        }
    }
        
}
    


