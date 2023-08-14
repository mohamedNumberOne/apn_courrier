<?php


include("all.class.php");


class question extends all
{


    public function add_quest($id_dep, $sujet_qst, $text_qst, $type_qst, $fichier_qst, $id_m, $id_session, $num_qst,$date_eng)
    {
        $id_dep = htmlspecialchars($id_dep);
        $sujet_qst = htmlspecialchars($sujet_qst);
        // $text_qst = htmlspecialchars($text_qst);
        $type_qst = htmlspecialchars($type_qst);
        $id_m = htmlspecialchars($id_m);
        $id_session = htmlspecialchars($id_session);
        $num_qst = htmlspecialchars($num_qst);

        // Verify Id dept :
        $sql = "SELECT id_dep from deputes where id_dep = ? ";
        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$id_dep]);
        $row = $exec->rowCount();
        if ($row === 1) {
            // Verify Id wizara : 

            $sql = "SELECT id_m from ministeres where id_m = ? ";
            $exec  =  $this->cnxt_to_db()->prepare($sql);

            $exec->execute([$id_m]);
            $row = $exec->rowCount();
            if ($row === 1) {
                // Verify  type_qst : 
                if ($type_qst  === 'a' ||   $type_qst === 'b') {
                    // a kitabi , b chafawi
                    switch ($type_qst) {
                        case 'b':
                            $mokadima =
                                "بناء على الدستور، لاسيما المواد 7 و117 و158 منه، بناء على القانون العضوي رقم 16-12،
                             ولاسيما المواد 69 و 70 و 71 و 72 منه، بناء على القانون رقم 01-01، المتعلق بعضو البرلمان، المعدل، ولاسيما المواد 3

                            - 5 و 7 و 8 منه. - بناء على النظام الداخلي للمجلس الشعبي الوطني.

                            أتوجه إليكم بالسؤال الشفوي";
                            break;

                        case 'a':
                            $mokadima = "- بناء على الدستور، لاسيما المواد 7 و117 و158 منه،

                        بناء على القانون العضوي رقم 16-12، ولاسيما المواد 69 و 73 و 74 منه، بناء على القانون رقم 01-01، المتعلق بعضو البرلمان، المعدل، ولاسيما المواد 3

                        - 5 و 7 و 8 منه. بناء على النظام الداخلي للمجلس الشعبي الوطني.

                        أتوجه إليكم بالسؤال الكتابي
                            ";
                            break;

                        default:
                            $mokadima = "";
                            break;
                    }

                    $mokadima = $mokadima . " <br>";

                    $id_admin =  $_SESSION['id'];
                    // verify  id_session  :
                    $sql_session = "SELECT id_session from sessions where id_session = ? ";
                    $exec  =  $this->cnxt_to_db()->prepare($sql_session);

                    $exec->execute([$id_session]);
                    $row = $exec->rowCount();

                    if ($row === 1) {

                        // Verify num qst : 

                        $sql = "SELECT num_qst from questions where num_qst = ?  and type_qst = ? 
                                and id_session =  ?   ";
                        $exec  =  $this->cnxt_to_db()->prepare($sql);

                        $exec->execute([$num_qst, $type_qst, $id_session]);
                        $row = $exec->rowCount();

                        if ($row === 0) {
                            $sql = "INSERT INTO questions values  (
                                null ,
                                ?, 
                                ?, 
                                ?, 
                                'a' , 
                                ?, 
                                ?, 
                                null ,
                                null , 
                                null ,
                                null , 
                                0 ,
                                ?, 
                                $id_admin ,
                                ?,
                                ?,
                                null,
                                0,
                                ?,
                                0 ,
                                '/',
                                null

                                ) ";

                            $text_qst = $mokadima . $text_qst; 
                            $exec  =  $this->cnxt_to_db()->prepare($sql);
                            // $fichier_qst = 'pdf';
                            $exec->execute([$sujet_qst, $text_qst, $type_qst, $fichier_qst, $date_eng , $id_m, $id_dep, $id_session, $num_qst]);
                            //////////////   bedel id admin   ////////////////////////

                            $row = $exec->rowCount();

                            if ($row === 1) {
                                // echo "<script> location.href ='' </script>";
                                $_SESSION['added'] = "<div class='alert alert-success text-center  container '> 
                                تمت إضافة السؤال
                                     </div> ";
                                header('location:add_qst.php');
                            } else {

                                $_SESSION['added'] = "<div class='alert alert-warning text-center ' > خطأ </div>";
                                header('location:add_qst.php');
                            }
                        } else {


                            $_SESSION['added'] = "<div class='alert alert-warning text-center ' > 
                            خطأ في رقم السؤال 
                            </div>";
                            header('location:add_qst.php');
                        }
                    } else {
                        $_SESSION['added'] = "<div class='alert alert-warning text-center ' > خطأ </div>";
                        header('location:add_qst.php');
                    }
                } else {

                    $_SESSION['added'] = "<div class='alert alert-warning text-center ' > خطأ </div>";
                    header('location:add_qst.php');
                }
            } else {

                $_SESSION['added'] = "<div class='alert alert-warning text-center ' > خطأ </div>";
                header('location:add_qst.php');
            }
        } else {

            $_SESSION['added'] = "<div class='alert alert-warning text-center ' > خطأ </div>";
            header('location:add_qst.php');
        }
    }


    public function get_orales_qst()
    {

        $sql = "SELECT  count(id_qst) as total from questions 
        INNER JOIN sessions on sessions.id_session = questions.id_session 
        where  type_qst = 'b' and etat_session = 1  ";

        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute();
        $row = $exec->rowCount();

        if ($row > 0) {
            foreach ($exec as $key) {
                $ids =  $key['total'];
            }
        }


        $qst_par_page = 50;
        $nb_page =  ceil($ids / $qst_par_page);
        if (
            isset($_GET['page'])  && !empty(trim($_GET['page']))
            && filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT)
            &&
            $_GET['page'] <= $nb_page

        ) {
            $page =  htmlspecialchars($_GET['page']);
        } else {
            $page = 1;
        }

        $debut = ($page - 1) * $qst_par_page;

        $sql = "SELECT questions.id_qst   , questions.id_dep , talkhis , groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , sujet_qst , transfert , molahada_one , molahada_two , etat_qst , mashob , date_eng ,date_reunion ,date_env  , fichier_rep , fichier_qst    , date_rep , num_qst , taajil , taraf_taajil  
        , date_resume 
        FROM  questions  INNER JOIN deputes on deputes.id_dep = questions.id_dep 
        INNER JOIN sessions on sessions.id_session = questions.id_session 
        INNER JOIN ministeres on ministeres.id_m = questions.id_m 
        INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
        INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
        left JOIN repenses on repenses.id_qst = questions.id_qst
        where  type_qst = 'b' and etat_session = 1 order by num_qst desc  limit  $debut , $qst_par_page   ";

        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute();
        $row = $exec->rowCount();

        if ($row  > 0) {

            echo "  <div class='text-right mb-2' >
            الصفحات:
            ";

            for ($i = 1; $i <= $nb_page; $i++) {
                if ($i != $page) {
                    echo " <span class='span_page' >   <a href='?page=$i' class='a_page'  > $i   </a>  </span>   ";
                } else {
                    echo " <span class='span_page' style='background:gray;'  > $i </span>   ";
                }
            }

            echo "  
             </div> 
                <table class='table table-striped mt-2 table-bordered  text-center text-dark '>
            <thead>

                <tr >
                    <th scope='col'> # </th>
                    <th scope='col'>تاريخ الايداع</th>
                    <th scope='col'>صاحب السؤال</th>
                    <th scope='col'>الوزارة</th>
                    <th scope='col'>السؤال</th>
                    <th scope='col'  style='min-width:250px' >الموضوع</th>
                    <th scope='col'>التلخيص</th>

                    <th scope='col'>  
                      تاريخ                      
                     <br>
              التلخيص                       
                    </th>

                    <th scope='col'>ملاحظة 1</th>
                    <th scope='col'>ت.إ.المكتب</th>
                    <th scope='col'> قرار المكتب  </th>
                    <th scope='col'>  ملاحظة 2</th>
                    <th scope='col'> ت.إ.الحكومة</th>
                    <th scope='col'>تحويل</th>
                    <th scope='col'>التأجيل</th>
                    <th scope='col'>السحب</th>
                    <th scope='col'>ت . الجواب</th>
                    <th scope='col'>الجواب</th>
                    <th scope='col'>تعديل</th>
                    
                </tr>
            </thead>
            <tbody>";


            foreach ($exec as $key) {
                $id_qst = $key['id_qst'];
                $sujet_qst = $key['sujet_qst'];
                $etat_qst = $key['etat_qst'];
                $num_qst =  $key['num_qst'];

                $taajil =  $key['taajil'];
                $taraf_taajil =  $key['taraf_taajil'];

                $date_resume =  $key['date_resume'];


                if (!empty($key['date_resume'])) {
                    $date_resume = $key['date_resume'];
                } else {
                    $date_resume =  "ليس بعد";
                }

                
                switch ($taajil) {
                    case '1':
                        $taajil = "<span class='badge bg-danger text-white' >   قام بالتأجيل  </span> ";
                        break;
                    case '0':
                        $taajil =  " <span class='badge bg-success text-white' >   لم يؤجل   </span> ";
                        break;

                    default:
                        '/';
                        break;
                }


                switch ($taraf_taajil) {
                    case '1':
                        $taraf_taajil = 'النائب';
                        break;
                    case '0':
                        $taraf_taajil = 'الوزير';
                        break;

                    default:
                        '/';
                        break;
                }

                switch ($etat_qst) {
                    case 'a':
                        $etat_qst = 'لم يعالج بعد';
                        break;
                    case 'r':
                        $etat_qst = '<span class="badge bg-danger text-light" > مرفوض </span>';
                        break;
                    case 'c':
                        $etat_qst = '<span class="badge bg-success text-light" > مقبول </span>';
                        break;
                    default:
                        $etat_qst = 'لم يعالج بعد';
                        break;
                }
                $date_eng = $key['date_eng'];
                if (!empty($key['date_env'])) {
                    $date_env = $key['date_env'];
                } else {
                    $date_env =  "ليس بعد";
                }
                if (!empty($key['date_reunion'])) {
                    $date_reunion = $key['date_reunion'];
                } else {
                    $date_reunion =  "ليس بعد";
                }

                if (!empty($key['molahada_one'])) {
                    $molahada_one = $key['molahada_one'];
                } else {
                    $molahada_one =  "لا يوجد";
                }

                if (!empty($key['molahada_two'])) {
                    $molahada_two = $key['molahada_two'];
                } else {
                    $molahada_two =  "لا يوجد";
                }


                if (!empty($key['transfert'])) {
                    $transfert =  "<span class='btn btn-warning'> قام بالتحويل </span>";
                } else {
                    $transfert =  "لم يقم بالتحويل";
                }

                if (!empty($key['talkhis'])) {
                    // $talkhis = $key['talkhis'];
                    $talkhis = " <a href='modifications.php?idqst=$id_qst' target='_blank' > التلخيص </a> ";
                } else {
                    $talkhis =  "لم يلخص بعد";
                }

                if (!empty($key['date_rep'])) {
                    $date_rep = $key['date_rep'];
                } else {
                    $date_rep =  "ليس بعد";
                }

                $nom_w = $key['nom_w'];


                // $id_m = $key['id_m'];
                $nom_m = $key['nom_m'];
                $nom_g = $key['nom_g'];
                $fichier_qst = $key['fichier_qst'];

                $nom = $key['nom'] . ' ' . $key['pnom'];

                echo " 
                 <tr>
                    <th scope='row'> $num_qst </th>
                    <td> 
                    
                        $date_eng 

                        <form action='update.php' method='post'   >
                        <input type='date' name='date_eng_form' class='w-100' required     >
                        <br>
                        <input type='hidden' name='id_qst_form' value='$id_qst'>
                        <br>
                        <input type='submit' name='change_date_eng_orale' class='btn btn-success p-1'  value='تعديل'>
                        </form>

                    </td>
                    <td>  
                        - <b> $nom </b>  .  <br> 
                        - $nom_g .   <br> 
                        - $nom_w .  
                     </td>
                    
                    <td> $nom_m  </td>
                    <td> <a href='$fichier_qst'  target='_blank' >   PDF </a>  </td>
                    <td> $sujet_qst </td>
                    <td> $talkhis </td>
                    <td> $date_resume </td>
                    <td> $molahada_one  </td> ";

                if (

                    (isset($_SESSION['admin_connected'])  &&  $_SESSION['admin_connected'] === "yes")
                    && (isset($_SESSION['super_admin']) || isset($_SESSION['modif2']))
                    && ($_SESSION['super_admin'] == 1 || $_SESSION['modif2']  == 1)

                ) {
                    echo "<td> 

                    $date_reunion
 
                           <form action='update.php' method='post'   >
                                <input type='date' name='date_reunion_form' class='w-100' required     >
                                <br>
                                <input type='hidden' name='id_qst_form' value='$id_qst'>
                                <br>
                                <input type='submit' name='change_date_reunion_orale' class='btn btn-success p-1'  value='تعديل'>
                            </form>

                    </td>";
                } else {
                    echo "<td>  $date_reunion </td>";
                }

                echo "  <td> $etat_qst </td>
                    <td> $molahada_two</td>";

                if (

                    (isset($_SESSION['admin_connected'])  &&  $_SESSION['admin_connected'] === "yes")
                    && (isset($_SESSION['super_admin']) || isset($_SESSION['modif2']))
                    && ($_SESSION['super_admin'] == 1 || $_SESSION['modif2']  == 1)

                ) {
                    echo "<td> 
                    
                    $date_env
 
                           <form action='update.php' method='post'   >
                                <input type='date' name='date_env_form' class='w-100' required     >
                            <br>
                                <input type='hidden' name='id_qst_form' value='$id_qst'>
                            <br>
                                <input type='submit' name='change_date_env_orale' class='btn btn-success p-1'  value='تعديل'>
                            </form>

                    </td>";
                } else {
                    echo "<td>  $date_env </td>";
                }


                echo " <td> $transfert </td>
                <td>  $taajil <hr> $taraf_taajil </td>
                ";


                if (!empty($key['mashob'])) {
                    echo "<td> <span class='badge bg-danger text-white' >   سؤال مسحوب  <span> </td>";
                } else {
                    echo "<td> <span class='badge bg-success text-white' >  لم يتم السحب  </span>  </td>";
                }



                if (
                    isset($_SESSION['admin_connected'], $_SESSION['super_admin'])
                    &&    $_SESSION['admin_connected'] === "yes"
                    &&  $_SESSION['super_admin'] == 1

                ) {
                    if (!empty($date_rep)  && $date_rep != "ليس بعد") {
                        echo "<td> 
                        $date_rep 
                        
                           <form action='update.php' method='post'   >
                                <input type='date' name='date_rep_form' class='w-100' required     >
                            <br>
                                <input type='hidden' name='id_qst_form' value='$id_qst'>
                            <br>
                                <input type='submit' name='change_date_rep_chafawi' class='btn btn-success p-1'  value='تعديل'>
                            </form>
                        </td> ";
                    } else {
                        echo "<td>   
                        
                         ليس بعد <br> <br>

                            <form action='update.php' method='post' >
                                <input type='date' name='date_rep_form' class='w-100' required     >
                            <br>
                                <input type='hidden' name='id_qst_form' value='$id_qst'>
                            <br>
                                <input type='submit' name='change_date_rep_chafawi' class='btn btn-success p-1'  value='إضافة'>
                            </form>
                    
                        </td> ";
                    }


                    if (!empty($key['fichier_rep'])) {
                        $fichier_rep = $key['fichier_rep'];
                        echo " <td>  <a href='$fichier_rep' target='_blank' > Youtube </a>  </td> ";
                    } else {
                        $fichier_rep =  "ليس بعد <br> <br>
                       <form action='update.php' method='post' >
                        <input type='hidden' name='id_qst_form' value='$id_qst'>
                        <input type='hidden' name='type_qst_form' value='b'>
                         <input type='url' name='youtube_link' class='w-100' required > <br> <br>
                          <input type='submit' name='add_link' class='btn btn-success p-1'  value='اضافة الرابط'>
                         </form>
                    ";
                        echo  "<td>  $fichier_rep </td> ";
                    }
                } else {
                    echo "<td> $date_rep </td> ";
                    if (!empty($key['fichier_rep'])) {
                        $fichier_rep = $key['fichier_rep'];
                        echo " <td>  <a href='$fichier_rep'  target='_blank'  > Youtube </a>  </td> ";
                    } else {
                        $fichier_rep =  "ليس بعد";
                        echo  "<td>  $fichier_rep </td> ";
                    }
                }


                echo " 
                        <td>  
                            <a href='modifications.php?idqst=$id_qst' target='_blank'  >  
                                <i class='far fa-edit'></i>  
                            </a> 
                                <br><br> 
                            ";
                if (
                    isset($_SESSION['admin_connected'], $_SESSION['super_admin'])
                    &&    $_SESSION['admin_connected'] === "yes"
                    &&  $_SESSION['super_admin'] == 1

                ) {
                    echo "   <a href='sup.php?id_qst=$id_qst' style='color:red' >  
                                <i class='fas fa-trash'></i>  
                            </a> ";
                }

                $sql = "SELECT  datediff ( now() , date_env ) as diff_date   FROM questions 
                        where    questions.id_qst = ?
                        and  questions.id_qst not in ( select id_qst from repenses where  id_qst = ? )  ";

                $get_date_diff  =  $this->cnxt_to_db()->prepare($sql);

                $get_date_diff->execute([$id_qst, $id_qst]);
                $row = $get_date_diff->rowCount();

                foreach ($get_date_diff as $key) {
                    $diff_date =  $key['diff_date'];
                }

                if (isset($diff_date) && $diff_date != NULL && $diff_date > 30) {
                    echo " <br> <br>  <i class='fas fa-bell'  style='color:red;' ></i>  
                     <span class='badge badge-danger ' > 30 </span>  يوم  
                    
                    ";
                }

                echo "  </td>
                </tr> ";
            }


            echo "</tbody> 
        </table>";
        } else {
            echo "  <div class='alert alert-warning text-center  container '> 
                 لا يوجد أي سؤال شفوي بعد
                </div> ";
        }
    }


    public function get_ecrits_qst()
    {


        $sql = "SELECT  count(id_qst) as total from questions 
        INNER JOIN sessions on sessions.id_session = questions.id_session 
        where  type_qst = 'a' and etat_session = 1  ";

        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute();
        $row = $exec->rowCount();

        if ($row > 0) {
            foreach ($exec as $key) {
                $ids =  $key['total'];
            }
        }


        $qst_par_page = 50;
        $nb_page =  ceil($ids / $qst_par_page);
        if (
            isset($_GET['page'])  && !empty(trim($_GET['page']))
            && filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT)
            &&
            $_GET['page'] <= $nb_page

        ) {
            $page =  htmlspecialchars($_GET['page']);
        } else {
            $page = 1;
        }

        $debut = ($page - 1) * $qst_par_page;


        $sql = "SELECT questions.id_qst , questions.id_dep , talkhis , groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , sujet_qst , transfert , molahada_one , molahada_two , mashob , etat_qst , date_eng ,date_reunion , date_env , date_rep  , fichier_rep , fichier_qst , num_qst , type_qst , date_resume
        
        FROM  questions  
        INNER JOIN deputes on deputes.id_dep = questions.id_dep 
        INNER JOIN sessions on sessions.id_session = questions.id_session 
        INNER JOIN ministeres on ministeres.id_m = questions.id_m 
        INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
        INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
        left JOIN repenses on repenses.id_qst = questions.id_qst
        where  type_qst = 'a' and etat_session = 1 order by num_qst  desc limit  $debut , $qst_par_page  ";

        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute();
        $row = $exec->rowCount();
        if ($row  > 0) {

            echo "  <div class='text-right mb-3' >
            الصفحات:
            ";

            for ($i = 1; $i <= $nb_page; $i++) {
                if ($i != $page) {
                    echo " <span class='span_page' >   <a href='?page=$i' class='a_page'  > $i   </a>  </span>   ";
                } else {
                    echo " <span class='span_page' style='background:gray;'  > $i </span>   ";
                }
            }


            echo "
            </div>
                <table class='table table-striped table-bordered  text-center '>
            <thead>
                <tr>
                    <th scope='col'> # </th>
                    <th scope='col'>تاريخ الايداع</th>
                    <th scope='col'>صاحب السؤال</th>
                    <th scope='col'>الوزارة</th>
                    <th scope='col'>السؤال</th>
                    <th scope='col'  style='min-width:250px' >الموضوع</th>
                    <th scope='col'>التلخيص</th>

                    <th scope='col'>  
                      تاريخ                      
                     <br>
              التلخيص                       
                    </th>
                     
                    <th scope='col'>ملاحظة 1</th>
                    <th scope='col'>ت.إ.المكتب</th>
                    <th scope='col'> قرار المكتب  </th>
                    <th scope='col'>  ملاحظة 2</th>
                    <th scope='col'> ت.إ.الحكومة</th>
                    <th scope='col'> السحب </th>
                    <th scope='col'> ت . الجواب</th>
                    <th scope='col'>الجواب</th>
                    <th scope='col'>تعديل</th>
                </tr>
            </thead>
            <tbody>";

            // id_qst	sujet_qst	text_qst	type_qst	etat_qst	fichier_qst	date_eng	date_env	molahada_one	molahada_two	transfert	id_m	id_ad	id_dep	

            foreach ($exec as $key) {

                $id_qst = $key['id_qst'];
                $sujet_qst = $key['sujet_qst'];
                $type_qst = $key['type_qst'];
                $etat_qst = $key['etat_qst'];
                $num_qst = $key['num_qst'];
                $fichier_qst = $key['fichier_qst'];

                $date_resume = $key['date_resume'];


                 

                switch ($etat_qst) {
                    case 'a':
                        $etat_qst = 'لم يعالج بعد';
                        break;
                    case 'r':
                        $etat_qst = '<span class="badge bg-danger text-light" > مرفوض </span>';
                        break;
                    case 'c':
                        $etat_qst = '<span class="badge bg-success text-light" > مقبول </span>';
                        break;
                    default:
                        $etat_qst = 'لم يعالج بعد';
                        break;
                }

                $date_eng = $key['date_eng'];

                if (!empty($key['date_env'])) {
                    $date_env = $key['date_env'];
                } else {
                    $date_env =  "ليس بعد";
                }
                if (!empty($key['date_reunion'])) {
                    $date_reunion = $key['date_reunion'];
                } else {
                    $date_reunion =  "ليس بعد";
                }

                if (!empty($key['molahada_one'])) {
                    $molahada_one = $key['molahada_one'];
                } else {
                    $molahada_one =  "لا يوجد";
                }

                if (!empty($key['molahada_two'])) {
                    $molahada_two = $key['molahada_two'];
                } else {
                    $molahada_two =  "لا يوجد";
                }


                if (!empty($key['talkhis'])) {
                    // $talkhis = $key['talkhis'];
                    $talkhis = " <a href='modifications.php?idqst=$id_qst' target='_blank' > التلخيص </a> ";
                } else {
                    $talkhis =  "لم يلخص بعد";
                }

                if (!empty($key['date_rep'])) {
                    $date_rep = $key['date_rep'];
                } else {
                    $date_rep =  "ليس بعد";
                }

               if (!empty($key['date_resume'])) {
                    $date_resume = $key['date_resume'];
                } else {
                    $date_resume =  "ليس بعد";
                }


                $nom_w = $key['nom_w'];

                $nom_m = $key['nom_m'];
                $nom_g = $key['nom_g'];
                // $id_dep = $key['id_dep'];
                $nom = $key['nom'] . ' ' . $key['pnom'];

                echo " 
                 <tr>
                    <th scope='row'> $num_qst </th>
                    <td> 
                    
                        $date_eng
                        <form action='update.php' method='post'   >
                            <input type='date' name='date_eng_form' class='w-100' required     >
                            <br>
                            <input type='hidden' name='id_qst_form' value='$id_qst'>
                            <br>
                            <input type='submit' name='change_date_eng_ecrit' class='btn btn-success p-1'  value='تعديل'>
                        </form>

                    </td>

                    <td>  
                        - <b> $nom </b>  .  <br> 
                        - $nom_g .   <br> 
                        - $nom_w .  
                     </td>
                    <td> $nom_m  </td>
                    <td> <a href='$fichier_qst'  target='_blank'>   PDF </a>  </td>
                    <td>  $sujet_qst </td>
                    <td>  $talkhis </td>
                    <td>  $date_resume </td>
                    <td> $molahada_one  </td>";

                if (

                    (isset($_SESSION['admin_connected'])  &&  $_SESSION['admin_connected'] === "yes")
                    && (isset($_SESSION['super_admin']) || isset($_SESSION['modif2']))
                    && ($_SESSION['super_admin'] == 1 || $_SESSION['modif2']  == 1)

                ) {
                    echo "<td> 
                    
                    $date_reunion
 
                           <form action='update.php' method='post'   >
                                <input type='date' name='date_reunion_form' class='w-100' required     >
                            <br>
                                <input type='hidden' name='id_qst_form' value='$id_qst'>
                            <br>
                                <input type='submit' name='change_date_reunion' class='btn btn-success p-1'  value='تعديل'>
                            </form>

                    </td>";
                } else {
                    echo "<td>  $date_reunion </td>";
                }

                echo "<td> $etat_qst </td>
                    <td> $molahada_two</td>";

                if (

                    (isset($_SESSION['admin_connected'])  &&  $_SESSION['admin_connected'] === "yes")
                    && (isset($_SESSION['super_admin']) || isset($_SESSION['modif2']))
                    && ($_SESSION['super_admin'] == 1 || $_SESSION['modif2']  == 1)

                ) {
                    echo "<td> 
                    
                    $date_env
 
                           <form action='update.php' method='post'   >
                                <input type='date' name='date_env_form' class='w-100' required     >
                            <br>
                                <input type='hidden' name='id_qst_form' value='$id_qst'>
                            <br>
                                <input type='submit' name='change_date_env' class='btn btn-success p-1'  value='تعديل'>
                            </form>

                    </td>";
                } else {
                    echo "<td>  $date_env </td>";
                }



                if (!empty($key['mashob'])) {

                    echo "<td>  <span class='badge bg-danger text-white' > سؤال مسحوب  </span>  </td>";
                } else {

                    echo "<td> <span class='badge bg-success text-white' > لم يتم السحب  </span>  </td>";
                }


                if (
                    isset($_SESSION['admin_connected'], $_SESSION['super_admin'])
                    &&    $_SESSION['admin_connected'] === "yes"
                    &&  $_SESSION['super_admin'] == 1

                ) {
                    if (!empty($date_rep)  && $date_rep != "ليس بعد") {
                        echo "<td> 
                        $date_rep 
                        
                           <form action='update.php' method='post'   >
                                <input type='date' name='date_rep_form' class='w-100' required     >
                            <br>
                                <input type='hidden' name='id_qst_form' value='$id_qst'>
                            <br>
                                <input type='submit' name='change_date_rep' class='btn btn-success p-1'  value='تعديل'>
                            </form>
                        </td> ";
                    } else {
                        echo "<td>   
                        
                            ليس بعد <br> <br>                           

                            <form action='update.php' method='post'   >
                                <input type='date' name='date_rep_form' class='w-100' required     >
                            <br>
                                <input type='hidden' name='id_qst_form' value='$id_qst'>
                            <br>
                                <input type='submit' name='change_date_rep' class='btn btn-success p-1'  value='إضافة'>
                            </form>
                    
                        </td> ";
                    }


                    if (!empty($key['fichier_rep'])) {
                        $fichier_rep = $key['fichier_rep'];
                        echo " <td>  <a href='$fichier_rep' target='_blank' > PDF </a>  </td> ";
                    } else {
                        $fichier_rep =  "ليس بعد <br> <br>
                    <form action='update.php' method='post'  enctype='multipart/form-data' >
                        <input type='file' name='file_rep_form' class='w-100' required  accept='.pdf,.PDF'  >
                    <br>
                        <input type='hidden' name='id_qst_form' value='$id_qst'>
                        <input type='hidden' name='type_qst_form' value='$type_qst'>
                    <br>
                        <input type='submit' name='add_rep_form' class='btn btn-success p-1'  value='إضافة'>
                    </form>
                    ";
                        echo  "<td>  $fichier_rep </td> ";
                    }
                } else {
                    echo "<td> $date_rep </td> ";
                    if (!empty($key['fichier_rep'])) {
                        $fichier_rep = $key['fichier_rep'];
                        echo " <td>  <a href='$fichier_rep'  target='_blank'  > PDF </a>  </td> ";
                    } else {
                        $fichier_rep =  "ليس بعد";
                        echo  "<td>  $fichier_rep </td> ";
                    }
                }

                echo "
                    <td> 
                     <a href='modifications.php?idqst=$id_qst'  target='_blank' >  <i class='far fa-edit'></i>  </a> 
                                                 <br> <br> ";
                if (
                    isset($_SESSION['admin_connected'], $_SESSION['super_admin'])
                    &&    $_SESSION['admin_connected'] === "yes"
                    &&  $_SESSION['super_admin'] == 1

                ) {
                    echo "   <a href='sup.php?id_qst=$id_qst' style='color:red' >  
                                <i class='fas fa-trash'></i>  
                            </a> ";
                }

                $sql = "SELECT  datediff ( now() , date_env ) as diff_date    FROM questions 
                        where    questions.id_qst = ?
                        and  questions.id_qst not in ( select id_qst from repenses where  id_qst = ? )  ";

                $get_date_diff  =  $this->cnxt_to_db()->prepare($sql);

                $get_date_diff->execute([$id_qst, $id_qst]);
                 
                foreach ($get_date_diff as $key) {
                    $diff_date =  $key['diff_date'];
                    
                }

                if (isset($diff_date) && $diff_date != NULL && $diff_date > 30) {
                    echo " <br> <br>  <i class='fas fa-bell'  style='color:red;' ></i>  
                     <span class='badge badge-danger ' > 30 </span>  يوم  
                    
                    ";
                } 

                echo "  </td>
                </tr> ";
            }


            echo "</tbody> 
        </table>";
        } else {
            echo "  <div class='alert alert-warning text-center  container '> 
                 لا يوجد أي سؤال كتابي بعد
                </div> ";
        }
    }


    public function get_qst_info($id)
    {
        $id = htmlspecialchars($id);
        // Verify Id qst GET :
        $sql = "SELECT * from questions where id_qst = ? ";
        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$id]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "SELECT questions.id_qst , text_qst , questions.id_dep , talkhis , groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , mashob , sujet_qst , transfert , molahada_one , molahada_two , etat_qst , date_eng ,date_reunion ,date_env , type_qst  
            , date_rep , num_qst , fichier_rep , taajil , taraf_taajil
            FROM  questions  INNER JOIN deputes on deputes.id_dep = questions.id_dep 
        INNER JOIN ministeres on ministeres.id_m = questions.id_m 
        INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
        INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
        left JOIN repenses on repenses.id_qst = questions.id_qst
        where   questions.id_qst = ? ";
            $exec  =  $this->cnxt_to_db()->prepare($sql);

            $exec->execute([$id]);
            $row = $exec->rowCount();
            if ($row  === 1) {

                foreach ($exec as $key) {

                    $id_qst = $key['id_qst'];
                    $sujet_qst = $key['sujet_qst'];
                    $etat_qst = $key['etat_qst'];

                    $taajil = $key['taajil'];
                    $taraf_taajil = $key['taraf_taajil'];



                    switch ($taajil) {
                        case '0':
                            $taajil = 'لم يؤجل';
                            break;
                        case '1':
                            $taajil = 'قام بالتأجيل ';
                            break;

                        default:
                            $taajil = 'لم يؤجل';
                            break;
                    }


                    switch ($etat_qst) {
                        case 'a':
                            $etat_qst = 'لم يعالج بعد';
                            break;
                        case 'r':
                            $etat_qst = 'مرفوض';
                            break;
                        case 'c':
                            $etat_qst = 'مقبول';
                            break;
                        default:
                            $etat_qst = 'لم يعالج بعد';
                            break;
                    }



                    $date_eng = $key['date_eng'];
                    if (!empty($key['date_env'])) {
                        $date_env = $key['date_env'];
                    } else {
                        $date_env =  "ليس بعد";
                    }
                    if (!empty($key['date_reunion'])) {
                        $date_reunion = $key['date_reunion'];
                    } else {
                        $date_reunion =  "ليس بعد";
                    }

                    if (!empty($key['molahada_one'])) {
                        $molahada_one = $key['molahada_one'];
                    } else {
                        $molahada_one =  "لا يوجد";
                    }

                    if (!empty($key['molahada_two'])) {
                        $molahada_two = $key['molahada_two'];
                    } else {
                        $molahada_two =  "لا يوجد";
                    }


                    if (!empty($key['transfert'])) {
                        $transfert =  "نعم ";
                    } else {
                        $transfert =  " لا ";
                    }

                    if (!empty($key['talkhis'])) {
                        $talkhis = $key['talkhis'];
                    } else {
                        $talkhis =  "لم يلخص بعد";
                    }


                    if (!empty($key['mashob'])) {
                        $sahb = "نعم";
                    } else {
                        $sahb = "لا";
                    }

                    $nom_w = $key['nom_w'];

                    $type_trans = $key['type_qst'];

                    switch ($key['type_qst']) {
                        case 'a':
                            $type_qst = "كتابي";
                            break;
                        case 'b':
                            $type_qst = "شفوي";
                            break;
                        default:
                            $type_qst = "/";
                            break;
                    }

                    // $id_m = $key['id_m'];
                    $nom_m = $key['nom_m'];
                    $nom_g = $key['nom_g'];
                    // $id_dep = $key['id_dep'];
                    $nom = $key['nom'] . ' ' . $key['pnom'];
                    $num_qst = $key['num_qst'];


                    if (!empty($key['date_rep'])) {
                        $date_rep = $key['date_rep'];
                    } else {
                        $date_rep =  "ليس بعد";
                    }


                    $text_qst = $key['text_qst'];

                    echo "
                    <div class='all_quest mt-4' >
                        <table class='table table-bordered   text-center '>
                            <thead>
                                <tr class='table-secondary' >

               
                    <th scope='col'> رقم السؤال </th>
                    <th scope='col'>تاريخ الايداع</th>
                    <th scope='col'>صاحب السؤال</th>
                    <th scope='col'>الوزارة</th>
                    <th scope='col'> قرار المكتب  </th>
                    <th scope='col'>الملاحظة 1</th>
                    <th scope='col'>ت.إ.المكتب</th>
                    <th scope='col'>  الملاحظة 2</th>
                    <th scope='col'> ت.إ.الحكومة</th>";
                    if ($type_trans == 'b') {
                        echo "<th scope='col'>  هل قام بالتحويل </th>
                         <th scope='col'>التأجيل</th>
                        ";
                    }


                    echo " <th scope='col'> هل قام  بالسحب </th>
                    <th scope='col'> ت . الجواب</th>
                    <th scope='col'>الجواب</th>
                    <th scope='col'>طبيعة السؤال</th>
                
  
                </tr>
                    </thead>
                        <tbody>
                                <tr class='table-primary'>
                                    <td>$num_qst  </td>
                                    <td>$date_eng  </td>
                                    <td>
                                      <b>  $nom </b>  
                                         $nom_g  <br> <span  > ____ </span> <br>  $nom_w   
                                    </td>
                                    <td>$nom_m  </td>
                                    <td>$etat_qst  </td>
                                    <td>$molahada_one  </td>
                                    <td>$date_reunion  </td>
                                    <td>$molahada_two  </td>
                                    <td>$date_env  </td>";

                    if ($type_trans == 'b') {
                        echo "<td>$transfert  </td>
                                <td> 
                                    $taajil
                                    <hr>
                                    $taraf_taajil 
                                </td>
                  
                                ";
                    }

                    echo " 
                            <td>$sahb   </td>
                                <td>$date_rep  </td>";
                    if (!empty($key['fichier_rep'])) {
                        $fichier_rep = $key['fichier_rep'];
                        echo "<td> <a href='$fichier_rep' target='_blank' > الجواب </a>     </td>";
                    } else {
                        $fichier_rep =  "ليس بعد";
                        echo "<td>  $fichier_rep    </td>";
                    }

                    echo " 
                            <td> $type_qst  </td>
                        </tr>
                                
                            </tbody>
                        </table>
                        </div>
                    ";

                    echo " <hr>  <h5 class='text-center wow' > 
                         الموضوع : 
                         $sujet_qst
                         </h5> ";
                    echo  "<p style='font-size:13px;' class='text-right ' >$text_qst</p> <hr>";
                    echo " <h5 class='text-center wow' >      التلخيص:      </h5> ";
                    echo  "<p style='font-size:13px;' class='text-right ' >$talkhis</p> <hr>";
                }

                //  Donner le form pour ladmin 1
                if (
                    isset($_SESSION['admin_connected'], $_SESSION['modif1'])
                    &&    $_SESSION['admin_connected'] === "yes"
                    &&  $_SESSION['modif1'] == 1
                ) {
                    echo " <form method='POST'>";
                    if ($talkhis === "لم يلخص بعد") {
                        $talkhis = '';
                    }
                    if ($molahada_one === "لا يوجد" || $molahada_one == null) {
                        $molahada_one = '';
                    }
                    echo "
                            <div class='form-floating'>

                                <textarea name='update_talkhis' cols='30' rows='10' placeholder='التلخيص' 
                                class='form-control mb-3 border-secondary' required >$talkhis</textarea>

                                <textarea name='update_molahada_one' cols='90' rows='8' placeholder='الملاحظة 1' 
                                class='form-control mb-3 border-secondary' required>$molahada_one</textarea>


                            </div>
                    <center>
                        <input type='submit' value='تعديل' name='update_modif_one' class='btn btn-success mb-3'>
                    </center>
                            ";
                    echo "</form> <hr> ";
                }


                //  Donner le form pour ladmin 2 
                if (
                    isset($_SESSION['admin_connected'], $_SESSION['modif1'])
                    &&    $_SESSION['admin_connected'] === "yes"
                    &&  $_SESSION['modif2'] == 1
                ) {

                    echo "   
                    <center>
                        <ol class='list-group  list-group-numbered p-0 mt-5 mb-5  col-md-5 col-12 '>

                            <li class='list-group-item border-secondary d-flex justify-content-between align-items-start'>
                                <div class='ms-2 me-auto'>
                                    <b class='fw-bold'>   قرار المكتب   </b>
                                </div>
                                <a class='badge bg-success text-light rounded-pill p-2' 
                                href='update.php?id_etat=$id_qst&action=c'>القبول</a>
                                <a class='badge bg-danger text-light rounded-pill p-2' 
                                href='update.php?id_etat=$id_qst&action=r'>الرفض</a>
                            </li>


                            <li class='list-group-item border-secondary d-flex justify-content-between align-items-start'>
                                <div class='ms-2 me-auto'>
                                <b class='fw-bold'> السحب </b>
                                </div>
                                <a class='badge bg-success text-light rounded-pill p-2' 
                                href='update.php?id_sahb=$id_qst&action=0'> الغاء السحب</a>
                                <a class='badge bg-danger text-light rounded-pill p-2' 
                                href='update.php?id_sahb=$id_qst&action=1'> اسحب</a>
                            </li> ";

                    // ida kan chafawi
                    if ($type_trans == 'b') {
                        echo  "
                                <li class='list-group-item border-secondary d-flex justify-content-between align-items-start'>
                                    <div class='ms-2 me-auto'>
                                        <b class='fw-bold'>   التحويل </b>
                                    </div>
                                    <a class='badge bg-success text-light rounded-pill p-2' 
                                    href='update.php?tahwil=$id_qst&action=1'>التحويل</a>
                                    <a class='badge bg-danger text-light rounded-pill p-2' 
                                    href='update.php?tahwil=$id_qst&action=0'>  الغاء التحويل</a>
                                </li>


                                <li class='list-group-item border-secondary d-flex justify-content-between align-items-start'>
                                    <div class='ms-2 me-auto'>
                                        <b class='fw-bold'>   التاجيل </b>
                                    </div>
                                    <a class='badge bg-success text-light rounded-pill p-2' 
                                    href='update.php?taajil=$id_qst&action=1'>التاجيل</a>
                                    <a class='badge bg-danger text-light rounded-pill p-2' 
                                    href='update.php?taajil=$id_qst&action=0'>  الغاء التاجيل</a>

                                </li>

                                
                                <li class='list-group-item border-secondary d-flex justify-content-between align-items-start'>
                                    <div class='ms-2 me-auto'>
                                        <b class='fw-bold'>   طرف التاجيل </b>
                                    </div>
                                    <a class='badge bg-success text-light rounded-pill p-2' 
                                    href='update.php?taraf_taajil=$id_qst&action=1'>النائب </a>
                                    <a class='badge bg-danger text-light rounded-pill p-2' 
                                    href='update.php?taraf_taajil=$id_qst&action=0'>    الوزير</a>

                                </li>

                            ";
                    }
                    echo " </center> </ol> 
                    <hr> ";


                    echo " <form method='POST'>";
                    if ($talkhis === "لم يلخص بعد") {
                        $talkhis = '';
                    }
                    if ($molahada_two === "لا يوجد" || $molahada_two == null) {
                        $molahada_two = '';
                    }
                    echo "
 
                        <div class='form-row' >
                            <div class='form-group col-md-6 col-12 '>
                                <label class='w-100 text-center'> <i class='far fa-calendar-alt'></i>  
                                تاريخ اجتماع المكتب </label>
                            <input type='date' value='$date_reunion'  class='form-control ' required  name='update_date_reunion' > 
                            </div>
                            <div class='form-group col-md-6 col-12 '>
                                <label class='w-100 text-center'>  <i class='far fa-calendar-alt'></i>  تاريخ الارسال للحكومة </label>
                            <input type='date'  value='$date_env' class='form-control ' required  name='update_date_env' > 
                            </div>
                        </div>

                        <center>
                            <div class='form-floating'>
                            
                              <h3 class='text-center' >   الملاحظة 2 :  $molahada_two  </h3>
                                <hr>

                                <input type='radio'  name='update_molahada_two' value='تحفظ'  required  id='input1' >   
                                <label for='input1' >    تحفظ *  </label>  <br>

                                <input type='radio'  name='update_molahada_two' value='قضية شخصية'  id='input2'   >   
                                <label for='input2' > قضية شخصية *  </label>  <br>
    
                                <input type='radio'  name='update_molahada_two' value='قضية امام العدالة'   id='input3'   >   
                                <label for='input3' >   قضية امام العدالة *  </label> <br>

                                <input type='radio'  name='update_molahada_two' value='تم الرد اقل من 3 اشهر'  id='input4'    >   
                                <label for='input4' >  تم الرد اقل من 3 اشهر *   </label>  <br>

                                <input type='radio'  name='update_molahada_two' value='اعادة الصياغة'  id='input5'   >   
                                <label for='input5' >  اعادة الصياغة * </label> <br>

                                <input type='radio'  name='update_molahada_two' value='اعادة توجيه السؤال'  id='input6'     >   
                                <label for='input6' >   اعادة توجيه السؤال * </label> <br>

                                <input type='radio'  name='update_molahada_two' value='سبب آخر'  id='input7'   >   
                                <label for='input7' >   سبب آخر  * </label> 


                                </div>
                            </center>


                    <center>
                        <input type='submit' value='تعديل' name='update_modif_two' class='btn btn-success mb-3 mt-3'>
                    </center>
                            ";
                    echo "</form>";
                }
            }
        } else {
            echo  " 
            <div class='alert alert-danger  text-center' >  
                خطأ في رقم السؤال !  ربما قد تم حذفه 
                <br>
                او ليس متاح مؤقتا
            </div> ";
        }
    }


    public function update_modif_one($new_talkhis, $new_molahada_one, $id_qst)
    {
        $new_talkhis = htmlspecialchars($new_talkhis);
        $new_molahada_one = htmlspecialchars($new_molahada_one);
        $id_qst = htmlspecialchars($id_qst);

        // Verify Id qst GET :
        $sql = "SELECT id_qst , date_resume from questions where id_qst = ? ";
        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$id_qst]);
        foreach ($exec as $key ) {
            $date_resume = $key['date_resume'] ;
        }
        $row = $exec->rowCount();
        if ($row === 1) {
            // modification de : molahada 1 + talkhis
            if(    empty($date_resume ) ) {
                $sql = "UPDATE questions set  talkhis = ? , molahada_one = ?  , date_resume = now()  where id_qst = ? ";
            } else {
                $sql = "UPDATE questions set  talkhis = ? , molahada_one = ?    where id_qst = ? ";
            }
            
            $exec  =  $this->cnxt_to_db()->prepare($sql);

            $exec->execute([$new_talkhis, $new_molahada_one, $id_qst]);
            $row = $exec->rowCount();

            if ($row === 1) {

                $_SESSION['updated'] = "<div class='alert alert-success text-center ' > 
                تم التغيير بنجاح                 
                </div> ";
                // echo " <script> location.href='' </script> ";
            }
        } else {
            $_SESSION['updated'] = "<div class='alert alert-danger text-center ' > 
              خطأ في رقم السؤال
                </div> ";
        }
    }


    public function  update_modif_two($update_molahada_two, $update_date_reunion, $update_date_env, $id_qst)
    {

        $update_molahada_two = htmlspecialchars($update_molahada_two);
        $update_date_reunion = htmlspecialchars($update_date_reunion);
        $update_date_env = htmlspecialchars($update_date_env);
        $id_qst = htmlspecialchars($id_qst);

        // Verify Id qst GET :
        $sql = "SELECT id_qst from questions where id_qst = ? ";
        $exec  =  $this->cnxt_to_db()->prepare($sql);

        $exec->execute([$id_qst]);
        $row = $exec->rowCount();
        if ($row === 1) {

            // modification de : molahada 2 + les dates
            $sql = "UPDATE questions set  molahada_two = ? , date_reunion = ? , date_env = ?  where id_qst = ? ";
            $exec  =  $this->cnxt_to_db()->prepare($sql);

            $exec->execute([$update_molahada_two, $update_date_reunion, $update_date_env, $id_qst]);
            $row = $exec->rowCount();

            if ($row === 1) {

                $_SESSION['updated'] = "<div class='alert alert-success text-center ' > 
                تم التغيير بنجاح 
                </div> ";
            }
        } else {
            $_SESSION['updated'] = "<div class='alert alert-danger text-center ' > 
              خطأ في رقم السؤال
                </div> ";
        }
    }


}


$question = new question();
