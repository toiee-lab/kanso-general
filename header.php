<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kanso-general
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
    <div class="uk-offcanvas-content">
		<div id="kns-head" class="uk-background-cover uk-background-center-center">		
		    <div uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; cls-inactive: uk-navbar-transparent uk-light; show-on-up: true">		
		        <nav class="uk-navbar-container">
		            <div class="uk-container uk-container-expand">
		                <div uk-navbar>
			                <div class="uk-navbar-left">
				                <?php
									the_custom_logo();
								?>
			                </div>
			                <div class="uk-navbar-right">
          						<?php
									wp_nav_menu( array(
										'theme_location' => 'menu-1',
										'menu_id'        => 'primary-menu',
										'menu_class'     => 'uk-navbar-nav uk-visible@m',
										'container'      => false,
									) );
								?>
				                    <ul class="uk-navbar-nav">
			                        <li><a href="#sidebar" uk-toggle><span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span></a></li>
			                    </ul>			                    
			                </div>
		                </div>
		            </div>
		        </nav>
		    </div>
		    <div id="kns-header" class="uk-light" style="">
			    <div id="hns-header-text">
				    <h1 class="uk-heading-divider">Great teacher inspires</h1>
				    <h2>become a great teacher together</h2>
			    </div>
		    </div>
		</div><!-- #kns-head -->
		
			

