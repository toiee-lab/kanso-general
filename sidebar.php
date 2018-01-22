<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kanso-general
 */
?>
			<div id="footer">
				<div  class="uk-grid-collapse uk-child-width-expand@s uk-text-left" uk-grid>
	
				    <div>
				        <?php dynamic_sidebar('footer-left'); ?>
				    </div>
				    <div>
	   			        <?php dynamic_sidebar('footer-center'); ?>
				    </div>
				    <div>
	   			        <?php dynamic_sidebar('footer-right'); ?>
				    </div>
				    
				</div>
				<p id="footer-copyright">Copyright &copy; <?php echo get_option( 'kanso_general_options_ownername' ); ?>, All rights reserved.</p>
			</div><!-- #footer -->
			
	    </div><!-- uk-offcanvas-content -->
	    <div id="sidebar" uk-offcanvas="overlay: true;mode: push">
	        <div class="uk-offcanvas-bar">
	
	            <button class="uk-offcanvas-close" type="button" uk-close></button>

				<aside id="secondary" class="widget-area">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</aside><!-- #secondary -->


	        </div>
	    </div>


