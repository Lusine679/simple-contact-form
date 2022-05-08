<?php
function scf_shortcode($data) {
        require_once ("scf_print_form.php");
        $SCF_print_form = new SCF_print_form();
        return $SCF_print_form->print_form();
}
add_shortcode(SCF_PLUGIN_PREFIX, 'scf_shortcode');
