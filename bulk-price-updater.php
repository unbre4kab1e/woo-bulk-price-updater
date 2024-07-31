<?php
/*
Plugin Name: Bulk Price Updater
Description: A plugin to bulk update product prices in WooCommerce.
Version: 1.0
Author: Abdelghafour (UnBre4Kab1e)
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define plugin paths
define('BPU_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BPU_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once BPU_PLUGIN_DIR . 'includes/functions.php';
require_once BPU_PLUGIN_DIR . 'includes/class-bulk-price-updater.php';

// Initialize the plugin
function bpu_initialize_plugin() {
    $bulk_price_updater = new BulkPriceUpdater();
}
add_action('plugins_loaded', 'bpu_initialize_plugin');
