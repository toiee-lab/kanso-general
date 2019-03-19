<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kanso-general
 */

get_header(); ?>
	<div class="uk-container uk-container-middle uk-background-default">


		<?php
		if ( have_posts() ) :
			if ( is_home() && ! is_front_page() ) :
				?>
		<header>
			<h1 class=""><?php single_post_title(); ?></h1>
			<h2 class="main-subtitle"><?php echo esc_html( get_post_meta( get_queried_object_id(), 'kns_lead', true ) ); ?></h2>
		</header>
		<div style="margin-top: 2rem;">
				<?php
			endif;
			?>
			<?php
			$args = array(
				'theme_location'  => 'blog-menu',
				'container'       => 'nav',
				'container_class' => 'uk-navbar-container uk-navbar-transparent uk-visible@s',
				'items_wrap'      => '<ul id="%1$s" class="%2$s uk-navbar-nav">%3$s</ul>',
				'fallback_cb'     => '',
			);
			wp_nav_menu( $args );
			?>
			<div class="uk-hidden@s">
				<p><a href="#toggle-animation" class="uk-button uk-button-default" type="button" uk-toggle="target: #cat_list; animation: uk-animation-fade">カテゴリ一覧</a></p>
				<div id="cat_list" uk-modal>
					<div class="uk-modal-dialog uk-margin-auto-vertical">
						<button class="uk-modal-close-default" type="button" uk-close></button>
						<div class="uk-modal-header">
							<h2 class="uk-modal-title">カテゴリ一覧</h2>
						</div>
						<div class="uk-modal-body" uk-overflow-auto>
							<?php
							$args = array(
								'theme_location'  => 'blog-menu',
								'container'       => 'div',
								'container_class' => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s uk-list uk-list-divider uk-link-text">%3$s</ul>',
								'fallback_cb'     => '',
							);
							wp_nav_menu( $args );
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid uk-height-match="target: > div > .uk-card">
				<?php
				/* Start the Loop */

				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'card' );

				endwhile;
				?>
			</div>

			<?php
				echo kanso_get_post_navigation();
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
		</div>

	</div><!-- .main-content -->


<?php
get_sidebar();
get_footer();
