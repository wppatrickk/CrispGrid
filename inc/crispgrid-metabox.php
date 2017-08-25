<?php
/*
 * @author    Crisp Themes
 * @copyright Copyright (c) 2017, Crisp Themes, https://www.crispthemes.com
 * @license   http://en.wikipedia.org/wiki/MIT_License The MIT License
*/

add_action( 'add_meta_boxes', 'crispgrid_metabox' );

function crispgrid_metabox() {
    add_meta_box( 'crispgrid-shortcode', __( "Grid Shortcode", 'crispgrid' ), 'crispgrid_cb', 'crispgrid', 'normal', 'high' );
	add_meta_box( 'crispgrid-settings', __( "Grid Settings", 'crispgrid' ), 'crispgrid_settings', 'crispgrid', 'normal', 'default' );
}

function crispgrid_cb($post) {
	$shortcode = get_post_meta($post->ID, 'crispgrid_shortcode', true);
	wp_nonce_field( 'crispgrid_nonce_set', 'crispgrid_nonce' ); ?>
    <input type="text" name="crispgrid_shortcode" id="crispgrid-shortcode" value="<?php echo htmlentities($shortcode);?>" style="width: 100%; max-width: 300px;" readonly /><br />
	<p>Use this shortcode wherever you want to display the grid.</p>
    <?php    
}

