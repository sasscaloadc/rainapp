<?php
include_once 'simple_html_dom.php';
if(!isset($_SESSION))
{
    session_start();
}
//recieve id from ajax call
$id = $_POST['id'];
//curl and get result
//truncate/manipulate date value and return that to ajax
//else return 1 to ajax call

$arrContextOptions = array(
							"ssl" => array(
							"verify_peer" => false,
							"verify_peer_name" => false,
							'http' => array('header' => "User- Agent:SASSCAL Weather/1.0\r\n" ))
                        );

//check to see if there are previously saved dates
if(!file_get_html('https://'.$_SESSION['login'].':'.$_SESSION['pw'].'@afrihost.sasscal.org/api/locations/'.$id.'/latestdate.json',false,stream_context_create($arrContextOptions))){
    //if there are no dates, return yesterdays date as the from date
  //  $return = date('Y-m-d',strtotime("-1 days"));
    echo 1;
    
}
else
{
//if there are dates, take the last saved date and return it to create post as the from date. One second will be added in the post_measurement /post_temperature functions before record is saved

    $html = file_get_contents('https://'.$_SESSION['login'].':'.$_SESSION['pw'].'@afrihost.sasscal.org/api/locations/'.$id.'/latestdate.json', false, stream_context_create($arrContextOptions));
    $return = substr($html, 0, strpos($html, "T"));
 
    //echo date('Y-m-d', strtotime("+1 days", strtotime($return)));//$return;
    echo $return;
}
?>