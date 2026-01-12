<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<h3 class="card-title post-title <?php echo (get_query_var('view') != 'grid')? 'fs-4' : 'fs-5 text-truncate' ?>">
    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</h3>
<?php 
$slogan = get_post_meta( get_the_ID(), 'slogan', true );
control_listings_formated_content($slogan, '<p class="slogan">', '</p>');
?>