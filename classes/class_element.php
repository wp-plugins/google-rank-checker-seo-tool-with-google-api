<?
class element{
	public $_string;	
	public $_page;	
	public $_position;	
	public $_total_Monthly_Traffic;	
	public $_visitor_Acquisition_Price;	
	public $_total_Yearly_Traffic_Value;
	public $_searchType;	
	public $_averageCpc;	
	public $_meanAveragePosition;	
	public $_meanClicks;	
	public $_meanTotalCost;	
	public $_globalMonthlySearches;
	public $_url;
	public $_results;
	public $_date;
	public $_level;	
	public $_competingPage;
}

class elementSorter{
	function ComparisonDelegateByGlobalMonthlySearches($a, $b){
		return self::ComparisonDelegate($a, $b, "_globalMonthlySearches");
	}
	function ComparisonDelegateByCompetingPages($a, $b){
		return self::ComparisonDelegate($a,$b, "_competingPage");
	}
	function ComparisonDelegate($a, $b, $field){
		if ($a->$field == $b->$field) {
			return 0;
		}
		return ($a->$field > $b->$field) ? -1 : 1;
	}
}
?>