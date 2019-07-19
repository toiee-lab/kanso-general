<?php

/**
 * Class Kanso_Upgrade
 */
class Kanso_Upgrade {

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'check_theme_version' ) );
		add_action( 'switch_theme', array( $this, 'options_removal' ) );
	}

	public function check_theme_version() {

		/* 親テーマがKANSOなら、親をセットする */
		$wp_theme = wp_get_theme();
		if ( false !== $wp_theme->parent() ) {
			$wp_theme = $wp_theme->parent();
		}

		$current_version = $wp_theme->get('Version');
		$old_version = get_option( 'kanso_theme_version' );

		if ($old_version !== $current_version) {
			/* before ver1.5 */
			if( false === $old_version ) {
				$this->upgrade_1_5();
			}

			update_option('kanso_theme_version', $current_version);
		}
	}

	private function upgrade_1_5() {
		/* ver1.5 exchange UserCustom to ACF */
		$list = [
			[
				'type'   => 'boolean',
				'before' => 'kns_hidetitle',
				'after'  => 'kns_hide_title',
				'init'   => false,
			],
			[
				'type'   => 'boolean',
				'before' => 'kns_hidethumb',
				'after'  => 'kns_hide_thumbnail',
				'init'   => false,
			],
			[
				'type'   => 'text',
				'before' => 'kns_lead',
				'after'  => 'kns_subtitle',
				'init'   => '',
			],
			[
				'type'   => 'boolean',
				'before' => 'exclude_menu',
				'after'  => 'kns_exclude_toc',
				'init'   => false,
			],
			[
				'type'   => 'boolean',
				'before' => 'toc_starting_point',
				'after'  => 'kns_toc_top',
				'init'   => false,
			],
			[
				'type'   => 'number',
				'before' => 'toc_starting_point_depth',
				'after'  => 'kns_toc_depth',
				'init'   => 0,
			],
		];

		foreach ( $list as $dat ) {

			$args = [
				'meta_key'       => $dat['before'],
				'post_type'      => [ 'page', 'post' ],
				'posts_per_page' => -1,
			];
			$posts = get_posts( $args );

			foreach ( $posts as $p ) {
				$pid   = $p->ID;
				$value = get_post_meta( $pid, $dat['before'], true );
				$value = ( '' === $value ) ? $dat['init'] : $value;

				update_field( $dat['after'], $value, $pid );
				delete_post_meta( $pid, $dat['before'] );
			}
		}
	}

	public function options_removal() {
		delete_option('kanso_theme_version');
	}
}
