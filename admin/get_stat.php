<?php





if (

    isset($_POST['select_l'])

    && !empty(trim($_POST['select_l']))

    &&    filter_var($_POST['select_l'], FILTER_VALIDATE_INT)

) {

    $id_loi = htmlspecialchars($_POST['select_l']);

    try {

        $cnx = new PDO('mysql:host=91.216.107.184;dbname=insap1757363', 'insap1757363',  '2109660000Moh!', array(1002 => 'SET NAMES utf8'));

        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



        $sql = " SELECT * from lois where id_loi = ? ";

        $execution =  $cnx->prepare($sql);

        $execution->execute([$id_loi]);

        $row = $execution->rowCount();

        if ($row > 0) {



            $sql_all_ins = "SELECT count( id_dep ) as all_ins from participer where id_loi = ? ";

            $execution =  $cnx->prepare($sql_all_ins);

            $execution->execute([$id_loi]);

            $row = $execution->rowCount();



            if ($row > 0) {



                foreach ($execution as $key) {

                    $all_deputes =  $key['all_ins'];

                    if ($all_deputes > 0) {



                        // SEXE

                        $sql_hommes = "SELECT COUNT( id_dep ) as hommes FROM participer 

                                where id_dep in ( select id_dep from deputes where sexe = 1 ) 

                                and  id_loi = ? ";

                        $get_hommes =  $cnx->prepare($sql_hommes);

                        $get_hommes->execute([$id_loi]);

                        $row = $get_hommes->rowCount();

                        if ($row > 0) {



                            foreach ($get_hommes as $key) {



                                $nb_hommes = $key['hommes'];

                                $nb_femmes =  $all_deputes - $nb_hommes;

                                $hommes   =  round(($nb_hommes * 100) / $all_deputes);

                                $femmes   = round(($nb_femmes *  100) / $all_deputes);

                            }

                            $div_sexe = "

                            <div class='div_stat sexe'>

                                <div class='text-center'> الجنس <i class='fas fa-restroom'></i></div>

        

                                    <div class=' age_sexe '>

                

                                        <div>

                                            <div class='bg-danger stat_sexe'>

                                                <div class='bg-success remplissage' style= 'height:  " . $hommes .  "px  ; '></div>

                                            </div>

                                            رجال <br>

                                            $hommes%

                                        </div>

                

                                        <div>

                                            <div class='bg-danger stat_sexe '>

                                                <div class='bg-success remplissage' style= '  height: " . $femmes .  "px ; '></div>

                                            </div>

                                            نساء <br>

                                            $femmes%

                                        </div>

                

                                    </div>

                            </div>";

                        } else {



                            $femmes = 100;

                            $hommes = 0;



                            $div_sexe = "

                            <div class='div_stat sexe'>

                                <div class='text-center'> الجنس <i class='fas fa-restroom'></i></div>

        

                                    <div class=' age_sexe '>

                

                                        <div>

                                            <div class='bg-danger stat_sexe'>

                                                <div class='bg-success remplissage' style= 'height:  " . $hommes .  "px  ; '></div>

                                            </div>

                                            رجال <br>

                                            $hommes%

                                        </div>

                

                                        <div>

                                            <div class='bg-danger stat_sexe '>

                                                <div class='bg-success remplissage' style= '  height: " . $femmes .  "px ; '></div>

                                            </div>

                                            نساء <br>

                                            $femmes%

                                        </div>

                

                                    </div>

                            </div>

                            

                            ";

                        }



                        //   age 



                        $sql_age_35 = " SELECT COUNT(deputes.id_dep) as age_35 FROM `participer` 

                        inner join deputes on deputes.id_dep = participer.id_dep

                        WHERE id_loi = ? and  YEAR( now() ) -  YEAR(deputes.date_nai) < 35  ";



                        $get_age_35 =  $cnx->prepare($sql_age_35);

                        $get_age_35->execute([$id_loi]);



                        foreach ($get_age_35 as $key) {

                            $age_35 = $key['age_35'];

                            $nisba35   = round(( $age_35 *  100) / $all_deputes);

                        }





                        $sql_age50 = " SELECT COUNT(deputes.id_dep) as age_50 FROM `participer` 

                        inner join deputes on deputes.id_dep = participer.id_dep

                        WHERE id_loi = ? and  YEAR( now() ) -  YEAR(deputes.date_nai) < 50 and YEAR( now() ) -  YEAR(deputes.date_nai) >= 35 ";



                        $get_age50 =  $cnx->prepare($sql_age50);

                        $get_age50->execute([$id_loi]);



                        foreach ($get_age50 as $key) {

                            $age_moins_50 = $key['age_50'];

                            $nisba_moins_50   = round(( $age_moins_50 *  100) / $all_deputes);

                        }





                        $sql_age_plus_50 = " SELECT COUNT(deputes.id_dep) as age_60 FROM `participer` 

                        inner join deputes on deputes.id_dep = participer.id_dep

                        WHERE id_loi = ? and  YEAR( now() ) -  YEAR(deputes.date_nai) >= 50  ";



                        $get_age_pls_50  =  $cnx->prepare($sql_age_plus_50);

                        $get_age_pls_50->execute([$id_loi]);





                        foreach ($get_age_pls_50  as $key) {

                            $age_plus_60 = $key['age_60'];

                            $nisba_plus_50   = round(( $age_plus_60 *  100) / $all_deputes);

                        }







                        //   GROUPE 



                        $sql_groupe = "SELECT * from groupes  ";

                        $all_grps =  $cnx->prepare($sql_groupe);

                        $all_grps->execute( );

                        $row = $all_grps->rowCount();

                        if ($row > 0) {

                            $div_groupes = "

                            <div class=' div_stat groupe'>



                                <div class='text-center w-100' >  

                                    الانتماء السياسي <i class='fas fa-users'></i> 

                                </div>

            

                            <div class=' groupe_det ' >";



                            foreach ($all_grps as $key_all_grp) {

                                $id_groupe = $key_all_grp['id_groupe'];

                                $nom_groupe = $key_all_grp['nom'];



                                $sql_groupe = "SELECT COUNT( participer.id_dep ) as nb_dept from participer 

                                INNER JOIN deputes ON deputes.id_dep = participer.id_dep 

                                INNER JOIN groupes ON deputes.id_groupe = groupes.id_groupe 

                                INNER JOIN lois ON participer.id_loi = lois.id_loi 

                                where deputes.id_groupe =   '$id_groupe' and   lois.id_loi = ? ";

                                $exec =  $cnx->prepare($sql_groupe);

                                $exec->execute([$id_loi]);

                                foreach ($exec as $all_info) {



                                    $nb_dept = $all_info['nb_dept'];

                                    $nisba_groupe = round(($nb_dept * 100) / $all_deputes);

                                    $div_groupes .= "

                                    <div  style= ' width:150px ;  '  class='mt-5'  >

                                        <div class='bg-danger stat_sexe ' style='margin:auto' >

                                            <div class='bg-success remplissage' style= ' height: " . $nisba_groupe .  "px ; '></div>

                                        </div>

                                         <span class='nom_grp' > $nom_groupe  </span> 

                                         <span class='nom_grp' >$nisba_groupe%  </span>

                                    </div>

                                ";

                                }

                            }

                            $div_groupes .= "</div> </div>";

                                          

                            $div_age = "   <div class='div_stat age'>

                            <div class='text-center'> العمر <i class='fas fa-baby'></i>

                                <i class='fas fa-user-tie'></i>

                            </div>



                            <div class='age_sexe' >



                                <div>

                                    <div class='bg-danger stat_sexe  m-auto'>

                                        <div class='bg-success remplissage' 

                                        style='height:   ". $nisba35. "px;'>

                                        </div>

                                    </div>

                                    <span class='nom_grp' >  اقل من 35 سنة   </span>

                                    <span class='nom_grp' > $nisba35% </span>

                                </div>



                                <div>

                                    <div class='bg-danger stat_sexe m-auto'>

                                        <div class='bg-success remplissage' 

                                        style='height:   ". $nisba_moins_50. "px;'>

                                        </div>

                                    </div>

                                    <span class='nom_grp' > اقل من 50 سنة </span>

                                    <span class='nom_grp' >  $nisba_moins_50%</span>

                                </div>

    

                                <div>

                                    <div class='bg-danger stat_sexe m-auto'>

                                        <div class='bg-success remplissage' 

                                        style='height: ". $nisba_plus_50. "px;'>

                                        </div>

                                    </div>

                                    <span class='nom_grp' > اكثر من 50 سنة  </span>

                                        <span class='nom_grp' > $nisba_plus_50% </span>

                                </div>





                            </div>



                        </div>";



                           

                        

                        echo "

                            <div class='age_sexe mt-3'> 

                                $div_age

                                $div_sexe 

                                $div_groupes

                            </div>

                            ";

                        }

                    } else {

                        echo  "<div class='alert-warning alert mt-5 text-center' >

                            لم يسجل  اي شخص حتى الآن

                        </div>";

                    }

                }

            } else {

                echo  "<div class='alert-warning alert mt-5 text-center' >

                لم يسجل  اي شخص حتى الآن

            </div>";

            }

        } else {

        }

    } catch (PDOException $e) {

        echo   $e->getMessage();

    }

}

