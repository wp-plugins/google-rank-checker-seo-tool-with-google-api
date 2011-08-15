<?php
require_once dirname(__FILE__) . '/../Type.php';
define('GPC_NAME_DELIMITER', '__T');

class GenericsCheckProxy {
	protected $target;
	protected $reflection;
	protected static $classReflections = array();
	protected static $methodReflections = array();
	
	public function __construct(IGeneric $target) {
		$this->target = $target;
		$className = get_class($target);
		if (empty(self::$classReflections[$className])) {
			self::$classReflections[$className] = new ReflectionClass($className);
		}
		$this->reflection = self::$classReflections[$className];
	}
	
	public function InvokeMethod($method, array $args) {
		$reflection = $this->reflection;
		$class = $reflection->name;
		if (empty(self::$methodReflections[$class])) {
			self::$methodReflections[$class] = array();
			$this->prepareMethod($method);
		} else if (array_key_exists($method, self::$methodReflections[$class]) == false) {
			$this->prepareMethod($method);
		}
		
		$genArr =& self::$methodReflections[$class][$method]['gen'];
		$methodReflection = self::$methodReflections[$class][$method]['ref'];
		if (empty($genArr) == false) {
			$types = $this->target->GetTypes();
			foreach ($genArr AS $k => $v) {
				if ($types[$v]->IsItemFromType($args[$k]) == false) {
					throw new InvalidArgumentException("Argument at position $k passed to $method is not from the generic type required ({$types[$v]})!");
				}
			}
		}
		return $methodReflection->invokeArgs($this->target, $args);
	}
	
	public function __call($method, array $args) {
		return $this->InvokeMethod($method, $args);
	}
	
	protected function prepareMethod($method) {
		try {
			$methodRef = $this->reflection->getMethod($method);
			$typesNumberRef = $this->reflection->getMethod('NumberOfTypes');
			
			$num = $typesNumberRef->invoke(null);
			
			$arr = array();
			$i = 0;
			
			foreach ($methodRef->getParameters() AS $param) {
				$name = $param->getName();
				$nameArray = explode(GPC_NAME_DELIMITER, $name);
				$end = end($nameArray);
				if (is_numeric($end) && $end<=$num) {
					$arr[$i] = $end-1;
				}
				$i++;
			}
			
			$result = array('ref' => $methodRef, 'gen' => $arr);
			self::$methodReflections[$this->reflection->name][$method] = $result;
		} catch (Exception $ex) {
			throw $ex;
		}
	}
}
?>