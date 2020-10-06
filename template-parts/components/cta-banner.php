<!--Begin CTA Banner-->
<section class="section section--brush">
  <?php if (get_sub_field('layout') === "Two Columns") : ?>
  <div class="row row-site column pt<?php the_sub_field('top_spacing'); ?> pb<?php the_sub_field('bottom_spacing'); ?>">
    <div class="row medium-up-2 text-grid-col text-grid-col--2">
      <div class="columns">
        <div class="text-grid-col__block">
          <?php if (get_sub_field('two_column_block')['left_headline']) : ?>
          <h2><?php echo get_sub_field('two_column_block')['left_headline']; ?></h2>
          <?php endif; ?>
          <?php if (get_sub_field('two_column_block')['left_overview']) : ?>
          <p><?php echo get_sub_field('two_column_block')['left_overview']; ?></p>
          <?php endif; ?>
          <?php if (get_sub_field('two_column_block')['left_button']) : ?>
          <a class="btn-brush-scale <?php echo get_sub_field('two_column_block')['left_button']['class']; ?>" href="<?php echo get_sub_field('two_column_block')['left_button']['url']; ?>" <?php if (get_sub_field('two_column_block')['left_button']['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('two_column_block')['left_button']['title']; ?></a>
          <?php endif; ?>
        </div>
      </div>
      <div class="columns">
        <div class="text-grid-col__block">
          <?php if (get_sub_field('two_column_block')['right_headline']) : ?>
          <h2><?php echo get_sub_field('two_column_block')['right_headline']; ?></h2>
          <?php endif; ?>
          <?php if (get_sub_field('two_column_block')['right_overview']) : ?>
          <p><?php echo get_sub_field('two_column_block')['right_overview']; ?></p>
          <?php endif; ?>
          <?php if (get_sub_field('two_column_block')['right_button']) : ?>
          <a class="btn-brush-scale <?php echo get_sub_field('two_column_block')['right_button']['class']; ?>" href="<?php echo get_sub_field('two_column_block')['right_button']['url']; ?>" <?php if (get_sub_field('two_column_block')['right_button']['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('two_column_block')['right_button']['title']; ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php else : ?>
    <div class="heading-block mb0">
      <div class="row row-site column">
        <div class="row">
          <div class="xlarge-10 xxlarge-9 xlarge-centered column">
            <?php if (get_sub_field('heading_block')['hb_label']) : ?>
            <h2 class="label" data-reveal="fade-up-xsmall"><?php echo get_sub_field('heading_block')['hb_label']; ?></h2>
            <?php endif; ?>
            <?php if (get_sub_field('heading_block')['hb_headline']) : ?>
            <h3 class="h1" data-reveal="fade-up-xsmall"><?php echo get_sub_field('heading_block')['hb_headline']; ?></h3>
            <?php endif; ?>
            <?php if (get_sub_field('heading_block')['hb_subheadline']) : ?>
            <h4 class="h3 subheader" data-reveal="fade-up-xsmall"><?php echo get_sub_field('heading_block')['hb_subheadline']; ?></h4>
            <?php endif; ?>
            <?php if (get_sub_field('heading_block')['hb_overview']) : ?>
            <div class="heading-block__overview" data-reveal="fade-up-xsmall">
              <?php echo get_sub_field('heading_block')['hb_overview']; ?>
            </div>
            <?php endif; ?>
            <?php if (get_sub_field('heading_block')['hb_cta_title'] || get_sub_field('heading_block')['hb_primary_button'] || get_sub_field('heading_block')['hb_secondary_button']) : ?>
            <div class="heading-block__cta" data-reveal="fade-up-xsmall">
              <?php if (get_sub_field('heading_block')['hb_cta_title']) : ?>
              <h5 class="h4 mb4"><?php echo get_sub_field('heading_block')['hb_cta_title']; ?></h5>
              <?php endif; ?>
              <?php if (get_sub_field('heading_block')['hb_primary_button']) : ?>
              <a class="button <?php echo get_sub_field('heading_block')['hb_primary_button']['class']; ?>" href="<?php echo get_sub_field('heading_block')['hb_primary_button']['url']; ?>" <?php if (get_sub_field('heading_block')['hb_primary_button']['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('heading_block')['hb_primary_button']['title']; ?></a>
              <?php endif; ?>
              <?php if (get_sub_field('heading_block')['hb_secondary_button']) : ?>
              <a class="button secondary <?php echo get_sub_field('heading_block')['hb_secondary_button']['class']; ?>" href="<?php echo get_sub_field('heading_block')['hb_secondary_button']['url']; ?>" <?php if (get_sub_field('heading_block')['hb_secondary_button']['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('heading_block')['hb_secondary_button']['title']; ?></a>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</section>
<!--End CTA Banner-->
