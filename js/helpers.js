function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) 
    {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

jQuery(document).ready(function() {
    jQuery("#priceoffer").maskMoney();
    jQuery("#measurementoffer").maskMoney();
    jQuery('#delete_image_file').live('click', function(e){
        e.preventDefault();
        if(window.confirm("Are you sure?"))
        {
            var file_name = jQuery(this).data("id");
            var src = jQuery('img#'+file_name).attr("src");
            var filename= src.split('\\').pop().split('/').pop()+',';
            jQuery('img#'+file_name).remove();
            jQuery(this).remove();
            jQuery('#all_files_name').val(jQuery('#all_files_name').val().replace(filename, ''));
            if(jQuery('#files_to_delete').val() == '')
            {
                 jQuery('#files_to_delete').val(filename); 
            }
            else
            {
                jQuery('#files_to_delete').val(jQuery('#files_to_delete').val()+filename);
            }
        }
    });
});