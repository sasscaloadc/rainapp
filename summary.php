<?php
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
                    $body .='<br>
<!--location-->
<div class="row">
<center><b><h5 class="subheader" id="title"></h5></b></center></div>
<div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix" >
               <i class="icon ion-location" style="font-size:32px;"></i>
               </span>
            </div>
            <div class="small-8 columns">
               <select id="locations" style="height:40px;" onchange="getId()">
                  ';
								for ($i = 0;$i<count($option);$i++)
										{
											$body.='<option value="'.@$option[$i].'">' .@$values[$i].'</option>';
										} //$i = 0; $i < count( $option ); $i++
								
                    
    $body .= '</select>
            </div>
            <div class="small-1 columns">
            </div>
</div>

<!--range-->
<div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix" >
               <i class="icon ion-ios-calendar-outline" style="font-size:32px;"></i>
               </span>
            </div>
            <div class="small-8 columns">
                <select id="range">
                    <option value="7">Past week</option>
                    <option value="30">Past month</option>
                    <option value="90">Past 3 months</option>
                </select>
            </div>
            <div class="small-1 columns">
            </div>
</div>

<!--graphtype-->
<div class="row collapse">
            <div class="small-2 small-offset-1 columns">
               <span class="prefix" >
               <i class="icon ion-stats-bars" style="font-size:32px;"></i>
               </span>
            </div>
            <div class="small-8 columns">
            <select id="graph">
                <option selected="selected" value="Bar">Bar graph</option>
                <option value="Line">Line graph</option>
            </select>    
            </div>
            <div class="small-1 columns">
            </div>
</div>

<div class="row" id="loading">
    <center>
    <img src="images/294.GIF"/><br>
    <strong>Please wait..</strong>
    </center>
</div>
<div id="graphRefresh">
<input type="hidden" id="locationId" value="'.$_SESSION['measurements'].'"/>
<input type="hidden" id="type" value="'.$_SESSION['type'].'"/>
<canvas  id="rain"  style="margin-left:-20px;width="100%";height="200";"></canvas></div>';

include('index.php');
echo '
    <script type="text/javascript" src="js/graph.js"></script>
';}}}
?>