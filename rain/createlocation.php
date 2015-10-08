<?php
include_once 'simple_html_dom.php';
$body = '';
if(!isset($_SESSION))
{
    session_start();
}
if(!isset($SESSION['login']) && !isset($_SESSION['pw']))
{
    header('Location: signin.php');
}
else
{
    $username = $_SESSION['login'];
    $pw = $_SESSION['pw'];
    $arrContextOptions = array(
        "ssl"=>array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            'http'=> array(
            'header'=>"User-Agent: SASSCAL Weather/1.0\r\n"
            )
        )
    );
    @$cont = @file_get_html('https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/locations', false,stream_context_create( $arrContextOptions));
    if($cont===false)
    {
       
        header('Location: signin.php');
    }
    else
    {

$body .='<br>
<center><h5 class="subheader"><b>CREATE LOCATION</b></h5></center>
<div class="row" id="loading">
    <center>
        <img src="images/294.GIF"/><br>
         <strong>Please wait. Your location is being saved....<br></strong>
    </center>
 </div>
 
<div class="center row" id="location">

<div data-alert class="alert-box info">
  For automatic latitude and longitude capture,Please ensure that location services are enabled on your device.
  <a href="#" class="close">&times;</a>
</div>

<div class="signup-panel">
   <form method="post" data-abide>
       
      <div class="row collapse">
         <div class="small-2 small-offset-1 columns">
            <span class="prefix">
            <i class="icon ion-bookmark">
            </i>
            </span>
         </div>
         <div class="small-8 columns">
            <input type="text" placeholder="Name" name="location" id="location" required>
             <small class="error">Location name required.</small>
         </div>
         <div class="small-1 columns">
            </div>
      </div>
       
      <div class="row collapse">
         <div class="small-2 small-offset-1 columns">
            <span class="prefix">
            <i class="icon ion-android-pin">
            </i>
            </span>
         </div>
         <div class="small-8 columns">
            <input type="text" placeholder="Longitude" name="longitude" id="long" required>
            <small class="error">Valid latitude required.</small>
         </div>
         <div class="small-1 columns">
            </div>
       </div>
       
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix">
               <i class="icon ion-android-pin">
               </i>
               </span>
            </div>
            <div class="small-8 columns">
               <input type="text" placeholder="Latitude" name="latitude" id="lat" required>
                 <small class="error">Valid longitude required.</small>
            </div>
            <div class="small-1 columns">
            </div>
         </div>
          <div class="row hide-for-large-up hide-for-medium">
   <a href="createpost.php" class="button alert round tiny small-offset-2" >CANCEL</a>
   <button class="button round tiny small-offset-1" type="submit">SAVE</button>
   </div>
   <div class="row hide-for-small">
   <center>
   <a href="createpost.php" class="button alert round large-offset-1 large-3 medium-3 medium-offset-2 large columns" type="reset">CANCEL</a>
   <button class="button round large large-3 large-offset-4 medium-3 medium-offset-2 columns" type="submit">SAVE</button>
   <div class="large-1 columns">
   </div>
   </center>
   </div>
   </form>

   </div>
</div>';
include('index.php');

echo '
        <script>
       $(document).ready(function(){
           $("#loading").hide();
           function getLocation() {
                if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
                }
                else
                {
                console("Geolocation is not supported by this browser.");
                }
                }
                function showPosition(position) {
                document.getElementById("lat").value =  position.coords.latitude;
                document.getElementById("long").value = position.coords.longitude;
                }
    
                window.onload = getLocation;
       
            $("#location").submit(function(event){
                event.preventDefault();
                $("#location").hide();
                 $("#loading").show();
                $.ajax({
                    type: "POST",
                    data: $("form").serialize(),
                    url: "controllers/post_location.php",
                    success: function(data){
                        if(data==200)
                        {
                         $("#loading").show();
                        toastr.success("Location saved successfully.");
                        window.location.href = "createpost.php";
                        }
                        if(data==400)
                        {
                         $("#location").show();
                        $("#loading").hide();
                        toastr.error("Location could not be saved. The Latitude/Longitude entered already exists");
                        }
                        if(data==22)
                        {
                        $("#loading").show();
                        toastr.error("Location could not be saved. PLease try again later.");
                        }
                    },
                    beforeSend: function(){
                        $("#location").hide();
                        $("#loading").show();
                    }
                });
            }
            )
        }
        );
    
</script>
        ';
    }
}
?>
