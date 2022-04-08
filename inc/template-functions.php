<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package coolte
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function coolte_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
    global $post;
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    $global_layout = coolte_get_option( 'global_layout' );

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
      if ( $post && is_singular() ) {
          $post_options = get_post_meta( $post->ID, 'coolte-meta-select-layout', true );

          if (empty( $post_options ) ) {
              $global_layout = esc_attr( coolte_get_option('global_layout') );
          } else{
              $global_layout = esc_attr($post_options);
          }
      }

    if ($global_layout == 'left-sidebar') {
        $classes[]= 'left-sidebar';
    }
    elseif ($global_layout == 'no-sidebar') {
        $classes[]= 'no-sidebar';
    }
    else{
        $classes[]= 'right-sidebar';

    }

	return $classes;
}
add_filter( 'body_class', 'coolte_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function coolte_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'coolte_pingback_header' );


if ( ! function_exists( 'coolte_archive_title' ) ) :
    function coolte_archive_title( $title ) {
        if ( is_category() ) {
            $title = single_cat_title( '', false );
        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );
        } elseif ( is_author() ) {
            $title = '<span class="vcard">' . get_the_author() . '</span>';
        } elseif ( is_post_type_archive() ) {
            $title = post_type_archive_title( '', false );
        } elseif ( is_tax() ) {
            $title = single_term_title( '', false );
        }

        return $title;
    }
endif;
add_filter( 'get_the_archive_title', 'coolte_archive_title' );


/**
 * Returns word count of the sentences.
 *
 * @since coolte 1.0.0
 */
if (!function_exists('coolte_words_count')):
function coolte_words_count($length = 25, $coolte_content = null) {
    $length          = absint($length);
    $source_content  = preg_replace('`\[[^\]]*\]`', '', $coolte_content);
    $trimmed_content = wp_trim_words($source_content, $length, '');
    return $trimmed_content;
}
endif;


if( ! function_exists( 'coolte_excerpt_length' ) ) :

    /**
     * Excerpt length
     *
     * @since  coolte 1.0.0
     *
     * @param null
     * @return int
     */
    function coolte_excerpt_length( $length ){
        if ( is_admin() ) {
                return $length;
        }
        $excerpt_length = coolte_get_option('excerpt_length_global');
        if ( empty( $excerpt_length) ) {
            $excerpt_length = $length;
        }
        return absint( $excerpt_length );

    }

endif;
add_filter( 'excerpt_length', 'coolte_excerpt_length', 999 );

if (!function_exists('coolte_get_localized_variables')) :
    /**
     * Returns localized variable.
     *
     * @since 1.0.0
     *
     * return array localized variables
     */
    function coolte_get_localized_variables(){
        /*For Ajax Load Posts*/
        $args['nonce'] = wp_create_nonce( 'sb-load-more-nonce' );
        $args['ajaxurl'] = admin_url( 'admin-ajax.php' );


        if( is_front_page() ){
            $args['post_type'] = 'post';
        }

        /*Support for custom post types*/
        if( is_post_type_archive() ){
            $args['post_type'] = get_queried_object()->name;
        }
        /**/

        /*Support for categories and taxonomies*/
        if( is_category() || is_tag() || is_tax() ){
            $args['cat'] = get_queried_object()->slug;
            $args['taxonomy'] = get_queried_object()->taxonomy;
            /*Get the associated post type for custom taxonomy*/
            if( is_tax() ){
                global $wp_taxonomies;
                $tax_object = isset( $wp_taxonomies[$args['taxonomy']] ) ? $wp_taxonomies[$args['taxonomy']]->object_type : array();
                $args['post_type'] = array_pop($tax_object);
            }
            /**/
        }
        /**/

        /*Support for search*/
        if( is_search() ){
            $args['search'] = get_search_query();
        }
        /**/

        /*Support for author*/
        if( is_author() ){
            $args['author'] = get_the_author_meta( 'user_nicename' ) ;
        }
        /**/

        /*Support for date archive*/
        if( is_date() ){
            $args['year'] = get_query_var('year');
            $args['month'] = get_query_var('monthnum');
            $args['day'] = get_query_var('day');
        }
        /**/

        return $args;
    }
endif;

if( ! function_exists( 'coolte_recommended_plugins' ) ) :

  /**
   * Recommended plugins
   *
   */
  function coolte_recommended_plugins(){
      $coolte_plugins = array(
        array(
            'name'     => __('Social Share With Floating Bar', 'coolte'),
            'slug'     => 'social-share-with-floating-bar',
            'required' => false,
        ),
        array(
            'name'     => __( 'MailChimp for WordPress', 'coolte' ),
            'slug'     => 'mailchimp-for-wp',
            'required' => false,
        ),
        array(
            'name'      => esc_html__('Demo Import Kit','coolte'),
            'slug'      => 'demo-import-kit',
            'required'  => false,
        ),
        array(
            'name'      => esc_html__('Themeinwp Import Companion','coolte'),
            'slug'      => 'themeinwp-import-companion',
            'required'  => false,
        ),
      );
      $coolte_plugins_config = array(
          'dismissable' => true,
      );
      
      tgmpa( $coolte_plugins, $coolte_plugins_config );
  }
