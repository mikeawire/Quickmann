

$(document).ready(function(){


    $("#amount_naira").keyup(function(){
        $('#amount').val((parseFloat($('#amount_naira').val())) *100);
      
     
    
    
    });
});