<?php
	
//	add_action( 'add_meta_boxes', 'register_kns_lead_meta_boxes' );
	add_action( 'save_post', 'save_kns_lead_meta_boxes' );
	
	
	add_action('edit_form_after_title', 'display_kns_lead_meta_box');


	function display_kns_lead_meta_box( $post )
	{
		$id = get_the_ID();
		
		// embed
		$kns_lead = get_post_meta($id, 'kns_lead', true);
								
		wp_nonce_field( 'kns_lead_meta_box', 'kns_lead_meta_box_nonce' );
		echo <<<EOD
<p><b>リード文(サブタイトル)</b>（任意）:<br>
<input type="text" name="kns_lead" value="{$kns_lead}" style="width:100%"></p>
EOD;

	}
	function save_kns_lead_meta_boxes($post_id)
	{
        // Check if our nonce is set.
        if ( ! isset( $_POST['kns_lead_meta_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['kns_lead_meta_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'kns_lead_meta_box' ) ) {
            return $post_id;
        }
		
		$kns_lead = isset($_POST['kns_lead']) ? $_POST['kns_lead'] : null;		
		$before = get_post_meta($post_id, 'kns_lead', true);
		
		if($kns_lead)
		{
			update_post_meta($post_id, 'kns_lead', wp_kses($kns_lead) );
		}
		else
		{
			delete_post_meta($post_id, 'kns_lead', $before);
		}
	}