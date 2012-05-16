<?php



// Handles outputting document title
function the_doc_title(){
  global $paged;
  print_r($s);
 echo '[';
 if (function_exists('is_tag') && is_tag()) {
      single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; 
    } elseif (is_archive()){
      wp_title(''); echo ' In the Past - '; 
    } elseif (is_search()) {
          echo 'Search for &quot;'. wp_specialchars(get_search_query()) .'&quot; - '; 
        
    } elseif (!(is_404()) && (is_single()) || (is_page())) {
      wp_title(''); echo ' - '; 
    } elseif (is_404()) {
        echo 'Not Found - '; 
    } if (is_home()) {
      bloginfo('name'); echo ' - '; bloginfo('description'); 
    } else {
      bloginfo('name'); 
    }

    if ($paged > 1) {
             echo ' - page '. $paged; 
    }
   echo ' ]';
}

// http://wpsnipp.com/index.php/css/alternate-odd-even-post-class/
// Adding odd even classes to posts
function oddeven_post_class($classes) {
   static $current_class = 'odd-post';
   $classes[] = $current_class;
   $current_class = ($current_class == 'odd-post') ? 'even-post' : 'odd-post';
   return $classes;
}
add_filter ('post_class' ,'oddeven_post_class');


// New custom excerpt length
function update_excerpt_length($length) {
  return 20;
}
add_filter('excerpt_length', 'update_excerpt_length');




 function search_hilighter($content, $terms) {
    $do_not_highlight = array( "a", "A", "is", "Is", "the", "The", "and", "And" );
    $search_term = $terms;
    foreach ($search_term as $search_t) {
            preg_match_all("/$search_t+/i", $content, $matches);
            foreach ($matches as $match) {
                if (!in_array($match[0],$do_not_highlight)) {
                $content = str_replace($match[0], "[m]" . $match[0] . "[mm]", $content);
                }
            }
        }
 
        $find = array("[m]","[mm]");
        $replace = array('<span class="hilite-result">','</span>');
        $highlighted_content = str_replace($find,$replace,$content);   
    echo $highlighted_content;
}

function post_errors($errors = array()){
  if(count($errors) > 0){
    foreach($errors as $error){
      echo '<div class="notification error">'."$error</div>";
    }
  }
}

/*
// Use if you have private or protected content
function the_title_trim($title) {
  $title = attribute_escape($title);
  $findthese = array(
    '#Protected:#',
    '#Private:#'
  );
  $replacewith = array(
    '', // What to replace "Protected:" with
    '' // What to replace "Private:" with
  );
  $title = preg_replace($findthese, $replacewith, $title);
  return $title;
}
add_filter('the_title', 'the_title_trim');
*/
