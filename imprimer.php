<meta charset="UTF-8">



<?php

// num

if (isset($_GET['num_qst'], $_GET['id_session'], $_GET['type'])) {

    $num_qst = htmlspecialchars($_GET['num_qst']);
    $id_session = htmlspecialchars($_GET['id_session']);
    $type = htmlspecialchars($_GET['type']);

    require_once __DIR__ . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf(["mode" => "utf-8", "format" => "A4-L"]);

    $mpdf->autoScriptToLang = true;

    $mpdf->autoLangToFont = true;

    $stylesheet = file_get_contents('bootstrap/bootstrap.css');
    $stylesheet = file_get_contents('css/style_pdf.css');


    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);


    try {



        $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
        
 

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = " SELECT   groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , talkhis  , molahada_one   ,   num_qst , date( date_eng ) as date_eng  , taajil , taraf_taajil   , type_qst
        FROM  questions  INNER JOIN deputes on deputes.id_dep = questions.id_dep 
        INNER JOIN ministeres on ministeres.id_m = questions.id_m 
        INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
        INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
        
        where num_qst = ? and id_session = ? and type_qst = ?  ";

        $exec = $cnx->prepare($sql);

        $exec->execute([$num_qst, $id_session, $type]);

        $row = $exec->rowCount();

        if ($row > 0) {

            $tab = "";

            foreach ($exec as $key) {

                $nom_g = $key['nom_g'];
                $nom = $key['nom'];
                $pnom = $key['pnom'];
                $nom_w = $key['nom_w'];
                $nom_m = $key['nom_m'];
                $num_qst = $key['num_qst'];
                $date_eng = $key['date_eng'];
                $talkhis = $key['talkhis'];
                $molahada_one = $key['molahada_one'];
                $taajil = $key['taajil'];
                $taraf_taajil = $key['taraf_taajil'];
                $type_qst = $key['type_qst'];


                switch ($type_qst) {
                    case 'b':
                        $type_qst = "   شفوي ";
                        break;
                    case 'a':
                        $type_qst =  "    كتابي   ";
                        break;

                    default:
                        'كتابي';
                        break;
                }

                switch ($taajil) {
                    case '1':
                        $taajil = "   قام بالتأجيل  ";
                        break;
                    case '0':
                        $taajil =  "    لم يؤجل     ";
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


                $tab .=

                    "
                <tr>
                    
                    <td class='talkhis' > $molahada_one  </td>
                     
                   
                    <td class='talkhis' > $talkhis  </td>
                   
                    <td > $nom_m  </td>
                    <td>  
                        $nom  $pnom    <hr>  $nom_g <hr> $nom_w  
                    </td>
                    <td  > $date_eng  </td>
                    <td> $num_qst  <br> $type_qst </td>
                </tr>

                ";
            }



            $tab .= "

             </tbody>

            </table>";
        } else {

            echo "

        <div class='alert-warning alert mt-5 text-center' >

           لم يتم ايجاد اي سؤال 

        </div>";
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }


    $html = " 
 
        <h1 class='text-center' > 
        
            قائمة الاسئلة  

        </h1>

    <table lang='ar'  >

    <thead>

         <tr>
            
            <td scope='col'>  الملاحظات </td>
            
            <td scope='col'>الموضوع</td>
            <td scope='col'> 
                      عضو الحكومة
                    <br>
                    الموجه إليه السؤال                    
             </td>
              <td scope='col'>صاحب السؤال</td>
               <td scope='col'   >تاريخ الايداع</td>
              <td scope='col'> الرقم </td>
         </tr>

    </thead>

    <tbody> " . $tab;



    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
    $name = date("Y/m/d H:i:s") . ".pdf";
    $mpdf->Output($name, "D");

}




// mot clé 

else if (isset($_GET['mot_cle'])) {

 

    $mot_cle = htmlspecialchars($_GET['mot_cle']);

    require_once __DIR__ . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf(["mode" => "utf-8", "format" => "A4-L"]);

    $mpdf->autoScriptToLang = true;

    $mpdf->autoLangToFont = true;

    $stylesheet = file_get_contents('bootstrap/bootstrap.css');
    $stylesheet = file_get_contents('css/style_pdf.css');

    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);


    try {

       

         $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));

       

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_qst ,  groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , talkhis  , molahada_one   ,   num_qst , date( date_eng ) as date_eng  , type_qst    , taajil , taraf_taajil   
            FROM  questions  
            INNER JOIN deputes on deputes.id_dep = questions.id_dep 
            INNER JOIN ministeres on ministeres.id_m = questions.id_m 
            INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
            INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
            INNER JOIN sessions on sessions.id_session = questions.id_session
        
            where text_qst like ? and etat_session = 1   order by num_qst desc   ";

        $exec = $cnx->prepare($sql);

        $exec->execute(['%' . $mot_cle . '%']);

        $row = $exec->rowCount();

        if ($row > 0) {

            $tab = "";

            foreach ($exec as $key) {

                $nom_g = $key['nom_g'];
                $nom = $key['nom'];
                $pnom = $key['pnom'];
                $nom_w = $key['nom_w'];
                $nom_m = $key['nom_m'];
                $num_qst = $key['num_qst'];
                $date_eng = $key['date_eng'];
                $talkhis = $key['talkhis'];
                $molahada_one = $key['molahada_one'];
                $taajil = $key['taajil'];
                $taraf_taajil = $key['taraf_taajil'];
                $type_qst = $key['type_qst'];


                switch ($type_qst) {
                    case 'b':
                        $type_qst = "   شفوي ";
                        break;
                    case 'a':
                        $type_qst =  "    كتابي   ";
                        break;

                    default:
                        'كتابي';
                        break;
                }


                switch ($taajil) {
                    case '1':
                        $taajil = "   قام بالتأجيل  ";
                        break;
                    case '0':
                        $taajil =  "    لم يؤجل     ";
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


                $tab .=

                    "
                <tr>
                    
                    <td class='talkhis' > $molahada_one  </td>
                     
                   
                    <td class='talkhis' > $talkhis  </td>
                   
                    <td > $nom_m  </td>
                    <td>  
                        $nom  $pnom    <hr>  $nom_g <hr> $nom_w  
                    </td>
                    <td  > $date_eng  </td>
                    <td> $num_qst <br> $type_qst  </td>
                </tr>

                ";
            }



            $tab .= "

             </tbody>

            </table>";
        } else {

            echo "
            <div class='alert-warning alert mt-5 text-center' >

                لم يتم ايجاد اي سؤال 

            </div>";
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }




    $html = " 
 
        <h1 class='text-center' > 
        
            قائمة الاسئلة  

        </h1>

    <table lang='ar'  >

    <thead>

         <tr>
            
            <td scope='col'>  الملاحظات </td>
            
            <td scope='col'>الموضوع</td>
            <td scope='col'> 
                      عضو الحكومة
                    <br>
                    الموجه إليه السؤال                    
             </td>
              <td scope='col'>صاحب السؤال</td>
               <td scope='col'   >تاريخ الايداع</td>
              <td scope='col'> الرقم </td>
         </tr>

    </thead>

    <tbody> " . $tab;



    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

    $name = date("Y/m/d H:i:s") . ".pdf";
    $mpdf->Output($name, "D");

 

}




