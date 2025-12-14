<?php 
extract(wp_parse_args( $args, [
    'name' => '',
    'title' => '',
    'subtitle' => '',
    'image_hover_text' => '',
    'button_text' => '',
    'button_link' => '',
    'read_more_text' => '',
    'post_type' => '',
    'posts_per_page' => '',
    'dots' => [],
    'shadow' => [],
    'separator' => ''  
] ));
$uniqueID = uniqid();
$button_link = !empty($button_link)? $button_link : get_permalink(get_option('posts_page'));
$the_query = new WP_Query( [
    'post_type' => $post_type,
    'posts_per_page' => $posts_per_page,
    'ignore_sticky_posts' => true
] );
?>
<!-- about sec start -->
<section class="listing-news blog-sec position-relative bg-image aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
        <div class="section-head d-grid d-lg-flex justify-content-lg-between">
            <div class="col-lg-9 mb-5 mb-lg-0">
                <?php control_listings_content($name, '<span class="label">', '</span>'); ?>
                <?php control_listings_content($title, '<h2 class="blog-title">', '</h2>'); ?>
                <?php control_listings_content($subtitle, '<p class="desc mb-5">', '</p>'); ?> 
            </div>
            <?php if( !empty($button_text) || empty($button_link) ): ?>
            <div class="btn-wrap"> 
                <a href="<?php echo esc_url($button_link) ?>" class="btn faq-btn custom-btn"><?php echo esc_attr($button_text) ?></a>  
            </div>
            <?php endif; ?>
        </div> 

        <div class="blog-cards-wrap zoom-gallery">
        <?php if ( $the_query->have_posts() ) : ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- the loop -->
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="col col-md-6 col-lg-4 aos-init aos-animate" data-aos="fade-up" data-aos-duration="800">
                    <div class="card h-100 border-0">
                        <?php if( has_post_thumbnail() ): ?>
                        <a class="card-thumb item-thumb overflow-hidden" href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'post-thumbnail', ['class' => 'card-img-top img-fluid'] ) ?>
                            <span class="view"><?php echo esc_attr($image_hover_text); ?></span>
                        </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <?php 
                            $categories_list = '<span class="label"'.get_the_category_list( '</span> <span class="label">' ).'</span>';
                            if ( $categories_list ) {
                                printf($categories_list);
                            }
                            ?>
                            <?php the_title( '<h5 class="card-title">', '</h5>' ); ?>                            
                            <p class="card-desc"><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>
                            <a class="blog-btn" href="<?php the_permalink(); ?>"><?php echo esc_attr($read_more_text) ?></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <!-- end of the loop -->
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p><?php esc_attr_e( 'Sorry, no posts matched your criteria.', 'control-listings' ); ?></p>
        <?php endif; ?>
        </div>
          
    </div>
    <?php if( !empty($shadow['url']) ): ?>
    <div class="shape"><img src="<?php echo esc_url($shadow['url']) ?>" alt="<?php esc_attr_e( 'Shadow', 'control-listings' ) ?>"></div>
    <?php endif; ?>
</section>
<!-- about sec end -->
<?php if( !empty($separator) && ($separator == 'yes') ): ?>
<div class="container">
    <hr>
</div>
<?php endif; ?>