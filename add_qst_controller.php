<?php

session_start();

if (!isset($_SESSION['admin_connected'])   ||    $_SESSION['admin_connected'] !== "yes") {
    session_destroy();
    unset($_SESSION);
    header("location:index.php");
}

include('qst.class.php');


if (isset($_POST['add_quest'])) {

    if (
        isset(
            $_POST['id_depute'],
            $_POST['type_qst'],
            $_POST['id_ministere'],
            $_POST['date_eng'],
            $_POST['sujet'],
            $_FILES['pdf'],
            $_POST['txt_qst'],
            $_POST['id_session'],
            $_POST['num_qst']

        )
        &&  !empty(trim($_POST['id_depute']))
        &&  !empty(trim($_POST['type_qst']))
        &&  !empty(trim($_POST['sujet']))
        &&  !empty(trim($_POST['id_ministere']))
        &&  !empty($_FILES['pdf'])
        &&  !empty(trim($_POST['txt_qst']))
        &&  !empty(trim($_POST['date_eng']))
        &&  !empty(trim($_POST['id_session']))
        &&  !empty(trim($_POST['num_qst']))
        &&   filter_var($_POST['num_qst'], FILTER_VALIDATE_INT)
    ) {
        // $id_dep, $sujet_qst, $text_qst, $type_qst, $fichier_qst, $id_m , $num_qst


        if ($_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            // get details of the uploaded file
            $fileTmpPath = $_FILES['pdf']['tmp_name'];
            $fileName = $_FILES['pdf']['name'];
            $fileSize = $_FILES['pdf']['size'];
            $fileType = $_FILES['pdf']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // sanitize file-name
            $newFileName =   date("Y-m-d H-i-s") . '.' . $fileExtension;

            // check if file has one of the following extensions
            $allowedfileExtensions = array('pdf', 'PDF');
            if ($fileSize <= 2097152) {
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    // directory in which the uploaded file will be moved
                    $uploadFileDir = 'qst/';
                    $dest_path = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {

                        $question->add_quest(

                            $_POST['id_depute'],
                            $_POST['sujet'],
                            $_POST['txt_qst'],
                            $_POST['type_qst'],
                            $dest_path,
                            $_POST['id_ministere'],
                            $_POST['id_session'],
                            $_POST['num_qst'] ,
                            $_POST['date_eng'] 

                        );
                    } else {
                        $_SESSION['added']  .=  " <div class='alert alert-warning text-center ' > 
                     لم يتم رفع الملف ، اعد المحاولة  من جديد 
                </div>  ";
                        header('location:add_qst.php');
                    }
                } else {
                    $_SESSION['added']  .=  " <div class='alert alert-warning text-center ' > 
                 يرجى ادخال ملف بصيغة   PDF
                </div>   ";
                    header('location:add_qst.php');
                }
            } else {
                $_SESSION['added']  .=  " <div class='alert alert-warning text-center ' > 
                 لا يجب ان يتجاوز حجم الملف 2 ميغابايت
                </div>   ";
                header('location:add_qst.php');
            }

        } else {
            $_SESSION['added']  .= " 
            <div class='alert alert-warning text-center ' > 
                هناك خطأ في الملف 
            </div>  ";
            header('location:add_qst.php');
        }
    } else {
        $_SESSION['added'] = "<div class='alert alert-warning text-center  container '> 
               يرجى ادخال جميع البيانات 
                </div> ";
        header('location:add_qst.php');
    }
} else {
    header('location:add_qst.php');
}
