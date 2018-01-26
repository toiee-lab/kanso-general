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
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
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
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'kanso-general' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'kanso_general_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'kanso_general_setup' );

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
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'kanso-general' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'kanso-general' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'kanso_general_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kanso_general_scripts() {
	wp_enqueue_style( 'kanso-general-style', get_stylesheet_uri() );

	wp_enqueue_script( 'kanso-general-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'kanso-general-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'jquery-uk-form', get_template_directory_uri() . '/js/uk-form.js', array(), '20151215', true );
	
	wp_enqueue_style( 'uikit', 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/css/uikit.min.css' );
	wp_enqueue_style( 'base-style', get_stylesheet_uri(), array('uikit') );
	
	wp_enqueue_script( 'uikit-js', 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit.min.js');
	wp_enqueue_script( 'uikit-icon' , 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit-icons.min.js', array('uikit-js') );

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
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'uk-active ';
    }
    return $classes;
}

/**
 * ３つのフッターウィジェットを追加
 */
$kns_footers = array('left', 'center', 'right');
foreach( $kns_footers as $name ) {
	register_sidebar( array(
		'name'            => 'Footer '.$name,
		'id'              => 'footer-'.$name,
		'before_widget'   => '<div class="uk-padding">',
		'after_widget'    => '</div>',
		'before_title'    => '<h3>',
		'after_title'     => '</h3>'
	) );
}


/**
 * ショートコードを追加するためのもの
 */
require get_template_directory() . '/inc/shortcodes.php';



/**
 * リード文を入力するフィールドを用意する
 */
require get_template_directory() . '/inc/register-lead-meta.php';
/**
 * タイトルを非表示にするフィールドを用意する
 */
require get_template_directory() . '/inc/hide-title-meta.php';



/**
 * page menu widget additions.
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
function kanso_general_customize_admin_bar_menu($wp_admin_bar){
	$wp_admin_bar->add_menu( array(
		'id'    => 'nestedpages',
		'meta'  => array(),
		'title' => '固定ページ一覧',
		'href'   => home_url('/wp-admin/admin.php?page=nestedpages')
	) );
}
add_action('admin_bar_menu', 'kanso_general_customize_admin_bar_menu', 9999);
