<?php
class SCF{
    protected static $instance = null;
    function __construct () {
        require_once ("includes/scf_shortcode.php");
        add_action('wp_enqueue_scripts', array($this, 'load_css_js'), 5);
    }

    public function load_css_js(){
        wp_enqueue_style( 'scf_front_style',  SCF_URL . '/assets/css/style.css', false, NULL, 'all' );
    }

    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}