// details 

else if (
    isset($_GET['dettail'], $_GET['type_qst'])
    && $_GET['dettail'] == 'rech'
    && ($_GET['type_qst'] == 'a' ||  $_GET['type_qst'] == 'b')

) {

    $type =  htmlspecialchars($_GET['type_qst']);



    require_once __DIR__ . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf(["mode" => "utf-8", "format" => "A4-L"]);

    $mpdf->autoScriptToLang = true;

    $mpdf->autoLangToFont = true;

    $stylesheet = file_get_contents('bootstrap/bootstrap.css');
    $stylesheet = file_get_contents('css/style_pdf.css');

    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);


    try {


        $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
       

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // $sql_get_detail =   " SELECT   groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m   , talkhis  , molahada_one   ,   num_qst , date( date_eng ) as date_eng  , taajil , 
        //         taraf_taajil   , type_qst , questions.id_qst , date_env
        //         FROM  questions  INNER JOIN deputes on deputes.id_dep = questions.id_dep 
        //         INNER JOIN ministeres on ministeres.id_m = questions.id_m 
        //         INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
        //         INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
        //         INNER JOIN sessions on sessions.id_session = questions.id_session

        //         where type_qst = ?     and  etat_session = 1 
        // ";

        // 

        $sql_get_detail = "SELECT   groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , talkhis  , molahada_one   ,   num_qst , date( date_eng ) as date_eng  , taajil , taraf_taajil   , type_qst , questions.id_qst , questions.date_env , 
        repenses.date_rep 
        FROM  questions  INNER JOIN deputes on deputes.id_dep = questions.id_dep 
        INNER JOIN ministeres on ministeres.id_m = questions.id_m 
        INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
        INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
        LEFT JOIN repenses on repenses.id_qst = questions.id_qst  
        INNER JOIN sessions on sessions.id_session = questions.id_session

        where type_qst = ?    and  etat_session = 1  ";

        // date min ila 
         
        if (

            isset($_GET['date_min']) && !empty($_GET['date_min'])
            && isset($_GET['date_ila']) && !empty($_GET['date_ila'])

        ) {
            $date_min = $_GET['date_min'];
            $date_ila = $_GET['date_ila'];

            $sql_2date  = " and ( date_eng >= '$date_min' and date_eng <= '$date_ila') ";
            $sql_get_detail = $sql_get_detail . $sql_2date;
        } else if (!empty($_GET['date_min'])  &&  empty($_GET['date_ila'])) {

            $date_min = $_GET['date_min'];

            $sql_date_min = " and date_eng >= '$date_min' ";
            $sql_get_detail = $sql_get_detail . $sql_date_min;
        } else if (!empty($_GET['date_ila']) &&  empty($_GET['date_min'])) {

            $date_ila = $_GET['date_ila'];

            $sql_date_ila = " and date_eng <= '$date_ila' ";
            $sql_get_detail = $sql_get_detail . $sql_date_ila;
        }


        if (!empty($_GET['id_ministere'])) {
            $id_ministere = $_GET['id_ministere'];

            $sql_id_ministere = " and ministeres.id_m =  '$id_ministere' ";
            $sql_get_detail = $sql_get_detail . $sql_id_ministere;
        }

        if (!empty($_GET['deputes'])) {
            $deputes = $_GET['deputes'];

            $sql_deputes = " and deputes.id_dep =  '$deputes' ";
            $sql_get_detail = $sql_get_detail . $sql_deputes;
        }

        if (!empty($_GET['mashoba'])) {
            $mashoba = $_GET['mashoba'];

            $sql_mashoba = " and mashob =  '$mashoba' ";
            $sql_get_detail = $sql_get_detail . $sql_mashoba;
        }

        if (!empty($_GET['accepted'])) {
            $accepted = $_GET['accepted'];

            $sql_accepted = " and etat_qst =  '$accepted' ";
            $sql_get_detail = $sql_get_detail . $sql_accepted;
        }

        if (!empty($_GET['moaajala'])) {
            $moaajala = $_GET['moaajala'];

            $sql_moaajala = " and taajil =  '$moaajala' ";
            $sql_get_detail = $sql_get_detail . $sql_moaajala;
        }

        // modification 

        if (!empty($_GET['transfert'])) {
            $transfert = $_GET['transfert'];
            $sql_transfert = " and transfert =  '$transfert' ";
            $sql_get_detail = $sql_get_detail . $sql_transfert;
        }

        if (!empty($_GET['rep'])) {
            $rep = $_GET['rep'];
             
            if( $rep == 'yes' ) {
                $rep =  " is not NULL " ;
            }else {
                $rep =  " is   NULL   " ;
            }

            
            $sql_rep = " and repenses.fichier_rep ". $rep ;
            $sql_get_detail = $sql_get_detail . $sql_rep;
            // echo $sql_get_detail ;
        }
        

 
        $sql_get_detail = $sql_get_detail . " group by num_qst desc ";

        // echo $sql_get_detail  . '<hr>' ;
        
        $exec = $cnx->prepare($sql_get_detail);

        $exec->execute([$type]);
        // $exec->execute();

        $row = $exec->rowCount();

        if ($row > 0) {

            $tab = "";

            foreach ($exec as $key) {

                $nom_g = $key['nom_g'];
                $nom = $key['nom'];
                $pnom = $key['pnom'];
                $nom_w = $key['nom_w'];
                $nom_m = $key['nom_m'];
                $num_qst = $key['num_qst'];
                $date_eng = $key['date_eng'];
                $date_rep = $key['date_rep'];
                $talkhis = $key['talkhis'];
                $molahada_one = $key['molahada_one'];
                $taajil = $key['taajil'];
                $taraf_taajil = $key['taraf_taajil'];
                $type_qst = $key['type_qst'];
                $date_env = $key['date_env'];

                
                switch ($type_qst) {
                    case 'b':
                        $type_qst = "   شفوي ";
                        break;
                    case 'a':
                        $type_qst =  "    كتابي   ";
                        break;

                    default:
                        'كتابي';
                        break;
                }

                switch ($taajil) {
                    case '1':
                        $taajil = "   قام بالتأجيل  ";
                        break;
                    case '0':
                        $taajil =  "    لم يؤجل     ";
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


                $tab .=

                    "
                <tr>
                    
                    <td class='talkhis' > $molahada_one  </td>
                    <td class='' > $date_env  </td>
                    <td class='' > $date_rep  </td>
                    
                    <td class='talkhis' > $talkhis  </td>
                   
                    <td > $nom_m  </td>
                    <td>  
                        $nom  $pnom    <hr>  $nom_g <hr> $nom_w  
                    </td>
                    <td  > $date_eng  </td>
                    <td> $num_qst <br> $type_qst  </td>
                </tr>

                ";
            }


            $tab .= "

             </tbody>

            </table>";
        } else {

            echo "

        <div class='alert-warning alert mt-5 text-center' >

          لا يوجد اي سؤال

        </div>";
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }



    $html = " 
  
        <h1 class='text-center' > 
        
            قائمة الاسئلة  
 
        </h1>

    <table lang='ar'  >

    <thead>

         <tr>
            
            <td scope='col'>  الملاحظات </td>
            
            <td scope='col'>تاريخ  الارسال</td> 
            <td scope='col'>تاريخ  الجواب</td> 
            <td scope='col'>الموضوع</td>
            <td scope='col'> 
                      عضو الحكومة
                    <br>
                    الموجه إليه السؤال                    
             </td>
              <td scope='col'>صاحب السؤال</td>
               <td scope='col'   >تاريخ الايداع</td>
              <td scope='col'> الرقم </td>
         </tr>

    </thead>

    <tbody> " . $tab ;

  
//  echo $tab ;
       $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

     $name = date("Y/m/d H:i:s") . ".pdf";
       $mpdf->Output($name, "D");
      $mpdf->Output( );

} else {
    header('location:recherche.php');
}


?>