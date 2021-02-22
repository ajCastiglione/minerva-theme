<?php
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
add_action('wp_ajax_load_more_posts', 'load_more_posts');

function load_more_posts()
{
    $next_page = $_POST['current_page'] + 1;
    $per_page = $_POST['posts_per_page'];
    $offset_start = 1;
    $offset = ($next_page - 1) * $per_page + $offset_start;
    $args = [
        'post_type' => 'post',
        'paged' => $next_page,
        'posts_per_page' => $per_page,
        'offset' => $offset
    ];
    $query = new WP_Query($args);

    if ($query->have_posts()) :

        ob_start();

        while ($query->have_posts()) : $query->the_post();

            if (file_exists(get_template_directory() . '/template-parts/blog/post.php')) {
                get_template_part('template-parts/blog/post');
            } else {
                get_template_part('blocks/ajax-blogs/post');
            }

        endwhile;

        wp_send_json_success(ob_get_clean());

    else :

        wp_send_json_error('<p class="alert-error">No more posts!</p>');

    endif;
}
