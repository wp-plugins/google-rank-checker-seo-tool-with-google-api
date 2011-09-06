<?
require_once('BaseCollection.php');

class Stack extends BaseCollection {
	public function __construct($exceptions = 15) {
		parent::__construct($exceptions);
	}
	
	public function Push($item) {
		array_push($this->array, $item);
	}
	
	public function Pop() {
		if ($this->IsEmpty()) {
			$this->ex->ThrowException(new BadFunctionCallException('Cannot use method Pop on an empty Stack'), ExceptionsManager::EX_MEDIUM);
			return null;
		}
		return array_pop($this->array);
	}
	
	public function Peek() {
		if ($this->IsEmpty()) {
			$this->ex->ThrowException(new BadFunctionCallException('Cannot use method Peek on an empty Stack'), ExceptionsManager::EX_MEDIUM);
			return null;
		}
		
		return end($this->array);
	}
	
	public function PushMultiple($items) {
		$this->addMultiple($items);
	}

	public function getIterator() {
		return new ArrayIterator(array_reverse($this->array));
	}

}
?>