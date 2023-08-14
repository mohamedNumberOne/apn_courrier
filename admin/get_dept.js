

$('#select_l').on('change', function (e) {

    var mytable = document.getElementById('table');

    var select_l = this.value;

    if (select_l.trim() != "") { 

        mytable.innerHTML = '<div> <span>يرجى الإنتظار</span> <div class="anim" > </div> </div>';

        $.post('get_dept.php', { select_l: select_l }, function (data) { 

            mytable.innerHTML = data ;

        } );

    }else {

        mytable.innerHTML =  "" ;

    }

} ) ;



//////////////////////



$('#select_wilaya').on('change', function (e) {

    var deputes_liste = document.getElementById('deputes_liste');

    var wilaya = this.value;

    if (wilaya.trim() != "") { 



        deputes_liste.innerHTML = '<div> <span>يرجى الإنتظار</span> <div class="anim" > </div> </div>';

        $.post('get_dept.php', { wilaya : wilaya }, function (data) { 

            deputes_liste.innerHTML = data ;

        } );

    }else {

        deputes_liste.innerHTML =  "" ;

    }

} ) ;