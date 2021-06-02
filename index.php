<!-- Begin Header -->
<?php get_header(); ?>
<!-- End Header -->
<!-- Begin WP Page Loop -->
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<!-- Begin Hero -->
<?php get_template_part( 'template-parts/hero' ); ?>
<!-- End Hero -->
<!-- Begin Intro -->
<?php if ( is_front_page() ) { get_template_part( 'template-parts/components/intro' ); } ?>
<!-- End Intro -->
<!-- Begin Components -->
<?php get_template_part( 'template-parts/components/loop' ); ?>
<!-- End Components -->
<?php endwhile; endif; ?>
<!-- Begin Footer -->
<?php get_footer(); ?>
<!-- End Footer -->
