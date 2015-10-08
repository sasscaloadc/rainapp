<?php
date_default_timezone_set('Africa/Johannesburg');
$body = '';
  if (isset($_GET['success'])) {
        $body .= '<div class="row">
        <div data-alert class="alert-box info small-8 small-offset-1 large-4 large-offset-4 columns">
'.$_GET['success'].'
  <a href="#" class="close">&times;</a>
</div></div>'; 
}
$body .= '<br>
<center><h5 class="subheader"><b>DELETE RECORDS</b></h5></center>';
/*edit post*/
include_once 'simple_html_dom.php';
//check if user is logged in
/*if(session_status() == PHP_SESSION_NONE){
session_start();
}*/
if(!isset($_SESSION)){
    session_start();}
if(!isset($_SESSION['login'])&& !isset($_SESSION['pw']))
 {
   header( 'Location: signin.php?page=editpost' );	 
 }
else
{
    
     $username = $_SESSION['login'];
    $pw = $_SESSION['pw'];

//get list of locations on page
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

if(!file_get_contents('https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/locations.json', false, stream_context_create($arrContextOptions)))
{
header( 'Location: signin.php?page=editpost' );
}
else
{
$html = file_get_contents('https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/locations.json', false, stream_context_create($arrContextOptions));
    
    $temperature = array();
    $rain = array();
    $result= array();
    $contents = array();
      $resultTemp= array();
    $contentsTemp = array();
    $value = json_decode($html);
 //get all locations in first loop
   $locations = array();
    
    $link = 'https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/locations/';
    //arrays to store urls for rain and temperature

    $rainValue = array();
    $temperatureUrl = array();
    
    //get rain and temperature array for location
   for($i=0;$i<count(json_decode($html,true));$i++)
    {
        $location = 'Location_'.$i;
        //inner loop to extract all rain ids for each location
       $locations[$i] = $value->$location->name;
       $testValue = array_filter($value->$location->rain);
       $testValue2 = array_filter($value->$location->mintemp);
      if(!empty($testValue)){
   
            @$rain[$i] .= $link;
            @$rain[$i] .= $value->$location->id.'/';  
            @$rain[$i] .= 'rain.json';
          
       }
      
          if(!empty($testValue2)){
            @$temperature[$i] = $link;
            @$temperature[$i] .= $value->$location->id.'/'; 
            @$temperature[$i] .= 'mintemp.json';
                 
       }
       //using links generated in for loop above, extract the json data to create links to be used to delete records
    
    }
     for($i=key($temperature);$i<count(json_decode($html,true));$i++)
    {
         if(@$temperature[$i]!=''){
      @$resultTemp[$i] = file_get_contents(@$temperature[$i], false, stream_context_create($arrContextOptions));
          @$contentsTemp[$i] = json_decode($resultTemp[$i]);
            
                        $count = 0;
                foreach ($contentsTemp[$i] as $type) {
                        $count+= count($type);
                    }
             
             for($x=0;$x<$count;$x++)
        { 
               
        $temps = 'Mintemp_'.$x;
          $body .='<div class="row"><div class="medium-offset-1 small-8 large-offset-1 columns">';
            $body .= '<i class="icon ion-android-pin"></i> ';
            $body .= $locations[$i].'<br>';
            $body .= '<i class="icon ion-ios-calendar-outline"></i> ';
            $body .= date('d-M-Y',strtotime($contentsTemp[$i]->$temps->todate)).'<br>';
            $body .= '<i class="wi wi-thermometer all_icons"></i> ';
            $body .= $contentsTemp[$i]->$temps->mintemp.' &deg;C<br></div><button data-reveal-id="temp" type="button" class="tiny round alert small-3 edit" id="'.$contentsTemp[$i]->$temps->id.'"><i class="icon ion-ios-trash-outline all_icons"></i></button></div><hr>';
            $body .= '<div id="temp" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <center><h3 id="modalTitle"><b>Confirmation</b></h3><hr><br>
        <p>Deleted records cannot be recovered. Are you sure you want to delete this record?</p><hr>
        <p>
     <div class="row">
   <a hef="#" id="no" value="t_no" class="button alert round tiny" >NO</a>
   <a href="#" class="button round tiny small-offset-1" value="t_yes" type="button" id="t_yes">YES</a>
   </div>
   <!--row 6 end-->
        </p>
    </div>';
        }
         }
       
    } 
    //for each json link get rain records
 for($i=key($rain);$i<count(json_decode($html,true));$i++)
    { 
     if(@$rain[$i]!=''){
      $result[$i] = file_get_contents(@$rain[$i], false, stream_context_create($arrContextOptions));
      $contents[$i] = json_decode(@$result[$i]);
       // print_r($contents[$i]).'<br>';       
            $count = 0;
foreach ($contents[$i] as $type) {
    $count+= count($type);
}
       
      for($x=0;$x<$count;$x++)
        { 
        $rains = 'Rain_'.$x;
          $body .='<div class="row"><div class="medium-offset-1 small-8 large-offset-1 columns">';
            $body .= '<i class="icon ion-android-pin"></i> ';
            $body .= $locations[$i].'<br>';
            $body .= '<i class="icon ion-ios-calendar-outline"></i> ';
            $body .= date('d-M-Y',strtotime($contents[$i]->$rains->todate)).'<br>';
            $body .= '<i class="wi wi-rain all_icons"></i> ';
            $body .= $contents[$i]->$rains->rain.' mm<br></div><button data-reveal-id="confirm" type="button" class="tiny round alert small-3 edit" id="'.$contents[$i]->$rains->id.'"><i class="icon ion-ios-trash-outline all_icons"></i></button></div><hr>';
            $body .= '
                 
<div id="confirm" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
   <center>
   <h3 id="modalTitle"><b>Confirmation</b></h3>
   <hr>
   <br>
   <p>Deleted records cannot be recovered. Are you sure you want to delete this record?</p>
   <hr>
   <p>
   <div class="row">
      <a href="#" id="no" class="button alert round tiny">NO</a>
      <a href="#" id="yes" class="button round tiny small-offset-1">YES</a>
   </div>
   <!--row 6 end-->
</div>';
        }
          
    } 
 }    
}      
}
   include('index.php');
echo '<script>  
                   
                    $("button").click(function() {
                        record = this.id;           
                        $("a").click(function() {
                           if(this.id === "yes")
                           {
                             var x = "state.php";
                            var y = record;
                            $.post(
                                    x,{link: y}, function(data)
                                    {window.location.href = "controllers/delete_measurement.php";}
                                  );
                           }
                           else if(this.id === "t_yes")
                           {
                           
                             var x = "state.php";
                            var y = record;
                            $.post(
                                    x,{link: y}, function(data)
                                    {window.location.href = "controllers/delete_temperature.php";}
                                  );
                           
                           }
                           else if(this.id==="no")
                           {
                           $(\'[data-reveal]\').foundation(\'reveal\', \'close\');
                           }
                            })    
                   }); 
                  
          
</script>';
?>