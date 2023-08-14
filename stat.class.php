<?php

include('connect.class.php');

class stat extends db
{

    public function  get_sessions()

    {

        $sql_get_sessions = " SELECT  id_session , 	nom_session   from sessions ";

        $exec  =  $this->cnxt_to_db()->prepare($sql_get_sessions);

        $exec->execute();

        $row = $exec->rowCount();

        if ($row > 0) {

            echo "
                    <div class='form-group  col-12 col-md-6 pr-0 '>

                    <label for='select_wilaya' class='titre_form text-center w-100'> حدد الدورة  </label>

                        <select class='form-control wilaya_select ' id='select_session' 
                        required name='select_session' >

                            <option value=''></option> ";

            foreach ($exec as $key) {
                // id_session 	nom_session  
                $nom = $key['nom_session'];
                $id = $key['id_session'];

                echo " <option value='$id'> $nom  </option>";
            }

            echo "  </select>

                    </div>";
        }
    }


    public function get_form_serch1()
    {

        $sql_get_sessions = " SELECT  id_session , 	nom_session   from sessions ";

        $exec  =  $this->cnxt_to_db()->prepare($sql_get_sessions);

        $exec->execute();

        $row = $exec->rowCount();

        if ($row > 0) {

            echo "

           <form action='' method='post'  >
            
            <div class='form-row'> 
                    <div class='col-12 col-lg-4 mt-3' >

                            <label  class='titre_form text-center w-100'> حدد الدورة  </label>

                    <select class='form-control '   required name='select_session_filtre_num' >

                        <option value=''></option> ";

            foreach ($exec as $key) {
                // id_session 	nom_session  
                $nom = $key['nom_session'];
                $id = $key['id_session'];

                echo " <option value='$id'> $nom  </option>";
            }

            echo
            "  </select>

                    </div>
                    
                    
                <div class='col-12 col-lg-4  mt-3  '>
                 <label   class='titre_form text-center w-100'> رقم السؤال </label>
                    <input type='number' class='form-control' lang='fr'  min='1'  required name='num_qst_filtre'  >
                </div>


                <div class='col-12 col-lg-4  mt-3  '>
                 <label   class='titre_form text-center w-100'> طبيعة السؤال </label>
                        <select class='form-control '   required name='select_type_filtre' >
                            <option ></option> 
                            <option value='a'>كتابي  </option> 
                            <option value='b'> شفوي </option> 
                        </select>
                </div>

            </div>    



                
                <center> 
                    <input type='submit' name='rech_num' value='ابحث' class='mt-5 btn btn-success' > 
                </center>
                    
            </form>    ";
        }
    }


    public function cherche_question_bnum($num_qst, $id_session, $type)
    {

        $num_qst = htmlspecialchars($num_qst);
        $id_session = htmlspecialchars($id_session);
        $type  =  htmlspecialchars($type);

        $sql_get_sessions = "SELECT  questions.id_qst ,  groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , talkhis  , molahada_one   ,   num_qst , date( date_eng ) as date_eng  , taajil , taraf_taajil   
        FROM  questions  INNER JOIN deputes on deputes.id_dep = questions.id_dep 
        INNER JOIN ministeres on ministeres.id_m = questions.id_m 
        INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
        INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
        
        
        where num_qst = ? and id_session = ? and type_qst = ?   ";


        $exec  =  $this->cnxt_to_db()->prepare($sql_get_sessions);

        $exec->execute([$num_qst, $id_session, $type]);

        $row = $exec->rowCount();

        if ($row > 0) {
            echo " 
           <a href='imprimer.php?num_qst=$num_qst&id_session=$id_session&type=$type' 
           class='btn btn-success mb-2 float-right' > 
            <i class='fas fa-download'></i> تحميل
           </a>
          <table class='table table-striped table-bordered  text-center container '   >
            <thead>
                <tr>
                    <th scope='col'> الرقم </th>
                    <th scope='col'   >تاريخ الايداع</th>
                    <th scope='col'>صاحب السؤال</th>
                    <th scope='col'> 
                            عضو الحكومة
                            <br>
                            الموجه إليه السؤال                    
                    </th>
                    
                    <th scope='col'>الموضوع</th>
                    
                    <th scope='col'>  الملاحظات </th>
                </tr>
            </thead>
            <tbody>";
            foreach ($exec as $key) {

                $nom_g = $key['nom_g'];
                $id_qst = $key['id_qst'];
                $nom = $key['nom'];
                $pnom = $key['pnom'];
                $nom_w = $key['nom_w'];
                $nom_m = $key['nom_m'];
                $num_qst = $key['num_qst'];
                $date_eng = $key['date_eng'];
                $talkhis = $key['talkhis'];
                $molahada_one = $key['molahada_one'];


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


                echo " 
               
                <tr>
                    <td> <a href='modifications.php?idqst=$id_qst'  target='_blank' > $num_qst </a>   </td>
                    <td style='max-width: 100px !important ; width:100px ' > $date_eng  </td>
                    <td>  <b> $nom  $pnom </b>  <hr>  $nom_g <hr> $nom_w  </td>
                    <td style=' width:200px;' > $nom_m  </td>
                    <td style='min-width:200px;' > $talkhis  </td>
                    
                    <td style='min-width:100px;' > $molahada_one  </td>
                </tr>
                ";
            }
            echo "</tbody> 
            </table> ";
        } else {
            echo "  <div class='alert alert-warning text-center container ' >  لا يوجد سؤال بهاذا الرقم </div> ";
        }
    }


