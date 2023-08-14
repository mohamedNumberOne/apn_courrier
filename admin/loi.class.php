<?php





class lois

{



    public $id_loi;

    public $nom_loi;

    public $date_fin;

    public $jour;

    public $mois;

    public $annee;



    public function loi_to_form() {

        try {


            $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = " SELECT *  from lois where date_fin > now()  ";

            $exec_loi =  $cnx->prepare($sql);

            $exec_loi->execute( );

            $row_loi = $exec_loi->rowCount();

            if ($row_loi > 0) {
                echo "<label for='loi' class='d-block titre_form'>  إختر القانون </label>

                <select id='loi' name='loi'  class='form-control wilaya_select col-12 col-md-6 ' required >";

                echo    "<option value='' >  </option>  ";

                foreach ($exec_loi as $key) {

                    $nom = $key['nom'];

                    $id = $key['id_loi'];

                    // $date_fin = $key['date_fin'];

                    echo "<option value='$id' >  $nom  </option>  ";
                }

                echo "  </select> <hr> ";
            }


 
        } catch (PDOException $e) {

            echo   $e->getMessage();
        }

    }




    public function get_loi()

    {



        try {

            $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = " SELECT  

            id_loi , nom , date_fin , year(date_fin) as annee , month(date_fin) as mois

            , day(date_fin) as jour  

            from lois where date_fin > now() ";

            $execution =  $cnx->prepare($sql);

            $execution->execute();

            $row = $execution->rowCount();

            if ($row > 0) {

                foreach ($execution as $key) {

                    $this->id_loi = $key['id_loi'];

                    $this->nom_loi = $key['nom'];

                    $this->date_fin = $key['date_fin'];

                    $this->jour = $key['jour'];

                    $this->mois = $key['mois'];

                    $this->annee = $key['annee'];
                }
            }
        } catch (PDOException $e) {

            echo   $e->getMessage();
        }
    }



    public function  form_update_loi ($id_loi) {
        try {
            $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', 
            array(1002 => 'SET NAMES utf8'));

            $id_loi = htmlspecialchars($id_loi) ;

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = " SELECT nom , year(date_fin) as y , month(date_fin) as mo ,
            day(date_fin) as d ,
            hour(date_fin) as h , minute(date_fin) as mi   from lois  where id_loi  = ?  ";

            $execution =  $cnx->prepare($sql);

            $execution->execute( [$id_loi] );

            $row = $execution->rowCount();
            if ( $row === 1 ) {

                foreach ($execution as $key ) {
                    $nom = $key['nom'] ;
                    
                }
                

                echo "
                <h1 class='text-center m-3 pt-4' >  التعديل على: $nom </h1>
                    <form method='POST'>
                    <div class='form-group'>
                        <label for='exampleInputEmail1'>الاسم الجديد</label>
                        <input type='text' class='form-control' id='exampleInputEmail1' 
                           name='new_name' required >
                    </div>

                    <div class='form-group'>
                        <label for='w'>تاريخ النهاية الجديد</label>
                        <input type='date' class='form-control' id='w' name='new_date' required >
                    </div>
                    
                    <div class='form-group'>
                        <label for='s'>الساعة</label>
                        <input type='time' class='form-control' id='s'name='new_hour' value='09:00'  required>
                    </div>

                    <button type='submit' class='btn btn-success w-100' name='update_loi'>تعديل</button>
                </form>
                
                ";


            }else {
                header('location:lois.php');
            }
        }catch (PDOException $e) {

            echo   $e->getMessage();
        }

    }

    public function   update_loi ($new_name , $new_date  )  {
        try {
            $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', 
            array(1002 => 'SET NAMES utf8'));

            $new_name = htmlspecialchars($new_name) ;
            $new_date = htmlspecialchars($new_date) ;

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = " UPDATE lois set nom = ?  , date_fin = ? where id_loi  = ?  ";

            $execution =  $cnx->prepare($sql);

            $execution->execute( [$new_name , $new_date, $_GET['id_loi_up'] ] );

            $_SESSION['success_up'] = "<div class='alert alert-success text-center' >
            تم التعديل
            </div>" ;
            header('location:lois.php');

          
        }catch (PDOException $e) {

            echo   $e->getMessage();
        }


    }

    public function display_lois()

    {

        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



        $sql = " SELECT * from lois  ";

        $execution =  $cnx->prepare($sql);

        $execution->execute();

        $row = $execution->rowCount();

        if ($row > 0) {

            echo "
            <table class='table table-bordered text-center   '>

            <thead>

                <tr>

                    <th scope='col'>   خيارات  </th> 
                    <th scope='col'>اسم القانون</th>
                    <th scope='col'>تاريخ نهاية التسجيل</th> 
                    
                </tr>

            </thead>

            <tbody>

            ";

            foreach ($execution as $key) {

                $date_fin    = $key['date_fin'];
                $nom   = $key['nom'];
                $id_loi   = $key['id_loi'];

                echo "                    

                <tr>
                    <td>   
                        <a href='sup_lois.php?id_loi_sup=$id_loi' 
                        class='btn btn-danger' >
                            حذف
                        </a>    
                        <a href='update_loi.php?id_loi_up=$id_loi' 
                        class='btn btn-success' >
                        تعديل   
                        </a>   
                        
                    </td>

                    <td> $nom  </td>

                    <td>  $date_fin    </td>



                </tr>";
            }
            echo "
            </tbody>

            </table>";
        } else {
            echo "<div class='alert alert-warning text-center' >لا يوجد قوانين</div>  ";
        }
    }







    public function get_all_lois()

    {



        try {

            $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = " SELECT * from lois  ";

            $execution =  $cnx->prepare($sql);

            $execution->execute();

            $row = $execution->rowCount();

            if ($row > 0) {

                echo "    

                <form method='POST'>

                    <select class='form-control col-sm-12 col-md-6 ' id='select_l' >

                        <option value='' >اختر القانون </option>";

                foreach ($execution as $key) {

                    $id_loi =  $key['id_loi'];

                    $nom =  $key['nom'];

                    echo " <option value='$id_loi' > $nom </option> ";
                }

                echo " </select>

                </form>";
            }
        } catch (PDOException $e) {

            echo   $e->getMessage();
        }
    }





    public function add_loi($nom_loi, $date_fin)

    {

        $nom_loi = htmlspecialchars($nom_loi);

        $date_fin = htmlspecialchars($date_fin);


        try {

            $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', 
            array(1002 => 'SET NAMES utf8'));

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_SESSION['id'])) {

                $admin =  $_SESSION['id'];

                $verify_nom_loi = "SELECT nom from lois where nom =  ? ";

                $execution1 = $cnx->prepare($verify_nom_loi);

                $execution1->execute([$nom_loi]);

                $row1 = $execution1->rowCount();

                if ($row1 === 0) {

                    $sql = "INSERT INTO  lois values (  ? , ? , ? , ?   ) ";

                    $execution = $cnx->prepare($sql);

                    $execution->execute([null, $nom_loi, $date_fin, $admin]);

                    $row = $execution->rowCount();

                    if ($row === 1) {

                        $_SESSION['add_loi'] =  "

                        <div class=' alert alert-success text-center ' >تم اضافة القانون</div>";
                    }
                } else {

                    $_SESSION['add_loi'] =  "

                    <div class=' alert alert-warning text-center ' >  حصل خطأ ما </div>";
                }
            }
        } catch (PDOException $e) {

            echo   $e->getMessage();
        }
    }
}



$lois = new lois();
