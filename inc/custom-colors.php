<?php


/**
 * 色のセットを返す
 *  nav-bg は、background の css を返す
 *  head-bg は、background の css を返す
 *
 * @key
 * @choices
 */
function kns_get_color_set( $key, $choices = false ) {
	$scheme = array(
		'snow'      => array(
			'name'    => '白色',
			'color'   => 'black',
			'nav-bg0' => 'background-color : rgba(255, 255, 255) !important; border-bottom: #eee 1px solid;',
			'nav-bg'  => 'background-color : rgba(255, 255, 255, 0.8) !important; border-bottom: #eee 1px solid;',
			'head-bg' => 'background: linear-gradient(to bottom, #ece9e6, #ffffff);',
		),
		'deepblack' => array(
			'name'    => 'ブラック',
			'color'   => '#ccc',
			'nav-bg0' => 'background-color : rgba(0, 0, 0) !important;',
			'nav-bg'  => 'background-color : rgba(0, 0, 0, 0.8) !important;',
			'head-bg' => 'background: linear-gradient(to top, #000000, #434343);',
		),
		'simple'    => array(
			'name'    => 'ネイビー(紺色)',
			'color'   => 'white',
			'nav-bg0' => 'background: linear-gradient(to right, #141e30, #243b55) !important;',
			'nav-bg'  => 'background-color : rgba(36, 59, 85, 0.8) !important;',
			'head-bg' => 'background: linear-gradient(to right, #141e30, #243b55);',
		),
		'royal'     => array(
			'name'    => '紫色',
			'color'   => 'white',
			'nav-bg0' => 'background: linear-gradient(to right, #0f0c29, #302b63, #24243e) !important;',
			'nav-bg'  => 'background-color : rgba(48, 43, 99, 0.85) !important;',
			'head-bg' => 'background: linear-gradient(to right, #0f0c29, #302b63, #24243e);',
		),
		'transfile' => array(
			'name'    => '水色',
			'color'   => 'white',
			'nav-bg0' => 'background: linear-gradient(to left, #16bffd, #cb3066) !important;',
			'nav-bg'  => 'background-color : rgba(22, 191, 253, 0.85) !important;',
			'head-bg' => 'background: linear-gradient(to left, #16bffd, #cb3066);',
		),
		'firewatch' => array(
			'name'    => '赤色',
			'color'   => 'white',
			'nav-bg0' => 'background: linear-gradient(to right, #cb2d3e, #ef473a) !important;',
			'nav-bg'  => 'background-color : rgba(203, 45, 62, 0.9) !important;',
			'head-bg' => 'background: linear-gradient(to right, #cb2d3e, #ef473a);',
		),
		'matini'    => array(
			'name'    => '黄色',
			'color'   => 'black',
			'nav-bg0' => 'background: linear-gradient(-90deg, #FF00A1, #F6FF00) !important;',
			'nav-bg'  => 'background-color : rgba(246, 255, 0, 0.95) !important;',
			'head-bg' => 'background: linear-gradient(-90deg, #FF00A1, #F6FF00);',
		),
		'leaf'      => array(
			'name'    => '緑色',
			'color'   => 'white',
			'nav-bg0' => 'background: linear-gradient(to bottom, #76b852, #8dc26f) !important;',
			'nav-bg'  => 'background-color : rgba(118, 184, 82, 0.9) !important;',
			'head-bg' => 'background: linear-gradient(to bottom, #76b852, #8dc26f);',
		),
		'purple'    => array(
			'name'    => '濃い紫色',
			'color'   => 'white',
			'nav-bg0' => 'background: linear-gradient(to bottom, #41295a, #2f0743) !important;',
			'nav-bg'  => 'background-color : rgba(65, 41, 90, 0.9) !important;',
			'head-bg' => 'background: linear-gradient(to bottom, #41295a, #2f0743);',
		),
	);

	if ( ! isset( $scheme[ $key ] ) ) {
		$key = 'snow';
	}

	$scheme = apply_filters( 'kns_set_color_set', $scheme );

	/* v1.0から選択肢を2つに減らした。基本的に、additional cssで設定する */
	if ( $choices ) {
		$tmp_arr = array();

		foreach ( $scheme as $k => $v ) {
			$tmp_arr[ $k ] = $v['name'];
		}
		return $tmp_arr;
	}

	return $scheme[ $key ];
}
