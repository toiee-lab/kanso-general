<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kanso-general
 */

?>

<footer id="footer" uk-height-viewport="expand: true">
	<div  class="uk-grid-collapse uk-child-width-expand@s uk-text-left" uk-grid>

		<div>
			<?php dynamic_sidebar( 'footer-left' ); ?>
		</div>
		<div>
			<?php dynamic_sidebar( 'footer-center' ); ?>
		</div>
		<div>
			<?php dynamic_sidebar( 'footer-right' ); ?>
		</div>

	</div>
	<p id="footer-copyright">Copyright &copy; <span class="ownername"><?php echo esc_html( get_option( 'kanso_general_options_ownername' ) ); ?></span>, All rights reserved.</p>
</footer><!-- #footer -->

<?php wp_footer(); ?>

</body>
</html>
