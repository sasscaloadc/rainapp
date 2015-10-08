<?php
if(isset($_POST['user']) && isset($_POST['password']))
{
// Initialize session and set URL.
$ch = curl_init();
$url = 'https://afrihost.sasscal.org/api/locations';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERPWD, strtolower($_POST['user']).':'.$_POST['password']);
// Set so curl_exec returns the result instead of outputting it.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
// Get the response and close the channel.
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

   if($response){
        if($response == 'Not authorized -2'){
            //if log in has failed redirect to login page with message
            //header('Location: ../signin.php?message='$message);
            echo 1;
        }
        elseif(strpos($response,'Not verified') !== false)
        {
            echo json_encode($response);
        }
        else
        {
            //save all details in session and return 2
   if(!isset($_SESSION)){
            session_start();}
            $_SESSION['login'] = strtolower($_POST['user']);
            $_SESSION['pw'] = $_POST['password'];
            echo 2;
    }

}
}
  
?>