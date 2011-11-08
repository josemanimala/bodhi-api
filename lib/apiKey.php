<?PHP
class apiKey
{
	public $keyChain;
	function __construct()
	{
		$this->keyChain=array('stuff here');
	}
	public function getKey()
	{
		return $this->keyChain;
	}
}
?>
