 



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