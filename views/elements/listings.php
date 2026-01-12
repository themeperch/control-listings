<?php
$css_classes = [
    'single-listing-tabs',
    !empty($align)? $align : '',
    !empty($css_class)? $css_class : ''
];
$attributes = [
    !empty($css_id)? 'id="'.$css_id.'"' : '',
    'class="'.esc_attr(implode(' ', $css_classes)).'"'    
];
wp_enqueue_style('ctrl-listings-swiper');
wp_enqueue_script('ctrl-listings-swiper');
?>
<div <?php
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
 echo join(' ', array_filter($attributes)); 
 ?>>
  <?php if( count($display) > 1 ): ?>
  <div class="nav d-flex flex-wrap mx-auto gap-30 mb-30" id="singleListingtab" role="tablist">
      <?php 
      $count = 1;      
      foreach ($display as $tab) : $value = $atts[$tab.'_title'] ?>  
          <?php
          $active_class = $count == 1 ? ' active' : '';
          $aria_selected = $count == 1 ? ' aria-selected="true"' : '';
          ?>        
          <a class="nav-link<?php echo esc_attr($active_class) ?>" id="listingTab-<?php echo esc_attr($tab); ?>" data-bs-toggle="tab" href="#tabContent-<?php echo esc_attr($tab); ?>" role="tab" aria-controls="tabContent-<?php echo esc_attr($tab); ?>"<?php echo esc_attr($aria_selected) ?>><?php echo esc_attr($value); ?></a>          
      <?php 
      $count++;      
      endforeach; ?>
  </div>
  <?php endif; ?>
  <div class="tab-content" id="singleListingtabContent">
      <?php 
      $count = 1;
      foreach ($display as $tab) : ?>
        <div class="tab-pane fade<?php echo ($count == 1)? ' show active' : ''; ?>" id="tabContent-<?php echo esc_attr($tab); ?>" role="tabpanel" aria-labelledby="listingTab-<?php echo esc_attr($tab); ?>" tabindex="0">
          <?php
            $the_query = new WP_Query( control_listings_query_args_by_type($tab, $atts) );
            // The Loop
            if ( $the_query->have_posts() ):  ?>
              <div class="listing-carousel-wrapper mx-auto">
                <div class="swiper swiperCarousel" data-column="'.$column.'">
                  <div class="swiper-wrapper pb-50">
                  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                      <div class="swiper-slide">
                      <?php control_listings_locate_template('loop/content.php'); ?>
                      </div>
                  <?php endwhile; ?>
                  </div>
                  <div class="swiper-pagination"></div>
                </div>
              </div>
              <?php
            else:
              esc_attr_e('No listings found!', 'control-listings');
            endif;
            wp_reset_postdata();
          ?>
        </div>
      <?php 
      $count++;
      endforeach; ?>  
  </div>
</div>