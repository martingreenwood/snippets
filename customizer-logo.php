<?php

	// Adds logo to customiser
	$wp_customize->add_section( 'lvy_logo_section' , array(
		'title'       => __( 'Logo', 'lvy' ),
		'priority'    => 30,
		'description' => 'Upload a logo to replace the default site name and description in the header',
	));
	$wp_customize->add_setting( 'lvy_logo' );
	$wp_customize->add_setting( 'lvy_logo_width', array( 'default' => '60' ));
	$wp_customize->add_setting( 'lvy_logo_height', array( 'default' => '39' ));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'lvy_logo', array(
		'label'    => __( 'Logo', 'lvy' ),
		'section'  => 'lvy_logo_section',
		'settings' => 'lvy_logo',
	)));
	$wp_customize->add_control( 'lvy_logo_width',
		array(
			'label' => 'Width',
			'section' => 'lvy_logo_section',
			'type' => 'text',
		)
	);
	$wp_customize->add_control( 'lvy_logo_height',
		array(
			'label' => 'Height',
			'section' => 'lvy_logo_section',
			'type' => 'text',
		)
	);