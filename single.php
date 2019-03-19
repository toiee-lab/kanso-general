<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kanso-general
 */

get_header(); ?>
	<div class="uk-container uk-container-small uk-background-default main-content">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );
			?>
			<hr class="uk-divider-small uk-text-center">
			<?php
			the_post_navigation(
				array(
					'prev_text'          => '&lt; PREVIOUS',
					'next_text'          => 'NEXT &gt;',
					'screen_reader_text' => 'Navigation',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				?>
				<hr class="uk-margin-large">
				<?php
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</div><!-- .main-content -->
<?php
get_sidebar();
get_footer();
