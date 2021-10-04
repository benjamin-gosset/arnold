<?php 

/**
 * Add post thumbnails support
 */ 
add_theme_support( 'post-thumbnails' );

/**
 * Add site title in theme header
 */ 
add_theme_support( 'title-tag' );

/**
* Switch default core markup for search form, comment form, and comments
* to output valid HTML5.
*/
add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'script',
    'style',
) );

/**
 * Add support for core custom logo.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
add_theme_support( 'custom-logo', array(
    'height'      => 50,
    'width'       => 250,
    'flex-width'  => true,
    'flex-height' => true,
) );

/**
 * Enqueue styles and scripts
 */ 
add_action( 'wp_enqueue_scripts', 'bgo_register_assets' );

function bgo_register_assets() {
    // Styles
    wp_enqueue_style( 'bgo', get_template_directory_uri() . '/dist/css/main.min.css', array(), '1.0');

    // Scripts
    wp_enqueue_script( 'bgo', get_template_directory_uri() . '/dist/js/app.js', array(), '1.0', true);
}

/**
 * Register menus
 */ 
register_nav_menus( array(
	'primary-menu' => esc_html__( 'Primary menu', 'arnold' ),
	'topbar-menu' => esc_html__( 'Top bar menu', 'arnold' ),
	'social-menu' => esc_html__( 'Main menu social icons', 'arnold' ),
	'footer-menu' => esc_html__( 'Footer menu', 'arnold' ),
	'footer-social-menu' => esc_html__( 'Footer social icons', 'arnold' ),
) );

/**
 * Remove post tags
 */
add_action( 'init', 'bgo_remove_default_taxos', 2 );
function bgo_remove_default_taxos() {
    global $wp_taxonomies;
    unset($wp_taxonomies['post_tag']);
}

/**
 * Add categories to pages
 */
function bgo_categories_support() {
	register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'bgo_categories_support' );

/**
 * Add Rich Categories with Gutenberg editor as CPT
 */
// Register Custom Post Type
function bgo_gut_categories() {

	$labels = array(
		'name'                  => _x( 'Gut Categories', 'Post Type General Name', 'arnold' ),
		'singular_name'         => _x( 'Gut Category', 'Post Type Singular Name', 'arnold' ),
		'menu_name'             => __( 'Gut Cat', 'arnold' ),
		'name_admin_bar'        => __( 'Gut Cat', 'arnold' ),
		'archives'              => __( 'Item Archives', 'arnold' ),
		'attributes'            => __( 'Item Attributes', 'arnold' ),
		'parent_item_colon'     => __( 'Parent Item:', 'arnold' ),
		'all_items'             => __( 'Toutes les catégories', 'arnold' ),
		'add_new_item'          => __( 'Ajouter une nouvelle catégorie', 'arnold' ),
		'add_new'               => __( 'Ajouter', 'arnold' ),
		'new_item'              => __( 'Nouvelle catégorie enrichie', 'arnold' ),
		'edit_item'             => __( 'Modifier la catégorie enrichie', 'arnold' ),
		'update_item'           => __( 'Mettre à jour la catégorie enrichie', 'arnold' ),
		'view_item'             => __( 'Voir la catégorie enrichie', 'arnold' ),
		'view_items'            => __( 'Voir les catégories enrichies', 'arnold' ),
		'search_items'          => __( 'Search Item', 'arnold' ),
		'not_found'             => __( 'Not found', 'arnold' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'arnold' ),
		'featured_image'        => __( 'Featured Image', 'arnold' ),
		'set_featured_image'    => __( 'Set featured image', 'arnold' ),
		'remove_featured_image' => __( 'Remove featured image', 'arnold' ),
		'use_featured_image'    => __( 'Use as featured image', 'arnold' ),
		'insert_into_item'      => __( 'Insert into item', 'arnold' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'arnold' ),
		'items_list'            => __( 'Items list', 'arnold' ),
		'items_list_navigation' => __( 'Items list navigation', 'arnold' ),
		'filter_items_list'     => __( 'Filter items list', 'arnold' ),
	);
	$args = array(
		'label'                 => __( 'Gut Category', 'arnold' ),
		'description'           => __( 'Create content-rich categories', 'arnold' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 25,
		'menu_icon'             => 'dashicons-admin-plugins',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => false,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => false,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'gut_categories', $args );

}
add_action( 'init', 'bgo_gut_categories', 0 );