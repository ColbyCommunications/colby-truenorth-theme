<!-- Begin Content Block -->
<section class="section section--snowflake pt<?php the_sub_field('top_spacing'); ?> pb<?php the_sub_field('bottom_spacing'); ?>">
  <div class="row row-site column" data-reveal="fade">
    <?php if (get_sub_field('full_width')) : ?>
      <?php the_sub_field('content'); ?>
    <?php else : ?>
      <div class="row">
        <div class="xlarge-10 xxlarge-9 xlarge-centered column article">
          <?php the_sub_field('content'); ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<!-- End Content Block -->
