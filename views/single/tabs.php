<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="single-listing-tabs">
  <?php if( count($tabs) > 1 ): ?>
  <div class="nav d-flex flex-wrap gap-30 border-bottom mb-30" id="singleListingtab" role="tablist">
      <?php 
      $count = 1;
      foreach ($tabs as $tab => $value) : ?>          
          <a class="nav-link<?php echo ($count == 1)? ' active' : ''; ?>" id="listingTab-<?php echo esc_attr($tab); ?>" data-bs-toggle="tab" href="#tabContent-<?php echo esc_attr($tab); ?>" role="tab" aria-controls="tabContent-<?php echo esc_attr($tab); ?>"<?php echo ($count == 1)? ' aria-selected="true"' : ''; ?>><?php echo esc_attr($value); ?></a>          
      <?php 
      $count++;
      endforeach; ?>
  </div>
  <?php endif; ?>
  <div class="tab-content" id="singleListingtabContent">
      <?php 
      $count = 1;
      foreach ($tabs as $tab => $value) : ?>
        <div class="tab-pane fade<?php echo ($count == 1)? ' show active' : ''; ?>" id="tabContent-<?php echo esc_attr($tab); ?>" role="tabpanel" aria-labelledby="listingTab-<?php echo esc_attr($tab); ?>" tabindex="0">
          <?php control_listings_single_tab_content($tab); ?>
        </div>
      <?php 
      $count++;
      endforeach; ?>  
  </div>
</div>