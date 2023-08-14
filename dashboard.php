<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> الرئيسية</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/dash.css">


</head>

<body>


    <?php

    include('header.php');
    include('stat.class.php');

    ?>

    <h1 class="text-center m-3">
        <i class="fas fa-home icone_anim "></i>
        <span class="wow"> الرئيسية </span>
    </h1>


    <div class="container"> <?php $stat->get_sessions();  ?> </div>

    <div class="container div_stat  ">

        <div id="stat" class=" col-lg-12 "></div>
 
    </div>



    <script src="bootstrap/jquery.js"></script>
    <script>
        $('#select_session').on('change', function(e) {

            var stat = document.getElementById('stat');

            var session = this.value;

            if (session.trim() != "") {

                stat.innerHTML = '<div> <span>يرجى الإنتظار</span> <div class="anim" > </div> </div>';

                $.post('stat_ajax.php', {
                    session: session
                }, function(data) {

                    stat.innerHTML = data;

                });

            } else {

                stat.innerHTML = "";

            }

        });
    </script>
    <script src="bootstrap/bootstrap.js"></script>

</body>

</html>