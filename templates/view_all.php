<?php
/*
Template Name: View_all
*/
init_for_user_page();
get_header();
get_sidebar();

function postedOn()
{
    printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep">'),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );
}

$type = 'offers';
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1,);
$my_query = new WP_Query($args);
?>
<div class="offer" >
<?php
if( $my_query->have_posts() ) 
{
    while ($my_query->have_posts())
    {
        
        $my_query->the_post();
        $meta_values = get_post_meta(get_the_ID());?>
        <div class="offer_header">
            <a href="<?php the_permalink(); ?>" class="offer_title" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            <div class="offer_date"><?php postedOn(); ?></div>
            <div class="offer_house_type">House type: <?php echo $meta_values['type'][0] ?></div>
        </div>
        
        <div class="offer_content"><?php
        
        ?>
        <table>
            <tr><td><br /></td><td><br /></td></tr>
            <tr><td>Measurement:</td><td><?php if($meta_values['measurement'][0] != null){ echo $meta_values['measurement'][0] . ' m<sup>2</sup>';} ?></td></tr>
            <tr><td>Address:</td><td><?php echo $meta_values['address'][0] ?></td></tr>
            <tr><td>Price:</td><td><?php if($meta_values['price'][0] != null){ echo '$ ' . $meta_values['price'][0];}?></td></tr>
        </table>
        </div>
    <p class="offer_read_more"><a href="<?php the_permalink() ?>">Read more...</a></p>
    <?php
    } ?>
</div>
<?php
}
wp_reset_query();


get_footer(); 
?>