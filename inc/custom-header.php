<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package kanso-general
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses kanso_general_header_style()
 */
function kanso_general_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'kanso_general_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'flex-height'        => true,
				'wp-head-callback'   => 'kanso_general_header_style',
			)
		)
	);


	// デフォルトのヘッダーイメージを用意しておく
	register_default_headers( array(
		'leaf' => array(
			'url'           => '%s/images/headers/leaf.jpg',
			'thumbnail_url' => '%s/images/headers/leaf.jpg',
			'description'   => 'フード'
		),
		'person' => array(
			'url'           => '%s/images/headers/person.jpg',
			'thumbnail_url' => '%s/images/headers/person.jpg',
			'description'   => 'フード'
		),
		'cafe1' => array(
			'url'           => '%s/images/headers/cafe1.jpg',
			'thumbnail_url' => '%s/images/headers/cafe1.jpg',
			'description'   => 'フード'
		),
		'cafe2' => array(
			'url'           => '%s/images/headers/cafe2.jpg',
			'thumbnail_url' => '%s/images/headers/cafe2.jpg',
			'description'   => 'フード'
		),
		'foods' => array(
			'url'           => '%s/images/headers/foods.jpg',
			'thumbnail_url' => '%s/images/headers/foods.jpg',
			'description'   => 'フード'
		),
		'paint' => array(
			'url'           => '%s/images/headers/paint.jpg',
			'thumbnail_url' => '%s/images/headers/paint.jpg',
			'description'   => 'ペイント'
		),
		'pencil' => array(
			'url'           => '%s/images/headers/pencil.jpg',
			'thumbnail_url' => '%s/images/headers/pencil.jpg',
			'description'   => '鉛筆'
		),
		'flower' => array(
			'url'           => '%s/images/headers/flower.jpg',
			'thumbnail_url' => '%s/images/headers/flower.jpg',
			'description'   => '花'
		),
		'pen' => array(
			'url'           => '%s/images/headers/pen.jpg',
			'thumbnail_url' => '%s/images/headers/pen.jpg',
			'description'   => 'ペン'
		),
		'buildings' => array(
			'url'           => '%s/images/headers/buildings.jpg',
			'thumbnail_url' => '%s/images/headers/buildings.jpg',
			'description'   => 'ビルディング'
		),
	) );


}
add_action( 'after_setup_theme', 'kanso_general_custom_header_setup' );

if ( ! function_exists( 'kanso_general_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see kanso_general_custom_header_setup().
	 */
	function kanso_general_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
//		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
//			return;
//		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css" id="custom-header">
			<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
				?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
				<?php
				// If the user has set a custom color for the text use that.
			else :
				?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
			<?php endif; ?>
			<?php
			/* ヘッダーの設定を呼び出す */
			$kns_color_set = kns_get_color_set( get_option( 'kanso_general_options_colors', 'simple' ) );
			$header_img    = get_header_image();

			?>
			#kns-head {
				<?php
				if ( false !== $header_img ) {
					echo esc_html( 'background-image: url(' . $header_img . ');' );
				} else {
					echo esc_html( $kns_color_set['head-bg'] );
				}
				?>
			}
			#kns-header{
				height: <?php echo esc_html( get_option( 'kanso_general_options_height', 400 ) ); ?>px;
			}
			.kns-navbar-top {
				<?php
				echo esc_html( $kns_color_set['nav-bg0'] );
				?>
			}
			.kns-navbar-sticky {
				<?php
				echo esc_html( $kns_color_set['nav-bg'] );
				?>
			}
			.uk-logo,
			.uk-logo:hover,
			.kns-navbar-top-front,
			.kns-navbar-top-front li>a,
			.kns-navbar-top,
			.kns-navbar-top li>a,
			.kns-navbar-sticky,
			.kns-navbar-sticky li>a,
			#kanso_general_options_htitle,
			#kanso_general_options_hsubtitle
			{
				color : <?php echo esc_html( $kns_color_set['color'] ); ?>;
			}

		</style>
		<?php
	}
endif;
