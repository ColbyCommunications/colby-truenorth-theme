<!-- Begin Post Body - Podcast -->
<div class="post-body__podcast mt<?php echo get_sub_field('settings')['top_spacing']; ?> mb<?php echo get_sub_field('settings')['bottom_spacing']; ?>">
  <div class="podcast">
    <div class="podcast__thumb">
      <img src="<?php echo get_sub_field('thumbnail')['url']; ?>" width="<?php echo get_sub_field('thumbnail')['width']; ?>" height="<?php echo get_sub_field('thumbnail')['height']; ?>" alt="<?php echo esc_attr(get_sub_field('thumbnail')['alt']); ?>" />
    </div>
    <div class="podcast__body">
      <div class="podcast__details">
        <h3 class="podcast__title"><?php the_sub_field('title'); ?></h3>
        <?php if (get_sub_field('audio')) : ?>
        <audio controls>
          <source src="<?php echo get_sub_field('audio')['url']; ?>" type="audio/mp3">
        </audio>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<!-- End Post Body - Podcast -->
