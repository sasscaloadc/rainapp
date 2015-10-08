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
	
$data = Array();
if(!isset($_SESSION)){
    session_start();}
 if (!isset( $_SESSION['login']) && !isset($_SESSION['pw']))
		{
				//header( 'Location: signin.php?page=post_location' );				
		} 
else
		{
				$username          = $_SESSION['login'];
				$pw                = $_SESSION['pw'];

if(isset($_POST['location'])&&isset($_POST['longitude'])&&isset($_POST['latitude'])){
$data["latitude"] = $_POST['latitude'];
$data["longitude"] = $_POST['longitude'];
$data["name"] = $_POST['location'];
//$data["userid"] = 4;
}
$fields = json_encode($data);

$xmlOut = new SimpleXMLElement("<User/>");
arrayToXML($data, $xmlOut); // $display_array populated by implementations of get_array_all or get_array_instance
$fields = $xmlOut->asXML();

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://afrihost.sasscal.org/api/locations");
curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$pw);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/xml", "Content-Length: " . strlen($fields)));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

if ( curl_exec($ch)) {;
    $value = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($value==400){
        //$message = "Location could not be saved. The Latitude/Longitude entered already exists";
    //header('Location: ../createlocation.php?success='.$message);
            echo 400;
        }
         if($value==200)
        {             
    //$message = "Location saved successfully.";
    //header('Location: ../createpost.php?success='.$message);
            echo 200;
         }
} 
    else
    {
    //$error = curl_error($ch);
    echo 22;
    //header('Location: ../createlocation.php?success='.$message);
}
}
?>


