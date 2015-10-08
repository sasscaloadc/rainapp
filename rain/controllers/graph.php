<?php
//get id from summary
include_once '../simple_html_dom.php';
if(!isset($_SESSION))
{
    session_start();
}
$locationId = $_SESSION['measurements'];
$type = $_SESSION['type'];
$range = $_POST['range'];

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    'http'=>array(
        'header' => "User-Agent:SASSCAL Weather/1.0\r\n"),
    ),
); 
//$link = 'https://afrihost.sasscal.org/api/locations/'.$locationId.'/graph.json?mtype=rain&period='.$range;

$opts = array();
$context = stream_context_create($opts);

if($type=="mintemp"){
$rainHtml = file_get_html('https://'.$_SESSION['login'].':'.$_SESSION['pw'].'@afrihost.sasscal.org/api/locations/'.$locationId.'/graph.json?type=mintemp&period='.$range,false, stream_context_create($arrContextOptions));
    $_SESSION['type']=null;
    echo $rainHtml;
}
else
{
$rainHtml = file_get_html('https://'.$_SESSION['login'].':'.$_SESSION['pw'].'@afrihost.sasscal.org/api/locations/'.$locationId.'/graph.json?mtype=rain&period='.$range,false, stream_context_create($arrContextOptions));
    echo $rainHtml;
}
//$rainValue = json_encode($rainHtml);


?>