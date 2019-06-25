<?php


$kns_lead_obj = new Kns_Lead();

class Kns_Lead {

	public function __construct() {
		global $pagenow;
		if ( in_array(
			$pagenow,
			array( 'post.php', 'post-new.php', 'page.php', 'page-new.php' )
		) ) {
			add_action( 'admin_init', array( &$this, 'admin_init' ) );

			add_action( 'save_post', array( &$this, 'save' ) );
		}
	}

	function admin_init() {
		add_action(
			'add_meta_boxes',
			function () {
				add_meta_box(
					'kns_lead',
					'サブタイトル',
					array( &$this, 'meta_box' ),
					array( 'page', 'post' ),
					'side',
					'high'
				);
			}
		);
	}

	function meta_box() {
		$id = get_the_ID();

		// embed
		$kns_lead = esc_attr( get_post_meta( $id, 'kns_lead', true ) );

		wp_nonce_field( 'kns_lead_meta_box', 'kns_lead_meta_box_nonce' );
			echo <<<EOD
<p><b>サブタイトル</b>（任意）:<br>
<input type="text" id="meta_kns_lead" name="meta_input[kns_lead]" value="{$kns_lead}" style="width:100%"></p>
EOD;

	}

	function save( $post_id ) {

		// Check if our nonce is set.
		if ( ! isset( $_POST['kns_lead_meta_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['kns_lead_meta_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'kns_lead_meta_box' ) ) {
			return $post_id;
		}

		$kns_lead = isset( $_POST['meta_input']['kns_lead'] ) ? $_POST['meta_input']['kns_lead'] : null;
		$before   = get_post_meta( $post_id, 'kns_lead', true );

		if ( $kns_lead ) {
			update_post_meta(
				$post_id,
				'kns_lead',
				wp_kses(
					$kns_lead,
					array(
						'a'      => array(
							'href'  => array(),
							'title' => array(),
						),
						'br'     => array(),
						'em'     => array(),
						'strong' => array(),
					)
				)
			);
		} else {
			delete_post_meta( $post_id, 'kns_lead', $before );
		}
	}
}
