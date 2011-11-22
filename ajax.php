<?
	require_once( "../../../wp-config.php" );
	$action = $_POST['commit'];

	if ($action=='load_rss'){
		$result .= "<div class='metabox-holder' id='head'>
					<div class='postbox'>
						<div id='head-colour'>
							<span class='head-title'>".OPT7_GRC_PLUGINNAME."</span>
            				<div id='head-links'>
               					<ul>
                 					<li>".sprintf(__( "%sGet a free Web site Analysis%s", "Optimum7" ), '<a href="http://www.optimum7.com/alpha/seo/main-analysis-bullets-3.html?utm_source='.OPT7_GRC_UTM_SOURCE_CODE.'" target="_blank">','</a>')."</li> |
                 					<li>".sprintf(__( "%sHow this plugin works%s", OPT7_GRC_PLUGINNAME ), '<a href="'.OPT7_GRC_PLUGINSUPPORT_PATH.'" target="_blank">','</a>')."</li>
               					</ul>
             				</div>
						</div>	
						<div class='bnc-clearer'></div>
						<div class='bnc-clearer'></div>
        				<div id='news-support' class='clearfix'>
        				<div id='banner-support'>			
            				<a href='http://www.optimum7.com?utm_source=".OPT7_GRC_UTM_SOURCE_CODE."'><img src='".OPT7_GRC_PLUGIN_PATH."/images/opt7-logo.png' width='206' height='40'/></a>
        				</div>
            			<ul>";
           				
						try{
							$result .= get_rss_feed(ini_get('allow_url_fopen'));
						}
						catch (Exception $e){	
			   			}
			$result .="</ul>
        			 </div>   
    				</div>
				  </div>";
		echo $result;			  
	}

	function get_rss_feed($allow_url_fopen){
		try{
			$result ='';
			if ($allow_url_fopen==1){
				$xmlDoc = new DOMDocument();
				$xmlDoc->load(OPT7_GRC_RSS_URL);
				//get elements from "<channel>"
				$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
				$channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
				$channel_link = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
				$channel_desc = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
				//output elements from "<channel>"
				$result = $result."<p style='margin-left:10px;'><a href='http://www.optimum7.com/internet-marketing/?utm_source=".OPT7_GRC_UTM_SOURCE_CODE."'>" . $channel_title . " (Optimum7)</a>";
				$result = $result."<br />";
				$result = $result.$channel_desc."</p>";
				//get and output "<item>" elements
				for ($i=0; $i<OPT7_GRC_RSS_LINKS; $i++){
					$x=$xmlDoc->getElementsByTagName('item');
					$item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
					$item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
					$item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
					$result = $result."<li><a href='" . $item_link."?utm_source=".OPT7_GRC_UTM_SOURCE_CODE."'>" . $item_title . "</a></li>";
				}
			}
			else{
				$result = "<li><a href='http://www.optimum7.com/contact-us?utm_source=".OPT7_GRC_UTM_SOURCE_CODE."'>Plugin Support</a></li>";	
				$result = $result."<li><a href='http://www.optimum7.com/alpha/seo/main-analysis-bullets-2.html?utm_source=".OPT7_GRC_UTM_SOURCE_CODE."'>Website Analysis </a></li>";	
				$result = $result."<li><a href='http://www.optimum7.com/?utm_source=".OPT7_GRC_UTM_SOURCE_CODE."'>Internet Marketing Services </a></li>";	
				$result = $result."<li><a href='http://www.optimum7.com/internet-marketing/?utm_source=".OPT7_GRC_UTM_SOURCE_CODE."'>Internet Marketing Articles </a></li>";	
			}		
			return $result;
		}
		catch (Exception $e){	
		}
	}	
?>