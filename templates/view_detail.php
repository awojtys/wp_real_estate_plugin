<?php
/*
Template Name: View_detail
*/
   
function postedOn()
{
    printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep">'),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}

$meta_values = get_post_meta($post->ID);
$pictures = explode(',', $meta_values['all_files_name'][0]);
array_pop($pictures);
init_for_user_page();
get_header();
get_sidebar();
?>
<div class="offer" >
<?php
if($post->post_type == 'offers') 
{
    ?>
        <div class="offer_header">
            <div class="offer_title"><?php echo $post->post_title ?></div>
            <div class="offer_date"><?php echo $post->post_date ?></div>
            <div class="offer_house_type">House type: <?php echo $meta_values['type'][0] ?></div>
        </div>
        <div class="offer_content">
            <table>
            <tr><td><br /></td><td><br /></td></tr>
            <tr><td>Measurement:</td><td><?php if($meta_values['measurement'][0] != null){ echo $meta_values['measurement'][0] . ' m<sup>2</sup>';} ?></td></tr>
            <tr><td>Address:</td><td><?php echo $meta_values['address'][0] ?></td></tr>
            <tr><td>Price:</td><td><?php if($meta_values['price'][0] != null){ echo '$ ' . $meta_values['price'][0];}?></td></tr>
            <tr><td><br /></td><td><br /></td></tr>
            <tr><td>Description:<td/><?php echo $meta_values['description'][0] ?></td></tr>
            </table>
        </div>
    <div class="offer_pictures">
<?php 
    foreach($pictures as $picture)
    {
        echo '<a class="example-image-link" href="/wp-content/uploads/real_estate/'.$picture.'" data-lightbox="example-1"><img class="example-image" src="/wp-content/uploads/real_estate/'.$picture.'" alt="thumb-1" width="150" height="150"/></a>';

    }    
?>
    </div>
</div>
<?php
}




wp_reset_query();


get_footer(); 
?>