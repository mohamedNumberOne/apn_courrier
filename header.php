<?php

session_start();

//  include('admin.class.php');

if (!isset($_SESSION['admin_connected'])   ||    $_SESSION['admin_connected'] !== "yes") {
    session_destroy();
    unset($_SESSION);
    header("location:index.php");
}

function deco()

{

    session_destroy();

    unset($_SESSION);

    header("location:index.php");
}



if (isset($_POST['deco'])) {

    deco();
}


?>

<style>
    nav a {
        color: black !important;
    }

    .dropdown-menu a {
        color: black !important;
    }

    nav {
        background-color: #d6d8db !important;
    }

    .logo {
        width: 60px;
        border-radius: 5px;
    }



    .my_nav {
        position: relative;
        left: 0 !important;
        margin: auto;
        margin-right: 0;
    }


    .navbar-brand {
        margin-right: auto !important;
    }
</style>
<link rel="stylesheet" href="icones/all.css">
<link rel="stylesheet" href="css/anim.css">

<nav class="navbar navbar-expand-lg navbar-light   ">
    <!-- <a class="navbar-brand" href="dashboard.php"> <img src="img/logo.jpg" alt="" class="logo"> </a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="  collapse navbar-collapse   " id="navbarSupportedContent">
        <ul class="navbar-nav   text-left  my_nav  ">
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> الرئيسية <span class="sr-only">(current)</span></a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='recherche.php'> <i class="fas fa-search"></i> البحث </a>
            </li>
            <?php
            if (
                isset($_SESSION['admin_connected'], $_SESSION['super_admin'])
                &&    $_SESSION['admin_connected'] === "yes"
                &&  $_SESSION['super_admin'] == 1

            ) {
                echo "
            <li class='nav-item'>
                <a class='nav-link' href='add_qst.php'> <i class='fas fa-file-medical'></i> إضافة سؤال </a>
            </li>";
            }
            ?>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-clipboard-list"></i> قائمة الأسئلة
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="orales.php"> <i class="fas fa-head-side-cough"></i> الأسئلة الشفوية</a>
                    <a class="dropdown-item" href="ecrits.php"> <i class="fas fa-edit"></i> الأسئلة الكتابية</a>
                </div>
            </li>

            <?php
            // stat => <i class='fa-solid fa-arrow-trend-up'></i>
            if (
                isset($_SESSION['admin_connected'], $_SESSION['super_admin'])
                &&    $_SESSION['admin_connected'] === "yes"
                &&  $_SESSION['super_admin'] == 1

            ) {
                echo " 
            <li class='nav-item'>
                <a class='nav-link' href='add_session.php'> <i class='fas fa-layer-group'></i>إضافة الدورات </a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='add_admin.php'> <i class='fas fa-user-plus'></i> إضافة مشرف </a>
            </li>

            <li class='nav-item'>
                <a class='nav-link' href='deputes.php'> <i class='fas fa-users'></i> إضافة النواب </a>
            </li>

                 ";
            }

            ?>


            <form method="POST">
                <button class="btn  btn-danger my-2 my-sm-0" type="submit" name="deco">
                    <i class="fas fa-power-off"></i> الخروج</button>
            </form>
        </ul>

    </div>

    <a class="navbar-brand link_logo " href="dashboard.php"> <img src="img/logo.jpg" alt="" class="logo"> </a>
</nav>

<script src="icones/all.js"></script>