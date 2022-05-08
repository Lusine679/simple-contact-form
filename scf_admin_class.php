<?php

Class SCF_Admin{
    protected static $instance = null;
    private $prefix = "scf";

    private function __construct() {
        add_filter('media_buttons', array( $this, 'add_shortcode_button' ) );
        add_action("admin_enqueue_scripts", array($this, "load_admin_styles"));
        add_action('enqueue_block_editor_assets', array($this,'enqueue_block_editor_assets' ));
        add_action("admin_enqueue_scripts", array($this, "load_admin_scripts"));
        add_action('admin_menu', array($this, 'user_list'));
    }

    public function add_shortcode_button($context){
        $icon_url = plugins_url('/assets/images/contact-form.png', SCF_MAIN_FILE);
       echo '<a onclick="" href="" class="button scf_open_shortcode_popup" title="">
                        <span class="wp-media-buttons-icon" style="vertical-align: text-bottom; width: 16px; height: 16px;">
                        <img style="width: 100%; height: 100%; vertical-align: unset; padding: 0;" src="'.plugins_url('/assets/images/contact-form.png', SCF_MAIN_FILE).'">
                        </span>
                        Contact Form
                    </a>';
    }

    public function load_admin_scripts(){
        wp_enqueue_script( 'jquery' );
        wp_enqueue_media();
    
        wp_register_script( 'add_shortcode_js', SCF_URL . '/assets/admin/js/add_shortcode.js', array( 'jquery') , SCF_VERSION, true );
        wp_enqueue_script( 'add_shortcode_js' );
    }

    public function user_list(){
        add_menu_page('Contact Form', 'Contact Form', 'manage_options', 'my-menu', array($this,"scf_users_view") );
    }

    public function scf_users_view(){
        require_once ("admin/view/user_list.php");
    }

    public function load_admin_styles(){
        wp_enqueue_style( 'load_admin_styles', SCF_URL . '/assets/admin/css/scf_admin.css',"", SCF_VERSION );
    }

    public function enqueue_block_editor_assets() {
        $key = 'sc/scf';
        $plugin_name = "Contact Form";
        $icon_url = plugins_url('/assets/images/contact-form.png', SCF_MAIN_FILE);
        $icon_svg = plugins_url('/assets/images/contact-form.png', SCF_MAIN_FILE);
        ?>
        <script>
            if ( !window['scf_gb'] ) {
                window['scf_gb'] = {};
            }
            if ( !window['scf_gb']['<?php echo $key; ?>'] ) {
                window['scf_gb']['<?php echo $key; ?>'] = {
                    title: '<?php echo $plugin_name; ?>',
                    titleSelect: '<?php echo $plugin_name; ?>',
                    iconUrl: '<?php echo $icon_url; ?>',
                    iconSvg: {
                        width: '30',
                        height: '30',
                        src: '<?php echo $icon_svg; ?>'
                    },
                };
            }
        </script>
        <?php
        wp_enqueue_script( 'scf_gb_scf_js', SCF_URL . '/assets/admin/js/scf_block.js', array( 'wp-blocks', 'wp-element' ), SCF_VERSION );
        wp_localize_script('scf_gb_scf_js', 'sc_obj', array());
    }

    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}