<!-- Begin Post Body - CTA -->
<div class="post-body__cta mt<?php echo get_sub_field('settings')['top_spacing']; ?> mb<?php echo get_sub_field('settings')['bottom_spacing']; ?>">
  <?php if (get_sub_field('primary_button')) : ?>
  <a class="button <?php echo get_sub_field('primary_button')['class']; ?>" href="<?php echo get_sub_field('primary_button')['url']; ?>" <?php if (get_sub_field('primary_button')['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('primary_button')['title']; ?></a>
  <?php endif; ?>
  <?php if (get_sub_field('secondary_button')) : ?>
  <a class="button secondary <?php echo get_sub_field('secondary_button')['class']; ?>" href="<?php echo get_sub_field('secondary_button')['url']; ?>" <?php if (get_sub_field('secondary_button')['target']) : ?>target="_blank"<?php endif; ?>><?php echo get_sub_field('secondary_button')['title']; ?></a>
  <?php endif; ?>
</div>
<!-- End Post Body - CTA -->
