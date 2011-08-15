<?
require_once('Enumerable.php');
require_once('IDictionary.php');
class Dictionary extends Enumerable implements IDictionary {
	public function __construct($exceptions = 15) {
		parent::__construct($exceptions);
	}
	
	public function offsetExists($offset) {
		return $this->ContainsKey($offset);
	}

	public function offsetGet($offset) {
		if ($this->offsetExists($offset) == false) {
			$this->ex->ThrowException(new InvalidArgumentException('The key is not present in the dictionary'), ExceptionsManager::EX_HIGH);
			return null;
		}
		return $this->array[$offset];
	}

	public function offsetSet($offset, $value) {
		$this->Add($offset, $value);
	}

	public function offsetUnset($offset) {
		$this->Remove($offset);
	}

	public function Add($key, $value) {
		if ($key === null) {
			$this->ex->ThrowException(new InvalidArgumentException("Can't use 'null' as key!"), ExceptionsManager::EX_MEDIUM);
		}
		if ($this->ContainsKey($key)) {
			$this->ex->ThrowException(new InvalidArgumentException('That key already exists!'), ExceptionsManager::EX_MEDIUM);
			return;
		}
		$this->array[$key] = $value;
	}

	public function ContainsKey($key) {
		return $this->itemExists($key, $this->Keys());
	}

	public function ContainsValue($value) {
		return $this->itemExists($value, $this->Values());
	}

	public function Remove($key) {
		if ($this->ContainsKey($key) == false) {
			$this->ex->ThrowException(new InvalidArgumentException('The key is not present in the dictionary'), ExceptionsManager::EX_MEDIUM);
			return;
		}
		unset($this->array[$key]);
	}

	public function Keys() {
		return array_keys($this->array);
	}
	
	public function Values() {
		return array_values($this->array);
	}
	
	public function TryGetValue($key, &$value) {
		if ($this->ContainsKey($key)) {
			$value = $this[$key];
			return true;
		} else {
			$value = null;
			return false;
		}
	}
}
?>