<?php
//get id from summary

include_once '../simple_html_dom.php';
if(!isset($_SESSION))
{
    session_start();
}

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    'http'=>array(
        'header' => "User-Agent:SASSCAL Weather/1.0\r\n"),
    ),
); 

if(isset($_POST['id']) && isset($_POST['range']))
{
    $locationId = $_POST['id'];
    $range = $_POST['range'];
    $type = $_SESSION['type'];
    if($type == "rain")
    {
        $rainHtml = file_get_html('https://'.$_SESSION['login'].':'.$_SESSION['pw'].'@afrihost.sasscal.org/api/locations/'.$locationId.'/graph.json?mtype=rain&period='.$range,false, stream_context_create($arrContextOptions));
    echo $rainHtml;
    }
    else
    {
    $rainHtml = file_get_html('https://'.$_SESSION['login'].':'.$_SESSION['pw'].'@afrihost.sasscal.org/api/locations/'.$locationId.'/graph.json?type=mintemp&period='.$range,false, stream_context_create($arrContextOptions));
    $_SESSION['type']=null;
    echo $rainHtml;
    }

}


?>