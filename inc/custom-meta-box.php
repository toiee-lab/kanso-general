<?php

$kns_metabox = new Kns_MetaBox();

class Kns_MetaBox
{	
	public function __construct() {
		//Widgetが必要とするカスタムフィールドを入力させる追加の投稿情報を表示、保存させる
		add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
		add_action( 'save_post', array($this, 'save_meta_boxes') );
		add_action( 'save_post', array($this, 'save_meta_boxes_exclude_eyecatch') );

	}
	
	/**
	* 投稿ページに「exclude_menu を入れる」場所を作る
	*/
	function register_meta_boxes()
	{
		add_meta_box('exclude_menu', '【KANSO】設定', array($this, 'display_meta_box'), 'page', 'side' );
		add_meta_box('exclude_eyecatch', 'アイキャッチ設定', array($this, 'display_meta_box_exclude_eyecatch'), 'post', 'side' );
	}
	
	
	function display_meta_box( $post )
	{
		$id = get_the_ID();

		// タイトル非表示
		$kns_hidetitle = get_post_meta($id, 'kns_hidetitle', true);
		$checked_htitle = ($kns_hidetitle == 1) ? 'checked="checked"' : '';
		
		// サムネイル非表示
		$kns_hidethumb = get_post_meta($id, 'kns_hidethumb', true);;
		$checked_thumb = ($kns_hidethumb == 1) ? 'checked="checked"' : '';
		
		
		// embed
		$exclude_menu = get_post_meta($id, 'exclude_menu', true);
		$checked = ($exclude_menu == 1) ? 'checked="checked"' : '';
		
		$toc_starting_point = get_post_meta($id, 'toc_starting_point', true);
		$checked_toc_starting_point = ($toc_starting_point == 1) ? 'checked="checked"' : '';
		
		$toc_starting_point_depth = get_post_meta($id, 'toc_starting_point_depth', true);
		$toc_starting_point_depth = is_numeric( $toc_starting_point_depth ) ? $toc_starting_point_depth : 0;

		wp_nonce_field( 'exclude_menu_meta_box', 'exclude_menu_meta_box_nonce' );
?>
<p style="font-weight: bold;margin-bottom: 0px;">表示設定</p>
<p style="margin-top: 0.5em;"><label><input type="checkbox" name="kns_hidetitle" value="1" <?php echo $checked_htitle; ?>> タイトル・サブタイトルを非表示にする</label><br>
<label><input type="checkbox" name="kns_hidethumb" value="1"  <?php echo $checked_thumb; ?>> サムネイルを非表示にする</label></p>

<p style="font-weight: bold;margin-bottom: 0px;">目次設定</p>
<p style="margin-top: 0.5em;"><label><input type="checkbox" name="exclude_menu" value="1" <?php echo $checked; ?>> 目次に表示しない</label><br>
<label><input type="checkbox" name="toc_starting_point" value="1" <?php echo $checked_toc_starting_point; ?>> 目次の起点にする</label><br>
<input type="text" name="toc_starting_point_depth" size="2" value="<?php echo $toc_starting_point_depth;?>"> 表示する階層の深さ(数値)<br>
<small>起点に設定すると、このページの子ページをサイドバーの目次として使います。</small></p>
<?php

	}
	
	function save_meta_boxes($post_id)
	{
        // Check if our nonce is set.
        if ( ! isset( $_POST['exclude_menu_meta_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['exclude_menu_meta_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'exclude_menu_meta_box' ) ) {
            return $post_id;
        }
		
		$exclude_menu = isset($_POST['exclude_menu']) ? $_POST['exclude_menu'] : null;
		$before = get_post_meta($post_id, 'exclude_menu', true);		
		if($exclude_menu)
		{
			update_post_meta($post_id, 'exclude_menu', $exclude_menu);
		}
		else
		{
			delete_post_meta($post_id, 'exclude_menu', $before);
		}
		
		
		$toc_starting_point = isset($_POST['toc_starting_point']) ? $_POST['toc_starting_point'] : null;
		$before = get_post_meta($post_id, 'toc_starting_point', true);
		if($toc_starting_point){
			update_post_meta($post_id, 'toc_starting_point', $toc_starting_point);
		}
		else{
			delete_post_meta($post_id, 'toc_starting_point', $before);
		}
		
		
		$toc_starting_point_depth = isset($_POST['toc_starting_point_depth']) ? $_POST['toc_starting_point_depth'] : null;
		$before = get_post_meta($post_id, 'toc_starting_point_depth', true);
		if($toc_starting_point_depth){
			update_post_meta($post_id, 'toc_starting_point_depth', $toc_starting_point_depth);
		}
		else{
			delete_post_meta($post_id, 'toc_starting_point_depth', $before);
		}
		
		
		// タイトルの表示、非表示の保存
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
		
		// サムネイルの表示、非表示
		$kns_hidethumb = isset($_POST['kns_hidethumb']) ? $_POST['kns_hidethumb'] : null;
		$before = get_post_meta($post_id, 'kns_hidethumb', true);
		
		if($kns_hidethumb)
		{
			update_post_meta($post_id, 'kns_hidethumb', $kns_hidethumb );
		}
		else
		{
			delete_post_meta($post_id, 'kns_hidethumb', $before);
		}
	}
	
	
	function display_meta_box_exclude_eyecatch( $post ) {
		$id = get_the_ID();
		
		// サムネイル非表示
		$kns_hidethumb = get_post_meta($id, 'kns_hidethumb', true);;
		$checked_thumb = ($kns_hidethumb == 1) ? 'checked="checked"' : '';

		wp_nonce_field( 'exclude_eyecatch_meta_box', 'exclude_eyecatch_meta_box_nonce' );
?>
<p><label><input type="checkbox" name="kns_hidethumb" value="1"  <?php echo $checked_thumb; ?>> サムネイルを非表示にする</label></p>
<?php		
	}
	
	function save_meta_boxes_exclude_eyecatch( $post_id ) {
        // Check if our nonce is set.
        if ( ! isset( $_POST['exclude_eyecatch_meta_box_nonce'] ) ) {
            return $post_id;
        }
        
        // Verify that the nonce is valid.
        $nonce = $_POST['exclude_eyecatch_meta_box_nonce'];
        if ( ! wp_verify_nonce( $nonce, 'exclude_eyecatch_meta_box' ) ) {
            return $post_id;
        }

		// サムネイルの表示、非表示
		$kns_hidethumb = isset($_POST['kns_hidethumb']) ? $_POST['kns_hidethumb'] : null;
		$before = get_post_meta($post_id, 'kns_hidethumb', true);
		
		if($kns_hidethumb)
		{			
			update_post_meta($post_id, 'kns_hidethumb', $kns_hidethumb );
		}
		else
		{
			delete_post_meta($post_id, 'kns_hidethumb', $before);
		}
	}
}