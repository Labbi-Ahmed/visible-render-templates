<?php
/**
 * Plugin Name: Visible Render Templates
 * Plugin URI:  https://welabs.dev
 * Description: This plugin for the show the templates render the page
 * Version: 0.0.1
 * Author: Labbi Ahmed
 * Author URI: https://welabs.dev
 * Text Domain: visible-render-templates
 * WC requires at least: 5.0.0
 * Domain Path: /languages/
 * Requires Plugins: woocommerce, dokan-lite
 * License: GPL2
 */
use WeLabs\VisibleRenderTemplates\VisibleRenderTemplates;

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'VISIBLE_RENDER_TEMPLATES_FILE' ) ) {
    define( 'VISIBLE_RENDER_TEMPLATES_FILE', __FILE__ );
}

if ( ! defined( 'VISIBLE_RENDER_TEMPLATES_BASENAME' ) ) {
    define( 'VISIBLE_RENDER_TEMPLATES_BASENAME', plugin_basename( __FILE__ ) );
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load Visible_Render_Templates Plugin when all plugins loaded
 *
 * @return \WeLabs\VisibleRenderTemplates\VisibleRenderTemplates
 */
function welabs_visible_render_templates() {
    return VisibleRenderTemplates::init();
}

// Lets Go....
welabs_visible_render_templates();
