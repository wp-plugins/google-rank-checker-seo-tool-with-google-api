<style>

.metabox-holder{
	margin-top:20px;
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
	padding-top:10px;
}

#head-links li {
    color: #618299;
    display: inline;
    text-shadow: 1px 1px 0 #BFDFE8;
}

.head-title {
    color: #333C42;
    font: bold 22px Georgia,"Times New Roman",Times,serif;
    letter-spacing: -1px;
    margin: 0;
    padding: 0;
    text-shadow: 0 1px 0 #DEEEFA;
}

#news-support{
	
}

#news-support ul {
   width: 50%;
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
}

.clearfix:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
	}
.clearfix { display: inline-table; }
/* Hides from IE-mac \*/
* html .clearfix { height: 1%; }
.clearfix { display: block; }
/* End hide from IE-mac */

</style>
<div class="metabox-holder" id="head">
	<div class="postbox">
		<div id="head-colour">
			<span class="head-title">Keyword Rank Checker</span>
            <div id="head-links">
               <ul>
                 <li><?php echo sprintf(__( "%sGet a free Web site Analysis%s", "Optimum7" ), '<a href="http://www.optimum7.com/alpha/seo/main-analysis-bullets-3.html" target="_blank">','</a>'); ?></li> |
                 <li><?php echo sprintf(__( "%sHow this plugin works%s", "Google Rank Checker" ), '<a href="http://www.optimum7.com/internet-marketing/wordpress-2/google-rank-checker-wordpress-plugin-google-api.html?utm_source=RankCheckPlugin" target="_blank">','</a>'); ?></li>
               </ul>
             </div>
			<div class="bnc-clearer"></div>
		</div>	
		<div class="bnc-clearer"></div>
        <div id="news-support" class="clearfix">
        	<div id="banner-support">			
            	<a href="http://www.optimum7.com?utm_source=RankCheckPlugin"><img src="<? echo get_bloginfo('wpurl').'/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/images/opt7-logo.png"'?>" width="413" height="80"/></a>
        	</div>
            <ul>
           <?
		    $xml=("http://www.optimum7.com/internet-marketing/feed");
		   	$xmlDoc = new DOMDocument();
			$xmlDoc->load($xml);
			
			//get elements from "<channel>"
			$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
			$channel_title = $channel->getElementsByTagName('title')
			->item(0)->childNodes->item(0)->nodeValue;
			$channel_link = $channel->getElementsByTagName('link')
			->item(0)->childNodes->item(0)->nodeValue;
			$channel_desc = $channel->getElementsByTagName('description')
			->item(0)->childNodes->item(0)->nodeValue;
			
			//output elements from "<channel>"
			echo("<p style='margin-left:10px;'><a href='" . $channel_link
			  . "'>" . $channel_title . " (Optimum7)</a>");
			echo("<br />");
			echo($channel_desc . "</p>");
			
			//get and output "<item>" elements
			$x=$xmlDoc->getElementsByTagName('item');
			for ($i=0; $i<=9; $i++)
			  {
			  $item_title=$x->item($i)->getElementsByTagName('title')
			  ->item(0)->childNodes->item(0)->nodeValue;
			  $item_link=$x->item($i)->getElementsByTagName('link')
			  ->item(0)->childNodes->item(0)->nodeValue;
			  $item_desc=$x->item($i)->getElementsByTagName('description')
			  ->item(0)->childNodes->item(0)->nodeValue;
			  
			  echo ("<li><a href='" . $item_link
			  . "?utm_source=RankCheckPlugin'>" . $item_title . "</a></li>");
			  }
		   ?>
           </ul>
        </div>   
    </div><!-- postbox -->
</div><!-- wptouch-head -->