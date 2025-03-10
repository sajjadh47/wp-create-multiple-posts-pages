<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for
 * enqueueing the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Create_Multi_Posts_Pages
 * @subpackage Wp_Create_Multi_Posts_Pages/includes
 * @author     Sajjad Hossain Sagor <sagorh672@gmail.com>
 */
class Wp_Create_Multi_Posts_Pages_Admin
{
	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version )
	{
		$this->plugin_name 	= $plugin_name;
		
		$this->version 		= $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_styles()
	{
		$current_screen = get_current_screen();

		// check if current page is plugin settings page and current user an admin
		if( $current_screen->id == 'toplevel_page_wp-create-multiple-posts-pages' && current_user_can( 'manage_options' ) )
		{
			wp_enqueue_style( $this->plugin_name, WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_URL . 'admin/css/admin.css', [], $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_scripts()
	{
		$current_screen = get_current_screen();

		// check if current page is plugin settings page and current user an admin
		if( $current_screen->id == 'toplevel_page_wp-create-multiple-posts-pages' && current_user_can( 'manage_options' ) )
		{
			wp_enqueue_script( $this->plugin_name, WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_URL . 'admin/js/admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * Adds a settings link to the plugin's action links on the plugin list table.
	 *
	 * @since    2.0.0
	 *
	 * @param    array $links The existing array of plugin action links.
	 * @return   array The updated array of plugin action links, including the settings link.
	 */
	public function add_plugin_action_links( $links )
	{
		$links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=wp-create-multiple-posts-pages' ), __( 'Settings', 'wp-create-multiple-posts-pages' ) );
		
		return $links;
	}

	/**
	 * Adds the plugin settings page to the WordPress dashboard menu.
	 *
	 * @since    2.0.0
	 */
	public function admin_menu()
	{
		add_menu_page(
			__( 'Multiple Posts', 'wp-edit-username' ),
			__( 'Multiple Posts', 'wp-edit-username' ),
			'manage_options',
			'wp-create-multiple-posts-pages',
			array( $this, 'menu_page' ),
			'dashicons-menu'
		);
	}

	/**
	 * Renders the plugin settings page form.
	 *
	 * @since    2.0.0
	 */
	public function menu_page()
	{
		if( isset( $_POST['wpcmp_submit_for_create_posts'] ) )
		{
			if (
				! isset( $_POST['wpcmp_nonce'] ) ||
				! wp_verify_nonce( $_POST['wpcmp_nonce'], 'wpcmp_create_posts' )
			)
			{
			   print 'Sorry, your nonce did not verify.'; exit;
			}
			else
			{
				extract( $_POST );

				if (
					! empty( $wpcmp_posts_titles ) &&
					! empty( $wpcmp_new_post_type ) &&
					! empty( $wpcmp_new_post_status ) &&
					! empty( $wpcmp_new_post_author )
				)
				{
					$posts_titles 				= explode( "\n", $wpcmp_posts_titles );

					$category_ids				= array( 1 );

					if ( ! empty( $wpcmp_new_post_category ) )
					{	
						foreach ( $wpcmp_new_post_category as $id )
						{	
							$category_ids[] 	= intval( $id );
						}
					}

					$created_posts 				= array();

					foreach ( $posts_titles as $post_title )
					{	
						$post 					= array(
						  'post_title'    => sanitize_text_field( $post_title ),
						  'post_content'  => '',
						  'post_type' 	  => sanitize_text_field( $wpcmp_new_post_type ),
						  'post_status'   => sanitize_text_field( $wpcmp_new_post_status ),
						  'post_author'   => sanitize_text_field( $wpcmp_new_post_author ),
						  'post_category' => array_unique( $category_ids ),
						);

						// Insert the post into the database
						$post_id 				= wp_insert_post( $post );

						if( ! is_wp_error( $post_id ) )
						{
							//the post is valid
							$wpcmp_show_message = 'success';
							
							$created_posts[] 	= $post_id;
						}
					}

					if ( $wpcmp_show_message && $wpcmp_show_message == 'success' )
					{	
						$wpcmp_message 			= __( 'Posts Successfully Created!', 'wp-create-multiple-posts-pages' );
					}
				}
			}
		}

		$post_types 							= $this->get_custom_post_types();

		$users 									= get_users( 'who=authors' );

		$i 										= 0;

		require_once WP_CREATE_MULTI_POSTS_PAGES_PLUGIN_PATH . 'admin/partials/plugin-admin-display.php';
	}

	/**
	* Get all custom registered post types
	* 
	* @since    2.0.0
	*/
	public function get_custom_post_types()
	{
		$post_types 		= array( 'post', 'page' );

		$args 				= array( 'public' => true, '_builtin' => false );

		$output 			= 'names'; // names or objects, note names is the default
		
		$operator 			= 'and'; // 'and' or 'or'

		$extra_post_types 	= get_post_types( $args, $output, $operator );

		if ( ! empty( $extra_post_types ) )
		{
			$post_types 	= array_merge( $post_types, $extra_post_types );
		}
		
		return $post_types;
	}
}
