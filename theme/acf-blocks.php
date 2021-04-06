<?php
add_action('acf/init', 'my_acf_init');
function my_acf_init()
{
    // Check if function exists and hook into setup.
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'ajax-blogs',
            'title'             => __('Ajax Blog Posts'),
            'description'       => __('Will display blog posts using AJAX to fetch more.'),
            'render_callback'   => 'my_acf_block_render_callback',
            'category'          => 'layout',
            'icon'              => 'admin-post',
            'mode'              => 'edit',
            'align'             => 'full',
            'keywords'          => array('blogs', 'posts', 'ajax blog', 'ajax posts'),
            'enqueue_style'     => get_stylesheet_directory_uri() . '/library/dist/ajax-blogs/ajax-blogs.css',
            'enqueue_script'    => get_stylesheet_directory_uri() . '/library/dist/ajax-blogs/ajax-blogs.min.js',
            'supports'           => array('fontSize' => true, 'color' => array('text' => true, 'background' => true))
        ));
    }
}

function my_acf_block_render_callback($block)
{
    // Name has to be equal to the file name after content
    $slug = str_replace('acf/', '', $block['name']);

    // include a template part from within the "template-parts/blocks" folder
    $path = get_template_directory() . "/blocks/{$slug}/{$slug}.php";
    if (file_exists($path)) {
        include($path);
    }
}
