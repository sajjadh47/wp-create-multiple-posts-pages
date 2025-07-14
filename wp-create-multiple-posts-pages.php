<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           Wp_Create_Multi_Posts_Pages
 * @author            Sajjad Hossain Sagor <sagorh672@gmail.com>
 *
 * Plugin Name:       WP Create Multiple Posts & Pages
 * Plugin URI:        https://wordpress.org/plugins/wp-create-multiple-posts-pages/
 * Description:       Create Multiple WordPress Posts & Pages At Once With a Single Click.
 * Version:           2.0.2
 * Requires at least: 5.6
 * Requires PHP:      8.0
 * Author:            Sajjad Hossain Sagor
 * Author URI:        https://sajjadhsagor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-create-multiple-posts-pages
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WP_CREATE_MULTI_POSTS_PAGES_VERSION', '2.0.2' );

/**
 * Define Plugin Folders Path
 */
define( 'WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-create-multi-posts-pages-activator.php
 *
 * @since    2.0.0
 */
function on_activate_wp_create_multi_posts_pages() {
	require_once WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH . 'includes/class-wp-create-multi-posts-pages-activator.php';

	Wp_Create_Multi_Posts_Pages_Activator::on_activate();
}

register_activation_hook( __FILE__, 'on_activate_wp_create_multi_posts_pages' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-create-multi-posts-pages-deactivator.php
 *
 * @since    2.0.0
 */
function on_deactivate_wp_create_multi_posts_pages() {
	require_once WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH . 'includes/class-wp-create-multi-posts-pages-deactivator.php';

	Wp_Create_Multi_Posts_Pages_Deactivator::on_deactivate();
}

register_deactivation_hook( __FILE__, 'on_deactivate_wp_create_multi_posts_pages' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 *
 * @since    2.0.0
 */
require WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH . 'includes/class-wp-create-multi-posts-pages.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_wp_create_multi_posts_pages() {
	$plugin = new Wp_Create_Multi_Posts_Pages();

	$plugin->run();
}

run_wp_create_multi_posts_pages();
