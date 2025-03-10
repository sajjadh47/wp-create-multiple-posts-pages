<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.0.0
 * @package    Wp_Create_Multi_Posts_Pages
 * @subpackage Wp_Create_Multi_Posts_Pages/includes
 * @author     Sajjad Hossain Sagor <sagorh672@gmail.com>
 */
class Wp_Create_Multi_Posts_Pages_i18n
{
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.0.0
	 */
	public function load_plugin_textdomain()
	{
		load_plugin_textdomain(
			'wp-create-multiple-posts-pages',
			false,
			dirname( WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_BASENAME ) . '/languages/'
		);
	}
}
