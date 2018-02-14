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
 */

$options = get_option('kns_options');

if( isset( $options['kns_default_layout'] ) 
		&& ($options['kns_default_layout'] == 'sidebar')
) {
	get_template_part('page','sidebar');
}
else {  // デフォルト
	get_template_part('page','content');
}