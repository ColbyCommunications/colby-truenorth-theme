<?php
/**
 * Custom Functions (previously content.php)
 */

/**
 * Register custom query vars for filtering/sorting
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
 */

function ad_register_query_vars( $vars ) {
    $vars[] = 'register';
    $vars[] = 'category';
    return $vars;
}
add_filter( 'query_vars', 'ad_register_query_vars' );

/**
 * Sanitize Phone Numbers
 */
function ad_sanitize_phone($phone) {
  return preg_replace('/\D+/', '', $phone);
}

/**
 * Sanitize Email
 */
function ad_sanitize_email($email) {
  return str_replace("@","/at/", $email);
}

/**
 * Debug Pretty Output
 */
function pretty_dump($source) {
  echo '<pre>';
  var_dump($source);
  echo '</pre>';
}

/**
 * Function to check event status. Pre, Live, or Post Event
 */
function ad_event_status($show_event_start_date_time = null, $show_event_end_date_time = null) {

 if (!isset($show_event_start_date_time) || !isset($show_event_end_date_time)) {
   return "Pre";
 }

 $date_now = new DateTime(wp_date(DATE_RFC3339), new DateTimeZone('-05:00'));
 $date_start_show_event = new DateTime($show_event_start_date_time, new DateTimeZone('-05:00'));
 $date_end_show_event = new DateTime($show_event_end_date_time, new DateTimeZone('-05:00'));

 if ($date_now < $date_start_show_event) {
   return "Pre";
 }
 elseif ($date_now >= $date_start_show_event && $date_now < $date_end_show_event) {
   return "Live";
 }
 else {
   return "Post";
 }

}

/**
 * Function to check if user is logged in and registered for event
 */
function ad_registered_event($event_id = null) {
  if (!is_user_logged_in() || !isset($event_id)) {
    return false;
  }

  $current_user = wp_get_current_user(); // Current User Info
  $current_user_member = (in_array('member', $current_user->roles)); // Current User Part of the "Member" role

  // Check to see if user is already registered for event
  $user_event_args = array(
    'post_type' => 'event_registrations',
    'post_status' => 'publish',
    'posts_per_page'=> 1,
    'meta_query'	=> array(
      'relation'		=> 'AND',
      array(
        'key'=> 'user',
        'value'=> $current_user->ID,
      ),
      array(
        'key'=> 'event',
        'value'=> $event_id,
      )
    )
  );
  $user_event_query = new WP_Query($user_event_args);

  if ($current_user_member && $user_event_query->have_posts()) {
    return true;
  }

  return false;

}

/**
 * Function add to calendar date/time format
 */
function ad_event_dates($date = null, $start_time = null, $end_time = null, $time_zone = null) {

  $add_to_cal = array(
    "date_cal_start_iso" => '',
    "date_cal_end_iso" => '',
  );

  if (!isset($date) || !isset($start_time) || !isset($end_time) || !isset($time_zone)) {
    return $add_to_cal;
  }

  // Event Date
  $date_event_start = new DateTime($date);
  // Event Start Time
  $time_event_start = new DateTime($start_time);
  // Event End Time
  $time_event_end = new DateTime($end_time);
  // Event Time Zone
  $date_cal_timezone = $time_zone;

  // Format Event Start For Add To Calendar
  $date_cal_start = $date_event_start->format('Y-m-d');
  // Format Event Start Date and Time For Add To Calendar
  $date_cal_start_time = $time_event_start->format('H:i:s');
  $date_cal_start_combine = $date_cal_start . ' ' . $date_cal_start_time . ' ' .   $date_cal_timezone['value'];
  $date_cal_start_iso = new DateTime($date_cal_start_combine);
  $date_cal_start_iso = $date_cal_start_iso->format(DateTime::ATOM);
  // Format Event End Date and Time For Add To Calendar
  $date_cal_end_time = $time_event_end->format('H:i:s');
  $date_cal_end_combine = $date_cal_start . ' ' . $date_cal_end_time . ' ' .   $date_cal_timezone['value'];
  $date_cal_end_iso = new DateTime($date_cal_end_combine);
  $date_cal_end_iso = $date_cal_end_iso->format(DateTime::ATOM);

  return $add_to_cal = array(
    "date_cal_start_iso" => $date_cal_start_iso,
    "date_cal_end_iso" => $date_cal_end_iso
  );

}
