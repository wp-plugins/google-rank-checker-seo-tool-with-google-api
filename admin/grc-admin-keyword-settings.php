  <script type="text/javascript">  

	  $(function(){

        $('#tabs').tabs();

    });

    </script>

<?

	//initializing fields.

	$email = '';

	$password = '';

	$agent_name = '';

	$application_token = '';

	$developer_token = '';

	$agent_id_email = '';

	$Show_Last_Date_Update_Label = '';

	$Schedule_downloading = '';

	$Date_Format = '';

	$Table_title = '';	

	$limit = '';

	$maxcpc = '';	

	$maxpage='';

	$min_searches='';

	$google_API ='';
  	
	$backlink = '0';

   //getting the post forms for reset connection.

	if($_POST['reset'] == 'Reset connections'){
		//initializing the option for google connection counter.
		update_option('optimum7_google_ranking_checker_times_on_google', 0);
	}

	//getting the post forms for submit.
	if($_POST['submit'] == 'Save Changes'){
			//setting options
			$email = $_POST['optimum7_google_ranking_checker_email'];
			update_option('optimum7_google_ranking_checker_email', $email);

			$password = $_POST['optimum7_google_ranking_checker_pass'];
			update_option('optimum7_google_ranking_checker_pass', $password);
			
			$agent_name = $_POST['optimum7_google_ranking_checker_agent_name'];

			update_option('optimum7_google_ranking_checker_agent_name', $agent_name);

			

			$application_token = $_POST['optimum7_google_ranking_checker_app_token'];

			if (empty($application_token)){

			   $application_token = 'ignored';

			}

			update_option('optimum7_google_ranking_checker_app_token', $application_token);

			

			$developer_token = $_POST['optimum7_google_ranking_checker_dev_token'];

			update_option('optimum7_google_ranking_checker_dev_token', $developer_token);

			

			$agent_id_email = $_POST['optimum7_google_ranking_checker_agent_id_email'];

			update_option('optimum7_google_ranking_checker_agent_id_email', $agent_id_email);

			

			$Show_Last_Date_Update_Label = $_POST['optimum7_google_ranking_checker_date_update_label'];

			update_option('optimum7_google_ranking_checker_date_update_label', $Show_Last_Date_Update_Label);

			

			$Date_Format = $_POST['optimum7_google_ranking_checker_date_format'];

			update_option('optimum7_google_ranking_checker_date_format', $Date_Format);

			

			$Table_title = $_POST['optimum7_google_ranking_checker_table_title'];

			update_option('optimum7_google_ranking_checker_table_title', $Table_title);

			

			$limit = $_POST['optimum7_google_ranking_checker_limit_per_page'];

			update_option('optimum7_google_ranking_checker_limit_per_page', $limit);

			

			$maxcpc = $_POST['optimum7_google_ranking_checker_max_cpc'];

			update_option('optimum7_google_ranking_checker_max_cpc', $maxcpc);

			

			$min_searches = $_POST['optimum7_google_ranking_checker_min_searches'];

			update_option('optimum7_google_ranking_checker_min_searches', $min_searches);

			

			$maxpage = $_POST['optimum7_google_ranking_checker_max_page'];

			update_option('optimum7_google_ranking_checker_max_page', $maxpage);		

			

			$min_annual = $_POST['optimum7_google_ranking_checker_min_annual'];

			update_option('optimum7_google_ranking_checker_min_annual', $min_annual);

			

			$min_cost_click = $_POST['optimum7_google_ranking_checker_min_cost_click'];

			update_option('optimum7_google_ranking_checker_min_cost_click', $min_cost_click);

			

			$annual_times = $_POST['optimum7_google_ranking_checker_annual_times'];

			update_option('optimum7_google_ranking_checker_annual_times', $annual_times);	

		

			$google_API = $_POST['optimum7_google_ranking_checker_google_API'];

			update_option('optimum7_google_ranking_checker_google_API', $google_API);	
			
			
			$backlink = $_POST['optimum7_google_ranking_checker_backlink'];
			update_option('optimum7_google_ranking_checker_backlink', $backlink);

			?>

			<div class="updated"><p><strong><?php _e('General options saved.' ); ?></strong></p></div>

			<?php

	}
	else{

		//tab#1 options

			$email = get_option('optimum7_google_ranking_checker_email');

			$password = get_option('optimum7_google_ranking_checker_pass');

			$agent_name = get_option('optimum7_google_ranking_checker_agent_name');

			$application_token = get_option('optimum7_google_ranking_checker_app_token');		

				if (empty($application_token)){

					 $application_token = 'ignored'; //default value

					 update_option('optimum7_google_ranking_checker_app_token', $application_token);

				}			

			$developer_token = get_option('optimum7_google_ranking_checker_dev_token');

			$agent_id_email = get_option('optimum7_google_ranking_checker_agent_id_email');	

		

		//tab#2 options

			$maxcpc = get_option('optimum7_google_ranking_checker_max_cpc');

				if (empty($maxcpc)){

					 $maxcpc = '10'; //default value

					 update_option('optimum7_google_ranking_checker_max_cpc', $maxcpc);

				}

			$maxpage = get_option('optimum7_google_ranking_checker_max_page');

				if (empty($maxpage)){

					 $maxpage = '3'; //default value

					 update_option('optimum7_google_ranking_checker_max_page', $maxpage);

				}				

			$min_annual = get_option('optimum7_google_ranking_checker_min_annual');

				if (empty($min_annual)){

			   $min_annual = '200'; //default value

				   update_option('optimum7_google_ranking_checker_min_annual', $min_annual);

			}

			$min_cost_click = get_option('optimum7_google_ranking_checker_min_cost_click');

				if (empty($min_cost_click)){

				   $min_cost_click = '1'; //default value

				   update_option('optimum7_google_ranking_checker_min_cost_click', $min_cost_click);

				}

			$annual_times = get_option('optimum7_google_ranking_checker_annual_times');

			if (empty($annual_times)){

				   $annual_times = '1';

				   update_option('optimum7_google_ranking_checker_annual_times', $annual_times);

				}

			$min_searches = get_option('optimum7_google_ranking_checker_min_searches');

				if (empty($min_searches)){

					 $min_searches = '1000'; //default value

					 update_option('optimum7_google_ranking_checker_min_searches', $min_searches);

				}

			$google_API = get_option('optimum7_google_ranking_checker_google_API');

			//tab#3 options	

			$Table_title = get_option('optimum7_google_ranking_checker_table_title');

			$Show_Last_Date_Update_Label = get_option('optimum7_google_ranking_checker_date_update_label');

			$Date_Format = get_option('optimum7_google_ranking_checker_date_format');

			$limit = get_option('optimum7_google_ranking_checker_limit_per_page');
			
			if (empty($limit)){

				   $limit = '25';

				   update_option('optimum7_google_ranking_checker_limit_per_page', $limit);

				}
				
			$backlink = get_option('optimum7_google_ranking_checker_backlink');
	}			

