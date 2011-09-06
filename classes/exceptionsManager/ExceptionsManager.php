<?
class ExceptionsManager {
	const EX_FATAL = 0;
	const EX_HIGH = 4;
	const EX_MEDIUM = 8;
	const EX_LOW = 12;
	
	protected $exceptionsLevel;
	protected $allowChange;
	
	public function __construct($exceptionsLevel, $allowChange = true) {
		if ($this->checkLevel($exceptionsLevel) == false) {
			$exceptionsLevel = 15;
		}
		$this->exceptionsLevel = $exceptionsLevel;
		$this->allowChange = (bool)$allowChange;
	}
	
	public function ThrowException(Exception $exception, $level = ExceptionsManager::EX_MEDIUM){
		if ($this->checkLevel($level) == false) $level = ExceptionsManager::EX_MEDIUM;
		if ($this->shouldThrowException($level) == true) throw $exception;
	}
	
	public function GetExceptionsLevel() {
		return $this->exceptionsLevel;
	}
	
	public function CanChangeExceptionsLevel() {
		return $this->allowChange;
	}
	
	public function ChangeExceptionsLevel($exceptionsLevel) {
		if ($this->checkLevel($exceptionsLevel) == false) return false;
		if ($this->allowChange != true) {
			if ($this->exceptionsLevel == $exceptionsLevel) return true;
			$this->ThrowException(new BadMethodCallException('You cannot use the ChangeExceptionsLevel method'), ExceptionsManager::EX_LOW);
			return false;
		} else {
			$this->exceptionsLevel = $exceptionsLevel;
			return true;
		}
	}
	
	public function WillThrowException($level) {
		if ($this->checkLevel($level) == false) return false;
		return $this->shouldThrowException($level);
	}
	
	protected function checkLevel(&$level) {
		$level = (int)$level;
		return ($level >> 4) == 0;
	}
	
	protected function shouldThrowException($level) {
		return $level <= $this->exceptionsLevel;
	}
}
?>