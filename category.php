<?php

get_header();

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
    $query->the_post(); ?>
    <div class="container">
        <?php the_content(); ?>
    </div>
    <?php
endwhile;

wp_reset_postdata();

/**
 * 
 * Display posts from this category
 * 
 */
$posts_args = array( 
    'post_type'     => 'post',
    'post_status'   => 'publish',
    'post_per_page' => 6,
    'cat'  => $cat_id
);

$posts_query = new WP_Query( $posts_args );
$posts_number = $posts_query->found_posts;

if ( $posts_number >= 1 ) { ?>
    <div class="category-articles">
        <div class="container">
            <h3> Les derniers articles</h3>
            <div class="category-articles__wrapper">
                <?php
                    while ( $posts_query->have_posts() ) :
                        $posts_query->the_post(); 
                        $post_thumbnail = get_field('miniature');
                        $post_title = get_the_title();
                        $post_permalink = get_permalink();
                        ?>
                        <div class="category-articles__item card">
                            <img src="<?php echo $post_thumbnail; ?>">
                            <h4><a href="<?php echo $post_permalink; ?>"><?php echo $post_title; ?></a></h4>
                        </div>
                        <?php
                    endwhile;
                ?>
            </div>
        </div>
    </div>
<?php    
}

wp_reset_postdata();

/**
 * 
 * Display child or siblings categories
 * 
 */
if ( is_category() ) {
    $params = array( 
        'parent' =>  $cat_id, 
        'title_li' => '',
        'style' => '',
        'walker' => new Walker_Reformated_Category()
    );
    if ( count( get_categories( $params ) ) ) {
        $cat = get_the_category(); 
        $cat_name = $cat[0]->cat_name; ?>
        <div class="cat-links">
            <div class="container">
                <h3>D??couvrez d'autres th??matiques sur le sujet "<?php echo $cat_name; ?>"</h3>
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
                <h3>D??couvrez d'autres th??matiques sur le sujet "<?php echo $parent_name; ?>"</h3>
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