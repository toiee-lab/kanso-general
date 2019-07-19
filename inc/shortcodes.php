<?php

/**
 * shortcodeがpタグに囲まれるfix
 */
function shortcode_empty_paragraph_fix( $content ) {
	$array = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']',
	);

	$content = strtr( $content, $array );
	return $content;
}
add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );

/**
 * Alert
 */
add_shortcode(
	'uk-alert',
	function ( $atts, $content ) {

		$atts = shortcode_atts(
			array(
				'style' => 'none',
				'title' => '',
				'icon'  => 'true',
			),
			$atts
		);
		extract( $atts );

		// key: name, value: icon
		$alerts = array(
			'none'    => 'info',
			'primary' => 'info',
			'success' => 'check',
			'warning' => 'warning',
			'danger'  => 'ban',
		);

		$add_class = array_key_exists( $style, $alerts ) ? ' class="uk-alert-' . $style . '"' : '';

		$icon_name = ( $icon == 'false' ) ? '' : $alerts[ $style ];
		$add_icon  = ( $icon_name == '' ) ? '' : '<span uk-icon="icon: ' . $icon_name . '"></span>';

		// アイコンがあれば、タイトルにアイコンを入れる
		$title = $title == '' ? '' : '<h3>' . $add_icon . ' ' . $title . '</h3>';

		return "<div uk-alert{$add_class}>{$title}" . do_shortcode( str_replace( '<p></p>', '', $content ) ) . '</div>';
	}
);

/**
 * icon
 */
add_shortcode(
	'uk-icon',
	function( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'name' => 'dummydummy',
			),
			$atts
		);
		extract( $atts );

		return '<span uk-icon="icon: ' . $name . '"></span>';
	}
);


/**
 * badge
 */
add_shortcode(
	'uk-badge',
	function( $atts, $content ) {
		return '<span class="uk-badge">' . do_shortcode( $content ) . '</span>';
	}
);

/**
 * button
 */
add_shortcode(
	'uk-button',
	function ( $atts, $content ) {

		$atts = shortcode_atts(
			array(
				'href'   => '#',
				'style'  => 'default',
				'size'   => 'large',
				'width'  => '',
				'title'  => '',
				'align'  => 'center',
				'margin' => 'medium',
			),
			$atts
		);
		extract( $atts );

		$cls_width = ( $width != '' ) ? ' uk-width-' . $width : '';
		$class     = 'uk-button' . ' uk-button-' . $style . ' uk-button-' . $size . $cls_width;

		$button = "<a href=\"{$href}\" class=\"{$class}\" title=\"{$title}\">" . do_shortcode( $content ) . '</a>';

		$cls_margin = ( $margin == '' ) ? '' : ' class="uk-margin-' . $margin . '-top uk-margin-' . $margin . '-bottom"';

		if ( $align != '' && $align != 'none' ) {
			$button = "<div style=\"text-align: {$align}\"{$cls_margin}>{$button}</div>";
		}

		return $button;
	}
);


/**
 * icon
 */
add_shortcode(
	'uk-label',
	function( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style' => '',
			),
			$atts
		);
		extract( $atts );

		$class = ( $style == '' ) ? 'uk-label' : 'uk-label uk-label-' . $style;

		return '<span class="' . $class . '">' . do_shortcode( $content ) . '</span>';
	}
);

/**
 * uk-accordion
 */
add_shortcode(
	'uk-accordion',
	function( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'multiple' => '',
			),
			$atts
		);
		extract( $atts );

		$content = str_replace( '<p>===</p>', '===', $content );
		$items   = explode( '===', $content );

		$lists = array();
		foreach ( $items as $item ) {
			$lines = explode( "\n", $item );

			// 空行をスキップする
			$title = '&nbsp;';
			while ( ( $line = array_shift( $lines ) ) !== null ) {
				// pタグが自動で入っているので削除する
				$line = str_replace( array( '<p>', '</p>' ), '', $line );

				if ( $line !== '' ) {
					$title = $line;
					break;
				}
			}

			// 一行目をタイトルに
			$lists[] = array(
				'title'   => $title,
				'content' => do_shortcode( implode( "\n", $lines ) ),
			);
		}

		$multiple = ( $multiple != 'true' ) ? '' : '="multiple: true"';

		$ret = "<ul uk-accordion{$multiple}>\n";
		foreach ( $lists as $li ) {
			$ret .= "    <li>\n";
			$ret .= "        <a class=\"uk-accordion-title\" href=\"#\">{$li['title']}</a>\n";
			$ret .= "        <div class=\"uk-accordion-content\">{$li['content']}</div>\n";
			$ret .= "    </li>\n";
		}
		$ret .= "</ul>\n";

		return $ret;
	}
);

