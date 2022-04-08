<?php 
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function coolte_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Menu Sidebar', 'coolte' ),
		'id'            => 'menu-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'coolte' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'coolte' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'coolte' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );



	$coolte_footer_widgets_number = coolte_get_option('number_of_footer_widget');
	if( $coolte_footer_widgets_number > 0 ){
	    register_sidebar(array(
	        'name' => __('Footer Column One', 'coolte'),
	        'id' => 'footer-col-one',
	        'description' => __('Displays items on footer section.','coolte'),
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	        'after_widget' => '</div>',
	        'before_title'  => '<h3 class="widget-title">',
	        'after_title'   => '</h3>',
	    ));
	    if( $coolte_footer_widgets_number > 1 ){
	        register_sidebar(array(
	            'name' => __('Footer Column Two', 'coolte'),
	            'id' => 'footer-col-two',
	            'description' => __('Displays items on footer section.','coolte'),
	            'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '</div>',
	            'before_title'  => '<h3 class="widget-title">',
	            'after_title'   => '</h3>',
	        ));
	    }
	    if( $coolte_footer_widgets_number > 2 ){
	        register_sidebar(array(
	            'name' => __('Footer Column Three', 'coolte'),
	            'id' => 'footer-col-three',
	            'description' => __('Displays items on footer section.','coolte'),
	            'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '</div>',
	            'before_title'  => '<h3 class="widget-title">',
	            'after_title'   => '</h3>',
	        ));
	    }
	    if( $coolte_footer_widgets_number > 3 ){
	        register_sidebar(array(
	            'name' => __('Footer Column Four', 'coolte'),
	            'id' => 'footer-col-four',
	            'description' => __('Displays items on footer section.','coolte'),
	            'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '</div>',
	            'before_title'  => '<h3 class="widget-title">',
	            'after_title'   => '</h3>',
	        ));
	    }
	}
}
add_action( 'widgets_init', 'coolte_widgets_init' );
