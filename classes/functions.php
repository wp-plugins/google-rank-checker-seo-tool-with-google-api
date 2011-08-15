<?
require_once(GRC_PLUGINPATH. '/classes/google/Api/Ads/AdWords/Lib/AdWordsUser.php');
require_once(GRC_PLUGINPATH. '/classes/google/Api/Ads/Common/Util/MapUtils.php');
require_once(GRC_PLUGINPATH . '/classes/class_element.php');

class functions{
	public $Keywords_dictionary;	
	public $message;
	public function Get_Keywords($_isForcingToUpdate=false,$_array_keywords,$_searchPosition=true,$_isForPublicViewers=false){
		try{	
			 set_time_limit(0);
		 	 $Last_Date_Updated = get_option('optimum7_google_ranking_checker_last_date_updated');
			 $Last_Date_Updated = date(  "m/d/Y, g:i a", strtotime( $Last_Date_Updated ) );
			 $Last_Date_Updated_short_format = date(  "m/d/Y", strtotime( $Last_Date_Updated ) );
			 $Any_new_keyword = get_option('optimum7_google_ranking_checker_keywords_added');
			 $annual_times = get_option('optimum7_google_ranking_checker_annual_times');
			 $words= array();	
			 foreach ($_array_keywords as $key => $value){
				$split_keyword = explode(',', $value);
				array_push($words, trim($split_keyword[0]));
			 } 	
			 $this->Keywords_dictionary = new Dictionary();
			 if (sizeof($_array_keywords)>0){			 
				if ($_isForcingToUpdate==false){			   			
					if ($Any_new_keyword==true){	  
				   		 $this->message = 'New keyword has been added, please refresh!';
					}
					$data = $this->Import_From_Database();					
					if (!sizeof($data)>0) return;
					foreach ($data as &$value){
						$tmp_keyword = new element();
						$tmp_keyword->_string = $value->_string;
						$tmp_keyword->_page = $value->_page;
						$tmp_keyword->_meanAveragePosition = $value->_meanAveragePosition;
						$tmp_keyword->_averageCpc = $value->_averageCpc;
						$tmp_keyword->_searchType = $value->_searchType;
						$tmp_keyword->_meanClicks = $value->_meanClicks;
						$tmp_keyword->_meanTotalCost = $value->_meanTotalCost;		
						$tmp_keyword->_globalMonthlySearches = $value->_globalMonthlySearches;		
						$tmp_keyword->_position = $value->_position;
						$tmp_keyword->_url = $value->_url;		
						$tmp_keyword->_results = $value->_results;
						$tmp_keyword->_competingPage = $value->_competingPage;
						$tmp_keyword->_total_Yearly_Traffic_Value = $value->_total_Yearly_Traffic_Value;
						if ($_isForPublicViewers==false || $tmp_keyword->_page<get_option('optimum7_google_ranking_checker_max_page')){
							$this->Keywords_dictionary->Add($tmp_keyword->_string,$tmp_keyword);
						}
					}
			 	}
			 	else{
					// Process has been forced to update from Google
					$this->Keywords_dictionary = $this->Pull_Data_From_google($_array_keywords,$_searchPosition);					
					update_option('optimum7_google_ranking_checker_keywords_added',false);
					$Google_times = get_option('optimum7_google_ranking_checker_times_on_google');
				    $this->message = 'FYI: Update process has been forced, Data comes from Google Adwords [' . $Google_times. ']';
			 	}
			 }
			 else{
				$this->message = 'FYI: No keywords found';
				$this->Save_To_Database($this->Keywords_dictionary);
			 }
			 return $this->Keywords_dictionary;
		}
		catch (Exception $e){	
			throw new Exception($e->getMessage());
		}
	}	

	public function Save_To_Database($_keywords_dictionary){
		try{			
			update_option('optimum7_google_ranking_checker_keywords_data', $_keywords_dictionary);
		}
		catch (Exception $e){
			throw new Exception($e->getMessage());
		}	
	}

	public function Import_From_Database(){
		try{
			$_data = get_option('optimum7_google_ranking_checker_keywords_data');
			if (sizeof($_data)>0) {
				$this->message .= ' <br/> FYI: Data comes from Database';
			}
			return $_data;			
		}
		catch (Exception $e){
			throw new Exception($e->getMessage());
		}	
	}

	public function  Pull_Data_From_google($_array_keywords,$_searchPosition=true){
		try{
			$Google_times = get_option('optimum7_google_ranking_checker_times_on_google');
			$Google_times = $Google_times + 1;
			update_option('optimum7_google_ranking_checker_times_on_google', $Google_times);
			$today = date("l, F d, Y h:i" ,time());
			update_option('optimum7_google_ranking_checker_last_date_updated', $today);
			$this->Keywords_dictionary = $this->Set_Keywords($_array_keywords,$_searchPosition);
			return $this->Keywords_dictionary;
		}
		catch (Exception $e){
			throw new Exception($e->getMessage());
		}	
	}

