<?php
include_once 'simple_html_dom.php';
//check to see if user is logged in, if user is logged in use password and username, if not get them
if(!isset($_SESSION))
{
    session_start();
}
//check to see if user is logged in, if user is logged in use password and username, if not get them
if (!isset($_SESSION['login']) && !isset($_SESSION['pw']))
{
    header( 'Location: signin.php' );		
} 
 else
{
 $username = $_SESSION['login'];
 $pw = $_SESSION['pw'];

                    $ch = curl_init();
                    // Disable SSL verification
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        // Set the url
                    curl_setopt($ch, CURLOPT_URL, "https://afrihost.sasscal.org/api/locations?measure=rain");
                        //set password
                    curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$pw);
                        // Will return the response, if false it print the response
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                   
            if(!curl_exec($ch))
				{
                    curl_close($ch);
                   $error = "Password/Username combination incorrect.";
                   header('Location: signin.php?message='.$error);
         
                } 
				else
				{
                 // Execute
                    $result=curl_exec($ch);
                    curl_close($ch);
                    // Closing
                    //curl_close($ch);    
                
                    $dom = new DOMDocument();
                    $dom->loadHTML($result);
                    $li = $dom->getElementsByTagName('li');
                    $href = $dom->getElementsByTagName('a');
				//$html = file_get_html($link.'?measure=rain', false, stream_context_create($arrContextOptions));
				$values = array(); //location names
				$option = array(); //location ids
                                      
				foreach ( $li as $element )
				{
                    //get all names store in name array
				    $values[] .=  $element->nodeValue;  
                
				} 
								//get location id save in array
				foreach ( $href as $linkelement )
				{   
				    $option[] .= substr( strrchr( $linkelement->getAttribute('href'), '/' ), 1 );
                   
                }

                    if(empty($values))
                    {
                    header('Location: createlocation.php');
                    }
                    else
                    {
                        $body='
<center><h5 class="subheader"><b>MINIMUM TEMPERATURE</b></h5></center>
<div class="row" id="loading">
    <center>
    <img src="images/294.GIF"/><br><br>
    <strong>Saving minimum temperature record, please wait..</strong>
    </center>
</div>
<div class="center row" id="formContainer">
   <div class="signup-panel">
      <form id="postTemp" method="post" data-abide>
      <input type="hidden" name="to" id="today"/>
         <!--row 1-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix">
               <i class="icon ion-location"></i>
               </span>
            </div>
            <div class="small-8 columns">
               <select name="location" style="height:40px;" id="locations" onchange="getId()" >
                  ';
                     for($i=0;$i<count($option);$i++)
                           {
                           $body .='<option value="'.$option[$i].'">'.$values[$i].'</option>';
                           }
                           $body .='
               </select>
            </div>
            <div class="small-1">
            </div>
         </div>
         <!--row 1 end-->
         <!--row 2-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix">
               <i class="wi wi-thermometer"></i>
               </span>
            </div>
            <div class="small-8 columns">
               <input type="text" name="temperature" placeholder="Temperature (&deg;C)" id="temperatureV" required/>
               <small class="error">Temperature reading is required. Ensure it is a number.</small>
            </div>
            <div class="small-1 columns">
            </div>
         </div>

          <div id="shown"><!--this div is shown by default-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix">
               <i class="icon ion-ios-calendar-outline"></i>
               </span>
            </div>
            <div class="small-8 columns">
               <input type="text" placeholder="Date" id="fdatepicker3" name="date" onchange="datechange()"/>
            </div>
            <div class="small-1 columns">
            </div>
         </div>
         
         </div>
         <button type="button" id="graphs" class="tiny info  small-offset-8 large-offset-8" onclick=viewgraph()><i class="icon ion-stats-bars" style="color:#000;"></i></button>
         <!--row 2 end-->
         <!--row 3-->

         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix" style="height:inherit;">
               <i class="icon ion-ios-book-outline"></i>
               </span>
            </div>
            <div class="small-8 columns">  
               <textarea type="text" name="note" placeholder="Notes" ></textarea>
            </div>
            <div class="small-1 columns">
            </div>
         </div>
   </div>
   <!--row 5 end-->
   <!--row 6 -->
   <div class="row hide-for-large-up hide-for-medium">
   <center>
   <button type="reset" class="button alert round tiny" >CANCEL</button>
   <button class="button round tiny small-offset-1" type="submit">SAVE</button> </div>
   </center>
   <!--row 6 end-->
   <div class="row hide-for-small">
   <center>
   <button type="reset" class="button alert round large-offset-1 large-3 medium-3 medium-offset-2 large columns">CANCEL</button>
   <button class="button round large large-3 large-offset-4 medium-3 medium-offset-2 columns" type="submit">SAVE</button>
   <div class="large-1 columns"></div>
   </center>
   </div>
   </form>  
</div>
</div>
';
include('index.php');
                    
echo '<script>
            date = new Date((new Date()).valueOf() - 1000*3600*24);
            yesterday = moment().add(-1, "days").format("YYYY-MM-DD");
            today = moment().format("YYYY-MM-DD");
            var LocationIdKeeper = {}

                function datechange()
                    {
                            //get new date value
                            var cdate = document.getElementById("fdatepicker3").value;

                            var ddate = new Date(cdate);
                            ddate.setDate(ddate.getDate()+1);
                            var dd = ddate.getDate();
                            var mm = ddate.getMonth()+1;
                            var y = ddate.getFullYear();

                        var formattedNewDate = y+"-"+mm+"-"+dd;
                        document.getElementById("today").value = formattedNewDate;

                    }

        $(document).ready(function(){
         $("#fdatepicker3").fdatepicker(
            {
            format: "yyyy-mm-dd",
            }
         );
        $("#fdatepicker3").val(yesterday);
        $("#today").val(today);
        
        //set location id to the default selected item in select list
        
            var f = document.getElementById("locations");

      if(f.options.length == 0)
            {
            console.log("undef");
            }
            else
            {
            //location id saved here
            LocationIdKeeper.loc = f.options[f.selectedIndex].value;
        }});

function getId(){
            var f = document.getElementById("locations");
            if(f.options.length == 0)
            {
            console.log("undef");
            }
            else
            {
           //location id saved here
            LocationIdKeeper.loc = f.options[f.selectedIndex].value;
                    }
                }
        

        $("#postTemp").submit(function(event){
            event.preventDefault();
            $.ajax(
            {
                type: "POST",
                url: "controllers/post_temperature.php",
                data: $("form").serialize(),
                 beforeSend: function() { 
                    $("#loading").show();
                    $("#formContainer").hide();
                },
                complete: function() { $("#loading").hide(); 
                    $("#formContainer").show();
                },
                success: function(message){
                    $("#loading").hide();
                    if(message==418)
                    {
                    toastr.error("Temperature record not saved. The date range entered clashes with an existing date range for this location.")
                    }
                    else if(message==400)
                    {
                    toastr.error("Temperature record not saved. End date was not specified.");
                    }
                    else if(message==420)
                    {
                    toastr.error("Temperature record not saved. Please ensure that the measurement start date is not greater than the measurement end date.");
                    }
                    else 
                    {
                    toastr.success(message);
                    }
                }
            }
            );
        });
        
        //get location id from selected location
        
        
        function viewgraph()
                        {
                            var id = LocationIdKeeper.loc;
                            $.ajax({
                                    type: "POST",
                                    url: "state2.php",
                                    data: {data: id},
                                    success: function(data){
                                        
                                        window.location.href = "summary.php"
                                    }
                                    });
          
                        }
    </script>';
                    }
                }
 }
?>