<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package kanso-general
 */

get_header(); ?>


<div  class="uk-container uk-container-small uk-background-default main-content" >


	<section id="primary" class="content-area">
		<main id="main" class="site-main">





		<?php
		// 検索キーワードを読みだして<h1>で表示するためのプログラム
		if ( have_posts() ) : ?>
			<header class="page-header">
				<h1 class="page-title">	
				<?php
					/* translators: %s: search query. */
					printf( esc_html__( '検索キーワード : %s', 'kanso-general' ), '<span>' . get_search_query() . '</span>');
				?>
					
					<br>
					<h3 class="main-subtitle">更に検索する場合はこちら</h2>
					
				<?php
					get_search_form();
				?>
				</h1>
			</header><!-- .page-header -->
			
			
				

              
	            



			<?php
			// 実際の検索結果をループして表示するためのプログラム
			/* Start the Loop */
			while ( have_posts() ) : the_post();
             echo '<hr>';
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				 
				get_template_part( 'template-parts/content', get_post_format());
			endwhile;
			the_posts_navigation();
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif; ?>
		
		
		</main><!-- #main -->
	</section><!-- #primary -->


 
</div><!-- .main-content -->



<?php
get_sidebar();
get_footer();