/**
 * uk-tab
 */
add_shortcode(
	'uk-tab',
	function( $atts, $content ) {
		static $kns_tab_num = 0;

		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts
		);
		extract( $atts );

		$content = str_replace( '<p>===</p>', '===', $content );
		$items   = explode( '===', $content );

		$lists = array();
		foreach ( $items as $item ) {
			$lines = explode( "\n", $item );

			// 空行をスキップする
			$title = '&nbsp;';
			while ( ( $line = array_shift( $lines ) ) !== null ) {
				// pタグが自動で入っているので削除する
				$line = str_replace( array( '<p>', '</p>' ), '', $line );

				if ( $line !== '' ) {
					$title = $line;
					break;
				}
			}

			// 一行目をタイトルに
			$lists[] = array(
				'title'   => $title,
				'content' => do_shortcode( implode( "\n", $lines ) ),
			);
		}

		$kns_tab_num++;
		$id = $id == '' ? 'kns-tab-' . $kns_tab_num : $id;

		$ret = '<ul uk-tab="connect: #' . $id . '">' . "\n";
		foreach ( $lists as $li ) {
			$ret .= "    <li><a href=\"#\">{$li['title']}</a></li>\n";
		}
		$ret .= "</ul>\n";

		$ret .= "<ul class=\"uk-switcher kns-li-content uk-margin\" id=\"{$id}\">\n";
		foreach ( $lists as $li ) {
			$ret .= "    <li>{$li['content']}</li>\n";
		}
		$ret .= "</ul>\n";

		return $ret;
	}
);


/**
 * uk-grid
 */
add_shortcode(
	'uk-grid',
	function( $atts, $content ) {
		static $kns_tab_num = 0;

		$atts = shortcode_atts(
			array(
				'width'    => '',
				'class'    => '',
				'grid_cls' => 'uk-child-width-expand@s',
			),
			$atts
		);
		extract( $atts );

		// 空の pタグ行を削除する
		// $content = str_replace('<p></p>', '', $content);
		$content = str_replace( '<p>===</p>', '===', $content );
		$items   = explode( '===', $content );

		if ( $class != '' ) { // class が指定されている場合は、こちらを使う
			$cls = explode( ',', $class );
		} elseif ( $width ) {
			$cls = explode( ',', $width );
			foreach ( $cls as $k => $v ) {
				$cls[ $k ] = 'uk-width-' . $v . '@m';
			}
		} else {
			$cls = array();
		}

		$ret = '<div uk-grid class="' . $grid_cls . '">' . "\n";
		foreach ( $items as $item ) {
			$i_cls = array_shift( $cls );
			$ret  .= "<div class=\"{$i_cls}\">{$item}</div>\n";
		}
		$ret .= "</div>\n";

		return $ret;
	}
);


/*
 * uk-lightbox
 */
add_shortcode(
	'uk-lightbox',
	function( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'href'    => '',
				'label'   => 'click here',
				'caption' => '',
			),
			$atts
		);
		extract( $atts );

		if ( $href != '' ) { // シンプルな動作をする
			$add_caption = $caption != '' ? ' data-caption="' . $caption . '"' : '';
			$ret         = '<div uk-lightbox>
    <a href="' . $href . '"' . $add_caption . '>' . $label . '</a>
</div>' . "\n";
			return $ret;
		} else {
			return '<div uk-lightbox>' . do_shortcode( $content ) . '</div>' . "\n";
		}
	}
);


/**
 * uk-slideshow
 */
