<?

require_once('Dictionary.php');
require_once(GRC_PLUGINPATH. '/classes/generics/Type.php');

class GenericDictionary extends Dictionary implements IGeneric {
	protected $keyType;
	protected $valueType;
	
	public function __construct(Type $keyType, Type $valueType, $exceptions = 15) {
		parent::__construct($exceptions);
		$this->keyType = $keyType;
		$this->valueType = $valueType;
	}
	
	public function Add($key, $value) {
		if ($this->isItemKey($key) && $this->isItemValue($value)) {
			parent::Add($key, $value);
		}
	}

	public function ContainsKey($key) {
		if ($this->isItemKey($key)) {
			return parent::ContainsKey($key);
		}
		return false;
	}

	public function ContainsValue($value) {
		if ($this->isItemValue($value)){
			return parent::ContainsValue($value);
		}
		return false;
	}

	public function offsetGet($offset) {
		if ($this->isItemKey($offset)) {
			return parent::offsetGet($offset);
		}
		return null;
	}

	public function Remove($key) {
		if ($this->isItemKey($key)) {
			parent::Remove($key);
		}
	}

	public function TryGetValue($key, &$value) {
		if ($this->isItemKey($key)) {
			return parent::TryGetValue($key, $value);
		}
		return false;
	}
	
	protected function isItemKey($item, $ex = true) {
		$result = $this->keyType->IsItemFromType($item);
		if ($result == false && $ex == true) $this->ex->ThrowException(new InvalidArgumentException('You can only use items of the type: ' . $this->keyType . ' for keys'), ExceptionsManager::EX_HIGH);
		return $result;
	}
	
	protected function isItemValue($item, $ex = true) {
		$result = $this->valueType->IsItemFromType($item);
		if ($result == false && $ex == true) $this->ex->ThrowException(new InvalidArgumentException('You can only use items of the type: ' . $this->valueType . ' for values'), ExceptionsManager::EX_HIGH);
		return $result;
	}
	
	public function GetKeyType() {
		return $this->keyType;
	}
	
	public function GetValueType() {
		return $this->valueType;
	}

	public function GetTypes() {
		return array($this->keyType, $this->valueType);
	}

	public static function NumberOfTypes() {
		return 2;
	}
}
?>