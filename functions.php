<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'parallax', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'parallax' ) );

//* Add Image upload to WordPress Theme Customizer
add_action( 'customize_register', 'parallax_customizer' );
function parallax_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );
	
}

//* Include Section Image CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Parallax Pro Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/parallax/' );
define( 'CHILD_THEME_VERSION', '1.2' );


	//wp_deregister_script('jquery');( 'jquery-ui-core' );
    //wp_deregister_script('jquery');( 'jquery-ui-datepicker' );
	//wp_deregister_script('jquery');( 'jquery-ui-datepicker-local' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'parallax_enqueue_scripts_styles' );
function parallax_enqueue_scripts_styles() {

	wp_enqueue_script( 'parallax-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/responsive-menu.css', array() );
	wp_enqueue_style( 'customcss', get_bloginfo( 'stylesheet_directory' ) . '/custom.css', array() );
	wp_enqueue_style( 'Titillium-google-fonts', '//fonts.googleapis.com/css?family=Titillium+Web:400,300,300italic,400italic,600,600italic,700,900,700italic', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'Roboto-Condensed-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'tooltip', get_bloginfo( 'stylesheet_directory' ) . '/css/hint.css', array() );
	
}


//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'parallax_secondary_menu_args' );
function parallax_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

// Removes Query Strings from scripts and styles
function remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', 'remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'remove_script_version', 15, 1 );


//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Add support for additional color styles
add_theme_support( 'genesis-style-selector', array(
	'parallax-pro-blue'   => __( 'Parallax Pro Blue', 'parallax' ),
	'parallax-pro-green'  => __( 'Parallax Pro Green', 'parallax' ),
	'parallax-pro-orange' => __( 'Parallax Pro Orange', 'parallax' ),
	'parallax-pro-pink'   => __( 'Parallax Pro Pink', 'parallax' ),
) );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 360,
	'height'          => 70,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'footer-widgets',
	'footer',
) );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'parallax_author_box_gravatar' );
function parallax_author_box_gravatar( $size ) {

	return 176;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'parallax_comments_gravatar' );
function parallax_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;

	return $args;

}

//* Include Custom banner for home and subpages
add_action( 'genesis_after_header', 'banner' );

