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
	
	/*if ( is_front_page() ) {
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/dist/css/vendor/swiper-bundle.min.css', array(), '1.0');
	}*/

	if ( is_page( 19 ) ) {
		wp_enqueue_style( 'leaflet', '//unpkg.com/leaflet@1.7.1/dist/leaflet.css', array(), '1.0');
	}
	

    // Scripts
    /*if ( is_front_page() ) {
		wp_enqueue_script( 'swiper', get_template_directory_uri() . '/dist/js/vendor/swiper-bundle.min.js', array(), '1.0', true);
	}*/

	if ( is_page( 19 ) ) {
		wp_enqueue_script( 'leaflet', '//unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), '1.0', true);
	}

	wp_enqueue_script( 'arnold', get_template_directory_uri() . '/dist/js/app.js', array(), '1.0', true);
}

/** 
 * Add integrity and crossorigin for Leaflet CSS and JS 
 **/
add_filter( 'style_loader_tag', 'add_leaflet_css_attributes', 10, 2 );

function add_leaflet_css_attributes( $html, $handle ) {
    if ( 'leaflet' === $handle ) {
        return str_replace( "media='all'", "media='all' integrity='sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==' crossorigin=''", $html );
    }
    return $html;
}

add_filter( 'script_loader_tag', 'add_leaflet_js_attributes', 10, 3 );

function add_leaflet_js_attributes( $tag, $handle, $src ) {
    if ( 'leaflet' === $handle ) {
        $tag = '<script src="' . esc_url( $src ) . '" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>';
    }
    return $tag;
}


/**
 * Register menus
 **/ 
register_nav_menus( array(
	'primary-menu' => esc_html__( 'Primary menu', 'arnold' ),
	'topbar-menu' => esc_html__( 'Top bar menu', 'arnold' ),
	'social-menu' => esc_html__( 'Main menu social icons', 'arnold' ),
	'footer-menu-1' => esc_html__( 'Footer menu 1', 'arnold' ),
	'footer-menu-2' => esc_html__( 'Footer menu 2', 'arnold' ),
	'footer-menu-3' => esc_html__( 'Footer menu 3', 'arnold' ),
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
 * Deactivate internal pings
 */
function arnold_no_internal_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, $home ) ) {
			unset($links[$l]);
		}
	}
}
add_action( 'pre_ping' , 'arnold_no_internal_ping' );

/**
 * Add alt column for medias
 */
function arnold_adm_media_attachment_alt($cols) {
	$cols["alt"] = 'ALT Text';
	return $cols;
}
function arnold_adm_media_attachment_alt_content($column_name, $id) {
	if ( $column_name === 'alt' ) {
		echo get_post_meta( $id, '_wp_attachment_image_alt', true);
	}
}
add_filter('manage_media_columns', 'arnold_adm_media_attachment_alt', 1);
add_action('manage_media_custom_column', 'arnold_adm_media_attachment_alt_content', 1, 2);

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
	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = array( 'sub-menu' );

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<svg width=\"14\" height=\"8\" viewBox=\"0 0 14 8\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
		<path d=\"M0.989502 1.70193L6.99991 7.71234L13.0103 1.70193L11.5961 0.28772L6.99991 4.88391L2.40372 0.28772L0.989502 1.70193Z\" fill=\"#2E3A59\"/>
		</svg><ul$class_names>{$n}";
	}


	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 * @since 5.9.0 Renamed `$item` to `$data_object` to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output      Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object Menu item data object. Not used.
	 * @param int      $depth       Depth of page. Not Used.
	 * @param stdClass $args        An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		
		$item_has_children = false;

		foreach ( $data_object->classes as $item_class ) {
			if ( $item_class == 'menu-item-has-children' ) {
				$item_has_children = true;
			}
		}

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		if ( $item_has_children == true ) {
			$output .= '<button aria-label="Voir le sous-menu"><span class="plus">&plus;</span><span class="minus">&minus;</span></button>';
		}

		$output .= '</li>'.$n;
	}
}

