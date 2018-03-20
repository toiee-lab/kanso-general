/**
 * kanso.js
 *
 * フォームに、uikit の class を付ける
 *
 * Learn more: https://git.io/vWdr2
 */
 jQuery(function(){
  //なにかしらの処理
  jQuery('input').addClass('uk-input');

  jQuery('input[type="radio"]').addClass('uk-radio');
  jQuery('input[type="radio"]').removeClass('uk-input');
  
  jQuery('input[type="checkbox"]').addClass('uk-checkbox');  
  jQuery('input[type="checkbox"]').removeClass('uk-input');  
  
  jQuery('select').addClass("uk-select");
  jQuery('textarea').addClass("uk-textarea");
  jQuery(':submit').addClass('uk-button uk-button-primary');
  jQuery('label').addClass('uk-form-label');
  
  jQuery('.comment-reply-link').addClass('uk-button uk-button-default');
  
  
  //スクロールに合わせて、移動させる
  jQuery(window).scroll( function(){
	  var sc = jQuery(this).scrollTop();
	  var head_h = jQuery('#kns-head').height();
	  
	  if(sc > head_h){
		  jQuery('#content-sidebar').css({'margin-top':sc-head_h+'px'});
	  }
  } );
  
});

