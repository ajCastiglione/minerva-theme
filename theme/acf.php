<?php

/**
 * ACF Blocks
 */
add_action( 'acf/init', 'my_acf_init' );
function my_acf_init() {
	// Check if function exists and hook into setup.
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type(
			array(
				'name'            => 'ajax-blogs',
				'title'           => __( 'Ajax Blog Posts' ),
				'description'     => __( 'Will display blog posts using AJAX to fetch more.' ),
				'render_callback' => 'my_acf_block_render_callback',
				'category'        => 'layout',
				'icon'            => 'admin-post',
				'mode'            => 'edit',
				'align'           => 'full',
				'keywords'        => array( 'blogs', 'posts', 'ajax blog', 'ajax posts' ),
				'supports'        => array(
					'fontSize' => true,
					'color'    => array(
						'text'       => true,
						'background' => true,
					),
				),
			)
		);
	}
}

function my_acf_block_render_callback( $block ) {
	// Name has to be equal to the file name after content
	$slug = str_replace( 'acf/', '', $block['name'] );

	// include a template part from within the "template-parts/blocks" folder
	$path = get_template_directory() . "/blocks/{$slug}/{$slug}.php";
	if ( file_exists( $path ) ) {
		include $path;
	}
}

/**
 * ACF Options Page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
}

/**
 * ACF saves
 */


add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

function my_acf_json_save_point( $path ) {
	// update path
	$path = get_stylesheet_directory() . '/acf-json';

	// return
	return $path;
}

add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );

function my_acf_json_load_point( $paths ) {
	 // remove original path (optional)
	unset( $paths[0] );

	// append path
	$paths[] = get_stylesheet_directory() . '/acf-json';

	// return
	return $paths;
}
