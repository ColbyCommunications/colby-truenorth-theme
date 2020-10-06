<!-- Begin Previous Events -->
<div class="section pt10 pb10">
  <div class="row row-site column">
    <?php
      $post_filters = array(
        'pagination' => urldecode(get_query_var('pag', '1'))
      );

      $post_filters_args = array();

      // Filter Arguments
      include( locate_template( 'template-parts/modules/events/filter-query-previous.php', false, false ) );

      // Query
      $post_query = new WP_Query( $post_args );
    ?>
    <?php if($post_query->have_posts()) : ?>
    <div id="scroll-anchor" class="card-list card-list--3 js-ajax-load" data-filter-args='<?php echo json_encode($post_filters_args); ?>' data-filter-query="template-parts/modules/events/filter-query-previous" data-filter-list="template-parts/modules/events/list">
      <?php while( $post_query->have_posts() ) : $post_query->the_post(); ?>
      <?php include( locate_template( 'template-parts/modules/events/list.php', false, false ) ); ?>
      <?php endwhile; ?>
    </div>
    <div class="js-pagination">
    <!-- Begin Pagination -->
    <?php $pagination_query = $post_query; include(locate_template('template-parts/modules/pagination.php', false, false)); ?>
    <!-- End Pagination -->
    </div>
    <?php else : ?>
    <div class="center">
      <h3>Check back soon for a recap of past events.</h3>
    </div>
    <?php endif; wp_reset_postdata(); ?>
  </div>
</div>
<!-- End Previous Events -->
