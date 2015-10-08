<?php
$body = '';


$body .= '
 <center><h5 class="subheader"><b>SIGN UP</b></h5></center>
 <div class="row" id="loading">
    <center>
        Please wait. Your registration is being processed....<br>
        <img src="images/294.GIF"/>
    </center>
 </div>
<div class="center row" id="signup">
   <div class="signup-panel">
   
   <div data-alert class="alert-box info radius">
    <center><strong>Thank you for signing up to help SASSCAL gather climate data!
    Please use a valid email address and choose a password with at least 6 characters.</center></strong>
  </div>
 
    <form method="post" data-abide id="signup">
    <div class="row collapse">
    <div class="small-2 small-offset-1 columns">
    <span class="prefix">
    <i class="icon ion-ios-person-outline">
    </i>
    </span>
    </div>
    <div class="small-8 columns">
    <input placeholder="Email" name="user" type="email" required>
    <small class="error">Email is required and it must be valid with @ and .</small>
    </div>
    <div class="small-1 columns">
    </div>
    </div>
    <div class="row collapse">
    <div class="small-2 small-offset-1 columns">
    <span class="prefix">
    <i class="icon ion-ios-locked-outline">
    </i>
    </span>
    </div>
    <div class="small-8 columns">
    <input type="password" placeholder="Password" name="password" id="password" pattern="password">
    <small class="error">Password must be at least 6 characters long</small>
    </div>
     <div class="small-1 columns">
    </div>
    </div>
     <div class="row collapse">
    <div class="small-2 small-offset-1 columns">
    <span class="prefix">
    <i class="icon ion-ios-locked-outline">
    </i>
    </span>
    </div>
    <div class="small-8 columns">
    <input type="password" placeholder="Confirm Password" name="confirm" data-equalto="password" pattern="password">
    <small class="error">Password did not match.Please enter the correct password.</small>
    </div>
     <div class="small-1 columns">
    </div>
    </div>
     <center>
    <button class="button round tiny" type="submit">SIGN UP</button>
    </center>
    </form>
    </div>
</div>
';
include('index.php');
    echo '
    <ol id="signup" class="joyride-list" data-joyride>
     <li data-button="Start Tutorial" data-options="prev_button:false;nub_position: center;">
            <h4><center>WELCOME</center></h4>
        <p>Thank you! We will send you an email shortly to verify your address. Meanwhile please take our 5-minute tutorial to familiarize yourself with how our app works …</p>
    </li>
    <li data-options="prev_button:false;next_button:false;nub_position: center;">
            <h4><center>WHERE IS YOUR RAIN GAUGE?</center></h4>
            <p>The first step is to record the decimal coordinates (latitude and longitude) of where your rain gauge is located. Your mobile device can help to determine your location!</p>
            <p>When you see a message asking for permission to use Location Services, click “YES” or “ALLOW”.</p>
            <p>If you know your coordinates (in decimal form) you can also add them manually. Please be as precise as possible!</p>
        <p>Give your location a name before saving it.<br><br>
        <center><a href="createlocation.php" class="button tiny">Create location</a><center>
        </p>
    </li>
    </ol>
<script>
    $("#signup").submit(function(event){
        event.preventDefault();
        $("#signup").hide();
        $("#loading").show();
            $.ajax({
                    type:   "POST",
                    url:    "controllers/post_user.php",
                    data:   $("form").serialize(),
                    success:    function(message){
                        if(message==1)
                        {
                        toastr.success("Your account has been successfully created.");
                        $(document).foundation({joyride:{
                                                            post_ride_callback: function(){
                                                            console.log("tour finished");
                                                            window.setTimeout(function(){
                                                            location.href = "createlocation.php";
                                                            },1000);
                                                            }
                                                        }
                                                }).foundation(\'joyride\', \'start\');
                        }
                        
                        if(message==400)
                        {
                        toastr.error("Your registration has failed. Username you entered already exists.");
                        $("#loading").hide();
                        $("#signup").show();
                        }
                     }
                });
             });    
    </script>';
?>