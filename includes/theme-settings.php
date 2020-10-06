<?php
/**
 * Theme Settings
 */

add_theme_support( 'title-tag' ); // WP Page Title Support
add_theme_support('menus'); // WP Menu Theme Support
add_theme_support( 'customize-selective-refresh-widgets' ); // Selective Refresh Widgets
add_theme_support( 'post-thumbnails' ); // Add Support For Post Thumbnails
remove_action('wp_head', 'print_emoji_detection_script', 7); // Suppresses WP Emoji
remove_action('wp_print_styles', 'print_emoji_styles'); // Suppresses WP Emoji
remove_action('admin_print_scripts', 'print_emoji_detection_script'); // Suppresses WP Emoji
remove_action('admin_print_styles', 'print_emoji_styles'); // Suppresses WP Emoji
remove_action('wp_head', 'wp_generator'); // Suppresses the XHTML generator that just outputs some WordPress Info
remove_action('wp_head', 'wlwmanifest_link'); // Suppresses resource file needed to enable support for Windows Live Writer
remove_action('wp_head', 'wp_shortlink_wp_head'); // Suppresses the "shortlink"
remove_action('wp_head', 'rsd_link'); // Suppresses The RSD which is an API to edit your blog from external services and clients. If you edit your blog exclusively from the WP admin console, you don’t need this.
remove_action('wp_head', 'feed_links', 2 ); // Suppresses feed links.
remove_action('wp_head', 'feed_links_extra', 3 ); // Suppresses comments feed.
remove_action('wp_head', 'rest_output_link_wp_head' ); // Suppresses REST API Meta Data
remove_filter( 'the_content', 'wpautop' ); // Disables changing double line-breaks in the text into HTML paragraphs

// Adds Custom Thumbnail Sizes
update_option("thumbnail_crop", "1");
update_option("medium_crop", "1");
update_option("large_crop", "1");

function remove_default_image_sizes( $sizes) {
    unset( $sizes['1536x1536']);
    unset( $sizes['2048x2048']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');

// Adds Custom Thumbnail Sizes
add_image_size( 'media-thumb', 298, 214, true );
add_image_size( 'event-thumb', 400, 230, true );
add_image_size( 'carousel-thumb', 400, 274, true );

function ad_override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
} add_filter('tiny_mce_before_init', 'ad_override_mce_options');

// Custom Admin Menu Edits
function ad_custom_menu_positions() {
	// Move "Menus" item to it's own option in admin menu
  add_menu_page('Menus', 'Menus', 'edit_theme_options', 'nav-menus.php', '', 'dashicons-list-view', 20);
	remove_submenu_page('themes.php','nav-menus.php');
}
add_action( 'admin_menu', 'ad_custom_menu_positions' );

// Remove Comments Toolbar Menu Item
function ad_theme_remove_toolbar_node($wp_admin_bar) {
	$wp_admin_bar->remove_node('comments');
}
add_action('admin_bar_menu', 'ad_theme_remove_toolbar_node', 999);

// Add SVG Support
function ad_add_file_types_to_uploads($file_types) {
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}
add_action('upload_mimes', 'ad_add_file_types_to_uploads');

// Custom Display the classes for the body element.
require get_parent_theme_file_path('/includes/custom-functions/body-class.php');

// Detect if user logged in by role
function ad_if_user_role($user_role) {
  if( is_user_logged_in() ) {
    $user_check = ($user_role) ? $user_check = $user_role : $user_check = "";
    $user = wp_get_current_user();
    $role = ( array ) $user->roles;
    if (in_array($user_check, $role)) {
        return true;
    }
    else {
      return false;
    }
  } else {
    return false;
  }
}

// Remove All Default WP Dashboard Widgets
function ad_remove_dashboard_meta() {
  remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); // Incoming Links
  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' ); // Plugins
  remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // WordPress blog
  remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' ); // Other WordPress News
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Quick Press
  remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' ); // Recent Drafts
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // Right Now
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal'); // Activity
  // Hide these widgets if not administrator
  if ( !ad_if_user_role("administrator") ) {
    remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal'); // WP Engine Overview
    remove_meta_box( 'wpe_dify_news_feed', 'dashboard', 'normal'); // WP Engine News Feed
  }
}
add_action( 'admin_init', 'ad_remove_dashboard_meta' );

// Remove Welcome Widget
remove_action('welcome_panel', 'wp_welcome_panel');