endif;
add_action( 'tgmpa_register', 'coolte_recommended_plugins' );


/* Display Breadcrumbs */
if (!function_exists('coolte_get_breadcrumb')) :

    /**
     * Simple breadcrumb.
     *
     * @since 1.0.0
     */
    function coolte_get_breadcrumb()
    {
        // Bail if Home Page.
        if (is_front_page() || is_home()) {
            return;
        }
        $breadcrumb_type = coolte_get_option( 'breadcrumb_type' );
        if ( 'disabled' === $breadcrumb_type ) {
            return;
        }

        if (!function_exists('breadcrumb_trail')) {

            /**
             * Load libraries.
             */

            require_once get_template_directory() . '/assets/libraries/breadcrumb-trail/breadcrumb-trail.php';
        }

        $breadcrumb_args = array(
            'container' => 'div',
            'show_browse' => false,
        ); ?>


        <div class="twp-breadcrumbs">
            <?php breadcrumb_trail($breadcrumb_args); ?>
        </div>


    <?php }

endif;
add_action('coolte_action_get_breadcrumb', 'coolte_get_breadcrumb');

if ( ! function_exists( 'coolte_display_posts_navigation' ) ) :

  /**
   * Display Pagination.
   *
   * @since 1.0.0
   */
  function coolte_display_posts_navigation() {

        $pagination_type = coolte_get_option( 'pagination_type', true );
        switch ( $pagination_type ) {

            case 'default':
                the_posts_navigation();
                break;

            case 'numeric':
                the_posts_pagination();
                break;
            default:
                break;
        }
    return;
  }

endif;

add_action( 'coolte_posts_navigation', 'coolte_display_posts_navigation' );

/**
 * CSS related hooks.
 *
 * This file contains hook functions which are related to CSS.
 *
 * @package coolte
 */

if (!function_exists('coolte_trigger_custom_css_action')) :

    /**
     * Do action theme custom CSS.
     *
     * @since 1.0.0
     */
function coolte_trigger_custom_css_action()
{
    $coolte_header_bg_color = coolte_get_option('header_bg_color');
    $coolte_header_text_color = coolte_get_option('header_text_color');
    $coolte_site_title_identity_color = coolte_get_option('site_title_identity_color');
    $background_color = get_background_color();
    ?>
        <style type="text/css">
            <?php
            if (!empty($coolte_site_title_identity_color) ){
                ?>
                body header.site-header .site-branding,
                body header.site-header .site-branding a,
                body header.site-header .site-branding a:visited,
                body header.site-header .site-branding a:hover{
                    color: <?php echo esc_html($coolte_site_title_identity_color); ?>;
                }
                
            <?php  } ?>  
            <?php
                if( !empty($coolte_header_text_color) ){
                ?>
                body .twp-nav-main-navigation i,
                body header.site-header ul.twp-social-icons.twp-social-icons-white a,
                body header.site-header ul.twp-social-icons.twp-social-icons-white a:visited,
                body header.site-header ul.twp-social-icons.twp-social-icons-white a:hover,
                body .twp-nav-main-navigation .twp-nav-right-content .twp-search-section i{
                    color: <?php echo esc_html($coolte_header_text_color); ?>
                }
                body .twp-nav-main-navigation .twp-menu-icon.twp-white-menu-icon span:before,
                body .twp-nav-main-navigation .twp-menu-icon.twp-white-menu-icon span:after{
                    background-color:  <?php echo esc_html($coolte_header_text_color); ?>
                } 
                body .twp-nav-main-navigation.sticky i,
                body header.site-header .sticky ul.twp-social-icons.twp-social-icons-white a,
                body header.site-header .sticky ul.twp-social-icons.twp-social-icons-white a:visited,
                body header.site-header .sticky ul.twp-social-icons.twp-social-icons-white a:hover,
                body .twp-nav-main-navigation.sticky .twp-nav-right-content .twp-search-section i{
                    color: #fff;
                }
                body .twp-nav-main-navigation.sticky .twp-menu-icon.twp-white-menu-icon span:before,
                body .twp-nav-main-navigation.sticky .twp-menu-icon.twp-white-menu-icon span:after{
                    background-color:  #fff;
                } 

            <?php } ?>
            <?php
                if( !empty(  $coolte_header_bg_color ) ){
                    ?>
                body header.site-header .wp-custom-header{
                    background-color: <?php echo esc_html( $coolte_header_bg_color ); ?>;
                }
            <?php  } ?>
            body .boxed-layout {
                background: <?php echo esc_html($background_color)?>;
            }
        </style>
<?php }
endif;

