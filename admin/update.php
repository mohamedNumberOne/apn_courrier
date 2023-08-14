<style>
    button {

        font-size: 2rem;

        cursor: pointer;

    }
</style>



<?php


// update sahb

if (

    isset($_GET['id_loi'], $_GET['id_dep']) && (count($_GET) === 2)

    && !empty(trim($_GET['id_loi']))

    && !empty(trim($_GET['id_dep']))

    && filter_var($_GET['id_loi'], FILTER_VALIDATE_INT)

    && filter_var($_GET['id_dep'], FILTER_VALIDATE_INT)

) {



    $id_dep =  htmlspecialchars($_GET['id_dep']);

    $id_loi =  htmlspecialchars($_GET['id_loi']);



    try {



        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep , id_loi from participer  where id_dep = ? and id_loi = ? ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep, $id_loi]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE participer set  intervention = 2  where id_dep = ? and id_loi = ? ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep, $id_loi]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

                session_start();

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> هاذا النائب في حالة انسحاب </h1> <br>  



                <a href='deputes.php' > <button> العودة </button> </a>



                ";
            }
        } else {

            session_start();

            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}





if (

    isset($_GET['up_lajna_add'])

    && (count($_GET) === 1)

    && !empty(trim($_GET['up_lajna_add']))

    && filter_var($_GET['up_lajna_add'], FILTER_VALIDATE_INT)

) {



    $id_dep =  htmlspecialchars($_GET['up_lajna_add']);



    try {



        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep from deputes  where id_dep = ?  ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE deputes set  lajna = 1  where id_dep = ?  ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

                session_start();

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> خطا </h1> <br>  



                <a href='deputes.php' > <button> العودة </button> </a>



                ";
            }
        } else {

            session_start();

            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}





if (
    isset($_GET['up_lajna_delete'])

    && (count($_GET) === 1)

    && !empty(trim($_GET['up_lajna_delete']))

    && filter_var($_GET['up_lajna_delete'], FILTER_VALIDATE_INT)



) {



    $id_dep =  htmlspecialchars($_GET['up_lajna_delete']);



    try {



        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep from deputes  where id_dep = ?  ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE deputes set  lajna = 0  where id_dep = ?  ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

                session_start();

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> خطا </h1> <br>  



                <a href='deputes.php' > <button> العودة </button> </a>



                ";
            }
        } else {

            session_start();

            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}





////////////







if (
    isset($_GET['up_etat_actif'])

    && (count($_GET) === 1)

    && !empty(trim($_GET['up_etat_actif']))

    && filter_var($_GET['up_etat_actif'], FILTER_VALIDATE_INT)



) {



    $id_dep =  htmlspecialchars($_GET['up_etat_actif']);



    try {



        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep from deputes  where id_dep = ?  ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE deputes set  etat = 1  where id_dep = ?  ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

                session_start();

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> خطا </h1> <br>  



                <a href='deputes.php' > <button> العودة </button> </a>



                ";
            }
        } else {

            session_start();

            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}



////////////





if (
    isset($_GET['up_etat_off'])

    && (count($_GET) === 1)

    && !empty(trim($_GET['up_etat_off']))

    && filter_var($_GET['up_etat_off'], FILTER_VALIDATE_INT)



) {



    $id_dep =  htmlspecialchars($_GET['up_etat_off']);



    try {

        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep from deputes  where id_dep = ?  ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE deputes set  etat = 0  where id_dep = ?  ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

                session_start();

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> خطا </h1> <br>  



                <a href='deputes.php' > <button> العودة </button> </a>



                ";
            }
        } else {

            session_start();

            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}




/////////////////////  chafawi kitabi 


if (isset($_GET['action'])  && count($_GET) === 3) {

    if (
        isset($_GET['id_loi'], $_GET['id_dep'])
        &&
        ($_GET['action'] === 'kitabi'
            || $_GET['action'] === 'chafawi'
            || $_GET['action'] === 'sup')
    ) {

        $id_dep = htmlspecialchars($_GET['id_dep']);
        $id_loi = htmlspecialchars($_GET['id_loi']);
        $action = htmlspecialchars($_GET['action']);

        switch ($action) {
            case 'kitabi':
                $action = 0;
                break;
            case 'chafawi':
                $action = 1;
                break;
            case 'sup':
                $action = 2;
                break;
            default:
            case 'chafawi':
                $action = 1;
                break;
        }

        try {

            $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ( $action < 2 ) {
                $sql = "  UPDATE participer set intervention = ? where id_dep = ? and id_loi = ?  ";

                $execution = $cnx->prepare($sql);
    
                $execution->execute([$action, $id_dep, $id_loi]);
    
                // $row = $execution->rowCount();
                session_start();
    
                $_SESSION['updated'] =
                    "<div class='alert-success alert mt-5 text-center' >
                             تم التغيير بنجاح        
                        </div>";
    
                header('location:deputes.php');
            } else if ( $action === 2 ) {
                
                $sql = "DELETE FROM participer where id_dep = ? and id_loi = ?  ";

                $execution = $cnx->prepare($sql);
                $execution->execute([  $id_dep, $id_loi]);
                session_start();
                $_SESSION['supp_dif'] =
                    "<div class='alert-success alert mt-5 text-center' >
                        تم حذف اللنائب من قائمة المترشحين     
                    </div>";
    
                header('location:deputes.php');
            }


        } catch (PDOException $e) {

            echo   $e->getMessage();
        }
    }
}
