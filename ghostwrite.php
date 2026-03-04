<?php
/**
 * Plugin Name: Ghostwrite
 * Description: AI-powered personalized ghostwriting assistant.
 * Version: 1.0.0
 * Author: Arnab Kumar Mondal
 * Text Domain: ghostwrite
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-ghostwrite-core.php';

class Ghostwrite_Core {

    /**
     * Initialize the plugin and register hooks.
     */
    public function __construct() {
        // We need to hook into WordPress here!
    }

    /**
     * Register the text-generation ability.
     */
    public function register_ai_ability() {
        // We will build out our wp_register_ability() logic here next.
    }
}


// Initialize the plugin
$ghostwrite = new Ghostwrite_Core();