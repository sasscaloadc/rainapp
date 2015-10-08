<?php
include_once '../simple_html_dom.php';

if(!isset($_SESSION)){
session_start();
}

$email = strtolower($_POST['user']);
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

//check for existance of email
$url = 'https://erik@sas.co.na:qwe123@afrihost.sasscal.org/api/users';
$html = file_get_contents($url,false,stream_context_create($arrContextOptions));

if(strpos($html, $email)!==false)
{
  /***********************************************
  *if entered email adress is found do the following:
  *-save user id in session
  -save email in session                              
  ***************************************************/
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $as = $doc->getElementsByTagName('a');
    foreach ($as as $a) {
    if ($a->nodeValue === $email) {
        $_SESSION['id'] = substr(strrchr($a->getAttribute('href'), '/'), 1);
        $_SESSION['user'] = $email;
        echo 1;
    }
}
}
else
{
    echo 2;
}
?>