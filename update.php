<?php
session_start();

if (!isset($_SESSION['admin_connected'])   ||    $_SESSION['admin_connected'] !== "yes") {
    session_destroy();
    unset($_SESSION);
    header("location:index.php");
}


 $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));


if (isset($_GET['id_etat'],  $_GET['action']) && count($_GET) === 2) {

    $id =  htmlspecialchars($_GET['id_etat']);
    $action =  htmlspecialchars($_GET['action']);


    // Verify Id qst GET :
    $sql = "SELECT id_qst from questions where id_qst = ? ";
    $exec  =  $cnx->prepare($sql);

    $exec->execute([$id]);
    $row = $exec->rowCount();
    if ($row === 1) {

        if ($action === 'c' || $action === 'r') {
            $sql = "UPDATE questions set etat_qst = ? where  id_qst = ? ";
            $exec  =  $cnx->prepare($sql);
            $exec->execute([$action, $id]);
            $_SESSION['updated_button'] =
                " <div class='alert  alert-success text-center ' > 
            لقد تم التغيير بنجاح
            </div> ";
            header("location:modifications.php?idqst=$id");
        } else {
            $_SESSION['updated_button'] =
                " <div class='alert  alert-danger text-center ' > 
           1 لقد حصل خطأ
            </div> ";
            header("location:modifications.php?idqst=$id");
        }
    } else {
        $_SESSION['updated_button'] =
            " <div class='alert  alert-danger text-center ' > 
           2 لقد حصل خطأ
            </div> ";
        header("location:modifications.php?idqst=$id");
    }
}

if (isset($_GET['id_sahb'],  $_GET['action']) && count($_GET) === 2) {

    $id =  htmlspecialchars($_GET['id_sahb']);
    $action =  htmlspecialchars($_GET['action']);
    // Verify Id qst GET :
    $sql = "SELECT id_qst from questions where id_qst = ? ";
    $exec  =  $cnx->prepare($sql);
    $exec->execute([$id]);
    $row = $exec->rowCount();

    if ($row === 1) {
        if ($action === '0' || $action === '1') {
            $sql = "UPDATE questions set mashob = ? where  id_qst = ? ";
            $exec  =  $cnx->prepare($sql);
            $exec->execute([$action, $id]);
            $_SESSION['updated_button'] =
                " <div class='alert  alert-success text-center ' > 
            لقد تم التغيير بنجاح
            </div> ";
            header("location:modifications.php?idqst=$id");
        } else {
            $_SESSION['updated_button'] =
                " <div class='alert  alert-danger text-center ' > 
           3 لقد حصل خطأ
            </div> ";
            header("location:modifications.php?idqst=$id");
        }
    } else {
        $_SESSION['updated_button'] =
            " <div class='alert  alert-danger text-center ' > 
           4 لقد حصل خطأ
            </div> ";
        header("location:modifications.php?idqst=$id");
    }
}


if (isset($_GET['tahwil'],  $_GET['action']) && count($_GET) === 2) {

    $id =  htmlspecialchars($_GET['tahwil']);
    $action =  htmlspecialchars($_GET['action']);


    // Verify Id qst GET :
    $sql = "SELECT id_qst from questions where id_qst = ? ";
    $exec  =  $cnx->prepare($sql);

    $exec->execute([$id]);
    $row = $exec->rowCount();
    if ($row === 1) {

        if ($action === '0' || $action === '1') {
            $sql = "UPDATE questions set transfert = ? where  id_qst = ? ";
            $exec  =  $cnx->prepare($sql);
            $exec->execute([$action, $id]);
            $_SESSION['updated_button'] =
                " <div class='alert  alert-success text-center ' > 
            لقد تم التغيير بنجاح
            </div> ";
            header("location:modifications.php?idqst=$id");
        } else {
            $_SESSION['updated_button'] =
                " <div class='alert  alert-danger text-center ' > 
           5 لقد حصل خطأ
            </div> ";
            header("location:modifications.php?idqst=$id");
        }
    } else {
        $_SESSION['updated_button'] =
            " <div class='alert  alert-danger text-center ' > 
           6 لقد حصل خطأ
            </div> ";
        header("location:modifications.php?idqst=$id");
    }
}


