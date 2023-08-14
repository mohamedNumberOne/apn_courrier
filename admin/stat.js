$('#select_l').on('change', function (e) {
    var stats = document.getElementById('stats');
    var select_l = this.value;
    if (select_l.trim() != "") { 

        stats.innerHTML = '<div> <span>يرجى الإنتظار</span> <div class="anim" > </div> </div>';
        $.post('get_stat.php', { select_l : select_l }, function (data) { 
            stats.innerHTML = data ;
        } );
    }else {
        stats.innerHTML =  "" ;
    }
} ) ;