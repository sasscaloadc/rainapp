<?php
include_once 'simple_html_dom.php';
$timeTest = 0;
$body = '';
if(!isset($_SESSION))
{
    session_start();
}
//check to see if user is logged in, if user is logged in use password and username, if not get them
if (!isset($_SESSION['login']) && !isset($_SESSION['pw']))
{
    header( 'Location: signin.php?page=createpost' );		
} 
 else
{
 $username = $_SESSION['login'];
 $pw = $_SESSION['pw'];
 $arrContextOptions = array(
				            "ssl" => array(
								           "verify_peer" => false,
								           "verify_peer_name" => false,
								           'http' => array(
								           'header' => "User-Agent:SASSCAL Weather/1.0\r\n" 
								              ) 
								        ) 
				         );
     
//if(!file_get_html( 'https://'. $username . ':' . $pw . '@afrihost.sasscal.org/api/locations', false, stream_context_create( $arrContextOptions)))
     $link = 'https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/locations/';
     @$cont = @file_get_html('https://'. $username . ':' . $pw . '@afrihost.sasscal.org/api/locations', false, stream_context_create( $arrContextOptions));
     if($cont===false)
				{
                   $error = "Password/Username combination incorrect.";
                   header('Location: signin.php?message='.$error);
         
                } 
				else
				{
				$html = file_get_html('https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/locations?measure=rain', false, stream_context_create($arrContextOptions));
				$values = array(); //location names
				$option = array(); //location ids
                $times = array();//array of the last added dates for all locations for the user
				//get location name save in array
				foreach ( $html->find( 'li' ) as $element )
				{
				    $values[] .= strip_tags( $element->innertext );
				} //$html->find( 'li' ) as $element
								//get location id save in array
				foreach ( $html->find( 'a' ) as $linkelement )
				{
				    $option[] = substr( strrchr( $linkelement->href, '/' ), 1 );
				} //$html->find( 'a' ) as $linkelement

        $locationLink = 'https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/locations/';
                    
                foreach($option as $data)
                {
                    $times[] = file_get_contents($locationLink.$data.'/latestdate.json', false, stream_context_create($arrContextOptions));
                }
                    //print_r($times);
                    if(!array_filter($times))
                    {
                        $timeTest = 1;
                    }
                    else
                    {
                        $timeTest = 2;
                    }
        
                    if(empty($values))
                    {
                    header('Location: createlocation.php');
                    }
                    else
                    {
                    }
?>