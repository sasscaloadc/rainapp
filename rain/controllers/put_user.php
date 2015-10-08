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
	if(!isset($_SESSION))
    {
    session_start();
    }


$data = Array();
$data["id"] = $_SESSION['id'];
$data["email"] = $_SESSION['user'];
$data["password"] = $_POST['password'];
$data["access"] = "1";
$fields = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://afrihost.sasscal.org/api/users");

curl_setopt($ch, CURLOPT_USERPWD, "erik@sas.co.na:qwe123");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/json", "Content-Length: " . strlen($fields)));

curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
if ( curl_exec($ch)) {;
	echo 1;
} else {
	echo 2;
    curl_error($ch);
}	
?>