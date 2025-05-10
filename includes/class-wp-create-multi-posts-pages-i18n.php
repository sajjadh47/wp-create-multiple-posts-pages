<?php
/**
 * This file contains the definition of the Wp_Create_Multi_Posts_Pages_I18n class, which
 * is used to load the plugin's internationalization.
 *
 * @package       Wp_Create_Multi_Posts_Pages
 * @subpackage    Wp_Create_Multi_Posts_Pages/includes
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since    2.0.0
 */
class Wp_Create_Multi_Posts_Pages_I18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'wp-create-multiple-posts-pages',
			false,
			dirname( WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_BASENAME ) . '/languages/'
		);
	}
}
