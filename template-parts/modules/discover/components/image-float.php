<!-- Begin Post Body - Image Float -->
<div class="post-body__image-float mt<?php echo get_sub_field('settings')['top_spacing']; ?> mb<?php echo get_sub_field('settings')['bottom_spacing']; ?>">
  <img class="align<?php the_sub_field('align_image'); ?>" src="<?php echo get_sub_field('image')['url']; ?>" width="<?php echo get_sub_field('image')['width']; ?>" height="<?php echo get_sub_field('image')['height']; ?>" alt="<?php echo esc_attr(get_sub_field('image')['alt']); ?>" />
  <?php the_sub_field('content'); ?>
</div>
<!-- End Post Body - Image Float -->
