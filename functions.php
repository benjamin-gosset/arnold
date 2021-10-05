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
add_action( 'wp_enqueue_scripts', 'arnold_register_assets' );

function arnold_register_assets() {
    // Styles
    wp_enqueue_style( 'arnold', get_template_directory_uri() . '/dist/css/main.min.css', array(), '1.0');

    // Scripts
    wp_enqueue_script( 'arnold', get_template_directory_uri() . '/dist/js/app.js', array(), '1.0', true);
}

/**
 * Register menus
 */ 
register_nav_menus( array(
	'primary-menu' => esc_html__( 'Primary menu', 'arnold' ),
	'topbar-menu' => esc_html__( 'Top bar menu', 'arnold' ),
	'social-menu' => esc_html__( 'Main menu social icons', 'arnold' ),
	'footer-menu-1' => esc_html__( 'Footer menu 1', 'arnold' ),
	'footer-menu-2' => esc_html__( 'Footer menu 2', 'arnold' ),
	'footer-bottom-menu' => esc_html__( 'Footer bottom menu', 'arnold' ),
	'footer-social-menu' => esc_html__( 'Footer social icons', 'arnold' ),
) );

/**
 * Remove post tags
 */
add_action( 'init', 'arnold_remove_default_taxos', 2 );
function arnold_remove_default_taxos() {
    global $wp_taxonomies;
    unset($wp_taxonomies['post_tag']);
}

/**
 * Add categories to pages
 */
function arnold_categories_support() {
	register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'arnold_categories_support' );

/**
 * Add Rich Categories with Gutenberg editor as CPT
 */
// Register Custom Post Type
function arnold_content_categories() {

	$labels = array(
		'name'                  => _x( 'Catégories enrichies', 'Post Type General Name', 'arnold' ),
		'singular_name'         => _x( 'Content Category', 'Post Type Singular Name', 'arnold' ),
		'menu_name'             => __( 'Catégories', 'arnold' ),
		'name_admin_bar'        => __( 'Catégories enrichies', 'arnold' ),
		'archives'              => __( 'Item Archives', 'arnold' ),
		'attributes'            => __( 'Item Attributes', 'arnold' ),
		'parent_item_colon'     => __( 'Parent Item:', 'arnold' ),
		'all_items'             => __( 'Toutes les catégories enrichies', 'arnold' ),
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
		'label'                 => __( 'Content Category', 'arnold' ),
		'description'           => __( 'Create content-rich categories', 'arnold' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => true,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 25,
		'menu_icon'             => 'dashicons-admin-plugins',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => false,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => false,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'content_categories', $args );

}
add_action( 'init', 'arnold_content_categories', 0 );

// Add parent category to breadcrumb
add_filter( 'wpseo_breadcrumb_links', 'arnold_override_yoast_breadcrumb_trail' );
function arnold_override_yoast_breadcrumb_trail( $links ) {
	if ( is_category() ) {
		$cat_id = $links[1]['term_id'];
    	$cat_infos = get_category( $cat_id );
		$cat_parent_id = $cat_infos->parent;

		if ( ! empty( $cat_parent_id ) ) {
			$cat_parent_infos = get_category( $cat_parent_id );
        
			$breadcrumb[] = array(
				'url' => get_category_link( $cat_parent_id ),
				'text' => $cat_parent_infos->name,
			);
			
			array_splice( $links, 1, -2, $breadcrumb );
		}
	}
    return $links;
}

// Main Nav Walker
class Nav_Walker extends Walker_Nav_Menu 
{
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		if ( $args->walker->has_children ) {
			
		}		
	return $output;
	}
}