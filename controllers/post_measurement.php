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
   header( 'Location: signin.php?page=post_measurement' );	 
 }
else
{
    
     $username = $_SESSION['login'];
    $pw = $_SESSION['pw'];
/***get 'constant' data from form*******/
    if(isset($_POST['location']) && isset($_POST['rain']) && isset($_POST['note']))
    {
        
        $rain = $_POST['rain'];
        $location = $_POST['location'];
        $note = $_POST['note'];
       
    }
  
    /**get dates if only one date has been selected**/
    if($_POST['from']==null && isset($_POST['date']))
    {
    //echo "No to date<br>";
    //Set from date to , recieved date value plus one second
    //Set to date to 0800hrs of current date/recieved date
        
    $date1 = $_POST['date'];
    $date2  = $_POST['to'];

    //to date calibration
    $to2 = date_create($date2);
     date_time_set($to2,8,00,00);
    $to = date_format($to2,"Y-m-d H:i:s");

        
    //from date calibration
    $from2 = date_create($date1);
    date_time_set($from2,8,00,01);
    $from = date_format($from2,"Y-m-d H:i:s");
        
        //echo 'From date: '. $from .'<br>';
        //echo 'To date: '. $to .'<br>';
    }
    else
    {
        $date1 = $_POST['from'];
        $date2 =$_POST['to'];
        
        //to date calibration
    $to2 = date_create($date2);
    date_time_set($to2,8,00,00);
    date_add($to2, date_interval_create_from_date_string('1 days'));//add one day to date
    $to = date_format($to2,"Y-m-d H:i:s");
        
    //from date calibration
    $from2 = date_create($date1);
    date_time_set($from2,8,00,01);
    $from = date_format($from2,"Y-m-d H:i:s");
        
        
        }
   
 /******============================================================================================************/
 
$data["locationid"] = $location;
$data["rain"] = $rain;
$data["fromdate"] = $from;
$data["todate"] = $to;
$data["note"] = $note;

$fields = json_encode($data);
//echo 'From date: '. $from .'<br>';
//        echo 'To date: '. $to .'<br>';
    /******============================================================================================************/

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://afrihost.sasscal.org/api/rain");
curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$pw);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/json", "Content-Length: " . strlen($fields)));
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

if (curl_exec($ch)) {;
   $value = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if($value==200)
    {
    echo 'Your rain measurement of '.$rain.'mm has been successfully saved.';
    }
    else{
        echo $value;
    }
}
 else 
{
    $message = curl_error($ch);
     echo $message;
	//header('Location: ../createpost.php?success='.$message.'');
}
}

?>

