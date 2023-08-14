<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/admin.css">
    <meta charset="UTF-8" >
    <title>حساب التسيير</title>
    <link rel='icon' href='../img/logo.jpg'>
</head>

<body>


    <?php 
        
        session_start();
        include ('header.php'); 
        
    ?>
    
    <h1 class="text-center mt-3"> حساب التسيير </h1>
    <div class="container mt-3">
        
    <?php
        echo "<p class='text-center' > مرحبا  " .  $_SESSION['nom'] . ' ' .$_SESSION['pnom']  . "</p>" ;
        echo "<p class='text-center' >   " .  $_SESSION['email'] .  "</p>" ; 
    ?>

    </div>


    <script src="../bootstrap/jquery.js"></script>
    <script src="../bootstrap/bootstrap.js"></script>
</body>

</html>