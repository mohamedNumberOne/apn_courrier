<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الأسئلة الكتابية</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>


    <?php

    include('header.php');
    // include('all.class.php');
    include('qst.class.php');

    ?>

    <h1 class="text-center m-5">
        <i class="fas fa-edit  icone_anim "></i>
        <span class="wow"> قائمة الأسئلة الكتابية </span>
    </h1>

    <?php
    if (isset($_SESSION['pdf_rep'])) {
        echo  $_SESSION['pdf_rep'];
        unset($_SESSION['pdf_rep']);
    }
    ?>


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


    <div class=" all_quest">



        <?php
        if (isset($_SESSION['pdf_rep'])) {
            echo  $_SESSION['pdf_rep'];
            unset($_SESSION['pdf_rep']);
        }

        if (isset($_SESSION['sup'])) {
            echo  $_SESSION['sup'];
            unset($_SESSION['sup']);
        }
        
        if (isset($_SESSION['updated'])) {
            echo  $_SESSION['updated'];
            unset($_SESSION['updated']);
        }
    

        $question->get_ecrits_qst();
        ?>
    </div>



    <script src="bootstrap/jquery.js"></script>
    <script src="bootstrap/bootstrap.js"></script>
</body>

</html>