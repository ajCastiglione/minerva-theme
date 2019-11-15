<?php
/* external-libraries.php
 * Descripion: adds settings and controllers for bootstrap grid, wow.js & animate, 
 * font awesome & hover.css to theme customizer 
 */
 
 function add_external_libraries($wp_customize){
 
//panel
	$wp_customize->add_section( 
			'external-libraries' , 
			array(
				'title'      => __( 'External Libraries', 'bonestheme' ),
				'description' => '',
				'priority'   => 30,
				
		) 
	);
 }
 add_action( 'customize_register', 'add_external_libraries' );
 
 
 ?>