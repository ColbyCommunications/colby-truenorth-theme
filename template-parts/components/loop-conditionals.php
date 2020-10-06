<?php if (get_row_layout() == 'heading_block') : ?>
  <?php get_template_part( 'template-parts/components/heading-block' ); ?>
<?php elseif (get_row_layout() == 'content_block') : ?>
  <?php get_template_part( 'template-parts/components/content-block' ); ?>
<?php elseif (get_row_layout() == 'content_columns') : ?>
  <?php get_template_part( 'template-parts/components/content-columns' ); ?>
<?php elseif (get_row_layout() == 'embedded_video') : ?>
  <?php get_template_part( 'template-parts/components/embedded-video' ); ?>
<?php elseif (get_row_layout() == 'discover_list') : ?>
  <?php get_template_part( 'template-parts/components/discover-list' ); ?>
<?php elseif (get_row_layout() == 'events_list') : ?>
  <?php get_template_part( 'template-parts/components/events-list' ); ?>
<?php elseif (get_row_layout() == 'cta_banner') : ?>
  <?php get_template_part( 'template-parts/components/cta-banner' ); ?>
<?php elseif (get_row_layout() == 'northward_values') : ?>
  <?php get_template_part( 'template-parts/components/northward-values' ); ?>
<?php elseif (get_row_layout() == 'social_media_feed') : ?>
  <?php get_template_part( 'template-parts/components/social-media-feed' ); ?>
<?php elseif (get_row_layout() == 'stats_panel') : ?>
  <?php get_template_part( 'template-parts/components/stats-panel' ); ?>
<?php elseif (get_row_layout() == 'alternating_feature') : ?>
  <?php get_template_part( 'template-parts/components/alternating-feature' ); ?>
<?php elseif (get_row_layout() == 'stats_panel') : ?>
  <?php get_template_part( 'template-parts/components/stats-panel' ); ?>
<?php elseif (get_row_layout() == 'carousel') : ?>
  <?php get_template_part( 'template-parts/components/carousel' ); ?>
<?php elseif (get_row_layout() == 'global_component') : ?>
  <?php get_template_part( 'template-parts/components/global-component' ); ?>
<?php elseif (get_row_layout() == 'custom') : ?>
  <?php get_template_part( 'template-parts/components/custom' ); ?>
<?php endif; ?>
