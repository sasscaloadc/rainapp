<?php
include_once 'simple_html_dom.php';
$body = '';
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
				//get location name save in array
                    
                    
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
                    $body .= '             
<center><h5 class="subheader"><b>RAINFALL</b></h5></center>
<div class="row" id="loading">
    <center>
    <img src="images/294.GIF"/><br><br>
    <strong>Saving rain record, please wait..</strong>
    </center>
</div>
<div class="center row" id="signup">
   <div class="signup-panel">
      <form data-abide id="target">
         <!--row 1-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix">
               <i class="icon ion-location" id="location"></i>
               </span>
            </div>
            <div class="small-8 columns">
               <select id="locations" name="location" style="height:40px;" onchange="getId()">
                  ';
								for ( $i = 0; $i < count($option); $i++ )
										{
											$body .= '<option value="' . @$option[$i] . '">' .@$values[$i]. '</option>';
										} //$i = 0; $i < count( $option ); $i++
								
                    
    $body .= '
               </select>
            </div>
            <div class="small-1 columns">
            </div>
         </div>
         <!--row 1 end-->
         <!--row 2-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix" >
               <i class="icon ion-ios-rainy-outline" id="rain"></i>
               </span>
            </div>
            <div class="small-8 columns">
               <input type="number" id="rainV" name="rain"  placeholder="Rain (millimetres)" required/>
               <small class="error">Rain reading is required. Ensure it is a number.</small>
            </div>
            <div class="small-1 columns">
            </div>
         </div>
         
         <div id="shown"><!--this div is shown by default-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix">
               <i class="icon ion-ios-calendar-outline" id="date"></i>
               </span>
            </div>
            <div class="small-8 columns">
               <input type="text" placeholder="Date" id="fdatepicker3" name="date" onchange="datechange()">
            </div>
            <div class="small-1 columns">
        
            </div>
         </div>
            <button type="button" class="tiny info small-offset-1 large-offset-1" id="shows">More dates</button>
         <button type="button" id="graphs" class="tiny info  small-offset-2 large-offset-6" onclick=viewgraph()><i class="icon ion-stats-bars" style="color:#000;"></i></button>
         </div>
         
         <!--row 2 end-->
         <!--row 3-->
          <div id="hidden" style="display: none;" ><!--this div is hidden by default-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix">
               <i class="icon ion-ios-calendar-outline"></i>
               </span>
            </div>
            <div class="small-6 columns">
               <input type="text" placeholder="Start date" id="fdatepicker2" name="from">
            </div>
           <div class="small-3 columns">
            <span class="prefix-end">
               From
               </span>
            </div>
         </div>
         <!--row 3 end-->
         <!--row 4-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix">
               <i class="icon ion-ios-calendar-outline"></i>
               </span>
            </div>
            <div class="small-6 columns">
               <input type="text" placeholder="End date" id="fdatepicker" name="to">
            </div>
            <div class="small-3 columns">
            <span class="prefix-end">
               To(Incl.)
               </span>
            </div>
         </div>
         <button type="button" class="tiny info  small-offset-1 large-offset-1 " id="hides">Single date</button>
                 <button type="button" class="tiny info small-offset-2 large-offset-6" onclick=viewgraph()><i class="icon ion-stats-bars" style="color:#000;"></i></button>
       
         </div>
         
         <!--row 4 end-->
         <!--row 5-->
         <div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix" style="height:inherit;">
               <i class="icon ion-ios-book-outline" id="notes"></i>
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
   <button class="button alert round tiny" type="reset">CANCEL</button>
   <button class="button round tiny small-offset-1" type="submit" id="save">SAVE</button> </div>
   </center>
   <!--row 6 end-->
   <div class="row hide-for-small">
   <center>
   <button class="button alert round large-offset-1 large-3 medium-3 medium-offset-2 large columns" type="reset">CANCEL</button>
   <button class="button round large large-3 large-offset-4 medium-3 medium-offset-2 columns" type="submit" id="save">SAVE</button>
   <div class="large-1 columns"></div>
   </center>
   </div>
   </form>  
</div>
</div>
';

include( 'index.php' );
                    
echo '

    <ol id="settings" class="joyride-list" data-joyride>
     <li data-button="Record Yesterday’s Rainfall" data-options="prev_button:false;">
            <h4><center>GREAT!</center></h4>
        <p>Now that you have your location defined we can start to add rainfall records. 
        </p>
    </li>
        
        <li data-id="location" data-options="nub_position:top;prev_button:false;">
        <h5><center>LOCATIONS</center></h5>
        <p>
        Select the saved location of your rain gauge from the dropdown list. Remember that you can add multiple locations if you have more than one rain gauge. To add more locations click <a href="createlocation.php">here</a>.
        </p>
        </li>
        
        <li data-id="rain" data-options="nub_position:top;prev_button:false;">
        <h5><center>RAIN MEASUREMENT</center></h5>
        <p>Rain Measurements are recorded in millimetres.
If it did not rain yesterday, just add a zero (0).</p>
        </li>
        
        <li data-id="date" data-options="nub_position:top;prev_button:false;">
        <h5><center>DATE</center></h5>
        <p>By default the app will assume that you are recording yesterday’s rainfall. The generally accepted practice is to record the previous day’s rainfall when you are emptying your rain gauge the following morning, as close as possible to 08:00 in the morning!
        </p>
        </li>
        
        <li data-id="shows" data-options="nub_position:top;prev_button:false;">
        <h5><center>MORE DATES</center></h5>
       <p>If you have not had not emptied your gauge for a few days, then you can use a date range. By default it would start from the last date that you recorded rainfall for the selected location.<br>
       </p>
        </li>
        
        <li data-id="notes" data-button="Ok, Got it!" data-options="nub_position:top;prev_button:false;">
        <h5><center>NOTES</center></h5>
        <p>If there are any details you think might be useful for your rainfall record, you can enter them in this section.
        </p>
        <p>
        Click SAVE to store your rainfall information.
        </p>
        </li>
    </ol>

<script type="text/javascript" src="js/time.js"></script>
';
						}
                }
 }
?>