<?php
session_start();

if (isset($_GET['id_qst']) && count($_GET) === 1) {

    $id_qst = htmlspecialchars($_GET['id_qst']);
     $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
   
    
    $sql = "SELECT id_qst  , type_qst FROM  questions where id_qst = ?     ";
    $exec = $cnx->prepare($sql);
    $exec->execute([$id_qst]);
    $row = $exec->rowCount();

    if ($row > 0) {

        foreach ($exec as $key => $value) {
            $type_qst =  $value['type_qst'];
        }

        if ($type_qst == 'b') {
            $destination = "orales.php";
        } else if ($type_qst == 'a') {
            $destination = "ecrits.php";
        } else {
            $destination = "dashboard.php";
        }

        $sql = "DELETE FROM  repenses  where id_qst = ?   ";
        $exec = $cnx->prepare($sql);
        $exec->execute([$id_qst]);
        

        $sql = "DELETE FROM  questions where id_qst = ?   ";
        $exec = $cnx->prepare($sql);
        $exec->execute([$id_qst]);
        $row = $exec->rowCount();

        if ($row  === 1) {
            $_SESSION['sup'] = "<div class='alert alert-success text-center container' > 
            تم حذف السؤال
            </div>";
            header("location:$destination");
        } else {
            $_SESSION['sup'] = "<div class='alert alert-danger text-center container' > 
            خطأ في رقم  السؤال
            </div>";
            header("location:$destination");
        }
    } else {
        $_SESSION['sup'] = "<div class='alert alert-danger text-center container' > 
            خطأ في رقم  السؤال
            </div>";
        header('location:dashboard.php');
    }
} else {
    header('location:dashboard.php');
}

// sup dept 


if(  isset( $_GET['sup_dept_final'] ) && count($_GET) === 1 ) 
{


    $id_dept = htmlspecialchars($_GET['sup_dept_final']);

    $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
    
 
 

    $sql = "SELECT id_dep FROM deputes where id_dep = ?     ";
    $exec = $cnx->prepare($sql);
    $exec->execute([$id_dept]);
    $row = $exec->rowCount();

    if ($row  === 1  ) {

        $sql = "DELETE FROM deputes where id_dep = ?     ";
        $exec = $cnx->prepare($sql);
        $exec->execute([$id_dept]);
        $row = $exec->rowCount();

        if ($row === 1 ) {

            $_SESSION['sup'] = "<div class='alert alert-success text-center container' > 
            تم الحذف       
            </div>";
            header('location:deputes.php');
        }
    }else {
        $_SESSION['sup'] = "<div class='alert alert-danger text-center container' > 
            خطأ       
            </div>";
        header('location:deputes.php');
    }




}