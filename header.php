<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta name="theme-color" content="<?php the_field('brand_primary_color', 'option'); ?>">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0" />
<?php wp_head(); ?>
</head>

<body <?php custom_body_class(); ?>>
  <div class="root">
    <!-- Begin ADA Skip to Main Content -->
    <div class="ada-banner">
      <a class="skip-main" href="#main">Skip to main content</a>
    </div>
    <!-- End ADA Skip to Main Content -->
    <!--Begin Header-->
    <header class="header" role="banner">
      <div class="header__container">
        <div class="header__inner">
          <!-- Begin Logo -->
          <div class="logo">
            <a class="logo__colby" href="https://www.colby.edu/" target="_blank"></a>
            <a class="logo__dare" href="https://darenorthward.colby.edu/" target="_blank"></a>
            <img alt="<?php echo get_bloginfo(); ?> Logo" src="/wp-content/uploads/colby-dare-northward-logo.png" width="200" height="60">
          </div>
          <!-- End Logo -->
          <!-- Begin Drawer -->
          <div class="drawer">
            <div class="drawer__inner">
              <!-- Begin Main Menu -->
              <nav class="menu" aria-label="Main Menu" role="navigation">
                <?php $ad_menu = ad_tree_menu( '2' ); ?>
                <ul>
                <?php foreach ($ad_menu as &$primary_menu_item) : ?>
                  <li<?php echo ad_menu_classes($primary_menu_item); ?>><a <?php echo ad_menu_attributes($primary_menu_item); ?> href="<?php echo $primary_menu_item->url ?>"><?php echo $primary_menu_item->title; ?></a>
                  <?php if ( !empty($primary_menu_item->wpse_children) ) : ?>
                    <ul>
                      <?php foreach ($primary_menu_item->wpse_children as &$secondary_menu_item) : ?>
                        <li<?php echo ad_menu_classes($secondary_menu_item); ?>><a <?php echo ad_menu_attributes($secondary_menu_item); ?> href="<?php echo $secondary_menu_item->url ?>"><?php echo $secondary_menu_item->title; ?></a>
                        <?php if ( !empty($secondary_menu_item->wpse_children) ) : ?>
                          <ul>
                            <?php foreach ($secondary_menu_item->wpse_children as &$tertiary_menu_item) : ?>
                              <li<?php echo ad_menu_classes($tertiary_menu_item); ?>><a <?php echo ad_menu_attributes($tertiary_menu_item); ?> href="<?php echo $tertiary_menu_item->url ?>"><?php echo $tertiary_menu_item->title; ?></a></li>
                            <?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                  </li>
                <?php endforeach; ?>
                <?php if (is_user_logged_in()) : ?>
                <li><a href="/my-schedule">My Schedule</a>
                  <ul>
                    <li><a class="js-logout" href="#" data-redirect="" data-security="<?php echo wp_create_nonce('ajax-logout-nonce'); ?>">Logout</a></li>
                  </ul>
                </li>
                <?php else : ?>
                <li><a href="/login">Login</a></li>
                <?php endif; ?>
                </ul>
              </nav>
              <!-- End Main Menu -->
            </div>
          </div>
          <!-- End Drawer -->
        </div>
      </div>
      <!-- Begin Drawer Toggle -->
      <button class="drawer-toggle reset" aria-label="Mobile Navigation"><span></span></button>
      <!-- End Drawer Toggle -->
    </header>
    <!--End Header-->
    <!--Begin Page Body-->
    <div class="wrapper">
      <!--Begin Main Body-->
      <main id="main" class="main" role="main" tabindex="-1">
