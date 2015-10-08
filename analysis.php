<?php
//shows a summary of measurements for the locations
if(!isset($_SESSION)){
    session_start();}
$location = $_SESSION['location'];
$url = $location . '/measurements.json';
//retrieve json content and decode to display
$result = file_get_contents($url);
//decode json to human readable format
$value = json_decode($result);
$loc = json_decode(file_get_contents($location.'.json'));
// count(json_decode($result,true));
$rainArray = array();
$temperatureArray = array();
for($i=0;$i<count(json_decode($result,true));$i++){
    $ms = 'Measurement_'.$i;
    $rainArray[$i] = $value->$ms->rain;
    $temperatureArray[$i] = $value->$ms->mintemp;
}
//this section calculates the summary of readings for the chosen location
if(count(array_filter($rainArray))==0)
{
    $maxrain = "-- mm";
    $minrain = "-- mm";
    $totalrain = "--mm";
}
else
{
    if(min($rainArray)===null)
    {
    $maxrain = max($rainArray);
    $minrain = max($rainArray);
    $totalrain = array_sum($rainArray);
    }
    else
    {
    $maxrain = max($rainArray);
    $minrain = min($rainArray);
    $totalrain = array_sum($rainArray);   
    }
    
}
if(count(array_filter($temperatureArray))==0)
{
    $mintemp = "--";
    $maxtemp = "--";
}
else
{
    if(min($temperatureArray)===null)
    {
     $mintemp = max($temperatureArray);
     $maxtemp = max($temperatureArray);
    }
    else
    {
    $mintemp = min($temperatureArray);
    $maxtemp = max($temperatureArray);
    }
}
$_SESSION['mintemp'] = $mintemp;
$_SESSION['maxtemp'] = $maxtemp;
$_SESSION['maxrain'] = $maxrain;
$_SESSION['minrain'] = $minrain;
$_SESSION['totalrain'] = $totalrain;
$_SESSION['latitude'] = $loc->latitude;
$_SESSION['longitude'] = $loc->longitude;
$_SESSION['name'] = $loc->name;

$body =  '<div>
    <ul class="pricing-table" style="margin-bottom:0.25em;">
    <li class="title">LOCATION SUMMARY</li>
     </ul>
    <div class="row hide-for-small" data-equalizer>
    <div class="panel callout radius large-5 large-offset-1 columns"  data-equalizer-watch>
   <center><h5>HISTORY</h5></center>
   <ul class="no-bullet">
   <li><h6 style="margin-right:135px;display:inline-block;">NAME</h6> :'.$loc->name.'</li>
   <li><h6 style="margin-right:105px;display:inline-block;">LATITUDE</h6> :'.$loc->latitude.'</li>
   <li><h6 style="margin-right:90px;display:inline-block;">LONGITUDE</h6> :'.$loc->longitude.'</li>
   <li><h6 style="margin-right:70px;display:inline-block;">HIGHEST RAIN</h6> :'.$maxrain.'</li>
   <li><h6 style="margin-right:75px;display:inline-block;">LOWEST RAIN</h6> :'.$minrain.'</li>
   <li><h6 style="margin-right:92px;display:inline-block;">TOTAL RAIN</h6> :'.$totalrain.'</li>
   <li><h6 style="margin-right:-1px;display:inline-block;">HIGHEST MINIMUM TEMPERATURE</h6> :'.$maxtemp.'</li>
   <li><h6 style="margin-right:5px;display:inline-block;">LOWEST MINIMUM TEMPERATURE</h6> :'.$mintemp.'</li>
   </ul>
    </div>
     <div class="panel callout radius large-5 columns"  data-equalizer-watch>
     <center><h5>RECORDS</h5></center>';
if ($maxrain==0 && $minrain ==0 && $totalrain==0){
 $body .= '<p><center><h3>NO RECORDS TO DISPLAY</h3></center></p>
            <p><center><a href="locations.php" class="button round small">RETURN</a></center></p>';
}
else{
    $body.='<ul class="no-bullet">';
        for($i=0;$i<count(json_decode($result,true));$i++){
        $ms= 'Measurement_'.$i;
          
    $body.= '<center><li>
        <b>From: </b>'.
            date('d-M-Y',strtotime($value->$ms->fromdate)).
   '  &nbsp;&nbsp;<b>To:</b> '.
            date('d-M-Y',strtotime($value->$ms->todate)).
    '&nbsp;<button id="http://10.0.0.10/api2/users/'.$value->$ms->userid.'/locations/'.$value->$ms->locationid.'/measurements/'.$value->$ms->id.
    '" class="round small">VIEW</button><br></li></center>';
            }
    $body.='</ul>';
}
   $body .= '</div>
   <div class="large-1"></div>
    </div> 
</div>
<div>
<div class="row hide-for-medium hide-for-large-up" data-equalizer>
<div class="panel callout radius large-5 large-offset-1 columns"  data-equalizer-watch>
<center><h5>RECORDS</h5></center>';
if ($maxrain==0 && $minrain ==0 && $totalrain==0){
 $body .= '<p><center><h3>NO RECORDS TO DISPLAY</h3></center></p>
            <p><center><a href="locations.php" class="button round small">RETURN</a></center></p>';
}
else{  
  $body .=  '<table id="posts" class="responsive small-11 columns">
    <thead>
        <tr>
        <th>FROM</th>
        <th>TO</th>
        <th></th>
        </tr>
    </thead>
    <tbody>';
        for($i=0;$i<count(json_decode($result,true));$i++){
        $ms= 'Measurement_'.$i;
$body .= '<tr>
           <td>'.
            date('d-M-Y',strtotime($value->$ms->fromdate)).
        '</td> 
            <td>'.
            date('d-M-Y',strtotime($value->$ms->todate)).
        '</td>
            <td>
<button onclick="myFunction(this)" id="http://10.0.0.10/api2/users/'.$value->$ms->userid.'/locations/'.$value->$ms->locationid.'/measurements/'.$value->$ms->id.'" class=" round small">VIEW</button>
            </td>
        </tr>
    ';
}
}
 $body .= '</tbody>
    </table>';
 /* 
</div>
</div>
</div>';*/

include('index.html');
echo '<script type="text/javascript">
        $("button").click(function() {
        if(this.id!="nav"){
       console.log("redirecting to class");
        var x="state2.php";
        var y=this.id;
        $.post(x,{link: y},function(data){window.location.href = "details.php";});
    }});
    function myFunction(elem)
{
if(elem.id!="nav"){
       console.log("redirecting to class");
        var x="state2.php";
        var y=elem.id;
        $.post(x,{link: y},function(data){window.location.href = "details.php";});
}}
    </script>';
?>