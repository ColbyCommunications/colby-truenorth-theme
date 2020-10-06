<!-- Begin Post Body - Gallery -->
<?php
  $photos = get_sub_field('photos');
  if ($photos) :
?>
<div class="post-body__gallery mt<?php echo get_sub_field('settings')['top_spacing']; ?> mb<?php echo get_sub_field('settings')['bottom_spacing']; ?>">
  <div class="gallery-carousel js-gallery-carousel">
    <?php foreach($photos as $photo): ?>
    <div class="gallery-carousel__slide">
      <img src="<?php echo esc_url($photo['url']); ?>" width="<?php echo $photo['width']; ?>" height="<?php echo $photo['height']; ?>" alt="<?php echo esc_attr($photo['alt']); ?>" />
    </div>
    <?php endforeach; ?>
  </div>
</div>
<!-- End Post Body - Gallery -->
<?php endif; ?>
