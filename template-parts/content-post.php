<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kanso-general
 */

?>
	<?php
		the_title( '<h1 class="entry-title">', '</h1>' );
	?>
			<h2 class="main-subtitle"><?php echo get_post_meta(get_the_ID(), 'kns_lead', true);?></h2>


	
	<?php 
		$the_id = get_the_ID();
		if( get_post_meta($the_id, 'kns_hidethumb', true) != '1' )
		{				
			kanso_general_post_thumbnail();
		}
		?>
	<?php the_content(); ?>
				<div class="entry-meta uk-text-right uk-margin">
				<?php kanso_general_posted_on(); ?>
			</div><!-- .entry-meta -->

