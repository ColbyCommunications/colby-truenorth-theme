<!-- Begin Post Grid -->
<div class="section pt10 pb5">
  <div class="row row-site column">
    <?php
      $post_filters = array(
        'category' => urldecode(get_query_var('category')),
        'pagination' => urldecode(get_query_var('pag', '1'))
      );

      $post_filters_args = array();

      // Filter Arguments
      include( locate_template( 'template-parts/modules/discover/filter-query.php', false, false ) );

      // Query
      $post_query = new WP_Query( $post_args );
    ?>
    <div class="post-grid">
      <div class="post-grid__filter">
        <form class="js-post-filter">
          <div class="post-grid__filter-row">
            <div class="post-grid__filter-select">
              <select class="js-filter-select js-custom-select" name="category" aria-label="Select Category">
                <option value="">Select Category</option>
                <?php
                // Loop over each filter option
                $terms = get_terms(array(
                    'taxonomy' => 'media_categories',
                    'hide_empty' => true,
                ));
                ?>
                <?php foreach ($terms as $term) : ?>
                <option value="<?php echo $term->slug; ?>" <?php selected($post_filters['category'], $term->slug, true); ?>><?php echo $term->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="post-grid__filter-row">
            <button type="button" class="button post-grid__filter-clear js-filter-clear">Reset</button>
          </div>
        </form>
      </div>
      <div id="scroll-anchor" class="post-grid__list post-grid__list--4 js-ajax-load" data-filter-args='<?php echo json_encode($post_filters_args); ?>' data-filter-query="template-parts/modules/discover/filter-query" data-filter-list="template-parts/modules/discover/list">
        <?php if( $post_query->have_posts() ) : ?>
          <?php while( $post_query->have_posts() ) : $post_query->the_post(); ?>
          <?php include( locate_template( 'template-parts/modules/discover/list.php', false, false ) ); ?>
          <?php endwhile; ?>
        <?php else : ?>
        <div class="alert-container">
          <div class="alert alert-info"><p>No results found. Please try your search again.</div>
        </div>
        <?php endif; wp_reset_postdata(); ?>
      </div>
      <div class="js-pagination">
      <!-- Begin Pagination -->
      <?php $pagination_query = $post_query; include(locate_template('template-parts/modules/pagination.php', false, false)); ?>
      <!-- End Pagination -->
      </div>
    </div>
  </div>
</div>
<!-- End Post Grid -->
<!-- Begin Past Events -->
<?php
  // Current Date
  $date_now = new DateTime(wp_date(DATE_RFC3339));
  $date_now = $date_now->setTimezone(new DateTimeZone('America/New_York'));
  $date_now = $date_now->format('Y-m-d'); // Format to only have date so that events are compared only with the current date and not current time
  $events_args = array(
    'post_type' => 'events',
    'post_status' => 'publish',
    'posts_per_page'=> 3,
    'meta_query' => array(
      array(
        'key'	=> 'date',
        'compare'	=> '<',
        'value'	=> $date_now,
        'type' => 'DATETIME'
      )
    ),
    'order'	=> 'DESC',
    'orderby' => 'meta_value',
    'meta_key' => 'date',
    'meta_type'	=> 'DATE'
  );
  $events_query = new WP_Query($events_args);
?>
<?php if ($events_query->have_posts()) : ?>
<div class="section pt5 pb10">
  <div class="heading heading--b">
    <div class="row row-site column">
      <h2 class="heading__brush"><a href="/previous-events">Previous Events</a></h2>
    </div>
  </div>
  <div class="row row-site column">
    <div class="card-list card-list--3">
        <?php while($events_query->have_posts()) : $events_query->the_post(); ?>
          <!-- Begin Post Block -->
          <div class="card-list__block">
            <?php $prev_event = true; include( locate_template( 'template-parts/modules/events/card.php', false, false ) ); ?>
          </div>
          <!-- End Post Block -->
        <?php endwhile; ?>
    </div>
  </div>
</div>
<?php endif; wp_reset_postdata(); ?>
<!-- End Past Events -->
