<?php
/*
 Template Name: Home Page Template
 *
 * This is going to be based on how I typically create home page templates.
 * It will have some default tie-ins with ACF for ease of use in the backend for those who arent
 * comfortable modifying templates directly. 
 * Of course you can scrap everything if it suits your use-case.
 * 
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

<!-- Banner Area -->
<section class="banner-section" style="background-image:url(<?php $img = get_field('banner_image'); if(!empty($img)) : echo $img['url']; else : echo get_template_directory_uri() . '/library/images/default-bg.jpg'; endif;  ?>);">
	<div class="banner-content-container wrap">
		<h1 class="banner-title"><?php echo get_field('banner_title'); ?></h1>
		<p class="banner-content"><?php echo get_field('banner_content'); ?></p>
		<div class="banner-cta-box">
			<a class="banner-cta" href="<?php echo get_field('banner_link'); ?>"><?php echo get_field('banner_cta'); ?></a>
		</div>
	</div>
</section>

<!-- end Banner Area -->


			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="cf col-xs-12 col-sm-8 col-lg-8" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">
									<h1 class="page-title"><?php the_title(); ?></h1>
								</header>

								<section class="entry-content cf" itemprop="articleBody">
									<?php the_content(); ?>
								</section>

							</article>

							<?php endwhile; endif; ?>

						</main>

						<?php get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
