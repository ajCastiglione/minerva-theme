<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<main id="main" class="" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="article-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</header>

						<section class="entry-content " itemprop="articleBody">
							<?php the_content(); ?>
						</section>

					</article>

			<?php endwhile;
			endif; ?>

		</main>

	</div>

</div>


<?php get_footer(); ?>