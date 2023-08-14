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


        // id_ad	nom_ad	pnom_ad	email_ad	ps_ad	super_ad	modif1	modif2	

        $sql = "SELECT * from admin_questions  where email_ad = ? and ps_ad = ? ";

        $email =  htmlspecialchars(trim($email));

        $ps =  htmlspecialchars($ps);

        $execution = $this->cnxt_to_db()->prepare($sql);

        $execution->execute([$email, md5($ps)]);

        $row = $execution->rowCount();

        if ($row === 1) {

            foreach ($execution as $key) {


                $_SESSION['id'] =  $key['id_ad'];

                $_SESSION['nom'] =  $key['nom_ad'];

                $_SESSION['pnom'] = $key['pnom_ad'];

                $_SESSION['email'] = $key['email_ad'];

                $_SESSION['super_admin'] = $key['super_ad'];

                $_SESSION['modif1'] = $key['modif1'];

                $_SESSION['modif2'] = $key['modif2'];

                $_SESSION['admin_connected'] =  'yes';

                header('location:dashboard.php');
            }
        } else {

            $_SESSION['error_auth'] =  " <div class='alert alert-danger text-center ' > تحقق من البريد الالكتروني و من كلمة السر </div> ";
        }
    }







    public function  add_admin($nom, $pnom, $email, $ps, $super_a, $modif1 , $modif2 )

    {


        $nom  = htmlspecialchars($nom);

        $pnom = htmlspecialchars($pnom);

        $email = htmlspecialchars($email);

        $ps = htmlspecialchars($ps);

        $super_a = htmlspecialchars($super_a);
        $modif1 = htmlspecialchars($modif1);
        $modif2 = htmlspecialchars($modif2);


        $sql_email =   " SELECT email_ad from admin_questions where email_ad = ?  ";

        $get_email = $this->cnxt_to_db()->prepare($sql_email);

        $get_email->execute([$email]);

        $row = $get_email->rowCount();

        if ($row === 0) {

            $sql =   "INSERT INTO admin_questions values (  ? , ? , ? , ? , ? , ? , ? , ?  ) ";

            $execution = $this->cnxt_to_db()->prepare($sql);

            $execution->execute([null, $nom, $pnom,  $email, md5($ps),  $super_a ,$modif1 ,$modif2  ]);

            $_SESSION['admin_added'] = "<div class='alert alert-success text-center ' > تمت الإضافة </div>";
        } else {

            $_SESSION['admin_added'] = "<div class='alert alert-warning text-center ' >  
             خطأ  
              <br> 
            هاذا الايمايل قد تم التسجيل به مسبقا
            </div>";
        }
    }
}





$admin = new admin();
