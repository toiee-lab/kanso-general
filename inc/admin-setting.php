<?php
class KnsSetting
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        
        // 設定に従って、動作を変更する
        $this->options = get_option( 'kns_options' );
        
	    if( isset( $this->options['ve_off'] ) && $this->options['ve_off'] == '1' ) {
	        add_action( 'load-post.php'    , array($this, 'disable_ve') );
	        add_action( 'load-post-new.php', array($this, 'disable_ve') );
	    }
    }
    
    public function disable_ve(){
	    global $typenow;
        switch( $typenow ){
	        case 'post':
	        case 'page':
	        	add_filter('user_can_richedit', function(){ return false; });
	        	break;
        }
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'KANSOテーマ設定', 
            'KANSO設定', 
            'manage_options', 
            'kns-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'kns_options' );
        ?>
        <div class="wrap">

            <h2>KANSOテーマ設定</h2>           
	           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'kns_option_group' );   
                do_settings_sections( 'kns-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'kns_option_group', // Option group
            'kns_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'kanso-layout-section', // ID
            'KANSOレイアウト設定', // Title
            array( $this, 'print_section_info_kns' ), // Callback
            'kns-setting-admin' // Page
        );  

        add_settings_field(
            'default_template', // ID
            'デフォルトテンプレート', // Title 
            array( $this, 'default_template_callback' ), // Callback
            'kns-setting-admin', // Page
            'kanso-layout-section' // Section           
        );    
        
        
        add_settings_section(
            'setting_section_id', // ID
            '【非推奨】KANSO動作設定', // Title
            array( $this, 'print_section_info' ), // Callback
            'kns-setting-admin' // Page
        );  

        add_settings_field(
            've_off', // ID
            'ビジュアルエディタ', // Title 
            array( $this, 've_off_callback' ), // Callback
            'kns-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'jp_markdown_eneble', 
            'JP Markdown', 
            array( $this, 'jp_markdown_eneble_callback' ), 
            'kns-setting-admin', 
            'setting_section_id'
        );
        
        add_settings_field(
            'parse_md_in_shortcode', // ID
            'ショートコード内のMarkdown', // Title 
            array( $this, 'parse_md_in_shortcode_callback' ), // Callback
            'kns-setting-admin', // Page
            'setting_section_id' // Section           
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['ve_off'] ) )
            $new_input['ve_off'] = absint( $input['ve_off'] );

        if( isset( $input['jp_markdown_eneble'] ) )
            $new_input['jp_markdown_eneble'] = sanitize_text_field( $input['jp_markdown_eneble'] );

        if( isset( $input['parse_md_in_shortcode'] ) )
            $new_input['parse_md_in_shortcode'] = sanitize_text_field( $input['parse_md_in_shortcode'] );

        if( isset( $input['kns_default_layout'] ) )
            $new_input['kns_default_layout'] = sanitize_text_field( $input['kns_default_layout'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print '以下は、古いバージョンのKANSOテーマの使い方をサポートするためのものです。基本的に使わないでください。';
    }
    
    public function print_section_info_kns()
    {
        print 'KANSOのテーマレイアウトなど見た目を調整できます。';
    }


    /** 
     * Get the settings option array and print one of its values
     */
    public function ve_off_callback()
    {
	    if( isset( $this->options['ve_off'] ) && $this->options['ve_off'] == '1' )
	    {
		    $off = 'checked';
		    $on  = '';
	    }
	    else
	    {
		    $off = '';
		    $on  = 'checked';
	    }
	    
        printf(
	        '<label><input type="radio" name="kns_options[ve_off]" value="1" %s>無効にする</label> &nbsp;&nbsp;
			 <label><input type="radio" name="kns_options[ve_off]" value="0" %s>有効(デフォルト)</label>',
            $off,
            $on
        );
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function jp_markdown_eneble_callback()
    {
	    // 使わないを明示されている場合
	    if( isset( $this->options['jp_markdown_eneble'] ) && $this->options['jp_markdown_eneble'] == '1' )
	    {
		    $on  = 'checked';
   		    $off = '';
	    }
	    else
	    {
   		    $on  = '';
		    $off = 'checked';
	    }
	    
        printf(
	        '<label><input type="radio" name="kns_options[jp_markdown_eneble]" value="1" %s>有効</label> &nbsp;&nbsp;
			 <label><input type="radio" name="kns_options[jp_markdown_eneble]" value="0" %s>無効</label>',
            $on,
            $off
        );
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function parse_md_in_shortcode_callback()
    {
	    if( isset( $this->options['parse_md_in_shortcode'] ) && $this->options['parse_md_in_shortcode'] == '0' )
	    {
   		    $off = '';
		    $on  = 'checked';
	    }
	    else
	    {
   		    $off = 'checked';
		    $on  = '';
	    }
	    
        printf(
	        '<label><input type="radio" name="kns_options[parse_md_in_shortcode]" value="1" %s>解釈する</label> &nbsp;&nbsp;
	        <label><input type="radio" name="kns_options[parse_md_in_shortcode]" value="0" %s>解釈しない</label>',
            $on,
            $off
        );
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function default_template_callback()
    {
	    // 使わないを明示されている場合
	    // 0:コンテンツのみ、 1:サイドバー付き
	    if(  !isset( $this->options['kns_default_layout'] ) || $this->options['kns_default_layout'] == 'content' )
	    {
		    $content  = 'checked';
		    $sidebar  = '';
	    }
	    else
	    {
		    $content  = '';
   		    $sidebar  = 'checked';
	    }
	    
        printf(
	        '<label><input type="radio" name="kns_options[kns_default_layout]" value="content" %s>コンテンツのみ</label> &nbsp;&nbsp;
			 <label><input type="radio" name="kns_options[kns_default_layout]" value="sidebar" %s>サイドバー付き</label><br>
			 <p><small>固定ページのデフォルトテンプレートの動作を指定することができます。<br>なお、各固定ページでは、手動でどちらのテンプレートでも、自由に選ぶことができます。</small></p>
			 ',
            $content,
            $sidebar
        );
    }    

}

if( is_admin() )
    $my_settings_page = new KnsSetting();