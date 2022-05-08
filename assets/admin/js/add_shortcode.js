jQuery(function($){
    $('body').on('click', '.scf_open_shortcode_popup', function(e){
        e.preventDefault();
        send_to_editor('[scf]');
    });
});