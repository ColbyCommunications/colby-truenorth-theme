<!-- Begin Embedded Video -->
<section class="section section--snowflake pt<?php the_sub_field('top_spacing'); ?> pb<?php the_sub_field('bottom_spacing'); ?>">
  <!-- Begin Heading Block -->
  <?php get_template_part( 'template-parts/components/clone/heading-block' ); ?>
  <!-- End Heading Block -->
  <div class="row row-site column">
    <div class="featured-video">
      <div class="embed-container">
        <?php the_sub_field('embed_code'); ?>
      </div>
    </div>
  </div>
</section>
<!-- End Embedded Video -->
