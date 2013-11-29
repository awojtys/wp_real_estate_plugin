jQuery(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url =  '/wp-content/plugins/real_estate_office/server/php/',
        uploadButton = jQuery('<div/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = jQuery(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    jQuery('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = jQuery('<div/>').appendTo('#files');
        jQuery.each(data.files, function (index, file) {
            var node = jQuery('<p/>')
                    .append(jQuery('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = jQuery(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append(file.error);
        }
        if (index + 1 === data.files.length) {
            data.context.find('div')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        jQuery('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        jQuery.each(data.result.files, function (index, file) {
            var link = jQuery('<a>')
                .attr('target', '_blank')
                .prop('href', file.url);
            jQuery(data.context.children()[index])
                .wrap(link);
        });
    }).on('fileuploadfail', function (e, data) {
        jQuery.each(data.result.files, function (index, file) {
            var error = jQuery('<span/>').text(file.error);
            jQuery(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !jQuery.support.fileInput)
        .parent().addClass(jQuery.support.fileInput ? undefined : 'disabled');
});



jQuery(document).ready(function() {  
    
    jQuery('#saveoffer').live('click', function(e) {
        e.preventDefault();
        jQuery.ajax
        ({  
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'add_offer_with_ajax',  
                description: jQuery('#descriptionoffer').val(),
                picture: jQuery('#pictureoffer').val(),
                type: jQuery('#typeoffer').val(),
                measurement: jQuery('#measurementoffer').val(),
                address: jQuery('#addressoffer').val(),
                price: jQuery('#priceoffer').val(),
                post_type: jQuery('#post_typeoffer').val(),
                post_id: jQuery('#post_idoffer').val(),
                created_post_id: jQuery('.created_post_id').val(),
                all_files_name: jQuery('#all_files_name').val(),
                file_to_delete: jQuery('#files_to_delete').val(),
            },
            success: function(data, textStatus, XMLHttpRequest)
            {
                jQuery('.created_post_id').val(data.post_id);
                
            },
        }); 
    });
});