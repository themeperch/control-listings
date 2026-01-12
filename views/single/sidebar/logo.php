<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!empty($logo)): ?>
<div class="institution-logo bg-white position-relative mt-lg-n100 pt-lg-0 pt-50">
    <img src="<?php echo esc_url(wp_get_attachment_url($logo)); ?>" class="institution-logo img-fluid" />
</div>
<?php endif; ?>