	public function Set_Keywords($_array_keywords,$_searchPosition=true){
		try {
		  $tmp_dictionary = new Dictionary();
		  $user = new AdWordsUser();
		  //Get options from Settings
		  $email = get_option('optimum7_google_ranking_checker_email');
		  $password = get_option('optimum7_google_ranking_checker_pass');
		  $agent_name = get_option('optimum7_google_ranking_checker_agent_name');
		  $application_token = get_option('optimum7_google_ranking_checker_app_token');
		  $developer_token = get_option('optimum7_google_ranking_checker_dev_token');
		  $agent_id_email = get_option('optimum7_google_ranking_checker_agent_id_email');	
		  $google_API = get_option('optimum7_google_ranking_checker_google_API');	

		  $user->SetEmail($email);
		  $user->SetPassword($password);
		  $user->SetClientLibraryUserAgent($agent_name);
		  $user->SetClientId($agent_id_email);
		  $user->SetDeveloperToken($developer_token);
		  $user->SetApplicationToken($application_token);

		  $keywords = array();
		  $array_averageMonthlySearches = array();		  
		  $targetingIdeaService = $user->GetTargetingIdeaService('v201101');
		  $trafficEstimatorService = $user->GetTrafficEstimatorService('v201101');
		  $urls = array(); 
		  $words =array();
		  $competingPages = array();

		  foreach ($_array_keywords as &$value){ 
			 $split_keyword = explode(',', $value);			 
			 $words[]= trim($split_keyword[0]);
			 $urls[]= trim($split_keyword[1]);
			 $competingPages[] = trim($split_keyword[2]);
			 $keywords[] = new Keyword(trim($split_keyword[0]), 'EXACT');

			 // Create seed keyword.
			 $keyword = new Keyword();
			 $keyword->text = trim($split_keyword[0]);
			 $keyword->matchType = 'EXACT';
			 $selector = new TargetingIdeaSelector();
			 $selector->requestType = 'STATS';
			 $selector->ideaType = 'KEYWORD';
			 $selector->requestedAttributeTypes = array('CRITERION', 'AVERAGE_TARGETED_MONTHLY_SEARCHES');

			  // Set selector paging (required for targeting idea service).
			  $paging = new Paging();
			  $paging->startIndex = 0;
	  		  $paging->numberResults = 10;
			  $selector->paging = $paging;
			  // Create related to keyword search parameter.
			  $relatedToKeywordSearchParameter = new RelatedToKeywordSearchParameter();
			  $relatedToKeywordSearchParameter->keywords = array($keyword);

			  // Create keyword match type search parameter to ensure unique results.
			  $keywordMatchTypeSearchParameter = new KeywordMatchTypeSearchParameter();
			  $keywordMatchTypeSearchParameter->keywordMatchTypes = array('EXACT');
			  $selector->searchParameters =  array($relatedToKeywordSearchParameter, $keywordMatchTypeSearchParameter);

			  // Get related keywords.
			  $page = $targetingIdeaService->get($selector);
			  if (isset($page->entries)){
				foreach ($page->entries as $targetingIdea){
				  $data = MapUtils::GetMap($targetingIdea->data);
				  $keyword = $data['CRITERION']->value;
				  $averageMonthlySearches =  isset($data['AVERAGE_TARGETED_MONTHLY_SEARCHES']->value) ? $data['AVERAGE_TARGETED_MONTHLY_SEARCHES']->value : 0;
   			 	  $array_averageMonthlySearches[]= $averageMonthlySearches;
				}
			  } 
		  }

		  // Get the TrafficEstimatorService.
		  $keywordEstimateRequests = array();
		  foreach ($keywords as $keyword){
			$keywordEstimateRequest = new KeywordEstimateRequest();
			$keywordEstimateRequest->keyword = $keyword;
			$keywordEstimateRequests[] = $keywordEstimateRequest;
		  }

		  // Create ad group estimate requests.
		  $adGroupEstimateRequest = new AdGroupEstimateRequest();
		  $adGroupEstimateRequest->keywordEstimateRequests = $keywordEstimateRequests;
		  $maxcpc = get_option('optimum7_google_ranking_checker_max_cpc');
		  $adGroupEstimateRequest->maxCpc = new Money($maxcpc * 1000000);
		  $adGroupEstimateRequests = array($adGroupEstimateRequest);

		  // Create campaign estimate requests.
		  $campaignEstimateRequest = new CampaignEstimateRequest();
		  $campaignEstimateRequest->adGroupEstimateRequests = $adGroupEstimateRequests;
		  $campaignEstimateRequest->targets = array(new CountryTarget('US'), new LanguageTarget('en'));
		  $campaignEstimateRequests = array($campaignEstimateRequest);

		  // Create selector.
		  $selector = new TrafficEstimatorSelector();
		  $selector->campaignEstimateRequests = $campaignEstimateRequests;
			
		  // Get traffic estimates.
		  $result = $trafficEstimatorService->get($selector);
			 
		  // Display traffic estimates.
		  if (isset($result)) {
				$keywordEstimates = $result->campaignEstimates[0]->adGroupEstimates[0]->keywordEstimates;
				for ($i = 0; $i < sizeof($keywordEstimates); $i++){
				  $keyword = $keywordEstimateRequests[$i]->keyword;
				  $keywordEstimate = $keywordEstimates[$i];
				  // Find the mean of the min and max values.
				 // $AverageCpc = ($keywordEstimate->max->averageCpc->microAmount + $keywordEstimate->max->averageCpc->microAmount) / 2;
				  $AverageCpc = ($keywordEstimate->min->averageCpc->microAmount + $keywordEstimate->max->averageCpc->microAmount) / 2;
				  $meanAveragePosition = ($keywordEstimate->min->averagePosition + $keywordEstimate->max->averagePosition) / 2;
				  $meanClicks = ($keywordEstimate->min->clicksPerDay + $keywordEstimate->max->clicksPerDay)/2;
				  $meanTotalCost = ($keywordEstimate->min->totalCost->microAmount + $keywordEstimate->max->totalCost->microAmount) / 2;
				  $current_keyword = new element();
				  $current_keyword->_string =$keyword->text; 
				  $current_keyword->_searchType =$keyword->matchType; 
				  $current_keyword->_averageCpc = $AverageCpc; 
				  $current_keyword->_meanAveragePosition = round($meanAveragePosition, 2); 
				  $current_keyword->_meanClicks = $meanClicks; 
				  $current_keyword->_meanTotalCost = $meanTotalCost; 
				  $current_keyword->_url = $urls[$i]; 
				  $current_keyword->_competingPage =  $competingPages[$i];
				  $current_keyword->_globalMonthlySearches =$array_averageMonthlySearches[$i];
				  $current_keyword->_results= $this->getResults(trim($current_keyword->_string));
				  $current_keyword->_total_Yearly_Traffic_Value = (((($current_keyword->_averageCpc/1000000) * $current_keyword->_globalMonthlySearches) *$annual_times)); 

 				  if ($_searchPosition==true){
					  $found = false;
					  $x = 0;
					  $limit = get_option('optimum7_google_ranking_checker_max_page');
					  $limit = $limit*10;
					  for($x; $x < $limit && $found == false;){
							set_time_limit(0);
							$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=".stripslashes(str_replace(' ', '%20',trim($current_keyword->_string))).'&key='.$google_API.'&start='.$x;
							// note how referer is set manually
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_REFERER,  'http://www.'.$current_keyword->_url);
							$body = curl_exec($ch);
							curl_close($ch);
							// now, process the JSON string
							$json = json_decode($body);
							// print out the Array
							//print_r($json);
							//echo $json->responseData->results.length();
							$x4 = $x + 4;
							$old_x = $x;
							for($x; $x < $x4 && $found == false; $x = $x + 1){
								//echo $x-$old_x.'<br />';
								//echo $x.': '.$json->responseData->results[$x-$old_x]->url. ' - ' . $current_keyword->_url . '<br />';
								if (stristr($json->responseData->results[$x-$old_x]->url, trim($current_keyword->_url)) !== FALSE){
									$found = true;
								}
								//echo $json->responseData->results[$y]->unescapedUrl;
								//echo "<br />";
							}
							// now have some fun with the results...
						}
						if($found){
							$foundon = $x.'th';
							if($x == 1){ $foundon = $x.'st'; }
							else if($x == 2){ $foundon = $x.'nd'; }
							else if($x == 3){ $foundon = $x.'rd'; }
						}
				    
						$current_keyword->_position = $x; 
						$current_keyword->_page = ceil(($current_keyword->_position/10)); 
				 }
				 else{
					 $current_keyword->_position = $limit*10; 
				     $current_keyword->_page = ceil(($current_keyword->_position/10));
				 }
				  $tmp_dictionary->Add($current_keyword->_string, $current_keyword);
				  $this->Save_To_Database($tmp_dictionary);
				}
			} 
			else{
			  throw new Exception("No traffic estimates were returned.\n");
			}
			return $tmp_dictionary;
		} 
		catch (Exception $e){
		   throw new Exception($e->getMessage());
		}
	}

	public function getResults($search){
			$results = json_decode( file_get_contents( 'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=' . urlencode( $search ).'&key='.$google_API) );
			return $results->responseData->cursor->estimatedResultCount;
	}
}
?>