<?php
namespace FilmFavoris;

class Page
{
    protected $doc;
    public function showDoc()
    {
        echo $this->doc;
    }
    
    public function initHTML($titre, $css)
    {
        $this->logoutcheck();
        
        $retStr = "<!DOCTYPE html>\n";
        $retStr .= "<html lang='fr'>\n";
        $retStr .= "<head>\n";
        $retStr .= "<title>".$titre."</title>\n";
        $retStr .= '<link rel="stylesheet" type="text/css" href="style/topNav.css">';
        $retStr .= '<link rel="stylesheet" type="text/css" href="style/style.css">';
        if (!empty($css)) {
            $retStr .= '<link rel="stylesheet" type="text/css" href="' . $css .'">';
        }
        $retStr .= "</head>\n";
        $retStr .= "<body>\n";
        return $retStr;
    }
    
    public function topNav()
    {
        $topNav = '';
        $topNav .= '<div class="topNav">';
        $topNav .='<div><a class = "logoLink" href="index.php">
        <img class="logo" src="style/img/logo.png" alt="logo" height="82" width="82"></a></div>
        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <nav>';
        $topNav .= '<ul>';
        $topNav .= '<li><a href="index.php">Accueil</a></li>';
        
        $topNav .= '<li><a href="show_movies.php">Show Movies</a></li>';
        $topNav .= '<li><a href="show_users.php">Show Users</a></li>';
        $topNav .= '<li><a href="show_favorites.php">Show Favorites</a></li>';
        
        if(isset($_SESSION['user_id']))
        {
            $topNav .= '<li><a href="add_movie.php">Add Movie</a></li>';
            $topNav .= '<li><form class="logout" method="POST">
            <input name="log_id" type="hidden" value="logout">
            <button class="logout" type="submit" name="submit">Logout</button></form></li>';
            
        }
        else
        {
            $topNav .= '<li><a href="login.php">Login</a></li>';
            $topNav .= '<li><a href="signup.php">Signup</a></li>';
        }
        
        $topNav .= '</ul></nav><label for="nav-toggle" class="nav-toggle-label"><span></span>
        </label>';
       
        $topNav .= '</div>';
        return $topNav;
    }
    public function logoutCheck()
    {
         if(isset($_POST['log_id']))
            {
              
                $f_id=$_POST['log_id'];
                switch($f_id)
                {
                    case 'logout':
                    {

                        session_start();
                        session_unset();
                        session_destroy();

                        header("location: index.php?logout");

                        exit();


                    }

                    break; 
                }   
                        
            }
    }
    public function beginForm($method, $action, $name)
    {
        if($action == "")
        {
            return "<form method='" . $method . "' name='" . $name . "' >\n";
        } else {
            return "<form method='" . $method . "' action='" . $action . "' name='" . $name . "' >\n";
        }
        
    }

    public function endForm()
    {
        return "</form>";
        
    }

    public function insertInput($type, $name, $humantext)
    {

        $retStr = "<p><label for='" . $name . "'>" . $humantext . "</label><br/>";
        return $retStr . "<input name='" . $name . "' type='" . $type . "' id='" . $name . "' value='' /> </p>";
    }

    public function insertInputWithValue($type, $name, $humantext, $value)
    {
        return "<p><input name='" . $name . "' type='" . $type . "' value='" . $value . "' /> </p>";
    }



    public function insertHidden($name, $value)
    {
        return "<input type='hidden' name='" . $name . "' value='" . $value . "' ></input>";
    }

    public function createLink($href, $text)
    {
        return '<a href="' . $href . '">' . $text . '</a>';
    }

    public function beginBal($bal)
    {
        return "<" . $bal . ">";
    }

    public function endBal($bal)
    {
        return "</" . $bal . ">";
    }

    public function br()
    {
        return "<br/>\n";
    }

    public function beginEndBal($bal, $content)
    {
        $retStr = Page::beginBal($bal);
        $retStr .= $content;
        $retStr .= Page::endBal($bal);
        return $retStr . "\n";
    }
}
