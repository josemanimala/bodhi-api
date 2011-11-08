<?PHP

ini_set('display_errors','On'); 
error_reporting(E_ALL);

#handle file loading
include('/home/jose/public_html/lib/IPBLoad.php');
include('/home/jose/public_html/lib/render.php');
#add apikey here
include('/home/jose/secure/apiKey.php');

#create render object
function renderOutput($stat,$val)
{
	$render = new render();
	print_r($render->renderJson($val,$stat));
	exit();
}

#load the apikey
$apiKey = new apiKey();
$keyChain = $apiKey->getKey();
#check for api key in post
$requestKey='';
if(isset($_POST['apiKey']) && !empty($_POST['apiKey'])){$requestKey = $_POST['apiKey'];}else{$val=array("Error"=>"Api key required for access.");$stat='error'; renderOutput($stat,$val);}
#declare global post variables
$username='';
$password='';
$method='';
#check the validity of the apikey
if(in_array($requestKey,$keyChain))
{
	#Load IPB functions class
	$ipbLoad = new IPBLoad();
	#check for method
	if(isset($_POST['method']) && !empty($_POST['method'])){$method = $_POST['method'];}else{$val=array("Error"=>"Required parameters not set");$stat='error';renderOutput($stat,$val);}
	#authentication function
	if($method=='auth')
	{
		#check for post variables
		if(isset($_POST['username']) && !empty($_POST['username'])){$username = $_POST['username'];}else{$val=array("Error"=>"Required parameters not set");$stat='error';renderOutput($stat,$val);}
		if(isset($_POST['password']) && !empty($_POST['password'])){$password = $_POST['password'];}else{$val=array("Error"=>"Required parameters not set");$stat='error';renderOutput($stat,$val);}
		$val = $ipbLoad->authenticateMember($username,md5($password));
		if($val==true)
		{
			$val=array("authenticated"=>"true");
			$stat='ok';
			renderOutput($stat,$val);
		}
		else
		{
			$val=array("authenticated"=>"false");
			$stat='error';
			renderOutput($stat,$val);
		}
		
	}
	elseif($method=='load')#load function
	{
		#check the post variables
		if(isset($_POST['username']) && !empty($_POST['username'])){$username = $_POST['username'];}else{$val=array("Error"=>"Required parameters not set");$stat='error';renderOutput($stat,$val);}
		if(isset($_POST['password']) && !empty($_POST['password'])){$password = $_POST['password'];}else{$val=array("Error"=>"Required parameters not set");$stat='error';renderOutput($stat,$val);}
		$val = $ipbLoad->loadMember($username,md5($password));
		if($val==0)
		{
			$val=array("authenticated"=>"false");
			$stat='error';
			renderOutput($stat,$val);
		}
		else{
			$stat="ok";
			renderOutput($stat,$val);
		}
	}
	else
	{
		$val=array("Error"=>"method not found.");$stat='error';renderOutput($stat,$val);
	}
}
else
{
	$val=array("Error"=>"Invalid api key. Contact the bodhi web development team.");$stat='error';renderOutput($stat,$val);
}
?>
