<?php
$post_args = array(
  'post_type' => 'media',
  'post_status' => 'publish',
  'posts_per_page'=> 16,
  'orderby' => 'menu_order',
  'order' => 'ASC',
  'paged' => $post_filters['pagination']
);

// Taxonomy Filter
if (!empty($post_filters['category'])) {
  unset($post_args['post__not_in']);
  $post_args['tax_query'] = array(
    array(
      'taxonomy' => 'media_categories',
      'terms'    => $post_filters['category'],
      'field'    => 'slug'
    )
  );
}