function crispgrid_settings($post) {
	wp_nonce_field( 'crispgrid_nonce_set', 'crispgrid_nonce' );
	$crispgrid_type = get_post_meta($post->ID, 'crispgrid_type', true);
	$crispgrid_cols = get_post_meta($post->ID, 'crispgrid_cols', true);
	$crispgrid_display = get_post_meta($post->ID, 'crispgrid_display', true);
	$crispgrid_nop = get_post_meta($post->ID, 'crispgrid_nop', true);
	$crispgrid_image = get_post_meta($post->ID, 'crispgrid_image', true);
	$crispgrid_date = get_post_meta($post->ID, 'crispgrid_date', true);
	$crispgrid_author = get_post_meta($post->ID, 'crispgrid_author', true);
	$crispgrid_excerpt = get_post_meta($post->ID, 'crispgrid_excerpt', true);
	$crispgrid_excerpt_text = get_post_meta($post->ID, 'crispgrid_excerpt_text', true);
	$crispgrid_link = get_post_meta($post->ID, 'crispgrid_link', true);
	$crispgrid_link_text = get_post_meta($post->ID, 'crispgrid_link_text', true);
	$crispgrid_bgcolor = get_post_meta($post->ID, 'crispgrid_bgcolor', true);
	$crispgrid_color = get_post_meta($post->ID, 'crispgrid_color', true);
	$crispgrid_bgcolor_hover = get_post_meta($post->ID, 'crispgrid_bgcolor_hover', true);
	$crispgrid_color_hover = get_post_meta($post->ID, 'crispgrid_color_hover', true); ?>

	<div id="crispgrid-settings">
		<div class="crispgrid-wrap">
			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Post Type', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid_type"><?php esc_attr_e( 'Post Type', 'crispgrid' ); ?></label>
				<select name="crispgrid_type" id="crispgrid-type">
					<option value="post" <?php selected( $crispgrid_type, 'post' ); ?>>Posts</option>
					<?php 
					$postargs = array(
	       				'public'   => true,
	       				'_builtin' => false
	    			);
					$post_types = get_post_types($postargs);
					foreach ( $post_types as $post_type ) {
						$obj = get_post_type_object($post_type); ?>
	   					<option value="<?php echo $post_type; ?>" <?php selected( $crispgrid_type, $post_type ); ?>><?php echo $obj->labels->singular_name; ?></option>
					<?php } ?>
				</select>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Grid Columns', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid_cols"><?php esc_attr_e( 'Grid Columns', 'crispgrid' ); ?></label>
				<select name="crispgrid_cols" id="crispgrid-cols">
					<option value="2" <?php selected( $crispgrid_cols, '2' ); ?>>2</option>
					<option value="3" <?php selected( $crispgrid_cols, '3' ); ?> <?php if (!$crispgrid_cols) { echo "selected"; } ?>>3</option>
					<option value="4" <?php selected( $crispgrid_cols, '4' ); ?>>4</option>
					<option value="5" <?php selected( $crispgrid_cols, '5' ); ?>>5</option>
					<option value="6" <?php selected( $crispgrid_cols, '6' ); ?>>6</option>
				</select>
			</fieldset>

			<div class="crispgrid-display">
				<label>Display Type</label>
				<fieldset>
					<div class="crispgrid-display-wrap">
						<legend class="screen-reader-text"><span><?php esc_attr_e( 'Square', 'crispgrid' ); ?></span></legend>
						<label for="crispgrid-display">
							<input name="crispgrid_display" type="radio" value="square" <?php checked( $crispgrid_display, 'square' ); ?> <?php if (!$crispgrid_display) { ?>checked<?php } ?> />
							<span><?php esc_attr_e( 'Square', 'crispgrid' ); ?></span>
						</label>
					</div>

					<div class="crispgrid-display-wrap">
						<legend class="screen-reader-text"><span><?php esc_attr_e( 'Rectangle', 'crispgrid' ); ?></span></legend>
						<label for="crispgrid-display">
							<input name="crispgrid_display" type="radio" value="rectangle" <?php checked( $crispgrid_display, 'rectangle' ); ?> />
							<span><?php esc_attr_e( 'Rectangle', 'crispgrid' ); ?></span>
						</label>
					</div>

					<div class="clear"></div>
				</fieldset>

				<div class="clear"></div>
			</div>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'No. of Posts', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid_nop"><?php esc_attr_e( 'No. of Posts', 'crispgrid' ); ?></label>
				<input type="number" name="crispgrid_nop" id="crispgrid-nop" value="<?php if ($crispgrid_nop) { echo $crispgrid_nop; } ?>" placeholder="9" min="2" />
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Hide Featured Image', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid_image"><input type="checkbox" id="crispgrid-image" name="crispgrid_image" <?php checked( $crispgrid_image, 'on' ); ?>><?php esc_attr_e( 'Hide Featured Image', 'crispgrid' ); ?></label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Hide Date', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid_date"><input type="checkbox" id="crispgrid-date" name="crispgrid_date" <?php checked( $crispgrid_date, 'on' ); ?>><?php esc_attr_e( 'Hide Date', 'crispgrid' ); ?></label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Hide Author', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid_author"><input type="checkbox" id="crispgrid-author" name="crispgrid_author" <?php checked( $crispgrid_author, 'on' ); ?>><?php esc_attr_e( 'Hide Author', 'crispgrid' ); ?></label>
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Hide Excerpt', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid-excerpt"><input type="checkbox" id="crispgrid-excerpt" name="crispgrid_excerpt" <?php checked( $crispgrid_excerpt, 'on' ); ?>><?php esc_attr_e( 'Hide Excerpt', 'crispgrid' ); ?></label>
			</fieldset>

			<fieldset id="crispgrid-excerpt-length">
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Excerpt Length', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid_excerpt_text"><?php esc_attr_e( 'Excerpt Length', 'crispgrid' ); ?></label>
				<input type="number" name="crispgrid_excerpt_text" id="crispgrid-excerpt-text" value="<?php if ($crispgrid_excerpt_text) { echo $crispgrid_excerpt_text; } ?>" placeholder="40" min="10" />
			</fieldset>

			<fieldset>
				<legend class="screen-reader-text"><span><?php esc_attr_e( 'Hide Read More', 'crispgrid' ); ?></span></legend>
				<label for="crispgrid_link"><input type="checkbox" id="crispgrid-link" name="crispgrid_link" <?php checked( $crispgrid_link, 'on' ); ?>><?php esc_attr_e( 'Hide More Link', 'crispgrid' ); ?></label>
			</fieldset>

			<div id="crispgrid-read-more">
				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Full Post Text', 'crispgrid' ); ?></span></legend>
					<label for="crispgrid_link_text"><?php esc_attr_e( 'Full Post Text', 'crispgrid' ); ?></label>
					<input type="text" name="crispgrid_link_text" id="crispgrid-link-text" value="<?php if ($crispgrid_link_text) { echo $crispgrid_link_text; } ?>" placeholder="Read More" />
				</fieldset>

				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Background', 'crispgrid' ); ?></span></legend>
					<label for="crispgrid_bgcolor"><?php esc_attr_e( 'Background', 'crispgrid' ); ?></label>
					<input type="text" name="crispgrid_bgcolor" id="crispgrid-bgcolor" class="crispgrid-color-input" value="<?php if ($crispgrid_bgcolor) { echo $crispgrid_bgcolor; } ?>" placeholder="#eee" />
				</fieldset>

				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Color', 'crispgrid' ); ?></span></legend>
					<label for="crispgrid_color"><?php esc_attr_e( 'Color', 'crispgrid' ); ?></label>
					<input type="text" name="crispgrid_color" id="crispgrid-color" class="crispgrid-color-input" value="<?php if ($crispgrid_color) { echo $crispgrid_color; } ?>" placeholder="#111" />
				</fieldset>

				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Hover Background', 'crispgrid' ); ?></span></legend>
					<label for="crispgrid_bgcolor_hover"><?php esc_attr_e( 'Hover Background', 'crispgrid' ); ?></label>
					<input type="text" name="crispgrid_bgcolor_hover" id="crispgrid-bgcolor-hover" class="crispgrid-color-input" value="<?php if ($crispgrid_bgcolor_hover) { echo $crispgrid_bgcolor_hover; } ?>" placeholder="#111" />
				</fieldset>

				<fieldset>
					<legend class="screen-reader-text"><span><?php esc_attr_e( 'Hover Color', 'crispgrid' ); ?></span></legend>
					<label for="crispgrid_color_hover"><?php esc_attr_e( 'Hover Color', 'crispgrid' ); ?></label>
					<input type="text" name="crispgrid_color_hover" id="crispgrid-color-hover" class="crispgrid-color-input" value="<?php if ($crispgrid_color_hover) { echo $crispgrid_color_hover; } ?>" placeholder="#eee" />
				</fieldset>
			</div>

			<input type="submit" id="crispgrid-update" value="Update" />
		</div>

		<div class="crispgrid-ads-section">
			<div class="crispgrid-ad-section">
				<a href="https://www.crispthemes.com/" target="_blank"><img src="<?php echo CRISPGRID_URL; ?>/css/images/crisp_theme_logo.jpg" /></a>
			</div>

			<div class="crispgrid-ad-section">
				<a href="https://www.crispthemes.com/support/forum/plugins/crispslider/" target="_blank"><img src="<?php echo CRISPGRID_URL; ?>/css/images/plugin-support.png" /></a>
			</div>

			<div class="crispgrid-ad-section">
				<a href="https://www.crispthemes.com/plugins/" target="_blank"><img src="<?php echo CRISPGRID_URL; ?>/css/images/plugin-banner.png" /></a>
			</div>

			<div class="crispgrid-ad-section">
				<a href="https://www.crispthemes.com/themes/" target="_blank"><img src="<?php echo CRISPGRID_URL; ?>/css/images/theme-banner.png" /></a>
			</div>
		</div>

		<div class="clear"></div>
	</div>
<?php }

