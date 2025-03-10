<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             2.0.0
 * @package           Wp_Create_Multi_Posts_Pages
 *
 * Plugin Name:       WP Create Multiple Posts & Pages
 * Plugin URI:        https://wordpress.org/plugins/wp-create-multiple-posts-pages/
 * Description:       Create Multiple Wordpress Posts & Pages At Once With a Single Click.
 * Version:           2.0.1
 * Author:            Sajjad Hossain Sagor
 * Author URI:        https://sajjadhsagor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-create-multiple-posts-pages
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

/**
 * Currently plugin version.
 */
define( 'WP_CREATE_MULTI_POSTS_PAGES_VERSION', '2.0.1' );

/**
 * Define Plugin Folders Path
 */
define( 'WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-activator.php
 * 
 * @since    2.0.0
 */
function activate_wp_create_multi_posts_pages()
{
	require_once WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH . 'includes/class-plugin-activator.php';
	
	Wp_Create_Multi_Posts_Pages_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_wp_create_multi_posts_pages' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-deactivator.php
 * 
 * @since    2.0.0
 */
function deactivate_wp_create_multi_posts_pages()
{
	require_once WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH . 'includes/class-plugin-deactivator.php';
	
	Wp_Create_Multi_Posts_Pages_Deactivator::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_wp_create_multi_posts_pages' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * 
 * @since    2.0.0
 */
require WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH . 'includes/class-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_wp_create_multi_posts_pages()
{
	$plugin = new Wp_Create_Multi_Posts_Pages();
	
	$plugin->run();
}

run_wp_create_multi_posts_pages();
