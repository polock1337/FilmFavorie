<?php
namespace FilmFavoris;

class Confirmation extends Page 
{

    
    public function __construct()
    {
        
            $this->doc = parent::initHTML("Confirmation",'');
            $this->doc .= parent::topNav();
            
            $this->doc .= $this->formConfirm();

            $this->doc .= parent::endBal("body");
            $this->doc .= parent::endBal("html");
        
    }
    protected function formConfirm()
    {
        $form ='<form  action="confirm_user.php" method="POST" >
            <label>username :</label><br>
            <input type="text" name="uid" placeholder="Username"><br>
            <label>Confirm code :</label><br>
            <input type="text" name="confirmcode" placeholder="code"><br>
            <button type="submit" name="submit">Confirmer</button>
            <input name= "f_id" type="hidden" value="confirm">
            </form>';
        return $form;

    }
    public function confirmUser() 
    {
        if(!empty($_REQUEST['uid']) && !empty($_REQUEST['confirmcode'])){
            $conn = new Connection();
            $pdo = $conn->getPDO();

            $uidpg = pg_escape_string($_REQUEST['uid']);
            $uid = htmlspecialchars($uidpg);
            $codpg = pg_escape_string($_REQUEST['confirmcode']);
            $cod = htmlspecialchars($codpg);


            $sql = $pdo->prepare("SELECT (id) FROM public.movie_user WHERE username=:uid");
            $sql->bindParam(':uid', $uid);
            $sql->execute();
            $data = $sql->fetchAll();
            $rows = count($data);
            
            foreach ($data as $row) {
                $idNumber = $row['id'];
                
                $sql = $pdo->prepare("SELECT * FROM public.movie_user_confirm WHERE user_id=:idn");
                $sql->bindParam(':idn', $idNumber);
                $sql->execute();
                $data = $sql->fetchAll();
                foreach ($data as $row) {
                    if($row['confirm_code'] == $cod){
                        $conf = "True";
                        $query = "UPDATE public.movie_user_confirm";
                        $query .= " SET confirmed = :conf";
                        $query .= " WHERE user_id = :idn";
                        $sql = $pdo->prepare($query );
                        $sql->bindParam(':idn', $idNumber);
                        $sql->bindParam(':conf', $conf);
                        $sql->execute();

                        $query = "UPDATE public.movie_user";
                        $query .= " SET confirmed = :conf";
                        $query .= " WHERE id = :idn";
                        $sql = $pdo->prepare($query );
                        $sql->bindParam(':idn', $idNumber);
                        $sql->bindParam(':conf', $conf);
                        $sql->execute();

                        $this->doc .= "Your user account has been confirmed.";
                    }
                

                }
            }
        }
    }
}