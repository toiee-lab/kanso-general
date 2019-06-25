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
		the_title( '<h1 class="entry-title">', '</h1>' );

		$kns_lead = get_post_meta( get_the_ID(), 'kns_lead', true );
	if ( $kns_lead != '' ) :
		?>
		<h2 class="main-subtitle"><?php echo $kns_lead; ?></h2>
		<?php
		endif;

		$the_id = get_the_ID();
	if ( get_post_meta( $the_id, 'kns_hidethumb', true ) != '1' ) {
		kanso_general_post_thumbnail();
	}
	?>
	<?php the_content(); ?>
				<div class="entry-meta uk-text-right uk-margin">
				<?php kanso_general_posted_on(); ?>
			</div><!-- .entry-meta -->

