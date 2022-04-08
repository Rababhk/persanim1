<?php

/**
 * coolte About Page
 * @package coolte
 *
*/

if( !class_exists('coolte_About_page') ):

	class coolte_About_page{

		function __construct(){

			add_action('admin_menu', array($this, 'coolte_backend_menu'),999);

		}

		// Add Backend Menu
        function coolte_backend_menu(){

            add_theme_page(esc_html__( 'coolte Options','coolte' ), esc_html__( 'coolte Options','coolte' ), 'activate_plugins', 'coolte-about', array($this, 'coolte_main_page'));

        }

        // Settings Form
        function coolte_main_page(){

            require get_template_directory() . '/classes/about-render.php';

        }

	}

	new coolte_About_page();

endif;