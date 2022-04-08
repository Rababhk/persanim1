<?php
/**
 * Default theme options.
 *
 * @package coolte
 */

if ( ! function_exists( 'coolte_get_default_theme_options' ) ) :

	/**
	 * Get default theme options
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function coolte_get_default_theme_options() {

		$defaults = array();

		//header top bar
		$defaults['enable_search_section']		= 1;
		$defaults['enable_dark_light_section']		= 1;
		$defaults['enable_social_menu_section']		= 1;
		
		$defaults['enable_header_overlay']		= 1;
		$defaults['header_text_color']			= '#fff';
		$defaults['header_bg_color']			= '#000';
		
		$defaults['site_title_identity_color']		= '#fff';
		
		// Slider options.
		$defaults['show_main_banner_section']				    = 1;
		$defaults['coolte_banner_slider_section']			= esc_html__( 'Top Stories', 'coolte' );
		$defaults['select_category_for_slider_section']			= '';
		$defaults['number_of_home_slider']						= 6;
		$defaults['number_of_content_home_slider']				= 0;

		// Single post options.
		$defaults['enable_except_on_single_post'] 	= 1;
		$defaults['enable_authro_detail_single_page'] 	= 1;
		$defaults['enable_related_post_on_single_page'] 	= 1;
        $defaults['single_related_post_title']                   = esc_html__('You May Like', 'coolte');
		$defaults['number_of_single_related_post'] = 6;


		// featured_blog section
		$defaults['show_featured_category_section']			= 1;
		$defaults['select_category_for_featured_category']	= 0;
		$defaults['number_of_post_featured_category']		= 5;


		//Layout options.
		$defaults['site_date_layout_option']		= 'in-time-span';
		$defaults['global_layout']					= 'right-sidebar';
		$defaults['excerpt_length_global']			= 25;
		$defaults['pagination_type']				= 'default';
		$defaults['enable_copyright_credit']     	= 1;
		$defaults['copyright_text']					= esc_html__( 'Copyright All right reserved', 'coolte' );
		$defaults['number_of_footer_widget']		= 3;
		$defaults['enable_mailchimp_suscription']	= 1;
		$defaults['mailchimp_suscription_title']	= esc_html__( 'Suscribe Us Now', 'coolte' );
		$defaults['mailchimp_suscription_shortcode']	= '';
		$defaults['enable_site_logo_on_footer']	= 1;

		$defaults['breadcrumb_type']				= 'simple';
		$defaults['enable_preloader']				= 1;

		// Pass through filter.
		$defaults = apply_filters( 'coolte_filter_default_theme_options', $defaults );

		return $defaults;

	}

endif;