if (isset($_POST['add_rep_form'])) {
    if (
        isset($_POST['id_qst_form'],  $_POST['type_qst_form'], $_FILES['file_rep_form'])
        && !empty(trim($_POST['id_qst_form']))
        && !empty(trim($_POST['type_qst_form']))
        && !empty($_FILES['file_rep_form'])
    ) {


        $type_qst_form = htmlspecialchars($_POST['type_qst_form']);
        $id_qst_form   =   htmlspecialchars($_POST['id_qst_form']);

        $sql = "SELECT id_qst from questions where id_qst = ? and type_qst = ?  ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form, $type_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {



            // ::::::::::::::

            if ($_FILES['file_rep_form']['error'] === UPLOAD_ERR_OK) {
                // get details of the uploaded file
                $fileTmpPath = $_FILES['file_rep_form']['tmp_name'];
                $fileName = $_FILES['file_rep_form']['name'];
                $fileSize = $_FILES['file_rep_form']['size'];
                $fileType = $_FILES['file_rep_form']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                // sanitize file-name
                $newFileName =   date("Y-m-d H-i-s") . '.' . $fileExtension;

                // check if file has one of the following extensions
                $allowedfileExtensions = array('pdf', 'PDF');
                if ($fileSize <= 2097152) {

                    if (in_array($fileExtension, $allowedfileExtensions)) {
                        // directory in which the uploaded file will be moved
                        $uploadFileDir = 'rep/';
                        $dest_path = $uploadFileDir . $newFileName;

                        if (move_uploaded_file($fileTmpPath, $dest_path)) {

                            $sql = "INSERT into  repenses values ( null , ? , null , ? )   ";
                            $exec  =  $cnx->prepare($sql);
                            $exec->execute([$dest_path, $id_qst_form]);
                            $row = $exec->rowCount();
                            if ($row === 1) {
                                $_SESSION['pdf_rep']  =  " <div class='alert alert-success text-center ' > 
                                      تم اضافة الملف         
                                </div>  ";
                                header('location:ecrits.php');
                            }
                        } else {
                            $_SESSION['pdf_rep']  =  " <div class='alert alert-warning text-center ' > 
                             لم يتم رفع الملف ، اعد المحاولة  من جديد 
                            </div>  ";
                            header('location:ecrits.php');
                        }
                    } else {
                        $_SESSION['pdf_rep']  =  " <div class='alert alert-warning text-center ' > 
                             يرجى ادخال ملف بصيغة   PDF
                        </div>   ";
                        header('location:ecrits.php');
                    }
                } else {
                    $_SESSION['pdf_rep']  =  " <div class='alert alert-warning text-center ' > 
                 لا يجب ان يتجاوز حجم الملف 2 ميغابايت
                </div>   ";
                    header('location:ecrits.php');
                }
            } else {
                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                    هناك خطأ في الملف 
                </div>  ";
                header('location:ecrits.php');
            }



            // ::




        } else {
            $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                  خطا في رقم السؤال
                </div>  ";
            header('location:ecrits.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:ecrits.php');
    }
}



//  add youtube  link chafawi

