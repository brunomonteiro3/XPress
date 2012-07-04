<?php


// Use if you need to modify menu output
//http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
class x_menu_extended extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0)
           {
                     $description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}




// function for caching menus
function x_menu_cache($args = array()){
  global $post;
  if(isset($args['menu_id'])){
    $menu_file = DIR_CACHE.$args['menu_id'].''.$post->ID.'.html.cache';
      if(!file_exists($menu_file)){
          $_args = array(
            'show_home'     => true,
            'menu'          => '', 
            'container'     => '',
            'container_id'  => '',
            'fallback_cb'   => 'wp_page_menu',
            'echo'          => false,
            'walker' => new x_menu_extended()
          );
          
          foreach($args as $arg => $value) {
            $_args[$arg] = $value;
          }
      
          
          $menu = "<!-- [cached]  ".date("F j, Y, g:i a") ." -->\n";
          $menu .= wp_nav_menu($_args);
          $menu .= "\n<!-- // [cached] -->\n"; 

        file_put_contents($menu_file, $menu);
      }

      include_once($menu_file);
    } else {
       wp_nav_menu($args);
    }
}
global $pagenow;
// Flushes menu cache if menus are changed
if(isset($_POST['action']) && $pagenow === 'nav-menus.php'){
  array_map('unlink', glob(DIR_CACHE.'*.html.cache'));
}


function x_flush_cache(){
   array_map('unlink', glob(DIR_CACHE.'*'));
}


function x_page_group_menu(){
  global $post;
  $cache_file = DIR_CACHE .'pm.'.$post->ID.'.html.cache';
  if(!file_exists($cache_file)){
    $pages = "<!-- [cached]  ".date("F j, Y, g:i a") ." -->\n";
    $pages .= wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
    
    if(!$pages){
      $pages .= wp_list_pages("title_li=&include=".$post->ancestors[0]."&echo=0");
      $pages .= wp_list_pages("title_li=&child_of=".$post->ancestors[0]."&exclude=".$post->ID."&echo=0");
    }

    $pages = "<!-- [cached] -->\n";
    
    file_put_contents($cache_file, $pages);
  }
  include_once($cache_file);
}

add_action('save_post','x_flush_cache');


// http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
function x_post_pagination($pages = '', $range = 3){  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == ''){
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages){
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}