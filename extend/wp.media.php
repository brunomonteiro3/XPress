<?php

/**
 * wp.media.php - Media related functions and filters are found in the 
 * media extensions. You can also find the [gallery] shortcode in here.
 * 
 * @since 0.1
 */

// http://wordpress.stackexchange.com/questions/4307/how-can-i-add-an-image-upload-field-directly-to-a-custom-write-panel/4413#4413
/*

$fh - File Handler $_FILE
$post_id - ID of parent post
$title - title Of images
$to_thumb - make it parent post thumnail?

if ($_FILES['thumbnail']){
  insert_attachment($_FILES['thumbnail'],$ID, $_POST['post']['post_title'], true);
}

*/

function insert_attachment($fh, $post_id, $title, $to_thumb = false) {
  $success = false;
 if($fh['error'] == 0){
      require_once(DIR_ADMIN .'/includes/file.php');
      $accept_types = array('image/jpg','image/jpeg','image/gif','image/png');

      if(in_array($fh['type'],$accept_types)){
        $wp_file = wp_handle_upload($fh, array('test_form' => false));
              $file = $wp_file['file'];

              // Set up options array to add this file as an attachment
              $attachment = array(
                'post_mime_type' => $fh['type'],
                'post_title' => $title,
                'post_content' => '',
                'post_status' => 'inherit',
                'post_parent' => $post_id
              );
              // Run the wp_insert_attachment function. This adds the file to the media library and generates the thumbnails. If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
              $attach_id = wp_insert_attachment($attachment, $file);

              require_once(DIR_ADMIN .'includes/image.php');
              $attach_data = wp_generate_attachment_metadata($attach_id, $file);
              wp_update_attachment_metadata($attach_id,  $attach_data);
              update_post_meta($post_id, '_thumbnail_id',$attach_id);

              $success = true;
      }

    }

    return $success;
}