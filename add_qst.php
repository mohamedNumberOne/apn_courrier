<!DOCTYPE html>
<html lang='ar' dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> إضافة سؤال </title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/anim.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


    <?php

    include('header.php');
    include('qst.class.php');

    ?>

    <h1 class="text-center m-3">
        <i class="fas fa-file-medical icone_anim "></i>
        <span class="wow"> إضافة سؤال </span>
    </h1>


    <div class="container">

        <?php

        if (isset($_SESSION['add_qst'])) {
            echo  $_SESSION['add_qst'];
            unset($_SESSION['add_qst']);
        }

        if (isset($_SESSION['added'])) {
            echo  $_SESSION['added'];
            unset($_SESSION['added']);
        }

        $all->get_wilayas();


        ?>

        <div id="deputes_liste"></div>

    </div>


    <script src="bootstrap/jquery.js"></script>
    <script>
        $('#select_wilaya').on('change', function(e) {

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