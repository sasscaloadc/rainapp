<h2>DELETE - Location</h2>
<?php
	
	function arrayToXML(Array $array, SimpleXMLElement &$xml) {
		foreach($array as $key => $value) {
			// Array
			if (is_array($value)) {
				$xmlChild = (is_numeric($key)) ? $xml->addChild("id_$key") : $xml->addChild($key);
				arrayToXML($value, $xmlChild);
				continue;
			}   
			
			// Object
			if (is_object($value)) {
				$xmlChild = $xml->addChild(get_class($value));
				arrayToXML(get_object_vars($value), $xmlChild);
				continue;
			}
			
			// Simple Data Element
			(is_numeric($key)) ? $xml->addChild("id_$key", $value) : $xml->addChild($key, $value);
		}
	}   
	/*if(session_status() == PHP_SESSION_NONE){
session_start();
}*/
if(!isset($_SESSION)){
    session_start();}
if(!isset($_SESSION['login'])&& !isset($_SESSION['pw']))
 {
   header( 'Location: signin.php?page=editpost' );	 
 }
else
{
    
     $username = $_SESSION['login'];
    $pw = $_SESSION['pw'];

$id = $_SESSION['location'];
$data = Array();
$data["id"] =  $id;


$fields = json_encode($data);

//$xmlOut = new SimpleXMLElement("<User/>");
//arrayToXML($data, $xmlOut); // $display_array populated by implementations of get_array_all or get_array_instance
//$fields = $xmlOut->asXML();

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://afrihost.sasscal.org/api/location");
//curl_setopt($ch, CURLOPT_USERPWD, "erik@sas.co.na:qwe123");
curl_setopt($ch, CURLOPT_USERPWD,  $username.':'.$pw);
//curl_setopt($ch, CURLOPT_USERPWD, "guest:guest");

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/json", "Content-Length: " . strlen($fields)));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/xml", "Content-Length: " . strlen($fields)));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

if ( curl_exec($ch)) {;
    $message = "Location successfully deleted.";
	header('Location: ../locations.php?success='.$message.'');
                     
} else {
	$message = "Location could not be deleted this time.";
    header('Location: ../locations.php?success='.$message.'');
    //echo "cURL error : ".curl_error($ch);

}
}
?>
<br/>
End
<br/>

