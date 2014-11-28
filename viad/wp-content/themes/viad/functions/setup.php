<?php

//echo get_admin_url();
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function viad_ajaxurl() {
	?>
	<script type="text/javascript">var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
	<?php
}        
add_action('wp_head','viad_ajaxurl');

function viad_custom_roles() {

	$capabilities = array(
        'read'         => true,
        'edit_posts'   => true,
        'delete_posts' => false
    );
	
	add_role('member_basis', 'Basis member' , $capabilities);
	add_role('member_plus', 'Plus member' , $capabilities);
	add_role('member_custom', 'Custom member' , $capabilities);
	
	remove_role( 'editor' );
	remove_role( 'author' );
	remove_role( 'contributor' );
	remove_role( 'subscriber' );


}
add_action( 'init', 'viad_custom_roles' );

function viad_custom_types() {

    $args = array(
      'public' => true,
      'label'  => 'Frontpage blocks',
      'has_archive' => false,
	  'capability_type' => 'page',
	  'hierarchical' => true,
	  'supports' => array('page-attributes', 'editor', 'title')	
    );
    register_post_type( 'fp_blocks', $args );

    $args = array(
      'public' => true,
      'label'  => 'Companies',
      'has_archive' => true,
	  'taxonomies' => array('category','post_tag')      
    );
    register_post_type( 'companies', $args );

    $args = array(
      'public' => true,
      'label'  => 'Professionals',
      'has_archive' => true,
	  'taxonomies' => array('category','post_tag')      
    );
    register_post_type( 'professionals', $args );

/*
    $args = array(
      'public' => true,
      'label'  => 'Groups',
      'has_archive' => true,
	  'taxonomies' => array('category')      
    );
    register_post_type( 'groups', $args );
*/


    $args = array(
      'public' => true,
      'label'  => 'Projects',
      'has_archive' => true,
	  'taxonomies' => array('category', 'post_tag'),
	  'hierarchical' => true,
	  'supports' => array('page-attributes', 'editor', 'title')	
    );
    register_post_type( 'projects', $args );

    $args = array(
      'public' => true,
      'label'  => 'Blog',
      'has_archive' => false,
/* 	  'taxonomies' => array('category')       */
    );
    register_post_type( 'blog', $args );

    $args = array(
      'public' => true,
      'label'  => 'Emails',
      'has_archive' => true
    );
    register_post_type( 'emails', $args );

    $args = array(
      'public' => true,
      'label'  => 'Messages',
      'has_archive' => true
    );
    register_post_type( 'messages', $args );

	$args = array(
      'public' => true,
      'label'  => 'Reviews',
      'has_archive' => true
    );
    register_post_type( 'reviews', $args );


}
add_action( 'init', 'viad_custom_types' );

function viad_head_cleanup() {

    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);

    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

    if (!class_exists('WPSEO_Frontend')) {
        remove_action('wp_head', 'rel_canonical');
        add_action('wp_head', 'viad_rel_canonical');
    }
}

function viad_rel_canonical() {
    global $wp_the_query;

    if (!is_singular()) {
        return;
    }

    if (!$id = $wp_the_query->get_queried_object_id()) {
        return;
    }

    $link = get_permalink($id);
    echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}
add_action('init', 'viad_head_cleanup');


/**
 * Remove the WordPress version
 */
add_filter('the_generator', '__return_false');


/**
 * Disable admin bar frontend
 */
show_admin_bar(false);


/**
 * Clean up language_attributes() used in <html> tag
 *
 * Change lang="en-US" to lang="en"
 * Remove dir="ltr"
 */
function viad_language_attributes() {
    $attributes = array();
    $output = '';

    if (function_exists('is_rtl')) {
        if (is_rtl() == 'rtl') {
            $attributes[] = 'dir="rtl"';
        }
    }

    $lang = get_bloginfo('language');

    if ($lang && $lang !== 'en-US') {
        $attributes[] = "lang=\"$lang\"";
    } else {
        $attributes[] = 'lang="en"';
    }

    $output = implode(' ', $attributes);
    $output = apply_filters('viad_language_attributes', $output);

    return $output;
}
add_filter('language_attributes', 'viad_language_attributes');


function viad_redirect_admin(){
	if ( ! current_user_can( 'manage_options' ) && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX )) {
		wp_redirect( site_url() );
		exit;		
	}
}
add_action( 'admin_init', 'viad_redirect_admin' );

function viad_login_url( $orig_url, $redirect ) {
		return site_url();
}
add_filter( 'login_url', 'viad_login_url', 10, 2 );

function viad_login_failed() {
		wp_redirect( site_url() );
		exit;		

}
add_filter('wp_login_failed', 'viad_login_failed');



function viad_check_login($r, $d, $user) {

	$p_id = get_user_meta($user->ID,'profile_id');
	$profile_meta = get_post_meta($p_id[0], 'status');
	
//	if($profile_meta['status'][0] == 'draft') {
//		wp_redirect(get_permalink($p_id[0]).'#/edit-profile');
//	} else {
		wp_redirect(get_permalink($p_id[0]));
//	}
}

add_filter( 'login_redirect', 'viad_check_login', 10, 3 );


?>