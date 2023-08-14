<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> إضافة الدورات </title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/anim.css">
</head>

<body>


    <?php

    include('header.php');
    include('session.class.php');


    ?>

    <h1 class="text-center m-3">
        <i class='fas fa-layer-group icone_anim'></i>
        <span class="wow"> إضافة الدورات </span>
    </h1>


    <div class="container">

        <?php

        if (isset($_SESSION['add_sess'])) {
            echo $_SESSION['add_sess'];
            unset($_SESSION['add_sess']);
        }

        if (isset($_SESSION['error_sess'])) {
            echo $_SESSION['error_sess'];
            unset($_SESSION['error_sess']);
        }

       

        if (isset($_POST['add_session'])) {

            if (
                isset($_POST['date_debut'], $_POST['date_fin'], $_POST['session_name'])
                && !empty(trim($_POST['date_debut']))
                && !empty(trim($_POST['date_fin']))
                && !empty(trim($_POST['session_name']))
            ) {

                $session->add_session($_POST['date_debut'], $_POST['date_fin'], $_POST['session_name']);
            } else {
                echo "  <div class='alert alert-warning text-center ' > 
                      ادخل جميع البيانات
                </div>  ";
            }
        }

        ?>

        <form method="post">
            <div class="form-row">
                <div class="form-group col-lg-6 col-12 ">
                    <label for="exampleInputEmail1" class="w-100 text-center"> تاريخ البداية</label>
                    <input type="date" class="form-control" name="date_debut" required>
                </div>
                <div class="form-group col-lg-6 col-12 ">
                    <label class="w-100 text-center">تاريخ النهاية</label>
                    <input type="date" class="form-control" name="date_fin" required>
                </div>
            </div>
            <div class="form-group">
                <label class="w-100 text-center">اسم الدورة</label>
                <input type="text" class="form-control" name="session_name" required>
            </div>
            <center>
                <button type="submit" class="btn btn-success" name="add_session">إضافة</button>
            </center>
        </form>

        <hr>
        
        <?php
        
            $session -> get_sessions() ;

        ?>

    </div>


    <script src="bootstrap/jquery.js"></script>
    <script>
        $(' #select_wilaya').on('change', function(e) {
            var deputes_liste = document.getElementById('deputes_liste');
            var wilaya = this.value;
            if (wilaya.trim() != "") {
                deputes_liste.innerHTML = '<div> <span>يرجى الإنتظار</span> <div class="anim" > </div> </div>';
                $.post('get_dept_ajax.php', {
                    wilaya: wilaya
                }, function(data) {
                    deputes_liste.innerHTML = data;
                });
            } else {
                deputes_liste.innerHTML = "";
            }
        });
    </script>
    <script src="bootstrap/bootstrap.js"></script>

</body>

</html>