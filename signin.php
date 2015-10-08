<?php
if(!isset($_SESSION))
{
    session_start();
}

if(isset($_SESSION['login']) && isset($_SESSION['pw']))
{   
    header('Location: createpost.php');
}
else
{
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
<div id="verify" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <h3 id="modalTitle"><center>Please Verify Your Email Address!</center></h3>
  <div id="lead"></div>
  <br>
  <div id="add">
  </div>
  <br>
If this address is not correct, then simply
<a href="register.php">sign up</a> again using your correct email address.
<br>
<br>
<p>
<center>
<button type="button" class="small round success" onclick="resendEmail()">Resend email</button>

</center>
</p>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
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
                        else if(data==2)
                        {
                        $("#loading").show();
                        window.location.href = "createpost.php";
                        }
                        else
                        {
                        $("#logdiv").show();
                        $("#loading").hide();
                        
                        //Not verified mail@nomistake.co.na 23 Sep 2015
                        //toastr.info(data,{ timeOut: 10500 });
                        var re = /(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/g;
                        var email = "It was sent to: "+(data).match(re);//get email
                
                        var date = data.replace((data).match(re)," ");//remove email from string
                        date = date.replace("Not verified ","We sent you an email on");// remove not verified from string
                        date = date+" containing a link that you need to click on to verify your email address.";
                        date = date.replace( /"/g, "" );
                        
                    
                        document.getElementById("lead").innerHTML = date;
                        document.getElementById("add").innerHTML = email;
                        $(\'#verify\').foundation(\'reveal\', \'open\');
                        $(\'#verify\').foundation(\'reveal\', \'close\');
                        
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
        
        function resendEmail(){
            //alert("Resending email");
            $.ajax({
                type: "POST",
                url: "controllers/resendEmail.php",
                data: $("form").serialize(),
                success: function(data){
                }
            });
        }
</script>
';
}
?>