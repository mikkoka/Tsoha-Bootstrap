$(document).ready(function () {
    $(function () {
        
        var ohjaajat = [];
        $.getJSON("http://mkahri.users.cs.helsinki.fi/tsoha/ohjaajat",            
                function (data) {
                    $.each(data, function (i) {
                        ohjaajat.push(data[i].snimi);                   
                    });
                }
        );
        var tutkimusalat = [];
        $.getJSON("http://mkahri.users.cs.helsinki.fi/tsoha/alat",         
                function (data) {
                    $.each(data, function (i) {
                        tutkimusalat.push(data[i].nimi);                   
                    });
                }
        );

    $( "#ohjaajat" ).autocomplete({
      source: ohjaajat
    });   
    $( "#tutkimusalat" ).autocomplete({
      source: tutkimusalat
    });    
   
  });

});
