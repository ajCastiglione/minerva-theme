<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>
		<?php wp_title( '' ); ?>
	</title>

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
	<meta name="msapplication-TileColor" content="#f01d4f">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
	<meta name="theme-color" content="#121212">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="container">

		<header class="header">

			<div id="inner-header" class="wrap">

				<div class="header-left">
					<a href="<?php echo home_url(); ?>" rel="nofollow">
						<img src="" id="logo" class="h1">
					</a>
				</div>

				<div class="header-right">
					<nav role="navigation">
						<?php
						wp_nav_menu(
							array(
								'container'       => false,
								'container_class' => 'menu',
								'menu'            => __( 'The Main Menu', 'bonestheme' ),
								'menu_class'      => 'nav top-nav',
								'theme_location'  => 'main-nav',
								'depth'           => 2,
							)
						);
						?>
					</nav>
				</div>

			</div>

		</header>
