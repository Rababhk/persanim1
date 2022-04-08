<?php
/**
 * slider section
 *
 * @package coolte
 */

$default = coolte_get_default_theme_options();
// Header Main Section.
$wp_customize->add_section( 'header_section_settings',
	array(
		'title'      => __( 'Header Option', 'coolte' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting - enable_search_section.
$wp_customize->add_setting( 'enable_search_section',
	array(
		'default'           => $default['enable_search_section'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'coolte_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'enable_search_section',
	array(
		'label'    => __( 'Enable Search On Top', 'coolte' ),
		'section'  => 'header_section_settings',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);

// Setting - enable_dark_light_section.
$wp_customize->add_setting( 'enable_dark_light_section',
	array(
		'default'           => $default['enable_dark_light_section'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'coolte_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'enable_dark_light_section',
	array(
		'label'    => __( 'Enable Dark and Light Mode', 'coolte' ),
		'section'  => 'header_section_settings',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);


// Setting - enable_social_menu_section.
$wp_customize->add_setting( 'enable_social_menu_section',
	array(
		'default'           => $default['enable_social_menu_section'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'coolte_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'enable_social_menu_section',
	array(
		'label'    => __( 'Enable Social Menu', 'coolte' ),
		'section'  => 'header_section_settings',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);



// Slider Main Section.
$wp_customize->add_section( 'main_banner_section_settings',
	array(
		'title'      => __( 'Main Banner Section', 'coolte' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting - show_main_banner_section.
$wp_customize->add_setting( 'show_main_banner_section',
	array(
		'default'           => $default['show_main_banner_section'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'coolte_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'show_main_banner_section',
	array(
		'label'    => __( 'Enable Main Banner', 'coolte' ),
		'section'  => 'main_banner_section_settings',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);

$wp_customize->add_setting( 'coolte_banner_slider_section',
	array(
		'default'           => $default['coolte_banner_slider_section'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'coolte_banner_slider_section',
	array(
		'label'    => __( 'Slider Section Title Text', 'coolte' ),
		'section'  => 'main_banner_section_settings',
		'type'     => 'text',
		'priority' => 100,
	)
);

// Setting - drop down category for exclusive section.
$wp_customize->add_setting( 'select_category_for_slider_section',
	array(
		'default'           => $default['select_category_for_slider_section'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control( new coolte_Dropdown_Taxonomies_Control( $wp_customize, 'select_category_for_slider_section',
	array(
        'label'           => __( 'Category for Slider Section', 'coolte' ),
        'description'     => __( 'Select category to be shown on slider section on your banner ', 'coolte' ),
        'section'         => 'main_banner_section_settings',
        'type'            => 'dropdown-taxonomies',
        'taxonomy'        => 'category',
		'priority'    	  => 100,
    ) ) );


/*content excerpt in Slider*/
$wp_customize->add_setting( 'number_of_content_home_slider',
	array(
		'default'           => $default['number_of_content_home_slider'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'coolte_sanitize_positive_integer',
	)
);
$wp_customize->add_control( 'number_of_content_home_slider',
	array(
		'label'    => __( 'Select no words on Slider Section', 'coolte' ),
		'section'  => 'main_banner_section_settings',
		'type'     => 'number',
		'priority' => 100,
		'input_attrs'     => array( 'min' => 1, 'max' => 200, 'style' => 'width: 150px;' ),

	)
);