<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<main class="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

						<header class="article-header">
							<h1 class="page-title"><?= the_title(); ?></h1>
						</header>

						<section class="entry-content">
							<?php the_content(); ?>
						</section>

					</article>

			<?php endwhile;
			endif; ?>

		</main>

	</div>

</div>

<?php get_footer(); ?>