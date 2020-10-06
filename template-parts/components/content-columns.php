<section class="section section--snowflake pt<?php the_sub_field('top_spacing'); ?> pb<?php the_sub_field('bottom_spacing'); ?>">
  <!-- Begin Heading Block -->
  <?php get_template_part( 'template-parts/components/clone/heading-block' ); ?>
  <!-- End Heading Block -->
  <div class="row row-site column">
    <div class="row text-grid-col<?php if (get_sub_field('columns') === "Two") : ?> medium-up-2 text-grid-col--2<?php else : ?> large-up-3 text-grid-col--3<?php endif; ?>">
      <?php if (have_rows('column')) : while (have_rows('column')) : the_row(); ?>
        <div class="columns">
          <div class="text-grid-col__block" data-reveal="fade-up-xsmall">
            <?php if (get_sub_field('headline')) : ?>
            <h3 class="text-grid-col__headline"><?php the_sub_field('headline'); ?></h3>
            <?php endif; ?>
            <?php if (get_sub_field('subheadline')) : ?>
            <h4 class="text-grid-col__subheadline subheader"><?php the_sub_field('subheadline'); ?></h4>
            <?php endif; ?>
            <div class="text-grid-col__overview">
              <?php the_sub_field('overview'); ?>
            </div>
            <?php if (get_sub_field('button')) : ?>
            <div class="text-grid-col__action">
              <a class="button <?php echo get_sub_field('button')['class']; ?>" href="<?php echo get_sub_field('button')['url']; ?>" <?php if (get_sub_field('button')['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('button')['title']; ?></a>
            </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; endif; ?>
    </div>
  </div>
</section>
