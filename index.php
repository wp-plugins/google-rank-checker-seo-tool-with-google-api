<?
	/*
    Plugin Name: Google Rank Checker - SEO Tool with Google API
    Plugin URI: http://www.optimum7.com/internet-marketing/wordpress-2/google-rank-checker-wordpress-plugin-google-api.html
    Description: Provides the estimated Google position for a keyword and corresponding URL. It also provides the competitive pages for any pre-defined keyword list on a keyword for keyword basis.This plugin is an SEO-tool using the 2011 Google API
    Version: 4.0.0
    Author: Optimum7
    Author URI: http://www.optimum7.com/
    Copyright 2011  Optimum7 Inc  (email : julian@optimum7.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    */
	define('OPT7_GRC_PLUGINPATH', (DIRECTORY_SEPARATOR != '/') ? str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__)) : dirname(__FILE__));
	define('OPT7_GRC_PLUGINNAME', 'Google Rank Checker');
	define('OPT7_GRC_UTM_SOURCE_CODE', 'RankCheckPlugin');
	define('OPT7_GRC_PLUGINSUPPORT_PATH', 'http://www.optimum7.com/internet-marketing/?utm_source='.OPT7_GRC_UTM_SOURCE_CODE);
	define('OPT7_GRC_RSS_LINKS',10);
	define('OPT7_GRC_RSS_URL','http://www.optimum7.com/internet-marketing/feed');
	 
	_google_ranking_checker::bootstrap(); 
	add_action('wp_head', '_google_ranking_checker_local_css');
	
	function place_wp_google_ranking_checker_form($content){
   	  $output = _google_ranking_checker::display();
      $content = str_replace( '[optimum7_google_ranking_checker_form]', $output, $content); 
  	  return $content;
    }	 	

	function place_wp_google_ranking_checker_form_2($content) {
	 	$output = _google_ranking_checker::display_2();
 		$content = str_replace( '[optimum7_google_ranking_checker_form_2]', $output, $content); 
	 	return $content;
   }	
  
   function _google_ranking_checker_local_css() {
	$file = OPT7_GRC_PLUGINPATH;
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'jquery-ui-tabs' );
	echo '<link type="text/css" rel="stylesheet" href="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/css/style.css" />' . "\n";
	echo '<link type="text/css" rel="stylesheet" href="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/css/buttons.css" />' . "\n";
	echo '<link type="text/css" rel="stylesheet" href="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/css/ui-lightness/jquery-ui-1.8.12.custom.css" />' . "\n";
	echo '<script type="text/javascript" src="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/include/js/jquery-latest.js" /></script>' . "\n";
	echo '<script type="text/javascript" src="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/include/js/jquery.tablesorter.js" /></script>' . "\n";	
  }

  /********************************************************************************************************************/	
  class _google_ranking_checker{ 
	function bootstrap(){ 
	// Add the installation and uninstallation hooks 
	$file = OPT7_GRC_PLUGINPATH . '/' . basename(__FILE__);	
	register_activation_hook($file, array('_google_ranking_checker', 'install'));
	register_deactivation_hook($file, array('_google_ranking_checker', 'uninstall'));
	// Add the actions 
	add_action('wp_head', array('_google_ranking_checker', 'display_header'));		
	add_action('Opt7_GRC_scheduled',  array('_google_ranking_checker', 'cron_downloading'));		
	add_filter('the_content', 'place_wp_google_ranking_checker_form', '7');
	add_filter('the_content', 'place_wp_google_ranking_checker_form_2', '7');
	add_action('admin_menu', array('_google_ranking_checker','add_admin_options'));
	
  }

  function display_header() { 
	add_filter('the_content', array('_google_ranking_checker', 'display_magic_filter'));
  } 

  function display_magic_filter($content){ 
	return str_replace('{_google_ranking_checker}', _google_ranking_checker::display(), $content);
  } 

  function display(){ 
	  ob_start();
	  require(OPT7_GRC_PLUGINPATH . '/display.php');
	  $dl_html = ob_get_contents();
	  ob_end_clean();		
	  return $dl_html;
  }	
  
  function display_2(){ 
	  ob_start();
	  require(OPT7_GRC_PLUGINPATH . '/display-2.php');
	  $dl_html = ob_get_contents();
	  ob_end_clean();		
	  return $dl_html;
  }		

	function add_admin_options() {	
	  ob_end_clean();  
	  ob_start("ob_gzhandler");
	  echo '<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>';
	  echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>';
	  echo '<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>';
	  add_menu_page ('GRC_Keywords', 'SEO Keywords', 8, 'grc_keywords', array('_google_ranking_checker','grc_menu_keywords'), '/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/images/icon.gif');
	  add_submenu_page('grc_keywords', "Add_New", "Add new keyword", 8, 'grc_addnew', array('_google_ranking_checker','grc_menu_add_new')); 
	  add_submenu_page('grc_keywords', "Levels", "Add new Level", 8, 'grc_levels', array('_google_ranking_checker','grc_menu_add_level')); 
	  add_submenu_page('grc_keywords', "Settings", "Settings", 8, 'grc_settings', array('_google_ranking_checker','grc_menu_settings')); 
	}

	function grc_menu_keywords(){
	  require(OPT7_GRC_PLUGINPATH . '/admin/grc-admin-keywords.php');
	}
	
	function grc_menu_add_new(){
		require(OPT7_GRC_PLUGINPATH . '/admin/grc-admin-keyword-add.php');
	}
	
	function grc_menu_add_level(){
		require(OPT7_GRC_PLUGINPATH . '/admin/grc-admin-levels.php');
	}
	
	function grc_menu_settings() {
		require(OPT7_GRC_PLUGINPATH . '/admin/grc-admin-keyword-settings.php');
	}	 
	
	function optimum7_google_ranking_checker_init_widget(){
	  if (!function_exists('register_sidebar_widget'))
	  return;
	  register_sidebar_widget('Keywords Position','widget_optimum7_google_ranking_checker');
	  register_widget_control('Keywords Position', 'wiget_options_widget_optimum7_google_ranking_checker', 300, 100);
	}	   

	function widget_optimum7_google_ranking_checker($args){		
		extract($args);
		$title = stripslashes($options['title']);
		echo $before_widget, $before_title, $title, $after_title;
		require(OPT7_GRC_PLUGINPATH . '/display.php');
		echo $after_widget;
	}

	function wiget_options_widget_optimum7_google_ranking_checker(){
		$options = $newoptions = get_option('optimum7_google_ranking_checker_widget');
		if ( $_POST["optimum7-submit"] ){
			$newoptions['title'] = strip_tags(stripslashes($_POST["prt-title"]));
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('optimum7_google_ranking_checker_widget', $options);					
		}
		$title = attribute_escape($options['title']);
		?>
		<p><label for="prt-title"><?php _e('Title:'); ?> <input class="widefat" id="prt-title" name="prt-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<input type="hidden" id="dl-submit" name="dl-submit" value="1" />
		<?php
	}
	function install(){
		$scheduled = get_option('optimum7_google_ranking_checker_scheduled');
		$activate_scheduled = get_option('optimum7_google_ranking_checker_activate_scheduled');
		
		if ($activate_scheduled=='1')
			wp_schedule_event(time(), $scheduled, 'Opt7_GRC_scheduled');
	}
	/* * The uninstallation function */
	function uninstall(){
		wp_clear_scheduled_hook('Opt7_GRC_scheduled');
	}
	/* * The scheduled function */
	function cron_downloading() {
		require_once(OPT7_GRC_PLUGINPATH . '/classes/functions.php');
		$functions = new functions();	
		$myString = get_option('optimum7_google_ranking_checker_keywords');
		$array_keywords = explode(';', $myString);	
		unset($array_keywords[sizeof($array_keywords)-1]);
		$functions->Get_Keywords(true,$array_keywords,true);
	}
} /*class ends here*/
?>