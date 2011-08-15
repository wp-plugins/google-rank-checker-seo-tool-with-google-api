<? require_once(GRC_PLUGINPATH . '/classes/collections/GenericDictionary.php');?>
<? require_once(GRC_PLUGINPATH . '/classes/functions.php');?>
<? setlocale(LC_MONETARY, 'en_US');?>
<?
 try{
		$functions = new functions();		
		$Show_Last_Date_Update_Label = get_option('optimum7_google_ranking_checker_date_update_label');	
		$Date_Format = get_option('optimum7_google_ranking_checker_date_format');
		$Table_title = get_option('optimum7_google_ranking_checker_table_title');
		$Last_Date_Updated = get_option('optimum7_google_ranking_checker_last_date_updated');	
		$Last_Date_Updated = date(  $Date_Format, strtotime( $Last_Date_Updated ) );	
		$annual_times = get_option('optimum7_google_ranking_checker_annual_times');		
		$myString = get_option('optimum7_google_ranking_checker_keywords');
		$array_keywords = explode(';', $myString);	
		unset($array_keywords[sizeof($array_keywords)-1]);
		$aKeywords = new Dictionary();

		if($_POST['submit'] == 'Refresh data'){
			try{	
				$aKeywords= $functions->Get_Keywords(true,$array_keywords,true);	
			}
            catch (Exception $e){
				throw new Exception($e->getMessage());
			}
		}
		else{
			try{
				$aKeywords= $functions->Get_Keywords(false,$array_keywords,false);	
			}
			catch (Exception $e){
				throw new Exception($e->getMessage());
			}
		}
		$limit = 20;
		$page = $_GET['start'];
		if ((!$page) || (is_numeric($page) == false) || ($page < 0)){
			$page = 1; //default	
		}
		$set_limit = $page * $limit - ($limit);
		$prev_page = $page-1;
		$next_page = $page+1;
		$total_item=count($aKeywords);
		$total_pages = ceil($total_item / $limit);
		if ($total_item == 0){
			$content_start = 0;
		} else {
		$content_start = $set_limit +1;
		}
		$content_end = (($limit*$page)>=$total_item)?$total_item:($limit*$page);
		$start_page = ($page<9)?1:($page-5);
		$end_page = (($start_page+9)<$total_pages)?($start_page+9):$total_pages;
		?>	
     		<div class="updated"><p><strong><?php _e('' .$functions->message); ?></strong></p></div>
        	    <div class="wrap">
                	
					<?php include("grc-admin-keywords-head-area.php");?>
                    <? if (sizeof($aKeywords)>0) { ?>
                    <? if ($Table_title) { echo "<h2>". $Table_title. "</h2>" ;}?> 
                    <? if ($Show_Last_Date_Update_Label=='1') { echo "<span><abbr title='Last Update'>Last Update: </abbr><code>" . $Last_Date_Updated. "</code></span> ";}
                    if ($total_pages > 1) { ?>
                    <div style="padding-top:10px;float:right">
                    <strong><span>Page <?php echo $page;?> of <?php echo $total_pages; ?> - </span></strong> <?php
                    if ($page != 1) { ?>
                    <a href="admin.php?page=grc_keywords&start=<?=$prev_page?>"><<</a> <?php
                    }
                    for ($count=1; $count<=$total_pages; $count++) {
                    if ($count == $page) { ?>
                    <span><?php echo $count; ?></span> <?php
                    } else { ?>
                    <a href="admin.php?page=grc_keywords&start=<?=$count?>" ><?php echo $count; ?></a> <?php
                    }
                    }
                    if ($page != $total_pages) { ?>
                    <a href="admin.php?page=grc_keywords&start=<?php echo $next_page; ?>">>></a> <?php
                    } ?>
                    </div> <?php
                   }
				   if(sizeof($aKeywords)>0){
					?>
                    <div style="margin-top:10px;margin-bottom:20px;">
                      <table class="widefat"u>
                        <thead>
                            <tr>
                                <th style="text-align:left">Keyword</th>
                                <th style="text-align:left">Url</th>
                                <th style="text-align:left">Competing Pages</th>
                                <th style="text-align:center">Position</th>
                                <th style="text-align:right">Estimated Position</th>
                                <th style="text-align:right">Estimated Results</th>
                                <th style="text-align:right">Average CPC</th>           
                                <th style="text-align:right">Clicks per day</th>
                                <th style="text-align:right">Estimated Daily Cost</th>
                                <th style="text-align:right">Clicks per month</th>
                                <th style="text-align:right">Monthly Potential Traffic</th>
                                <th style="text-align:right">Annual Traffic Value</th>
                            </tr>
                        </thead>
                        <tfoot>
                           <tr>
                                <th style="text-align:left">Keyword</th>
                                <th style="text-align:left">Url</th>
                                <th style="text-align:left">Competing Pages</th>
                                <th style="text-align:center">Position</th>
                                <th style="text-align:right">Estimated Position</th>
                                <th style="text-align:right">Estimated Results</th>
                                <th style="text-align:right">Average CPC</th>            
                                <th style="text-align:right">Clicks per day</th>
                                <th style="text-align:right">Estimated Daily Cost</th>
                                <th style="text-align:right">Clicks per month</th>
                                <th style="text-align:right">Monthly Potential Traffic</th>
                                <th style="text-align:right">Annual Traffic Value</th>
                            </tr>
                       </tfoot>
                        <tbody>
                           <tr>
                              <?
							   $counter = 1;
							   foreach ( $aKeywords as &$keyword){
								   if ($counter>=$content_start && $counter<=$content_end) {
									   $PosAve = $PosAve + $keyword->_meanAveragePosition;
									   $totalTrafficMonthly = $totalTrafficMonthly + $keyword->_total_Monthly_Traffic;								   
									   $total = $total + $keyword->_total_Monthly_Traffic;								   
									   $clicksDay = $keyword->_meanClicks;
									   $clickskMonth = $clicksDay*31;
									   $clicksYear = $clickskMonth*12;
									   $real_pos_on_page = substr($keyword->_position, -1);
									   if ($real_pos_on_page=='0')
									   	   $real_pos_on_page = '10';
							?>           
                            <tr>
                            <? if (intval($keyword->_page)>get_option('optimum7_google_ranking_checker_max_page')){?>
                             	<td style="color:#F00;text-align:left"><?php echo $keyword->_string; ?></td>
                             <? }
							 else{
							 ?>
                             	<td style="text-align:left"><?php echo $keyword->_string; ?></td>
                             <?
                             }
							 ?>
                             <td style="text-align:left"><?php echo $keyword->_url; ?></td>  
                             <td style="text-align:right"><?php  echo number_format($keyword->_competingPage);?></td>                             
                             <td style="text-align:right"><?php echo $keyword->_position; ?></td>
                             <td style="text-align:right"><?php echo $keyword->_meanAveragePosition; ?></td>
                             <td style="text-align:right"><?php echo number_format($keyword->_results) ; ?></td>
                             <?  $min_cost_click = get_option('optimum7_google_ranking_checker_min_cost_click'); ?>
                             <td style="width:100px;text-align:right"><?php echo money_format('%(#10n', $keyword->_averageCpc/1000000);
									if ($keyword->_averageCpc/1000000 < $min_cost_click){
										$keyword->_averageCpc = $min_cost_click;
							 			echo ' (<span style="color:#F00;">'.money_format('%(#10n',$min_cost_click).'</span>)';
									}
									else
									$keyword->_averageCpc = $keyword->_averageCpc/1000000;
							 ?></td>
                             <td style="text-align:right"><?php echo round($clicksDay,2); ?></td>
                             <td style="text-align:right"><?php echo money_format('%(#10n',  ($clicksDay * ($keyword->_averageCpc/1000000))) ;  ?></td>
                             <td style="text-align:right"><?php echo number_format(round($clickskMonth,2),2, '.', ', '); ?></td>
                             <? $min_searches = get_option('optimum7_google_ranking_checker_min_searches');?>
                             <? if ($keyword->_globalMonthlySearches<$min_searches){?>
                             	<td style="width:120px;text-align:right"><?php echo number_format(round($keyword->_globalMonthlySearches,2)).'<span style="color:#F00"> (' . number_format($min_searches,0).')</span>'; ?></td>
                            	<? $keyword->_globalMonthlySearches = $min_searches;?>
							 <? }
							 else{
							 ?>
                             	<td style="width:120px;text-align:right"><?php echo number_format(round($keyword->_globalMonthlySearches,2));?></td>
                            <?
                             }
							 ?>
                            <? $min_annual = get_option('optimum7_google_ranking_checker_min_annual');?>
                            <? $keyword->_total_Yearly_Traffic_Value = $keyword->_averageCpc *$keyword->_globalMonthlySearches*$annual_times;?>
                             <td style="width:80px; text-align:right;">
								<?
									$total= $keyword->_total_Yearly_Traffic_Value; 
									echo  money_format('%.2n', $total);
								?>	
                              </td>
                           </tr>                        
                            <? 
								  }
								  $counter = $counter+1;
							} ?> 
                           </tr>
                       </tbody>
                        </table>
                    </div>
                     <? } }?>
                 </div>                 
                  <form method="post" action=""> 
                    <input type='hidden' name='optimum7_ranking_checker_settings_page' value='settings' /><input type="hidden" name="action" value="" />
                    <input type="hidden" id="_wpnonce" name="_wpnonce" value="" />
                    <input type="hidden" name="_wp_http_referer" value="/wp-content/plugins/optimum7-google-ranking-checker/admin/grc-keyword-settings.php" /> 
                	<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Refresh data" <? if (!sizeof($array_keywords)>0) echo 'disabled="disabled"';?>/></p>
                  </form>                    
                  <span class="description">Every time that refreshes, it connects to Google Adwords API to update data and Google will charge you for that.</span>
                  <br/> <br/>
                 <span class="description">In order to create a Wordpress Page or Post to show the results, please paste this code: <strong>[optimum7_google_ranking_checker_form]</strong></span>
        <?
	}
	catch (Exception $e){
		echo $e->getMessage();
	}
?>