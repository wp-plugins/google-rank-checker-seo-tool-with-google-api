<?
require_once(GRC_PLUGINPATH. '/classes/collections/config.php');
require_once(GRC_PLUGINPATH. '/classes/exceptionsManager/ExceptionsManager.php');
require_once(GRC_PLUGINPATH. '/classes/generics/IEquatable.php');

abstract class Enumerable implements IteratorAggregate {
	protected $array;
	protected $ex;
	
	public function __construct($exceptions = 15) {
		$this->array = array();
		if ($exceptions instanceof ExceptionsManager) $this->ex = $exceptions;
		else $this->ex = new ExceptionsManager($exceptions, false);
	}
	
	public function Clear() {
		$this->array = array();
	}

	public function Count() {
		return count($this->array);
	}
	
	public function IsEmpty() {
		return $this->Count() < 1;
	}
	
	public function GetArray() {
		return $this->array;
	}
	
	public function getIterator() {
        return new ArrayIterator($this->array);
    }
	
	public function PrintCollection($UseVarDump = false) {
		echo "<pre>";
		if ($UseVarDump) var_dump($this->array);
		else print_r($this->array);
		echo "</pre>";
	}
	
	protected static function itemExists($item, $array) {
		$result = false;
		if (gettype($item) != 'object') $result = in_array($item, $array, true);
		else {
			if ($item instanceof IEquatable) {
				foreach ($array AS $v) {
					if ($item->Equals($v)) {
						$result = true;
						break;
					}
				}
			} else {
				$result = in_array($item, $array, false);
			}
		}
		return $result;
	}
}
?>