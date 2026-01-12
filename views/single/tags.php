<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$tag_list = get_the_term_list(get_the_ID(), 'listing_tag');    
if( !empty($tag_list) && !is_wp_error($tag_list) ): ?>
<div class="listing-tags pb-50 border-bottom">
    <h2 class="listing-tags-title mb-30"><?php esc_attr_e('Tags', 'control-listings') ?></h2>
    <div class="tagcloud listing=tagcloud">    
        <?php echo wp_kses_post($tag_list); ?>
    </div>
</div>
<?php endif; ?>          