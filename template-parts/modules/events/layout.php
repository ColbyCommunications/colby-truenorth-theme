<div class="js-events-divider row row-site column" style="display:none;">
  <hr />
</div>
<script>
  $(function() {
    if ($(".card-list").length > 1) {
      $(".js-events-divider").show();
    }
  });
</script>
<?php
  // Current Date
  $date_now = new DateTime(wp_date(DATE_RFC3339), new DateTimeZone('-05:00'));
  $date_now = $date_now->format('Y-m-d'); // Format to only have date so that events are compared only with the current date and not current time
  $events_args = array(
    'post_type' => 'events',
    'post_status' => 'publish',
    'posts_per_page'=> -1,
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
?>
<section class="pt6 pb2">
  <div class="row row-site column">
    <?php if ($events_query->have_posts()) : ?>
    <div class="card-list card-list--3">
        <?php while($events_query->have_posts()) : $events_query->the_post(); ?>
          <!-- Begin Post Block -->
          <div class="card-list__block">
            <?php include( locate_template( 'template-parts/modules/events/card.php', false, false ) ); ?>
          </div>
          <!-- End Post Block -->
        <?php endwhile; ?>
    </div>
    <?php else : ?>
    <div class="mb8">
      <div class="alert alert-info">
        <p>No upcoming events, please check back later.</p>
      </div>
    </div>
    <?php endif; wp_reset_postdata(); ?>
  </div>
</section>
