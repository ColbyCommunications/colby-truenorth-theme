<!-- Begin Header -->
<?php get_header(); ?>
<!-- End Header -->
<!-- Begin WP Page Loop -->
<?php if (have_posts()): while (have_posts()) : the_post(); ?>

  <?php
    $dev_preview = isset($_GET['event-status']) ? $_GET['event-status'] : '';
    $event_status = ad_event_status(get_field('show_event_start_date_time'), get_field('show_event_end_date_time'), get_field('time_zone')['value']);
    $register_view = (get_query_var('register') === 'true') ? true : false;

    if (!empty($dev_preview)) {
      if ($dev_preview === "Pre-Event") {
        $event_status = "Pre";
      }
      elseif ($dev_preview === "Live Event") {
        $event_status = "Live";
      }
      elseif ($dev_preview === "Post Event") {
        $event_status = "Post";
      }
    }
  ?>
  <?php if ($event_status === "Pre") : ?>
    <?php if ($register_view) : ?>
      <?php include( locate_template( 'template-parts/modules/events/single/register.php', false, false ) ); ?>
    <?php else : ?>
      <?php include( locate_template( 'template-parts/modules/events/single/pre.php', false, false ) ); ?>
    <?php endif; ?>
  <?php elseif ($event_status === "Live") : ?>
    <?php if ($register_view) : ?>
      <?php include( locate_template( 'template-parts/modules/events/single/register.php', false, false ) ); ?>
    <?php else : ?>
      <?php include( locate_template( 'template-parts/modules/events/single/live.php', false, false ) ); ?>
    <?php endif; ?>
  <?php elseif ($event_status === "Post") : ?>
    <?php include( locate_template( 'template-parts/modules/events/single/post.php', false, false ) ); ?>
  <?php endif; ?>

<?php endwhile; endif; ?>
<!-- Begin Footer -->
<?php get_footer(); ?>
<!-- End Footer -->
