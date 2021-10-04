<?php

get_header();

$category = get_queried_object();
$cat_id   = $category->term_id;
// echo $cat_id;
?>

<h1><?php single_cat_title(''); ?></h1>

<?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
    }
?>

<?php
// Display content from gut cat with the actual category
$args = array( 
    'post_type'     => 'content_categories',
    'post_status'   => 'publish',
    'post_per_page' => 1,
    'category__in'  => $cat_id
);

$query = new WP_Query( $args );

while ( $query->have_posts() ) :
    $query->the_post();
    the_content();
endwhile;

wp_reset_postdata();

if ( is_category() ) {
    $params = array('parent' => get_queried_object_id() );
    if ( count( get_categories( $params ) ) ) {
        echo '<ul>';
        wp_list_categories( $params );
        echo '</ul>';
    }
}

get_footer();