add_action('save_post', 'crispgrid_save_grid');

function crispgrid_save_grid($post_id){
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    if( !isset( $_POST['crispgrid_nonce'] ) || !wp_verify_nonce( $_POST['crispgrid_nonce'], 'crispgrid_nonce_set' ) ) return;
     
    if( !current_user_can( 'edit_post', $post_id ) ) return;

	if(isset($_POST['post_type']) && ($_POST['post_type'] == "crispgrid")) {
        $shortcode = get_post_meta($post_id, 'crispgrid_shortcode', true);
		if (!$shortcode) {
			update_post_meta( $post_id, 'crispgrid_shortcode', '[crispgrid id="' . $post_id . '"]' );
		}

		if( $_POST['crispgrid_type'] ) {
			update_post_meta( $post_id, 'crispgrid_type', esc_attr( $_POST['crispgrid_type'] ) );
		}

		if( $_POST['crispgrid_cols'] ) {
			update_post_meta( $post_id, 'crispgrid_cols', esc_attr( $_POST['crispgrid_cols'] ) );
		}

		update_post_meta( $post_id, 'crispgrid_display', $_POST['crispgrid_display'] );

		if( $_POST['crispgrid_nop'] ) {
			update_post_meta( $post_id, 'crispgrid_nop', esc_attr( $_POST['crispgrid_nop'] ) );
		}

		$crispgrid_image = isset( $_POST['crispgrid_image'] ) && $_POST['crispgrid_image'] ? 'on' : 'off';
		update_post_meta( $post_id, 'crispgrid_image', $crispgrid_image );

		$crispgrid_date = isset( $_POST['crispgrid_date'] ) && $_POST['crispgrid_date'] ? 'on' : 'off';
		update_post_meta( $post_id, 'crispgrid_date', $crispgrid_date );

		$crispgrid_author = isset( $_POST['crispgrid_author'] ) && $_POST['crispgrid_author'] ? 'on' : 'off';
		update_post_meta( $post_id, 'crispgrid_author', $crispgrid_author );

		$crispgrid_excerpt = isset( $_POST['crispgrid_excerpt'] ) && $_POST['crispgrid_excerpt'] ? 'on' : 'off';
		update_post_meta( $post_id, 'crispgrid_excerpt', $crispgrid_excerpt );

		if( isset( $_POST['crispgrid_excerpt_text'] )) {
			update_post_meta( $post_id, 'crispgrid_excerpt_text', esc_attr( $_POST['crispgrid_excerpt_text'] ) );
		}

		$crispgrid_link = isset( $_POST['crispgrid_link'] ) && $_POST['crispgrid_link'] ? 'on' : 'off';
		update_post_meta( $post_id, 'crispgrid_link', $crispgrid_link );

		if( isset( $_POST['crispgrid_link_text'] )) {
			update_post_meta( $post_id, 'crispgrid_link_text', esc_attr( $_POST['crispgrid_link_text'] ) );
		}

		if( isset( $_POST['crispgrid_bgcolor'] )) {
			update_post_meta( $post_id, 'crispgrid_bgcolor', esc_attr( $_POST['crispgrid_bgcolor'] ) );
		}

		if( isset( $_POST['crispgrid_color'] )) {
			update_post_meta( $post_id, 'crispgrid_color', esc_attr( $_POST['crispgrid_color'] ) );
		}

		if( isset( $_POST['crispgrid_bgcolor_hover'] )) {
			update_post_meta( $post_id, 'crispgrid_bgcolor_hover', esc_attr( $_POST['crispgrid_bgcolor_hover'] ) );
		}

		if( isset( $_POST['crispgrid_color_hover'] )) {
			update_post_meta( $post_id, 'crispgrid_color_hover', esc_attr( $_POST['crispgrid_color_hover'] ) );
		}
	}
}
?>