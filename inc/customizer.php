<?php
/**
 * kanso-general Theme Customizer
 *
 * @package kanso-general
 */
/*
 説明 :
 * カスタマイザーに追加するには６つの作業が必要
 *
 * (0) カスタマイズ項目に対応して、CSSなりを吐き出すPHPプログラムの作成
 * (1) $wp_customize->add_setting でカスタマイズ項目の登録
 * (2) $wp_customize->control でカスタマイズ登録の表示を登録
 * (3) $wp_customize->selective_refresh->add_partial でカスタマイズ項目が修正された時に呼び出されるjavascriptを登録
 * (4) js/customize.js に 3で指定した javascript を用意する ( 5のメソッドを定義する )
 * (5) 4で呼び出されることになる関数を用意する
 *
 * 上記のようなややこしさを生み出している原因は、カスタマイザーの変更を、リアルタイムに反映させるために用意された仕組みが原因。
 * 1 - 5 は、リアルタイムに修正するための仕組み。自由度を確保しているがゆえに、あらゆることを書かないといけない。仕方ない。
 *
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function kanso_general_customize_register( $wp_customize ) {

	// コピーライトの名前表示フィールドの追加
	$wp_customize->add_setting(
		'kanso_general_options_ownername',
		array(
			'default'   => '',
			'type'      => 'option',
			'transport' => 'postMessage', // 表示更新のタイミング。デフォルトは'refresh'（即時反映）
		)
	);
	$wp_customize->add_control(
		'kanso_general_options_ownername',
		array(
			'settings' => 'kanso_general_options_ownername',
			'label'    => 'コピーライト名',
			'section'  => 'title_tagline',
			'type'     => 'text',
		)
	);

	// ------------------------------------
	//
	// ヘッダー設定
	//
	// 色の設定 : colorsセクションに追加
	// カラーセット
	$wp_customize->add_setting(
		'kanso_general_options_colors',
		array(
			'default'   => '400',
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);

	$color_choices = kns_get_color_set( 'dummy', true );

	$wp_customize->add_control(
		'kanso_general_options_colors',
		array(
			'settings'    => 'kanso_general_options_colors',
			'label'       => '全体 : ナビ色+α',
			'description' => 'フロントページでページ途中で現れるナビの文字色、背景色と、ヘッダー画像を指定しない場合の背景の色を指定することができます。',
			'section'     => 'header_image',
			'type'        => 'select',
			'choices'     => $color_choices,
			'priority'    => 0,
		)
	);

	// ヘッダーのタイトル、サブタイトル
	$wp_customize->add_setting(
		'kanso_general_options_htitle',
		array(
			'default'   => 'タイトル',
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'kanso_general_options_htitle',
		array(
			'settings' => 'kanso_general_options_htitle',
			'label'    => 'ヘッダーのタイトル',
			'section'  => 'header_image',
			'type'     => 'text',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'kanso_general_options_hsubtitle',
		array(
			'default'   => 'サブタイトル',
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'kanso_general_options_hsubtitle',
		array(
			'settings' => 'kanso_general_options_hsubtitle',
			'label'    => 'ヘッダーのサブタイトル',
			'section'  => 'header_image',
			'type'     => 'text',
			'priority' => 2,
		)
	);

	// フロントページのヘッダー文字色
	$wp_customize->add_setting(
		'kanso_general_options_hcolor_front',
		array(
			'default'   => '400',
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'kanso_general_options_hcolor_front',
		array(
			'settings' => 'kanso_general_options_hcolor_front',
			'label'    => 'フロントページ : キャッチコピー文字色',
			'section'  => 'header_image',
			'type'     => 'select',
			'choices'  => array(
				'#fff' => '白',
				'#333'  => '黒',
			),
			'priority' => 3,
		)
	);

	// ヘッダーイメージの高さ
	$wp_customize->add_setting(
		'kanso_general_options_height',
		array(
			'default'   => '400',
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'kanso_general_options_height',
		array(
			'settings' => 'kanso_general_options_height',
			'label'    => 'ヘッダーの高さ',
			'section'  => 'header_image',
			'type'     => 'text',
			'priority' => 4,
		)
	);

	// javascript で変更を即時に反映するための設定
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// javascript の登録
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'kanso_general_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'kanso_general_options_ownername',
			array(
				'selector'        => '.ownername',
				'render_callback' => 'kanso_general_customize_partial_ownername',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'kanso_general_customize_partial_blogdescription',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'kanso_general_options_htitle',
			array(
				'selector'        => '#kanso_general_options_htitle',
				'render_callback' => 'kanso_general_customize_partial_htitle',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'kanso_general_options_hsubtitle',
			array(
				'selector'        => '#kanso_general_options_hsubtitle',
				'render_callback' => 'kanso_general_customize_partial_hsubtitle',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'kanso_general_options_height',
			array(
				'selector'        => '#kanso_general_options_height',
				'render_callback' => 'kanso_general_customize_partial_height',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'kanso_general_options_hcolor_front',
			array(
				'selector'        => '#kanso_general_options_hcolor_front',
				'render_callback' => 'kanso_general_customize_partial_frontcolor',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'kanso_general_options_colors',
			array(
				'selector'        => '#kanso_general_options_colors',
				'render_callback' => 'kanso_general_customize_partial_colors',
			)
		);

	}
}
add_action( 'customize_register', 'kanso_general_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function kanso_general_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function kanso_general_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function kanso_general_customize_partial_htitle() {
	echo get_option( 'kanso_general_options_htitle' );
}

function kanso_general_customize_partial_hsubtitle() {
	echo get_option( 'kanso_general_options_hsubtitle' );
}

function kanso_general_customize_partial_height() {
	echo get_option( 'kanso_general_options_height' );
}
function kanso_general_customize_partial_frontcolor() {
	echo get_option( 'kanso_general_options_hcolor_front' );
}
function kanso_general_customize_partial_colors() {
	echo json_decode( kns_get_color_set( get_option( 'kanso_general_options_colors', 'snow' ) ) );
}
function kanso_general_customize_partial_ownername() {
	echo get_option( 'kanso_general_options_ownername' );
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function kanso_general_customize_preview_js() {
	wp_enqueue_script( 'kanso-general-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'kanso_general_customize_preview_js' );
