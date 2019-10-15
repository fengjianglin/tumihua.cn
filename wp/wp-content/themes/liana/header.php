<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if(!get_theme_mod('liana_preloader') ): ?>
    <div id="st-preloader">
        <div id="pre-status">
            <div class="preload-placeholder"></div>
        </div>
    </div>
<?php endif; ?>
<!-- /Preloader -->

<header id="header">
	<div class="container">

		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$liana_description = get_bloginfo( 'description', 'display' );
			if ( $liana_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $liana_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<div id="navigation-wrapper" class="pull-right">
			<?php wp_nav_menu( array('container' => false, 'theme_location' => 'main-menu', 'menu_class' => 'menu')); ?>
		</div>
		<div class="menu-mobile"></div>
	</div>
</header>



