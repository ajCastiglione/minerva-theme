<?php
add_action('acf/init', 'my_acf_init');
function my_acf_init()
{
    // Check if function exists and hook into setup.
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'testimonial',
            'title'             => __('Testimonial'),
            'description'       => __('A testimonial block.'),
            'render_callback'   => 'my_acf_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array('testimonial', 'quote'),
        ));
    }
}

function my_acf_block_render_callback($block)
{
    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    // Name has to be equal to the file name after content
    $slug = str_replace('acf/', '', $block['name']);

    // include a template part from within the "template-parts/blocks" folder
    $path = get_template_directory() . "/library/blocks/{$slug}/{$slug}.php";
    if (file_exists($path)) {
        include($path);
    }
}
