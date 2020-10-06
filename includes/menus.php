<?php
/**
* Menus
*/

/**********************
* Custom Tree Menu Functio Object
  -- custom function for outputting WP menus in recursive format
  -- see cacher for additional instructions and usage https://snippets.cacher.io/snippet/d9bf3ae291349fe158c2
**********************/
function ad_tree_object( array &$elements, $parentId = 0 ) {
  $branch = array();
  foreach ( $elements as &$element )
  {
      if ( $element->menu_item_parent == $parentId )
      {
          $children = ad_tree_object( $elements, $element->ID );
          if ( $children )
              $element->wpse_children = $children;

          $branch[$element->ID] = $element;
          unset( $element );
      }
  }
  return $branch;
}

function ad_menu_attributes($menu_item) {
  $attributes  = ! empty($menu_item->attr_title) ? ' title="'  . esc_attr($menu_item->attr_title) .'"' : '';
  $attributes .= ! empty($menu_item->target)     ? ' target="' . esc_attr($menu_item->target    ) .'"' : '';
  $attributes .= ! empty($menu_item->xfn)        ? ' rel="'    . esc_attr($menu_item->xfn       ) .'"' : '';
  return $attributes;
}

function ad_menu_classes($menu_item) {
  $class_names = join(' ', $menu_item->classes);
  $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
  return $class_names;
}

function ad_tree_menu( $menu_id ) {
    $items = wp_get_nav_menu_items( $menu_id );
    return  $items ? ad_tree_object( $items, 0 ) : null;
}

/**********************
* WordPres Default Walker Menu Register
**********************/

function register_theme_menus()
{
    register_nav_menus(
        array(
          // 'primary-menu' => __('Primary Menu')
        )
    );
}
add_action('init', 'register_theme_menus');

/**********************
* Clean Menu
**********************/

/**
Example: Calling Clean Menu
<?php
  $defaults = array(
    'container' => false,
    'theme_location' => 'footer-links-menu',
    'menu_class' => '',
    'menu' => '',
    'items_wrap' => '<ul>%3$s</ul>',
    'link_before' => '',
    'link_after' => '',
    'class_li' => false, // Custom argument to set whether class should be in li or a tag
    'walker' => new Clean_Menu
  );
  wp_nav_menu($defaults);
?>
*/

class Clean_Menu extends Walker_Nav_Menu
{
    /**
     * {@inheritdoc}
     */
    function start_lvl(&$output, $depth=0, $args=array())
    {
        $output .= '<ul class="sub-menu">';
    }
    /**
     * {@inheritdoc}
     */
    function end_lvl(&$output, $depth=0, $args=array())
    {
        $output .= '</ul>';
    }
    /**
     * {@inheritdoc}
     */
    function start_el(&$output, $item, $depth=0, $args=array(), $id=0)
    {
        $class_names = '';
        $classes = empty($item->classes) ?
            array() : array_intersect($this->get_allowed_classes(), (array) $item->classes);
        // put th ecustom CSS classes back in.
        if ($custom = get_post_meta($item->ID, '_menu_item_classes', true)) {
            $classes = array_merge($classes, $custom);
        }
        $class_names = join(' ',
            apply_filters('nav_menu_css_class', array_filter(array_unique($classes)), $item, $args)
        );
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        $output .= ($args->class_li) ? '<li' . $class_names .'>' : '<li>';
        $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
        $item_output = $args->before;
        $item_output .= ($args->class_li) ? '<a'. $attributes .'>' : '<a'. $attributes .' '. $class_names .'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    /**
     * {@inheritdoc}
     */
    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= "</li>";
    }
    /**
     * Get the CSS classes that will be allowed on menu item li's.
     *
     * @since   1.0
     * @access  private
     * @uses    apply_filters.
     * @return  array
     */
    private function get_allowed_classes()
    {
        return apply_filters('clean_menu_walker_allowed_classes', array(
            'current-menu-item',
            'current-menu-ancestor',
        ));
    }
}
