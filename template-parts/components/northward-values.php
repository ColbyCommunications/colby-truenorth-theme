<!--Begin The Northward Values-->
<section class="section section--snowflake section--topo-pattern pt<?php the_sub_field('top_spacing'); ?> pb<?php the_sub_field('bottom_spacing'); ?>">
  <div class="row row-site column">
    <div class="northward-values">
      <div class="northward-values__col northward-values__col--logo">
        <img src="<?php echo get_sub_field('logo')['url']; ?>" width="<?php echo get_sub_field('logo')['width']; ?>" height="<?php echo get_sub_field('logo')['height']; ?>" alt="<?php echo esc_attr(get_sub_field('logo')['alt']); ?>" />
      </div>
      <div class="northward-values__col northward-values__col--flower">
        <div class="flower">
          <?php $petal_count = 0; if (have_rows('values')) : while (have_rows('values')) : the_row(); ?>
            <div class="flower__petal flower__petal--<?php echo $petal_count; ?>">
              <div><?php the_sub_field('title'); ?></div>
            </div>
          <?php $petal_count++; endwhile; endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!--End The Northward Values-->
