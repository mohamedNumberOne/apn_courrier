<?php
include('connect.class.php');

class rep extends db
{

    public function add_rep($fichier_rep,     $id_qst)
    {

        $fichier_rep = htmlspecialchars($fichier_rep);
        $id_qst =  htmlspecialchars($id_qst);

        $sql = "SELECT id_qst from questions where id_qst = ? ";

        $execution =  $this->cnxt_to_db()->prepare($sql);

        $execution->execute([$sql]);

        $row = $execution->rowCount();

        if( $row === 1 ) {
            echo "1";
        }else {
            echo "noo";
        }

    }
}


$rep = new rep();
