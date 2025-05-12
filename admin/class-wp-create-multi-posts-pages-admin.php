<?php
/**
 * This file contains the definition of the Wp_Create_Multi_Posts_Pages_Admin class, which
 * is used to load the plugin's admin-specific functionality.
 *
 * @package       Wp_Create_Multi_Posts_Pages
 * @subpackage    Wp_Create_Multi_Posts_Pages/admin
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @since    2.0.0
 */
class Wp_Create_Multi_Posts_Pages_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string $plugin_name The name of this plugin.
	 * @param     string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function enqueue_styles() {
		$current_screen = get_current_screen();

		// check if current page is plugin settings page and current user an admin.
		if ( 'toplevel_page_wp-create-multiple-posts-pages' === $current_screen->id && current_user_can( 'manage_options' ) ) {
			wp_enqueue_style( $this->plugin_name, WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_URL . 'admin/css/admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function enqueue_scripts() {
		$current_screen = get_current_screen();

		// check if current page is plugin settings page and current user an admin.
		if ( 'toplevel_page_wp-create-multiple-posts-pages' === $current_screen->id && current_user_can( 'manage_options' ) ) {
			wp_enqueue_script( $this->plugin_name, WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_URL . 'admin/js/admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * Adds a settings link to the plugin's action links on the plugin list table.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     array $links The existing array of plugin action links.
	 * @return    array $links The updated array of plugin action links, including the settings link.
	 */
	public function add_plugin_action_links( $links ) {
		$links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=wp-create-multiple-posts-pages' ), __( 'Settings', 'wp-create-multiple-posts-pages' ) );

		return $links;
	}

	/**
	 * Adds the plugin settings page to the WordPress dashboard menu.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function admin_menu() {
		add_menu_page(
			__( 'Multiple Posts', 'wp-create-multiple-posts-pages' ),
			__( 'Multiple Posts', 'wp-create-multiple-posts-pages' ),
			'manage_options',
			'wp-create-multiple-posts-pages',
			array( $this, 'menu_page' ),
			'dashicons-menu'
		);
	}

	/**
	 * Renders the plugin settings page form.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function menu_page() {
		if ( isset( $_POST['wpcmp_submit_for_create_posts'] ) ) {
			if ( isset( $_POST['wpcmp_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wpcmp_nonce'] ) ), 'wpcmp_create_posts' ) ) {
				if ( ! empty( $_POST['wpcmp_posts_titles'] ) && ! empty( $_POST['wpcmp_new_post_type'] ) && ! empty( $_POST['wpcmp_new_post_status'] ) && ! empty( $_POST['wpcmp_new_post_author'] ) ) {
					$posts_titles = explode( "\n", sanitize_textarea_field( wp_unslash( $_POST['wpcmp_posts_titles'] ) ) );

					$category_ids = array( 1 );

					if ( ! empty( $wpcmp_new_post_category ) ) {
						foreach ( $wpcmp_new_post_category as $id ) {
							$category_ids[] = intval( $id );
						}
					}

					$created_posts = array();

					foreach ( $posts_titles as $post_title ) {
						$post = array(
							'post_title'    => sanitize_text_field( $post_title ),
							'post_content'  => '',
							'post_type'     => sanitize_text_field( wp_unslash( $_POST['wpcmp_new_post_type'] ) ),
							'post_status'   => sanitize_text_field( wp_unslash( $_POST['wpcmp_new_post_status'] ) ),
							'post_author'   => sanitize_text_field( wp_unslash( $_POST['wpcmp_new_post_author'] ) ),
							'post_category' => array_unique( $category_ids ),
						);

						// Insert the post into the database.
						$post_id = wp_insert_post( $post );

						if ( ! is_wp_error( $post_id ) ) {
							// the post is valid.
							$wpcmp_show_message = 'success';
							$wpcmp_message      = __( 'Posts Successfully Created!', 'wp-create-multiple-posts-pages' );
							$created_posts[]    = $post_id;
						}
					}
				}
			} else {
				$wpcmp_show_message = 'error';
				$wpcmp_message      = __( 'Sorry, your nonce did not verify.', 'wp-create-multiple-posts-pages' );
			}
		}

		$post_types = $this->get_custom_post_types();
		$users      = get_users( array( 'role__not_in' => 'Subscriber' ) );
		$i          = 0;

		require_once WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH . 'admin/views/plugin-admin-display.php';
	}

	/**
	 * Get all custom registered post types.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function get_custom_post_types() {
		$post_types       = array( 'post', 'page' );
		$args             = array(
			'public'   => true,
			'_builtin' => false,
		);
		$output           = 'names';
		$operator         = 'and';
		$extra_post_types = get_post_types( $args, $output, $operator );

		if ( ! empty( $extra_post_types ) ) {
			$post_types = array_merge( $post_types, $extra_post_types );
		}

		return $post_types;
	}
}
