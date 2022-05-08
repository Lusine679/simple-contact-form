<?php
/**
 * Plugin Name:     Simple Contact form
 * Description:     Simple Contact Form to get users in admin panel.
 * Version:         1.0.0
 * Author:          Lusine
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('SCF_MAIN_FILE')) {
    define('SCF_MAIN_FILE', plugin_basename(__FILE__));
}
if (!defined('SCF_DIR')) {
    define('SCF_DIR', dirname(__FILE__));
}
if (!defined('SCF_URL')) {
    define('SCF_URL', plugins_url(plugin_basename(dirname(__FILE__))));
}


if (!defined('SCF_VERSION')) {
    define('SCF_VERSION', "1.0.0");
}

if (!defined('SCF_PLUGIN_MAIN_FILE')) {
    define('SCF_PLUGIN_MAIN_FILE', __FILE__);
}
if (!defined('SCF_PLUGIN_PREFIX')) {
    define('SCF_PLUGIN_PREFIX', "scf");
}
if(!is_admin()){
    require_once ("scf_class.php");
    add_action('plugins_loaded', array('SCF', 'get_instance'));
}

if (is_admin()) {
    require_once('scf_admin_class.php');
    add_action('plugins_loaded', array('SCF_Admin', 'get_instance'));
}