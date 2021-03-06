<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<main id="main" class="" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article">

						<header class="article-header">

							<h1 class="page-title"><?= the_title(); ?></h1>

						</header>

						<section class="entry-content" itemprop="articleBody">
							<?php the_content(); ?>

						</section>

						<footer class="article-footer">

						</footer>

					</article>

			<?php endwhile;
			endif; ?>

		</main>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>