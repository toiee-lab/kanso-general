<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package kanso-general
 */

get_header(); ?>
	<div  class="uk-container uk-container-middle uk-background-default" >
		<section id="primary" class="content-area">
			<main id="main" class="site-main">
				<?php
				/* 検索キーワードを読みだして<h1>で表示するためのプログラム */
				if ( have_posts() ) :
					?>
					<header class="page-header">
						<h1 class="page-title">
							<?php
							/* translators: %s: search query. */
							printf( esc_html__( '検索キーワード : %s', 'kanso-general' ), '<span>' . get_search_query() . '</span>' );
							?>

							<br>
							<h3 class="main-subtitle">更に検索する場合はこちら</h3>

							<?php
							get_search_form();
							?>
						</h1>
					</header><!-- .page-header -->
					<?php
					/* 実際の検索結果をループして表示するためのプログラム */
					?>
					<div class="uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid uk-height-match="target: > div > .uk-card">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<div>
							<div class="uk-card uk-card-default uk-grid-small uk-box-shadow-small">
								<div class="uk-card-media-top uk-cover-container card-height">
									<div class="uk-card-badge uk-label uk-label-muted"><?php echo kanso_get_post_label(); ?></div>
									<img src="<?php echo esc_attr( kanso_general_get_thumnail_url() ); ?>" alt="" uk-cover>
									<!--            <a href="<?php echo esc_url( get_permalink() ); ?>"><img src="<?php echo esc_attr( kanso_general_get_thumnail_url() ); ?>" alt="" uk-cover></a>-->
									<a href="<?php echo esc_url( get_permalink() ); ?>"></a>
								</div>
								<div class="uk-card-body">
									<p class="uk-link-muted uk-margin-remove-bottom uk-text-small"><?php the_category( ' , ' ); ?></p>
									<?php
									if ( is_singular() ) :
										the_title( '<h1 class="uk-h4 uk-margin-remove uk-link-text">', '</h1>' );
									else :
										the_title( '<h2 class="uk-h4 uk-margin-remove uk-link-text"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

									endif;
									?>
									<p class="uk-margin-small-top">
										<?php
										the_excerpt(
											sprintf(
												wp_kses(
													/* translators: %s: Name of current post. Only visible to screen readers */
													__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'kanso-general' ),
													array(
														'span'  => array(
															'class' => array(),
														),
													)
												),
												get_the_title()
											)
										);
										?>
									</p>
									<div class="uk-position-bottom">
										<div class="uk-margin-small uk-margin-small-left">
											<?php
											$author_id  = get_the_author_meta( 'ID' );
											$author_img = get_avatar( $author_id );
											$imgtag     = '/<img.*?src=(["\'])(.+?)\1.*?>/i';
											if ( preg_match( $imgtag, $author_img, $imgurl ) ) {
												$author_img_url = $imgurl[2];
											}

											?>
											<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="uk-link-text"><img src="<?php echo esc_url( $author_img_url ); ?>" class="uk-border-circle post-card-avatar"> <?php the_author_meta( 'nickname' ); ?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
					</div>
					<?php
					echo kanso_get_post_navigation();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</main><!-- #main -->
		</section><!-- #primary -->
	</div><!-- .main-content -->
<?php
get_sidebar();
get_footer();
