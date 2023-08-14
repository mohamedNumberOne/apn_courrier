<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسيير الأدمين</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel='icon' href='../img/logo.jpg'>
</head>

<body>


    <?php
        session_start();
        include('header.php');
        include('admin.class.php');

        if (  isset ( $_POST['insert_ad'] )  ) {

            if (  isset(  $_POST['nom'] , $_POST['pnom'] , $_POST['email'] , $_POST['ps'] , $_POST['add_pers'] 
                            
                         , $_POST['super_a'] ,$_POST['stat'] , $_POST['telech']  
                        )  
            ) {
                
              $admin ->  add_admin( 
                            $_POST['nom'], $_POST['pnom'], $_POST['email'], 
                            $_POST['ps'],   $_POST['super_a'],  $_POST['add_pers'] , 
                            $_POST['stat'] , $_POST['telech']  
                        ) ;
            }
            

        }

    ?>


    <h1 class="text-center mt-3"> تسيير الأدمين </h1>

    <div class="container">

        <h2 class="text-center  pt-5 "> اضافة أدمين جديد </h2>

        <?php  
        if ( isset($_SESSION['admin_added'] ) ) {
         echo $_SESSION['admin_added'] ;
         unset(  $_SESSION['admin_added'] ) ;
        }
        ?>

        <form method="POST" class="p-4">
            <div class="form-row">
                <div class="col-md-6 col-sm-12  mb-2 ">
                    <input type="text" class="form-control" placeholder="الاسم"  name='nom' >
                </div>
                <div class="col-md-6 col-sm-12  mb-2">
                    <input type="text" class="form-control" placeholder="اللقب"  name='pnom' >
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 col-sm-12  mb-2 ">
                    <input type="email" class="form-control" placeholder="البريد الالكتروني"  name='email' >
                </div>
                <div class="col-md-6 col-sm-12  mb-2">
                    <input type="password" class="form-control" placeholder="كلمة السر"  name='ps' >
                </div>
            </div>
            <hr>
            <h3 class="text-center">الخصائص</h3>

            <div class="form-row">

                <div class="col-md-6 col-sm-12  mb-2 ">
                    <div class="form-group  ">
                        <label class="text-right col">تسجيل نواب جدد</label>
                        <select class="form-control"  name='add_pers' >
                            <option selected value=""> </option>
                            <option value="1">نعم </option>
                            <option value="0">لا</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12  mb-2">
                    <div class="form-group ">
                        <label class="text-right col">Super admin</label>
                        <select class="form-control"  name='super_a' >
                            <option selected value=""> </option>
                            <option value="1">نعم </option>
                            <option value="0">لا</option>
                        </select>
                    </div>
                </div>

            </div>

            
            <div class="form-row">

                <div class="col-md-6 col-sm-12  mb-2 ">
                    <div class="form-group  ">
                        <label class="text-right col">الاحصائيات</label>
                        <select class="form-control"  name='stat' >
                            <option selected value=""> </option>
                            <option value="1">نعم </option>
                            <option value="0">لا</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12  mb-2">
                    <div class="form-group ">
                        <label class="text-right col"> تحميل قائمة النواب </label>
                        <select class="form-control"  name='telech' >
                            <option selected value=""> </option>
                            <option value="1">نعم </option>
                            <option value="0">لا</option>
                        </select>
                    </div>
                </div>


            </div>
            <center>
                <button class="btn btn-success w-75 " name="insert_ad" >تأكيد</button>
            </center>
        </form>
    </div>



    <script src="../bootstrap/jquery.js"></script>
    <script src="../bootstrap/bootstrap.js"></script>
</body>

</html>