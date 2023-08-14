<?php


  $cnx = new PDO('mysql:host=localhost;dbname=insap1757363', 'root',  '', array(1002 => 'SET NAMES utf8'));
 

 

if (isset($_POST['session']) && !empty(trim($_POST['session']))) {

    $id_session =  htmlspecialchars($_POST['session']);
    $sql = " SELECT  id_session  from sessions where id_session = ?  ";
    $execution =  $cnx->prepare($sql);
    $execution->execute([$id_session]);

    $row = $execution->rowCount();

    if ($row === 1) {

        // all_qst :
        $sql = " SELECT  count(id_qst) as all_qst
         from questions where id_session = ?  ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $all_qst =  $key['all_qst'];
            if ($all_qst  != 0) {
                $pr_all_qst = 100;
            } else {
                $pr_all_qst = 0;
                $all_qst =  0;
            }
        }

        // orales :
        $sql = " SELECT   count( id_qst ) as orales  
         from questions where id_session = ? and  type_qst = 'b'  ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $orales =  $key['orales'];
            if ($orales  != 0) {

                $pr_chafawi =  round($orales  *  100  /  $all_qst);
            } else {
                $orales =  0;
                $pr_chafawi  = 0;
            }
        }


        // kitabi :
        // $sql = " SELECT   count( id_qst ) as ecrits  
        //  from questions where id_session = ? and  type_qst = 'a'  ";
        // $execution =  $cnx->prepare($sql);
        // $execution->execute([$id_session]);

        // $row = $execution->rowCount();
        // foreach ($execution as $key) {
        //     $ecrits =  $key['ecrits'];
        // }


        // kitabi :
        $sql = " SELECT   count( id_qst ) as ecrits 
         from questions where id_session = ? and  type_qst = 'a'  ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $ecrits =  $key['ecrits'];

            if ($ecrits  != 0) {
                $non_rep   = $all_qst - $ecrits;
                $pr_kitabi =  round($ecrits  *  100  /  $all_qst);
            } else {
                $ecrits =  0;
                $pr_kitabi  = 0;
            }
        }


        // repondu :
        $sql = "SELECT  count(id_rep) as repondu   from repenses  
        inner join questions on questions.id_qst =  repenses.id_qst 
        where  ( 
            	(repenses.fichier_rep is not NULL   and repenses.fichier_rep != '' ) 
            	and
        		repenses.fichier_rep is  not NULL  and repenses.fichier_rep != ''  
                  
                and questions.id_session = ?
        		)  ";

        $execution =  $cnx->prepare($sql);

        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $repondu =  $key['repondu'];

            if ($repondu  != 0) {
                $non_rep   = $all_qst - $repondu;
                $pr_repondu = round($repondu  *  100  /  $all_qst);
            } else {
                $repondu =  0;
                $pr_repondu  = 0;
                $non_rep   = $all_qst - $repondu;
            }
        }

        if ($pr_all_qst == 0) {
            $pr_non_repondu = 0;
        } else {
            $pr_non_repondu = 100  -   round($pr_repondu);
        }




        // repondu chafawi 
 
        $sql = "SELECT  count(id_rep) as repondu_chafawi   from repenses  
        inner join questions on questions.id_qst =  repenses.id_qst 
        where  ( 
            	
                (repenses.fichier_rep is not NULL   and repenses.fichier_rep != '' ) 

            	and

        		repenses.fichier_rep is  not NULL  and repenses.fichier_rep != ''  

                and  questions.type_qst = 'b'

                and questions.id_session = ?

        		)  ";

        $execution =  $cnx->prepare($sql);

        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $repondu_chafawi =  $key['repondu_chafawi'];

            if ($repondu_chafawi  != 0) {
                $non_rep   = $orales - $repondu_chafawi;
                $pr_repondu_chafawi = round($repondu_chafawi  *  100  /  $orales);
            } else {
                $repondu_chafawi =  0;
                $pr_repondu_chafawi  = 0;
                
            }
        }







        // repondu_kitabi  

        $sql = "SELECT  count(id_rep) as repondu_kitabi   from repenses  
        inner join questions on questions.id_qst =  repenses.id_qst 
        where  ( 
            	
                (repenses.fichier_rep is not NULL   and repenses.fichier_rep != '' ) 

            	and

        		repenses.fichier_rep is  not NULL  and repenses.fichier_rep != ''  

                and  questions.type_qst = 'a'

                and questions.id_session = ?

        		)  ";

        $execution =  $cnx->prepare($sql);

        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $repondu_kitabi =  $key['repondu_kitabi'];

            if ($repondu_kitabi  != 0 ) {
                $non_rep   = $ecrits - $repondu_kitabi;
                $pr_repondu_kitabi = round($repondu_kitabi  *  100  /  $ecrits);
            } else {
                $repondu_kitabi =  0;
                $pr_repondu_kitabi  = 0;
            }
        }



        //  30 jours sasn rep :

        $sql = "SELECT count(id_qst) as total_non_rep_30   FROM questions   
                where   id_qst  not in (  select id_qst from repenses  ) 
                and datediff( now() , date_env ) > 30  and id_session = ?  ";

        $execution =  $cnx->prepare($sql);

        $execution->execute( [$id_session] );

        
        foreach ($execution as $key) {

            $total_non_rep_30 = $key['total_non_rep_30'];

            if ($total_non_rep_30  != 0) {
                
                $pr_total_non_rep_30 = round($total_non_rep_30  *  100  /  $all_qst);

            } else {
              

                $total_non_rep_30 =  0;
                $pr_total_non_rep_30  = 0;
                
            }
        }


        echo " 

    <h1 class='text-center m-3'>
      <i class='fas fa-chart-bar icone_anim'></i>
        <span class='wow'> الإحصائيات </span>
    </h1>

    <div class='details wow'  >

        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_all_qst% ;' ></div> 
                </div>
                <div class='title' > 
                المجموع
                <br>
                (% $pr_all_qst) $all_qst 
                </div>
            </center>
        </div>

        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_kitabi% ;' ></div> 
                </div>
                <div class='title' > 
                الكتابية
                <br>
                (% $pr_kitabi)
                 $ecrits  

                 </div>
            </center>
        </div>
 


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height:$pr_chafawi% ;' ></div> 
                </div>
                <div class='title' >
                الشفوية
                 <br>
                 (% $pr_chafawi) $orales  
                 </div>
            </center>
        </div>

        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_repondu% ;' ></div> 
                </div>
                <div class='title' > 
                 تم الرد
                  <br>
                (% $pr_repondu) $repondu 
              
                </div>
            </center>
        </div>        
 
        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_non_repondu% ;' ></div> 
                </div>
                <div class='title' >   
                
                لم يتم الرد
                <br>
                (% $pr_non_repondu)  $non_rep 
                </div>
            </center>
        </div> 


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_total_non_rep_30% ;' ></div> 
                </div>
                <div class='title' >   
                
    30 يوم
        <br>
    بدون رد   
            
                <br>
                (% $pr_total_non_rep_30)  $total_non_rep_30 
                </div>
            </center>
        </div> 


    </div>";



        // madros chaafawi 

        $sql = " SELECT count( id_qst ) as madros_chafawi from questions where id_session =  ? 
                and type_qst = 'b' and date_reunion is not NULL;    ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $madros_chafawi =  $key['madros_chafawi'];
        }
        if ($madros_chafawi != 0) {
            $pr_madros_chafawi =  round($madros_chafawi  *  100  / $orales);
        } else {
            $pr_madros_chafawi = 0;
        }


        // makbol_chafawi: 
        $sql = " SELECT   count( id_qst ) as makbol_chafawi 
         from questions where id_session = ? and  type_qst = 'b'  and etat_qst = 'c' ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $makbol_chafawi =  $key['makbol_chafawi'];
        }
        if ($makbol_chafawi != 0) {
            $pr_makbol_chafawi =  round($makbol_chafawi  *  100  / $orales);
        } else {
            $pr_makbol_chafawi = 0;
        }


        // marfod_chafawi:
        $sql = " SELECT   count( id_qst ) as marfod_chafawi 
         from questions where id_session = ? and  type_qst = 'b'  and etat_qst = 'r' ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $marfod_chafawi =  $key['marfod_chafawi'];
        }

        if ($marfod_chafawi != 0 && $orales != 0) {
            $pr_marfod_chafawi =  round($marfod_chafawi  *  100  / $orales);
        } else {
            $pr_marfod_chafawi = 0;
        }




        $notyet_orales = $orales - ($marfod_chafawi  + $makbol_chafawi);

        if ($notyet_orales == 0) {
            $pr_notyet_orales = 0;
        } else {
            $pr_notyet_orales = 100 - ($pr_marfod_chafawi + $pr_makbol_chafawi);
        }




        // mashob chafawi :
        $sql = " SELECT   count( id_qst ) as mashob_chafawi 
         from questions where id_session = ? and  type_qst = 'b'  and mashob = '1' ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $mashob_chafawi =  $key['mashob_chafawi'];
        }
        if ($mashob_chafawi != 0) {
            $pr_mashob_chafawi =  round($mashob_chafawi  *  100  / $orales);
        } else {
            $pr_mashob_chafawi = 0;
        }



        // mohawal chafawi :
        $sql = " SELECT   count( id_qst ) as mohawal_chafawi 
         from questions where id_session = ? and  type_qst = 'b'  and transfert = '1' ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $mohawal_chafawi =  $key['mohawal_chafawi'];
        }
        if ($mohawal_chafawi != 0) {
            $pr_mohawal_chafawi =  round($mohawal_chafawi  *  100  / $orales);
        } else {
            $pr_mohawal_chafawi = 0;
        }


        // envoyer chafawi

        $sql = " SELECT   count( id_qst ) as envoyer 
         from questions where id_session = ? and  type_qst = 'b'  and 
          ( date_env != ''  or  date_env != NULL ) 
         ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $envoyer =  $key['envoyer'];
        }
        if ($envoyer != 0) {
            $pr_envoyer =  round($envoyer  *  100  / $orales);
        } else {
            $pr_envoyer = 0;
        }


        echo "
 


  <h2 class='text-center mt-5' > الشفوية </h2>

  <div class='details wow'  >
        





        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage ' style='height: $pr_madros_chafawi% ;' ></div> 
                </div>
                <div class='title' > 
                المدروسة            
                <br>
                (% $pr_madros_chafawi) $madros_chafawi 
                </div>
            </center>
        </div>


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage  bg-success' style='height: $pr_makbol_chafawi% ;' ></div> 
                </div>
                <div class='title' > 
                المقبولة
                <br>
                (% $pr_makbol_chafawi) $makbol_chafawi 
                </div>
            </center>
        </div>

        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage bg-danger' style='height: $pr_marfod_chafawi% ;' ></div> 
                </div>
                <div class='title' > 
                المرفوضة
                <br>
                (% $pr_marfod_chafawi)
                 $marfod_chafawi   

                 </div>
            </center>
        </div>
 


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage bg-warning' style='height:$pr_notyet_orales% ;' ></div> 
                </div>
                <div class='title' >
                لم تعالج
                 <br>
                 (% $pr_notyet_orales) $notyet_orales  
                 </div>
            </center>
        </div>


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_repondu_chafawi% ;' ></div> 
                </div>
                <div class='title' > 
                  تم الرد  
                  <br>
                (% $pr_repondu_chafawi) $repondu_chafawi 

                </div>
            </center>
        </div>    



        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_mashob_chafawi% ;' ></div> 
                </div>
                <div class='title' > 
                 المسحوبة
                  <br>
                (% $pr_mashob_chafawi) $mashob_chafawi 
              
                </div>
            </center>
        </div>        
 
        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_mohawal_chafawi% ;' ></div> 
                </div>
                <div class='title' >   
                المحولة
                <br>
                (% $pr_mohawal_chafawi)  $mohawal_chafawi 
                </div>
            </center>
        </div>


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage bg-primary' style='height: $pr_envoyer% ;' ></div> 
                </div>
                <div class='title' > 
                التي ارسلت للحكومة
                <br>
                (% $pr_envoyer) $envoyer 
                </div>
            </center>
        </div>

    </div> ";

        //   kitabi ///////////////////// badel asam les var


        // madros kitabi 

        $sql = " SELECT count( id_qst ) as madros_kitabi from questions where id_session =  ? 
                and type_qst = 'a' and date_reunion is not NULL;    ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $madros_kitabi =  $key['madros_kitabi'];
        }
        if ($madros_kitabi != 0) {
            $pr_madros_kitabi =  round($madros_kitabi  *  100  / $ecrits);
        } else {
            $pr_madros_kitabi = 0;
        }


        // makbol_kitabi:
        $sql = " SELECT   count( id_qst ) as makbol_chafawi 
         from questions where id_session = ? and  type_qst = 'a'  and etat_qst = 'c' ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $makbol_chafawi =  $key['makbol_chafawi'];
        }

        if ($makbol_chafawi != 0) {
            $pr_makbol_chafawi =  round($makbol_chafawi  *  100  / $ecrits);
        } else {
            $pr_makbol_chafawi = 0;
        }


        // marfod_chafawi:
        $sql = " SELECT   count( id_qst ) as marfod_chafawi 
         from questions where id_session = ? and  type_qst = 'a'  and etat_qst = 'r' ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $marfod_chafawi =  $key['marfod_chafawi'];
        }
        if ($marfod_chafawi != 0 && $ecrits != 0) {
            $pr_marfod_chafawi =  round($marfod_chafawi  *  100  / $ecrits);
        } else {
            $pr_marfod_chafawi = 0;
        }





        $notyet_orales = $ecrits - ($marfod_chafawi  + $makbol_chafawi);
        // $pr_notyet_orales = 100 - ($pr_marfod_chafawi + $pr_makbol_chafawi);

        if ($notyet_orales == 0) {
            $pr_notyet_orales = 0;
        } else {
            $pr_notyet_orales = 100 - ($pr_marfod_chafawi + $pr_makbol_chafawi);
        }

        // mashob chafawi :
        $sql = " SELECT   count( id_qst ) as mashob_chafawi 
         from questions where id_session = ? and  type_qst = 'a'  and mashob = '1' ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $mashob_chafawi =  $key['mashob_chafawi'];
        }
        if ($mashob_chafawi != 0) {
            $pr_mashob_chafawi =  round($mashob_chafawi  *  100  / $ecrits);
        } else {
            $pr_mashob_chafawi = 0;
        }


        // mohawal chafawi :
        $sql = " SELECT   count( id_qst ) as mohawal_chafawi 
         from questions where id_session = ? and  type_qst = 'a'  and transfert = '1' ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $mohawal_chafawi =  $key['mohawal_chafawi'];
        }
        if ($mohawal_chafawi != 0) {
            $pr_mohawal_chafawi =  round($mohawal_chafawi  *  100  / $ecrits);
        } else {
            $pr_mohawal_chafawi = 0;
        }


        // envoyer kitabi

        $sql = " SELECT   count( id_qst ) as envoyer 
         from questions where id_session = ? and  type_qst = 'a'  and 
          ( date_env != ''  or  date_env != NULL ) 
         ";
        $execution =  $cnx->prepare($sql);
        $execution->execute([$id_session]);

        $row = $execution->rowCount();
        foreach ($execution as $key) {
            $envoyer =  $key['envoyer'];
        }
        if ($envoyer != 0) {
            $pr_envoyer =  round($envoyer  *  100  / $ecrits);
        } else {
            $pr_envoyer = 0;
        }


        echo "
 
  <h2 class='text-center mt-5' > الكتابية </h2>

  <div class='details wow'  >
        



        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage ' style='height: $pr_madros_kitabi% ;' ></div> 
                </div>
                <div class='title' > 
                المدروسة            
                <br>
                (% $pr_madros_kitabi) $madros_kitabi 
                </div>
            </center>
        </div>

        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage bg-success' style='height: $pr_makbol_chafawi% ;' ></div> 
                </div>
                <div class='title' > 
                المقبولة
                <br>
                (% $pr_makbol_chafawi) $makbol_chafawi 
                </div>
            </center>
        </div>

        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage bg-danger' style='height: $pr_marfod_chafawi% ;' ></div> 
                </div>
                <div class='title' > 
                المرفوضة
                <br>
                (% $pr_marfod_chafawi)
                 $marfod_chafawi   
                 </div>
            </center>
        </div>
 


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage bg-warning' style='height:$pr_notyet_orales% ;' ></div> 
                </div>
                <div class='title' >
                لم تعالج
                 <br>
                 (% $pr_notyet_orales) $notyet_orales  
                 </div>
            </center>
        </div>



        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage ' style='height: $pr_repondu_kitabi% ;' ></div> 
                </div>
                <div class='title' > 
                تم الرد            
                <br>
                (% $pr_repondu_kitabi) $repondu_kitabi 
                </div>
            </center>
        </div>


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage' style='height: $pr_mashob_chafawi% ;' ></div> 
                </div>
                <div class='title' > 
                 المسحوبة
                  <br>
                (% $pr_mashob_chafawi) $mashob_chafawi 
              
                </div>
            </center>
        </div>    


        <div class='detail'>
            <center>
                <div class='pilier' > 
                    <div class='pourcentage bg-primary' style='height: $pr_envoyer% ;' ></div> 
                </div>
                <div class='title' > 
                التي ارسلت للحكومة
                <br>
                (% $pr_envoyer) $envoyer 
                </div>
            </center>
        </div>

    </div>

    ";


        //  par wizara

        echo " <h2 class='text-center mt-5 ' > الوزارات </h2> "; 

        echo " <div class='details wow mb-5'  > ";

            // sql id  wizara :

                $sql = "SELECT  distinct( nom_m ) ,  questions.id_m as  id_m   
                    from    questions
                    inner join ministeres on questions.id_m = ministeres.id_m 
                    inner join sessions on sessions.id_session = questions.id_session 
                    where questions.id_session =   ?  ";
                   

                $execution2 =  $cnx->prepare($sql);
                $execution2->execute( [$id_session] );

                foreach ($execution2 as $key)  
                {

                    $id_m = $key['id_m'];
                    $nom_m = $key['nom_m'];

                    $sql = "SELECT   count(id_qst) as total_m    from    questions
                            inner join ministeres on questions.id_m = ministeres.id_m 
                            inner join sessions on sessions.id_session = questions.id_session 
                            where  questions.id_session =   ?  and  questions.id_m =  '$id_m'  ";

                    $execution =  $cnx->prepare($sql);
                    $execution->execute([$id_session]);

                    foreach ($execution as $key)  {

                        $total_m = $key['total_m'] ;

                        if ($total_m != 0) {

                            $pr_total_m =  round( $total_m  *  100  / $all_qst , 2 );

                        } else {

                            $pr_total_m = 0;

                        }


                         echo "  <div class='detail'>
                                <center>
                                    <div class='pilier' > 
                                        <div class='pourcentage ' style='height: $pr_total_m% ;' ></div> 
                                    </div>
                                    <div class='title' style='font-size:14px;' > 
                                      $total_m <br>
                                    <hr>
                                    (% $pr_total_m) $nom_m 
                                    </div>
                                </center>
                            </div>";
                            
                    }


                }


      echo " </div>";




        //  par المجموعات البرلمانية

        echo " <h2 class='text-center mt-5 ' > المجموعات البرلمانية </h2> ";

        echo " <div class='details wow mb-5'  > ";

        // sql id  المجموعات البرلمانية :

        $sql = "SELECT distinct (groupes.nom) ,  groupes.id_groupe from    groupes 
           
             inner join deputes on deputes.id_groupe = groupes.id_groupe 
             inner join questions on deputes.id_dep = questions.id_dep 
             where  questions.id_session =  ? 
        ";

        $execution2 =  $cnx->prepare($sql);
        $execution2->execute([$id_session]);

        foreach ($execution2 as $key) {


            $nom_groupe = $key['nom'];
            $id_groupe = $key['id_groupe'];

            $sql = "SELECT   count(id_qst) as total_qst_grp    from    questions
                            inner join deputes on deputes.id_dep = questions.id_dep 
                            inner join groupes on groupes.id_groupe = deputes.id_groupe 
                            inner join sessions on sessions.id_session = questions.id_session 
                            where  questions.id_session =  ?  and  groupes.id_groupe  = '$id_groupe' ";

            $execution =  $cnx->prepare($sql);
            $execution->execute([$id_session]);

            foreach ($execution as $key) {

                $total_qst_grp = $key['total_qst_grp'];

                if ($total_qst_grp != 0) {

                    $pr_total_qst_grp =  round($total_qst_grp  *  100  / $all_qst, 2);
                } else {

                    $pr_total_qst_grp = 0;
                }


                echo "  <div class='detail'>
                                <center>
                                    <div class='pilier' > 
                                        <div class='pourcentage ' style='height: $pr_total_qst_grp% ;' ></div> 
                                    </div>
                                    <div class='title' style='font-size:14px;' > 
                                    <hr>
                                    $total_qst_grp <br>
                                    (% $pr_total_qst_grp) $nom_groupe  
                                    </div>
                                </center>
                            </div>";
            }
        }


        echo " </div>";






        //  par النواب

        echo " <h2 class='text-center mt-5 ' >   النّواب </h2> ";

        echo " <div class='details wow mb-5'  > ";

        // sql id   النواب   :

        $sql = "SELECT DISTINCT deputes.nom , deputes.pnom , deputes.id_dep from deputes 
                inner join questions on deputes.id_dep = questions.id_dep 
                where questions.id_dep in ( select DISTINCT ( id_dep ) from questions where  questions.id_session =  ?  );
             and  questions.id_session =  ? 
        ";

        $execution2 =  $cnx->prepare($sql);
        $execution2->execute([$id_session, $id_session]);

        foreach ($execution2 as $key) {


            $nom = $key['nom'];
            $pnom = $key['pnom'];
            $id_dep = $key['id_dep'];

            $sql = "SELECT   count(id_qst) as total_qst_dept    from    
            questions where id_dep = '$id_dep'   and   id_session =  ?  ";

            $execution =  $cnx->prepare($sql);
            $execution->execute([$id_session]);

            foreach ($execution as $key) {

                $total_qst_dept = $key['total_qst_dept'];

                if ($total_qst_dept != 0) {

                    $pr_total_qst_dept =  round($total_qst_dept  *  100  / $all_qst, 2);
                } else {

                    $pr_total_qst_dept = 0;
                }


                echo "  <div class='detail'>
                                <center>
                                    <div class='pilier' > 
                                        <div class='pourcentage ' style='height: $pr_total_qst_dept% ;' ></div> 
                                    </div>
                                    <div class='title' style='font-size:14px;' > 
                                    <hr>
                                    $nom $pnom <br>
                                    (% $pr_total_qst_dept) $total_qst_dept  
                                    </div>
                                </center>
                        </div>";
            }
        }


        echo " </div>";




    } else {
        echo " <div class='alert alert-warning text-center ' > خطأ في الدورة</div>";
    }
}
