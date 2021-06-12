<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<main class="main">

			<article id="post-not-found" class="hentry">

				<header class="article-header">
					<h1><?php _e('404 - Page Not Found', 'bonestheme'); ?></h1>
				</header>

				<section class="entry-content">
					<p><?php _e('The Page you were looking for was not found, but maybe try looking again!', 'bonestheme'); ?></p>
				</section>

				<section class="search">
					<p><?php get_search_form(); ?></p>
				</section>

			</article>

		</main>

	</div>

</div>

<?php get_footer(); ?>