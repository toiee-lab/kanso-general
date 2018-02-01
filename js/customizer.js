/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
	
	
	// site title
	wp.cutomize( 'kanso_general_options_htitle', function( value ){
		value.bind( function( to ){
			$( '#kanso_general_options_htitle' ).text( to );
		} );
	} );
	wp.cutomize( 'kanso_general_options_hsubtitle', function( value ){
		value.bind( function( to ){
			$( '#kanso_general_options_hsubtitle' ).text( to );			
		} );		
	} );
	
	wp.customize( 'kanso_general_options_ownername', function( value ) {
		value.bind( function( to ) {
			$( '.ownername' ).text( to );
		} );
	} );

	
	// header height
	wp.customize( 'kanso_general_options_height', function( value ){
		value.bind( function( to ){
			
			$( '#kanso_general_options_height').css({
				'height' : to
			} );
			
		} );
	} );
	
	// front page nav , header color
	wp.customize( 'kanso_general_customize_partial_frontcolor', function( value ){
		value.bind( function( to ){
			
			$( '#kns-head-nav').removeClass('uk-light');
			$( '#kns-head-nav').removeClass('uk-dark');
			
			$( '#kns-head-nav').removeClass('uk-'+to);
			
		} );
	} );	
	
	// color set を反映する
	wp.customize( 'kanso_general_customize_partial_colors', function( value ){
		value.bind( function( to ){
// やらなきゃいけないけど、やらなくてもいいのかなー			
//			$colors = eval( to );
//			debug.print( $colors );
			
//			$( '#kns-head-nav').removeClass('uk-light');
//			$( '#kns-head-nav').removeClass('uk-dark');
			
//			$( '#kns-head-nav').removeClass('uk-'+to);
			
		} );
	} );
	
	
	
} )( jQuery );
