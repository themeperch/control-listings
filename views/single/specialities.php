<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$specialities = get_post_meta(get_the_ID(), 'specialities', true);
if(empty($specialities)) return;
?>
<div class="listing-specialities border-bottom pb-30">
    <h2 class="listing-tags-title mb-30"><?php esc_attr_e('Specialities', 'control-listings') ?></h2>
    <ul class="list-arrow row row-cols-lg-3 gy-20 mb-0">
        <?php
        foreach ($specialities as $speciality) {
            control_listings_formated_content($speciality, '<li>', '</li>');
        }
        ?>
    </ul>
</div>