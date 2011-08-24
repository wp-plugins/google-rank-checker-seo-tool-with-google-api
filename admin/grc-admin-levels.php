   <?
	$levels = '';	
	if($_POST['submit'] == 'Save Levels'){
			$levels = $_POST['optimum7_google_ranking_checker_levels']; 
			update_option('optimum7_google_ranking_checker_levels', $levels);
			update_option('optimum7_google_ranking_checker_levels_added', true);?>
         	<div class="updated"><p><strong><?php _e('Levels saved.' ); ?></strong></p></div><?
	}
	else{
		$levels = get_option('optimum7_google_ranking_checker_levels');
	}	
  ?>
    
    
    <div class="wrap"> 
    	<?php include("grc-admin-keywords-head-area.php");?>
		<div id="icon-options-general" class="icon32"><br /></div> 
		<h2>Keyword Level Definitions</h2> 

        <div style="margin-top:20px;margin-bottom:10px;font-style:italic;"> This form is intended ​​to define levels for Google Keyword Results.<br/> <strong>Levels should be added separated by semicolon.</strong> Ex: Initial Value , Final Value  , Level Name;</div>
            <form method="post" action=""> 
            <input type='hidden' name='grc_menu_add_level' value='add_level' /><input type="hidden" name="action" value="" />
            <input type="hidden" id="_wpnonce" name="_wpnonce" value="" />
            <input type="hidden" name="_wp_http_referer" value="/wp-content/plugins/google-rank-checker-seo-tool-with-google-api/admin/grc-admin-levels.php" /> 
                <table class="form-table"> 
                    <tr valign="top"> 
                    <th scope="row"><label for="optimum7_google_ranking_checker_levels">Levels:</label></th> 
                    <td><textarea rows="10" cols="80" name="optimum7_google_ranking_checker_levels" class="regular-text code" style="margin-left:-100px;" ><?php echo $levels; ?></textarea>
                    </tr> 
                </table> 
        	<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Levels"  /></p></form> 
            
            <? 
			 	$levels = explode(';', $levels);
    		 	unset($levels[sizeof($levels)-1]);
	         	if (count($levels)>1){
				?>
                   <div>List of Levels: <strong><? echo count($levels);?></strong></div>
                <?
					$limit = 10;
					if (!$limit){
						$limit = 10;
					}
					
					$page = $_GET['start'];
					if ((!$page) || (is_numeric($page) == false) || ($page < 0)){
						$page = 1; //default	
					}
					
					$set_limit = $page * $limit - ($limit);
					$prev_page = $page-1;
					$next_page = $page+1;
					$total_item=count($keywords);
					$total_pages = ceil($total_item / $limit);
					
					if ($total_item == 0) {
					$content_start = 0;
					} else {
					$content_start = $set_limit +1;
					}
					
					$content_end = (($limit*$page)>=$total_item)?$total_item:($limit*$page);
					$start_page = ($page<9)?1:($page-5);
					$end_page = (($start_page+9)<$total_pages)?($start_page+9):$total_pages;
				
				 

 					if ($total_pages > 1) { ?>
                    <div style="padding-top:10px;">
                    <strong><span>Page <?php echo $page;?> of <?php echo $total_pages; ?> - </span></strong> <?php
                    if ($page != 1) { ?>
                    <a href="admin.php?page=grc_levels&start=<?=$prev_page?>"><<</a> <?php
                    }
                    for ($count=1; $count<=$total_pages; $count++) {
                    if ($count == $page) { ?>
                    <span><?php echo $count; ?></span> <?php
                    } else { ?>
                    <a href="admin.php?page=grc_levels&start=<?=$count?>" ><?php echo $count; ?></a> <?php
                    }
                    }
                    if ($page != $total_pages) { ?>
                    <a href="admin.php?page=grc_levels&start=<?php echo $next_page; ?>">>></a> <?php
                    } ?>
                    </div> <?php
                    }?>
					
					<div style="margin-top:5px;margin-bottom:20px;">
                       <table class="widefat" width="auto">
                         <thead>
                            <tr>
                              <th>Level</th>
                              <th>Initial Value</th>
                              <th>Final Value</th>
                            </tr>
                         </thead>
                         <tfoot>
                            <tr>
                              <th>Level</th>
                              <th>Initial Value</th>
                              <th>Final Value</th>
                            </tr>
                         </tfoot>
                         <tbody>
                             <tr>
                <? 
				$counter = 1;
				foreach ($levels as $key => $value)
			    {
					$split_level = explode(',', $value);
				?>           
                   <tr>
                     <td style="width:200px;"><? echo $split_level[2]?></td>
                     <td style="width:180px;"><? echo number_format($split_level[0])?></td> 
                     <td style="width:180px;"><? echo number_format($split_level[1])?></td>
                   </tr>                        
                 <?  
				  $counter = $counter+1;
				}
				?> 
                </tr>
           </tbody>
        </table>
  </div>
  <?
   }
  ?>
</div>  
<div class="clear"></div></div><!-- wpbody-content --> 
<div class="clear"></div></div><!-- wpbody --> 
<div class="clear"></div></div><!-- wpcontent --> 
</div><!-- wpwrap --> 