add_shortcode(
	'uk-slideshow',
	function( $atts, $content ) {
		static $kns_tab_num = 0;

		$atts = shortcode_atts(
			array(
				'width' => '',
			),
			$atts
		);
		extract( $atts );

		preg_match_all( '(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', $content, $urls );
		$urls = array_unique( $urls[0] );

		$ret = <<<EOD
<div uk-slideshow="animation: push">

    <div class="uk-position-relative uk-visible-toggle uk-light">
	
	    <ul class="uk-slideshow-items">
EOD;
		foreach ( $urls as $u ) {
			$ret .= <<<EOD
			<li>
	            <img src="{$u}" alt="" uk-cover>
	        </li>
EOD;
		}

		$ret .= <<<EOD
	    </ul>
	
	    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
	    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
	    
	</div>

    <ul class="uk-slideshow-nav uk-dotnav uk-flex-center">
EOD;

		for ( $i = 0; $i < count( $urls ); $i++ ) {
			$ret .= '		<li uk-slideshow-item="' . $i . '"><a href="#">Item ' . ( $i + 1 ) . '</a></li>' . "\n";
		}

		$ret .= <<<EOD
    </ul>

</div>
EOD;

		return $ret;
	}
);



// ! KANSO 投稿表示のためのショートコード
add_shortcode(
	'kns-showpost',
	function( $atts, $content ) {

		// 子ページを表示するオプションの場合
		if ( is_array( $atts ) ) {
			$children = ( array_search( 'children', $atts ) !== false ) ? true : false;
		} else {
			$children = false;
		}

		$atts = shortcode_atts(
			array(
				'title'        => 'お知らせ',
				'style'        => 'list',
				'post_type'    => 'post',
				'cat_name'     => '',
				'num'          => '6',
				'label'        => 'new',
				'orderby'      => 'date',
				'order'        => 'DESC',
				'post_ids'     => '',
				'kns_exclude_toc' => 1,   // メニューに表示しない設定したアイテムは、表示しない
				'exclude_ids'  => '',
			),
			$atts
		);
		extract( $atts );

		$param = array(
			'numberposts'   => $num,
			'category_name' => $cat_name,  // slug name (not display name)
			'orderby'       => $orderby,
			'order'         => $order,
			'post_type'     => $post_type,
			'include'       => $post_ids,
		);

		if ( $children ) { // 子ページを検索する

			// 除外する id を設定する
			if ( $kns_exclude_toc === 'true' ) {
				$ex_q      = array(
					'post_type'      => 'page',
					'meta_key'       => 'kns_exclude_toc',
					'meta_value'     => 1,
					'compare'        => '=',
					'posts_per_page' => -1,
				);
				$the_query = new WP_Query( $ex_q );
				$tmp_posts = $the_query->posts;
				foreach ( $tmp_posts as $p ) {
					$exclude_ids .= $p->ID . ',';
				}
			}

			$parent_id = get_the_ID();
			if ( $post_ids != '' && is_numeric( $post_ids ) ) {
				$parent_id = $post_ids;
			}

			$title      = '';
			$q          = array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_parent'    => $parent_id,
				'orderby'        => 'menu_order',
				'order'          => 'asc',
			);
			$query      = new WP_Query( $q );
			$post_array = $query->posts;
		} else {
			$post_array = get_posts( $param );
		}

		// 投稿を除外する
		$ex_post_ids = array_flip( explode( ',', $exclude_ids ) );
		foreach ( $post_array as $k => $p ) {
			if ( isset( $ex_post_ids[ $p->ID ] ) ) {
				unset( $post_array[ $k ] );
			}
		}

		$dummy_img = get_bloginfo( 'template_directory' ) . '/images/dummy.png';

		global $post;  // the_permalink などを使えるようにするために、global 宣言する（WordPressの定石)
		switch ( $style ) {

			case 'media-top':
				$div_num = ceil( count( $post_array ) / 3.0 );

				ob_start();
				?>
				<?php for ( $i = 0; $i < $div_num; $i++ ) : ?>
<div class="uk-child-width-1-3@m uk-grid-small" uk-grid uk-height-match="target: > div > .uk-card; row: false">
					<?php
					for ( $j = 0; $j < 3; $j++ ) :
						if ( ( $post = array_shift( $post_array ) ) == null ) {
							break;
						}
						setup_postdata( $post ); /* the_permalinkなどが使えるサブループを作成 */
						$t_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$t_img = ( $t_img[0] == '' ) ? $dummy_img : $t_img[0];
						?>
	<div>
		<div class="uk-card uk-card-default uk-card uk-card-small uk-box-shadow-small">
			<div class="uk-card-media-top">
				<a href="<?php the_permalink(); ?>"><img src="<?php echo $t_img; ?>" alt="" /></a>
			</div>
			<div class="uk-card-body">
				<h3 class="uk-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p><?php echo mb_strimwidth( get_the_excerpt(), 0, 30 ); ?> <a href="<?php the_permalink(); ?>">...</a></p>
			</div>
		</div>
	</div>
						<?php
	endfor;
					wp_reset_postdata();  /* setup_postdata を使った後は、必ずリセットする */
					?>
</div>
			<?php endfor; ?>
				<?php
				$ret = ob_get_contents();
				ob_end_clean();
				break;

			// ------------------------
			case 'media-bottom':
				$div_num = ceil( count( $post_array ) / 3.0 );

				ob_start();
				?>
				<?php for ( $i = 0; $i < $div_num; $i++ ) : ?>
<div class="uk-child-width-1-3@m uk-grid-small" uk-grid uk-height-match="target: > div > .uk-card;">
					<?php
					for ( $j = 0; $j < 3; $j++ ) :
						if ( ( $post = array_shift( $post_array ) ) == null ) {
							break;
						}
						setup_postdata( $post );
						$t_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$t_img = ( $t_img[0] == '' ) ? $dummy_img : $t_img[0];
						?>
	<div>
		<div class="uk-card uk-card-default uk-card uk-card-small uk-box-shadow-small">
			<div class="uk-card-body">
				<h3 class="uk-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p><?php echo mb_strimwidth( get_the_excerpt(), 0, 30 ); ?> <a href="<?php the_permalink(); ?>">...</a></p>
			</div>
			<div class="uk-card-media-bottom">
				<a href="<?php the_permalink(); ?>"><img src="<?php echo $t_img; ?>" alt="" /></a>
			</div>
		</div>
	</div>
						<?php
	endfor;
					wp_reset_postdata();
					?>
</div>
			<?php endfor; ?>
				<?php
				$ret = ob_get_contents();
				ob_end_clean();
				break;

			// ------------------------
			case 'media-left':
			case 'media-right':
				ob_start();
				?>
				<?php
				foreach ( $post_array as $post ) :
					setup_postdata( $post );
					?>
					<?php
						$t_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$t_img = ( $t_img[0] == '' ) ? $dummy_img : $t_img[0];

					?>
				
<div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
	<div class="<?php echo ( $style == 'media-left' ) ? 'uk-card-media-left' : 'uk-flex-last@s uk-card-media-right'; ?> uk-cover-container" onclick="location.href='<?php the_permalink(); ?>'" style="cursor: pointer;">
		<img src="<?php echo $t_img; ?>" alt="" uk-cover>
		<canvas width="600" height="400"></canvas>
	</div>
	<div>
		<div class="uk-card-body">
			<h3 class="uk-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<p><?php echo mb_strimwidth( get_the_excerpt(), 0, 90 ); ?> <a href="<?php the_permalink(); ?>">...</a></p>
		</div>
	</div>
</div>			
					<?php
	endforeach;
				wp_reset_postdata();
				?>
				<?php
				$ret = ob_get_contents();
				ob_end_clean();
				break;
			// ------------------------
			default:
				ob_start();
				?>
<div class="uk-margin">
	<h3><?php echo $title; ?></h3>
	<dl class="uk-description-list uk-description-list-divider uk-margin-left uk-margin-right">
				<?php
				foreach ( $post_array as $post ) :
					setup_postdata( $post );
					?>
		<dt><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></dt>
		<dd><?php echo mb_substr( get_the_excerpt(), 0, 50 ); ?> <a href="<?php the_permalink(); ?>">...</a></dd>
					<?php
		endforeach;
				wp_reset_postdata();
				?>
	</dl>
</div>	
				<?php
				$ret = ob_get_contents();
				ob_end_clean();

		}

		return $ret;
		// return $ret.'<pre style="height:200px;font-size:10px;">'. print_r($param, true) . print_r($post_array, true).'</pre>';
	}
);


add_shortcode(
	'kanso-search',
	function ( $form ) {
		return get_search_form( false );
	}
);
