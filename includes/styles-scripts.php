<?php
/**
 * Styles & Scripts
 */

// Sets theme styles
function ad_theme_styles() {
  $cache_buster = "100520200"; // Format: MMDDYYHMM
  wp_enqueue_style('screen', get_template_directory_uri() . '/style.css', array(), $cache_buster);
  wp_dequeue_style('wp-block-library'); // Remove Gutenberg Block CSS
}
add_action('wp_enqueue_scripts', 'ad_theme_styles');

// Sets admin styles
function ad_admin_styles() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/assets/css/admin.css');
}
add_action('admin_enqueue_scripts', 'ad_admin_styles');

// Sets theme js
function ad_theme_js() {
  $cache_buster = "100520200"; // Format: MMDDYYHMM
  wp_deregister_script('jquery'); // prevent defaults WP jQuery
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), null, false);
  wp_enqueue_script('extras_js', get_template_directory_uri() . '/assets/js/extras.js', array('jquery'), $cache_buster, true);
  wp_enqueue_script('scripts_js', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery', 'extras_js'), $cache_buster, true);

  // Custom GA Setup
  wp_enqueue_script('gtag_js', 'https://www.googletagmanager.com/gtag/js?id=UA-109273021-10#asyncload', array(), null, false);

  if (is_user_logged_in()) {
    $current_user = wp_get_current_user(); // Current User Info
    wp_add_inline_script('gtag_js', 'window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}');
    wp_add_inline_script('gtag_js', 'gtag(\'js\', new Date());');
    wp_add_inline_script('gtag_js', 'gtag(\'set\', {\'user_id\': \''. $current_user->ID .'\'});');
    wp_add_inline_script('gtag_js', 'gtag(\'config\', \'UA-109273021-10\');');
  }

}
add_action('wp_enqueue_scripts', 'ad_theme_js');

function ad_async_scripts($url) {
   if (strpos($url, '#asyncload') === false) {
     return $url;
   }
   else if (is_admin()) {
     return str_replace('#asyncload', '', $url);
   }
   else {
     return str_replace( '#asyncload', '', $url )."' async='async";
   }
}
add_filter('clean_url', 'ad_async_scripts', 11, 1);

// Suppresses wp-embed script
function ad_deregister_scripts() {
  wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'ad_deregister_scripts');

// Add ACF Options closing head tracking codes
function ad_add_tracking_codes_head() {
  echo get_field('head_scripts', 'option') . "\n";
}
add_action( 'wp_head', 'ad_add_tracking_codes_head', 100 );

// Add ACF Options closing body tracking codes
function ad_add_tracking_codes_body() {
  echo get_field('body_scripts', 'option') . "\n";
}
add_action( 'wp_footer', 'ad_add_tracking_codes_body', 100 );

function ad_site_kit_properties() {
  if (!is_user_logged_in()) {
    return;
  }
  $current_user = wp_get_current_user(); // Current User Info
  wp_add_inline_script('google_gtagjs', 'gtag(\'set\', {\'user_id\': \''. $current_user->ID .'\'});');
}
add_filter('googlesitekit_gtag_opt', 'ad_site_kit_properties');
