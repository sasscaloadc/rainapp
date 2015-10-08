<?php
date_default_timezone_set('Africa/Johannesburg');

	$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    'http'=>array(
        'header' => "User-Agent:SASSCAL Weather/1.0\r\n"),
    ),
); 
$opts = array();
$context = stream_context_create($opts);
$data = Array();
if(!isset($_SESSION)){
    session_start();}
if(!isset($_SESSION['login'])&& !isset($_SESSION['pw']))
 {
   header('Location: signin.php');	 
 }
else
{
    
    $username = $_SESSION['login'];
    $pw = $_SESSION['pw'];
/***get 'constant' data from form*******/
    if(isset($_POST['location']) && isset($_POST['temperature']) && isset($_POST['note']) && isset($_POST['date']) && isset($_POST['to']))
    {
        $mintemp = $_POST['temperature'];
        $location = $_POST['location'];
        $note = $_POST['note'];
        $date = $_POST['date'];
        $today = $_POST['to'];
    }
    
    else
    {
        header('Location: signin.php');
    }
  
 /******============================================================================================************/
 
$data["locationid"] = $location;
$data["mintemp"] = $mintemp;
$data["fromdate"] = $date;
$data["todate"] = $today;
    /*$data["fromdate"] = '2015-04-30';
$data["todate"] = '2015-05-01 10:59 ';*/
$data["note"] = $note;

$fields = json_encode($data);

    /******============================================================================================************/

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://afrihost.sasscal.org/api/mintemp");
curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$pw);
//curl_setopt($ch, CURLOPT_USERPWD, "erik@sas.co.na:qwe123");

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/json", "Content-Length: " . strlen($fields)));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
if (curl_exec($ch)) {;
    $value = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($value==200)
    {
    echo 'Your temperature measurement of '.$mintemp.'&deg;C has been successfully saved.';
    }
    else{
        echo $value;
    }   
}
 else 
{
echo $value;
}
}
?>
