<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kanso-general
 */
?>

			<div id="footer" class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>

			    <div>
			        <div class="uk-padding">Item</div>
			    </div>
			    <div>
			        <div class="uk-padding">Item</div>
			    </div>
			    <div>
			        <div class="uk-padding">Item</div>
			    </div>
			    
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


