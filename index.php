<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الأدمن </title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="icones/all.css">

</head>

<body>

    <?php

    session_start();

    include('admin.class.php');

    if (isset($_POST['connect'])) {

        if (isset($_POST['email'], $_POST['ps']) && !empty($_POST['ps']) && !empty(trim($_POST['email']))) {

            $admin->connect_admin($_POST['email'], $_POST['ps']);
        } else {

            $_SESSION['error_auth'] = " <div class=' alert alert-warning text-center ' >املأ جميع الحقول</div> ";
        }
    }


    ?>


    <h1 class="alert alert-secondary text-center container mt-3"> تسجيل دخول الأدمن </h1>

    <h4 class="   text-center   mt-3">
        العهدة التشريعية التاسعة<br>
        2021 - 2026
    </h4>

    <div class="container">
        <?php

        if (isset($_SESSION['error_auth'])) {

            echo  $_SESSION['error_auth'];

            unset($_SESSION['error_auth']);
        }

        if (isset($_SESSION['sup'])) {
            echo  $_SESSION['sup'];
            unset($_SESSION['sup']);
        }

        ?>
    </div>

    <div class="container mt-3 d-flex   flex-wrap-reverse align-items-center justify-content-center   ">


        <form method="POST" class="col-lg-8   ">

            <div class="mb-3">

                <label for="exampleInputEmail1" class="form-label w-100 text-right">
                    البريد الالكتروني <i class="far fa-envelope"></i>
                </label>

                <input type="email" class="form-control" id="exampleInputEmail1" name="email" style="border-radius: 20px;">

            </div>

            <div class="mb-3">

                <label for="exampleInputPassword1" class="form-label w-100 text-right">
                    كلمة السر <i class="fas fa-lock-open"></i>
                </label>

                <input type="password" class="form-control" id="exampleInputPassword1" name="ps" style="border-radius: 20px;">

            </div>

            <center>

                <button type="submit" class="btn btn-success w-75 " name="connect"> الدخول</button>

            </center>

        </form>


        <img src="img/logo.jpg" alt="" class="col-lg-4 col-6  ">

    </div>


    <script src="icones/all.js"></script>
</body>

</html>