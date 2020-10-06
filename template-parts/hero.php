<?php
// Setup Page Headers for Taxonomy Pages
$id_term = "";
if (is_tax()) {
  $id_term = get_queried_object();
}

// Hero Fields
$hero_type = get_field('hero_type', $id_term);
$hero_carousel = get_field('hero_carousel', $id_term);
$hero_image = get_field('hero_image', $id_term);
$hero_headline = get_field('hero_headline', $id_term);
?>

<?php if ($hero_type === "Carousel") : ?>
<!--Begin Hero Carousel-->
<section class="hero">
  <?php if (have_rows('hero_carousel')) : while (have_rows('hero_carousel')) : the_row(); ?>
  <div class="hero__slides">
    <picture>
      <?php if (get_sub_field('mobile_image')) : ?>
      <source media="(max-width: 640px)" srcset="<?php echo get_sub_field('mobile_image')['url']; ?> 640w">
      <?php endif; ?>
      <?php if (get_sub_field('tablet_image')) : ?>
      <source media="(max-width: 1024px)" srcset="<?php echo get_sub_field('tablet_image')['url']; ?> 1024w">
      <?php endif; ?>
      <img src="<?php echo get_sub_field('desktop_image')['url']; ?>" width="1440" height="425" alt="<?php echo get_sub_field('desktop_image')['alt']; ?>">
    </picture>
  </div>
  <?php endwhile; endif; ?>
</section>
<!--End Hero Carousel-->
<?php elseif ($hero_type === "Small Hero") : ?>
<!--Begin Inner Hero-->
<section class="inner-hero">
  <div class="inner-hero__bg" style="background-image:url('<?php echo get_field('hero_image')['url']; ?>')"></div>
  <div class="inner-hero__body">
    <div class="row row-site column">
      <div class="inner-hero__caption">
        <?php if ($hero_headline) : ?>
        <h1 class="inner-hero__title"><?php echo $hero_headline; ?></h1>
        <?php elseif (get_the_title()) : ?>
        <h1 class="inner-hero__title"><?php echo the_title(); ?></h1>
        <?php else : ?>
        <h1 class="inner-hero__title"><?php echo get_bloginfo(); ?></h1>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<!--End Inner Hero-->
<?php elseif ($hero_type === "Page Title") : ?>
<!--Begin Page Title-->
<section class="page-title">
  <div class="page-title__align">
    <div class="row row-site column">
      <div class="page-title__heading">
        <?php if ($hero_headline) : ?>
        <h1 class="page-title__title"><?php echo $hero_headline; ?></h1>
        <?php elseif (get_the_title()) : ?>
        <h1 class="page-title__title"><?php echo the_title(); ?></h1>
        <?php else : ?>
        <h1 class="page-title__title"><?php echo get_bloginfo(); ?></h1>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<!--End Page Title-->
<?php endif; ?>
