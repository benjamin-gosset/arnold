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
    $cat_id = get_queried_object_id();
    $params = array( 
        'parent' =>  $cat_id, 
        'title_li' => '',
        'style' => ''
    );
    if ( count( get_categories( $params ) ) ) {
        $cat = get_the_category(); 
        $cat_name = $cat[0]->cat_name; ?>
        <div class="cat-links">
            <div class="container">
                <h3>Découvrez d'autres thématiques sur le sujet "<?php echo $cat_name; ?>"</h3>
            </div>
            <div class="sub-cat">
                <?php wp_list_categories( $params ); ?>
            </div>
        </div>
    <?php    
    } else {
        $child = get_category( $cat_id );
        $parent = $child->parent;
        $parent_data = get_category( $parent );
        $parent_name = $parent_data->cat_name;
        $parent_id = $parent_data->term_id;
        $siblings_params = array( 
            'parent' => $parent_id,
            'exclude' => array( $cat_id ),
            'title_li' => '',
            'style' => '',
            'separator' => '',
            'walker' => new Walker_Reformated_Category()
        ); ?>
        <div class="cat-links">
            <div class="container">
                <h3>Découvrez d'autres thématiques sur le sujet "<?php echo $parent_name; ?>"</h3>
                <div class="siblings-cat">
                    <?php 
                        wp_list_categories( $siblings_params ); 
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
}

get_footer();