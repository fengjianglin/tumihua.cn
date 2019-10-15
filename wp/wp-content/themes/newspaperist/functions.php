<?php 


/** Load styles **/
add_action( 'wp_enqueue_scripts', 'newspaperist_enqueue_styles' );
function newspaperist_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
} 


/** New fonts **/
function newspaperist_google_fonts() {
	wp_enqueue_style( 'newspaperist-google-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', false ); 
}
add_action( 'wp_enqueue_scripts', 'newspaperist_google_fonts' );


/** New customizer options **/


function newspaperist_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'footer_settings', array(
		'title'      => __('Footer Settings','newspaperist'),
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		) );

	$wp_customize->add_setting( 'footer_headline_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_headline_color', array(
		'label'       => __( 'Headline Color', 'newspaperist' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_headline_color',
		) ) );
	$wp_customize->add_setting( 'footer_text_color', array(
		'default'           => '#656565',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color', array(
		'label'       => __( 'Text Color', 'newspaperist' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_text_color',
		) ) );
	$wp_customize->add_setting( 'footer_link_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_link_color', array(
		'label'       => __( 'Link Color', 'newspaperist' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_link_color',
		) ) );
	$wp_customize->add_setting( 'footer_border_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_border_color', array(
		'label'       => __( 'Border Color', 'newspaperist' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_border_color',
		) ) );

	$wp_customize->add_setting( 'footer_background_color', array(
		'default'           => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background_color', array(
		'label'       => __( 'Background Color', 'newspaperist' ),
		'section'     => 'footer_settings',
		'priority'   => 1,
		'settings'    => 'footer_background_color',
		) ) );
}
add_action( 'customize_register', 'newspaperist_customize_register' );

if(! function_exists('newspaperist_customizer_css' ) ):
	function newspaperist_customizer_css(){
		?>


		<style type="text/css">
		.site-info, .footer-column-three input.search-submit, .footer-column-three p, .footer-column-three li, .footer-column-three td, .footer-column-three th, .footer-column-three caption, .site-info { color: <?php echo esc_attr(get_theme_mod( 'footer_text_color')); ?>; }
		.footer-column-three h3, .footer-column-three h4, .footer-column-three h5, .footer-column-three h6, .footer-column-three h1, .footer-column-three h2, .footer-column-three h4, .footer-column-three h3 a { color: <?php echo esc_attr(get_theme_mod( 'footer_headline_color')); ?>; }
		.footer-column-three a, .footer-column-three li a, .footer-column-three .widget a, .footer-column-three .sub-arrow, .site-info a { color: <?php echo esc_attr(get_theme_mod( 'footer_link_color')); ?>; }
		.footer-column-three h3:after { background: <?php echo esc_attr(get_theme_mod( 'footer_border_color')); ?>; }
		.site-info, .widget ul li, .footer-column-three input.search-field, .footer-column-three input.search-submit { border-color: <?php echo esc_attr(get_theme_mod( 'footer_border_color')); ?>; }
		.site-footer { background-color: <?php echo esc_attr(get_theme_mod( 'footer_background_color')); ?>; }
		</style>
		<?php }
		add_action( 'wp_head', 'newspaperist_customizer_css' );
		endif;
