<?php
wp_enqueue_script( 'jquery' );

include_once 'ConnectWithDB.php';
include_once 'Forms.php';
include_once 'ModifyPicture.php';

function init_for_user_page()
{
    wp_register_style('offer_templates_style.css', plugin_dir_url( __FILE__ ).'css/offer_templates_style.css');
    wp_enqueue_style('offer_templates_style.css');
    
    wp_register_style('lightbox.css', plugin_dir_url( __FILE__ ).'css/lightbox.css');
    wp_enqueue_style('lightbox.css');
    
    wp_register_style('screen.css', plugin_dir_url( __FILE__ ).'css/screen.css');
    wp_enqueue_style('screen.css');
    
    wp_register_script('modernizr.custom.js', plugin_dir_url( __FILE__ ).'js/modernizr.custom.js');
    wp_enqueue_script('modernizr.custom.js');
    
    wp_register_script('lightbox-2.6.min.js', plugin_dir_url( __FILE__ ).'js/lightbox-2.6.min.js');
    wp_enqueue_script('lightbox-2.6.min.js');
}


function init_all_files()
{
        
        wp_register_style('bootstrap.min.css', plugin_dir_url( __FILE__ ).'css/bootstrap.css');
        wp_register_style('jquery.fileupload-ui.css', plugin_dir_url( __FILE__ ).'css/jquery.fileupload-ui.css');

        wp_register_script('masks.js', plugin_dir_url( __FILE__ ).'js/masks.js', array('jquery'));
        wp_register_script('jquery.ui.widget.js', plugin_dir_url( __FILE__ ).'js/vendor/jquery.ui.widget.js', array('jquery'));
        wp_register_script('load-image.min.js', 'http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js');
        wp_register_script('canvas-to-blob.min.js', 'http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js');
        wp_register_script('bootstrap.min.js', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js', array('jquery'));
        wp_register_script('jquery.iframe-transport.js', plugin_dir_url( __FILE__ ).'js/jquery.iframe-transport.js', array('jquery'));
        wp_register_script('jquery.fileupload.js', plugin_dir_url( __FILE__ ).'js/jquery.fileupload.js', array('jquery'));
        wp_register_script('jquery.fileupload-process.js', plugin_dir_url( __FILE__ ).'js/jquery.fileupload-process.js', array('jquery'));
        wp_register_script('jquery.fileupload-image.js', plugin_dir_url( __FILE__ ).'js/jquery.fileupload-image.js', array('jquery'));
        wp_register_script('jquery.fileupload-audio.js', plugin_dir_url( __FILE__ ).'js/jquery.fileupload-audio.js', array('jquery'));
        wp_register_script('jquery.fileupload-validate.js', plugin_dir_url( __FILE__ ).'js/jquery.fileupload-validate.js', array('jquery'));
        wp_register_script('jquery.fileupload-video.js', plugin_dir_url( __FILE__ ).'js/jquery.fileupload-video.js', array('jquery'));
        wp_register_script('ajax.js', plugin_dir_url( __FILE__ ).'js/ajax.js');
        wp_register_script('helpers.js', plugin_dir_url( __FILE__ ).'js/helpers.js');
}
add_action('init', 'init_all_files');

function enqueue_all_files()
{
        
        wp_enqueue_style('bootstrap.min.css');
        wp_enqueue_style('jquery.fileupload-ui.css');

        wp_enqueue_script( 'masks.js' );
        wp_enqueue_script( 'jquery.ui.widget.js' );
        wp_enqueue_script( 'load-image.min.js' );
        wp_enqueue_script( 'canvas-to-blob.min.js' );
        wp_enqueue_script( 'bootstrap.min.js');
        wp_enqueue_script( 'jquery.iframe-transport.js' );
        wp_enqueue_script( 'jquery.fileupload.js' );
        wp_enqueue_script( 'jquery.fileupload-process.js' );
        wp_enqueue_script( 'jquery.fileupload-image.js' );
        wp_enqueue_script( 'jquery.fileupload-audio.js' );
        wp_enqueue_script( 'jquery.fileupload-video.js' );
        wp_enqueue_script( 'jquery.fileupload-validate.js' );
        wp_enqueue_script( 'ajax.js' );
        wp_enqueue_script( 'helpers.js' );
}

?>