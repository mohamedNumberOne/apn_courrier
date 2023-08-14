<?php


if (isset($_POST['select_l'])) {

    $select_loi = htmlspecialchars(trim($_POST['select_l']));

    try {

        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = " SELECT deputes.nom as deputes_nom, groupes.nom as nom_groupe, deputes.pnom as deputes_pnom, date_ins , intervention , classement , participer.id_dep , participer.id_dep , participer.id_loi 

        from participer 

        INNER JOIN deputes ON participer.id_dep = deputes.id_dep 

        INNER JOIN groupes ON groupes.id_groupe = deputes.id_groupe WHERE id_loi =  ? GROUP BY classement  ";


        $exec = $cnx->prepare($sql);

        $exec->execute([$select_loi]);

        $row = $exec->rowCount();

        if ($row > 0) {

            echo "

           <a href='../liste_depute.php?select_loi=$select_loi' >

                <button class='btn btn-success' >

                    تحميل  <i class='fas fa-download'></i> 

            </button>

           </a> 

            <table class='table table-striped text-center mt-4 '>

            <thead>

                <tr>

                    <th scope='col'>الاسم</th>

                    <th scope='col'>اللقب</th>

                    <th scope='col'>تاريخ التسجيل</th>

                    <th scope='col'>الانتماء</th>

                    <th scope='col'>الدور</th>

                    <th scope='col'> طبيعة التدخل </th>

                    <th scope='col'>  تغيير </th>

                </tr>

            </thead>

            <tbody> ";



            foreach ($exec as $key) {

                $nom_dep =  $key['deputes_nom'];

                $deputes_pnom =  $key['deputes_pnom'];

                $date_ins =  $key['date_ins'];

                $classement =  $key['classement'];

                $nom_groupe =  $key['nom_groupe'];

                $intervention =  $key['intervention'];

                $id_dep =  $key['id_dep'];

                $id_loi =  $key['id_loi'];



                switch ($intervention) {

                    case '0':

                        $intervention = "كتابي";

                        break;

                    case '1':

                        $intervention =  "شفوي";

                        break;

                    case '2':

                        $intervention =  "سحب";

                        break;

                    default:

                        $intervention =  "كتابي";

                        break;

                }

 
                echo "<tr>

                    <td scope='row'> $deputes_pnom </td>

                    <td>  $nom_dep </td>

                    <td> $date_ins </td>

                    <td>  $nom_groupe </td>

                    <td> $classement  </td>

                    <td> $intervention </td>

                    
                    <td> 

                        <a href='update.php?id_dep=$id_dep&id_loi=$id_loi'> 
                            <button class='btn btn-danger p-1' >سحب </button> 
                        </a> 

                        <a href='update.php?id_dep=$id_dep&id_loi=$id_loi&action=kitabi'> 
                            <button class='btn btn-dark  p-1' >كتابي </button> 
                        </a> 

                        <a href='update.php?id_dep=$id_dep&id_loi=$id_loi&action=chafawi'> 
                            <button class='btn btn-success  p-1' >شفوي </button> 
                        </a> 
                        
                        <a href='update.php?id_dep=$id_dep&id_loi=$id_loi&action=sup'> 
                            <button class='btn btn-danger  p-1' >حذف </button> 
                        </a> 

                    </td>

                </tr> ";

            }



            echo "

            </tbody>

        </table>";

        } else {

            echo "

            <div class='alert-warning alert mt-5 text-center' >

                لم يسجل  اي شخص حتى الآن

            </div>";

        }

        return $cnx;

    } catch (PDOException $e) {

        echo   $e->getMessage();

    }

}





if (isset($_POST['wilaya'])) {



    $wilaya = htmlspecialchars(trim($_POST['wilaya']));


    try {



        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = " SELECT  id_dep , nom , pnom , etat , lajna from deputes WHERE id_wilaya =  ? ";



        $exec = $cnx->prepare($sql);

        $exec->execute([$wilaya]);

        $row = $exec->rowCount();

        if ($row > 0) {

            echo "

            <table class='table table-striped text-center mt-4 '>

            <thead>

                <tr>

                    <th scope='col'>الاسم</th>

                    <th scope='col'>اللقب</th>

                    <th scope='col'>الحالة</th>

                    <th scope='col'>اللجنة</th>

                </tr>

            </thead>

            <tbody> ";



            foreach ($exec as $key) {



                $nom_dep =  $key['nom'];

                $pnom_dep =  $key['pnom'];

                $id_dep =  $key['id_dep'];

                $etat =  $key['etat'];

                $lajna =  $key['lajna'];

                switch ($etat) {



                    case '0':

                        $etat = "مجمد";

                        break;

                    case '1':

                        $etat =  "نشط";

                        break;

                    default:

                        $etat =  "نشط";

                        break;

                }





                switch ($lajna) {



                    case '0':

                        $lajna = "ليس عضو";

                        break;

                    case '1':

                        $lajna =  "عضو";

                        break;

                }



                echo "

                <tr>

                    <td>  $pnom_dep </td>

                    <td>  $nom_dep </td>



                    <td>   

                        <b> $etat </b>

                        <br>";

                if ($etat == "مجمد") {

                            echo "<a href='update.php?up_etat_actif=$id_dep'> 

                                        <button class='btn btn-success' >  تنشيط </button> 

                                    </a> ";

                } else if ($etat ==  "نشط") {

                            echo " <a href='update.php?up_etat_off=$id_dep'> 

                                        <button class='btn btn-danger' >  تجميد  </button> 

                                    </a> ";

                }



                echo "</td>

                  

                    <td>  

                        <b> $lajna </b>

                        <br>";

                if ($lajna == "ليس عضو") {

                    echo "<a href='update.php?up_lajna_add=$id_dep'> 

                                    <button class='btn btn-success' >  اضافة للجنة  </button> 

                                </a>";

                } else if ($lajna ==  "عضو") {

                    echo "  <a href='update.php?up_lajna_delete=$id_dep'> 

                                        <button class='btn btn-danger' >  حذف من اللجنة </button> 

                                    </a>";

                }

                echo "</td>

                </tr>";

            }



            echo "

            </tbody>

        </table>";

        } else {

            echo "

            <div class='alert-warning alert mt-5 text-center' >

                    لا يوجد اي نائب  

            </div>";

        }

        return $cnx;

    } catch (PDOException $e) {

        echo   $e->getMessage();

    }

}

