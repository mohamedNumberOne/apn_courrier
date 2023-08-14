<?php

include("connect.class.php");

class admin extends db
{

    private  $id;
    private  $nom;
    private  $pnom;
    private  $email;
    private  $ps;
    private  $super_admin;
    private  $add_pers;
    private  $statistiques;
    private  $telechargement;


    public function connect_admin($email, $ps)
    {

        $sql = "SELECT * from admins  where email = ? and ps = ? ";
        $email =  htmlspecialchars(trim($email));
        $ps =  htmlspecialchars($ps);
        $execution = $this->cnxt_to_db()->prepare($sql);

        $execution->execute([$email, md5($ps)]);

        $row = $execution->rowCount();
        if ($row === 1) {
            foreach ($execution as $key) {


                $_SESSION['id'] =  $key['id'];
                $_SESSION['nom'] =  $key['nom'];
                $_SESSION['pnom'] = $key['pnom'];
                $_SESSION['email'] = $key['email'];
                $_SESSION['super_admin'] = $key['super_admin'];
                $_SESSION['add_pers'] = $key['add_pers'];
                $_SESSION['statistiques'] = $key['statistiques'];
                $_SESSION['telechargement'] = $key['telechargement'];

                header('location:welcome.php');
            }
        } else {
            $_SESSION['error_auth'] =  " <div class='alert alert-danger' > تحقق من البريد الالكتروني و من كلمة السر </div> ";
        }
    }



    public function  add_admin($nom, $pnom, $email, $ps, $super_a, $add_pers, $stat, $telech)
    {

        $nom  = htmlspecialchars($nom);
        $pnom = htmlspecialchars($pnom);
        $email = htmlspecialchars($email);
        $ps = htmlspecialchars($ps);
        $super_a = htmlspecialchars($super_a);
        $add_pers = htmlspecialchars($add_pers);
        $stat = htmlspecialchars($stat);
        $telech = htmlspecialchars($telech);

        $sql_email =   " SELECT email from admins where email = ?  " ;
        $get_email = $this->cnxt_to_db()->prepare($sql_email) ;
        $get_email -> execute([$email ]) ;
        $row = $get_email  -> rowCount();
        if (  $row === 0   ) {
            $sql =   "INSERT INTO admins values (  ? , ? , ? , ? , ? , ? , ? , ? , ?  ) " ;
            $execution = $this->cnxt_to_db()->prepare($sql);
            $execution->execute([ null , $nom , $pnom ,  $email, md5($ps),  $super_a, $add_pers, $stat, $telech ]);
            $_SESSION['admin_added'] = "<div class='alert alert-success text-center ' > تمت الإضافة </div>";
        }else {
            $_SESSION['admin_added'] = "<div class='alert alert-warning text-center ' >  خطأ   </div>";
        }


    }
}


$admin = new admin();