?>

<div class="wrap"> 

    <?php include("grc-admin-keywords-head-area.php");?>
    
    <form method="post" action=""> 

    <input type='hidden' name='optimum7_ranking_checker_settings_page' value='settings' /><input type="hidden" name="action" value="" />

    <input type="hidden" id="_wpnonce" name="_wpnonce" value="" />

    <input type="hidden" name="_wp_http_referer" value="/wp-content/plugins/optimum7-google-ranking-checker/admin/grc-keyword-settings.php" /> 



		<div id="tabs">

			<ul>

				<li><a href="#tabs-1">Google Adwords Credentials</a></li>

				<li><a href="#tabs-2">Rules</a></li>

				<li><a href="#tabs-3">Keywords Table</a></li>

                <li><a href="#tabs-4">Connections</a></li>

           </ul>

			<div id="tabs-1">

           		

                <div style="margin-top:20px;margin-bottom:10px;font-style:italic;"> The following options will be used to log into Google Adwords. If you do not have a Google Adwords account yet, please </br> <a href="http://adwords.google.com/support/aw/bin/answer.py?hl=en&answer=142822">click here</a></div>



                <table class="form-table"> 

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_email" style="font-size:12px;">Email:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_email" type="text" id="optimum7_google_ranking_checker_email" value="<?php echo $email; ?>" class="regular-text" />

                        <span class="description">(Required)</span></td> 

                        

                        </tr> 

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_pass" style="font-size:12px;">Password:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_pass" type="text" id="optimum7_google_ranking_checker_pass"  value="<?php echo $password;?>" class="regular-text" /> 

                        <span class="description">(Required)</span>

                        </td> 

                        </tr> 

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_agent_name" style="font-size:12px;">Agent Name:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_agent_name" type="text" id="optimum7_google_ranking_checker_agent_name" value="<?php echo $agent_name;?>" class="regular-text code" />

                        <span class="description">(Optional)</span>

                        </td> 

                        </tr> 

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_app_token" style="font-size:12px;">Application Token:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_app_token" type="text" id="optimum7_google_ranking_checker_app_token" value="<?php echo $application_token;?>" class="regular-text code" /> 

                       <span class="description">(Optional) - default value is 'ignored'</span></td> 

                        </tr> 

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_dev_token" style="font-size:12px;">Developer Token:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_dev_token" type="text" id="optimum7_google_ranking_checker_dev_token" value="<?php echo $developer_token;?>" class="regular-text code" /> 

                         <span class="description">(Required)</span>

                        </td> 

                        </tr>  

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_agent_id_email" style="font-size:12px;">Agent Id/Email:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_agent_id_email" type="text" id="optimum7_google_ranking_checker_agent_id_email" value="<?php echo $agent_id_email;?>" class="regular-text code" /> 

                        <span class="description">(Optional)</span>

                        </td> 

                        </tr>

                       <tr valign="top"> 

                        	<th scope="row"><label for="optimum7_google_ranking_checker_google_API"  style="font-size:12px;">Google API</label></th> 

                       		<td><input name="optimum7_google_ranking_checker_google_API" type="text" id="optimum7_google_ranking_checker_google_API" value="<?php echo $google_API;?>" class="regular-text code"  style="width:640px;" /></td> 

                       </tr>

                </table> 

            </div>

		    <div id="tabs-2">

            	<table class="form-table"> 

                 	   <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_max_cpc" style="font-size:12px;">Max CPC:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_max_cpc" type="text" id="optimum7_google_ranking_checker_max_cpc" value="<?php echo $maxcpc;?>" class="regular-text code" /> 

                       	 <span class="description">(Optional) - default value is '10$'</span>

                        </td> 

                        </tr>

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_max_page" style="font-size:12px;">Top Google Page:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_max_page" type="text" id="optimum7_google_ranking_checker_max_page" value="<?php echo $maxpage;?>" class="regular-text code" /> 

                        <span class="description">(Optional) - default value is '3'</span>

                        </td> 

                        </tr>

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_min_searches"  style="font-size:12px;">Min Monthly Potential Traffic: </label></th> 

                        <td><input name="optimum7_google_ranking_checker_min_searches" type="text" id="optimum7_google_ranking_checker_min_searches" value="<?php echo $min_searches;?>" class="regular-text code" /> 

                       <span class="description">(Optional) - default value is '1000'</span>

                        </tr>

                         <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_min_cost_click"  style="font-size:12px;">Min Cost Per Click:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_min_cost_click" type="text" id="optimum7_google_ranking_checker_min_cost_click" value="<?php echo $min_cost_click;?>" class="regular-text code" /> 

                        <span class="description">(Optional) - default value is '1$'</span>

                        </td> 

                        </tr>

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_annual_times"  style="font-size:12px;">annual traffic = monthly searches x Ave CPC x</label></th> 

                        <td><input name="optimum7_google_ranking_checker_annual_times" type="text" id="optimum7_google_ranking_checker_annual_times" value="<?php echo $annual_times;?>" class="regular-text code" /> 

                        <span class="description">(Optional) - default value is '1'</span>

                        </td> 

                        </tr>
                </table> 

           </div>

			<div id="tabs-3">

            	<table class="form-table"> 

          				<tr valign="top"> 

                            <th scope="row"><label for="optimum7_google_ranking_checker_table_title"  style="font-size:12px;">Table Title:</label></th> 

                            <td><input name="optimum7_google_ranking_checker_table_title" type="text" id="optimum7_google_ranking_checker_table_title" value="<?php echo $Table_title;?>" class="regular-text code" /> 

                            <span class="description">(Optional)</span>

                            </td> 

                        </tr>

                        <tr valign="top">

                        <th scope="row" style="font-size:12px;">Last Date Update?:</th>

                        <td> <fieldset><legend class="screen-reader-text"  style="font-size:12px;"><span></span></legend><label for="optimum7_google_ranking_checker_date_update_label">

                        <input name="optimum7_google_ranking_checker_date_update_label" type="checkbox" id="optimum7_google_ranking_checker_date_update_label" value="1"  <?  if ($Show_Last_Date_Update_Label=='1') {echo "checked='yes'";} ?>  />

                        </label>            

                        </fieldset></td>

                        </tr>

                        <tr>

                        <th scope="row" style="font-size:12px;">Date Format:</th>

                        <td>

                            <fieldset><legend class="screen-reader-text"  style="font-size:12px;"><span>Date Format</span></legend>

                            <label title='F j, Y'><input type='radio' name='optimum7_google_ranking_checker_date_format' value='F j, Y' <?  if ($Date_Format=='F j, Y') {echo "checked='checked'";} ?> /> <span><? echo date('F j, Y')?></span></label><br />            

                            <label title='Y/m/d'><input type='radio' name='optimum7_google_ranking_checker_date_format' value='Y/m/d' <?  if ($Date_Format=='Y/m/d') {echo "checked='checked'";} ?>/> <span><? echo date('Y/m/d')?></span></label><br />

                            <label title='m/d/Y'><input type='radio' name='optimum7_google_ranking_checker_date_format' value='m/d/Y' <?  if ($Date_Format=='m/d/Y') {echo "checked='checked'";} ?> /> <span><? echo date('m/d/Y')?></span></label><br />

                            <label title='d/m/Y'><input type='radio' name='optimum7_google_ranking_checker_date_format' value='d/m/Y'<?  if ($Date_Format=='d/m/Y') {echo "checked='checked'";} ?> /> <span><? echo date('d/m/Y')?></span></label><br />

                            <p><a href="http://codex.wordpress.org/Formatting_Date_and_Time">Documentation on date and time formatting</a>.</p>

                            </fieldset>

                   		</td>

                   		</tr>

                        <tr valign="top"> 

                        <th scope="row"><label for="optimum7_google_ranking_checker_limit_per_page"  style="font-size:12px;">Keywords per Page:</label></th> 

                        <td><input name="optimum7_google_ranking_checker_limit_per_page" type="text" id="optimum7_google_ranking_checker_limit_per_page" value="<?php echo $limit;?>" class="regular-text code" /> 

                        <span class="description">(Optional) - default value is '25'</span>

                        </td> 

                        </tr>
                        
                        <tr valign="top">

                        <th scope="row" style="font-size:12px;">Show Support Link?:</th>

                        <td> <fieldset><legend class="screen-reader-text"  style="font-size:12px;"><span></span></legend><label for="optimum7_google_ranking_checker_backlink">						
                        <select name="optimum7_google_ranking_checker_backlink" id="optimum7_google_ranking_checker_backlink" style="width:80px;">
                            <option value='1' <? if ($backlink==1) {echo 'selected';}?>>Yes</option>
                            <option value='0' <? if ($backlink==0) {echo 'selected';}?>>No</option>
                        </select>
    				
                        </label>            

                        </fieldset></td>

                        </tr>

          		</table> 

            </div>

            <div id="tabs-4">

                <table class="form-table"> 

                      <tr valign="top"> 

                          <th scope="row"><label for="optimum7_google_ranking_checker_google_counter" style="font-size:12px;">Google Connections: <? echo get_option('optimum7_google_ranking_checker_times_on_google');?></label></th> 

                      </tr>

                </table>   

             <input type="submit" name="reset" id="reset" class="button-primary" value="Reset connections"  style="margin-top:10px;margin-left:230px;"/>

        	</div>		

        </div>        

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"  />

</p>

</form> 

<!-- we have release this plugin for public uses, we just need you to keep the following link (url) to our site, thanks.-->

<span class="description">In order to create a Wordpress Page or Post to show the results, please paste this code: <strong>[optimum7_google_ranking_checker_form]</strong></span>

	<? if ($backlink==1){?>
    <div style="font-size:10px;margin: 25px 0 0 0px;">Copyright &copy; 2011 <a href="http://optimum7.com?utm_source=RankCheckPlugin" title="Optimum7 - Internet Marketing Services"><span style="text-decoration:none;color:#000;">Internet Marketing Services</span></a> by Optimum7</div>
    <? }?>
    
</div>  

<div class="clear"></div></div><!-- wpbody-content --> 

<div class="clear"></div></div><!-- wpbody --> 

<div class="clear"></div></div><!-- wpcontent --> 

</div><!-- wpwrap --> 

