<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kanso-general
 */

?>
<?php
if ( is_home() || is_front_page() ) {
	echo '';
} else {
	$the_id = get_the_ID();
	get_template_part( 'template-parts/breadcrumb', 'page' );

	if ( true !== get_field( 'kns_hide_title' ) ) {
		the_title( '<h1 class="main-title">', '</h1>' );
		the_subtitle( '<h2 class="main-subtitle">', '</h2>' );
	}

	if ( true !== get_field( 'kns_hide_thumbnail' ) ) {
		kanso_general_post_thumbnail();
	}
}

the_content();

if ( ! is_front_page() && ! is_home() && ( true !== get_field( 'kns_exclude_toc' ) ) ) :

	$pagelist = get_pages(
		array(
			'meta_key'   => 'kns_exclude_toc',
			'meta_value' => '1',
		)
	);
	$ex_pages = array();
	foreach ( $pagelist as $p ) {
		$ex_pages[] = $p->ID;
	}
	$ex_pages[] = get_option( 'page_on_front' );
	$ex_pages[] = get_option( 'page_for_posts' );

	$pagelist = get_pages(
		array(
			'sort_column' => 'menu_order',
			'sort_order'  => 'asc',
			'exclude'     => implode( ',', $ex_pages ),
		)
	);

	$page_ids = array();
	foreach ( $pagelist as $p ) {
		$page_ids[] += $p->ID;
	}

	$current = array_search( get_the_ID(), $page_ids );
	$prev_id = isset( $page_ids[ $current - 1 ] ) ? $page_ids[ $current - 1 ] : '';
	$next_id = isset( $page_ids[ $current + 1 ] ) ? $page_ids[ $current + 1 ] : '';
	?>
<hr class="uk-margin-large-top">
<div class="uk-clearfix uk-margin-medium-top kns-footer-page-nav">
	<div class="uk-float-right">
	<?php if ( ! empty( $next_id ) ) : ?>
		<a href="<?php echo get_permalink( $next_id ); ?>"
 title="<?php echo get_the_title( $next_id ); ?>"><span><?php echo get_the_title( $next_id ); ?> &gt;</span></a>
	<?php endif; ?>
	</div>
	<div class="uk-float-left">
	<?php if ( ! empty( $prev_id ) ) : ?>
		<a href="<?php echo get_permalink( $prev_id ); ?>"
		  title="<?php echo get_the_title( $prev_id ); ?>"><span>&lt; <?php echo get_the_title( $prev_id ); ?></span></a>
	<?php endif; ?>
	</div>
</div><!-- .kns-footer-page-nav -->
	<?php
	endif;
?>
