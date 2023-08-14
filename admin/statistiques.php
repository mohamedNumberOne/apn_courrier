<!DOCTYPE html>

<html lang='ar' dir='rtl'>



<head>

    <meta charset='UTF-8'>

    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <title>الإحصائيات</title>

    <link rel='stylesheet' href='../bootstrap/bootstrap.css'>

    <link rel='stylesheet' href='css/admin.css'>

    <link rel='icon' href='../img/logo.jpg'>

    <link rel='stylesheet' href='../icones/all.css'>

    <style>

        .age_sexe,

        .groupe {

            display: flex;

            justify-content: space-between;

            flex-wrap: wrap;

        }



        .div_stat {

            width: 30px;

            box-shadow: 0 0 10px #ccc;

            border-right: 1px solid #EEE;

            border-radius: 5px;

            padding: 20px;

            cursor: pointer;

            transition: transform 0.5s;

        }



        .div_stat:hover {

            transform: scale(1.03);

        }



        .age {

            width: 65%;

        }



        .sexe {

            width: 30%;

        }



        .stat_sexe {

            width: 30px;

            height: 100px;

            position: relative;

             background: black !important;

        }



        .remplissage {

            width: 30px;

            position: absolute;

            bottom: 0;

            margin: auto;

           

        }



        .groupe {

            width: 90%;

            margin: auto;

            margin-top: 20px;

        }



        .nom_grp {

            font-size: 12px;

            text-align: center;

            display: block;

        }



        .groupe_det  {

            display: flex;  

            justify-content: space-between;

            width: 100%;

            flex-wrap: wrap;



        }  



        @media screen and (max-width:900px) {



            .age,

            .sexe,

            .groupe {

                width: 100%;

                margin-top: 20px;

            }



        }

    </style>

</head>



<body>



    <?php

    session_start();

    include('header.php');

    include('loi.class.php');

    ?>



    <h1 class='text-center mt-3'> الإحصائيات </h1>



    <div class='container mt-3 p-3'>



        <?php

            $lois->get_all_lois();

        ?>



        <div id='stats'>

            

        </div>



    </div>





    <script src='../icones/all.js'></script>

    <script src='../bootstrap/jquery.js'></script>

    <script src='stat.js'></script>

    <script src='../bootstrap/bootstrap.js'></script>

</body>



</html>