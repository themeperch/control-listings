<div class="d-flex flex-wrap align-items-center justify-content-lg-between">
    <h3 class="enquiry-title"><?php esc_attr_e('Enquiry now', 'control-listings') ?></h3>
    <div class="fs-6"><?php echo wp_kses_post(control_listings_get_average_ratings_html(get_the_ID(), true)); ?></div>
</div>
<?php control_listings_template_part('single/enquiry/contact'); ?>