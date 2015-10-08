<?php
/***************************************************************************
*view displays list of all locations , with their coodinates and gives user*
*the option to view the location summary, *
*clicking view redirects to locationsummary.php                            *
****************************************************************************/
$body = '<div class="row">
    <center><h5 class="subheader"><b>DELETE/VIEW LOCATION DATA</b></h5></center><br>
    </div>';
include_once 'simple_html_dom.php';
if(!isset($_SESSION)){
    session_start();}
if (!isset($_SESSION['login'])&&!isset(  $_SESSION['pw'])){
    header('Location: signin.php?page=post_location');
}
else
{
    $username = $_SESSION['login'];
    $pw = $_SESSION['pw'];
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    'http'=>array(
        'header' => "User-Agent:SASSCAL Weather/1.0\r\n"),
    ),
); 

$html = file_get_html('https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/locations.json', false, stream_context_create($arrContextOptions));
// Find all list items 
$vals = array();
$links=array();

foreach($html->find('li') as $element) {
    $vals[].= strip_tags($element->innertext);
    }
foreach($html->find('a') as $linkelement) 
{
    $links[]=$linkelement->href;
    
}
if (isset($_GET['success'])) {
    $body .= '
    <div data-alert class="alert-box info small-8 small-offset-1 large-4 large-offset-4 columns">
  '.$_GET['success'].'
  <a href="#" class="close">&times;</a>
</div>'; 
    unset($_GET['success']);
}

    //get list of locations for logged in user
   $locations = json_decode($html);
    $name = array();
    //print_r($locations);
    for($i=0;$i<count(json_decode($html,true));$i++)
    {
    $loc = 'Location_'.$i;
    $link = 'https://'.$username.':'.$pw.'@afrihost.sasscal.org/api/users/'.$locations->$loc->userid.'/locations/'.$locations->$loc->id.'/';
    $body .= '
    
    <div class="row">
    <div class="medium-offset-1 small-4 large-offset-1 columns"><b>';
    $body .= $locations->$loc->name.'<b></div>
   
      <button data-reveal-id="confirm" type="button" class="tiny round alert small-3 columns" id="'.$locations->$loc->id.'"><i class="icon ion-ios-trash-outline"></i></button>
      <button type="button" onclick=viewgraph("'.$link.'") class="tiny round success small-3 small-offset-1 columns"><i class="icon ion-ios-eye"></i></button>
      <hr></div>';
        $body .= '<div id="confirm" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <center><h3 id="modalTitle"><b>Confirmation</b></h3><hr><br>
        <p>Deleted locations cannot be recovered. Are you sure you want to delete this saved location?</p><hr>
        <p>
     <div class="row">
   <a hef="#" id="no" value="t_no" class="button alert round tiny" >NO</a>
   <a href="#" class="button round tiny small-offset-1" type="button" id="yes">YES</a>
   </div>
   <!--row 6 end-->
        </p>
    </div>';
    }
include('index.php');
    echo '<script>
            //delete selected location
              $("button").click(function() {
                        record = this.id;           
                        $("a").click(function() {
                           if(this.id === "yes")
                           {
                             var x = "state.php";
                            var y = record;
                            $.post(
                                    x,{link: y}, function(data)
                                    {window.location.href = "controllers/delete_location.php";}
                                  );
                           }
                           else 
                           {
                           $(\'[data-reveal]\').foundation(\'reveal\', \'close\');
                           }
            });
            });
            function viewgraph(id)
            {
                //alert(id);
                var x = "state2.php";
                            var y = id;
                            $.post(
                                    x,{link: y}, function(data)
                                    {window.location.href = "summary.php";}
                                  );
            }
        </script>';
}
?>