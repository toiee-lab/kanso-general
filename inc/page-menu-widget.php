<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * menu_exclude カスタムフィールドを設定すると、メニューウィジェットから除外します。
 *
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package kanso-manual
 */

/**
 * Class PageToc_Widget
 */
class PageToc_Widget extends WP_Widget {

	/**
	 * PageToc_Widget コンストラクタ
	 */
	public function __construct() {
		
		$widget_options = array(
			'classname'                     => 'pagetoc-widget',
			'description'                   => '固定ページの階層を利用して、目次メニューを出力します',
			'customize_selective_refresh'   => true,
		);
		$control_options = array( 'width' => 400, 'height' => 350 );

		parent::__construct( 'pagetoc-widget', 'KANSO 固定ページ目次', $widget_options, $control_options );
	}

	/**
	 * //! ウィジェットの内容をWebページに出力します（HTML表示）
	 *
	 * @param array $args       register_sidebar()で設定したウィジェットの開始/終了タグ、タイトルの開始/終了タグなどが渡される。
	 * @param array $instance   管理画面から入力した値が渡される。
	 */
	public function widget( $args, $instance ) {
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		$widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';
		$depth = is_numeric( $instance['depth'] ) ? $instance['depth'] : 0;
		
		//目次起点設定を検索し、あれば設定する
		$child_of = '';
		$post_id = get_the_ID();
		$tsp = get_post_meta( $post_id, 'toc_starting_point' , true);
		if( $tsp ){
			$child_of = $post_id;
		}
		else{
			$ancs = get_post_ancestors( $post_id );
			foreach( $ancs as $a_id){
				$tsp = get_post_meta( $a_id, 'toc_starting_point', true);
				if( $tsp ){
					$child_of = $a_id;
					break;
				}
			}
		}
		
		//起点になっている場合は、タイトルを修正し、depth も修正する
		if( $child_of !== ''){
			$title = get_the_title( $child_of );
			$widget_text = get_post_meta( $child_of, 'kns_lead', true );
			
			$depth = get_post_meta( $child_of, 'toc_starting_point_depth', true );
			$depth = is_numeric( $depth ) ? $depth : 0;
		}
		

		echo $args['before_widget'];
		
		if ( ! empty( $title ) ) {
//			echo $args['before_title'] . $title . $args['after_title'];
			echo '<h3>' . $title . '</h3>';
		} ?>
        <p class="pagetoc-widget-text"><?php echo $widget_text; ?></p>
		<ul class="uk-nav uk-nav-default tm-nav">
		<?php
			
			$q = array (
					'post_type'		=> 'page',
					'meta_key'		=> 'exclude_menu',
					'meta_value'	=> 1,
					'compare' 		=> '=',
					'posts_per_page' => -1
				);
			$the_query = new WP_Query( $q );
			$tmp_posts = $the_query->posts;
			
			$ex_ids = '';
			foreach($tmp_posts as $p)
			{
				$ex_ids .= $p->ID.',';
			}
			$ret = wp_list_pages( array( 'title_li' => '', "exclude" =>$ex_ids, 'echo'=>0, 'depth'=>$depth, 'child_of'=>$child_of) );

			$ret = preg_replace('/class="(.*?)current_page_item/', 'class="$1current_page_item router-link-exact-active uk-active', $ret);
			echo $ret;
		?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * 管理画面のウィジェット設定フォームを出力します。
	 *
	 * @param array $instance   現在のオプション値が渡される。
	 */
	public function form( $instance ) {
		$defaults = array(
			'title' => '',
			'text'  => '',
			'depth' => '0',
		);

		$instance   = wp_parse_args( (array) $instance, $defaults );
		
		$title  = sanitize_text_field( $instance['title'] );
		$depth  = is_numeric($instance['depth']) ? $instance['depth'] : 0;
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'タイトル' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( '説明文' ); ?></label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id( 'depth' ); ?>"><?php _e( '表示する階層の深さ' ); ?></label>
	        <input class="" size="2" id="<?php echo $this->get_field_id( 'depth' ); ?>" name="<?php echo $this->get_field_name( 'depth' ); ?>" value="<?php echo esc_attr( $depth ); ?>" />
        </p>
		<?php
	}

	/**
	 * ウィジェットオプションのデータ検証/無害化
	 *
	 * @param array $new_instance   新しいオプション値
	 * @param array $old_instance   以前のオプション値
	 *
	 * @return array データ検証/無害化した値を返す
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']  = sanitize_text_field( $new_instance['title'] );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text']   = $new_instance['text'];
			
		} else {
			$instance['text']   = wp_kses_post( $new_instance['text'] );
		}
		
		$instance['depth']  = is_numeric($new_instance['depth']) ? $new_instance['depth'] : 0;

		return $instance;
	}
}

