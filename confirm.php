<?php
include_once 'simple_html_dom.php';

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    'http'=>array(
        'header' => "User-Agent:SASSCAL Weather/1.0\r\n"),
    ),
);

$hash = $_GET['token'];
$id = $_GET['id'];
$ch = curl_init();
$url = 'https://erik@sas.co.na:qwe123@afrihost.sasscal.org/api/users/'.$id.'/verify?token='.$hash;

$html = file_get_contents($url,false,stream_context_create($arrContextOptions));

if($html == 'Account verified')
{
    $body = '<br><div class="row">
    <center><h3>Thank you! Your account has been successfully verified.<br>Please <a href="signin.php">login to</a> proceed</h3></center></div>';
}
elseif($html == 'Error with verify query')
{
$body = '<br><div class="row">
    <center><h3>Error with verify query</h3></center></div>';
}
elseif($html == 'Could not verify user')
{
$body = '<br><div class="row">
    <center><h3>Could not verify user</h3></center></div>';
}
elseif($html == 'Error with verify update query')
{
$body = '<br><div class="row">
    <center><h3>Error with verify update query</h3></center></div>';
}
include('index.php');

?>