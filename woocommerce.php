<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kanso-general
 *
 * Template Name: コンテンツのみ
 */

get_header(); ?>
		<div class="uk-container uk-container-small uk-background-default main-content">
			<?php woocommerce_breadcrumb(); ?>
			<?php
				woocommerce_content();
			?>			
			
		</div><!-- .main-content -->


<?php
get_sidebar();
get_footer();
