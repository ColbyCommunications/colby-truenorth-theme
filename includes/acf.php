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

  // Allow Shortcode in Instructions
  function ad_acf_prepare_field($field) {
    $field['instructions'] = do_shortcode($field['instructions']);
    return $field;
  }
  add_filter('acf/prepare_field/key=field_5f71fdff1dead', 'ad_acf_prepare_field');
  add_filter('acf/prepare_field/key=field_5f71fe2c1deae', 'ad_acf_prepare_field');
  add_filter('acf/prepare_field/key=field_5f71fe411deb0', 'ad_acf_prepare_field');

}
