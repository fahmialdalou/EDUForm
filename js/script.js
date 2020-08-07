jQuery(document).ready(function(){

      //Empty Validation
      function isEmpty(field) {
        if (typeof field !== undefined) {
            if (jQuery.trim(field.val()) === "") {
                    jQuery(field).addClass('red_bordered');
                    jQuery(field).after('<i class="edu_error_message"> Please check this field.</i>')
                    return true;
            }else{
                jQuery(field).removeClass('red_bordered');
                jQuery(field).parent().find('.edu_error_message').remove();
                return false;
            }
        }
      }
    
    //Form validation
    jQuery('form.edu_form').each(function(){
        jQuery(this).submit(function(event) {
            jQuery(this).find('.edu_error_message').remove();
            jQuery(this).find('input[type="text"],input[type="email"]').each(function(){
                if (isEmpty(jQuery(this))) event.preventDefault();
            });
        });
    });


    jQuery('input[type="text"],input[type="email"]').keypress(function(){
        jQuery(this).parent().find('.edu_error_message').remove();
        jQuery(this).removeClass('red_bordered');
    });

});
