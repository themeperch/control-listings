<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<form class="d-grid gap-10 mb-30" method="get" action="<?php echo esc_url(control_listings_archive_page_url(true)) ?>">
    <div class="filter d-grid d-lg-flex gap-15 justify-content-between">
        <?php do_action('control_listings_result_count') ?>
        <?php do_action('control_listings_order_form') ?>    
    </div>
    <div class="d-flex flex-wrap gap-1">
        <?php do_action('control_listings_order_form_fields'); ?>
    </div>
</form>