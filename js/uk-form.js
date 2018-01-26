/**
 * uk-form.js
 *
 * フォームに、uikit の class を付ける
 *
 * Learn more: https://git.io/vWdr2
 */
 jQuery(function(){
  //なにかしらの処理
  jQuery('input').addClass('uk-input');
  jQuery('select').addClass("uk-select");
  jQuery('textarea').addClass("uk-textarea");
  jQuery('radio').addClass("uk-radio");
  jQuery('checkbox').addClass("uk-checkbox");
  jQuery('range').addClass("uk-range");  
  jQuery(':submit').addClass('uk-button uk-button-primary');
  jQuery('label').addClass('uk-form-label');
  
  jQuery('.comment-reply-link').addClass('uk-button uk-button-default');
  
});

