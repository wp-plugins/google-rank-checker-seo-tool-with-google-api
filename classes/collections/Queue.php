<?
require_once('BaseCollection.php');
class Queue extends BaseCollection implements Countable {
	public function __construct($exceptions = 15) {
		parent::__construct($exceptions);
	}
	
	public function Enqueue($item) {
		array_push($this->array,$item);
	}
	
	public function EnqueueMultiple($items) {
		$this->addMultiple($items);
	}
	
	public function Dequeue() {
		if ($this->IsEmpty()) {
			$this->ex->ThrowException(new BadFunctionCallException('Cannot use method Dequeue on an empty Queue'), ExceptionsManager::EX_MEDIUM);
			return null;
		}
		return array_shift($this->array);
	}
	
	public function Peek() {
		if ($this->IsEmpty()) {
			$this->ex->ThrowException(new BadFunctionCallException('Cannot use method Peek on an empty Queue'), ExceptionsManager::EX_MEDIUM);
			return null;
		}
		
		return $this->array[0];
	}
}
?>