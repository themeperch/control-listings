<?php
/**
 * The template for Previous/next post navigation.
 *
 * @package WordPress
 * @subpackage control-listings
 * @since Citykid 1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$next = is_rtl() ? control_listings_get_icon_svg( 'ui', 'arrow_left' ) : control_listings_get_icon_svg( 'ui', 'arrow_right' );
$prev = is_rtl() ? control_listings_get_icon_svg( 'ui', 'arrow_right' ) : control_listings_get_icon_svg( 'ui', 'arrow_left' );

$previous_label = get_theme_mod('prev_link_text', esc_html__( 'Previous', 'control-listings' ));
$next_label     = get_theme_mod('next_link_text', esc_html__( 'Next', 'control-listings' ));

the_post_navigation(
    array(
        'next_text' => '<div class="text-end"><p class="meta-nav text-muted mb-0">' . $next_label .' '. $next . '</p><p class="post-title fs-4 fw-semibold text-break">%title</p></div>',
        'prev_text' => '<div class="text-start"><p class="meta-nav text-muted mb-0">' . $prev .' '. $previous_label . '</p><p class="post-title fs-4 fw-semibold text-break">%title</p></div>',
    )
);