<!--Begin Discover List-->
<section class="section section--snowflake pt<?php the_sub_field('top_spacing'); ?> pb<?php the_sub_field('bottom_spacing'); ?>">
  <!-- Begin Heading Block -->
  <?php get_template_part( 'template-parts/components/clone/heading-block' ); ?>
  <!-- End Heading Block -->
  <div class="row row-site column">
    <div class="post-grid">
      <div class="post-grid__list post-grid__list--4">
        <?php if (get_sub_field('show') === "Most Recent") : ?>
          <?php
            $media_post_args = array(
              'post_type' => 'media',
              'post_status' => 'publish',
              'posts_per_page'=> 4,
              'orderby' => 'date',
              'order' => 'DESC'
            );
            $media_post_query = new WP_Query($media_post_args);
          ?>
          <?php if ($media_post_query->have_posts()) : while($media_post_query->have_posts()) : $media_post_query->the_post(); ?>
            <!-- Begin Post Block -->
            <div class="post-grid__block">
              <?php include( locate_template( 'template-parts/modules/discover/block.php', false, false ) ); ?>
            </div>
            <!-- End Post Block -->
          <?php endwhile; endif; wp_reset_postdata(); ?>
        <?php else : ?>
          <?php $media_post = get_sub_field('media_post'); foreach($media_post as $post): setup_postdata($post); ?>
            <!-- Begin Post Block -->
            <div class="post-grid__block">
              <?php include( locate_template( 'template-parts/modules/discover/block.php', false, false ) ); ?>
            </div>
            <!-- End Post Block -->
          <?php endforeach; wp_reset_postdata(); ?>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>
<!--End Discover List-->
