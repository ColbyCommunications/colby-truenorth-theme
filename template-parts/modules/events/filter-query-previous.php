<?php
// Current Date
$date_now = new DateTime(wp_date(DATE_RFC3339), new DateTimeZone('-05:00'));
$date_now = $date_now->format('Y-m-d'); // Format to only have date so that events are compared only with the current date and not current time
$post_args = array(
  'post_type' => 'events',
  'post_status' => 'publish',
  'posts_per_page'=> 9,
  'meta_query' => array(
    array(
      'key'	=> 'date',
      'compare'	=> '<',
      'value'	=> $date_now,
      'type' => 'DATETIME'
    )
  ),
  'order'	=> 'DESC',
  'orderby' => 'meta_value',
  'meta_key' => 'date',
  'meta_type'	=> 'DATE',
  'paged' => $post_filters['pagination']
);

$prev_event = true;
