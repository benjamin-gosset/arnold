<?php

get_header();

$category = get_queried_object();
$cat_id   = $category->term_id;

// Display content from gut cat with the actual category
$args = array( 
    'post_type'     => 'content_categories',
    'post_status'   => 'publish',
    'post_per_page' => 1,
    'category__in'  => $cat_id
);

$query = new WP_Query( $args );

while ( $query->have_posts() ) :
    $query->the_post(); ?>
    <div class="container">
        <?php the_content(); ?>
    </div>
    <?php
endwhile;

wp_reset_postdata();

if ( is_category() ) {
    echo '<div class="container cat-links"><h2>Découvrez d\'autres thématiques sur le sujet</h2>';
    $cat_id = get_queried_object_id();
    $params = array( 
        'parent' =>  $cat_id, 
        'title_li' => '',
        'style' => ''
    );
    if ( count( get_categories( $params ) ) ) {
        echo '<div class="sub-cat">';
        wp_list_categories( $params );
        echo '</div>';
    } else {
        $child = get_category( $cat_id );
        $parent = $child->parent;
        $parent_data = get_category( $parent );
        $parent_id = $parent_data->term_id;
        $siblings_params = array( 
            'parent' => $parent_id,
            'exclude' => array( $cat_id ),
            'title_li' => '',
            'style' => ''
        );
        echo '<div class="siblings-cat">';
        wp_list_categories( $siblings_params );
        echo '</div>';
    }
    echo '</div>';
}

get_footer();