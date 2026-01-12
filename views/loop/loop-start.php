<?php if(get_query_var('view') == 'list') return; ?>
<?php
$css_class = [
    'row',
    $column_class
];
?>
<?php if(get_query_var('view') == 'map'):  ?>
        <div class="map-view-content px-20">
<?php endif; ?>
<?php if($masonary): ?>
    <div class="<?php echo esc_attr(implode(' ', $css_class)) ?>" data-masonry='{"percentPosition": true }'>
<?php else: ?>
    <div class="<?php echo esc_attr(implode(' ', $css_class)) ?>">
<?php endif; ?>