<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset='UTF-8'>

    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title> التعديل  </title>

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

    <div class='container mt-3'>

   
        <?php

 
            if (isset($_GET['id_loi_up'])) {

                $lois-> form_update_loi($_GET['id_loi_up']);

                if ( isset($_POST['update_loi']) ) {

                    if ( isset($_POST['new_name'] , $_POST['new_date'] , $_POST['new_hour'] )){
                        $new_date = $_POST['new_date'] . ' ' . $_POST['new_hour']. '-00'; 
                        $lois->  update_loi ($_POST['new_name'] , $new_date  ) ;
                    }

                }
            }

        ?>

            


    </div>



    <script src='../bootstrap/jquery.js'></script>

    <script src='../bootstrap/bootstrap.js'></script>

</body>

</html>