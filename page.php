<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
    }
?>

<?php     
    the_content(); 
?>

<?php get_footer(); ?>