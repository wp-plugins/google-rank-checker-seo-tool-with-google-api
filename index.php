<?
	/*
    Plugin Name: Google Rank Checker - SEO Tool with Google API
    Plugin URI: http://www.optimum7.com/internet-marketing/wordpress-2/google-rank-checker-wordpress-plugin-google-api.html?utm_source=RankCheckPlugin
    Description: Provides the estimated Google position for a keyword and corresponding URL. It also provides the competitive pages for any pre-defined keyword list on a keyword for keyword basis.This plugin is an SEO-tool using the 2011 Google API
    Version: 5.0.0
    Author: Optimum7
    Author URI: http://www.optimum7.com/?utm_source=RankCheckPlugin
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
	define('OPT7_GRC_PLUGINSUPPORT_PATH', 'http://www.optimum7.com/internet-marketing/wordpress-2/google-rank-checker-wordpress-plugin-google-api.html?utm_source='.OPT7_GRC_UTM_SOURCE_CODE);
	define('OPT7_GRC_RSS_LINKS',10);
	define('OPT7_GRC_RSS_URL','http://www.optimum7.com/internet-marketing/feed');
	_google_ranking_checker::bootstrap();
    add_shortcode('optimum7_google_ranking_checker_form', array('_google_ranking_checker','display'));
	add_shortcode('optimum7_google_ranking_checker_form_2', array('_google_ranking_checker','display2'));
  /********************************************************************************************************************/	
  class _google_ranking_checker{ 
	function bootstrap(){ 
		// Add the installation and uninstallation hooks 
		$file = OPT7_GRC_PLUGINPATH . '/' . basename(__FILE__);	
		register_activation_hook($file, array('_google_ranking_checker', 'install'));
		register_deactivation_hook($file, array('_google_ranking_checker', 'uninstall'));
		// Add the actions 
		add_action('Opt7_GRC_scheduled',  array('_google_ranking_checker', 'cron_downloading'));		
		add_action('admin_menu', array('_google_ranking_checker','add_admin_options'));
    }
    
	function display(){ 
	  add_action('wp_footer', array('_google_ranking_checker','add_css'));
	  ob_start();
	  require(OPT7_GRC_PLUGINPATH . '/display.php');
	  $dl_html = ob_get_contents();
	  ob_end_clean();		
	  return $dl_html;
	}
	
	function display2(){ 
	  add_action('wp_footer', array('_google_ranking_checker','add_css'));
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

	function install(){}

	function uninstall(){
		remove_shortcode('optimum7_google_ranking_checker_form');
	}
	
	function add_css() {
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery-ui-tabs' );
		echo '<link type="text/css" rel="stylesheet" href="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/css/style.css" />' . "\n";
		echo '<link type="text/css" rel="stylesheet" href="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/css/buttons.css" />' . "\n";
		echo '<link type="text/css" rel="stylesheet" href="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/css/ui-lightness/jquery-ui-1.8.12.custom.css" />' . "\n";
		echo '<script type="text/javascript" src="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/include/js/jquery-latest.js" /></script>' . "\n";
		echo '<script type="text/javascript" src="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/include/js/jquery.tablesorter.js" /></script>' . "\n";	
   }
  } /*class ends here*/
?>