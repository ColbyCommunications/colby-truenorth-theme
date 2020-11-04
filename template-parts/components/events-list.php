<!--Begin Events List-->
<section class="section section--snowflake pt<?php the_sub_field('top_spacing'); ?> pb<?php the_sub_field('bottom_spacing'); ?>">
  <!-- Begin Heading Block -->
  <?php get_template_part( 'template-parts/components/clone/heading-block' ); ?>
  <!-- End Heading Block -->
  <div class="row row-site column">
    <div class="card-list card-list--3">
      <?php if (get_sub_field('show') === "Upcoming") : ?>
        <?php
          // Current Date
          $date_now = new DateTime(wp_date(DATE_RFC3339));
          $date_now = $date_now->setTimezone(new DateTimeZone('America/New_York'));
          $date_now = $date_now->format('Y-m-d'); // Format to only have date so that events are compared only with the current date and not current time
          $events_args = array(
            'post_type' => 'events',
            'post_status' => 'publish',
            'posts_per_page'=> 3,
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
        <?php if ($events_query->have_posts()) : while($events_query->have_posts()) : $events_query->the_post(); ?>
          <!-- Begin Post Block -->
          <div class="card-list__block">
            <?php include( locate_template( 'template-parts/modules/events/card.php', false, false ) ); ?>
          </div>
          <!-- End Post Block -->
        <?php endwhile; endif; wp_reset_postdata(); ?>
      <?php else : ?>
        <?php $events = get_sub_field('events'); foreach($events as $post): setup_postdata($post); ?>
          <!-- Begin Post Block -->
          <div class="card-list__block">
            <?php include( locate_template( 'template-parts/modules/events/card.php', false, false ) ); ?>
          </div>
          <!-- End Post Block -->
        <?php endforeach; wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
  </div>
</section>
<!--End Events List-->
