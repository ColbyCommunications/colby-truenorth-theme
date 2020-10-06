<!-- Begin Header -->
<?php get_header(); ?>
<!-- End Header -->
<!-- Begin WP Page Loop -->
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<!-- Begin Page w/Sidebar -->
<div class="section pt10 pb8">
  <div class="row row-site column">
    <div class="page-body">
      <div class="page-body__left">
        <div class="post-body">
          <h1><?php the_title(); ?></h1>
          <?php if (have_rows('discover_components')) : while (have_rows('discover_components')) : the_row(); ?>
            <?php if (get_row_layout() == 'content_block') : ?>
              <?php get_template_part( 'template-parts/modules/discover/components/content-block' ); ?>
            <?php elseif (get_row_layout() == 'video_embed') : ?>
              <?php get_template_part( 'template-parts/modules/discover/components/video-embed' ); ?>
            <?php elseif (get_row_layout() == 'image_float') : ?>
              <?php get_template_part( 'template-parts/modules/discover/components/image-float' ); ?>
            <?php elseif (get_row_layout() == 'testimonial') : ?>
              <?php get_template_part( 'template-parts/modules/discover/components/testimonial' ); ?>
            <?php elseif (get_row_layout() == 'image') : ?>
              <?php get_template_part( 'template-parts/modules/discover/components/image' ); ?>
            <?php elseif (get_row_layout() == 'cta_buttons') : ?>
              <?php get_template_part( 'template-parts/modules/discover/components/cta-buttons' ); ?>
            <?php elseif (get_row_layout() == 'gallery') : ?>
              <?php get_template_part( 'template-parts/modules/discover/components/gallery' ); ?>
            <?php elseif (get_row_layout() == 'podcast') : ?>
              <?php get_template_part( 'template-parts/modules/discover/components/podcast' ); ?>
            <?php endif; ?>
          <?php endwhile; endif; ?>
        </div>
      </div>
      <aside class="page-body__right">
        <!-- Begin Sidebar Module -->
        <div class="sidebar-module">
          <div class="sidebar-module__inner">
            <div class="sidebar-module__body">
              <div class="sidebar-module__heading">
                <h2 class="sidebar-module__heading-brush">Related Content</h2>
              </div>
              <div class="sidebar-module__post">
                <?php $related_content = get_field('related_content'); if ($related_content) :  ?>

                  <?php foreach( $related_content as $post): setup_postdata($post); ?>
                    <!-- Begin Post Block -->
                    <?php include( locate_template( 'template-parts/modules/discover/block.php', false, false ) ); ?>
                    <!-- End Post Block -->
                  <?php endforeach; wp_reset_postdata(); ?>

                <?php else : ?>

                  <?php
                    $terms = get_the_terms(get_the_id(), 'media_categories');
                    $terms_arr = array();
                    foreach ($terms as $term) {
                      $terms_arr[] = $term->term_id;
                    }
                    $related_args = array(
                      'post_type' => 'media',
                      'post_status' => 'publish',
                      'posts_per_page'=> 3,
                      'post__not_in'=> array(get_the_id()),
                      'tax_query' => array(
                        array(
                          'taxonomy' => 'media_categories',
                          'field'    => 'term_id',
                          'terms'    => $terms_arr,
                        ),
                      ),
                      'orderby' => 'date',
                      'order' => 'DESC'
                    );
                    $related_query = new WP_Query($related_args);
                    if (!$related_query->have_posts()) {
                      $related_args = array(
                        'post_type' => 'media',
                        'post_status' => 'publish',
                        'posts_per_page'=> 3,
                        'post__not_in'=> array(get_the_id()),
                        'orderby' => 'date',
                        'order' => 'DESC'
                      );
                      $related_query = new WP_Query($related_args);
                    }
                  ?>
                  <?php if ($related_query->have_posts()) : while($related_query->have_posts()) : $related_query->the_post(); ?>
                    <!-- Begin Post Block -->
                    <?php include( locate_template( 'template-parts/modules/discover/block.php', false, false ) ); ?>
                    <!-- End Post Block -->
                  <?php endwhile; endif; wp_reset_postdata(); ?>

                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <!-- End Sidebar Module -->
      </aside>
    </div>
  </div>
</div>
<!-- End Page w/Sidebar -->
<!-- Begin Components -->
<?php get_template_part( 'template-parts/components/loop' ); ?>
<!-- End Components -->
<?php endwhile; endif; ?>
<!-- Begin Footer -->
<?php get_footer(); ?>
<!-- End Footer -->
