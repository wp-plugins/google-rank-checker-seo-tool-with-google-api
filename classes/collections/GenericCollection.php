<?

require_once('Collection.php');
require_once('classes/generics/Type.php');

class GenericCollection extends Collection implements IGeneric {
	protected $type;
	
	public function __construct(Type $type, $exceptions = 15, $array = null) {
		parent::__construct($exceptions, $array);
		$this->type = $type;
	}

	public function AllIndexesOf($item) {
		if ($this->isItemFromTheType($item) == false) {
			return array();
		}
		return parent::AllIndexesOf($item);
	}

	public function LastIndexOf($item, $start = null, $length = null) {
		if ($this->isItemFromTheType($item) == false) {
			return -1;
		}
		return parent::LastIndexOf($item, $start, $length);
	}

	public function Add($item) {
		if ($this->isItemFromTheType($item) == true) parent::Add($item);
	}

	public function AddRange($items) {
		if ($items instanceof IGeneric && $items instanceof BaseCollection) {
			$genericsCount = $this->NumberOfTypes();
			if ($genericsCount == $items->NumberOfTypes()) {
				$arr1 = $this->GetTypes();
				$arr2 = $items->GetTypes();
				for ($i=0; $i<$genericsCount; $i++) {
					if ($arr1[$i]->Equals($arr2[$i]) == false) return;
				}

				$this->addMultiple($items);
			}
		} else {
			$res = new Collection();
			if ($items instanceof IteratorAggregate || is_array($items)) {
				foreach ($items AS $value) {
					if ($this->isItemFromTheType($value, false)) $res->Add($value);
				}
			} else {
				$this->ex->ThrowException(new InvalidArgumentException('Items must be either a Collection or an array'), ExceptionsManager::EX_LOW);
			}
			$this->addMultiple($res);
		}
	}

	public function Contains($item) {
		if ($this->isItemFromTheType($item) == false) {
			return false;
		}
		return parent::Contains($item);
	}

	public function IndexOf($item, $start=null, $length=null) {
		if ($this->isItemFromTheType($item) == false) {
			return -1;
		}
		return parent::IndexOf($item, $start, $length);
	}

	public function Insert($index, $item) {
		if ($this->isItemFromTheType($item) == true) parent::Insert($index, $item);
	}

	public function offsetSet($offset, $value) {
		if ($this->isItemFromTheType($value) == true) parent::offsetSet($offset, $value);
	}

	public function Remove($item) {
		if ($this->isItemFromTheType($item) == true) parent::Remove($item);
	}

	public function GetType() {
		return $this->type;
	}
	
	protected function isItemFromTheType($item, $ex = true) {
		$result = $this->type->IsItemFromType($item);
		if ($result == false && $ex == true) $this->ex->ThrowException(new InvalidArgumentException('You can only use items of the type: ' . $this->type), ExceptionsManager::EX_HIGH);
		return $result;
	}

	public function GetTypes() {
		return array($this->type);
	}
	
	public static function NumberOfTypes() {
		return 1;
	}

}
?>