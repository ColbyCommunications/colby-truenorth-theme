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
function ad_event_status($show_event_start_date_time = null, $show_event_end_date_time = null, $show_event_timezone = 'America/New_York') {

 if (!isset($show_event_start_date_time) || !isset($show_event_end_date_time)) {
   return "Pre";
 }

 $date_now = new DateTime(wp_date(DATE_RFC3339));
 $date_now = $date_now->setTimezone(new DateTimeZone($show_event_timezone));
 $date_now = new DateTime($date_now->format('Y-m-d H:i:s'));
 #pretty_dump($date_now);

 $date_start_show_event = new DateTime($show_event_start_date_time);
 #pretty_dump($date_start_show_event);

 $date_end_show_event = new DateTime($show_event_end_date_time);
 #pretty_dump($date_end_show_event);

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
 * Function to create date range
 */
function ad_start_end_date($start_date = '', $end_date = '') {
  $event_date = '';
  $start_date_time = new DateTime($start_date);
  $start_date = $start_date_time->format('Y-m-d');
  $end_date_time = new DateTime($end_date);
  $end_date = $end_date_time->format('Y-m-d');
  if ($start_date == $end_date) {
    $event_date = $start_date_time->format('F j, Y');
  }
  else {
    $event_start_mo = $start_date_time->format('m');
    $event_end_mo = $end_date_time->format('m');
    if ($event_start_mo == $event_end_mo) {
      $event_date = $start_date_time->format('F') . ' ' . $start_date_time->format('j') . '-' . $end_date_time->format('j') . ', ' . $start_date_time->format('Y');
    }
    else {
      $event_date = $start_date_time->format('F j, Y') . ' - ' . $end_date_time->format('F j, Y');
    }
  }
  return $event_date;
}

/**
 * Function to check if user is logged in and registered for event
 */
function ad_registered_event($event_id = null) {
  if (!is_user_logged_in() || !isset($event_id)) {
    return false;
  }

  $current_user = wp_get_current_user(); // Current User Info
  $roles_access = array('member', 'administrator');
  $current_user_member = (count(array_intersect($current_user->roles, $roles_access)) > 0) ? true : false; // Current User Part of the "Member" or "Administrator" role

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
function ad_event_dates($date = null, $date_end = null, $start_time = null, $end_time = null, $time_zone = null) {

  $add_to_cal = array(
    "date_cal_start_iso" => '',
    "date_cal_end_iso" => '',
  );

  if (!isset($date) || !isset($date_end) || !isset($start_time) || !isset($end_time) || !isset($time_zone)) {
    return $add_to_cal;
  }

  // Event Date
  $date_event_start = new DateTime($date);
  // Event Date End
  if (empty($date_end)) {
    $date_end = $date;
  }
  $date_event_end = new DateTime($date_end);
  // Event Start Time
  $time_event_start = new DateTime($start_time);
  // Event End Time
  $time_event_end = new DateTime($end_time);
  // Event Time Zone
  $date_cal_timezone = $time_zone;

  // Format Event Start & End For Add To Calendar
  $date_cal_start = $date_event_start->format('Y-m-d');
  $date_cal_end = $date_event_end->format('Y-m-d');
  // Format Event Start Date and Time For Add To Calendar
  $date_cal_start_time = $time_event_start->format('H:i:s');
  $date_cal_start_combine = $date_cal_start . ' ' . $date_cal_start_time . ' ' .   $date_cal_timezone['value'];
  $date_cal_start_iso = new DateTime($date_cal_start_combine);
  $date_cal_start_iso = $date_cal_start_iso->format(DateTime::ATOM);
  // Format Event End Date and Time For Add To Calendar
  $date_cal_end_time = $time_event_end->format('H:i:s');
  $date_cal_end_combine = $date_cal_end . ' ' . $date_cal_end_time . ' ' .   $date_cal_timezone['value'];
  $date_cal_end_iso = new DateTime($date_cal_end_combine);
  $date_cal_end_iso = $date_cal_end_iso->format(DateTime::ATOM);

  return $add_to_cal = array(
    "date_cal_start_iso" => $date_cal_start_iso,
    "date_cal_end_iso" => $date_cal_end_iso
  );

}


add_filter( 'gform_pre_send_email', 'ad_before_email' );
function ad_before_email( $email ) {
  $email['subject'] = html_entity_decode($email['subject']);
  return $email;
}
