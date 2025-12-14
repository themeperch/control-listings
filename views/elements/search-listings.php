<?php 
$css_classes = [
    'search-listings-wrapper',
    'd-grid',
    'gap-15',
    !empty($align)? $align : '',
    !empty($css_class)? $css_class : ''
];
$attributes = [
    !empty($css_id)? 'id="'.$css_id.'"' : '',
    'class="'.esc_attr(implode(' ', $css_classes)).'"'    
];
$searchform_args = control_listings_get_searchform_args();
?>
<form method="get" action="<?php echo esc_url(control_listings_archive_page_url()) ?>">
    <div <?php echo implode(' ', array_filter($attributes)); ?>>
        <div class="input-group search-listings-group">  
            <input type="text" name="terms" class="form-control" value="<?php echo esc_attr(get_query_var('terms')); ?>" placeholder="<?php echo esc_attr($search_placeholder) ?>">
            <?php if( !empty($searchform_args['min_age']) && !empty($searchform_args['max_age']) ): ?>
            <select class="form-select age-select" name="age">
                <option><?php echo esc_attr($age_placeholder) ?></option>
                <?php for ($year=$searchform_args['min_age']; $year < $searchform_args['max_age']; $year++) : ?>
                    <option value="<?php echo intval($year) ?>"><?php /* translators: %s is the number of years. */ printf(__('%d Year', 'control-listings'), $year) ?></option>
                <?php endfor; ?>                
            </select>
            <?php endif; ?>

            <?php
            $terms = get_terms( array(
                'taxonomy' => 'listing_cat',
                'hide_empty' => true,
            ));
            if( !empty($terms) ): ?>
            <select class="form-select category-select" name="lcat">
                <option value=""><?php echo esc_attr($category_placeholder) ?></option>
                <?php foreach ($terms as $term): ?>
                <option value="<?php echo esc_attr($term->slug) ?>"><?php echo esc_attr($term->name) ?></option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>
            <input type="text" class="form-control" name="zip" value="<?php echo get_query_var('zip'); ?>" placeholder="<?php echo esc_attr($zip_placeholder) ?>">
            <input class="btn btn-primary" type="submit" value="<?php echo esc_attr($button_text) ?>">
        </div>
        <p class="mb-0"><?php echo esc_attr(str_replace('total_listings', control_listings_count_posts_published(), $footer_text)); ?></p>
    </div>
</form>