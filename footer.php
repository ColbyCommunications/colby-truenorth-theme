      </main>
      <!--End Main Body-->
      <!--Begin Footer -->
      <footer class="footer" role="contentinfo">
        <div class="row row-site column">
          <div class="footer__row pt4 pb4">
            <div class="footer__left">
              <a class="footer__logo" href="http://www.colby.edu/" target="_blank"><img alt="<?php the_field('name', 'option'); ?> Logo" src="/wp-content/uploads/colby-college-wordmark-logo.png" width="130" height="64" /></a>
            </div>
            <div class="footer__middle">
              <div class="footer__cta">
                <?php $ad_menu = ad_tree_menu( '3' ); if (isset($ad_menu)) : foreach ($ad_menu as &$primary_menu_item) : ?>
                  <a class="btn-brush-scale" <?php echo ad_menu_attributes($primary_menu_item); ?> href="<?php echo $primary_menu_item->url ?>"><?php echo $primary_menu_item->title; ?></a>
                <?php endforeach; endif; ?>
              </div>
              <div class="footer__info">
                <ul>
                  <li>&copy; <?php echo date('Y'); ?> <?php the_field('name', 'option'); ?>. All Rights Reserved.</li>
                  <li><?php if (get_field('address', 'option')) : ?><span><?php the_field('address', 'option'); ?></span> <?php endif; ?><?php if (get_field('city', 'option')) : ?><span><?php the_field('city', 'option'); ?>, <?php endif; ?><?php if (get_field('state', 'option')) : ?><?php the_field('state', 'option'); ?> <?php endif; ?><?php if (get_field('zip_code', 'option')) : ?><?php the_field('zip_code', 'option'); ?><?php endif; ?></span><?php if (get_field('phone_number', 'option')) : ?> <span><a href="tel:<?php echo ad_sanitize_phone(get_field('phone_number', 'option')); ?>"><?php the_field('phone_number', 'option'); ?></a></span><?php endif; ?><?php if (get_field('privacy_policy_link', 'option')) : ?> <span><a href="<?php the_field('privacy_policy_link', 'option'); ?>" target="_blank">Privacy Policy</a></span><?php endif; ?></li>
                </ul>
              </div>
            </div>
            <div class="footer__social">
              <?php $ad_menu = ad_tree_menu('4'); if (isset($ad_menu)) : ?>
              <ul>
                <?php foreach ($ad_menu as &$primary_menu_item) : $class_names = join(' ', $primary_menu_item->classes); ?>
                <li><a <?php echo ad_menu_attributes($primary_menu_item); ?> href="<?php echo $primary_menu_item->url ?>"><span class="social-links__icon <?php echo $class_names; ?>"></span><span class="social-links__label"><?php echo $primary_menu_item->title; ?></span></a></li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </footer>
      <!--End Footer -->
    </div>
    <!--End Page Body-->
  </div>
<!--Begin Scripts -->
<?php wp_footer(); ?>
<!--End Scripts -->
</body>
</html>
