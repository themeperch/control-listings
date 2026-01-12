<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$terms = get_terms( array(
  'taxonomy' => $taxonomy,
  'orderby' => 'count',
  'order' => 'DESC'
) );
if(empty($terms)) return;

$active_term = false;
if( is_tax($taxonomy)){
  $active_term = get_queried_object()->term_id;
}

?>
<?php if(!empty($title)): ?>
<h4 class="widget-title mb-20"><?php echo esc_attr($title); ?></h4>
<?php endif; ?>

<?php if( $display == 'inline' ): ?>
  <div class="listing-categories inline-terms inline-terms-<?php echo esc_attr(str_replace('_', '-', $taxonomy)) ?> d-flex flex-wrap gap-1">
    <?php foreach ($terms as $term): 
      $active_class = $active_term == $term->term_id? ' active' : '';
      ?>     
        <a class="d-inline-flex gap-1<?php echo esc_attr($active_class) ?>" href="<?php echo esc_url(get_term_link($term, 'listing_cat')); ?>">
        <?php echo esc_attr($term->name) ?><span class="count text-white ms-auto">(<?php echo esc_attr($term->count) ?>)</span>
      </a>        
    </li>
    <?php endforeach; ?>
  </div>
<?php endif; ?>  

<?php
if( $display == 'list' ):
$css_classes = [
    'widget-listing-categories',  
    'listing-terms',
    'list-terms-'.str_replace('_', '-', $taxonomy), 
    'list-group',
    'list-group-flush',
    !empty($align)? $align : '',
    !empty($css_class)? $css_class : ''
];
$attributes = [
    !empty($css_id)? 'id="'.$css_id.'"' : '',
    'class="'.esc_attr(implode(' ', $css_classes)).'"'    
];
?>
<ul <?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo join(' ', array_filter($attributes)); 
?>>
  <?php foreach ($terms as $term):  
    $icon = rwmb_meta( 'icon', ['object_type' => 'term'], $term->term_id );
    $active_class = $active_term == $term->term_id? ' active' : '';
    ?>
    <li class="list-group-item">  
      <a class="d-flex flex-wrap w-100 gap-10<?php echo esc_attr($active_class) ?>" href="<?php echo esc_url(get_term_link($term, 'listing_cat')); ?>">
      <?php echo !empty($icon)? sprintf('<span class="icon text-primary">%s</span>', wp_kses_post(control_listings_get_icon_svg('marker', $icon, 18))) : ''; ?>
      <span class="term-name"><?php echo esc_attr($term->name) ?></span>
      <span class="count text-muted ms-auto">(<?php echo esc_attr($term->count) ?>)</span>
    </a>        
  </li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>