if (isset($_POST['add_link'])) {
    if (
        isset($_POST['id_qst_form'],  $_POST['type_qst_form'], $_POST['youtube_link'])
        && !empty(trim($_POST['id_qst_form']))
        && !empty(trim($_POST['type_qst_form']))
        && !empty($_POST['youtube_link'])
    ) {
        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $type_qst_form = htmlspecialchars($_POST['type_qst_form']);
        $youtube_link = htmlspecialchars($_POST['youtube_link']);

        $sql = "SELECT id_qst from questions where id_qst = ? and type_qst = ?  ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form, $type_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            // verify if  update  or insert     
            $sql = "SELECT id_qst from repenses where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$id_qst_form]);
            $row = $exec->rowCount();

            if ($row === 0) {
                $sql = "  INSERT INTO repenses values (  null  , ? , null , ? ) ";
                $exec  =  $cnx->prepare($sql);

                $exec->execute([$youtube_link, $id_qst_form]);
                $row = $exec->rowCount();
                if ($row === 1) {
                    $_SESSION['youtube_link']   = " 
                <div class='alert alert-success text-center ' > 
                  تمت الاضافة
                </div>  ";
                    header('location:orales.php');
                } else {
                    $_SESSION['youtube_link']   = " 
                <div class='alert alert-warning text-center ' > 
                   خطا      
                </div>  ";
                    header('location:orales.php');
                }
            } elseif ($row === 1) {

                $sql = "  UPDATE  repenses  SET fichier_rep = ? where id_qst = ?  ";
                $exec  =  $cnx->prepare($sql);

                $exec->execute([$youtube_link, $id_qst_form]);
                $row = $exec->rowCount();
                if ($row === 1) {
                    $_SESSION['youtube_link']   = " 
                <div class='alert alert-success text-center ' > 
                    تم التعديل
                </div>  ";
                    header('location:orales.php');
                } else {
                    $_SESSION['youtube_link']   = " 
                <div class='alert alert-warning text-center ' > 
                   خطا      
                </div>  ";
                    header('location:orales.php');
                }
            } else {
                $_SESSION['youtube_link']   = " 
                <div class='alert alert-warning text-center ' > 
                   خطا      
                </div>  ";
                header('location:orales.php');
            }
        } else {

            $_SESSION['youtube_link']   = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:orales.php');
        }
    } else {
        $_SESSION['youtube_link']   = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:orales.php');
    }
}





// change_date_rep kitabi

if (isset($_POST['change_date_rep'])) {

    if (
        isset($_POST['date_rep_form'], $_POST['id_qst_form'])
        && !empty(trim($_POST['date_rep_form']))
        && !empty(trim($_POST['id_qst_form']))
    ) {

        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $date_rep_form = htmlspecialchars($_POST['date_rep_form']);
        $sql = "SELECT id_qst from repenses where id_qst = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "   UPDATE   repenses set date_rep = ? where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$date_rep_form, $id_qst_form]);
            $row = $exec->rowCount();
            if ($row === 1) {

                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-success text-center ' > 
                   تم التعديل
                </div>  ";
                header('location:ecrits.php');
            } else {
                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   لقد حصل خطا
                </div>  ";
                header('location:ecrits.php');
            }
        } else {
            $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:ecrits.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:ecrits.php');
    }
}





//   change_date_reunion kitabi 


if (isset($_POST['change_date_reunion'])) {

    if (
        isset($_POST['date_reunion_form'], $_POST['id_qst_form'])
        && !empty(trim($_POST['date_reunion_form']))
        && !empty(trim($_POST['id_qst_form']))
    ) {

        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $date_reunion_form = htmlspecialchars($_POST['date_reunion_form']);

        $sql = "SELECT id_qst from questions where id_qst = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "   UPDATE   questions set date_reunion = ? where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$date_reunion_form, $id_qst_form]);
            $row = $exec->rowCount();
            if ($row === 1) {

                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-success text-center ' > 
                   تم التعديل
                </div>  ";
                header('location:ecrits.php');
            } else {
                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   لقد حصل خطا
                </div>  ";
                header('location:ecrits.php');
            }
        } else {
            $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:ecrits.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:ecrits.php');
    }
}





//   change_date_env kitabi 


if (isset($_POST['change_date_env'])) {

    if (
        isset($_POST['date_env_form'], $_POST['id_qst_form'])
        && !empty(trim($_POST['date_env_form']))
        && !empty(trim($_POST['id_qst_form']))
    ) {

        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $date_env_form = htmlspecialchars($_POST['date_env_form']);

        $sql = "SELECT id_qst from questions where id_qst = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "   UPDATE   questions set date_env = ? where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$date_env_form, $id_qst_form]);
            $row = $exec->rowCount();
            if ($row === 1) {

                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-success text-center ' > 
                   تم التعديل
                </div>  ";
                header('location:ecrits.php');
            } else {
                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   لقد حصل خطا
                </div>  ";
                header('location:ecrits.php');
            }
        } else {
            $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:ecrits.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:ecrits.php');
    }
}





//  change_date_reunion_orale


