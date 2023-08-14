<?php

 




if (isset($_POST['wilaya'])) {


    $wilaya = htmlspecialchars(trim($_POST['wilaya']));

    try {

        $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
       
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
                    <th scope='col'> الحذف  <br> النهائي </th>

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

                                    <button class='btn btn-success' >  عضو الحكومة   </button> 

                                </a>";

                } else if ($lajna ==  "عضو") {

                    echo "  <a href='update.php?up_lajna_delete=$id_dep'> 
                                        <button class='btn btn-danger' > سحب من الحكومة </button> 
                                    </a>";
                }

                echo "</td>
                
                <td> <a href='sup.php?sup_dept_final=$id_dep' class='btn btn-danger' > احذف </a> </td>

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

