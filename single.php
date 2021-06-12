<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<main class="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?= get_template_part('post-formats/format', get_post_format()); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-not-found" class="hentry">
					<header class="article-header">
						<h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e('Try double running a search to find the post you\'re looking for.', 'bonestheme'); ?></p>
						<?= get_search_form() ?>
					</section>

				</article>

			<?php endif; ?>

		</main>

	</div>

</div>

<?php get_footer(); ?>