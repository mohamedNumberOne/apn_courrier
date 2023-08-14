<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>إضافة مشرف</title>
    <link rel='stylesheet' href='bootstrap/bootstrap.css'>
    <link rel='stylesheet' href='css/style.css'>

</head>

<body>

    <?php

    include('header.php');
    include('admin.class.php');

    if (isset($_POST['add_admin'])) {

        if( isset($_POST['nom_ad'],
            $_POST['pnom_ad'],
            $_POST['email_ad'],
            $_POST['ps_ad'],
            $_POST['super_ad'],
            $_POST['modif1'],
            $_POST['modif2'] ) 
            && ! empty( trim($_POST['nom_ad'] ))
            && ! empty( trim($_POST['pnom_ad']))
            && ! empty( trim($_POST['email_ad']))
            && ! empty( ($_POST['ps_ad']))
              
        ) 
            
        {
            
            $admin->add_admin(
                $_POST['nom_ad'],
                $_POST['pnom_ad'],
                $_POST['email_ad'],
                $_POST['ps_ad'],
                $_POST['super_ad'],
                $_POST['modif1'],
                $_POST['modif2']
            );

        } else {
            echo "<div class='alert alert-warning text-center  container '> 
                يرجى ادخال جميع اليانات 
                </div> ";
        }

    }
    ?>
    <h1 class='text-center m-3'>
        <i class='fas fa-user-plus  icone_anim '></i>
        <span class='wow'> إضافة مشرف </span>
    </h1>

    <div class='container'>

    <?php

        if(  isset($_SESSION['admin_added'] ) ) {
            echo $_SESSION['admin_added'] ;
            unset($_SESSION['admin_added'] ) ;
        }

    ?>
    
        <form method='POST'>
            <div class="form-row">
                <div class='form-group mb-3 col-md-6 col-12 '>
                    <label class='form-label w-100 text-center '>الاسم</label>
                    <input type='text' class='form-control' required name='pnom_ad'>
                </div>

                <div class='form-group mb-3 col-md-6 col-12 '>
                    <label class='form-label w-100 text-center '>اللقب</label>
                    <input type='text' class='form-control' required name='nom_ad'>
                </div>
            </div>

            <div class="form-row">
                <div class='form-group mb-3 col-md-6 col-12 '>
                    <label class='form-label w-100 text-center '>كلمة السر</label>
                    <input type='password' class='form-control  ' required name='ps_ad'>
                </div>

                <div class='form-group mb-3 col-md-6 col-12 '>
                    <label class='form-label w-100 text-center '>البريد الالكتروني</label>
                    <input type='email' class='form-control' required name='email_ad'>
                </div>
            </div>


            <div class="form-row">
                <div class='form-group mb-3 col-md-6 col-12 '>
                    <label class='form-label w-100 text-center '> التلخيص</label>

                    <select name='modif1' class='form-control  ' required>

                        <option> </option>
                        <option value='1'> نعم </option>
                        <option value='0'> لا </option>

                    </select>
                </div>


                <div class='form-group mb-3 col-md-6 col-12 '>
                    <label class='form-label w-100 text-center '> امانة المكتب </label>

                    <select name='modif2' class='form-control  ' required>

                        <option> </option>
                        <option value='1'> نعم </option>
                        <option value='0'> لا </option>

                    </select>
                </div>


            </div>

            <div class='form-group mb-3 col-md-6 col-12 '>
                <label class='form-label w-100 text-center '> Super Admin </label>

                <select name='super_ad' class='form-control  ' required>

                    <option> </option>
                    <option value='1'> نعم </option>
                    <option value='0'> لا </option>

                </select>
            </div>

            <center>
                <button type='submit' class='btn btn-success mb-4' name='add_admin'>إضافة</button>
            </center>
            
        </form>
    </div>


    <script src='bootstrap/jquery.js'></script>
    <script src='bootstrap/bootstrap.js'></script>

</body>

</html>