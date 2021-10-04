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
        <h1 class="logo">
            <a href="<?php echo site_url(); ?>">
                <svg role="img" aria-label="Benjamin Gosset - Accueil" class="normal">
                    <use xlink:href="#logo-bg" />
                </svg>
            </a>
        </h1>
    </header>
    
    <main role="main">
        <a id="content" tabindex="-1"></a>