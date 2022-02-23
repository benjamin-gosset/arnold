<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    <?php wp_body_open(); ?>
    <a class="skip-link" href="#content">Aller au contenu</a>
    <a id="top"></a>

    <div class="hidden" hiddden>
        <?php get_template_part( 'dist/img/sprite.svg' ); ?>
    </div>

    <header class="header" role="banner">
        <div class="container">
            <a href="<?php echo site_url(); ?>" class="brand">Benjamin Gosset</a>
            <button class="header__toggle hamburger" type="button" aria-expanded="false">
                <span class="hamburger__box">
                    <span class="hamburger__inner"></span>
                </span>
                <span class="hamburger__label">Menu</span>
            </button>
            <nav role="navigation" aria-label="Menu principal" class="main-nav">
                <?php 
                    wp_nav_menu( array(
                        'menu'           => 'Main menu',
                        'theme_location' => 'primary-menu',
                        'container'      => '',
                        'walker'         => new Nav_Walker
                    ));
                ?>
            </nav>
            <div class="header__cta">
                <a href="<?php echo site_url('/devis/'); ?>">Devis gratuit</a>
            </div>
        </div>
    </header>
    
    <main role="main">
        <a id="content" tabindex="-1"></a>      
            <?php
                if ( is_page() && ! is_front_page() ) { 
                    $featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
                    ?>
                    <section class="page-title-area" style="background-image: url(<?php echo $featured_img_url; ?>);">
                        <div class="container">
                            <?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
                                } 
                            ?>
                            <h1><span><?php the_title(); ?></span></h1>
                        </div>
                    </section>
                <?php } elseif ( is_category() ) { 
                    $cat_id = get_queried_object_id();

                    /**
                     * Display content from gut cat with the actual category
                     **/ 
                    $args = array( 
                        'post_type'     => 'content_categories',
                        'post_status'   => 'publish',
                        'post_per_page' => 1,
                        'category__in'  => $cat_id
                    );
                    
                    $query = new WP_Query( $args );
                    
                    while ( $query->have_posts() ) :
                        $query->the_post(); 
                        $feat_image = get_the_post_thumbnail_url();
                    endwhile;
                    ?>
                    <section class="page-title-area" style="background-image: url(<?php echo $feat_image; ?>);">
                        <div class="container">
                            <?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
                                } 
                            ?>
                            <h1><?php single_cat_title(''); ?></h1>
                        </div>
                    </section>
                <?php } elseif ( is_single() ) { 
                    $featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
                    ?>
                    <section class="page-title-area" style="background-image: url(<?php echo $featured_img_url; ?>);">
                        <div class="container">
                            <?php
                                $post_date = get_the_date();
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
                                } 
                            ?>
                            <h1><span><?php the_title(); ?></span></h1>
                            <span class="post-date">Publié le <?php echo $post_date; ?></span>
                        </div>
                    </section>
                <?php
                }