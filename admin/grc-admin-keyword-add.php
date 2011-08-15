<?

	$keywords = '';	

	if($_POST['submit'] == 'Save Keywords')

	{

			$keywords = explode(';', $_POST['optimum7_google_ranking_checker_keywords']);

			$words= array();			

			foreach ($keywords as $key => $value)

			{

				$split_keyword = explode(',', $value);

				array_push($words, trim($split_keyword[0]));

				if (empty($split_keyword[0])) unset($value);

			}			

			$result = array_unique($words);			

			$duplicates = count($words)-count($result);

			$keywords = $_POST['optimum7_google_ranking_checker_keywords'];

			update_option('optimum7_google_ranking_checker_keywords', $keywords);

            update_option('optimum7_google_ranking_checker_keywords_added', true);

			if ($duplicates>0)

			{

				?><div class="updated"><p><strong><?php _e('Keywords saved. But you have duplicated keywords' ); ?></strong></p></div><?	

			}

			else

			{

				?><div class="updated"><p><strong><?php _e('Keywords saved.' ); ?></strong></p></div><?		

			}

	}

	else

	{

		$keywords = get_option('optimum7_google_ranking_checker_keywords');

	}	

?>



<div class="wrap"> 
	
    <?php include("grc-admin-keywords-head-area.php");?>

    <div style="margin-top:20px;margin-bottom:10px;font-style:italic;"> This form is intended to define the keywords that will be shown and updated using Google Adwords API.<br/> <strong>The keywords should be added separated by semicolon.</strong> Ex. keyword, domain.com, competing pages;</div>

    		<form method="post" action=""> 

    		<input type='hidden' name='optimum7_ranking_checker_add_keywords_page' value='add_keyword' /><input type="hidden" name="action" value="" />

    		<input type="hidden" id="_wpnonce" name="_wpnonce" value="" />

    		<input type="hidden" name="_wp_http_referer" value="/wp-content/plugins/optimum7-google-ranking-checker/admin/grc-admin-keyword-add.php" /> 

            <table class="form-table"> 

                <tr valign="top"> 

                <th scope="row"><label for="optimum7_google_ranking_checker_keywords">Keywords:</label></th> 

                <td><textarea rows="10" cols="80" name="optimum7_google_ranking_checker_keywords" class="regular-text" style="margin-left:-100px;" ><?php echo $keywords; ?></textarea>

                </tr> 

            </table> 

		<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Keywords"  /></p></form> 

		<?

			 $keywords = explode(';', $keywords);

			 unset($keywords[sizeof($keywords)-1]);

		?>

		<? if (count($keywords)>0) {?>

                <div>List of Keywords: <strong><? echo count($keywords);?></strong></div>

                    <?

					$limit = 10;

					$page = $_GET['start'];

					if ((!$page) || (is_numeric($page) == false) || ($page < 0))

					{

						$page = 1; //default	

					}

					$set_limit = $page * $limit - ($limit);

					$prev_page = $page-1;

					$next_page = $page+1;

					$total_item=count($keywords);

					$total_pages = ceil($total_item / $limit);					

					if ($total_item == 0)

					{

						$content_start = 0;

					}

					else

					{

						$content_start = $set_limit +1;

					}

					$content_end = (($limit*$page)>=$total_item)?$total_item:($limit*$page);

					$start_page = ($page<9)?1:($page-5);

					$end_page = (($start_page+9)<$total_pages)?($start_page+9):$total_pages;

 					if ($total_pages > 1)

					{ ?>

                    	<div style="padding-top:10px;">

                            <strong><span>Page <?php echo $page;?> of <?php echo $total_pages; ?> - </span></strong> <?php

                            if ($page != 1)

                            { ?>

                                <a href="admin.php?page=grc_addnew&start=<?=$prev_page?>"><<</a> <?php

                            }

                            for ($count=1; $count<=$total_pages; $count++)

                            {

                                if ($count == $page)

                                { ?>

                                    <span><?php echo $count; ?></span> <?php

                                }

                                else

                                {?>

                                    <a href="admin.php?page=grc_addnew&start=<?=$count?>" ><?php echo $count; ?></a> <?php

                                }

                            }

                            if ($page != $total_pages)

                            { ?>

                                <a href="admin.php?page=grc_addnew&start=<?php echo $next_page; ?>">>></a> <?php

                            } ?>

                    	</div> <?php

                    }?>

 				   <div style="margin-top:5px;margin-bottom:20px;">

                       <table class="widefat"u style="width:auto;">

                         <thead>

                            <tr>

                              <th >Keyword</th>

                              <th>Url</th>

                              <th>Competing Pages</th>

                            </tr>

                         </thead>

                         <tfoot>

                            <tr>

                              <th>Keyword</th>

                              <th>Url</th>

                              <th>Competing Pages</th>

                            </tr>

                         </tfoot>

                         <tbody>

                             <tr>

								<? 

                                $counter = 1;

                                foreach ($keywords as $key => $value)

                                {

                                    $split_keyword = explode(',', $value);

                                    if ($counter>=$content_start && $counter<=$content_end)

                                    {

										if (!empty($split_keyword[0]))

										{

											?>           

										   <tr>

										   <? foreach ($split_keyword as $key => $split){?>

											 <td><?php echo trim($split); ?></td> <? }?>

										   </tr>                        

									 <? } 

							    	}

                                  $counter = $counter+1;

                                }

                                ?> 

                             </tr>

           				</tbody>

       				 </table>

  				</div>

  		<? }?>

</div>  

<div class="clear"></div></div><!-- wpbody-content --> 

<div class="clear"></div></div><!-- wpbody --> 

<div class="clear"></div></div><!-- wpcontent --> 

</div><!-- wpwrap --> 