if (isset($_POST['change_date_reunion_orale'])) {

    if (
        isset($_POST['date_reunion_form'], $_POST['id_qst_form'])
        && !empty(trim($_POST['date_reunion_form']))
        && !empty(trim($_POST['id_qst_form']))
    ) {

        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $date_reunion_form = htmlspecialchars($_POST['date_reunion_form']);

        $sql = "SELECT id_qst from questions where id_qst = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "   UPDATE   questions set date_reunion = ? where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$date_reunion_form, $id_qst_form]);
            $row = $exec->rowCount();
            if ($row === 1) {

                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-success text-center ' > 
                   تم التعديل
                </div>  ";
                header('location:orales.php');
            } else {
                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   لقد حصل خطا
                </div>  ";
                header('location:orales.php');
            }
        } else {
            $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:orales.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:orales.php');
    }
}






/////////////////




// change_date_env_orale 

if (isset($_POST['change_date_env_orale'])) {

    if (
        isset($_POST['date_env_form'], $_POST['id_qst_form'])
        && !empty(trim($_POST['date_env_form']))
        && !empty(trim($_POST['id_qst_form']))
    ) {

        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $date_env_form = htmlspecialchars($_POST['date_env_form']);

        $sql = "SELECT id_qst from questions where id_qst = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "   UPDATE   questions set date_env = ? where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$date_env_form, $id_qst_form]);
            $row = $exec->rowCount();
            if ($row === 1) {

                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-success text-center ' > 
                   تم التعديل
                </div>  ";
                header('location:orales.php');
            } else {
                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   لقد حصل خطا
                </div>  ";
                header('location:orales.php');
            }
        } else {
            $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:orales.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:orales.php');
    }
}


// change date rep chafawi : 


if (isset($_POST['change_date_rep_chafawi'])) {

    if (
        isset($_POST['date_rep_form'], $_POST['id_qst_form'])
        && !empty(trim($_POST['date_rep_form']))
        && !empty(trim($_POST['id_qst_form']))
    ) {


        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $date_rep_form = htmlspecialchars($_POST['date_rep_form']);
        $sql = "SELECT id_qst from repenses where id_qst = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "   UPDATE   repenses set date_rep = ? where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$date_rep_form, $id_qst_form]);
            $row = $exec->rowCount();
            if ($row === 1) {

                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-success text-center ' > 
                   تم التعديل
                </div>  ";
                header('location:orales.php');
            } else {
                $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   لقد حصل خطا
                </div>  ";
                header('location:orales.php');
            }
        } else {
            $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:orales.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:orales.php');
    }
}








// change date eng orale



if (isset($_POST['change_date_eng_orale'])) {

    if (
        isset($_POST['date_eng_form'], $_POST['id_qst_form'])
        && !empty(trim($_POST['date_eng_form']))
        && !empty(trim($_POST['id_qst_form']))
    ) {

        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $date_eng_form = htmlspecialchars($_POST['date_eng_form']);

        $sql = "SELECT id_qst from questions where id_qst = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "   UPDATE   questions set date_eng = ? where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$date_eng_form, $id_qst_form]);
            $row = $exec->rowCount();
            if ($row === 1) {

                $_SESSION['updated']  = " 
                <div class='alert alert-success text-center ' > 
                   تم التعديل
                </div>  ";
                header('location:orales.php');
            } else {
                $_SESSION['updated']  = " 
                <div class='alert alert-warning text-center ' > 
                   لقد حصل خطا
                </div>  ";
                header('location:orales.php');
            }
        } else {
            $_SESSION['updated']  = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:orales.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:orales.php');
    }
}



//




// change date eng ecrit



