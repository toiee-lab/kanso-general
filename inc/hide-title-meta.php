<?php
	
	add_action( 'add_meta_boxes', 'register_kns_hidetitle_meta_boxes' );
	add_action( 'save_post', 'save_kns_hidetitle_meta_boxes' );
	
	
//	add_action('edit_form_after_title', 'display_kns_hidetitle_meta_box');


	function display_kns_hidetitle_meta_box( $post )
	{
		$id = get_the_ID();
		
		// embed
		$kns_hidetitle = get_post_meta($id, 'kns_hidetitle', true);
		$checked = ($kns_hidetitle == 1) ? 'checked="checked"' : '';

		wp_nonce_field( 'kns_hidetitle_meta_box', 'kns_hidetitle_meta_box_nonce' );
		echo <<<EOD
<p>タイトルを表示したくない場合、以下にチェックを入れてください。</p>
<p><label><input type="checkbox" name="kns_hidetitle" value="1" {$checked}> 非表示にする</label></p>
EOD;


	}
	function save_kns_hidetitle_meta_boxes($post_id)
	{
        // Check if our nonce is set.
        if ( ! isset( $_POST['kns_hidetitle_meta_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['kns_hidetitle_meta_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'kns_hidetitle_meta_box' ) ) {
            return $post_id;
        }
		
		$kns_hidetitle = isset($_POST['kns_hidetitle']) ? $_POST['kns_hidetitle'] : null;		
		$before = get_post_meta($post_id, 'kns_hidetitle', true);
		
		if($kns_hidetitle)
		{
			update_post_meta($post_id, 'kns_hidetitle', $kns_hidetitle );
		}
		else
		{
			delete_post_meta($post_id, 'kns_hidetitle', $before);
		}
	}
	function register_kns_hidetitle_meta_boxes()
	{
		add_meta_box('kns_hidetitle', 'タイトルの非表示', 'display_kns_hidetitle_meta_box', 'page', 'side' );
	}