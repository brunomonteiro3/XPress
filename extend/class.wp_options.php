<?php

/**
 * Class to easily add/organize menu pages to WordPress as well as tabs to custom Pages
 *
 * @author Andres Hermosilla
 * @copyright Copyright 2011, Andres Hermosilla
 * @license Dual licensed under the MIT or GPL Version 2 licenses.
 * @version 0.1
 * 
 */

class WP_options {

	 public static $pages = array();
	 public static $tabs= array();
	 public static $now;
	

/**
 *  Add Tabs to existing custom pages (not core wordpress pages)
 * @param string [$title] Title of tab outputted
 * @param string [$slug] URL slug to access tab
 * @param string [$parent] parent URL slug
 * @param string [$function] name of function to call when tab loads
 *
 */
public function addTab($title = null, $slug = null ,$parent = null, $function = null){
	if($title == null){
		// no parameters passed 
		throw new Exception("Make sure to pass in appropriate parameters for addTab");  
	} elseif($function == null){
		// no function passed = not all required parameters filled
		throw new Exception("Add all parameters. Also Make sure to pass in function parameter for addTab");  
	}
	self::$pages[$parent]['tabs'][$slug] = array('title'=>$title,'slug'=>$slug,'function'=>$function);
}

/**
 * Add Primary pages to the Main Menu, takes same parameters core WP function add_menu_page() takes
 * @param string [$page_title] Title of page outputted in when in page
 * @param string [$menu_title] Title of page outputted WP menu
 * @param string [$capability] Permissions requirment to access tab
 * @param string [$slug] URL slug to access page
 * @param string [$function] name of function to call when page loads
 * @param string [$icon_url] URL of image to be icon, if wanted
 * @param integer [$position] The position in the menu order this menu should appear
 *
 */  

  public function addPage($page_title = null, $menu_title = null, $capability = null, $slug = null, $function = null, $icon_url = null, $position = null ){
	   if($page_title == null){
		   // no parameters passed
			throw new Exception("Make sure to pass in appropriate parameters for addPage");  
	  	} elseif($function == null){
			// no function passed = not all required parameters filled
			throw new Exception("Add all parameters. Also Make sure to pass in function parameter for addPage");  
		}
	   self::$pages[$slug] = array('title'=>$page_title,'menu_title'=> $menu_title,'capability'=> $capability,'slug'=> $slug,'function'=> $function, 'icon_url'=>$icon_url, 'position'=>$position);
	  
  }



/**
 * Add subpage to existing Menu pages or custom Menu Pages, takes same parameters core WP function add_submenu_page() takes
 * @param string|array [$type] Pass in string for primary options 
 * (management,users,comments,pages,links,media,posts,dashboard,theme,plugins) or custom slugs
 * array(post_type => client) or array(custom => 'parent_slug')
 * @param string [$page_title] Title of page outputted in when in page
 * @param string [$menu_title] Title of page outputted WP menu
 * @param string [$capability] Permissions requirment to access tab
 * @param string [$slug] URL slug to access page
 * @param string [$function] name of function to call when page loads
 * 
 */  
  public  function addSubpage($type = null, $page_title = null, $menu_title = null, $capability = null, $slug = null, $function = null){
	   if($type == null){
		   // no parameters passed
			throw new Exception("Make sure to pass in appropriate parameters for addSubpage");  
	  	} elseif($function == null){
			// no function passed = not all required parameters filled
			throw new Exception("Make sure to pass in function parameter for addSubpage");  
		}
		// add to pages array and set a flag for subpage	
	   self::$pages[$slug] = array('type'=>$type, 'title'=>$page_title,'menu_title'=> $menu_title,'capability'=> $capability,'slug'=> $slug,'function'=> $function,'subpage'=>true);
	   
  }
/**
 * Action that is added to the admin_menu hook
 * 
 */ 
  public function attach(){
	// loop through the pages	
	  foreach(self::$pages as $page ){
		// loop through pages and checks if subpage flag is set
		if(isset($page['subpage'])){
			
			// check if is array for custom options or post types
			if(!is_array($page['type'])){
				// if not array create function for type
				$add = "add_{$page['type']}_page";
				// if function doesnt exist, complain
				if(!function_exists($add)){
					throw new Exception("Function doesn't exist, you didn't use an existing page parent");
				}
				$add($page['title'], $page['menu_title'], $page['capability'], $page['slug'], array($this,'page'));
			} else {
				// checks if is post type
				if($page['type'][0] == 'post_type'){
					add_submenu_page("edit.php?post_type={$page['type'][1]}", $page['title'], $page['menu_title'], $page['capability'], $page['slug'], array($this,'page'));
				} else {
					// adds submenu to custom parent
					add_submenu_page($page['type'][1], $page['title'], $page['menu_title'], $page['capability'], $page['slug'], array($this,'page'));
				}
			}
		} else {
			// else add to main menu
			add_menu_page( $page['title'], $page['title'], $page['capability'], $page['slug'], array($this,'page'), $page['icon_url'], $page['position']);
		}
	  }
 	}
/**
 * Base function to create unfied options page look, also works with tab logic.
 * 
 */   
  
  public function page(){
  	  global $pagenow;
	  $site = get_bloginfo('url');
		
	  // load up page
	  if(isset($_GET['page'])){
		  $page = $_GET['page'];
		  $page = self::$pages[$page];
		  $current = $page;
	  }
	  
	  //load up tab if is set and set to current
	  if(isset($_GET['tab'])){
		  $tab = $_GET['tab'];
		  $current = $page['tabs'][$tab];
		  
	  }
	  
	  self::$now = $current;
    ?>
    <!-- standard wordpress admin pages wrap -->
	<div class="wrap">
 		<div class="icon32 icon32-posts-page" id="icon-edit-pages"><br></div>	
  <?php if(isset($page['tabs'])){  ?>
		<h2 class="nav-tab-wrapper">
   <?php echo '<a class="nav-tab';
			if(!isset($tab)){
				echo ' nav-tab-active';
			}
			
			echo  "\" href=\"$site/wp-admin/admin.php?page={$page['slug']}\">{$page['title']}</a>"; ?>
			
		<?php foreach($page['tabs'] as $tab){
				echo '<a class="nav-tab';
				if($current['slug'] == $tab['slug']){
					echo ' nav-tab-active';
				}
				echo "\" href=\"$site/wp-admin/admin.php?page={$page['slug']}&tab={$tab['slug']}\">{$tab['title']}</a>"; 
			}
		?></h2>
            <h3><?php echo $current['title']; ?></h3>
		<?php } else { ?>  
           
      	<h2><?php echo $current['title']; ?></h2>
      	<div class="wp-function-wrap">
        <?php } 		
			// load function and run it
	  		$function = $current['function'];
			if(function_exists($function)){
				$function();	
			} else {
				echo "Function $function() does not exist";
			}
	  		
	?>
     </div>
    </div>
      <?php
  }
/**
 * Function to run after all the pages have been added
 * 
 */     
  public function init(){
	   add_action( 'admin_menu', array($this ,'attach'));  
  }
  
}

?>