    public function cherche_question_motcle($motcle)
    {

        $motcle = htmlspecialchars($motcle);

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


        // $qst_par_page = 30;
        // $nb_page =  ceil($ids / $qst_par_page);
        // if (
        //     isset($_GET['page'])  && !empty(trim($_GET['page']))
        //     && filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT)
        //     &&
        //     $_GET['page'] <= $nb_page

        // ) {
        //     $page =  htmlspecialchars($_GET['page']);
        // } else {
        //     $page = 1;
        // }

        // $debut = ($page - 1) * $qst_par_page;


        $sql_get_sessions = "SELECT id_qst ,  groupes.nom as nom_g , deputes.nom as nom , wilayas.nom as nom_w , pnom , nom_m , talkhis  , molahada_one   ,   num_qst , date( date_eng ) as date_eng  , type_qst    , taajil , taraf_taajil   
        FROM  questions  
        INNER JOIN deputes on deputes.id_dep = questions.id_dep 
        INNER JOIN ministeres on ministeres.id_m = questions.id_m 
        INNER JOIN wilayas on wilayas.id = deputes.id_wilaya
        INNER JOIN groupes on groupes.id_groupe = deputes.id_groupe
        INNER JOIN sessions on sessions.id_session = questions.id_session
       
        where text_qst like ? and etat_session = 1   order by num_qst desc  ";
        //limit  $debut , $qst_par_page   

        $exec  =  $this->cnxt_to_db()->prepare($sql_get_sessions);
            
        $exec->execute( ['%' . $motcle . '%' ] );

        $row = $exec->rowCount();

        if ($row > 0) {

            // echo "  <div class='text-right mb-2' >
            // الصفحات:
            // ";

            // for ($i = 1; $i <= $nb_page; $i++) {
            //     if ($i != $page) {
            //         echo " <span class='span_page' >   <a href='?page=$i' class='a_page'  > $i   </a>  </span>   ";
            //     } else {
            //         echo " <span class='span_page' style='background:gray;'  > $i </span>   ";
            //     }
            // }
            // echo "</div>" ;

            echo " 
            <a href='imprimer.php?mot_cle=$motcle'  class='btn btn-success float-right mb-2' >  
                <i class='fas fa-download'></i>  تحميل   
            </a>
          <table class='table table-striped table-bordered  text-center container  '   >
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
                </tr>
            </thead>
            <tbody>";
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
                </tr>
                ";
            }
            echo "</tbody> 
            </table> ";
        } else {
            echo "  <div class='alert alert-warning text-center container ' >  لم يتم ايجاد اي سؤال </div> ";
        }
    }


    public function get_form_detail()
    {


        echo
        "<form method='post' > 

            <div class='row'>

                <div class='col-lg-3 col-12  mt-2'>
                    <label for='' class='text-center w-100'> المودعة من </label>
                    <input type='date' class='form-control' name='min'>
                </div>
                <div class='col-lg-3 col-12 mt-2'>
                    <label for='' class='text-center w-100 '> إلى </label>
                    <input type='date' class='form-control' name='ila'>
                </div>

                        <div class='col-lg-3 col-12 mt-2'>
                            <label for='' class='text-center w-100 '> طبيعة السؤال </label>
                            <select class='form-control' name='type_qst' required >
                                <option> </option>
                                <option value='b'> شفوي </option>
                                <option value='a'> كتابي </option>
                            </select>
                        </div>


                <div class='form-group col-lg-3 col-12 mt-2 '>
                        <label   class='w-100 text-center '> اختر الوزارة  </label>
                         
                            <select  name='id_ministere'  class='form-control  col-12  '    >  
                                <option > </option> ";

                    $sql = " SELECT  * from ministeres ";

                    $get_ministeres = $this->cnxt_to_db()->prepare($sql);

                    $get_ministeres->execute();

                    $row = $get_ministeres->rowCount();
                    if ($row  > 0) {

                        foreach ($get_ministeres as $key) {

                            $id_m =  $key['id_m'];

                            $nom_m =  $key['nom_m'];

                            echo "<option value='$id_m' > $nom_m    </option> ";
                        }
                    } else {
                        echo "<option>  لا يوجد وزارات </option> ";
                    }

                echo "  </select> 

                        </div> 
                    

                    </div>
                    
              <div class='row'>   ";


        $sql = " SELECT id_dep , nom , pnom   from deputes where etat = 1 group by nom ";

        $get_ministeres = $this->cnxt_to_db()->prepare($sql);

        $get_ministeres->execute();

        $row = $get_ministeres->rowCount();
        if ($row  > 0) {
            echo "

                <div class='col-lg-3 col-12 mt-2'>
                    <label for='' class='text-center w-100 '> النائب </label>
                    <select class='form-control' name='deputes'>
                        <option value=''> </option>";
                        foreach ($get_ministeres as $key) {
                            $id_dep =  $key['id_dep'];
                            $nom =  $key['nom'];
                            $pnom =  $key['pnom'];
                            echo "<option value='$id_dep'> $nom $pnom   </option>";
                        }

            echo " </select>

                </div>";
        }




        echo "
                <div class='col-lg-3 col-12 mt-2'>
                    <label for='' class='text-center w-100 '> المسحوبة </label>
                    <select class='form-control' name='mashoba'>
                        <option> </option>
                        <option value='yes'> نعم </option>
                        <option value='no'> لا </option>
                    </select>
                </div>

                <div class='col-lg-3 col-12 mt-2'>
                    <label for='' class='text-center w-100 '> المقبولة </label>
                    <select class='form-control' name='accepted'>
                        <option> </option>
                        <option value='yes'> نعم </option>
                        <option value='no'> لا </option>
                    </select>
                </div>

                <div class='col-lg-3 col-12 mt-2'>
                    <label for='' class='text-center w-100 '> المؤجلة </label>
                    <select class='form-control' name='moaajala'>
                        <option> </option>
                        <option value='yes'> نعم </option>
                        <option value='no'> لا </option>
                    </select>
                </div>

            </div> ";

            echo " <div class='row'>   

                    <div class='col-lg-3 col-12 mt-2'>
                        <label for='' class='text-center w-100 '> المحولة </label>
                        <select class='form-control' name='transfert'>
                            <option> </option>
                            <option value='yes'> نعم </option>
                            <option value='no'> لا </option>
                        </select>
                    </div>

                    <div class='col-lg-3 col-12 mt-2'>
                        <label for='' class='text-center w-100 '>  الإجابة </label>
                        <select class='form-control' name='rep'>
                            <option> </option>
                            <option value='yes'> نعم </option>
                            <option value='no'> لا </option>
                        </select>
                    </div>

                    </div>" ;

            echo "<center>
                <input type='submit' name='rech_detail' value='ابحث' class='mt-5 mb-5 btn btn-success'>
            </center> ";

        echo "</form> ";
    }

    public function get_rech_detail(
        $min,
        $ila,
        $id_ministere,
        $deputes,
        $type_qst,
        $mashoba,
        $accepted,
        $moaajala
    ) {


    }

}


$stat =  new  stat();
