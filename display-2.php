<? require_once(OPT7_GRC_PLUGINPATH . '/classes/collections/GenericDictionary.php');?>
<? require_once(OPT7_GRC_PLUGINPATH . '/classes/functions.php');?>
<? get_header();?>
<? 
    try{ 
		$functions = new functions();
		setlocale(LC_MONETARY, 'en_US');
		$Show_Last_Date_Update_Label = get_option('optimum7_google_ranking_checker_date_update_label');	
		$Date_Format = get_option('optimum7_google_ranking_checker_date_format');
		$Table_title = get_option('optimum7_google_ranking_checker_table_title');
		$Last_Date_Updated = get_option('optimum7_google_ranking_checker_last_date_updated');	
		$Last_Date_Updated = date(  $Date_Format, strtotime( $Last_Date_Updated ) );			
		$myString = get_option('optimum7_google_ranking_checker_keywords');
		$keywords = explode(';', $myString);
		$annual_times = get_option('optimum7_google_ranking_checker_annual_times');
		$keywords= $functions->Get_Keywords(false,$keywords,true,true);
		
		$array = array();
		if(empty($keywords)){
			throw new Exception('No keyword to show');
		}
		foreach ( $keywords as &$keyword){
			$array[] = $keyword;
		}		

		foreach ( $array as &$arr){
			$arr->_competingPage = number_format($arr->_competingPage,2,'.','');
		}	

		usort($array, array("elementSorter", "ComparisonDelegateByPosition"));
		$aKeywords = new Dictionary();
		$tmp_counter = 0;
		foreach ( $array as &$arr){
			//echo $arr->_string. ' - ' . $arr->_competingPage;
			$aKeywords->Add($tmp_counter,$arr);
			$tmp_counter++;
		}
		
		$limit = 1000;
		
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
		$total_item=count($aKeywords);
		$total_pages = ceil($total_item / $limit);
		
		if ($total_item == 0) {
		$content_start = 0;
		} else {
		$content_start = $set_limit +1;
		}
		
		$content_end = (($limit*$page)>=$total_item)?$total_item:($limit*$page);
		$start_page = ($page<9)?1:($page-5);
		$end_page = (($start_page+9)<$total_pages)?($start_page+9):$total_pages;
		?>	
        		    <? if (count($aKeywords)>0) { ?>
                    <? if ($Table_title) { echo "<h2>". $Table_title. "</h2>" ;}?> 
                    <? if ($Show_Last_Date_Update_Label=='1') { echo "<span>Last Update: " . $Last_Date_Updated. "</span> ";}
                     
                    if ($total_pages > 1) { ?>
                    <div style="padding-top:10px;">
                    <strong><span>Page <?php echo $page;?> of <?php echo $total_pages; ?> - </span></strong> <?php
                    if ($page != 1) { ?>
                    <a href="?start=<?=$prev_page?>"><<</a> <?php
                   }
                    for ($count=1; $count<=$total_pages; $count++) {
                    if ($count == $page) { ?>
                    <span><?php echo $count; ?></span> <?php
                    } else { ?>
                    <a href="?start=<?=$count?>" ><?php echo $count; ?></a> <?php
                    }
                    }
                    if ($page != $total_pages) { ?>
                    <a href="?start=<?php echo $next_page; ?>">>></a> <?php
                    } ?>
                    </div> <?php
                    }
					 ?>
					
                    <div style="margin-top:10px;margin-bottom:20px;">
                       <table id="tablesorter1" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:center;width:120px;">Keyword</th>
                                    <th scope="col" style="text-align:center;width:60px;">Position</th>                                 
                                    <th scope="col" style="text-align:center;width:100px;">Competing Pages</th>          
                                    <th scope="col" style="text-align:center;width:100px;">Cost per Click</th>
                                    <th scope="col" style="text-align:center;width:auto;">Url</th>
                                </tr>
                            </thead>
                            <tbody>     
                            <? 
     						    $counter = 1;
								$PosAve =0;
								foreach ( $aKeywords as &$keyword){
									if ($counter>=$content_start && $counter<=$content_end){
											
										   $totalTrafficMonthly = $totalTrafficMonthly + $keyword->_globalMonthlySearches;								   
										   $clicksDay = ceil(number_format($keyword->_meanClicks, 2, '.', ''));
										   $clickskMonth = $clicksDay*30;
										   $clicksYear = $clickskMonth*12;
										   $costPerClick = $keyword->_averageCpc/1000000;
										   $costYearly = $costPerClick * $clicksYear;
										   $PosAve =  $PosAve + $keyword->_meanAveragePosition;
										   $total = $total + $costPerClick;
										   $real_pos_on_page = substr($keyword->_position, -1);
										   if ($real_pos_on_page=='0')
											   $real_pos_on_page = '10';
								?>                                              
										<tr>
											<td class="col-keyword" style="text-align:left;width:250px;font-size:11px;font-weight:bold;"><?php echo strtoupper($keyword->_string); ?></td>
											<td class="col-position" style="text-align:center"><?php echo $keyword->_position; ?></td>
                                             <? $min_searches = get_option('optimum7_google_ranking_checker_min_searches');?>
											<td style="text-align:center"><?php if ($keyword->_globalMonthlySearches < $min_searches){
													$keyword->_globalMonthlySearches = $min_searches;
													//echo number_format($keyword->_globalMonthlySearches, 0, '.', ',');
													echo number_format($keyword->_competingPage, 0, '.', ',');
												}
												else{
													$keyword->_globalMonthlySearches = str_replace(',', '', (string) $keyword->_globalMonthlySearches);
													//echo number_format($keyword->_globalMonthlySearches, 0, '.', ',');
													echo number_format($keyword->_competingPage, 0, '.', ',');
                                            	}?>
                                            </td>                                           
                                            <? $min_cost_click = get_option('optimum7_google_ranking_checker_min_cost_click');?>
											<td style="text-align:center"><?php if ($keyword->_averageCpc/1000000 < $min_cost_click){
													$keyword->_averageCpc = $min_cost_click;
							 						echo  money_format('%.2n',  $keyword->_averageCpc);
												}
												else{
													$keyword->_averageCpc = $keyword->_averageCpc/1000000;
													echo money_format('%.2n',  $keyword->_averageCpc);
                                            	}?>
                                            </td>
                                            <td style="text-align:left">
                                            <?
													echo  $keyword->_url;
											?>	
                                            </td>
										</tr>  
									<? 									  
									}
								  $counter = $counter+1;
							} ?>                                                                   
                            </tbody>
                        </table>
                    </div>
       		 <? 
		}?>		
		<? if (get_option('optimum7_google_ranking_checker_backlink')==1){?>
 		 <!-- we have release this plugin for public uses, we just need you to keep the following link (url) to our site, thanks.-->
        <p style="font-size:10px;margin: 25px 0 0 30px;">Copyright &copy; 2011 <a href="http://optimum7.com" title="Optimum7 - Internet Marketing Services"><span style="text-decoration:none;color:#000;">Internet Marketing Services</span></a> by Optimum7</p>
		<? }?>        
		<?	
	}
	catch (Exception $e){
		echo $e->getMessage();
	}
?>