<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>الاسئلة الشفوية</title>
    <link rel='stylesheet' href='bootstrap/bootstrap.css'>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


    <?php

    include('header.php');
    include('qst.class.php');

    ?>

    <h1 class='text-center m-5 '><i class="fas fa-head-side-cough icone_anim"></i>
        <span class="wow"> قائمة الأسئلة الشفوية </span>
    </h1>
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


    ?>

    <?php
    if (isset($_SESSION['youtube_link'])) {
        echo  $_SESSION['youtube_link'];
        unset($_SESSION['youtube_link']);
    }
    ?>


    <style>
        .all_quest {
            width: 95%;
            margin: auto;
        }
    </style>


    <div style='overflow: auto !important ;' class=' all_quest'>

        <?php

        $question->get_orales_qst();

        ?>

    </div>

    <script src='bootstrap/jquery.js'></script>
    <script src='bootstrap/bootstrap.js'></script>
</body>

</html>