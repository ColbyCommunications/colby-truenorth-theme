<?php

/*
 To add in additional classes check this out https://core.trac.wordpress.org/browser/tags/4.9/src/wp-includes/post-template.php#L555
*/

function custom_body_class($class = '')
{
    // Separates classes with a single space, collates classes for body element
    echo 'class="' . join(' ', get_custom_body_class($class)) . '"';
}

/**
 * Retrieve the classes for the body element as an array.
 */
function get_custom_body_class($class = '')
{
    global $wp_query;
    $classes = array();

    if (is_user_logged_in()) {
        $classes[] = 'logged-in';
    }
    if (is_admin_bar_showing()) {
        $classes[] = 'admin-bar';
        $classes[] = 'no-customize-support';
    }

    /* Uncomment for template name
    if ( is_page_template() ) {
      $template_slug  = get_page_template_slug( get_the_ID() );
      $template_slug  = str_replace(".php","",$template_slug);
      $classes[] = sanitize_html_class( str_replace( '.', '-', $template_slug ) );
    }
    else {
      $classes[] = "template-default";
    }
    */

    if (! empty($class)) {
        if (!is_array($class)) {
            $class = preg_split('#\s+#', $class);
        }
        $classes = array_merge($classes, $class);
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }
    $classes = array_map('esc_attr', $classes);
    /**
     * Filters the list of CSS body classes for the current post or page.
     */
    $classes = apply_filters('custom_body_class', $classes, $class);
    return array_unique($classes);
}
