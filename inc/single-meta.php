<?php
/**
 * Implement theme metabox.
 *
 * @package coolte
 */

if ( ! function_exists( 'coolte_add_theme_meta_box' ) ) :

	/**
	 * Add the Meta Box
	 *
	 * @since 1.0.0
	 */
	function coolte_add_theme_meta_box() {

		$apply_metabox_post_types = array( 'post', 'page' );

		foreach ( $apply_metabox_post_types as $key => $type ) {
			add_meta_box(
				'coolte-theme-settings',
				esc_html__( 'Single Page/Post Settings', 'coolte' ),
				'coolte_render_theme_settings_metabox',
				$type
			);
		}

	}

endif;

add_action( 'add_meta_boxes', 'coolte_add_theme_meta_box' );

if ( ! function_exists( 'coolte_render_theme_settings_metabox' ) ) :

	/**
	 * Render theme settings meta box.
	 *
	 * @since 1.0.0
	 */
	function coolte_render_theme_settings_metabox( $post, $metabox ) {

		$post_id = $post->ID;
		$coolte_post_meta_value = get_post_meta($post_id);

		// Meta box nonce for verification.
		wp_nonce_field( basename( __FILE__ ), 'coolte_meta_box_nonce' );
		// Fetch Options list.
		$page_layout = get_post_meta($post_id,'coolte-meta-select-layout',true);
		$coolte_meta_image_checkbox = get_post_meta($post_id,'coolte-meta-image-checkbox',true);
		$coolte_meta_checkbox = get_post_meta($post_id,'coolte-meta-checkbox',true);
		

		?>

		<div class="coolte-tab-main">

            <div class="coolte-metabox-tab">
                <ul>
                    <li>
                        <a id="twp-tab-general" class="twp-tab-active" href="javascript:void(0)"><?php esc_html_e('Layout Settings', 'coolte'); ?></a>
                    </li>
                </ul>
            </div>

            <div class="coolte-tab-content">
                
                <div id="twp-tab-general-content" class="coolte-content-wrap coolte-tab-content-active">

                    <div class="coolte-meta-panels">

                        <div class="coolte-opt-wrap coolte-checkbox-wrap">

                            <input id="coolte-meta-image-checkbox" name="coolte-meta-image-checkbox" type="checkbox" <?php if ($coolte_meta_image_checkbox) { ?> checked="checked" <?php } ?> />

                            <label for="coolte-meta-image-checkbox"><?php esc_html_e('Check To Disable Featured Image From Banner', 'coolte'); ?></label>
                        </div>

                        <div class="coolte-opt-wrap coolte-checkbox-wrap">

                            <input id="coolte-meta-checkbox" name="coolte-meta-checkbox" type="checkbox" <?php if ($coolte_meta_checkbox) { ?> checked="checked" <?php } ?> />

                            <label for="coolte-meta-checkbox"><?php esc_html_e('Check To Enable Featured Image On Single Page', 'coolte'); ?></label>
                        </div>
                        
                        <div class="coolte-opt-wrap coolte-opt-wrap-alt">
                            <label><?php esc_html_e('Single Page/Post Layout', 'coolte'); ?></label>
                            <select name="coolte-meta-select-layout" id="coolte-meta-select-layout">
					            <option value="right-sidebar" <?php selected('right-sidebar',$page_layout);?>>
					            	<?php _e( 'Content - Primary Sidebar', 'coolte' )?>
					            </option>
					            <option value="left-sidebar" <?php selected('left-sidebar',$page_layout);?>>
					            	<?php _e( 'Primary Sidebar - Content', 'coolte' )?>
					            </option>
					            <option value="no-sidebar" <?php selected('no-sidebar',$page_layout);?>>
					            	<?php _e( 'No Sidebar', 'coolte' )?>
					            </option>
				            </select>
                        </div>


                    </div>
                </div>

            </div>
        </div>

    <?php
	}

endif;



if ( ! function_exists( 'coolte_save_theme_settings_meta' ) ) :

	/**
	 * Save theme settings meta box value.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 */
	function coolte_save_theme_settings_meta( $post_id, $post ) {

		// Verify nonce.
		if ( ! isset( $_POST['coolte_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['coolte_meta_box_nonce'], basename( __FILE__ ) ) ) {
			  return; }

		// Bail if auto save or revision.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check permission.
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return; }
		} else if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$coolte_meta_image_checkbox =  isset( $_POST[ 'coolte-meta-image-checkbox' ] ) ? esc_attr($_POST[ 'coolte-meta-image-checkbox' ]) : '';
		update_post_meta($post_id, 'coolte-meta-image-checkbox', sanitize_text_field($coolte_meta_image_checkbox));

		$coolte_meta_checkbox =  isset( $_POST[ 'coolte-meta-checkbox' ] ) ? esc_attr($_POST[ 'coolte-meta-checkbox' ]) : '';
		update_post_meta($post_id, 'coolte-meta-checkbox', sanitize_text_field($coolte_meta_checkbox));

		$coolte_meta_select_layout =  isset( $_POST[ 'coolte-meta-select-layout' ] ) ? esc_attr($_POST[ 'coolte-meta-select-layout' ]) : '';
		if(!empty($coolte_meta_select_layout)){
			update_post_meta($post_id, 'coolte-meta-select-layout', sanitize_text_field($coolte_meta_select_layout));
		}
	}

endif;

add_action( 'save_post', 'coolte_save_theme_settings_meta', 10, 3 );