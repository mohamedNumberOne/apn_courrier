<link rel="stylesheet" href="../icones/all.css">
<script src="../icones/all.js" ></script>

<?php

// super admin = add lois + députés + admin

function verify_session()
{
  if (!isset(
    $_SESSION['id'],
    $_SESSION['nom'],
    $_SESSION['pnom']
  )) {
    header('location:index.php');
  }
}

verify_session();

function deco()
{
  session_destroy();
  unset($_SESSION);
  header("location:index.php");
}

if (isset($_POST['deco'])) {
  deco();
}

?>

<nav class="navbar navbar-expand-lg    navbar-light bg-success">
  <a class="navbar-brand" href="#"><img src="../img/logo.jpg" width="70px" alt="logo" class="logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <form method="POST">

        <button class="btn btn-danger my-2 my-sm-0" type="submit" name="deco"> <i class="fas fa-power-off"></i> الخروج</button>
      </form>
      <li class="nav-item ">
        <a class="nav-link" href="welcome.php">الرئيسية<i class="fas fa-home"></i> <span class="sr-only">(current)</span></a>
      </li>
      <?php

      if (isset($_SESSION['super_admin']) && $_SESSION['super_admin'] == 1) {
        echo "      
        <li class='nav-item'>
          <a class='nav-link' href='lois.php'>القوانين <i class='fas fa-gavel'></i></a>
        </li>";
      }

      ?>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          إضافة <i class='fas fa-user-plus'></i>
        </a>
        <?php

        if (

          (isset($_SESSION['add_pers']) || isset($_SESSION['super_admin']))

          && ($_SESSION['add_pers'] == 1  ||  $_SESSION['super_admin'] == 1)
        ) {
          echo "   <div class='dropdown-menu' aria-labelledby='navbarDropdown'>  ";

          if (isset($_SESSION['add_pers']) && ($_SESSION['add_pers'] == 1)) {
            echo "<a class='dropdown-item' href='ajouter_dep.php'>إضافة نائب</a>";
          }

          if (isset($_SESSION['super_admin']) && $_SESSION['super_admin'] == 1) {
            echo "<a class='dropdown-item' href='ajouter_admin.php'> إضافة أدمين  </a>";
          }
          echo "</div>";
        }

 
        ?>

      </li>
      <?php

      if (isset($_SESSION['statistiques']) &&  ($_SESSION['statistiques'] == 1)) {

        echo "      
            <li class='nav-item'>
              <a class='nav-link' href='statistiques.php'  > الإحصائيات 
                <i class='fas fa-signal'></i>
              </a>
            </li>";
      }

      ?>

      <?php

      if (isset($_SESSION['telechargement']) &&  ($_SESSION['telechargement'] == 1)) {

        echo "      
            <li class='nav-item'>
              <a class='nav-link' href='deputes.php'  > النواب المسجلون  
                <i class='fas fa-users'></i> 
              </a>
            </li>";
      }
     
      ?>

    </ul>

  </div>
</nav>
