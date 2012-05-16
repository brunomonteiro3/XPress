<?php

//http://wpengineer.com/2214/adding-input-fields-to-the-comment-form/
add_filter( 'preprocess_comment', 'verify_comment_captcha' );
function verify_comment_captcha( $commentdata ) {
    if ( !isset( $_POST['captcha'])){
       wp_die( __( 'Whoa! Did you use the number 3 for the CAPTCHA?' ));
    } else {
      if($_POST['captcha'] !== '3'){
        wp_die( __( 'Whoa! Did you use the number 3 for the CAPTCHA?' ));
      }
    }
    return $commentdata;
}

function theme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-meta">
        <span class="author-meta">
         <?php echo get_avatar($comment, $size = 32 ); ?>
         <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
       </span>
       <span class="datetime">
        <?php printf(__('%1$s'), get_comment_date('F jS, Y')) ?><?php edit_comment_link(__('(Edit)'),'  ','') ?></span>
      </div>
      <div class="comment-text">
      <?php comment_text() ?>
    </div>
      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        <?php if ($comment->comment_approved == '0') : ?> <em class="comment-status"><?php _e('Your comment is awaiting moderation.') ?></em><?php endif; ?>
      </div>
      
     </div>
<?php
}
