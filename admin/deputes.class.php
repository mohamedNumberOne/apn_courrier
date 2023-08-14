<?php

include('connect.class.php') ;

class deputes extends db {


    public function form_add_deputes()

    {


        $sql_wilaya = "SELECT  nom , id  from wilayas ";

        $execution =  $this->cnxt_to_db()->prepare($sql_wilaya);

        $execution->execute();

        $sql_groupe = "SELECT    id_groupe , nom   from groupes ";

        $groupes  =  $this->cnxt_to_db()->prepare($sql_groupe);

        $groupes->execute();



        // $row = $execution->rowCount();



        echo "

            <form method='POST'   >



            <div class='form-row'>

                <div class='col-sm-12  col-md-6 mb-2'>

                    <input type='text' class='form-control' name='pnom' placeholder='الإسم' required>

                </div>




                <div class='col-sm-12 col-md-6  mb-2'>

                    <input type='text' class='form-control' name='nom' placeholder='اللقب' required>

                </div>

            </div>

            <hr>

            <div class='form-row'>

                <div class=' col-sm-12  col-md-6 mb-2   '>

                     

                    <select class='form-control'   required name='wilayas'  >

                    <option value=''  > الولاية  </option> ";

        foreach ($execution as $res) {

            $wilaya = $res['nom'];

            $id = $res['id'];

            echo "<option value='$id'  > $wilaya </option> ";
        }

        echo "</select>

                </div> 

                <div class='col-sm-12  col-md-6 mb-2  '>

                

                    <select class='form-control'   required name='groupes'  >

                    <option value=''  > الحزب  </option> 

                    ";

        foreach ($groupes as $res) {

            $nom_groupe = $res['nom'];

            $id_groupe = $res['id_groupe'];

            echo "<option value=$id_groupe  > $nom_groupe </option> ";
        }

        echo "</select>

                </div>

            </div>





            <hr>



            <div class='form-row'>

                <div class=' col-sm-12  col-md-6 mb-2 '>

                    <label class='d-block col text-right  titre_form'> تاريخ الميلاد </label>

                    <input type='date' class='form-control' name='date_nai' required />

                </div>

                <div class='col-sm-12  col-md-6 mb-2'>

                    <label class='d-block col text-right titre_form'> الجنس </label>

                    <select name='sexe' class='form-control' required>

                        <option value=''></option>

                        <option value='1' selected >ذكر</option>

                        <option value='0'>انثى</option>

                    </select>

                </div>

            </div>

            <hr>



            <div class='form-row'>

                <div class='form-group col-sm-12  col-md-6  mt-4'>
                    <label class='text-right w-100' > كلمة السر </label>
                    <input type='password'  value='123'  name='ps' class='form-control' placeholder='كلمة السر' required>

                </div>

                <div class='form-group  col-sm-12  col-md-6 mt-4'>
                    <label class='text-right w-100' > هل هو عضو في اللجنة ؟ </label>
                    <select name='lajna' class='form-control'  required >
                       
                        <option></option>

                        <option value='1' > نعم </option>

                        <option value='0' selected > لا </option>

                    </select>

                </div>

            </div>



            <center> <input type='submit' name='add_dep' value='تأكيد' class='btn btn-success w-75'> </center>



        </form>";
    }



    public function add_dep($nom, $pnom, $date_nai, $groupe, $wilaya, $sexe, $ps, $lajna)

    {



        $nom  = htmlspecialchars(trim($nom));

        $pnom  = htmlspecialchars(trim($pnom));

        $date_nai  = htmlspecialchars(trim($date_nai));

        $groupe  = htmlspecialchars(trim($groupe));

        $sexe  = htmlspecialchars(trim($sexe));

        $wilaya  = htmlspecialchars(trim($wilaya));

        $lajna  = htmlspecialchars(trim($lajna));

        if (isset($_SESSION['id'])) {

            $admin = $_SESSION['id'];
        }else {
            $admin = 1;
        }





        // modifier Id admin ///////////////////////////////// c bn

        $sql_insert = " INSERT INTO deputes values( ? ,  ? , ? ,  ? , ? ,  ?  , ? , ? , ? , ? , ? )  ";

        $exec  =  $this->cnxt_to_db()->prepare($sql_insert);

        $exec->execute([null, $nom, $pnom,  $date_nai, $sexe,  $ps,  $wilaya,  $groupe, $admin, 1, $lajna]);



        $row = $exec->rowCount();

        echo "<script> location.href ='' </script>";

        if ($row === 1) {

            $_SESSION['depute_added'] = "<div class='alert alert-success text-center ' > تمت الإضافة </div>";
        } else {

            $_SESSION['depute_added'] = "<div class='alert alert-warning text-center ' > خطأ </div>";
        }
    }





    public function  get_wilayas()

    {


        $sql_get_wilayas = " SELECT * from wilayas ";

        $exec  =  $this->cnxt_to_db()->prepare($sql_get_wilayas);

        $exec->execute();

        $row = $exec->rowCount();

        if ($row > 0) {

            echo "

                    <div class='form-group  col-12 col-md-6 pr-0 '>

                    <label for='select_wilaya' class='titre_form text-center w-100'>حدد الولاية</label>

                        <select class='form-control wilaya_select ' id='select_wilaya' required name='select_wilaya' >

                            <option value=''></option> ";

            foreach ($exec as $key) {

                $nom = $key['nom'];

                $id = $key['num_w'];

                echo " <option value='$id'> $nom  </option>";
            }

            echo "  </select>

                    </div>

                    ";
        }
    }

    

}


$deputes = new deputes() ;
