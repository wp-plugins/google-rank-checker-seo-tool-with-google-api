<?
	/*
    Plugin Name: Google Rank Checker - SEO Tool with Google API
    Plugin URI: http://www.optimum7.com/internet-marketing/wordpress-2/google-rank-checker-wordpress-plugin-google-api.html?utm_source=RankCheckPlugin
    Description: Provides the estimated Google position for a keyword and corresponding URL. It also provides the competitive pages for any pre-defined keyword list on a keyword for keyword basis.This plugin is an SEO-tool using the 2011 Google API
    Version: 5.1.0
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
	define('OPT7_GRC_PLUGIN_PATH', get_bloginfo('wpurl').'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api');
	
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
		add_action( 'admin_head', array('_google_ranking_checker','opt7_settings_Jqueries'));
    }
    
	function display(){ 
	  add_action('wp_footer', array('_google_ranking_checker','add_css'));
	  add_action('wp_footer', array('_google_ranking_checker','add_document_ready'));
	  ob_start();
	  require(OPT7_GRC_PLUGINPATH . '/display.php');
	  $dl_html = ob_get_contents();
	  ob_end_clean();		
	  return $dl_html;
	}
	
	function display2(){ 
	  add_action('wp_footer', array('_google_ranking_checker','add_css'));
	  add_action('wp_footer', array('_google_ranking_checker','add_document_ready_2'));
	  ob_start();
	  require(OPT7_GRC_PLUGINPATH . '/display-2.php');
	  $dl_html = ob_get_contents();
	  ob_end_clean();		
	  return $dl_html;
	}
	
	function add_css() {
		echo '<link type="text/css" rel="stylesheet" href="' .get_bloginfo('wpurl') .'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/css/style.css" />' . "\n";
		echo '<script type="text/javascript" src="http://tablesorter.com/jquery-latest.js"></script>' . "\n";	
		echo '<script type="text/javascript" src="http://autobahn.tablesorter.com/jquery.tablesorter.js" /></script>' . "\n";	
   }
   
   function add_document_ready(){
   		echo '<script>$(document).ready(function(){
   				jQuery.tablesorter.addParser({id: "commaDigit",is: function(s, table) { var c = table.config; return jQuery.tablesorter.isDigit(s.replace(/,/g, ""), c);}, format: function(s) {return jQuery.tablesorter.formatFloat(s.replace(/,/g, ""));},type: "numeric"});
				$("#tablesorter").tablesorter({sortList:[[1,0],[4,0],[2,1]], widgets: ["zebra"],  headers: {5:{sorter:"numeric"},3: {sorter:"commaDigit"}}});});</script>' . "\n";
   }
   
   function add_document_ready_2(){
		echo '<script type="text/javascript"> $(document).ready(function() { jQuery.tablesorter.addParser({id: "commaDigit",is: function(s, table) { var c = table.config; return jQuery.tablesorter.isDigit(s.replace(/,/g, ""), c);}, format: function(s) {return jQuery.tablesorter.formatFloat(s.replace(/,/g, ""));},type: "numeric"});
			  $("#tablesorter1").tablesorter({sortList:[[3,1],[1,0],[2,0]], widgets: ["zebra"],  headers: {5:{sorter:"numeric"},3: {sorter:"commaDigit"}}});});</script>' . "\n";
   }
   
   function add_admin_options() {	
	  ob_end_clean();  
	  ob_start("ob_gzhandler");
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
	
	function opt7_settings_Jqueries(){
		echo '<link type="text/css" rel="stylesheet" href="'.OPT7_GRC_PLUGIN_PATH.'/css/settings.css" />' . "\n";
		echo '<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />';
		echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
			  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
			  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>';

		?>
        	<script>	  
				var url =  "/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/ajax.php";  	
				jQuery(document).ready(function(){
					jQuery("#middle-notify").hide();
					load_rss();
					$( "#tabs" ).tabs();
				});
			
				function load_rss(){
					jQuery("#middle-notify").show();
					jQuery.ajax({
						type: "POST",
						url: url,
						cache: false,
						data: "commit=load_rss",
						success: function(ajaxResutl){
							jQuery( "#opt7_rss" ).html(ajaxResutl);
							jQuery("#middle-notify").hide(); 
							},
						});
				}
			</script>
        <?
	}
	
	function grc_menu_settings() {
	  require(OPT7_GRC_PLUGINPATH . '/admin/grc-admin-keyword-settings.php');
	}	 
	
	function install(){
	}

	function uninstall(){
		remove_shortcode('optimum7_google_ranking_checker_form');
	}
  } /*class ends here*/
?>