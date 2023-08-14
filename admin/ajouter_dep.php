<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel='icon' href='../img/logo.jpg'>
    <title>إضافة نائب</title>
</head>

<body>

    <?php
    
    session_start();

    
    include('add_conttroller.php');
    
    include('header.php');

    ?>

    <h1 class='text-center mt-3 '> إضافة نائب جديد </h1>


    <div class='container mt-5  p-5'>
        <?php

        if (isset($_SESSION['depute_added'])) {
            echo $_SESSION['depute_added'];
            unset($_SESSION['depute_added']);
        }

        $deputes->form_add_deputes();
        if (isset($_POST['add_dep'])) {
            if (  isset( $_POST['nom'], $_POST['pnom'],  $_POST['date_nai'], $_POST['groupes'], 
            $_POST['wilayas'], $_POST['sexe'], $_POST['ps'] ,   $_POST['lajna']  )  ) {

                $deputes->add_dep($_POST['nom'], $_POST['pnom'],  $_POST['date_nai'], $_POST['groupes'], 
                $_POST['wilayas'], $_POST['sexe'], $_POST['ps'] ,   $_POST['lajna'] );
            }

        }

        ?>

        <hr class="m-5" >
        <h1 class='text-center mt-2 '> إضافة نائب للتدخل </h1>
        
        <?php

        if (isset($_POST['add_dep_intervention'])) {

            if (
                isset($_POST['select_dept_inter'], $_POST['select_loi_inter'], $_POST['intervenir_ad'])
                && !empty($_POST['select_dept_inter']) && !empty($_POST['select_loi_inter'])
                && !empty($_POST['intervenir_ad'])
            ) {
                $deputes->add_intervention(
                    $_POST['select_dept_inter'],
                    $_POST['select_loi_inter'],
                    $_POST['intervenir_ad']
                );
            } else {
                echo " املأ جميع الحقول";
            }
        }

        if (  isset(  $_SESSION['intervention_added']  )  ) {
            echo  $_SESSION['intervention_added'] ;
            unset(  $_SESSION['intervention_added']  ) ; 
        }
            $deputes ->  get_form_add_intervention() ;

        ?>

        
    </div>

    <script src="../bootstrap/jquery.js"></script>
    <script src="../bootstrap/bootstrap.js"></script>

</body>

</html>