<?php




class db {



    private $ps ;

    private $server;

    private $db_name;

     

    public function cnxt_to_db () {

        
        // $this -> ps = '';
        $this->ps = '';

         $this -> server = 'localhost';
        // $this->server = '91.216.107.184';

        $this -> db_name = 'insap1757363';

        

        try{

            $cnx = new PDO( 'mysql:host='.$this -> server.';dbname='. $this -> db_name , 'root' , $this -> ps , array(1002 => 'SET NAMES utf8') );

            $cnx -> setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );  

            

            return $cnx ;

        }

        catch( PDOException $e ){

            echo   $e-> getMessage() ;

        }



    }



}









// $sql = " SELECT * from produits ";



// $execution =  $this -> cnxt_to_db ()-> prepare($sql);

// $execution->execute([ $sql  ]);

// $row = $execution->rowCount();



?>