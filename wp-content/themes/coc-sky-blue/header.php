<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Coc-sky-blue
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'coc-sky-blue' ); ?></a>

	<header id="masthead" class="site-header">
        <nav id="site-navigation" class="main-navigation pull-right">
            <div class="site-title pull-left">
                <?php the_custom_logo(); ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
            </div>
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">{ - }</button>
            <div class="menu-items pull-right"><?php
                if (!is_user_logged_in()) {
                    wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                    ) );
                } else {
                    if ( current_user_can( 'manage_options' ) ) {
                        /* A user with admin privileges */
                        wp_nav_menu( array(
                            'theme_location' => 'menu-3',
                            'menu_id'        => 'primary-menu',
                        ) );
                    } else {
                        /* A user without admin privileges */
                        wp_nav_menu( array(
                            'theme_location' => 'menu-2',
                            'menu_id'        => 'primary-menu',
                        ) );
                    }
                }?>
            </div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
