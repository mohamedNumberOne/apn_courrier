<?php

if ( isset( $_GET['id_loi_sup'] ) && count($_GET) === 1 
        && filter_var(  $_GET['id_loi_sup'] , FILTER_VALIDATE_INT )  
    ) {

    $id_loi = $_GET['id_loi_sup'] ;

    $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', 
        array(1002 => 'SET NAMES utf8'));

    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = " SELECT id_loi from lois where id_loi = ? ";

    $execution =  $cnx->prepare($sql);

    $execution->execute( [$id_loi] );

    $row = $execution->rowCount();

    if( $row  === 1 ) {

        $sql = "DELETE FROM participer where id_loi = ? ";

        $execution =  $cnx->prepare($sql);
    
        $execution->execute( [$id_loi] );
    

            $sql = "DELETE FROM lois where id_loi = ? ";

            $execution =  $cnx->prepare($sql);
        
            $execution->execute( [$id_loi] );
        
            $row = $execution->rowCount();
            if ( $row  === 1  ) {
                session_start();
                $_SESSION['succuess_sup_loi'] = 
                " <div class='alert alert-success text-center ' > 
                تم حذف القانون و قائمة المتدخلين فيه</div> " ;
                header("location:lois.php");
            } 
            else {
                session_start();
                $_SESSION['err_sup_lois'] = 
                " <div class='alert alert-danger text-center ' > 
                خطأ يرجى المحاولة لاحقا </div> " ;
                header("location:lois.php");
            }
        
         
    } else {
        session_start();
        $_SESSION['err_sup_lois'] = 
        " <div class='alert alert-danger text-center ' > 
        خطأ يرجى المحاولة لاحقا </div> " ;
        header("location:lois.php");
    }


}
else {

    session_start();
    $_SESSION['err_sup_lois'] = " <div class='alert alert-danger m-2' > 
    خطأ يرجى المحاولة لاحقا </div> " ;
    header("location:lois.php");

}


?>