<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<main id="main" class="" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?= get_template_part('post-formats/format', get_post_format()); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-not-found" class="hentry">
					<header class="article-header">
						<h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e('Uh Oh. Something is missing. Try double checking things.', 'bonestheme'); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e('This is the error message in the single.php template.', 'bonestheme'); ?></p>
					</footer>
				</article>

			<?php endif; ?>

		</main>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>