<?php

/**
* shortcodeがpタグに囲まれるfix
*
*/
function shortcode_empty_paragraph_fix($content) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
 
    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'shortcode_empty_paragraph_fix');	
	
/**
 * Alert
 */
add_shortcode( 'uk-alert' , function ( $atts , $content ){
	
	$atts = shortcode_atts( array(
		'class' => 'none',
		'title' => '',
		'icon'  => 'true',
	), $atts );
	extract( $atts );
	
	//key: name, value: icon
	$alerts = array(
		'none'    => 'info',
		'primary' => 'info',
		'success' => 'check',
		'warning' => 'warning',
		'danger'  => 'ban'
	);
	
	$add_class = array_key_exists( $class, $alerts )  ? ' class="uk-alert-'.$class.'"' : '';
	
	$icon_name = ( $icon == 'false' ) ? '' : $alerts[ $class ];
	$add_icon  = ($icon_name  == '' ) ? '' : '<span uk-icon="icon: '.$icon_name.'"></span>';
	
	//アイコンがあれば、タイトルにアイコンを入れる
	$title = $title == '' ? '' : '<h3>'.$add_icon.' '.$title.'</h3>';

	return "<div uk-alert{$add_class}>{$title}" . do_shortcode( str_replace('<p></p>', '', $content) ) . "</div>";
});

/**
 * icon
 */
add_shortcode( 'uk-icon' , function( $atts, $content ){
	$atts = shortcode_atts( array(
		'name' => 'dummydummy'
	), $atts);
	extract( $atts );
	 
	return '<span uk-icon="icon: '.$name.'"></span>';
});

