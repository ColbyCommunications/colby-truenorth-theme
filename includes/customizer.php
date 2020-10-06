<?php
/**
 * Customizer Functions
 */

 function ad_theme_customizer($wp_customize) {
     // Hide Default Customizer Sections
     $wp_customize->remove_section( 'custom_css'); // Additional CSS
     $wp_customize->remove_section( 'static_front_page'); // Home Page Settings
 }
add_action('customize_register', 'ad_theme_customizer');
