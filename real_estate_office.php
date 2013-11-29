<?php
include_once 'Includes.php';
/*
 Plugin Name: Real Estate Plugin 
 Version: 1.0
 Author: Andrzej Wojtyś
 Description: Plugin for create new offers
 */

$dir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/real_estate';
$helper = new Forms();

function install()
{
    if(!dir($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/real_estate'))
    {
        mkdir($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/real_estate', 0777);
    }
        
    $current = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/real_estate_office/templates/view_all.php');
    file_put_contents(get_template_directory().'/view_all.php', $current);
    $current = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/real_estate_office/templates/view_detail.php');
    file_put_contents(get_template_directory().'/view_detail.php', $current);
}



function uninstall()
{
    unlink(get_template_directory().'/view_detail.php');
    unlink(get_template_directory().'/view_all.php');
}
//add upload data for post create
function addEncodingMultipartToForm() 
{
    echo ' enctype="multipart/form-data"';
}

//create form for shortcode
function offerForm()
{
    enqueue_all_files();
    global $helper;
    echo '<table>';
    $helper->createForm();
    echo '</table>';
    
    echo '<input type="hidden" class="created_post_id" />';
    file_upload_form();
}

//create new post_type offers
function Offer_Post_Type() {
    
    register_post_type( 'Offers',
        array(
            'labels' => array(
                'name' => 'Offers',
                'singular_name' => 'Offer',
                'add_new_item' => 'Add New Offer',
                'add_new' => 'Add Offer',
                'edit_item' => 'Edit Offer',
                'new_item' => 'New Offer',
                'view_item' => 'View Offer',
                'search_items' => 'Search Offers',
                'not_found' => 'No offers found',
            ),
        'public' => true,
        'has_archive' => true,
        'taxonomies' => array('houses'),
        'rewrite' => array('slug' => 'Offers'),
        'menu_position' => '20',
        'hierarchical' => true,
        'parent_item' => null,
        'supports' => array('title'),
        'parent_item_colon' => null,
        ));
}

//create new taxonomy for offers
function houses_taxonomy() {
        register_taxonomy(
            'houses',
            'offers',
            array(
                'labels' => array(
                    'name' => 'Houses',
                    'singular_name' => 'House',
                    'add_new_item' => 'Add New House Type',
                    'new_item_name' => 'New House Type',
                    'edit_item' => 'Edit',
                    'update_item' => 'Update',
                    'all_items' => 'All Houses',
                    'search_items' => 'Search Houses',
                    'popular_items' => 'Popular Houses Type',
                    'not_found' => 'No houses found',
                    'add_or_remove_items' => 'Add or remove houses',
                ),
            'rewriechote' => array( 'slug' => 'house' ),
            'separate_items_with_commas' => __( 'Separate writers with commas' ),
            ));
}


//add meta_box to admin panel offers post
function myplugin_add_custom_box() {
    global $post;
    enqueue_all_files();
    if($post->post_type == 'offers')
    {
        add_meta_box(
            'myplugin_sectionid',
            __( 'Add new offert', 'text_domain' ),
            'meta_box_in_ap');
    }
}

//prepare meta_box to add to admin panel offers post
function meta_box_in_ap() 
{
    global $helper;
    echo '<table>';
    $helper->createForm();
    echo '</table>';
    file_upload_form();
}

if($_POST['offer']['save'] || $_POST['save'])
{
    $files_to_delete = '';
    if($_POST['offer']['files_to_delete'] != '')
    {
        $files_to_delete = $_POST['offer']['files_to_delete'];
        unset($_POST['offer']['files_to_delete']);
        $helper->deleteFiles($files_to_delete);
    }
    $post = array('post_type' => $_POST['offer']['post_type'], 'post_id' => $_POST['offer']['post_id']);
    $prepared_data = $helper->prepareOfferData($_REQUEST['offer'], $_FILES['offer']);
    $helper->sendOfferToDB($prepared_data, $post);
}
//add validate after add offer with using AJAX
function add_offer_with_ajax()
{
    if($_POST['post_type'] == 'offers')
    {
        wp_update_post();
    }
    global $helper;
    $files_to_delete = '';
    if($_POST['file_to_delete'] != '')
    {
        $files_to_delete = $_POST['file_to_delete'];
        unset($_POST['file_to_delete']);
        $helper->deleteFiles($files_to_delete);
    }
    
    $post = array('post_type' => $_POST['post_type'], 'post_id' => $_POST['post_id'], 'created_post_id'  => $_POST['created_post_id']);
    unset($_POST['post_type']);unset($_POST['post_id']);unset($_POST['created_post_id']);
    $prepared_data = $helper->prepareOfferData($_POST, $_FILES['offer']);
    $helper->sendOfferToDB($prepared_data, $post);
}
//add ajaxurl
function add_ajaxurl() {
?>

<script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}
//add action for ajax
function add_ajax_for_offers()
{
    add_action('wp_ajax_add_offer_with_ajax', 'add_offer_with_ajax');
}

//add form for upload file
function file_upload_form()
{
    $file_value ='';
    $images = new ConnectWithDB();
    $files = $images ->getPicturesName();
    if($files[0] != null)
    {
        foreach($files as $file)
        {
            $file_value .= $file.',';
        }
    }
    else 
    {
        $file_value = $files[0];
    }
    echo '
<div class="container">

    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Add files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    <input type="hidden" name="offer[all_files_name]" id="all_files_name" value="'.$file_value.'" />
    <input type="hidden" name="offer[files_to_delete]" id="files_to_delete" />
    <div>';
    if($files)
    {
        echo 'Uploaded files:<br /><table>';
        foreach($files as $file)
        {
            $file_name = explode('.', $file);
            echo '<tr><td><img src="../wp-content/uploads/real_estate/' . $file . '" id="'.$file_name[0].'"/></td><td><a href="" data-id="'.$file_name[0].'" id="delete_image_file">Click to delete</a></td></tr>';
        }
        echo '</table>';
    }
    echo ' </div>
    <br><input type="submit" name="offer[save]" value="Save" id="saveoffer" />
    <br /><br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Informations</h3>
        </div>
        <div class="panel-body">
            <ul>
                <li>The maximum file size for uploads in this demo is <strong>5 MB</strong>.</li>
                <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo.</li>
     </ul>
        </div>
    </div>
</div>';
}

function offer_detail_template()
{
    global $post;
    if($post->post_type == 'offers')
    {
        include( get_template_directory() . '/view_detail.php' );
        exit();
    }
}

add_action( 'template_redirect', 'offer_detail_template' );

//create shortcode
add_shortcode('offerform', 'offerForm');
//add new post type
add_action( 'init', 'Offer_Post_Type' );
//add new taxonomy
add_action( 'init', 'houses_taxonomy' );

//add file operation for form
add_action('post_edit_form_tag', 'addEncodingMultipartToForm');
//add new custom field
add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );
//action when plugin is install
register_activation_hook(__FILE__, 'install');
register_deactivation_hook(__FILE__, 'uninstall');
//add wp_ajax save data for offer
add_action('admin_init', 'add_ajax_for_offers');
//add ajax action
add_action('wp_head', 'add_ajaxurl');
//after change theme
add_action('after_switch_theme', 'install');
?>
