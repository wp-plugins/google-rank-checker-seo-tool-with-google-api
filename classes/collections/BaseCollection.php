<?
require_once('Enumerable.php');

abstract class BaseCollection extends Enumerable {
	public function Contains($item) {
		return $this->itemExists($item, $this->array);
	}
	
	protected function addMultiple($items) {
		if (!is_array($items) && !($items instanceof IteratorAggregate)) {
			$this->ex->ThrowException(new InvalidArgumentException('Items must be either a Collection or an array'), ExceptionsManager::EX_LOW);
			return;
		}
		if ($items instanceof Enumerable) {
			$array = array_values($items->GetArray());
		} else if (is_array($items)) {
			$array = array_values($items);
		} else if ($items instanceof IteratorAggregate) {
			foreach ($items AS $v) {
				$array[] = $v;
			}
		}
		if (empty($array) == false) $this->array = array_merge($this->array, $array);
	}
}
?>