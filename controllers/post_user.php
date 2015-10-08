<?php
	include_once '../simple_html_dom.php';
	include_once 'emailClass.php';
$data = Array();
$emailer = new Emailer();

if(isset($_POST['user']) && isset($_POST['password'])){
    $password = $_POST['password'];
    $user = strtolower($_POST['user']);
}
//check if email  entered already exists
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

if(strpos($html, $user)!==false)
{
  /***********************************************
  *if entered email adress is found do the following:
  *-do not save 
  -notify user                         
  ***************************************************/
echo 400;
}
else
{
$data["email"] = $user;   
$data["password"] = $password;
$fields = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://afrihost.sasscal.org/api/users");
curl_setopt($ch, CURLOPT_USERPWD, "erik@sas.co.na:qwe123");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/json", "Content-Length: " . strlen($fields)));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
if ( curl_exec($ch)) {;
                      if(!isset($_SESSION)){
    session_start();}
    $_SESSION['login'] = $data["email"];
    $_SESSION['pw'] = $data["password"];
    $arrContextOptions = array(
				            "ssl" => array(
								           "verify_peer" => false,
								           "verify_peer_name" => false,
								           'http' => array(
								           'header' => "User-Agent:SASSCAL Weather/1.0\r\n" 
								              ) 
								        ) 
				         );

     $link = 'https://'.$_SESSION['login'].':'.$_SESSION['pw'].'@afrihost.sasscal.org/api/users/';
   $contents = file_get_html($link, false, stream_context_create( $arrContextOptions));     
    //login get file contents so as to obtain username and id
                      foreach($contents->find("a") as $cont){ 
                          $id = substr( strrchr( $cont->href,'/' ), 1 );
                      }
                      
                      $hashString = strtolower($user);
                      $hashString .= $password;
                      $hashkey = md5($hashString);             
        //message
echo $emailer->sendEmail($hashkey, $id,$user);
                      
} else {
    echo curl_error($ch);
}
}
?>
