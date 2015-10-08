<?php
$body = '
 <center><h5 class="subheader"><b>LOG IN</b></h5></center>
 <div class="row" id="loading">
    <center>
     <strong>Please wait your request is being processed...<br></strong>
     <img src="images/294.GIF"/>
   </center>
 </div>
<div class="center row" id="logdiv">
   <div class="signup-panel">
    <form id="login" method="POST" data-abide>
    <div class="row collapse">
    <div class="small-2 small-offset-1 columns">
    <span class="prefix">
    <i class="icon ion-ios-person-outline">
    </i>
    </span>
    </div>
    <div class="small-8 columns">
    <input type="text" placeholder="Email" name="user" required>
     <small class="error">Email required.</small>
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
    <input type="password" placeholder="Password" name="password" required>
    <small class="error">Password required.</small>
    </div>
     <div class="small-1 columns">
    </div>
    </div>
     <center>
    <button class="button round tiny" type="submit">LOG IN</button>
    </center>
    </form>
    <p>
    <center>
    <div data-alert class="alert-box info">
        Not registered yet? <a href="register.php">SIGN UP</a> to add your records.
    </div><br>
     <div data-alert class="alert-box info">
        Forgot your password? <a href="reset.php">RESET IT HERE</a> to access your account.
    </div>
    </center>
    </p>
    </div>
</div>
';
include('index.php');
echo '<script>
        $(document).ready(function(){
            $("#login").submit(function(event){
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    data: $("form").serialize(),
                    url: "controllers/login.php",
                    success: function(data){
        
                        if(data==1)
                        {
                         $("#logdiv").show();
                        $("#loading").hide();
                        toastr.warning("Wrong username and password combination. Please try again with the correct details.");
                        }
                        if(data==2)
                        {
                        $("#loading").show();
                        window.location.href = "createpost.php";
                        }
                        if(data == 3)
                        {
                        $("#logdiv").show();
                        $("#loading").hide();
                        toastr.info("Your account has not been verified yet. Please verify your account from the email that you used to register.", "Log in failed",{ timeOut: 10500 });
                        
                 
                    }},
                    beforeSend: function(){
                        $("#logdiv").hide();
                        $("#loading").show();
                    }
                });
            }
            )
        }
        );
</script>
';
//}
?>