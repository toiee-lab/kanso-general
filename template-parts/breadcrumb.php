<?php if( ! is_front_page() ): ?>
		<ul class="uk-breadcrumb">
			<li><a href="<?php echo site_url(); ?>"><span uk-icon="icon: home"></span> home</a></li>
			<?php 
				$ancs = array_reverse($post->ancestors);
				if( count($ancs) == 0 ){
				?>
			<li></li>				
				<?php	
				}
				else
				{
					foreach( $ancs as $pid ){
					?>			
			<li><a href="<?php echo get_page_link( $pid ); ?>"><?php echo get_page( $pid )->post_title; ?></a></li>
				<?php 
					}
				}
				?>
		</ul>
<?php endif; ?>