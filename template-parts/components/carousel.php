<!-- Begin Cards Carousel -->
<section class="section section--pattern-<?php the_sub_field('background_color'); ?>">
  <div class="card-carousel card-carousel--<?php the_sub_field('headline_type'); ?>-headline">
    <?php if (get_sub_field('headline_type') && get_sub_field('headline')) : ?>
    <div class="card-carousel__header">
      <div class="row row-site column">
        <h2 class="card-carousel__header-headline"><?php the_sub_field('headline'); ?></h2>
      </div>
    </div>
    <?php endif; ?>
    <div class="card-carousel__slider">
      <div class="row row-site column">
        <div class="card-carousel__arows">
          <button class="slick-prev slick-arrow" aria-label="Previous" type="button"><span class="icon-angle-left"></span></button>
          <button class="slick-next slick-arrow" aria-label="Next" type="button"><span class="icon-angle-right"></span></button>
        </div>
        <div class="js-card-carousel">
          <?php if (have_rows('slides')) : while (have_rows('slides')) : the_row(); ?>
            <?php
              $slide_target = "";
              $slide_class = "";
              if (get_sub_field('type') === "Video") {
                $slide_link = get_sub_field('video_link');
              }
              elseif (get_sub_field('type') === "Photo") {
                $slide_link = get_sub_field('photo')['url'];
              }
              else {
                $slide_link = get_sub_field('link')['url'];
                if (get_sub_field('link')['target']) {
                  $slide_target = 'target="_blank"';
                }
                if (get_sub_field('link')['class']) {
                  $slide_class = get_sub_field('link')['class'];
                }
              }
            ?>
            <!-- Begin Nav Carousel Slide -->
            <div class="card-carousel__slides">
              <div class="card-carousel__slides-block">
                <a class="image-card zoom-trigger <?php if (get_sub_field('type') === "Video") : ?>popup-video<?php elseif (get_sub_field('type') === "Photo") : ?>popup-image<?php endif; ?> <?php echo $slide_class; ?>" href="<?php echo $slide_link; ?>" <?php echo $slide_target; ?>>
                  <img class="zoom-img" src="<?php echo get_sub_field('thumbnail')['sizes']['carousel-thumb']; ?>" width="400" height="273" alt="<?php echo esc_attr(get_sub_field('thumbnail')['alt']); ?>" />
                  <?php if (get_sub_field('type') === "Video") : ?>
                  <div class="image-card__play">
                    <span class="icon-play"></span>
                  </div>
                  <?php endif; ?>
                </a>
              </div>
            </div>
            <!-- End Nav Carousel Slide -->
          <?php endwhile; endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Cards Carousel -->
