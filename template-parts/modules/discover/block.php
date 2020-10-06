<a class="post-block zoom-trigger" href="<?php the_permalink(); ?>">
  <div class="post-block__image">
    <img class="zoom-img" src="<?php echo get_field('thumbnail')['sizes']['media-thumb']; ?>" width="298" height="214" alt="<?php echo esc_attr(get_field('thumbnail')['alt']); ?>" />
    <?php if (get_field('category')) : ?>
    <div class="post-block__image-overlay">
      <span><?php echo get_field('category')->name; ?></span>
    </div>
    <?php endif; ?>
  </div>
  <div class="post-block__body">
    <h3 class="post-block__title"><?php the_title(); ?></h3>
  </div>
</a>
