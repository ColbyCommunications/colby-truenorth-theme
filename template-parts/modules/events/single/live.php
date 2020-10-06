<!-- Begin Components - Live Events -->
<?php if (have_rows('live_event_components')) : while (have_rows('live_event_components')) : the_row(); ?>
  <?php include( locate_template( 'template-parts/components/loop-conditionals.php', false, false ) ); ?>
<?php endwhile; endif; ?>
<!-- Begin Components - Live Events -->
