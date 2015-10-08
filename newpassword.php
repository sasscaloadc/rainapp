<?php
$body = '';
$body .= '
 <center><h5 class="subheader"><b>PASSWORD RESET</b></h5></center>
 <div class="row" id="loading">
    <center>
        Please wait. Your password is being reset....<br>
        <img src="images/294.GIF"/>
    </center>
 </div>
<div class="center row" id="resetContainer">
   <div class="signup-panel">
   
   <div data-alert class="alert-box info radius">
    <center><strong>You are on this page because you forgot your password!
    Please enter and verify your new password to proceed</center></strong>
  </div>
 
    <form id="reset" method="post" data-abide id="signup">
  <div class="row collapse">
    <div class="small-2 small-offset-1 columns">
    <span class="prefix">
    <i class="icon ion-ios-locked-outline">
    </i>
    </span>
    </div>
    <div class="small-8 columns">
    <input type="password" placeholder="New password" name="password" id="password" pattern="password">
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
    <input type="password" placeholder="Confirm New Password" name="confirm" data-equalto="password" pattern="password">
    <small class="error">Password did not match.Please enter the correct password.</small>
    </div>
     <div class="small-1 columns">
    </div>
    </div>
     <center>
    <button class="button round tiny" type="submit">RESET</button>
    </center>
    </form>
    </div>
</div>
';
include('index.php');
echo '
        <script>
        $("#reset").submit(function(event){
        event.preventDefault();
        
            $.ajax({
                type: "POST",
                url: "controllers/put_user.php",
                data: $("form").serialize(),
                success: function(message){
                if(message==1)
                {
                toastr.success("Your password has been reset, you can use the new password to access your account now.");
                window.location.href = "signin.php";
                }
                if(message==2)
                {
                toastr.error("Password could not be reset this time, try again later.");
                }
                },
                beforeSend: function(){
                    $("#resetContainer").hide();
                    $("#loading").show();
                },
                complete: function(){
                   $("#resetContainer").show();
                    $("#loading").hide();
                }
            
            });
         });
        </script>
';
?>