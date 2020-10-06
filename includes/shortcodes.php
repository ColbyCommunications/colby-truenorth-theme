<?php
/**
* Shortcodes
*/

// ob_start(); and return ob_get_clean(); explanation
// php just outputs your content right away when its see print statement. What we do here is, we are holding all the output in buffer and not giving it in print until the whole things finish.

// Displays form short code
function ad_form_shortcode( $atts, $content = null ) {
    ob_start();
    //set default attributes and values
    $values = shortcode_atts( array(
        'name' => ''
    ), $atts );

    if ( $values['name'] !== "" && locate_template( array( 'template-parts/modules/forms/'.$values['name'].'.php' ) ) != ''  ) {
    	get_template_part( 'template-parts/modules/forms/'.$values['name'] );
    }
    else {
    	return '<p>No Form Found</p>';
    }
    return ob_get_clean();
}
add_shortcode( 'forms', 'ad_form_shortcode' );

// Displays custom module short code
function module_shortcode($atts, $content = null) {
    ob_start();
    //set default attributes and values
    $values = shortcode_atts( array(
        'path' => ''
    ), $atts );
    if ( $values['path'] !== "" && locate_template( array( 'template-parts/modules/'.$values['path'].'.php' ) ) != ''  ) {
    	get_template_part( 'template-parts/modules/'.$values['path'] );
    }
    else {
    	return '<p>No Shortcode Found</p>';
    }
    return ob_get_clean();
}
add_shortcode( 'module', 'module_shortcode' );

// Displays style guide short code
function ad_style_guide_shortcode() {
    ob_start();
    get_template_part( 'template-parts/modules/style-guide' );
    return ob_get_clean();
}
add_shortcode( 'styleguide', 'ad_style_guide_shortcode' );