// CPT Realisations
function bgo_sites_post_type() {

	$labels = array(
		'name'                  => _x( 'R??alisations', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'R??alisation', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'R??alisations', 'text_domain' ),
		'name_admin_bar'        => __( 'R??alisation', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Toutes les r??alisations', 'text_domain' ),
		'add_new_item'          => __( 'Ajouter une nouvelle r??alisation', 'text_domain' ),
		'add_new'               => __( 'Ajouter', 'text_domain' ),
		'new_item'              => __( 'Nouvelle r??alisation', 'text_domain' ),
		'edit_item'             => __( 'Modifier la r??alisation', 'text_domain' ),
		'update_item'           => __( 'Mettre ?? jour la r??alisation', 'text_domain' ),
		'view_item'             => __( 'Voir la r??alisation', 'text_domain' ),
		'view_items'            => __( 'Voir les r??alisations', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'realisations',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'R??alisation', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-images-alt2',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'realisation', $args );

}

add_action( 'init', 'bgo_sites_post_type', 0 );


class Walker_Reformated_Category extends Walker_Category
{
	static $counter = 0;

    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters( 'list_cats', esc_attr( $category->name ), $category );

		// Don't generate an element if the category name is empty.
		if ( '' === $cat_name ) {
			return;
		}

		$atts         = array();
		$atts['href'] = get_term_link( $category );

		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			/**
			 * Filters the category description for display.
			 *
			 * @since 1.2.0
			 *
			 * @param string  $description Category description.
			 * @param WP_Term $category    Category object.
			 */
			$atts['title'] = strip_tags( apply_filters( 'category_description', $category->description, $category ) );
		}

		/**
		 * Filters the HTML attributes applied to a category list item's anchor element.
		 *
		 * @since 5.2.0
		 *
		 * @param array   $atts {
		 *     The HTML attributes applied to the list item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $href  The href attribute.
		 *     @type string $title The title attribute.
		 * }
		 * @param WP_Term $category Term data object.
		 * @param int     $depth    Depth of category, used for padding.
		 * @param array   $args     An array of arguments.
		 * @param int     $id       ID of the current category.
		 */
		$atts = apply_filters( 'category_list_link_attributes', $atts, $category, $depth, $args, $id );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$link = sprintf(
			'<a%s>%s</a>',
			$attributes,
			$cat_name
		);

		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			$link .= ' ';

			if ( empty( $args['feed_image'] ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

			if ( empty( $args['feed'] ) ) {
				/* translators: %s: Category name. */
				$alt = ' alt="' . sprintf( __( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
			} else {
				$alt   = ' alt="' . $args['feed'] . '"';
				$name  = $args['feed'];
				$link .= empty( $args['title'] ) ? '' : $args['title'];
			}

			$link .= '>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= $name;
			} else {
				$link .= "<img src='" . esc_url( $args['feed_image'] ) . "'$alt" . ' />';
			}
			$link .= '</a>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= ')';
			}
		}

		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' (' . number_format_i18n( $category->count ) . ')';
		}
		if ( 'list' === $args['style'] ) {
			$output     .= "\t<li";
			$css_classes = array(
				'cat-item',
				'cat-item-' . $category->term_id,
			);

			if ( ! empty( $args['current_category'] ) ) {
				// 'current_category' can be an array, so we use `get_terms()`.
				$_current_terms = get_terms(
					array(
						'taxonomy'   => $category->taxonomy,
						'include'    => $args['current_category'],
						'hide_empty' => false,
					)
				);

				foreach ( $_current_terms as $_current_term ) {
					if ( $category->term_id == $_current_term->term_id ) {
						$css_classes[] = 'current-cat';
						$link          = str_replace( '<a', '<a aria-current="page"', $link );
					} elseif ( $category->term_id == $_current_term->parent ) {
						$css_classes[] = 'current-cat-parent';
					}
					while ( $_current_term->parent ) {
						if ( $category->term_id == $_current_term->parent ) {
							$css_classes[] = 'current-cat-ancestor';
							break;
						}
						$_current_term = get_term( $_current_term->parent, $category->taxonomy );
					}
				}
			}

			/**
			 * Filters the list of CSS classes to include with each category in the list.
			 *
			 * @since 4.2.0
			 *
			 * @see wp_list_categories()
			 *
			 * @param string[] $css_classes An array of CSS classes to be applied to each list item.
			 * @param WP_Term  $category    Category data object.
			 * @param int      $depth       Depth of page, used for padding.
			 * @param array    $args        An array of wp_list_categories() arguments.
			 */
			$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
			$css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';

			$output .= $css_classes;
			$output .= ">$link\n";
		} elseif ( isset( $args['separator'] ) ) {
			$output .= "\t<div class=\"siblings-cat__item card\">$link" . $args['separator'] . "\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}

	

    function end_el(&$output, $item, $depth=0, $args=array()) {
		$output .= '<svg role="img" aria-label="Lire la suite" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M11.17 11H5V9H11.17L8.59 6.41L10 5L15 10L10 15L8.59 13.59L11.17 11Z" fill="#2E3A59"/>
		<path fill-rule="evenodd" clip-rule="evenodd" d="M0 10C4.82823e-07 4.47715 4.47715 -4.82823e-07 10 0C15.5228 4.82823e-07 20 4.47715 20 10C20 15.5228 15.5228 20 10 20C4.47715 20 -4.82823e-07 15.5228 0 10ZM2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10Z" fill="#2E3A59"/>
		</svg></div>';
		return $output;
	}
}

/**
 * Exclude a post type from XML sitemaps.
 *
 * @param boolean $excluded  Whether the post type is excluded by default.
 * @param string  $post_type The post type to exclude.
 *
 * @return bool Whether or not a given post type should be excluded.
 */
function bgo_sitemap_exclude_post_type( $excluded, $post_type ) {
    return $post_type === 'realisation';
}

add_filter( 'wpseo_sitemap_exclude_post_type', 'bgo_sitemap_exclude_post_type', 10, 2 );
