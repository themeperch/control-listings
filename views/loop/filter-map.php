<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<form class="d-grid gap-10 mb-30" method="get" action="<?php echo esc_url(control_listings_archive_page_url(true)) ?>">
    <div class="search-listings-wrapper listings-search-form d-flex flex-wrap gap-30 bg-white p-20 mb-20 border-bottom">
        <div class="input-group gap-2">
            <div class="form-floating">
                <input type="text" name="terms" value="<?php echo esc_attr(get_query_var('terms')); ?>" placeholder="<?php esc_attr_e('Search keywords', 'control-listings') ?>" id="listingSearchInput" class="form-control" />
                <label for="listingSearchInput"><?php esc_attr_e('Search keywords', 'control-listings') ?></label>
            </div>
            <div class="form-floating">
                <input id="listingSearchAge" type="text" name="age" class="form-control"  value="<?php echo esc_attr(get_query_var('age')); ?>" placeholder="<?php esc_attr_e('Age: (in Years)', 'control-listings') ?>" pattern="[0-9]" />
                <label for="listingSearchAge"><?php esc_attr_e('Age: min-max (Years)', 'control-listings') ?></label> 
            </div>
            <div class="form-floating">
                <input id="listingSearchPrice" type="text" name="price" class="form-control" placeholder="<?php /* translators: %s is the currency symbol. */ printf(esc_attr__('Price: (in %s)', 'control-listings'), esc_attr(control_listings_get_currency())) ?>" value="<?php echo esc_attr(get_query_var('price')); ?>"  pattern="[0-9]" />
                <label for="listingSearchPrice"><?php /* translators: %s is the currency symbol. */ printf(esc_attr__('Price: (%s)', 'control-listings'), esc_attr(control_listings_get_currency())) ?></label> 
            </div>
            <?php
            $terms = get_terms( array(
                'taxonomy' => 'listing_cat',
                'hide_empty' => true,
            ));
            if( !empty($terms) ): ?>
            <select class="form-select category-select" name="lcat">
                <option value=""><?php echo esc_attr__('Category', 'control-listings') ?></option>
                <?php foreach ($terms as $term): $selected = !empty($lcat_active) && in_array($term->slug, $lcat_active); ?>
                <option value="<?php echo esc_attr($term->slug) ?>" <?php selected($selected, true); ?>><?php echo esc_attr($term->name) ?></option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>
            <input type="submit" value="<?php esc_attr_e('Search', 'control-listings') ?>" />
        </div>



      

        
    
     
            

      </div>    
    <div class="filter d-grid d-lg-flex gap-15 justify-content-between px-20">
        <?php do_action('control_listings_result_count') ?>
        <?php do_action('control_listings_order_form') ?>    
    </div>    
</form>