if (isset($_POST['change_date_eng_ecrit'])) {

    if (
        isset($_POST['date_eng_form'], $_POST['id_qst_form'])
        && !empty(trim($_POST['date_eng_form']))
        && !empty(trim($_POST['id_qst_form']))
    ) {

        $id_qst_form = htmlspecialchars($_POST['id_qst_form']);
        $date_eng_form = htmlspecialchars($_POST['date_eng_form']);

        $sql = "SELECT id_qst from questions where id_qst = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_qst_form]);
        $row = $exec->rowCount();
        if ($row === 1) {

            $sql = "   UPDATE   questions set date_eng = ? where id_qst = ?    ";
            $exec  =  $cnx->prepare($sql);

            $exec->execute([$date_eng_form, $id_qst_form]);
            $row = $exec->rowCount();
            if ($row === 1) {

                $_SESSION['updated']  = " 
                <div class='alert alert-success text-center ' > 
                   تم التعديل
                </div>  ";
                header('location:ecrits.php');
            } else {
                $_SESSION['updated']  = " 
                <div class='alert alert-warning text-center ' > 
                   لقد حصل خطا
                </div>  ";
                header('location:ecrits.php');
            }
        } else {
            $_SESSION['updated']  = " 
                <div class='alert alert-warning text-center ' > 
                   خطا في رقم السؤال
                </div>  ";
            header('location:ecrits.php');
        }
    } else {
        $_SESSION['pdf_rep']  = " 
                <div class='alert alert-warning text-center ' > 
                   ادخل جميع البيانات
                </div>  ";
        header('location:ecrits.php');
    }
}



//



if( isset( $_GET['id_session_active'] ) && ! empty($_GET['id_session_active'] ) ) {


  $id_session_active = htmlspecialchars($_GET['id_session_active']);

        $sql = "SELECT id_session from sessions where id_session = ?    ";
        $exec  =  $cnx->prepare($sql);

        $exec->execute([$id_session_active]);
        $row = $exec->rowCount();
        if ($row === 1) {
        $sql = "UPDATE  sessions set etat_session = 0    ";
        $exec  =  $cnx->prepare($sql);
        $exec->execute();


        $sql = "UPDATE  sessions set etat_session = 1 where id_session = ?   ";
        $exec  =  $cnx->prepare($sql);
        $exec->execute([$id_session_active]);
        $row = $exec->rowCount();
        if ($row === 1) {
            $_SESSION['error_sess']  = " 
                <div class='alert alert-success text-center ' > 
                  تم التعديل
                </div>  ";
            header('location:add_session.php');
        }
        }else {
        $_SESSION['error_sess']  = " 
                <div class='alert alert-warning text-center ' > 
                 خطا
                </div>  ";
        header('location:add_session.php');
        }


}


// taajil

if (isset($_GET['taajil'],  $_GET['action']) && count($_GET) === 2)  

{

    $id =  htmlspecialchars($_GET['taajil']);
    $action =  htmlspecialchars($_GET['action']);

    // Verify Id qst GET :
    $sql = "SELECT id_qst from questions where id_qst = ? ";
    $exec  =  $cnx->prepare($sql);

    $exec->execute([$id]);
    $row = $exec->rowCount();
    if ($row === 1) {

        if ($action == '0' || $action == '1') {
            $sql = "UPDATE questions set taajil = ? where  id_qst = ? ";
            $exec  =  $cnx->prepare($sql);
            $exec->execute([$action, $id]);
            $_SESSION['updated_button'] =
            " <div class='alert  alert-success text-center ' > 
            لقد تم التغيير بنجاح
            </div> ";
            header("location:modifications.php?idqst=$id");
        } else {
            $_SESSION['updated_button'] =
            " <div class='alert  alert-danger text-center ' > 
           1 لقد حصل خطأ
            </div> ";
            header("location:modifications.php?idqst=$id");
        }
    } else {
        $_SESSION['updated_button'] =
        " <div class='alert  alert-danger text-center ' > 
           2 لقد حصل خطأ
            </div> ";
        header("location:modifications.php?idqst=$id");
    }

}


// taraf taajil 

