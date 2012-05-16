<?php

/**
 * Email related functions - i.e. enable HTML emails, setting custom 
 * password remind email etc.
 *  
 * @since 0.1
 * @file  wp.email.php
 */

// So you can send HTML emails, mate!  
function mail_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','mail_content_type' );

// http://wordpress.org/extend/plugins/welcome-email-editor/
add_filter('retrieve_password_title', 'lost_pass_title', 10, 1 );
add_filter('retrieve_password_message', 'lost_pass_message', 10, 2 );


function lost_pass_title(){
  return 'Title';
}

function lost_pass_message(){
  return 'Message';
}


//http://sltaylor.co.uk/blog/customizing-new-user-email-pluggable-function/
// Redefine user notification function  
if ( !function_exists('wp_new_user_notification') ) {  
    function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {  
        $user = new WP_User($user_id);  
  
        $user_login = stripslashes($user->user_login);  
        $user_email = stripslashes($user->user_email);  
  
        $message  = sprintf(__('New user registration on your blog %s:'), get_option('blogname')) . "\r\n\r\n";  
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";  
        $message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";  
  
        @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message);  
  
        if ( emptyempty($plaintext_pass) )  
            return;  
  
        $message  = __('Hi there,') . "\r\n\r\n";  
        $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n"; 
        $message .= wp_login_url() . "\r\n"; 
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n"; 
        $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n\r\n"; 
        $message .= sprintf(__('If you have any problems, please contact me at %s.'), get_option('admin_email')) . "\r\n\r\n"; 
        $message .= __('Adios!');  
  
        wp_mail($user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message);  
  
    }  
}  