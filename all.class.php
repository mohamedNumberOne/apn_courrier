<?php


include("connect.class.php");

class all extends db
{


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


$all = new all();
