<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kanso-general
 */

?>


<div>
    <div class="uk-card uk-card-default uk-border-rounded">
        <div class="uk-card-media-top uk-height-medium uk-cover-container">
	        <?php if( is_sticky() ) : ?>
   	        <div class="uk-card-badge uk-label">featured</div>
   			<?php endif; ?>
   	        <img src="<?php echo kanso_general_get_thumnail_url(); ?>" alt="" uk-cover>
<!--            <a href="<?php echo esc_url( get_permalink() ); ?>"><img src="<?php echo kanso_general_get_thumnail_url(); ?>" alt="" uk-cover></a>-->
			<a href="<?php echo esc_url( get_permalink() ); ?>"></a>
        </div>
        <div class="uk-card-body">
	        <p class="uk-link-muted uk-margin-remove-bottom uk-text-small"><?php the_category(' , '); ?></p>
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="uk-h3 uk-margin-remove uk-link-text">', '</h1>' );
			else :
				the_title( '<h2 class="uk-h3 uk-margin-remove uk-link-text"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	
			endif;
			?>
            <p class="uk-margin-small-top">
	            <?php
		   			the_excerpt( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'kanso-general' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );
		        ?>
            </p>
            <div class="uk-position-bottom">
	            <div class="uk-margin-small uk-margin-small-left">
	        <?php
		        $author_id = get_the_author_meta( 'ID' );
				$author_img = get_avatar( $author_id );
				$imgtag= '/<img.*?src=(["\'])(.+?)\1.*?>/i';
				if(preg_match($imgtag, $author_img, $imgurl)){
					$author_img_url = $imgurl[2];
				}
				
			?>
					<a href="<?php echo get_author_posts_url( $author_id ); ?>" class="uk-link-text"><img src="<?php echo $author_img_url ?>" class="uk-border-circle post-card-avatar"> <?php the_author_meta('nickname');?></a>
	            </div>
	        </div>
        </div>
    </div>
</div>
    
    

