<?php
/*****This method only works in php.5.4 going up. live server currently on 5.4
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}*/
include_once 'simple_html_dom.php';
if(!ini_get('date.timezone') )
{
    date_default_timezone_set('GMT');
}
if(!isset($_SESSION)){
    session_start();}
//check for existance of pw and username
if(isset($_SESSION['login'])&&isset($_SESSION['pw']))
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

} 
//save request in file
    @$cont = @file_get_html('https://'. $username . ':' . $pw . '@afrihost.sasscal.org/api/locations', false, stream_context_create( $arrContextOptions));
echo '<!DOCTYPE html>
<html class="no-js" lang="en">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width,height=device-height initial-scale=1.0" />
      <title>SASSCAL</title>
      <link rel="stylesheet" href="css/foundation.min.css" />
      <link rel="stylesheet" href="css/ionicons.min.css" />  
    <link rel="stylesheet" href="css/joyride-2.1.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/1.3.2/css/weather-icons.css" rel="stylesheet">
       <link href="css/toaster.min.css" rel="stylesheet">     
       <link href="css/foundation-datepicker.min.css" rel="stylesheet">
     <script async src="js/vendor/modernizr.js"></script>
<style>
    .signup-panel {
  padding: 15px;
}
#loading{
display:none;
}
.all_icons{
    font-size:20px;
}
.edit{
top:10px;
}
.settings_text{
    top:13px;
}
.signup-panel i {
  font-size: 32px;
  line-height: 42px;
  color: #999;
}
.signup-panel form input, .signup-panel form span {
  height: 40px;
}
  .alert-box info{
   style=height:117px;
  }
 .nav-button { 
      float: left; 
      background: #46484d; 
      height:45px;
     width:33%; 
     margin-left:-19px;
     margin-right:15px;
      <!--margin:0; -->
      border-right: 1px solid #5a5a5a; 
      text-align: center;
    }
    .nav-button a { 
      color:#fff; 
      
      text-decoration: none; 
      line-height: 40px; 
      text-shadow: 0 -1px rgba(0,0,0,.9);
    }
     .top-bar ul {
      list-style: none;
      margin-bottom: 0;
         margin-right:-35px;
    }
    a:hover {
      color: #fff;
    }
    .prefix{
    width:98%;
    }
    
    .prefix-end{
    width:66%;
    border-style: solid;
border-width: 1px;
display: block;
font-size: 0.875rem;
height: 2.3125rem;
line-height: 2.3125rem;
overflow: visible;
padding-bottom: 0px;
padding-top: 0px;
position: relative;
text-align: center;
z-index: 2;
    }
    
span.prefix-end, label.prefix-end {
    background: #F2F2F2 none repeat scroll 0% 0%;
    border-left: medium none #CCC;
    color: #333;
    border-color: #CCC;
}
       input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="color"], textarea {
 
  width: 100%;
}

.joyride-tip-guide span.joyride-nub.top {
    border-bottom-color: rgba(0, 0, 0, 0.8);
    border-top-color: transparent !important;
    border-left-color: transparent !important;
    border-right-color: transparent !important;
    border-top-width: 0px;
    top: -14px;
    left:50px;
}
.joyride-tip-guide span.joyride-nub.top_right
{
    border-bottom-color: rgba(0, 0, 0, 0.8);
    border-top-color: transparent !important;
    border-left-color: transparent !important;
    border-right-color: transparent !important;
    border-top-width: 0px;
    top: -14px;
    left:150px;
}
</style>
   </head>
   <body>
     <!--body content starts here-->
      <div class="row">
      <div class="small-12 large-offset-1 large-10 columns">
            <div class="panel">
                <div class="contain-to-grid sticky">
                    <nav class="top-bar" data-topbar>
                    <ul>
                    <li class="nav-button"><a href="createpost.php"><i style="font-size:40px;" class="icon ion-ios-rainy-outline"></i></a></li>  
                     <li class="nav-button"><a href="createtemp.php"><i style="font-size:33px;" class="wi wi-thermometer"></i></a></li>';
                     
//if(!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW']))
     if($cont===false)
{
echo '<li class="nav-button"><a href="signin.php" ><i style="font-size:33px;" class="icon ion-ios-person-outline"></i></a></li>';
}
else
{
echo '<li class="nav-button"><a href="#" id="cog" data-reveal-id="settings"><i style="font-size:33px;" class="icon ion-ios-cog-outline"></i></a></li>';
}
     echo '</ul>
                    </nav>
                </div>
                <div clas="row"><center><img src="images/sasscal_small.png" id="logo"/></center>
                </div>';
if(!isset($body)){
$body = '';
}
echo   $body;

echo '</div>
      </div>
      </div>    
       <div id="settings" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <center><h3 id="modalTitle"><b>ACCOUNT</b></h3><br>
          <ul class="no-bullet">
              <!--<li id="edit">
            <div class="small-8 large-6 large-offset-1 columns settings_text" style="text-align:left;settings_text">
                  Edit account
              </div>
                <div class="small-4 large-5 columns">
                <a href="#" class="button small round"><i class="icon ion-edit all_icons"></i></a>
                </div>
               <hr>
          </li>-->
              
            <li>
                 <div class="small-8 large-6 large-offset-1 columns settings_text" style="text-align:left;">
                Add location
                </div>
                 <div class="small-4 large-5 columns">
                     <a href="createlocation.php" class="button small round"><i class="icon ion-ios-location all_icons"></i></a>
                </div>
                <hr>
          </li>
           <li>
                  <div class="small-8 large-6 large-offset-1 columns settings_text" style="text-align:left;">
                  Manage locations
                 </div>
                 <div class="small-4 large-5 columns">
                     <a href="locations.php" class="button small round"><i class="icon ion-ios-list-outline all_icons"></i></a>
                </div>
        <hr>
                 </li>
             <li>
                  <div class="small-8 large-6 large-offset-1 columns settings_text" style="text-align:left;">
                  Delete posts
                 </div>
                 <div class="small-4 large-5 columns">
                     <a href="editpost.php" class="button small round"><i class="icon ion-ios-trash-outline all_icons"></i></a>
                </div>
        <hr>
                 </li>';
//if((isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])))
   if(isset( $_SESSION['login'] ) && isset( $_SESSION['pw'])) 
{
       echo '<li>
                  <div class="small-8 large-6 large-offset-1 columns settings_text" style="text-align:left;">
                  Log out 
                 </div>
                 <div class="small-4 large-5 columns">
                     <a href="controllers/logout.php" class="button small round"><i class="icon ion-log-out all_icons"></i></a>
                </div>
                <hr>
            </li>';
}

          echo  '</ul>
       <a class="close-reveal-modal" aria-label="Close">&#215;</a>
  
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script> 
<script type="text/javascript" src="js/foundation-datepicker.min.js"></script>
<script type="text/javascript" src="js/foundation/foundation.abide.js"></script>
<script type="text/javascript" src="js/Chart.js"></script> 
<script src="js/jquery.joyride-2.1.js"></script>
<script src="js/toaster.min.js"></script>
<script type="text/javascript" src="js/moment.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

  ga(\'create\', \'UA-68437551-1\', \'auto\');
  ga(\'require\', \'linkid\');
  ga(\'send\', \'pageview\');
</script>
<script>
        $(document).foundation(
        {
  abide : {
    live_validate : false,
    focus_on_invalid : true,
    validate_on_blur : false,
    patterns: {
            password: /^(.){6,}$/
            }
    }
    });  

toastr.options = {
  "closeButton": false,

  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "6000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
 
      </script>       
   </body>
</html>';
    ?>