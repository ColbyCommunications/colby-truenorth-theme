<?php if (get_sub_field('hb_type') === "Default") : ?>
  <?php if (get_sub_field('hb_label') || get_sub_field('hb_headline') || get_sub_field('hb_subheadline') || get_sub_field('hb_overview') || get_sub_field('hb_primary_button')) : ?>
  <div class="heading-block mb<?php the_sub_field('hb_bottom_spacing'); ?>">
    <div class="row row-site column">
      <div class="row">
        <div class="xlarge-10 xxlarge-9 xlarge-centered column">
          <?php if (get_sub_field('hb_label')) : ?>
          <h2 class="label label" data-reveal="fade-up-xsmall"><?php the_sub_field('hb_label'); ?></h2>
          <?php endif; ?>
          <?php if (get_sub_field('hb_headline')) : ?>
          <h3 class="h1" data-reveal="fade-up-xsmall"><?php the_sub_field('hb_headline'); ?></h3>
          <?php endif; ?>
          <?php if (get_sub_field('hb_subheadline')) : ?>
          <h4 class="h3 subheader" data-reveal="fade-up-xsmall"><?php the_sub_field('hb_subheadline'); ?></h4>
          <?php endif; ?>
          <?php if (get_sub_field('hb_overview')) : ?>
          <div class="heading-block__overview" data-reveal="fade-up-xsmall">
            <?php the_sub_field('hb_overview'); ?>
          </div>
          <?php endif; ?>
          <?php if (get_sub_field('hb_cta_title') || get_sub_field('hb_primary_button') || get_sub_field('hb_secondary_button')) : ?>
          <div class="heading-block__cta" data-reveal="fade-up-xsmall">
            <?php if (get_sub_field('hb_cta_title')) : ?>
            <h5 class="h4 mb4"><?php the_sub_field('hb_cta_title'); ?></h5>
            <?php endif; ?>
            <?php if (get_sub_field('hb_primary_button')) : ?>
            <a class="button <?php echo get_sub_field('hb_primary_button')['class']; ?>" href="<?php echo get_sub_field('hb_primary_button')['url']; ?>" <?php if (get_sub_field('hb_primary_button')['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('hb_primary_button')['title']; ?></a>
            <?php endif; ?>
            <?php if (get_sub_field('hb_secondary_button')) : ?>
            <a class="button secondary <?php echo get_sub_field('hb_secondary_button')['class']; ?>" href="<?php echo get_sub_field('hb_secondary_button')['url']; ?>" <?php if (get_sub_field('hb_secondary_button')['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('hb_secondary_button')['title']; ?></a>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
<?php else : ?>
  <div class="heading <?php if (get_sub_field('hb_label')) : ?>heading--label<?php endif; ?> heading--<?php the_sub_field('brush_option'); ?>">
    <div class="row row-site column">
      <h2 class="heading__brush"><?php if (get_sub_field('hb_link')) : ?><a href="<?php echo get_sub_field('hb_link')['url']; ?>" <?php if (get_sub_field('hb_link')['target']) : ?>target="_blank"<?php endif; ?>><?php the_sub_field('hb_headline'); ?></a><?php else : ?><?php the_sub_field('hb_headline'); ?><?php endif; ?></h2>
      <?php if (get_sub_field('hb_label')) : ?>
      <span class="heading__label"><?php the_sub_field('hb_label'); ?></span>
      <?php endif; ?>
      <?php if (get_sub_field('hb_overview')) : ?>
        <div class="row mt4">
          <div class="xlarge-10 xxlarge-9 xlarge-centered column">
            <div class="heading__overview" data-reveal="fade-up-xsmall">
              <?php the_sub_field('hb_overview'); ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
