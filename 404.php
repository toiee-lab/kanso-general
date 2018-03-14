<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package kanso-general
 */

get_header(); ?>


	
  <div  class="uk-container uk-container-small uk-background-default main-content" >

	<h1>お探しのページは、見つかりませんでした</h1>
	<h2 class="main-subtitle">Page is not found</h2>
	
	
	
<img src="<?php echo get_template_directory_uri(); ?>/images/notfound/notfound1.jpg">
	
	
	
	
	<p>以下のフォームで検索することができます。</p>
	

      <?php
		get_search_form();
	  ?>
 
  </div><!-- .main-content -->
<?php
get_sidebar();
get_footer();
