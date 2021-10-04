<?php get_header(); ?>

<code>archive.php</code>

<?php 
    if ( is_category() ) {
        $title = single_tag_title( '', false );
    }
    elseif ( is_search() ) {
        $title = "Vous avez recherché : " . get_search_query();
    }
    else {
        $title = 'Le Blog';
    }

    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb('<p class="breadcrumb">','</p>');
    }
    
get_footer(); ?>