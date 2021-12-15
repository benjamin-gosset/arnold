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
            <?php 
                if ( is_front_page() ) { ?>
                    <h1 class="logo">
                        <a href="<?php echo site_url(); ?>">
                            <svg role="img" aria-label="Benjamin Gosset - Accueil" class="normal">
                                <use xlink:href="#logo-bg" />
                            </svg>
                        </a>
                    </h1>
                <?php } else { ?>
                    <a href="<?php echo site_url(); ?>" class="logo">
                        <svg role="img" aria-label="Benjamin Gosset - Accueil" class="normal">
                            <use xlink:href="#logo-bg" />
                        </svg>
                    </a>
                <?php }
            ?>
            <button class="header__toggle hamburger" type="button" aria-expanded="false">
                <span class="hamburger__box">
                    <span class="hamburger__inner"></span>
                </span>
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
                if ( is_page() && ! is_front_page() ) { ?>
                    <section class="page-title-area">
                        <div class="container">
                            <?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
                                } 
                            ?>
                            <h1><span><?php the_title(); ?></span></h1>
                        </div>
                    </section>
                <?php } elseif ( is_category() ) { ?>
                    <section class="page-title-area">
                        <div class="container">
                            <?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
                                } 
                            ?>
                            <h1><?php single_cat_title(''); ?></h1>
                        </div>
                    </section>
                <?php } elseif ( is_single() ) { ?>
                    <section class="page-title-area">
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