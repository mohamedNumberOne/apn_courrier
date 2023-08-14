<!DOCTYPE html>

<html lang='ar' dir='rtl'>

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../bootstrap/bootstrap.css">

    <meta charset="UTF-8" >

    <title>Admin</title>

</head>



<body>



    <?php



    session_start();

    include('admin.class.php');

    if (isset($_POST['connect'])) {

        if (isset($_POST['email'], $_POST['ps']) && !empty ( $_POST['ps'] ) && !empty ( trim($_POST['email']) ) ) {

            $admin->connect_admin($_POST['email'], $_POST['ps']);

        } else {

            $_SESSION['error_auth'] = " <div class=' alert alert-warning text-center ' >املأ جميع الحقول</div> ";

        }

    }



    ?>



    <div class="container mt-3">



        <h1 class="alert alert-success text-center "> تسجيل دخول الأدمن </h1>


        <?php



            if (isset($_SESSION['error_auth'])) {

                echo  $_SESSION['error_auth'];

                unset(  $_SESSION['error_auth'] ) ;

            } 



        ?>



        <form method="POST">

            <div class="mb-3">

                <label for="exampleInputEmail1" class="form-label">البريد الالكتروني</label>

                <input type="email" class="form-control" id="exampleInputEmail1"
                    
                name="email"   >



            </div>

            <div class="mb-3">

                <label for="exampleInputPassword1" class="form-label">كلمة السر</label>

                <input type="password" class="form-control" id="exampleInputPassword1" name="ps" >

            </div>

            <center>

                <button type="submit" class="btn btn-success w-75 " name="connect">تسجيل الدخول</button>

            </center>

        </form>



    </div>





</body>



</html>