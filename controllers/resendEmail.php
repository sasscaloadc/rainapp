<?php
include_once 'emailClass.php';
include_once '../simple_html_dom.php';
if(!isset($_SESSION))
{
    session_start();
}

$email = new Emailer();
$user = strtolower($_POST['user']);
$password = $_POST['password'];

$arrContextOptions = array(
				            "ssl" => array(
								           "verify_peer" => false,
								           "verify_peer_name" => false,
								           'http' => array(
								           'header' => "User-Agent:SASSCAL Weather/1.0\r\n" 
								              ) 
								        ) 
				         );
     
     //$link = 'https://'.$user.':'.$password.'@afrihost.sasscal.org/api/users/';
$link = 'https://erik@sas.co.na:qwe123@afrihost.sasscal.org/api/users';
   $contents = file_get_html($link, false, stream_context_create( $arrContextOptions));
if(strpos($contents, $user)!==false)
{
  /***********************************************
  *if entered email adress is found do the following:
  *-save user id in session
  -save email in session                              
  ***************************************************/
    $doc = new DOMDocument();
    $doc->loadHTML($contents);
    $as = $doc->getElementsByTagName('a');
    foreach ($as as $a) {
    if ($a->nodeValue === $user) {
       $id = substr(strrchr($a->getAttribute('href'), '/'), 1);
      
  
    }
}
}
$hashString = strtolower($user);
$hashString .= $password;

$hashkey = md5($hashString);
//echo $contents;
echo $email->sendEmail($hashkey, $id,$user);
?>