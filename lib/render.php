<?PHP
class render
{
    public function renderJson($messageList,$status) {
        $response = json_encode(array('status'=>$status,'message'=>$messageList));
	return $response;
    }
}
?>