<!-- Begin Post Body - Blockquote -->
<div class="post-body__blockquote mt<?php echo get_sub_field('settings')['top_spacing']; ?> mb<?php echo get_sub_field('settings')['bottom_spacing']; ?>">
  <blockquote class="center">
    <div class="quote">
      <p><?php the_sub_field('quote'); ?></p>
    </div>
    <?php if (get_sub_field('source_name') || get_sub_field('source_title')) : ?>
    <p class="cite"><?php if (get_sub_field('source_name')) : ?>— <?php the_sub_field('source_name'); ?><?php endif; ?><?php if (get_sub_field('source_title')) : ?> <span><?php the_sub_field('source_title'); ?></span><?php endif; ?></p>
    <?php endif; ?>
  </blockquote>
</div>
<!-- End Post Body - Blockquote -->
