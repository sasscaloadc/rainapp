<?php
include_once '../simple_html_dom.php';

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

 $doc = new DOMDocument();
    $doc->loadHTML($html);
    $as = $doc->getElementsByTagName('body');

foreach ($as as $a) {
echo 'Valiue :__'.$a->nodeValue;
}
/*
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERPWD,'erik@sas.co.na:qwe123');
// Set so curl_exec returns the result instead of outputting it.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
// Get the response and close the channel.
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

echo $response;
curl_close($ch);
*/

?>
