<?php
/*
Plugin Name: Test Plugin
Description: Custom plugin for adding few options for Theme => Qusq Lite by  IshYoBoy.com
Author: Matus Vrsansky
Version: 1.0.0
*/

// Include file for setting plugin fields
require "includes/tp.function.php";

// add custom style for Test Plugin
function add_plugin_stylesheet()
{
    wp_enqueue_style( 'test-plugin-style', plugins_url( '/includes/test-plugin-style.css', __FILE__ ) );
}

add_action('admin_print_styles', 'add_plugin_stylesheet');