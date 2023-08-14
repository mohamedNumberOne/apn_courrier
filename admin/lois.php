<!DOCTYPE html>

<html lang='ar' dir='rtl'>



<head>

    <meta charset='UTF-8'>

    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title>صفحة القوانين</title>

    <link rel='stylesheet' href='../bootstrap/bootstrap.css'>

    <link rel='stylesheet' href='css/admin.css'>

    <link rel='icon' href='../img/logo.jpg'>

</head>



<body>



    <?php 

        session_start();

        include('loi.class.php');

        include('header.php'); 

    ?>



    <h1 class='text-center m-3'> تسيير القوانين</h1>


    <div class='container mt-3'>

            <?php
                    if (isset($_SESSION['success_up'])) {
                        echo $_SESSION['success_up'] ;
                        unset($_SESSION['success_up']);
                    }
            ?>

        <h2 class='text-center m-4   pt-3 '> اضافة قانون جديد </h2>



        <?php  



            if ( isset( $_POST['add'] ) ) {

                if ( isset ( $_POST['nom_loi'] , $_POST['date_fin']  ) 
                                && ! empty($_POST['date_fin']) 

                        && ! empty(  trim( $_POST['nom_loi']) ) 
                    ) 

                {

                    $date_fin = $_POST['date_fin'] . ' ' . $_POST['heure_fin'] .':00' ;
                    
                    $lois ->  add_loi(   $_POST['nom_loi']   , $date_fin  ) ;

                }

            }



            if ( isset($_SESSION['add_loi']) ) {

                echo $_SESSION['add_loi'] ;

                unset($_SESSION['add_loi']);
                 

            }



        ?>



        <form method='POST' class='p-4'>

            <div class='form-row'>

                <div class='form-group col-md-6'>

                    <label for='inputEmail4' class='col text-right'   >اسم القانون</label>

                    <input type='text' class='form-control' id='inputEmail4' name='nom_loi' required >

                </div>

                <div class='form-group col-md-6'>

                    <label for='inputPassword4' class='col text-right'  >آخر اجل للتسجيل</label>

                    <input type='date' class='form-control' id='inputPassword4' name='date_fin' required>

                </div>

                <div class='form-group col-md-6'>

                    <label for='time' class='col text-right'  >   الساعة  </label>

                    <input type='time' class='form-control' 
                        value="09:00"
                    id='time' name='heure_fin' required>

                </div>

            </div>



            <center>

                <button class='btn btn-success w-75 ' name="add"  >تأكيد</button>

            </center>

        </form>



        <hr class='m-4'>



        <div>

      
                <?php 
                        
                    if ( isset( $_SESSION['succuess_sup_loi'])   ) {
                        echo $_SESSION['succuess_sup_loi'] ; 
                        unset( $_SESSION['succuess_sup_loi'] ) ;
                    }
                    
                    if ( isset( $_SESSION['err_sup_lois'])   ) {
                        echo $_SESSION['err_sup_lois'] ; 
                        unset( $_SESSION['err_sup_lois'] ) ;
                    }
                    
                ?>        
        

            <h2 class='text-center m-2'>قائمة القوانين السابقة</h2>


                    <?php 

                        $lois -> display_lois() ;

                    ?> 



        </div>





    </div>



            

    <script src='../bootstrap/jquery.js'></script>

    <script src='../bootstrap/bootstrap.js'></script>

</body>



</html>