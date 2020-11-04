<!-- Begin Previous Events -->
<div class="section pt10 pb10">
  <div class="row row-site column">
    <?php
      $current_user = wp_get_current_user();
      $current_user_event_ids = array();
      $current_user_event_args = array(
        'post_type' => 'event_registrations',
        'post_status' => 'publish',
        'posts_per_page'=> -1,
        'meta_query'	=> array(
          array(
            'key'=> 'user',
            'value'=> $current_user->ID,
          )
        )
      );
      $current_user_event_query = new WP_Query($current_user_event_args);

      if($current_user_event_query->have_posts()) {
        while($current_user_event_query->have_posts()) {
          $current_user_event_query->the_post();
            $current_user_event_ids[] = get_field('event');
        }
      }

      if (!empty($current_user_event_ids)) {
        // Current Date
        $date_now = new DateTime(wp_date(DATE_RFC3339));
        $date_now = $date_now->setTimezone(new DateTimeZone('America/New_York'));
        $date_now = $date_now->format('Y-m-d'); // Format to only have date so that events are compared only with the current date and not current time
        $events_args = array(
          'post_type' => 'events',
          'post_status' => 'publish',
          'posts_per_page'=> -1,
          'post__in' => $current_user_event_ids,
          'meta_query' => array(
            array(
              'key'	=> 'date',
              'compare'	=> '>=',
              'value'	=> $date_now,
              'type' => 'DATETIME'
            )
          ),
          'order'	=> 'ASC',
          'orderby' => 'meta_value',
          'meta_key' => 'date',
          'meta_type'	=> 'DATE'
        );
        $events_query = new WP_Query($events_args);
      }
    ?>
    <?php if(isset($events_query) && $events_query->have_posts()) : ?>
      <div class="card-list card-list--3">
          <?php while($events_query->have_posts()) : $events_query->the_post(); ?>
          <?php include( locate_template( 'template-parts/modules/events/list.php', false, false ) ); ?>
          <?php endwhile; ?>
      </div>
    <?php else : ?>
    <div class="mb8">
      <div class="alert alert-info">
        <p>You do not have any scheduled events. Please <a href="/attend">Register</a> for events to populate your schedule.</p>
      </div>
    </div>
    <?php endif; wp_reset_postdata(); ?>
  </div>
</div>
<!-- End Previous Events -->
