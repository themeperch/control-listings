<?php
$css_classes = [
    'widget-listings',
    !empty($align)? $align : '',
    !empty($css_class)? $css_class : ''
];
$attributes = [
    !empty($css_id)? 'id="'.$css_id.'"' : '',
    'class="'.esc_attr(implode(' ', $css_classes)).'"'    
];
?>

<?php if(!empty($title)): ?>
<h4 class="widget-title mb-20"><?php echo esc_attr($title); ?></h4>
<?php endif; ?>

<div <?php 
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo join(' ', array_filter($attributes)); 
?>>
  <?php
    $query_args = control_listings_query_args_by_type($type, ['posts_per_page' => $posts_per_page]);
    $the_query = new WP_Query( $query_args );
    // The Loop
    if ( $the_query->have_posts() ):  ?>
      <ul class="list-group list-group-flush gap-0">
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <li class="list-group-item">
            <?php control_listings_locate_template('loop/content-widget.php'); ?>
            </li>
        <?php endwhile; ?>
        </ul>
      <?php
    else:
      esc_attr_e('No listings found!', 'control-listings');
    endif;
    wp_reset_postdata();
  ?>
</div>