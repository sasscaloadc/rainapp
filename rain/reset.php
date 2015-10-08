<?php
/*allows user to reset their password*/
$body = '';
$body .= '
 <center><h5 class="subheader"><b>PASSWORD RESET</b></h5></center>
 <div class="row" id="loading">
    <center>
        Please wait. Your password is being reset....<br>
        <img src="images/294.GIF"/>
    </center>
 </div>
<div class="center row" id="reset">
   <div class="signup-panel">
   
   <div data-alert class="alert-box info radius">
    <center><strong>You are on this page because you forgot your password!
    Please enter your email address to proceed</center></strong>
  </div>
 
    <form id="pwReset" method="post" data-abide id="signup">
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
    
    </div>
     <center>
    <button class="button round tiny" type="submit">SUBMIT</button>
    </center>
    </form>
    </div>
</div>
';
include('index.php');
echo '
        <script>
        $("#pwReset").submit(function(event){
        event.preventDefault();
        
            $.ajax({
                type: "POST",
                url: "controllers/pwreset.php",
                data: $("form").serialize(),
                success: function(message){
                if(message==1)
                {
                toastr.success("Your account has been found, please wait for redirection to enter new password.");
                window.location.href = "newpassword.php";
                }
                else if(message==2)
                {
                toastr.error("Incorrect email entered, please try again with email linked to your account.");
                }
                else
                {
                alert(message);
                
                }
                },
                beforeSend: function(){
                    $("#reset").hide();
                    $("#loading").show();
                },
                complete: function(){
                   $("#reset").show();
                    $("#loading").hide();
                }
            
            });
         });
        </script>
';
?>