<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since         2.0.0
 * @package       Wp_Create_Multi_Posts_Pages
 * @subpackage    Wp_Create_Multi_Posts_Pages/admin/views
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

?>

<div class="wrap">
	<h2><?php echo esc_html__( 'Create Multiple Posts', 'wp-create-multiple-posts-pages' ); ?></h2>
	<?php if ( isset( $wpcmp_show_message ) ) : ?>
		<div class="notice notice-<?php echo esc_attr( $wpcmp_show_message ); ?> is-dismissible">
			<p><?php echo esc_html( $wpcmp_message ); ?></p>
		</div>
		<?php if ( 'success' === $wpcmp_show_message ) : ?>
		<div class="notice notice-success is-dismissible wpcmp_notice">
			<h4><?php echo esc_html__( 'Created Posts', 'wp-create-multiple-posts-pages' ); ?>:</h4>
			<div class="container-fluid">
				<?php foreach ( $created_posts as $wpcmp_id ) : ?>
					<div class="row wpcmp_row">
						<p class="col-md-11 wpcmp_col_11"><?php echo esc_html( get_the_title( $wpcmp_id ) ); ?></p>
						<p class="col-md-1 wpcmp_col_1">
							<a href="<?php echo esc_url( get_the_permalink( $wpcmp_id ) ); ?>" class='button wpcmp_a'>
								<?php echo esc_html__( 'View', 'wp-create-multiple-posts-pages' ); ?>
							</a>
							<a href="<?php echo esc_url( get_edit_post_link( $wpcmp_id ) ); ?>" class='button'>
								<?php echo esc_html__( 'Edit', 'wp-create-multiple-posts-pages' ); ?>
							</a>
						</p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
	<?php endif; ?>
	<form action="" method="post">
		<div class="form-group">
			<p class="col-form-label insert_note">
				<?php echo esc_html__( 'Insert Posts Title One Per Line', 'wp-create-multiple-posts-pages' ); ?>
				<small> (<?php echo esc_html__( 'Press Enter To Go To A New Line', 'wp-create-multiple-posts-pages' ); ?>)</small>
			</p>
			<textarea class="form-control new_line_bg new_line_number" name="wpcmp_posts_titles" id="wpcmp_posts_titles" cols="30" rows="8"></textarea>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col">
					<p class="col-form-label insert_note"><?php echo esc_html__( 'Post Type', 'wp-create-multiple-posts-pages' ); ?></p>
					<select name="wpcmp_new_post_type" id="wpcmp_new_post_type" class="form-control" disabled>
						<?php foreach ( $post_types as $wpcmp_post_type ) : ?>
							<option value="<?php echo esc_attr( $wpcmp_post_type ); ?>"><?php echo esc_html( ucfirst( $wpcmp_post_type ) ); ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="col">
					<p class="col-form-label insert_note"><?php echo esc_html__( 'Post Status', 'wp-create-multiple-posts-pages' ); ?></p>
					<select name="wpcmp_new_post_status" id="wpcmp_new_post_status" class="form-control" disabled>
						<option value="publish"><?php echo esc_html__( 'Publish', 'wp-create-multiple-posts-pages' ); ?></option>
						<option value="draft"><?php echo esc_html__( 'Draft', 'wp-create-multiple-posts-pages' ); ?></option>
						<option value="pending"><?php echo esc_html__( 'Pending', 'wp-create-multiple-posts-pages' ); ?></option>
						<option value="private"><?php echo esc_html__( 'Private', 'wp-create-multiple-posts-pages' ); ?></option>
					</select>
				</div>
				<div class="col">
					<p class="col-form-label insert_note"><?php echo esc_html__( 'Post Author', 'wp-create-multiple-posts-pages' ); ?></p>
					<select name="wpcmp_new_post_author" id="wpcmp_new_post_author" class="form-control" disabled>
					<?php
					foreach ( $users as $user ) {
						echo '<option value="' . esc_attr( $user->ID ) . '">' . esc_html( ucwords( str_replace( '_', ' ', $user->user_login ) ) ) . '</option>';
					}
					?>
					</select>
				</div>
				<div class="col">
					<p class="col-form-label insert_note"><?php echo esc_html__( 'Post Category', 'wp-create-multiple-posts-pages' ); ?> <small><?php echo esc_html__( '(Posts Only)', 'wp-create-multiple-posts-pages' ); ?></small></p>
					<select name="wpcmp_new_post_category[]" id="wpcmp_new_post_category" class="form-control" multiple disabled>
					<?php
					$categories = get_categories(
						array(
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => false,
						)
					);

					foreach ( $categories as $category ) {
						echo '<option value="' . esc_attr( $category->term_id ) . '">' . esc_html( ucwords( str_replace( '_', ' ', $category->cat_name ) ) ) . '</option>';
					}
					?>
					</select>
				</div>
				<div class="col">
					<p class="col-form-label insert_note"><?php echo esc_html__( 'Action', 'wp-create-multiple-posts-pages' ); ?></p>
					<button type="submit" class="button" name="wpcmp_submit_for_create_posts" id="wpcmp_submit_for_create_posts" disabled><?php echo esc_html__( 'Add Posts', 'wp-create-multiple-posts-pages' ); ?></button>
				</div>
			</div>
			<?php wp_nonce_field( 'wpcmp_create_posts', 'wpcmp_nonce' ); ?>
		</div>
	</form>
</div>