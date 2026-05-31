$(document).ready(function(){
$('.choose').click(function(){

 
    $('#profile_photo').click();


});

$('#profile_photo').change(function(){





    photo = $('#profile_photo').val() ;

    $('#photo').val(photo);


this.form.submit();
    
    
 
});

});




(function ($) {
    "use strict";

    
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    

})(jQuery);

//script
$(document).ready(function(){
    $('#property_search').hide()
$('.property-btn').click(function(){
$('#login-form').hide(1000);
$('#property_search').show(2000);

$('.property-btn').hide(400);
$('.login-btn').show(2000);

});

$('.login-btn').click(function(){
    $('#property_search').hide(1000);
    $('#login-form').show(2000);

    $('.login-btn').hide(400);
    $('.property-btn').show(2000);
  
    
    });

});





$(document).ready(function(){


    
    $('.loginBtn').click(function(){
        
  var phone = $('#phone_number').val();
  
       
        //getting all values
       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/get_phone",
            method: 'POST',
            data:
            {
            'phone':phone,
            },
            
           beforeSend: function() {
          
       
            $(".result").html("<p class='text-success'> Please wait submitting.. </p>");
           
      
        },  

        // on success response
        
        success:function(response) {
           
       
            $(".result").html(response);

            // reset form fields
           
            $(".loginForm")[0].reset();
        },

        // error response
        error:function(e) {
            
            $(".result").html("Some error encountered.");
        }
            
        });
     
    });

});
