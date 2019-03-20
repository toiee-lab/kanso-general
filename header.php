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
<?php
if ( is_front_page() ) :
	?>
	<div id="kns-head" class="uk-background-cover uk-background-center-center">
		<div id="kns-head-nav-front" uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky kns-navbar-sticky; cls-inactive: uk-navbar-transparent kns-navbar-top-front; show-on-up: true">
			<nav class="uk-navbar-container">
				<div class="uk-container uk-container-expand">
					<div uk-navbar>
						<div class="uk-navbar-left">
							<?php
							if ( has_custom_logo() ) {
								$_logo_html = get_custom_logo();
								echo esc_html( $_logo_html );
							} else {
								echo '<a href="' . esc_html( get_bloginfo( 'url' ) ) . '" class="uk-link-reset uk-text-large uk-margin-left ">' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</a>';
							}
							?>
						</div>
						<div class="uk-navbar-right">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
									'menu_class'     => 'uk-navbar-nav uk-visible@m',
									'container'      => false,
									'fallback_cb'    => '',
								)
							);
							?>
							<?php
							$uk_visible = '';
							if ( kns_get_template() === 'sidebar' ) {
								$uk_visible = 'uk-hidden@m';
							}
							?>
							<ul class="uk-navbar-nav <?php echo esc_html( $uk_visible ); ?>">
								<li><a href="#sidebar" uk-toggle><span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</nav>
		</div>
		<div id="kns-header">
			<div id="kns-header-text" class="uk-padding-small">
				<h1 id="kanso_general_options_htitle"><?php echo esc_html( get_option( 'kanso_general_options_htitle' ) ); ?></h1>
				<h2 id="kanso_general_options_hsubtitle"><?php echo esc_html( get_option( 'kanso_general_options_hsubtitle' ) ); ?></h2>
			</div>
		</div>
	</div>
	<?php
else :
	?>
	<div id="kns-head-nav" uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-inactive: kns-navbar-top; cls-active: uk-navbar-sticky kns-navbar-sticky ; show-on-up: true">
		<nav class="uk-navbar-container">
			<div class="uk-container uk-container-expand">
				<div uk-navbar>
					<div class="uk-navbar-left">
						<?php
						if ( has_custom_logo() ) {
							$_logo_html = get_custom_logo();
							echo esc_html( $_logo_html );
						} else {
							echo '<a href="' . esc_html( get_bloginfo( 'url' ) ) . '" class="uk-link-reset uk-text-large uk-margin-left ">' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</a>';
						}
						?>
					</div>
					<div class="uk-navbar-right">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'uk-navbar-nav uk-visible@m',
								'container'      => false,
								'fallback_cb'    => '',
							)
						);
						?>
						<?php
						$uk_visible = '';
						if ( kns_get_template() === 'sidebar' ) {
							$uk_visible = 'uk-hidden@m';
						}
						?>
						<ul class="uk-navbar-nav <?php echo esc_html( $uk_visible ); ?>">
							<li><a href="#sidebar" uk-toggle><span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</div>
	<?php
endif;
?>
<!-- end header -->



