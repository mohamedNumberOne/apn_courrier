<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> البحث</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    td {
        padding: 2px !important;
        font-size: 15px;
    }
    </style>


</head>

<body>


    <?php

    include('header.php');
    include('stat.class.php');

    ?>

    <h1 class="text-center m-3">
        <i class="fas fa-search icone_anim"></i>
        <span class="wow"> البحث </span>
    </h1>



    <div class='container'>

        <h4 class="text-right mt-5">
            <span class="wow"> برقم السؤال :</span>
        </h4>

        <?php



        $stat->get_form_serch1();



        ?>

    </div>

    <hr>

    <div class='container mt-5 '>

        <h4 class="text-right mt-5">
            <span class="wow"> بالكلمات المفتاحية : </span>
        </h4>


        <form method='post'>

            <input class="form-control    col-lg-6 col-12 " type="search" name="tagname_filtre" required>
            <center>
                <input type='submit' name='rech_motcle' value='ابحث' class='mt-5 btn btn-success'>
            </center>
        </form>

    </div>




    <hr>

    <div class='container mt-5 '>

        <h4 class="text-right mt-5">
            <span class="wow"> البحث المفصل : </span>
        </h4>

        <?php

        $stat->get_form_detail();

        ?>



    </div>


    <div class=" container ">

        <?php

        // rech_num

        if (isset($_POST['rech_num'])) {
            if (isset(
                $_POST['num_qst_filtre'],
                $_POST['select_session_filtre_num'],
                $_POST['select_type_filtre']
            )) {
                $stat->cherche_question_bnum(
                    $_POST['num_qst_filtre'],
                    $_POST['select_session_filtre_num'],
                    $_POST['select_type_filtre']
                );
            } else {
                echo " <div class='alert alert-warning' >  املا جميع الفراغات </div> ";
            }
        }

        // _____ 

        // rech mot cle 


        if (isset($_POST['rech_motcle'])) {

            if (
                isset($_POST['tagname_filtre'])
                && !empty(trim($_POST['tagname_filtre']))
            ) {
                $stat->cherche_question_motcle($_POST['tagname_filtre']);
            } else {
                echo "  <div class='alert alert-warning text-center container ' >  
                    ادخل  كلمة على الأ قل  
                </div> ";
            }
        }


        // rech detail : 


        if (isset($_POST['rech_detail'])) {

            if (

                isset($_POST['type_qst']) 
                
                &&( $_POST['type_qst'] == "a" || $_POST['type_qst'] == "b")
               
            ) {
                
                $type  =  htmlspecialchars($_POST['type_qst']);
                $link = "";
                $sql_get_detail = "SELECT   groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , talkhis  , molahada_one   ,   num_qst , date( date_eng ) as date_eng  , taajil , taraf_taajil   , type_qst , questions.id_qst , questions.date_env , 
                repenses.date_rep 
                FROM  questions  INNER JOIN deputes on deputes.id_dep = questions.id_dep 
                INNER JOIN ministeres on ministeres.id_m = questions.id_m 
                INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
                INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
                LEFT JOIN repenses on repenses.id_qst = questions.id_qst  
                INNER JOIN sessions on sessions.id_session = questions.id_session

                where type_qst = '$type'     and  etat_session = 1  ";

                if( 
                    isset( $_POST['min'] ) && !empty($_POST['min'])  
                    && isset($_POST['ila']) && !empty($_POST['ila'])  
                
                ) 
                {
                    
                    $date_min = $_POST['min'];
                    $date_ila = $_POST['ila'];
                    $link = "date_min=$date_min&date_ila=$date_ila";
                    $sql_2date  =" and ( date_eng >= '$date_min' and date_eng <= '$date_ila') " ;
                    $sql_get_detail = $sql_get_detail . $sql_2date;
                    
                }else if ( !empty($_POST['min'])  &&  empty($_POST['ila'] ) ) {
                    
                    $date_min = $_POST['min'];
                    $link .= "&date_min=$date_min";
                    $sql_date_min = " and date_eng >= '$date_min' ";
                    $sql_get_detail = $sql_get_detail . $sql_date_min;
                }

                else if (!empty($_POST['ila']) &&  empty($_POST['min'])  ) {
                    
                    $date_ila = $_POST['ila'];
                    $link .= "&date_ila=$date_ila";
                    $sql_date_ila = " and date_eng <= '$date_ila' ";
                    $sql_get_detail = $sql_get_detail . $sql_date_ila;
                }
 

                if (!empty($_POST['id_ministere'])) {
                    $id_ministere = $_POST['id_ministere'];
                    $link .= "&id_ministere=$id_ministere";
                    $sql_id_ministere = " and ministeres.id_m =  '$id_ministere' ";
                    $sql_get_detail = $sql_get_detail . $sql_id_ministere;
                }

                if (!empty($_POST['deputes'])) {
                    $deputes = $_POST['deputes'];
                    $link .= "&deputes=$deputes";
                    $sql_deputes = " and deputes.id_dep =  '$deputes' ";
                    $sql_get_detail = $sql_get_detail . $sql_deputes;
                }

                if (!empty($_POST['mashoba'])) {
                    $mashoba = $_POST['mashoba'];
                    switch ($mashoba) {
                        case 'yes':
                            $mashoba = 1 ;
                            break;
                        case 'no':    
                            $mashoba = 0;
                            break;
                        default:
                            $mashoba = 0;
                            break;
                    }
                    
                    $sql_mashoba = " and mashob =  '$mashoba' ";
                    $link .= "&mashoba=$mashoba";
                    $sql_get_detail = $sql_get_detail . $sql_mashoba;
                }

                if (!empty($_POST['accepted'])) {
                    $accepted = $_POST['accepted'];
                    switch ($accepted) {
                        case 'yes': $accepted =  'c' ;   break;
                        case 'no':  $accepted = 'r'; break;

                        default:
                            $accepted = 'a';
                            break;
                    }
                    $link .= "&accepted=$accepted";
                    $sql_accepted = " and etat_qst =  '$accepted' ";
                    $sql_get_detail = $sql_get_detail . $sql_accepted;
                }

                if (!empty($_POST['moaajala'])) {
                    $moaajala = $_POST['moaajala'];
                    switch ($moaajala) {
                        case 'yes':
                            $moaajala = 1;
                            break;
                        case 'no':
                            $moaajala = 0;
                            break;
                        default:
                            $moaajala = 0;
                            break;
                    }

                    $link .= "&moaajala=$moaajala";
                    $sql_moaajala = " and taajil =  '$moaajala' ";
                    $sql_get_detail = $sql_get_detail . $sql_moaajala;
                }


                // modification 

                    
                if (!empty($_POST['rep'])) {
                    $rep = $_POST['rep'];
                     
                    if( $rep == 'yes' ) {
                        $rep =  " is not NULL " ;
                    }else {
                        $rep =  " is  NULL  " ;
                    }

                    $link .= "&rep=$rep";
                    $sql_rep = " and repenses.fichier_rep ". $rep ;
                    $sql_get_detail = $sql_get_detail . $sql_rep;
                    // echo $sql_get_detail ;
                }

                // INNER JOIN repenses on repenses.id_qst = questions.id_qst 

                
                 
                if (!empty($_POST['transfert'])) {
                    $transfert = $_POST['transfert'];
                    switch ($transfert) {
                        case 'yes':
                            $transfert = 1 ;
                            break;
                            case 'no':
                                $transfert = 0 ;
                                break;
                        default:
                        $transfert = 1 ;
                            break;
                    }
                   
                    $link .= "&transfert=$transfert";
                    $sql_transfert = " and transfert = '$transfert' ";
                    $sql_get_detail = $sql_get_detail . $sql_transfert;
                }

                //  fin modif


                $sql_get_detail = $sql_get_detail . " group by num_qst desc " ;

                 $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
                
                $get_details = $cnx ->prepare($sql_get_detail);
                $get_details->execute();

                $row = $get_details->rowCount();
                if ($row  > 0) {
                    echo '' ;
                    if( ! empty( trim( $link ) ) ) {
                        if ($link[0] == "&") {
                            $link = substr($link, 1, (strlen($link)));
                        }
                    }

                echo " 
                <hr>  <span class='badge badge-success' >  $row   </span>  <hr>
                    <a href='imprimer.php?dettail=rech&type_qst=$type&$link'
                        class='btn btn-success float-right mb-2' >  
                        <i class='fas fa-download'></i>  تحميل   
                    </a>

                <table class='table table-striped table-bordered  text-center container '   >
                    <thead>
                        <tr>
                            <th scope='col'> الرقم </th>
                            <th scope='col'> تاريخ الايداع</th>
                            <th scope='col'>صاحب السؤال</th>

                            <th scope='col'> 
                                    عضو الحكومة
                                    <br>
                                    الموجه إليه السؤال                    
                            </th>

                            <th scope='col'>الموضوع</th>
                            
                            <th scope='col'>  الملاحظات </th> 
                            <th scope='col'>  تاريخ الارسال </th> 
                            <th scope='col'>  تاريخ الجواب </th> 

                        </tr>
                    </thead>
                    <tbody>";
                    foreach ($get_details as $key) {

                        $nom_g = $key['nom_g'];
                        $nom = $key['nom'];
                        $pnom = $key['pnom'];
                        $nom_w = $key['nom_w'];
                        $nom_m = $key['nom_m'];
                        $num_qst = $key['num_qst'];
                        $date_eng = $key['date_eng'];
                        $date_env = $key['date_env'];
                        $date_rep = $key['date_rep'];
                        $talkhis = $key['talkhis'];
                        $molahada_one = $key['molahada_one'];
                        $type_qst = $key['type_qst'];
                        $id_qst = $key['id_qst'];

                        $taajil =  $key['taajil'];
                        $taraf_taajil =  $key['taraf_taajil'];


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


                        switch ($type_qst) {
                            case 'a':
                                $type_qst = "كتابي";
                                break;
                            case 'b':
                                $type_qst =  "شفوي";
                                break;


                            default:
                                $type_qst =  "/";
                                break;
                        }


                        echo " 
               
                <tr>
                    <td> 
                        <a href='modifications.php?idqst=$id_qst' target='_blank' >$num_qst </a>  
                        <br> $type_qst 
                    </td>
                    <td style='max-width: 100px !important ; width:100px ' > $date_eng  </td>
                    <td>  <b> $nom  $pnom </b>  <hr>  $nom_g <hr> $nom_w  </td>
                    <td style=' width:200px;' > $nom_m  </td>
                    <td style='min-width:200px;' > $talkhis  </td>
                       
                    <td style='min-width:100px;' > $molahada_one  </td>
                    <td style='min-width:80px;' > $date_env  </td>
                    <td style='min-width:80px;' > $date_rep </td>
                    
                </tr>
                ";
                }
                    echo "</tbody> 
                    </table> ";
                } else {
                        echo "  <div class='alert alert-warning text-center container ' >  
                            لم يتم ايجاد اي سؤال 
                        </div> ";
                    }

            } 


            }  
       
        

        ?>

    </div>



    <script src="bootstrap/jquery.js"></script>
    <script src="bootstrap/bootstrap.js"></script>

</body>

</html>