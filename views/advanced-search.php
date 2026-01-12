<div class="offcanvas offcanvas-start"  data-bs-scroll="true" tabindex="-1" id="listingAdvancedSearch" aria-labelledby="listingAdvancedSearchLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="listingAdvancedSearchLabel"><?php esc_attr_e('Listing search', 'control-listings') ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div id="advancedFormResults"></div>
    <?php control_listings_template_part('filter-form') ?>
    <form class="listings-search-form d-grid gap-30" method="get" action="<?php echo esc_url(control_listings_archive_page_url()) ?>">
      <div class="listings-search-terms">
        <input type="text" name="terms" value="<?php echo esc_attr(get_query_var('terms')); ?>" id="listingSearchInput" class="form-control" placeholder="<?php esc_attr_e('Enter keywords...', 'control-listings') ?>" autofocus="true" />
        <?php do_action('control_listings_search_form_fields'); ?>        
      </div>
      <?php if( !empty($min_age) && !empty($max_age) ): ?>
      <div class="listings-age-search">  
         <div class="listing-range-slider">
            <p class="listing-range-value"><?php esc_attr_e('Age:', 'control-listings') ?> <span class="min-value" data-value="<?php echo esc_attr($min_age) ?>"><?php echo esc_attr($min_age_active) ?></span> - <span class="max-value" data-value="<?php echo esc_attr($max_age) ?>"><?php echo esc_attr($max_age_active) ?></span> (in Years)</p>
            <div class="listing-range-bar"></div>    
            <input type="hidden" name="age" value="<?php echo esc_attr(get_query_var('age')); ?>"> 
          </div>   
      </div>
      <?php endif; ?>

      <?php if( !empty($min_price) && !empty($max_price) ): ?>
      <div class="listings-price-search">  
         <div class="listing-range-slider">
            <p class="listing-range-value"><?php esc_attr_e('Price:', 'control-listings') ?> <span class="min-value" data-value="<?php echo esc_attr($min_price) ?>"><?php echo esc_attr($min_price_active) ?></span> - <span class="max-value" data-value="<?php echo esc_attr($max_price) ?>"><?php echo esc_attr($max_price_active) ?></span> (in <?php echo esc_attr(get_control_listings_currency()); ?>)</p>
            <div class="listing-range-bar"></div>    
            <input type="hidden" name="price" value="<?php echo esc_attr(get_query_var('price')); ?>"> 
          </div>   
      </div>
      <?php endif; ?>
    
      <?php
      $terms = get_terms( array(
          'taxonomy' => 'listing_cat',
          'hide_empty' => true,
      ));
      if( !empty($terms) ): ?>      
      <div class="widget">
        <h4 class="widget-title"><?php esc_attr_e('Categories', 'control-listings') ?></h4>
        <div class="checked-group d-flex flex-wrap gap-1">      
          <?php foreach ($terms as $term) : $checked = !empty($lcat_active) && in_array($term->slug, $lcat_active); ?>
              <div>
                <input type="checkbox" class="listing-term btn-check" id="listing-term-<?php echo esc_attr($term->term_id) ?>" value="<?php echo esc_attr($term->slug) ?>" autocomplete="off" <?php checked($checked, true); ?>/>
                <label class="btn btn-sm btn-outline-secondary" for="listing-term-<?php echo esc_attr($term->term_id) ?>"><?php echo esc_attr($term->name .' ('. $term->count.')') ?></label>
              </div>
          <?php endforeach; ?>
          <input type="hidden" name="lcat" value="<?php echo esc_attr(implode(',', $lcat_active)) ?>" />
        </div>
      </div>
      <?php endif; ?>
      <input type="hidden" name="redirect_to" value="<?php echo esc_url(control_listings_archive_page_url()) ?>" />
      <input type="submit"  data-bs-dismiss="offcanvas" value="<?php esc_attr_e('Filter', 'control-listings') ?>" />      

    </form>
  </div>
</div>