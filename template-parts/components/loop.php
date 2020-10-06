<?php if (have_rows('components')) : while (have_rows('components')) : the_row(); ?>
  <?php include( locate_template( 'template-parts/components/loop-conditionals.php', false, false ) ); ?>
<?php endwhile; endif; ?>
