<?php

//////////////////////////////////////////////////////////////////
// Customizer - Add Settings
//////////////////////////////////////////////////////////////////
function liana_register_theme_customizer( $wp_customize ) {
 	
	// Add Sections
	$wp_customize->add_section( 'liana_new_section_footer' , array(
   		'title'      => __('Footer Settings', 'liana'),
   		'priority'   => 103,
	) );
	$wp_customize->add_section( 'liana_new_section_page' , array(
   		'title'      => __('Page Settings', 'liana'),
   		'priority'   => 102,
	) );
	$wp_customize->add_section( 'liana_new_section_post' , array(
   		'title'      => __('Post Settings', 'liana'),
   		'priority'   => 101,
	) );
	
	$wp_customize->add_section( 'liana_new_section_general' , array(
   		'title'      => __('General Settings', 'liana'),
   		'priority'   => 100,
	) );
	$wp_customize->add_section( 'liana_new_section_social' , array(
   		'title'      => __('Social Media Settings', 'liana'),
   		'description'=> __('Enter your social media usernames. Icons will not show if left blank.', 'liana'),
   		'priority'   => 99,
	) );
	
	
	
	// Add Setting
		
		// General

		$wp_customize->add_setting(
	        'liana_home_layout',
	        array(
	            'default'     => 'rightsidebar',
	            'sanitize_callback' => 'liana_sanitize_select'
	        )
	    );

		$wp_customize->add_setting(
	        'liana_blog_pagination',
	        array(
	            'default'     => 'pagination',
	            'sanitize_callback' => 'liana_sanitize_select'
	        )
	    );

		$wp_customize->add_setting(
	        'liana_preloader',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );

		
		
		// Post Settings
		$wp_customize->add_setting(
	        'liana_post_author_name',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
	    $wp_customize->add_setting(
	        'liana_post_date',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
	    $wp_customize->add_setting(
	        'liana_post_comment',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
	    $wp_customize->add_setting(
	        'liana_post_cat',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
	    $wp_customize->add_setting(
	        'liana_post_tags',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_post_author',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
	    $wp_customize->add_setting(
	        'liana_post_nav',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_post_related',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );

	    // Social Media for About Me

		$wp_customize->add_setting(
	        'liana_footer_social_check',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
		
		$wp_customize->add_setting(
	        'liana_facebook',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_twitter',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_google',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_youtube',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_skype',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_pinterest',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_flickr',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_linkedin',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_xing',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_vimeo',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_instagram',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_dribbble',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_tumblr',
	        array(
	            'default'     => '',
	            'sanitize_callback' => 'esc_url_raw'
	        )
	    );
		
		
		// Page Settings
		$wp_customize->add_setting(
	        'liana_page_comments',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_page_layout',
	        array(
	            'default'     => 'rightsidebar',
	            'sanitize_callback' => 'liana_sanitize_select'
	        )
	    );


		
		// Footer Options
		$wp_customize->add_setting(
	        'liana_back_to_top',
	        array(
	            'default'     => false,
	            'sanitize_callback' => 'liana_sanitize_checkbox'
	        )
	    );
		$wp_customize->add_setting(
	        'liana_footer_copyright',
	        array(
	            'sanitize_callback' => 'wp_kses_data'
	        )
	    );
		
		// Color Options

			// Color general
			$wp_customize->add_setting(
				'liana_theme_color',
				array(
					'default'     => '#6fb98f',
					'sanitize_callback' => 'sanitize_hex_color'
				)
			);
			$wp_customize->add_setting(
				'liana_anchor_color',
				array(
					'default'     => '#777',
					'sanitize_callback' => 'sanitize_hex_color'
				)
			);
			$wp_customize->add_setting(
				'liana_anchor_hover_color',
				array(
					'default'     => '#6fb98f',
					'sanitize_callback' => 'sanitize_hex_color'
				)
			);


    // Add Control
		
		// General
		
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_home_layout',
				array(
					'label'          => __('Homepage Layout', 'liana'),
					'section'        => 'liana_new_section_general',
					'settings'       => 'liana_home_layout',
					'type'           => 'radio',
					'priority'	 => 2,
					'choices'        => array(
						'full'   => __('Full Posts', 'liana'),
						'rightsidebar'  => __('Right Sidebar', 'liana')
					)
				)
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_blog_pagination',
				array(
					'label'          => __('Blog Pagination or Navigation', 'liana'),
					'section'        => 'liana_new_section_general',
					'settings'       => 'liana_blog_pagination',
					'type'           => 'radio',
					'priority'	 => 3,
					'choices'        => array(
						'pagination'   => __('Pagination', 'liana'),
						'navigation'  => __('Navigation', 'liana')
					)
				)
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_preloader',
				array(
					'label'      => __('Disable Preloader', 'liana'),
					'section'    => 'liana_new_section_general',
					'settings'   => 'liana_preloader',
					'type'		 => 'checkbox',
					'priority'	 => 4
				)
			)
		);
		
		
		
		// Post Settings

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_post_author_name',
				array(
					'label'      => __('Hide Author Name', 'liana'),
					'section'    => 'liana_new_section_post',
					'settings'   => 'liana_post_author_name',
					'type'		 => 'checkbox',
					'priority'	 => 1
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_post_date',
				array(
					'label'      => __('Hide Date', 'liana'),
					'section'    => 'liana_new_section_post',
					'settings'   => 'liana_post_date',
					'type'		 => 'checkbox',
					'priority'	 => 2
				)
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_post_cat',
				array(
					'label'      => __('Hide Category', 'liana'),
					'section'    => 'liana_new_section_post',
					'settings'   => 'liana_post_cat',
					'type'		 => 'checkbox',
					'priority'	 => 3
				)
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_post_tags',
				array(
					'label'      => __('Hide Tags', 'liana'),
					'section'    => 'liana_new_section_post',
					'settings'   => 'liana_post_tags',
					'type'		 => 'checkbox',
					'priority'	 => 4
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_post_author',
				array(
					'label'      => __('Hide Author Box', 'liana'),
					'section'    => 'liana_new_section_post',
					'settings'   => 'liana_post_author',
					'type'		 => 'checkbox',
					'priority'	 => 5
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_post_nav',
				array(
					'label'      => __('Hide Next/Prev Post Navigation', 'liana'),
					'section'    => 'liana_new_section_post',
					'settings'   => 'liana_post_nav',
					'type'		 => 'checkbox',
					'priority'	 => 6
				)
			)
		);
		
		
		// Page settings
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_page_comments',
				array(
					'label'      => __('Hide Comments', 'liana'),
					'section'    => 'liana_new_section_page',
					'settings'   => 'liana_page_comments',
					'type'		 => 'checkbox',
					'priority'	 => 1
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_page_layout',
				array(
					'label'          => __('Page Layout', 'liana'),
					'section'        => 'liana_new_section_page',
					'settings'       => 'liana_page_layout',
					'type'           => 'radio',
					'priority'	 => 2,
					'choices'        => array(
						'full'   => __('Fullwidth', 'liana'),
						'rightsidebar'  => __('Right Sidebar', 'liana')
					)
				)
			)
		);
		
		// Footer Settings

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_back_to_top',
				array(
					'label'      => __('Disable Back to top', 'liana'),
					'section'    => 'liana_new_section_footer',
					'settings'   => 'liana_back_to_top',
					'type'		 => 'checkbox',
					'priority'	 => 1
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_footer_copyright',
				array(
					'label'      => __('Footer Copyright Text', 'liana'),
					'section'    => 'liana_new_section_footer',
					'settings'   => 'liana_footer_copyright',
					'type'		 => 'textarea',
					'priority'	 => 2
				)
			)
		);

		// Social Media
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_footer_social_check',
				array(
					'label'      => __('Disable Social Icons', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_footer_social_check',
					'type'		 => 'checkbox',
					'priority'	 => 1
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_facebook',
				array(
					'label'      => __('Facebook', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_facebook',
					'type'		 => 'url',
					'priority'	 => 2
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_twitter',
				array(
					'label'      => __('Twitter', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_twitter',
					'type'		 => 'url',
					'priority'	 => 3
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_google',
				array(
					'label'      => __('Google Plus', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_google',
					'type'		 => 'url',
					'priority'	 => 4
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_youtube',
				array(
					'label'      => __('Youtube', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_youtube',
					'type'		 => 'url',
					'priority'	 => 5
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_skype',
				array(
					'label'      => __('Skype', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_skype',
					'type'		 => 'url',
					'priority'	 => 6
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_pinterest',
				array(
					'label'      => __('Pinterest', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_pinterest',
					'type'		 => 'url',
					'priority'	 => 7
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_flickr',
				array(
					'label'      => __('Flickr', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_flickr',
					'type'		 => 'url',
					'priority'	 => 8
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_linkedin',
				array(
					'label'      => __('Linkedin', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_linkedin',
					'type'		 => 'url',
					'priority'	 => 9
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_xing',
				array(
					'label'      => __('Xing', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_xing',
					'type'		 => 'url',
					'priority'	 => 10
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_vimeo',
				array(
					'label'      => __('Vimeo', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_vimeo',
					'type'		 => 'url',
					'priority'	 => 11
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_instagram',
				array(
					'label'      => __('Instagram', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_instagram',
					'type'		 => 'url',
					'priority'	 => 12
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_dribbble',
				array(
					'label'      => __('Dribbble', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_dribbble',
					'type'		 => 'url',
					'priority'	 => 13
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'liana_tumblr',
				array(
					'label'      => __('Tumblr', 'liana'),
					'section'    => 'liana_new_section_social',
					'settings'   => 'liana_tumblr',
					'type'		 => 'url',
					'priority'	 => 14
				)
			)
		);
		
		// Color Settings
			
			// Colors general
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'liana_theme_color',
					array(
						'label'      => __('Theme Color', 'liana'),
						'section'    => 'colors',
						'settings'   => 'liana_theme_color',
						'priority'	 => 1
					)
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'liana_anchor_color',
					array(
						'label'      => __('Anchor Color', 'liana'),
						'section'    => 'colors',
						'settings'   => 'liana_anchor_color',
						'priority'	 => 2
					)
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'liana_anchor_hover_color',
					array(
						'label'      => __('Anchor Hover Color', 'liana'),
						'section'    => 'colors',
						'settings'   => 'liana_anchor_hover_color',
						'priority'	 => 3
					)
				)
			);
	
 
}
add_action( 'customize_register', 'liana_register_theme_customizer' );
?>