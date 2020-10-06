<?php
/**
 * Advanced Custom Field Settings
 */

if(class_exists('ACF')) {

  // Add ACF Options Page
  acf_add_options_page(array(
    'page_title' 	=> 'Theme Settings',
    'menu_title'	=> 'Theme Settings',
    'menu_slug' 	=> 'theme-general-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ));

  // Add ACF Filters
  add_filter('acf/format_value/type=text', 'do_shortcode');
  add_filter('acf/format_value/type=textarea', 'do_shortcode');

  // ACF Relationship Field Hook to Only Return Published Posts
  function ad_acf_relationship_return_publish( $value, $post_id, $field ) {
    $returned_value = array();
    if ($value) {
      foreach($value as $key => $id){
        if (get_post_status( $id ) == 'publish') {
          $returned_value[] = $id;
        }
      }
    }
    return $returned_value;
  }
  add_filter('acf/load_value/type=relationship', 'ad_acf_relationship_return_publish', 10, 3);

}
