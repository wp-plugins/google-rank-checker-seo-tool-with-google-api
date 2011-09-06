<?
require_once('Stack.php');
require_once('classes/generics/Type.php');

class GenericStack extends Stack implements IGeneric {
	protected $type;
	
	public function __construct(Type $type, $exceptions = 15) {
		parent::__construct($exceptions);
		$this->type = $type;
	}

	public function Contains($item) {
		if ($this->isItemFromTheType($item) == false) {
			return false;
		}
		return parent::Contains($item);
	}

	public function Push($item) {
		if ($this->isItemFromTheType($item) == true) parent::Push($item);
	}
	
	public function PushMultiple($items) {
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
	
	protected function isItemFromTheType($item, $ex = true) {
		$result = $this->type->IsItemFromType($item);
		if ($result == false && $ex == true) $this->ex->ThrowException(new InvalidArgumentException('You can only use items of the type: ' . $this->type), ExceptionsManager::EX_HIGH);
		return $result;
	}

	public function GetType() {
		return $this->type;
	}
	
	public function GetTypes() {
		return array($this->type);
	}

	public static function NumberOfTypes() {
		return 1;
	}
}
?>