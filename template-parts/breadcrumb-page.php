<?php if ( ! is_front_page() ) : ?>

	<div class="kns-breadcrumb">
		<ul itemscope itemtype="http://schema.org/BreadcrumbList">
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo site_url(); ?>" itemprop="item"><span itemprop="name">home</span><meta itemprop="position" content="1"></a>
			</li>
			<?php
				$ancs = array_reverse( $post->ancestors );
			if ( count( $ancs ) == 0 ) {
			} else {
				$cnt = 1;
				foreach ( $ancs as $pid ) {
					?>
			<li class="bc-divider">&gt;</li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo get_page_link( $pid ); ?>" itemprop="item"><span itemprop="name"><?php echo get_page( $pid )->post_title; ?></span><meta itemprop="position" content="<?php echo $cnt += 1; ?>"></a>
			</li>
					<?php
				}
			}
			?>
			<li class="bc-divider">&gt;</li>
			<li class="bc-current_page"><?php echo get_the_title(); ?></li>
		</ul>
	</div>
<?php endif; ?>
