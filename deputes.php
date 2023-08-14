<!DOCTYPE html>

<html lang='ar' dir='rtl'>



<head>

    <meta charset='UTF-8'>

    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

    <title> النواب </title>

    <link rel='icon' href='../img/logo.jpg'>

</head>



<body>



    <?php



    include('header.php');
       
    include('admin/deputes.class.php');
       

    ?>


    <div class='container mt-2 p-4 '>

        <?php
        if (isset($_SESSION['depute_added'])) {

            echo $_SESSION['depute_added'] ;
            unset($_SESSION['depute_added']);
        }

        if (isset($_SESSION['sup'])) {

            echo $_SESSION['sup'];
            unset($_SESSION['sup']);
        }

        if (isset($_SESSION['updated'])) {
            echo $_SESSION['updated'];
            unset($_SESSION['updated']);
        }

   

        if (isset($_POST['add_dep'])) {

            if (isset(
                $_POST['nom'],
                $_POST['pnom'],
                $_POST['date_nai'],
                $_POST['groupes'],

                $_POST['wilayas'],
                $_POST['sexe'],
                $_POST['ps'],
                $_POST['lajna']
            )) {


                $deputes->add_dep(
                    $_POST['nom'],
                    $_POST['pnom'],
                    $_POST['date_nai'],
                    $_POST['groupes'],
                    $_POST['wilayas'],
                    $_POST['sexe'],
                    $_POST['ps'],
                    $_POST['lajna']
                );
            }
        }


            $deputes->form_add_deputes();

        ?>
        <hr>
        <h1 class='text-center mt-3'> التعديل على النواب </h1>

        <?php 
               $deputes->get_wilayas(); 
        ?>

        <div id="deputes_liste"></div>


    </div>


    <script src="bootstrap/jquery.js"></script>
    <script src="bootstrap/bootstrap.js"></script>

     <script src='get_dept.js'></script>  


</body>



</html>