function banner() {

 if (is_front_page()) {  
		require(CHILD_DIR.'/home-banner.php');
	 }
  // If it's the About page, display subpage banner
	elseif ( is_page()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif ( is_single()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif ( is_archive()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif(is_home()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif(is_404()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	

}


// Add Read More Link to Excerpts

add_filter('excerpt_more', 'get_read_more_link');

add_filter( 'the_content_more_link', 'get_read_more_link' );

function get_read_more_link() {

   return '...&nbsp;<a class="readmore" href="' . get_permalink() . '">[Read&nbsp;More]</a>';

}


// Customize the post info function
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
	$post_info = 'Posted on: [post_date]';
	return $post_info;
}

// Button Shortcode
function download_button($atts, $content = null) {
 extract( shortcode_atts( array(
          'url' => '#'
), $atts ) );
return '<a href="'.$url.'" class="wpbutton"><span>' . do_shortcode($content) . '</span></a>';
}
add_shortcode('download', 'download_button');
 

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_footer', 'genesis_footer_widget_areas', 5 );

/* Genesis - Remove breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//Changing the Copyright text
add_action( 'genesis_after_footer', 'genesischild_footer_creds_text' );
function genesischild_footer_creds_text () {
 echo '<div class="credits-section"><div class="wrap"><p class="copyright">Copyright © '. date('Y') .' - All rights reserved</p><p class="site-links"><a href="/site-map/">Site Map</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/privacy-policy/">Privacy Policy</a></p></div></div>';
}

//Remove Genesis Footer Credits and Return to Top Text
remove_action( 'genesis_footer', 'genesis_do_footer' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );


// Widget - Latest News on home page
genesis_register_sidebar( array(
	'id'			=> 'genesis-featured-posts',
	'name'			=> __( 'Latest News on Home Page', 'timothy' ),
	'description'	=> __( 'This is home page widget', 'timothy' ),
) );

// Widget - Testimonials on home page
genesis_register_sidebar( array(
	'id'			=> 'testimonials-home',
	'name'			=> __( 'Latest Testimonials on Home Page', 'timothy' ),
	'description'	=> __( 'This is home page widget', 'timothy' ),
) );


//* Rotate image using Sub Tag
function random_hero_img($tag) { 

	$args = array( 'post_type' => 'attachment', 
				// 'post_status' => 'publish',
				'orderby' => 'rand',
				'post_mime_type' => 'image',
				'post_status' => 'inherit',
				'tax_query' => array(
					array(
						'taxonomy' => 'media_tag',
						'field' => 'slug',
						'terms' => $tag
					)
				
						));
    $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
		  $image = wp_get_attachment_image_src('', $size, false);
		  
		endwhile; 
		wp_reset_query();
		$header_url = $image[0];
  return $header_url;
  
}

// Previous / Next Post Navigation Filter
add_filter( 'genesis_prev_link_text', 'gt_review_prev_link_text' );
function gt_review_prev_link_text() {
        $prevlink = '&laquo;';
        return $prevlink;
}
add_filter( 'genesis_next_link_text', 'gt_review_next_link_text' );
function gt_review_next_link_text() {
        $nextlink = '&raquo;';
        return $nextlink;
}


/*Custom Post Type For Projects/Map */

function my_custom_post_project() {
  $labels = array(
    'name'               => _x( 'Projects', 'post type general name' ),
    'singular_name'      => _x( 'Project', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'project' ),
    'add_new_item'       => __( 'Add New Project' ),
    'edit_item'          => __( 'Edit Project' ),
    'new_item'           => __( 'New Project' ),
    'all_items'          => __( 'All Project' ),
    'view_item'          => __( 'View Project' ),
    'search_items'       => __( 'Search Project' ),
    'not_found'          => __( 'No Projects found' ),
    'not_found_in_trash' => __( 'No Projects found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Projects'
  );
  $args = array(
    'labels'        => $labels,
        'description'   => 'Holds our events and event specific data',
        'public'        => true,
        'menu_position' => 5,
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'has_archive'   => true,    
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'project', 'with_front' => true),
        'capability_type' => 'post',
        'hierarchical' => false,
  );
  register_post_type( 'project', $args ); 
  flush_rewrite_rules();
}
add_action( 'init', 'my_custom_post_project' );

//Custom Taxonomies For Project Post Type

function my_taxonomies_project() {
  $labels = array(
    'name'              => _x( 'Project Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Project Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Project Categories' ),
    'all_items'         => __( 'All Project Categories' ),
    'parent_item'       => __( 'Parent Project Category' ),
    'parent_item_colon' => __( 'Parent Project Category:' ),
    'edit_item'         => __( 'Edit Project Category' ), 
    'update_item'       => __( 'Update Project Category' ),
    'add_new_item'      => __( 'Add New Project Category' ),
    'new_item_name'     => __( 'New Project Category' ),
    'menu_name'         => __( 'Project Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'project_category', 'project', $args );
}
add_action( 'init', 'my_taxonomies_project', 0 );

//CUSTOM INTERACTION MESSAGES For Project Post Type

function my_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['project'] = array(
    0 => '', 
    1 => sprintf( __('Project updated. <a href="%s">View Project</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Project updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Project published. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Project saved.'),
    8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );

remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
add_action( 'genesis_site_title', 'em_dynamic_site_title' );
function em_dynamic_site_title() {
	if(is_home() || is_front_page()) { ?> 
		<h1 class="site-title"><a href="/" title="Home"><?php bloginfo('name');?></a></h1>
	<?php } else { ?>
		<p class="site-title" itemprop="headline"><a href="/" title="Home"><?php bloginfo('name');?></a></p>
	<?php }
}