if (isset($_GET['taraf_taajil'],  $_GET['action']) && count($_GET) === 2) {

    $id =  htmlspecialchars($_GET['taraf_taajil']);
    $action =  htmlspecialchars($_GET['action']);

    // Verify Id qst GET :
    $sql = "SELECT id_qst from questions where id_qst = ? ";
    $exec  =  $cnx->prepare($sql);

    $exec->execute([$id]);
    $row = $exec->rowCount();
    if ($row === 1) {

        if ($action == '0' || $action == '1') {
            switch ($action) {
                case '1':  $action = 'النائب' ; break;
                case '0':  $action = 'الوزير' ; break;
                
                default:
                     '/' ;
                    break;
            }
            

            $sql = "UPDATE questions set taraf_taajil = ? where  id_qst = ? ";
            $exec  =  $cnx->prepare($sql);
            $exec->execute([$action, $id]);
            $_SESSION['updated_button'] =
                " <div class='alert  alert-success text-center ' > 
            لقد تم التغيير بنجاح
            </div> ";
            header("location:modifications.php?idqst=$id");
        } else {
            $_SESSION['updated_button'] =
                " <div class='alert  alert-danger text-center ' > 
           1 لقد حصل خطأ
            </div> ";
            header("location:modifications.php?idqst=$id");
        }
    } else {
        $_SESSION['updated_button'] =
            " <div class='alert  alert-danger text-center ' > 
           2 لقد حصل خطأ
            </div> ";
        header("location:modifications.php?idqst=$id");
    }
}




// taghyir lajna

if (
    isset($_GET['up_lajna_delete'])

    && (count($_GET) === 1)

    && !empty(trim($_GET['up_lajna_delete']))

    && filter_var($_GET['up_lajna_delete'], FILTER_VALIDATE_INT)

) {



    $id_dep =  htmlspecialchars($_GET['up_lajna_delete']);



    try {



         $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
        
       
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep from deputes  where id_dep = ?  ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE deputes set  lajna = 0  where id_dep = ?  ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

               

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> خطا </h1> <br>  

                <a href='deputes.php' > <button> العودة </button> </a>



                ";
            }
        } else {

             

            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}



///////////////



if (

    isset($_GET['up_lajna_add'])

    && (count($_GET) === 1)

    && !empty(trim($_GET['up_lajna_add']))

    && filter_var($_GET['up_lajna_add'], FILTER_VALIDATE_INT)

) {



    $id_dep =  htmlspecialchars($_GET['up_lajna_add']);



    try {



         $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
       
      

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep from deputes  where id_dep = ?  ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE deputes set  lajna = 1  where id_dep = ?  ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

                

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> خطا </h1> <br>  

                <a href='deputes.php' > <button> العودة </button> </a>  ";
            }
        } else {

            
            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}


///////////////



if (
    isset($_GET['up_etat_actif'])

    && (count($_GET) === 1)

    && !empty(trim($_GET['up_etat_actif']))

    && filter_var($_GET['up_etat_actif'], FILTER_VALIDATE_INT)

) {



    $id_dep =  htmlspecialchars($_GET['up_etat_actif']);



    try {



        $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
       
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep from deputes  where id_dep = ?  ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE deputes set  etat = 1  where id_dep = ?  ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> خطا </h1> <br>  

                <a href='deputes.php' > <button> العودة </button> </a>



                ";
            }
        } else {

          

            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}



////////////





if (
    isset($_GET['up_etat_off'])

    && (count($_GET) === 1)

    && !empty(trim($_GET['up_etat_off']))

    && filter_var($_GET['up_etat_off'], FILTER_VALIDATE_INT)



) {



    $id_dep =  htmlspecialchars($_GET['up_etat_off']);



    try {

          $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
        

         

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT id_dep from deputes  where id_dep = ?  ";

        $execution = $cnx->prepare($sql);

        $execution->execute([$id_dep]);



        $row = $execution->rowCount();

        if ($row  === 1) {



            $sql_update = "UPDATE deputes set  etat = 0  where id_dep = ?  ";

            $execution2 = $cnx->prepare($sql_update);

            $execution2->execute([$id_dep]);

            $row2 = $execution2->rowCount();

            if ($row2  === 1) {

                

                $_SESSION['updated'] =

                    "<div class='alert-success alert mt-5 text-center' >

                     تم التغيير بنجاح        

                </div>";

                header('location:deputes.php');
            } else {

                echo " <h1> خطا </h1> <br>  



                <a href='deputes.php' > <button> العودة </button> </a>



                ";
            }
        } else {

            

            $_SESSION['updated'] =

                "<div class='alert-warning alert mt-5 text-center' >

                حصل خطأ ما ... يرجى المحاولة لاحقا      

            </div>";

            header('location:deputes.php');
        }
    } catch (PDOException $e) {

        echo   $e->getMessage();
    }
}

