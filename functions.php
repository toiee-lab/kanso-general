<?php
/**
 * kanso-general functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kanso-general
 */

/* FOR UPDATE */
require 'plugin-update-checker/plugin-update-checker.php';
$my_update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/toiee-lab/kanso-general/master/theme.json',
	__FILE__,
	'kanso-general'
);

if ( ! function_exists( 'kanso_general_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function kanso_general_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on kanso-general, use a find and replace
		 * to change 'kanso-general' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'kanso-general', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1'    => esc_html__( 'Primary', 'kanso-general' ),
				'blog-menu' => esc_html__( 'ブログトップメニュー', 'kanso-general' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		/**     add_theme_support( 'custom-background', apply_filters( 'kanso_general_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
		) ) );
		 */
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 50,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'kanso_general_setup' );


/**
 * ACFプラグインの存在をチェックする。
 */
function kns_exist_acf_admin_notice_error() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		$class   = 'notice notice-error';
		$message = __( '【重要】KANSO を利用するには、ACFプラグインが必須です。インストールし、有効にしてください。', 'kanso' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
}
add_action( 'admin_notices', 'kns_exist_acf_admin_notice_error' );


/* ACF がなくても、とりあえず動くようにする */
function kns_acf_proxy () {
	if ( ! function_exists( 'update_field' ) &&  ! is_admin() ) {

		function update_field( $selector, $value, $post_id = false ) {
			if ( false === $post_id ) {
				$post_id = get_the_ID();
			}
			update_post_meta( $post_id, $selector, $value );
		}

		function get_field( $selector, $post_id = false ) {
			if ( false === $post_id ) {
				$post_id = get_the_ID();
			}

			return get_post_meta( $post_id, $selector, true );
		}
	}
}
add_action( 'wp_loaded', 'kns_acf_proxy', 0, 99 );

/**
 * upgrade
 */
if( function_exists( 'acf_add_local_field_group' ) ) {
	require_once 'inc/upgrade.php';
	$kanso_upgrade = new Kanso_Upgrade();
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kanso_general_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kanso_general_content_width', 640 );
}
add_action( 'after_setup_theme', 'kanso_general_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kanso_general_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'kanso-general' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'kanso-general' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'kanso_general_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kanso_general_scripts() {
	/*	wp_enqueue_style( 'kanso-general-style', get_stylesheet_uri(), array(), '0.9.8' ); */

	wp_enqueue_script( 'kanso-general-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'kanso-general-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-uk-form', get_template_directory_uri() . '/js/kanso.js', array(), '20151215', true );

	wp_enqueue_style( 'uikit', get_template_directory_uri() . '/css/uikit.min.css', array(), '3.1.6' );
	wp_enqueue_style( 'base-style', get_stylesheet_uri(), array( 'uikit' ) );

	wp_enqueue_script( 'uikit-js', get_template_directory_uri() . '/js/uikit.min.js', array(), '3.1.6' );
	wp_enqueue_script( 'uikit-icon', get_template_directory_uri() . '/js/uikit-icons.min.js', array( 'uikit-js' ), '3.1.6' );

	if ( isset( $_GET['preview'] ) && 'true' === $_GET['preview'] ) {
		wp_enqueue_script( 'admin-bar-preview', get_template_directory_uri() . '/js/admin-bar-preview.js', array(), '20151215', true );
	}
}
add_action( 'wp_enqueue_scripts', 'kanso_general_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/custom-colors.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * ナビメニューのクラスの変更
 */
add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );
function special_nav_class( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'uk-active ';
	}
	return $classes;
}

/**
 * ロゴ
 */
if ( ! function_exists( 'kanso_custom_logo' ) ) :
	add_filter( 'get_custom_logo', 'kanso_custom_logo' );
	/** Filter the output of logo to fix Googles Error about itemprop logo */
	function kanso_custom_logo() {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$img            = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		$html           = '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home" itemprop="url"><img src="' . $img[0] . '" class="custom-logo"></a>';

		return $html;
	}
endif;

/**
 * ３つのフッターウィジェットを追加
 */
$kns_footers = array( 'left', 'center', 'right' );
foreach ( $kns_footers as $name ) {
	register_sidebar(
		array(
			'name'          => 'Footer ' . $name,
			'id'            => 'footer-' . $name,
			'before_widget' => '<div class="uk-padding">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);
}


/**
 * ショートコードを追加するためのもの
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Page menu widget additions.
 */
require get_template_directory() . '/inc/page-menu-widget.php';

/**
 * ウィジェットの登録
 */
function theme_register_widget() {

	register_widget( 'PageToc_Widget' );

}
add_action( 'widgets_init', 'theme_register_widget' );


/**
 * 編集画面の「管理ツールバー」に固定ページ一覧リンクを表示
 */
function kanso_general_customize_admin_bar_menu( $wp_admin_bar ) {
	$wp_admin_bar->add_menu(
		array(
			'id'    => 'nestedpages',
			'meta'  => array(),
			'title' => '固定ページ一覧',
			'href'  => home_url( '/wp-admin/admin.php?page=nestedpages' ),
		)
	);
}
add_action( 'admin_bar_menu', 'kanso_general_customize_admin_bar_menu', 9999 );


/* カスタマイザーの色の項目を削除 */
add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->remove_section( 'colors' );
	}
);

/* 設定画面の追加 */
require get_template_directory() . '/inc/admin-setting.php';


/* JP Markdown2 を使う */
$options = get_option( 'kns_options' );
if ( isset( $options['jp_markdown_eneble'] ) && '1' === $options['jp_markdown_eneble'] ) {
	if ( ! function_exists( 'jetpack_markdown_posting_always_on' ) ) {
		require get_template_directory() . '/jetpack-markdown2/markdown.php';
	}
}

/* JP Markdown が shortcode の中も parse するように修正 */
if ( ! isset( $options['parse_md_in_shortcode'] ) || '1' === $options['parse_md_in_shortcode'] ) {
	add_filter( 'jetpack_markdown_preserve_shortcodes', '__return_false' );
}


/* 必須プラグインを要求する */
require_once get_template_directory() . '/tgmpa/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'kanso_general_register_required_plugins' );
/** 必要なプラグインを登録 */
function kanso_general_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'     => 'Nested Pages',
			'slug'     => 'wp-nested-pages',
			'required' => true,
		),

		array(
			'name'     => 'WP Multibyte Patch',
			'slug'     => 'wp-multibyte-patch',
			'required' => 'true',
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'kanso-general',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}


/**
 * どのページテンプレートを使うか判定する
 *
 * 戻り値 : content or sidebar
 */
if ( ! function_exists( 'kns_get_template' ) ) {
	/** Kanso template */
	function kns_get_template() {

		if ( is_page_template( 'page-sidebar.php' ) ) {
			return 'sidebar';
		}

		if ( is_page_template( 'page-content.php' ) ) {
			return 'content';
		}

		/* デフォルトの場合 */

		if ( is_front_page() ) {
			return 'content';   /* 指定がなければ、コンテンツのみを採用する */
		}

		if ( is_home() ) {
			return 'content';   /* 投稿ページはサイドバーはないので、コンテンツレイアウトとして設定(headerで必要) */
		}

		/* デフォルトレイアウト値を戻す */
		$options = get_option( 'kns_options' );
		if ( isset( $options['kns_default_layout'] ) && 'sidebar' === ( $options['kns_default_layout'] ) ) {
			return 'sidebar';
		} else {
			return 'content';
		}
	}
}



/**
 * Woocommerce support
 */
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );


/**
 * Style sheet のバージョン番号をファイルスタンプに変更
 */
add_action(
	'wp_default_styles',
	function ( $styles ) {
		$mtime_template          = filemtime( get_template_directory() . '/style.css' );
		$mtime_style             = filemtime( get_stylesheet_directory() . '/style.css' );
		$mtime                   = ( $mtime_template ) > $mtime_style ? $mtime_template : $mtime_style;
		$styles->default_version = $mtime;
	}
);

/** Gutenberg Wide Alignment
 * https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#wide-alignment
 */
add_theme_support( 'align-wide' );

/**
 * 抜粋の長さ調整
 *
 * @param $length
 * @return int
 */
function custom_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 100 );

/** もっと読む */
function new_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

/* メディアライブラリを使いやすくする */
function muc_column( $cols ) {
	$cols['media_url'] = 'URL';
	return $cols;
}
function muc_value( $column_name, $id ) {
	if ( $column_name == 'media_url' ) {
		echo '<input type="text" width="100%" onclick="jQuery(this).select();" value="' . wp_get_attachment_url( $id ) . '" />';
	}
}
add_filter( 'manage_media_columns', 'muc_column' );
add_action( 'manage_media_custom_column', 'muc_value', 10, 2 );

add_filter('acf/settings/save_json', function ( $path ) {
	if ( file_exists( get_stylesheet_directory() . '/acf/index.php' ) ) {
		return get_stylesheet_directory() . '/acf';
	} else {
		return get_template_directory() . '/acf';
	}

	return $path;
});
add_filter('acf/settings/load_json', function ( $paths ) {
	unset($paths[0]);

	if ( file_exists( get_stylesheet_directory() . '/acf/index.php' ) ) {
		$paths[] = get_stylesheet_directory() . '/acf';
	} else {
		$paths[] = get_template_directory() . '/acf';
	}

	return $paths;
});