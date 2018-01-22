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
	add_theme_support( 'custom-header', apply_filters( 'kanso_general_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'flex-height'            => true,
		'wp-head-callback'       => 'kanso_general_header_style',
	) ) );
	
	
	// デフォルトのヘッダーイメージを用意しておく
	register_default_headers( array(
		'buildings' => array(
			'url'           => '%s/images/headers/buildings.jpg',
			'thumbnail_url' => '%s/images/headers/buildings.jpg',
			'description'   => 'ビルディング'
		),
		'foods' => array(
			'url'           => '%s/images/headers/foods.jpg',
			'thumbnail_url' => '%s/images/headers/foods.jpg',
			'description'   => 'フード'
		),
		'sea' => array(
			'url'           => '%s/images/headers/sea.jpg',
			'thumbnail_url' => '%s/images/headers/sea.jpg',
			'description'   => '海'
		),
		'childres' => array(
			'url'           => '%s/images/headers/childres.jpg',
			'thumbnail_url' => '%s/images/headers/childres.jpg',
			'description'   => '子供'
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
		)
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
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
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
		<?php if( is_home() || is_front_page() ): ?>
			#kns-head {
				background-image: url(<?php header_image(); ?>);
			}
			
			#kns-header{
				height: <?php echo get_option( 'kanso_general_options_height', 400 );?>px;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
