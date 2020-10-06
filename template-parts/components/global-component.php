<?php $post = get_sub_field('component'); setup_postdata($post); ?>
  <?php get_template_part( 'template-parts/components/loop' ); ?>
<?php wp_reset_postdata(); ?>
