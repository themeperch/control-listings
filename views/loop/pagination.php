<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php if(get_query_var('view') == 'map'):  ?>
<div class="bg-white p-20 border-top">
<?php endif; ?>
<?php control_listings_the_posts_navigation(); ?>

<?php if(get_query_var('view') == 'map'):  ?>
</div>
<?php endif; ?>