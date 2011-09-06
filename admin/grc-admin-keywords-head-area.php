<style>
.metabox-holder{
	margin-top:20px;
	width:40%;
}

#postbox {
    overflow: hidden;
    padding: 10px;
    position: relative;
	font-size: 11px;
    margin-top: 10px;
}

#head-colour{
	-moz-border-bottom-colors: none;
    -moz-border-image: none;
	-moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #BCCED9;
    border-color: #E5F0F2 #E5F0F2 #A2BDBF;
    border-style: solid;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    border-width: 1px;
    margin: -10px 0px 0px;
    padding: 10px;
}

#head-links {
    bottom: 6px;
    float: right;
    position: relative;
	padding-top:5px;
}

#head-links li {
    color: #618299;
    display: inline;
    text-shadow: 1px 1px 0 #BFDFE8;
}

.head-title {
    color: #333C42;
    font: bold 16px Georgia,"Times New Roman",Times,serif;
    letter-spacing: -1px;
    margin: 0;
    padding: 0;
    text-shadow: 0 1px 0 #DEEEFA;
}

#news-support{
}

#news-support ul {
   width: 90%;
   margin-bottom:20px;
   margin-top:10px;
}

#news-support li {
    border-bottom: 1px solid #E6E6E6;
    color: #C1CFD1;
    list-style-position: inside;
    list-style-type: disc;
    margin: 0 0 0 10PX;
    padding: 3px 0 3px 12px;
    text-indent: -12px;
	font-size:11px;
}

#banner-support{
	height:auto;
	width:40%;
	float:right;
	margin-right:15px;
}

.clearfix:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
}
.clearfix {
 display: inline-table; }
/* Hides from IE-mac \*/

* html .clearfix { height: 1%; }
.clearfix { display: block; }
/* End hide from IE-mac */
</style>

<? require_once(OPT7_GRC_PLUGINPATH . '/classes/functions.php');?>
<div class="metabox-holder" id="head">
	<div class="postbox">
		<div id="head-colour">
			<span class="head-title"><? echo OPT7_GRC_PLUGINNAME;?></span>
            <div id="head-links">
               <ul>
                 <li><?php echo sprintf(__( "%sGet a free Web site Analysis%s", "Optimum7" ), '<a href="http://www.optimum7.com/alpha/seo/main-analysis-bullets-3.html?utm_source='.OPT7_GRC_UTM_SOURCE_CODE.'" target="_blank">','</a>'); ?></li> |
                 <li><?php echo sprintf(__( "%sHow this plugin works%s", "Google Rank Checker" ), '<a href="http://www.optimum7.com/internet-marketing/wordpress-2/google-rank-checker-wordpress-plugin-google-api.html?utm_source='.OPT7_GRC_UTM_SOURCE_CODE.'" target="_blank">','</a>'); ?></li>
               </ul>
             </div>
			<div class="bnc-clearer"></div>
		</div>	
		<div class="bnc-clearer"></div>
        <div id="news-support" class="clearfix">
        	<div id="banner-support">			
            	<a href="http://www.optimum7.com?utm_source=<? echo OPT7_GRC_UTM_SOURCE_CODE;?>"><img src="<? echo get_bloginfo('wpurl').'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/images/opt7-logo.png"'?>" width="206" height="40"/></a>
        	</div>
            <ul>
          <?
			$functions = new functions();
			try{
				$result =  $functions->get_rss_feed(ini_get('allow_url_fopen'));
				echo $result;
			}
			catch (Exception $e){	
			   echo $e->getMessage();
			}
		   ?>
           </ul>
        </div>   
    </div><!-- postbox -->
</div><!-- wptouch-head -->