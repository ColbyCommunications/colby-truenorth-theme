<!-- Begin Stats Panel -->
<section class="section section--snowflake pt<?php the_sub_field('top_spacing'); ?> pb<?php the_sub_field('bottom_spacing'); ?>">
  <!-- Begin Heading Block -->
  <?php get_template_part( 'template-parts/components/clone/heading-block' ); ?>
  <!-- End Heading Block -->
  <div class="row row-site column">
    <div class="stats-panel">
      <?php if (have_rows('stats')) : while (have_rows('stats')) : the_row(); ?>
        <div class="stats-panel__col">
          <div class="stats stats--<?php the_sub_field('font_color'); ?>">
            <h3 class="stats__headline">
              <?php if (get_sub_field('line_1')['stat']) : ?>
              <span class="stats__<?php echo get_sub_field('line_1')['font_type']; ?>"><?php echo get_sub_field('line_1')['stat']; ?></span>
              <?php endif; ?>
              <?php if (get_sub_field('line_2')['stat']) : ?>
              <span class="stats__<?php echo get_sub_field('line_2')['font_type']; ?>"><?php echo get_sub_field('line_2')['stat']; ?></span>
              <?php endif; ?>
              <?php if (get_sub_field('line_3')['stat']) : ?>
              <span class="stats__<?php echo get_sub_field('line_3')['font_type']; ?>"><?php echo get_sub_field('line_3')['stat']; ?></span>
              <?php endif; ?>
            </h3>
          </div>
        </div>
      <?php endwhile; endif; ?>
    </div>
  </div>
</section>
<!-- End Stats Panel -->
