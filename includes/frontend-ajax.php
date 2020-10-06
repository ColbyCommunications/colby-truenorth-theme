<?php
/**
 * Frontend Ajax Requests
 */

// Front End Ajax Request - Localize Variable For Ajax URL
function ad_frontend_ajax_request() {
  wp_localize_script(
    'extras_js',
    'ajax_obj',
    array('ajaxurl' => admin_url('admin-ajax.php'))
  );
}
add_action('wp_enqueue_scripts', 'ad_frontend_ajax_request');

// This will take the path of the ajax url and output the content in the php file in the template-parts/module/ folder
function ad_ajax_request() {
  // The $_REQUEST contains all the data sent via ajax
  if (isset($_REQUEST)) {
    $ajax_path = $_REQUEST['ajax_path'];
    // Let's take the data that was sent and do something with it
    if ($ajax_path != '') {
      get_template_part( 'template-parts/modules/forms/'.$ajax_path );
    }
    // If you're debugging, it might be useful to see what was sent in the $_REQUEST
    // print_r($_REQUEST);
  }
  // Always die in functions echoing ajax content
  die();
}

// Allows logged in and non-loggedin users to access content
add_action('wp_ajax_ad_ajax_request', 'ad_ajax_request');
add_action('wp_ajax_nopriv_ad_ajax_request', 'ad_ajax_request');


// Post Filtering
function ad_post_filter() {
  $ajax_data = $_GET; // get posted data
	$query = (isset($ajax_data['query'])) ? $ajax_data['query'] : ''; // get posted data
  $filter_array = array();
  $filter_settings = (isset($ajax_data['settings'])) ? $ajax_data['settings'] : ''; // get filter settings
  $filter_tax_object = '';

  // Check for filter template and filter list
  if ( empty($filter_settings['query_template']) || empty($filter_settings['list_template']) ) {
    die();
  }

  // If on Taxonomy page
  if (!empty($filter_settings['tax'])) {
    $filter_tax_object = get_term($filter_settings['tax']);
  }

  // If Filter Args
  if (!empty($filter_settings['query_args'])) {
    $post_filters_args = $filter_settings['query_args'];
  }

  // Convert Filter Form Data to Array
  parse_str($query, $filter_array);

  $post_filters = array(
    'category' => (isset($filter_array['category'])) ? $filter_array['category'] : '',
    'pagination' => (isset($filter_array['pag'])) ? $filter_array['pag'] : 1
  );

  // Filter Arguments
  include( locate_template( $filter_settings['query_template'] . '.php', false, false ) );

  // Filter Query
  $post_query = new WP_Query( $post_args );

  echo '<div class="ajax-load">';
  while ($post_query->have_posts()) {
    $post_query->the_post();
    include( locate_template( $filter_settings['list_template'] . '.php', false, false ) );
  }
  echo '</div>';

  echo '<div class="ajax-load-pagination">';
  $pagination_query = $post_query;

  include(locate_template('template-parts/modules/pagination.php', false, false));
  echo '</div>';

  die();
}

// Allows logged in and non-loggedin users to access content
add_action('wp_ajax_ad_post_filter', 'ad_post_filter');
add_action('wp_ajax_nopriv_ad_post_filter', 'ad_post_filter');
