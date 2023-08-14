<?php

include('connect.class.php');

class session extends db {

    public function add_session(  $date_debut  , $date_fin , $session_name ) {

        $date_debut = htmlspecialchars($date_debut);
        $date_fin = htmlspecialchars($date_fin);
        $session_name = htmlspecialchars($session_name);

        $sql = " INSERT INTO sessions values ( null , ?  , ? ,  ?  , 0 , 1 ) ";

        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$session_name , $date_debut , $date_fin]);

        $row = $exec->rowCount();
        if ( $row === 1 ){
            
            echo    " <script> location.href='' </script>" ;
            $_SESSION['add_sess'] = "   <div class='alert alert-success text-center ' > 
                      تمت الاضافة
                </div>  ";

        }else {
           echo"  <script> location.href='' </script>";
           $_SESSION['add_sess'] = "  <div class='alert alert-warning text-center ' > 
                      خطأ
                </div>  ";
        }

    }


    public function get_sessions( ) {

        $sql = " SELECT * FROM sessions ";

        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute( );

        $row = $exec->rowCount();
        if ( $row > 0 ) {

            echo "   <ul class='list-group'>" ;
            foreach ($exec as $key  ) {
                $nom_session =  $key['nom_session'] ;
                $etat_session =  $key['etat_session'];
                $id_session =  $key['id_session'];
                
                
                if ( $etat_session == 1  ) {
                    switch ($etat_session) {
                        case '0':
                            $etat_session = "تفعيل";
                            break;
                        case '1':
                            $etat_session = "الجارية";
                            break;
                        default:
                            $etat_session = "تفعيل";
                            break;
                    }
                
                    echo "
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                $nom_session
                <span class=' badge bg-secondary p-2 text-white rounded-pill'>$etat_session</span>
            </li> ";

                }else if  ($etat_session == 0 ) {
                    switch ($etat_session) {
                        case '0':
                            $etat_session = "تفعيل";
                            break;
                        case '1':
                            $etat_session = "الجارية";
                            break;
                        default:
                            $etat_session = "تفعيل";
                            break;
                    }
                
                    echo "
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                $nom_session
               <a href='update.php?id_session_active=$id_session'> <span class=' badge 
                    bg-success
               text-white  p-2  rounded-pill'>$etat_session</span> </a>
            </li> ";
            
        }


            }
            echo "</ul>" ;

        }

    }


}

$session = new session();