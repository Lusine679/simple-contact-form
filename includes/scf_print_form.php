<?php
class SCF_print_form{
    
    public function print_form(){
        $data = '<h3>Contact Form</h3>
                <div class="container scf-form">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="contact_form">
                            <div>
                                <label>First Name</label>
                                <input type="text" class="scf-firstname form" name="scf-firstname" placeholder="Your name.." required>
                            
                                <label>Your Email</label>
                                <input type="email" class="scf-email form" name="scf-email" value="" placeholder="Your email.." required>
                                
                            </div>
                            <div>
                                <label>Last Name</label>
                                <input type="text" class="scf-lastname form" name="scf-lastname" placeholder="Your last name.." required>
                                
                                <label for="date">Date</label>
                                <input type="date" class="scf-date form" name="scf-date" value="" required>
                            </div>
                        </div>
                            
                        <label for="subject">File</label>
                        <input type="file" id="file-upload" class="scf-file form" name="scf-file" required>

                        
                        <input type="checkbox" name="checkbox" checked required>
                        <label for="contact_method"> I accept the Terms and Conditions</label>

                        <input type="submit" value="Save" name="scf-save-data" class="scf-save-data form">
                    </form>
                </div>';
            
            if(isset($_POST['scf-save-data'])){
                global $post;
                $post_id = $post->ID;
            
                $user_firstname = $_POST['scf-firstname'];
                $user_lastname = $_POST['scf-lastname'];
                $user_email = $_POST['scf-email'];
                $date = $_POST['scf-date'];
                $file = $_FILES['scf-file']['name'];
                
                // save in the file
                $uploaded_file = wp_upload_bits( $_FILES['scf-file']['name'], null, @file_get_contents( $_FILES['scf-file']['tmp_name'] ) ); 
                $file_url = $uploaded_file['url'];

                $arr = array(
                    'firstname' => $user_firstname,
                    'lastname' => $user_lastname,
                    'email' => $user_email,
                    'date' => $date,
                    'file' => $file_url
                );

                add_post_meta($post_id, "scf_form", $arr);    
 
                // save in the media
                $wp_upload_dir = wp_upload_dir();
                $filetype = wp_check_filetype(basename($file), null);
                $filename = $wp_upload_dir['path'] . '/' . wp_unique_filename($wp_upload_dir['path'], basename($file));

                $attachment = array(
                    'guid'           => $file,
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );

                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                require_once(ABSPATH . "wp-admin" . '/includes/media.php');
                
                $attachment_id = media_handle_upload('scf-file', $post->ID);     
            }
            return $data;
    }
}