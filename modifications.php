<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>التعديل</title>
    <link rel='stylesheet' href='bootstrap/bootstrap.css'>
    <link rel='stylesheet' href='css/style.css'>

    <style>
        td {
            min-width: 150px;
            max-width: 200px;
        }

        .all_quest {
            width: 95%;
            margin: auto;
            overflow: auto !important;
        }
    </style>
</head>

<body>

    <?php
    include('header.php');
    include('qst.class.php');
    ?>
    <h1 class='text-center m-3'>
        <i class='fas fa-edit icone_anim '></i>
        <span class='wow'> التعديلات </span>
    </h1>

    <?php

    if (isset($_GET['idqst'])) {
        $id_qst = htmlspecialchars($_GET['idqst']);

        if (isset($_POST['update_modif_one'])) {
            if (
                isset($_POST['update_molahada_one'], $_POST['update_talkhis'])
                && !empty(trim($_POST['update_molahada_one']))
                && !empty(trim($_POST['update_talkhis']))
            ) {
                $question->update_modif_one($_POST['update_talkhis'], $_POST['update_molahada_one'], $id_qst);
            } else {
                echo  "<div class='alert alert-danger  text-center'  > املأ جميع  الحقول  </div> ";
            }
        }


        if (isset($_POST['update_modif_two'])) {
            if (
                isset($_POST['update_molahada_two'], $_POST['update_date_reunion'] , $_POST['update_date_env'] )
                && !empty(trim($_POST['update_molahada_two']))
                && !empty(trim($_POST['update_date_reunion']))
                && !empty(trim($_POST['update_date_env']))
            ) {
                $id_qst = htmlspecialchars($_GET['idqst']);
                $question->update_modif_two($_POST['update_molahada_two'], $_POST['update_date_reunion'], 
                $_POST['update_date_env'] , $id_qst );
            } else {
                echo  "<div class='alert alert-danger  text-center'  > املأ جميع  الحقول  </div> ";
            }
        }


        echo   "<div class='container ' > ";

        if (isset($_SESSION['updated'])) {
            echo $_SESSION['updated'];
            unset($_SESSION['updated']);
        }

        if (isset($_SESSION['updated_button'])) {
            echo $_SESSION['updated_button'];
            unset($_SESSION['updated_button']);
        }
        

        $question->get_qst_info($_GET['idqst']);
        echo ' </div>';
    } else {
        header('location:dashboard.php');
    }




    ?>




    <script src='bootstrap/jquery.js'></script>
    <script src='bootstrap/bootstrap.js'></script>

</body>

</html>