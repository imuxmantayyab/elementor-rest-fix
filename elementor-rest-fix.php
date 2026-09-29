<?php
/**
 * Plugin Name: Elementor REST API Fix
 * Plugin URI:  https://github.com/imuxmantayyab/elementor-rest-fix/
 * Description: Prevents Elementor from injecting CSS into WordPress REST API responses, fixing the "not a valid JSON response" error in Gutenberg.
 * Version:     1.0.0
 * Author:      Usman Tayyab
 * Author URI:  https://www.linkedin.com/in/imuxmantayyab/
 * License:     GPL-2.0+
 * Text Domain: elementor-rest-fix
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Start an output buffer when the REST API initializes.
 * This captures any stray HTML/CSS that Elementor tries to print
 * before the JSON response is sent.
 */
add_action( 'rest_api_init', function() {
    ob_start();
}, PHP_INT_MAX );

/**
 * Clean the output buffer just before WordPress serves the REST response.
 * This discards the captured CSS without affecting the JSON payload,
 * which WordPress's REST server sends independently.
 */
add_filter( 'rest_pre_serve_request', function( $served ) {
    if ( ob_get_level() > 0 ) {
        ob_end_clean();
    }
    return $served;
}, PHP_INT_MIN );
