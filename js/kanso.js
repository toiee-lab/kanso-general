/**
 * kanso.js
 *
 * フォームに、uikit の class を付ける
 *
 * Learn more: https://git.io/vWdr2
 */
jQuery(
	function(){

		jQuery( 'input' ).each(
			function( index, el ){

				switch ( el.type ) {
					case 'text' :
						el.classList.add( 'uk-input' );
						break;
					case 'radio' :
						el.classList.add( 'uk-radio' );
						break;
					case 'checkbox' :
						el.classList.add( 'uk-checkbox' );
						break;
					case 'range' :
						el.classList.add( 'uk-range' );
						break;
					case 'submit' :
						el.classList.add( 'uk-button' );
						el.classList.add( 'uk-button-primary' );
					default:
				}
			}
		);

		jQuery( 'select' ).addClass( 'uk-select' );
		jQuery( 'textarea' ).addClass( "uk-textarea" );
		jQuery( 'label' ).addClass( 'uk-form-label' );
		jQuery( '.comment-reply-link' ).addClass( 'uk-button uk-button-default' );

		jQuery( 'button' ).each(
			function( index, el ){
				if ( el.classList.contains( 'uk-button' ) ) {
					// do nothing
				} else {
					el.classList.add( 'uk-button', 'uk-button-default' );
				}
			}
		);
});

