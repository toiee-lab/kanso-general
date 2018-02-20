<?php
	

// 色のセットを返す
//   color は、light か dark をセットする
//   nav-bg は、background の css を返す
//   head-bg は、background の css を返す
function kns_get_color_set($key, $choices = false)
{
	$scheme = array(
		
		'simple' => array(
			'name'    => 'ネイビー(紺色)',
			'color'   => 'light',
			'nav-bg'  => 'background-color : rgba(36, 59, 85, 0.8);',
			'head-bg' => 'background: linear-gradient(to right, #141e30, #243b55); '
		),
		
		'deepblack' => array(
			'name'    => 'ブラック',
			'color'   => 'light',
			'nav-bg'  => 'background-color : rgba(0, 0, 0, 0.8);',
			'head-bg' => 'background: linear-gradient(to top, #000000, #434343); '
		),
		
		'royal' => array(
			'name'    => '紫色',
			'color'   => 'light',
			'nav-bg'  => 'background-color : rgba(48, 43, 99, 0.7);',
			'head-bg' => 'background: linear-gradient(to right, #0f0c29, #302b63, #24243e); '
		),
		'transfile' => array(
			'name'    => '水色',
			'color'   => 'light',
			'nav-bg'  => 'background-color : rgba(22, 191, 253, 0.7);',
			'head-bg' => 'background: linear-gradient(to left, #16bffd, #cb3066); '
		),
		'snow' => array(
			'name'    => '白色',
			'color'   => 'dark',
			'nav-bg'  => 'background-color : rgba(255, 255, 255, 0.8); border-bottom: #eee 1px solid;',
			'head-bg' => 'background: linear-gradient(to bottom, #ece9e6, #ffffff); '
		),
		'firewatch' => array(
			'name'    => '赤色',
			'color'   => 'light',
			'nav-bg'  => 'background-color : rgba(203, 45, 62, 0.9);',
			'head-bg' => 'background: linear-gradient(to right, #cb2d3e, #ef473a); '
		),
		'matini' => array(
			'name'    => '黄色',
			'color'   => 'dark',
			'nav-bg'  => 'background-color : rgba(246, 255, 0, 0.95);',
			'head-bg' => 'background: linear-gradient(-90deg, #FF00A1, #F6FF00); '
		),
		'leaf' => array(
			'name'    => '緑色',
			'color'   => 'light',
			'nav-bg'  => 'background-color : rgba(118, 184, 82, 0.9);',
			'head-bg' => 'background: linear-gradient(to bottom, #76b852, #8dc26f); '
		),
		'purple' => array(
			'name'    => '濃い紫色',
			'color'   => 'light',
			'nav-bg'  => 'background-color : rgba(65, 41, 90, 0.9);',
			'head-bg' => 'background: linear-gradient(to bottom, #41295a, #2f0743); '
		),
	);
	
	if( ! isset($scheme[$key]) ) $key = 'simple';

	// 全部取得したい場合
	if( $choices ){
		$tmp_arr = array();
		
		foreach($scheme as $k=>$v)
		{
			$tmp_arr[$k] = $v['name'];
		}
				
		return $tmp_arr;
	}
	
	
	return $scheme[ $key ];
}
