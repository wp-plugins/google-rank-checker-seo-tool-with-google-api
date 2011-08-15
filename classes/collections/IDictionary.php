<?
interface IDictionary extends ArrayAccess, Countable, IteratorAggregate {
	public function Add($key, $value);
	public function ContainsKey($key);
	public function ContainsValue($value);
	public function Clear();
	public function Remove($key);
	public function PrintCollection($UseVarDump = false);
	public function GetArray();
	public function Keys();
	public function Values();
	public function TryGetValue($key, &$value);
}
?>