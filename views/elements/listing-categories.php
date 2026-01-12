<?php
$terms = get_terms( array(
  'taxonomy' => 'listing_cat'
) );
if(empty($terms)) return;

$css_classes = [
    'listing-categories',
    'row',
    'row-cols-lg-5',
    'row-cols-2',
    'g-10',
    'justify-content-center',
    !empty($align)? $align : '',
    !empty($css_class)? $css_class : ''
];
$attributes = [
    !empty($css_id)? 'id="'.$css_id.'"' : '',
    'class="'.esc_attr(implode(' ', $css_classes)).'"'    
];

?>
<div <?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo join(' ', array_filter($attributes)); 
?>>
  <?php foreach ($terms as $term):  
    $icon = rwmb_meta( 'icon', ['object_type' => 'term'], $term->term_id );
    ?>
      <div class="col">
          <div class="listing-category h-100 border text-center bg-light p-30 d-grid gap-10 overflow-hidden position-relative">
            <span class="listing-category-icon text-primary"><?php echo wp_kses_post(control_listings_get_icon_svg('marker', $icon, 64 )); ?></span>
            <div class="listing-category-info">
              <?php echo wp_kses_post(control_listings_formated_content(esc_attr($term->name), '<h5 class="mb-0">', '</h5>')) ?>
              
              <p class="mb-0"><?php /* translators: %s is the number of listings. */ printf(esc_attr__('%s Listings', 'control-listings'),  absint($term->count)) ?></p>              
            </div>
            <div class="position-absolute bottom-0 start-0 w-100">
              <a class="btn btn-sm btn-primary stretched-link d-block mx-20" href="<?php echo esc_url(get_term_link($term, 'listing_cat')); ?>"><?php esc_attr__('Browse Listings', 'control-listings') ?></a>
            </div>
            
          </div>
      </div>
  <?php endforeach; ?>
</div>