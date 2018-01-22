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
				// do nothing
			}
			else {
		?>
		
			<?php the_title('<h1>', '</h1>'); ?>
			<h2 class="main-subtitle"><?php echo get_post_meta(get_the_ID(), 'kns_lead', true);?></h2>
			
			<?php the_post_thumbnail(); ?>
			
		<?php } ?>
						
			<?php the_content(); ?>
