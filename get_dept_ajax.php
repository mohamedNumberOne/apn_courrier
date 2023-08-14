<?php



if (isset($_POST['wilaya'])) {


    $wilaya = htmlspecialchars(trim($_POST['wilaya']));

    try {

// OCT : 147.135.177.186
// srtmbabn_apn
        
       $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
       
          
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $sql = " SELECT  id_dep , nom , pnom  from deputes WHERE id_wilaya =  ?  and etat = 1 ";

        $exec = $cnx->prepare($sql);

        $exec->execute([$wilaya]);

        $row = $exec->rowCount();

        if ($row > 0) {


            echo "
             <form method='POST' action='add_qst_controller.php'  enctype='multipart/form-data'  >";


            $sql = " SELECT  nom_session , id_session from sessions  ";

            $exec = $cnx->prepare($sql);

            $exec->execute();

            $row = $exec->rowCount();

            if ($row > 0) {
                echo
                "     
                    <div class='form-group col-md-6 col-12 '>
                        <label   class='w-100 text-center '> الدورة </label>
                            <select  name='id_session'  class='form-control  col-12  '  required  > ";
                            echo "<option  > </option> ";
                            foreach ($exec as $key) {

                                $nom_session =  $key['nom_session'];

                                $id_session =  $key['id_session'];
                                echo "<option value='$id_session'   >    $nom_session</option> ";
                            }
                        echo
                " </select> 
                    </div>";
            }

            echo
            "     
                <div class='form-group col-md-6 col-12 '>
                    <label   class='w-100 text-center '> تاريخ الايداع </label>
                        <input type='date'  name='date_eng'  class='form-control  col-12  '  required  > 
                </div>";

            $sql = " SELECT  id_dep , nom , pnom  from deputes WHERE id_wilaya =  ?  and etat = 1 ";

            $exec = $cnx->prepare($sql);

            $exec->execute([$wilaya]);

            $row = $exec->rowCount();

          echo "  <div class='form-row'>
            
                    <div class='form-group col-md-6'>
                        <label   class='w-100 text-center '>اختر النائب</label>
                            <select  name='id_depute'  class='form-control  col-12  '  required  > ";

            echo "<option  > </option> ";
            foreach ($exec as $key) {

                $nom_dep =  $key['nom'];

                $pnom_dep =  $key['pnom'];

                $id_dep =  $key['id_dep'];
                echo "<option value='$id_dep' >$nom_dep  $pnom_dep</option> ";
            }


            echo
            " </select> 
                    </div>


                        <div class='form-group col-md-6'>
                            <label class='w-100 text-center'>  طبيعة السؤال  </label>
                            <select  name='type_qst'  class='form-control  col-12  ' required >  
                                <option > </option> 
                                <option value='b' > شفوي </option>
                                <option value='a' > كتابي </option>
                            </select> 
                        </div>

            </div>

                <div class='form-row'>
            
                    <div class='form-group col-md-6'>
                        <label   class='w-100 text-center '> اختر الوزارة  </label>
                         
                            <select  name='id_ministere'  class='form-control  col-12  ' required  >  
                                <option > </option> ";

            $sql = " SELECT  * from ministeres ";

            $get_ministeres = $cnx->prepare($sql);

            $get_ministeres->execute();

            $row = $get_ministeres->rowCount();
            if ($row  > 0) {

                foreach ($get_ministeres as $key) {

                    $id_m =  $key['id_m'];

                    $nom_m =  $key['nom_m'];

                    echo "<option value='$id_m' > $nom_m    </option> ";
                }
            } else {
                echo "<option   >  لا يوجد وزارات </option> ";
            }


            echo "  </select> 

                    </div>

                    <div class='form-group col-md-6'>
                        <label   class='w-100 text-center '> موضوع السؤال   </label>
                        <input type='text'  name='sujet'  class='form-control  ' required >
                    </div>

                </div>  
             
 

                <div  class='form-row' >
                         <div class='form-group col-md-6 p-0'>
                            <label class='w-100 text-center'>  ادخل رقم السؤال </label>
                             <input type='number' required min='1' lang='fr' class='form-control  ' name='num_qst'  >
                        </div>

                        <div class='form-group col-6  '>
                            <label class='w-100 text-center'> (PDF) ملف السؤال</label>
                            <input type='file' class='form-control-file'  name='pdf' accept='.pdf,.PDF' required >
                        </div> 
                </div>
                    ";
           


                echo "<div class='form-group'>
                    <label class='w-100 text-center'> السؤال </label>
                    <textarea class='form-control' name='txt_qst'  rows='6' required ></textarea>
                </div>



                <center>
                    <button type='submit' class='btn btn-success  mb-3'  name='add_quest' > اضافة السؤال</button>
                </center>

                 </form>

            ";
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


 