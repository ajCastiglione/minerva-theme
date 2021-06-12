<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<main class="main">

			<?php
			if (have_posts()) : while (have_posts()) : the_post();

					get_template_part('template-parts/blog/post');

				endwhile;

				bones_page_navi();

			else : ?>

				<article id="post-not-found" class="hentry">
					<header class="article-header">
						<h1><?php _e('No posts found!', 'bonestheme'); ?></h1>
					</header>
				</article>

			<?php endif; ?>

		</main>

	</div>

</div>


<?php get_footer(); ?>