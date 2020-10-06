<!-- Begin Components - Post Events -->
<?php if (have_rows('post_event_components')) : while (have_rows('post_event_components')) : the_row(); ?>
  <?php include( locate_template( 'template-parts/components/loop-conditionals.php', false, false ) ); ?>
<?php endwhile; endif; ?>
<!-- Begin Components - Post Events -->
