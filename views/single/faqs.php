<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(empty($faqs)) return;
$count = 1;
?>
<div class="accordion" id="accordionListingFaqs">
    <?php foreach ($faqs as $faq) : ?>
    <div class="accordion-item">
        <h3 class="accordion-header" id="accordionListingFaq<?php echo esc_attr($count); ?>">
            <a class="accordion-button fs-5<?php echo ($count == 1) ? '' : ' collapsed'; ?>" data-bs-toggle="collapse" href="#listingFaqAnswer<?php echo esc_attr($count) ?>" aria-expanded="<?php echo ($count == 1) ? 'true' : 'false'; ?>" aria-controls="listingFaqAnswer<?php echo esc_attr($count) ?>">
                <?php echo esc_attr($faq['question']) ?>
            </a>
        </h3>
        <div id="listingFaqAnswer<?php echo esc_attr($count) ?>" class="accordion-collapse collapse<?php echo ($count == 1) ? ' show' : ''; ?>" aria-labelledby="accordionListingFaq<?php echo esc_attr($count); ?>" data-bs-parent="#accordionListingFaqs">
        <div class="accordion-body">
            <?php echo wp_kses_post($faq['answer']) ?>
        </div>
        </div>
    </div>
  <?php $count++; endforeach; ?>
  
</div>