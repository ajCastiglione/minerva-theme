<?php
/**
 * Ajax Blogs Template.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'ajax-blogs-block';

// Create class attribute allowing for custom "className" and "align" values.
$className = 'ajax-blogs';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
if ( ! empty( $block['backgroundColor'] ) ) {
	$className .= " bg-$block[backgroundColor]";
}
if ( ! empty( $block['textColor'] ) ) {
	$className .= " txt-$block[backgroundColor]";
}

// Load values and assign defaults.
$posts_per_page = intval( get_field( 'per_page' ) );
$paged          = ( get_query_var( 'paged' ) ) ?: 1;

$args  = array(
	'post_type'      => 'post',
	'paged'          => $paged,
	'posts_per_page' => $posts_per_page,
);
$blogs = new WP_Query( $args );

$template = null;
if ( file_exists( get_template_directory() . '/template-parts/blog/post.php' ) ) {
	$template = 'template-parts/blog/post';
} else {
	$template = 'blocks/ajax-blogs/post';
}

?>
<section id="<?php echo esc_attr( $id ); ?>">
	<div class="<?php echo esc_attr( $className ); ?>">

		<div class="ajax-blogs__posts" data-page="<?php echo get_query_var( 'paged' ) ?: 1; ?>" data-max="<?php echo $blogs->max_num_pages; ?>" data-per="<?php echo $posts_per_page; ?>">

			<?php
			if ( $blogs->have_posts() ) :
				while ( $blogs->have_posts() ) :
					$blogs->the_post();
					?>
					<?php echo get_template_part( $template ); ?>
							<?php
			endwhile;
			endif;
			?>

		</div>

		<button class="ajax-blogs__load-more btn">Load More</button>

	</div>
</section>
