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
require_once plugin_dir_path( __FILE__ ) . 'admin/class-ghostwrite-admin.php';


// Initialize the plugin
$ghostwrite = new Ghostwrite_Core();