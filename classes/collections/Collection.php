<?
require_once('BaseCollection.php');
require_once('ICollection.php');
class Collection extends BaseCollection implements ICollection {
	public function __construct($exceptions = 15, $array = null) {
		parent::__construct($exceptions);
		if (is_array($array) || $array instanceof IteratorAggregate) $this->AddRange($array);
	}
	
	public function offsetExists($offset) {
		if (!is_numeric($offset)) {
			$this->ex->ThrowException(new InvalidArgumentException('The offset value must be numeric'), ExceptionsManager::EX_HIGH);
			return false;
		}
		if ($offset<0) {
			$this->ex->ThrowException(new InvalidArgumentException('The option value must be a number > 0'), ExceptionsManager::EX_HIGH);
			return false;
		}
		return array_key_exists((int)$offset, $this->array);
	}

	public function offsetGet($offset) {
		return $this->ElementAt($offset);
	}

	public function offsetSet($offset, $value) {
		if (!is_numeric($offset)) {
			$this->ex->ThrowException(new InvalidArgumentException('The offset value must be numeric'), ExceptionsManager::EX_HIGH);
			return;
		}
		if ($offset<0) {
			$this->ex->ThrowException(new InvalidArgumentException('The option value must be a number > 0'), ExceptionsManager::EX_HIGH);
			return;
		}
		$this->array[(int)$offset] = $value;
	}

	public function offsetUnset($offset) {
		$this->RemoveAt($offset);
	}

	public function Add($item) {
		array_push($this->array, $item);
	}
	
	public function AddRange($items) {
		$this->addMultiple($items);
	}

	public function Contains($item) {
		return $this->itemExists($item, $this->array);
	}

	public function IndexOf($item, $start = null, $length = null) {
		return $this->getIndexOf($item, false, $start, $length);
	}
	
	public function LastIndexOf($item, $start = null, $length = null) {
		return $this->getIndexOf($item, true, $start, $length);
	}

	public function Insert($index, $item) {
		if (!is_numeric($index)) {
			$this->ex->ThrowException(new InvalidArgumentException('The index must be numeric'), ExceptionsManager::EX_HIGH);
			return;
		}
		if ($index < 0 || $index >= $this->Count()) {
			$this->ex->ThrowException(new InvalidArgumentException('The index is out of bounds (must be >=0 and <= size of te array)'), ExceptionsManager::EX_HIGH);
			return;
		}
		
		$current = $this->Count() - 1;
		for (; $current >= $index; $current--) {
			$this->array[$current+1] = $this->array[$current];
		}
		$this->array[$index] = $item;
	}

	public function Remove($item) {
		if ($this->Contains($item)) {
			$this->RemoveAt($this->getFirstIndex($item, $this->array));
		} else {
			$this->ex->ThrowException(new InvalidArgumentException('Item not found in the collection: <pre>' . var_export($item, true) . '</pre>'), ExceptionsManager::EX_MEDIUM);
		}
	}

	public function RemoveAt($index) {
		if (!is_numeric($index)) {
			$this->ex->ThrowException(new InvalidArgumentException('The position must be numeric'), ExceptionsManager::EX_MEDIUM);
			return;
		}
		if ($index < 0 || $index >= $this->Count()) {
			$this->ex->ThrowException(new InvalidArgumentException('The index is out of bounds (must be >=0 and <= size of te array)'), ExceptionsManager::EX_MEDIUM);
			return;
		}
		
		$max = $this->Count()-1;
		for (; $index < $max; $index++) {
			$this->array[$index] = $this->array[$index+1];
		}
		array_pop($this->array);
	}
	
	public function AllIndexesOf($item) {
		return $this->getAllIndexes($item, $this->array);
	}
	
	public function ElementAt($index) {
		if ($this->offsetExists($index) == false) {
			$this->ex->ThrowException(new  OutOfRangeException('No element at position ' . $index), ExceptionsManager::EX_HIGH);
			return null;
		}
		return $this->array[$index];
	}
	
	protected function getIndexOf($item, $lastIndex = false, $start = null, $length = null) {
		if ($start != null && !is_numeric($start)) {
			$this->ex->ThrowException(new InvalidArgumentException('The start value must be numeric or null'), ExceptionsManager::EX_LOW);
			$start = null;
		}
		if ($length != null && !is_numeric($length)) {
			$this->ex->ThrowException(new InvalidArgumentException('The length value must be numeric or null'), ExceptionsManager::EX_LOW);
			$length = null;
		}
		if ($start == null) $start = 0;
		if ($length == null) $length = count($this->array) - $start;
		$array = array_slice($this->array,$start,$length,true);
		
		if ($lastIndex == true) $array = array_reverse($array, true);
		$result = $this->getFirstIndex($item, $array);
		if ($result === false) {
			$this->ex->ThrowException(new InvalidArgumentException('Item not found in the collection: <pre>' . var_export($item, true) . '</pre>'), ExceptionsManager::EX_HIGH);
			return -1;
		}
		return $result;
	}
	
	protected function getAllIndexes($item, $array) {
		if (gettype($item) != 'object') $result = array_keys($array, $item, true);
		else {
			if ($item instanceof IEquatable) {
				$result = array();
				foreach ($array AS $k => $v) {
					if ($item->Equals($v)) {
						$result[] = $k;
					}
				}
			} else {
				$result = array_keys($array, $item, false);
			}
		}
		if (!is_array($result)) $result = array();
		return $result;
	}
	
	protected function getFirstIndex($item, $array) {
		$result = false;
		if (gettype($item) != 'object') $result = array_search($item, $array, true);
		else {
			if ($item instanceof IEquatable) {
				foreach ($array AS $k => $v) {
					if ($item->Equals($v)) {
						$result = $k;
						break;
					}
				}
			} else {
				$result = array_search($item, $array, false);
			}
		}
		return $result;
	}
}
?>