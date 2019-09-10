<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kanso-general
 */

?>
	<div class="uk-link-muted uk-text-muted uk-text-small uk-text-center">
		<?php kanso_general_posted_date(); ?>
		<span class="uk-margin-small-left uk-margin-small-right">--</span>
		<a href="<?php echo esc_url( kanso_get_blog_home_url() ); ?>" >ブログ</a>
		<span class="uk-margin-small-left uk-margin-small-right">/</span>
		<?php the_category( ',' ); ?>
	</div>
	<?php
	if ( true !== get_field('kns_hide_title' ) ) {
		the_title( '<h1 class="entry-title">', '</h1>' );
		the_subtitle( '<h2 class="main-subtitle">', '</h2>' );
	}

	if ( true !== get_field( 'kns_hide_thumbnail' ) ) {
		kanso_general_post_thumbnail();
	}
	?>
	<?php the_content(); ?>
				<div class="entry-meta uk-text-right uk-margin">
				<?php kanso_general_posted_on(); ?>
			</div><!-- .entry-meta -->

